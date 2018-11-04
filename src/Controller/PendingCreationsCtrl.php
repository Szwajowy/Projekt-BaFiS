<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movie;
use App\Entity\Serie;

class PendingCreationsCtrl extends AbstractController
{
    /**
     * @Route("/pendingCreations", name="pending_creations_list")
     */
    public function index()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy(array('isApproved' => false), array('title' => 'ASC'));
        $series = $this->getDoctrine()->getRepository(Serie::class)->findBy(array('isApproved' => false), array('title' => 'ASC'));

        return $this->render('pending_creations/index.html.twig', array('movies' => $movies, 'series' => $series));
    }
}
