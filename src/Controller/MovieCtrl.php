<?php
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Movie;

    class MovieCtrl extends Controller {

        /**
         * @Route("/movies", name="movie_list")
         * @Method({"GET"})
         */
        public function index() {
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

                return $this->redirectToRoute('movie_list');
            }
                
            return $this->render('/movies/edit.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/movies/delete/{id}", name="movie_delete")
         */
        public function delete($id) {
            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($movie);
            $entityManager->flush();

            return $this->redirectToRoute('movie_list');
        }
    }