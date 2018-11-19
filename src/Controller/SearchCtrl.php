<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movie;
use App\Entity\Serie;

class SearchCtrl extends Controller
{
    private $request;
    private $searchInput;
    private $results;

    public function getResultsFromDB() {
        $filter = $this->searchInput;

        // Search for movies
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Movie::class);   
        $query = $repository->createQueryBuilder('c')
            ->where('c.isApproved = true')
            ->andWhere('c.title LIKE \'%'.$filter.'%\'')
            ->orderBy('c.title', 'ASC')
            ->getQuery();
        $movies = $query->getResult();

        // Search for series
        $repository = $em->getRepository(Serie::class);
        $query = $repository->createQueryBuilder('c')
        ->where('c.isApproved = true')
        ->andWhere('c.title LIKE \'%'.$filter.'%\'')
        ->orderBy('c.title', 'ASC')
        ->getQuery();
        $series = $query->getResult();

        // Add type viariable to all movie results
        foreach ($movies as $movie) {
            $movie->type = 'movie';
        }

        // Add type viariable to all serie results
        foreach ($series as $serie) {
            $serie->type = 'serie';
        }

        $this->results = $movies + $series;
        
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
