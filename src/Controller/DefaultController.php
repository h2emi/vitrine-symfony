<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TechnoRepository;

class DefaultController extends AbstractController
{
    public function indexAction(TechnoRepository $technoRepository)
    {
        $technos = $technoRepository->findAll();
        return $this->render('home.html.twig', ["technos" => $technos]);
    }
}