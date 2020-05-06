<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


use App\Repository\TechnoRepository;
use App\Entity\Techno;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request, TechnoRepository $technoRepository)
    {
        $technos = $technoRepository->findAll();


        //on déclare une nouvelle techno (vide)
        $techno = new Techno();
        //un créé un nouveau formulaire basé sur une entity (dans ce cas : techno)
        $technoForm = $this->createForm('App\Form\TechnoType', $techno);

        //on dit au formulaire d'écouter les envois de request
        $technoForm->handleRequest($request);

        //si le formulaire est envoyé
        if ($technoForm->isSubmitted()) {
            //hydrater mon entity (qui pour le moment est vide) avec les infos de mon formulaire
            $techno = $technoForm->getData();

            //je récupère le manager pour pouvoir sauvegarder mon entity dans la base de données
            $manager = $this->getDoctrine()->getManager();
            
            //je demande a Doctrine de préparer la sauvegarde de mon entity job
            $manager->persist($techno);
            
            //j'exécute la sauvegarde de mon entity job
            $manager->flush();
        }



        return $this->render('home.html.twig', ["technos" => $technos, "technoForm"=>$technoForm->createView()]);
    }
}