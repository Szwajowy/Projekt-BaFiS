<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Production;

class SearchCtrl extends Controller
{
    private $request;
    private $searchInput;
    private $results;

    public function getResultsFromDB() {
        $filter = $this->searchInput;

        // Search for productions
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Production::class);   
        $query = $repository->createQueryBuilder('c')
            ->where('c.isApproved = true')
            ->andWhere('c.title LIKE \'%'.$filter.'%\'')
            ->orderBy('c.title', 'ASC')
            ->getQuery();

        $this->results = $query->getResult();
    }

    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request)
    {
        $this->searchInput = $request->request->get('searchInput');
        $this->request = $request;

        if($error = $this->getResultsFromDB()) {
            return $error;
        }

        return $this->render('search/index.html.twig', array('results' => $this->results));
    }
}
