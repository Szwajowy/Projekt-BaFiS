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

    use App\Entity\Post;

    class PostCtrl extends Controller {

        /**
         * @Route("/", name="post_list")
         * @Method({"GET"})
         */

        public function index() {
            $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

            return $this->render('posts/index.html.twig', array('posts' => $posts));
        }

        /**
         * @Route("posts/show/{id}", name="post_show")
         */
        public function show($id) {
            $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

            return $this->render('posts/show.html.twig', array('post' => $post));
        }

        /**
         * @Route("/posts/add", name="post_add")
         * Method({"GET", "POST"})
         */
        public function add(Request $request) {
            $post = new Post();
            
            $form = $this->createFormBuilder($post)
                ->add('title', TextType::class, array(
                    'attr' => array('class' => 'form-control')
                    ))
                ->add('content', TextareaType::class, array(
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
                $post = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('post_list');
            }
                
            return $this->render('/posts/add.html.twig', array('form' => $form->createView()));
        }
    }