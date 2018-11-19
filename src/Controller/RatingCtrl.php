<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Movie;
    use App\Entity\Serie;
    use App\Entity\Rating;

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

            $this->requestData = json_decode($this->request->getContent(), true);
        }

        public function getRatingFromDB() {
            // Get rating from DB for movie or serie 
            if($this->productionType == 'movies') {
                $this->rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('movieID' => intval($this->requestData['movieID']), 'createdBy' => intval($this->requestData['userID'])), array());
            } else if ($this->productionType == 'series') {
                $this->rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('serieID' => intval($this->requestData['serieID']), 'createdBy' => intval($this->requestData['userID'])), array());
            }
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
                $this->rating->setValue(intval($this->requestData['ratingValue']));
                if($this->productionType == 'movies') {
                    $this->rating->setMovieID(intval($this->requestData['movieID']));
                } else if ($this->productionType == 'series') {
                    $this->rating->setSerieID(intval($this->requestData['serieID']));
                }
                $this->rating->setCreatedBy(intval($this->requestData['userID']));
                $this->rating->setCreatedAt(new \DateTime());
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