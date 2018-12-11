<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Production;

class PendingCreationsCtrl extends AbstractController
{
    // TODO: Add 'isApproved' field in DB
    
    /**
     * @Route("/pendingCreations", name="pending_creations_list")
     */
    public function index()
    {
        $productions = $this->getDoctrine()->getRepository(Production::class)->findBy(array('isApproved' => false), array('title' => 'ASC'));

        return $this->render('pending_creations/index.html.twig', array('productions' => $productions));
    }
}
