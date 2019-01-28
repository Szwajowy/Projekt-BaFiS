<?php
    namespace App\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;

    use Doctrine\Common\Collections\ArrayCollection;

    use App\Entity\Production;
    use App\Entity\Productiontype;
    use App\Entity\Genre;
    use App\Entity\Rating;

    use App\Form\Type\MovieType;

    class MainCtrl extends Controller {

        /**
         * @Route("/", name="main")
         * Method({"GET", "POST"})
         */
        public function index() {
            return $this->render('index.html.twig');
        }

        /**
         * @Route("/movies/show/{id}", name="movie_show")
         */
        public function show($id) {
            $movie = $this->getDoctrine()->getRepository(Production::class)->find($id);

            return $this->render('movies/show.html.twig', array('movie' => $movie));
        } 
    }