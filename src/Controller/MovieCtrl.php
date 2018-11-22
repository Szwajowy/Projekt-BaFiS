<?php
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Movie;
    use App\Entity\Rating;

    use App\Form\Type\MovieType;

    class MovieCtrl extends Controller {

        /**
         * @Route("/movies", name="movie_list")
         * Method({"GET", "POST"})
         */
        public function index(Request $request) {
            $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy(array(), array('title' => 'ASC'));

            return $this->render('movies/index.html.twig', array('movies' => $movies));
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
            
            $form = $this->createForm(MovieType::class, $movie);

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
            
            $form = $this->createForm(MovieType::class, $movie);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $movie = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movie);
                $entityManager->flush();

                return $this->redirectToRoute('movie_list');
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
    }