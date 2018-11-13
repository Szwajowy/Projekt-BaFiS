<?php
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Serie;
    use App\Entity\Rating;

    class SerieCtrl extends Controller {

        /**
         * @Route("/series", name="serie_list")
         * @Method({"GET"})
         */
        public function index(Request $request) {
            $serie = new Serie();
            
            $form = $this->createFormBuilder($serie)
                ->add('title', TextType::class, array(
                    'label' => 'Tytuł',
                    'required' => false,
                    'attr' => array('class' => 'form-control mr-1')
                    ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Wyszukaj',
                    'attr' => array('class' => 'btn btn-primary mr-1')
                ))
                ->getForm();
            
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $filter = $form->get('title')->getData();
            } else $filter = '';

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Serie::class);
            $query = $repository->createQueryBuilder('c')
                ->where('c.isApproved = true')
                ->andWhere('c.title LIKE \'%'.$filter.'%\'')
                ->orderBy('c.title', 'ASC')
                ->getQuery();
            $series = $query->getResult();

            return $this->render('series/index.html.twig', array('series' => $series, 'filter' => $form->createView()));
        }

        /**
         * @Route("/series/show/{id}", name="serie_show")
         */
        public function show($id) {
            $serie = $this->getDoctrine()->getRepository(Serie::class)->find($id);

            return $this->render('series/show.html.twig', array('serie' => $serie));
        }

        /**
         * @Route("/series/add", name="serie_add")
         * Method({"GET", "POST"})
         */
        public function add(Request $request) {
            $serie = new Serie();
            
            $form = $this->createFormBuilder($serie)
                ->add('title', TextType::class, array(
                    'attr' => array('class' => 'form-control')
                    ))
                ->add('genre', TextType::class, array(
                    'attr' => array('class' => 'form-control')
                ))
                ->add('description', TextareaType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Utwórz',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $serie = $form->getData();

                if($this->isGranted('ROLE_ADMIN')) {
                    $serie->setIsApproved(true);
                } else {
                    $serie->setIsApproved(false);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($serie);
                $entityManager->flush();

                return $this->redirectToRoute('serie_list');
            }
                
            return $this->render('/series/add.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/series/edit/{id}", name="serie_edit")
         * Method({"GET", "POST"})
         */
        public function edit(Request $request, $id) {
            $serie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
            
            $form = $this->createFormBuilder($serie)
                ->add('title', TextType::class, array(
                    'attr' => array('class' => 'form-control')
                    ))
                ->add('genre', TextType::class, array(
                    'attr' => array('class' => 'form-control')
                ))
                ->add('description', TextareaType::class, array(
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Edytuj',
                    'attr' => array('class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
                
            return $this->render('/series/edit.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/series/delete/{id}", name="serie_delete")
         */
        public function delete(Request $request, $id) {
            $serie = $this->getDoctrine()->getRepository(Serie::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        /**
         * @Route("/series/accept/{id}", name="serie_accept")
         */
        public function accept(Request $request, $id) {
            $serie = $this->getDoctrine()->getRepository(Serie::class)->find($id);
            $serie->setIsApproved(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        /**
         * @Route("/api/series/getRating", name="serie_get_rating")
         */
        public function getRating(Request $request) {
            if (!$request->getContent()) {
                $response = new JsonResponse(array('message' => "Request content is empty!"));
                return $response;
            }

            if ($request->getContentType() != 'json' || !$request->getContent()) {
                $response = new JsonResponse(array('message' => "Bad content-type!"));
                return $response;
            }

            $data = json_decode($request->getContent(), true);

            $rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('serieID' => intval($data['serieID']), 'createdBy' => intval($data['userID'])), array());
            if($rating != null) {
                $rating = $rating[0];
                $response = new JsonResponse(array('message' => "Successfull!", 'data' => $rating->getValue()));
            } else {
                $response = new JsonResponse(array('message' => "There is no rating on this serie from this user !"));
            }

            return $response;
        }

        /**
         * @Route("/api/series/changeRating", name="serie_change_rating")
         */
        public function changeRating(Request $request) {
            if (!$request->getContent()) {
                $response = new JsonResponse(array('message' => "Request content is empty!"));
                return $response;
            }

            if ($request->getContentType() != 'json' || !$request->getContent()) {
                $response = new JsonResponse(array('message' => "Bad content-type!"));
                return $response;
            }

            $data = json_decode($request->getContent(), true);

            $rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('serieID' => intval($data['serieID']), 'createdBy' => intval($data['userID'])), array());

            if($rating == null){
                $rating = new Rating();
                $rating->setValue(intval($data['ratingValue']));
                $rating->setSerieID(intval($data['serieID']));
                $rating->setCreatedBy(intval($data['userID']));
                $rating->setCreatedAt(new \DateTime());
            } else {
                $rating = $rating[0];
                $rating->setValue(intval($data['ratingValue']));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();

            $response = new JsonResponse(array('message' => "Successfull!"));

            return $response;
        }
    }