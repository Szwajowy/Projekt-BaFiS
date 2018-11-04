<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileCtrl extends AbstractController
{
    /**
     * @Route("/profile", name="profile_index")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig');
    }
}
