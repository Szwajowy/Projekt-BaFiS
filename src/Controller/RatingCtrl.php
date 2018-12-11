<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Production;
    use App\Entity\Rating;
    use App\Entity\User;

    class RatingCtrl extends Controller {
        private $request;
        private $requestData;
        private $productionType;
        private $rating = null;

        public function handleRequest() {
            // Check if request is there
            if (!$this->request) {
                $response = new JsonResponse(array('message' => "No request defined!"));
                return $response; // Return JSON response about error
            }

            // Check if request content is there
            if (!$this->request->getContent()) {
                $response = new JsonResponse(array('message' => "Request content is empty!"));
                return $response; // Return JSON response about error
            }

            // Check if request is in JSON
            if ($this->request->getContentType() != 'json' || !$this->request->getContent()) {
                $response = new JsonResponse(array('message' => "Bad content-type!"));
                return $response; // Return JSON response about error
            }

            $this->requestData = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this->request->getContent()), true);
        }

        public function getRatingFromDB() {
            $this->rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('idproduction' => intval($this->requestData['productionID']), 'iduser' => intval($this->requestData['userID'])), array());
        }

        /**
         * @Route("/api/{type}/getRating", name="get_rating")
         */
        public function getRating(Request $request, $type) {
            $this->productionType = $type;
            $this->request = $request;

            if($error = $this->handleRequest()) {
                return $error;
            }

            if($error = $this->getRatingFromDB()) {
                return $error;
            }

            if($this->rating != null && $this->rating != '') {
                $this->rating = $this->rating[0];
                $response = new JsonResponse(array('message' => "Successfull!", 'data' => $this->rating->getValue()));
            } else {
                $response = new JsonResponse(array('message' => "There is no rating on this movie from this user !"));
            }

            return $response;
        }

        /**
         * @Route("/api/{type}/changeRating", name="set_rating")
         */
        public function setRating(Request $request, $type) {
            $this->productionType = $type;
            $this->request = $request;

            if($error = $this->handleRequest()) {
                return $error;
            }

            if($error = $this->getRatingFromDB()) {
                return $error;
            }

            if($this->rating == null){
                $this->rating = new Rating();
                $production = $this->getDoctrine()->getRepository(Production::class)->find(intval($this->requestData['productionID']));
                $user = $this->getDoctrine()->getRepository(User::class)->find(intval($this->requestData['userID']));

                $this->rating->setValue(intval($this->requestData['ratingValue']));
                $this->rating->setIdproduction($production);
                $this->rating->setIduser($user);
                $this->rating->setCreated(new \DateTime());
            } else {
                $this->rating = $this->rating[0];
                $this->rating->setValue(intval($this->requestData['ratingValue']));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($this->rating);
            $entityManager->flush();

            $response = new JsonResponse(array('message' => "Successfull!"));
            return $response;
        }
    }