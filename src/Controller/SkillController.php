<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SkillController extends AbstractController
{
    public function skillUpdateAction(Request $request, $id, SkillRepository $skillRepository){

        // création du formulaire avec les valeurs de la skill ciblée
        $skill = $skillRepository->find($id);
        $skillForm = $this->createForm('App\Form\SkillType',$skill);

        //on dit au formulaire d'écouter les envois de request
        $skillForm->handleRequest($request);
        //si le formulaire est envoyé
        if($skillForm->isSubmitted()){
            //hydrater mon entity (qui contient les infos du skill ciblé) avec les nouvelles infos de mon formulaire
            $skill = $skillForm->getData();
            //je récupère le manager pour pouvoir sauvegarder mon entity dans la base de données
            $manager = $this->getDoctrine()->getManager();
            //je demande a Doctrine de préparer la sauvegarde de mon entity job
            $manager->persist($skill);
            //j'exécute la sauvegarde de mon entity job
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('skill_update.html.twig', ["skillForm"=>$skillForm->createView()]);

    }
}