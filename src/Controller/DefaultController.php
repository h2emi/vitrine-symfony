<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('./pages/public/home.html.twig', [
        ]);
    }

    public function aboutAction(){
        return $this->render('./pages/public/about.html.twig');
    }
}