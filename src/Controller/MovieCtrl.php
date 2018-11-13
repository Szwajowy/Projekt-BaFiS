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

    use App\Entity\Movie;
    use App\Entity\Rating;

    class MovieCtrl extends Controller {

        /**
         * @Route("/movies", name="movie_list")
         * Method({"GET", "POST"})
         */
        public function index(Request $request) {
            $movie = new Movie();
            
            $form = $this->createFormBuilder($movie)
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
            $repository = $em->getRepository(Movie::class);
            $query = $repository->createQueryBuilder('c')
                ->where('c.isApproved = true')
                ->andWhere('c.title LIKE \'%'.$filter.'%\'')
                ->orderBy('c.title', 'ASC')
                ->getQuery();
            $movies = $query->getResult();

            return $this->render('movies/index.html.twig', array('movies' => $movies, 'filter' => $form->createView()));
        }

        /**
         * @Route("/movies/show/{id}", name="movie_show")
         */
        public function show($id) {
            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

            return $this->render('movies/show.html.twig', array('movie' => $movie));
        } 

        /**
         * @Route("/movies/add", name="movie_add")
         * Method({"GET", "POST"})
         */
        public function add(Request $request) {
            $movie = new Movie();
            
            $form = $this->createFormBuilder($movie)
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
                $movie = $form->getData();

                if($this->isGranted('ROLE_ADMIN')) {
                    $movie->setIsApproved(true);
                } else {
                    $movie->setIsApproved(false);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movie);
                $entityManager->flush();

                return $this->redirectToRoute('movie_list');
            }
                
            return $this->render('/movies/add.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/movies/edit/{id}", name="movie_edit")
         * Method({"GET", "POST"})
         */
        public function edit(Request $request, $id) {
            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
            
            $form = $this->createFormBuilder($movie)
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
                $movie = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movie);
                $entityManager->flush();

                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
                
            return $this->render('/movies/edit.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/movies/delete/{id}", name="movie_delete")
         */
        public function delete(Request $request, $id) {
            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($movie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        /**
         * @Route("/movies/accept/{id}", name="movie_accept")
         */
        public function accept(Request $request, $id) {
            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
            $movie->setIsApproved(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        /**
         * @Route("/api/movies/getRating", name="movie_get_rating")
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

            $rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('movieID' => intval($data['movieID']), 'createdBy' => intval($data['userID'])), array());
            if($rating != null) {
                $rating = $rating[0];
                $response = new JsonResponse(array('message' => "Successfull!", 'data' => $rating->getValue()));
            } else {
                $response = new JsonResponse(array('message' => "There is no rating on this movie from this user !"));
            }

            return $response;
        }

        /**
         * @Route("/api/movies/changeRating", name="movie_change_rating")
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

            $rating = $this->getDoctrine()->getRepository(Rating::class)->findBy(array('movieID' => intval($data['movieID']), 'createdBy' => intval($data['userID'])), array());

            if($rating == null){
                $rating = new Rating();
                $rating->setValue(intval($data['ratingValue']));
                $rating->setMovieID(intval($data['movieID']));
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