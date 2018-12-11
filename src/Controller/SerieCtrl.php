<?php
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use App\Entity\Production;
    use App\Entity\Productiontype;
    use App\Entity\Genre;
    use App\Entity\Rating;

    use App\Form\Type\SerieType;

    class SerieCtrl extends Controller {

        /**
         * @Route("/series", name="serie_list")
         * @Method({"GET"})
         */
        public function index(Request $request) {
            $series = $this->getDoctrine()->getRepository(Production::class)->findBy(array('type' => 1, 'isApproved' => 1), array('title' => 'ASC'));

            return $this->render('series/index.html.twig', array('series' => $series));
        }

        /**
         * @Route("/series/show/{id}", name="serie_show")
         */
        public function show($id) {
            $serie = $this->getDoctrine()->getRepository(Production::class)->find($id);

            return $this->render('series/show.html.twig', array('serie' => $serie));
        }

        /**
         * @Route("/series/add", name="serie_add")
         * Method({"GET", "POST"})
         */
        public function add(Request $request) {
            $serie = new Production();
            
            $form = $this->createForm(SerieType::class, $serie);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $serie = $form->getData();

                // Set type of production to '1' - serie
                $productionType = $this->getDoctrine()->getRepository(Productiontype::class)->find(1);
                $serie->setType($productionType);

                if($this->isGranted('ROLE_ADMIN')) {
                    $serie->setIsApproved(true);
                } else {
                    $serie->setIsApproved(false);
                }

                $entityManager = $this->getDoctrine()->getManager();

                foreach($serie->getIdgenre() as $genre) {
                    $existingGenre = $this->getDoctrine()->getRepository(Genre::class)->findBy(['name' => $genre->getName()]);
                    if($existingGenre != null) {
                        $serie->removeidgenre($genre);
                        $serie->addidgenre($existingGenre[0]);
                    }
                }

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
            $serie = $this->getDoctrine()->getRepository(Production::class)->find($id);
            
            $form = $this->createForm(SerieType::class, $serie);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                foreach($serie->getIdgenre() as $genre) {
                    $existingGenre = $this->getDoctrine()->getRepository(Genre::class)->findBy(['name' => $genre->getName()]);
                    if($existingGenre != null) {
                        $serie->removeidgenre($genre);
                        $serie->addidgenre($existingGenre[0]);
                    }
                }

                $entityManager->persist($serie);
                $entityManager->flush();

                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
                
            return $this->render('/series/edit.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/series/delete/{id}", name="serie_delete")
         */
        public function delete(Request $request, $id) {
            $serie = $this->getDoctrine()->getRepository(Production::class)->find($id);

            $ratings = $this->getDoctrine()->getRepository(Rating::class)->findBy(['idproduction'=> $serie->getIdproduction()]);

            $entityManager = $this->getDoctrine()->getManager();

            foreach($ratings as $rating) {
                $entityManager->remove($rating); 
            }

            $entityManager->remove($serie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        /**
         * @Route("/series/accept/{id}", name="serie_accept")
         */
        public function accept(Request $request, $id) {
            $serie = $this->getDoctrine()->getRepository(Production::class)->find($id);
            $serie->setIsApproved(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }
    }