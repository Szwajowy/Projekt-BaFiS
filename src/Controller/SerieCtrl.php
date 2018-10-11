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

    use App\Entity\Serie;

    class SerieCtrl extends Controller {

        /**
         * @Route("/series", name="serie_list")
         * @Method({"GET"})
         */
        public function index() {
            $series = $this->getDoctrine()->getRepository(Serie::class)->findAll();

            return $this->render('series/index.html.twig', array('series' => $series));
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

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($serie);
                $entityManager->flush();

                return $this->redirectToRoute('serie_list');
            }
                
            return $this->render('/series/add.html.twig', array('form' => $form->createView()));
        }
    }