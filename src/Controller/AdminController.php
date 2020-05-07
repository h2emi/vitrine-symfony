<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\TechnoRepository;
use App\Entity\Techno;

use App\Repository\SkillRepository;
use App\Entity\Skill;

use App\Repository\CategoryRepository;
use App\Entity\Category;

use App\Repository\ProjectRepository;
use App\Entity\Project;

class AdminController extends AbstractController
{
    public function adminAction(Request $request, TechnoRepository $technoRepository, SkillRepository $skillRepository) {
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


        $skills = $skillRepository->findAll();
        $skill = new Skill();
        $skillForm = $this->createForm('App\Form\SkillType', $skill);
        $skillForm->handleRequest($request);
        
        if ($skillForm->isSubmitted()) {
            $skill = $skillForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($skill);
            $manager->flush();
        }


        $category = new Category();
        $categoryForm = $this->createForm('App\Form\CategoryType', $category);
        $categoryForm->handleRequest($request);
        
        if ($categoryForm->isSubmitted()) {
            $category = $categoryForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
        }

        $project = new Project();
        $projectForm = $this->createForm('App\Form\ProjectType', $project);
        $projectForm->handleRequest($request);
        
        if ($projectForm->isSubmitted()) {
            $project = $projectForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($project);
            $manager->flush();
        }

        
        return $this->render('./pages/admin/dashboard.html.twig', [
            "technos" => $technos, 
            "skills" => $skills, 
            "technoForm"=>$technoForm->createView(), 
            "skillForm"=>$skillForm->createView(),
            "categoryForm"=>$categoryForm->createView(), 
            "projectForm"=>$projectForm->createView()
        ]);

    }
}





   
        
    