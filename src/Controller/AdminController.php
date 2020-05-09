<?php

namespace App\Controller;

use App\Form\SkillType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\SkillRepository;
use App\Entity\Skill;

class AdminController extends AbstractController
{
    public function adminAction(){
        return $this->render('pages/admin/dashboard.html.twig');
    }

    public function projectAction(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->findAll();
        return $this->render('pages/admin/projects/projects.html.twig' , [
            "projects"=>$projects,
        ]);

    }

    public function projectUpdateAction(Request $request, $id, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->find($id);
        $projectForm = $this->createForm('App\Form\ProjectType', $project);


        $projectForm->handleRequest($request);
        if ($projectForm->isSubmitted()) {
            $project = $projectForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('projects');
        }

        return $this->render('pages/admin/projects/project_update.html.twig', [
            "projectForm" => $projectForm->createView()
        ]);

    }



    public function skillAction(SkillRepository $skillRepository){

        $skills = $skillRepository->findAll();

        return $this->render('pages/admin/skills/skills.html.twig', [
            "skills" => $skills,
        ]);
    }

    public function skillAddAction(Request $request)
    {
        $skill = new Skill();
        $skillForm = $this->createForm('App\Form\SkillType', $skill);
        $skillForm->handleRequest($request);

        if ($skillForm->isSubmitted()) {
            $skill = $skillForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($skill);
            $manager->flush();
            return $this->redirectToRoute('skills');
        }

        return $this->render('pages/admin/skills/skill_add.html.twig', [
            "skillForm"=>$skillForm->createView(),
        ]);
    }


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
            return $this->redirectToRoute('skills');
        }

        return $this->render('pages/admin/skills/skill_update.html.twig', [
            "skillForm"=>$skillForm->createView()
        ]);

    }

}





