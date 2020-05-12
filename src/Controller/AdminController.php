<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Techno;
use App\Form\SkillType;
use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use App\Repository\TechnoRepository;
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

    public function projectAddAction(Request $request)
    {
        $project = new Project();
        $projectForm = $this->createForm('App\Form\ProjectType', $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted()) {
            $project = $projectForm->getData();
            $file = $projectForm-> get('image')->getData();
            if($file){
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move(

                    $this->getParameter('uploads'), // routes->services.yaml
                    $newFilename
                );
                $project->setImage($newFilename);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $manager->flush();
                return $this->redirectToRoute('projects');
            }
        }

        return $this->render('pages/admin/projects/project_add.html.twig', [
            "projectForm"=>$projectForm->createView(),
        ]);
    }

    public function projectDeleteAction(Request $request, $id , ProjectRepository $projectRepository) {
        $project = $projectRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($project);
        $manager->flush();
        return $this->redirectToRoute('projects');
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
            $file = $skillForm-> get('image')->getData();
            if($file){
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move(

                    $this->getParameter('uploads'), // routes->services.yaml
                    $newFilename
                );
                $skill->setImage($newFilename);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($skill);
                $manager->flush();
                return $this->redirectToRoute('skills');

            }



        }

        return $this->render('pages/admin/skills/skill_add.html.twig', [
            "skillForm"=>$skillForm->createView(),
        ]);
    }

    public function skillDeleteAction(Request $request, $id , SkillRepository $skillRepository) {
        $skill = $skillRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($skill);
        $manager->flush();
        return $this->redirectToRoute('skills');
    }

    public function skillUpdateAction(Request $request, $id, SkillRepository $skillRepository)
    {

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



    public function technoAction(technoRepository $technoRepository){

            $technos = $technoRepository->findAll();

            return $this->render('pages/admin/technos/technos.html.twig', [
                "technos" => $technos,
            ]);
        }

    public function technoAddAction(Request $request)
    {
        $techno = new Techno();
        $technoForm = $this->createForm('App\Form\TechnoType', $techno);
        $technoForm->handleRequest($request);

        if ($technoForm->isSubmitted()) {
            $techno = $technoForm->getData();
            $file = $technoForm-> get('image')->getData();
            if($file){
                $newFilename = uniqid().'.'.$file->guessExtension();
                $file->move(

                    $this->getParameter('uploads'), // routes->services.yaml
                    $newFilename
                );
                $techno->setImage($newFilename);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($techno);
                $manager->flush();
                return $this->redirectToRoute('technos');

            }



        }

        return $this->render('pages/admin/technos/techno_add.html.twig', [
            "technoForm"=>$technoForm->createView(),
        ]);
    }

    public function technoUpdateAction(Request $request, $id, TechnoRepository $technoRepository)
    {
        $techno = $technoRepository->find($id);
        $technoForm = $this->createForm('App\Form\TechnoType',$techno);

        $technoForm->handleRequest($request);
        if($technoForm->isSubmitted()){
            $techno = $technoForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($techno);
            $manager->flush();
            return $this->redirectToRoute('technos');
        }

        return $this->render('pages/admin/technos/techno_update.html.twig', [
            "technoForm"=>$technoForm->createView()
        ]);
    }

    public function technoDeleteAction(Request $request, $id , TechnoRepository $technoRepository) {
        $techno = $technoRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($techno);
        $manager->flush();
        return $this->redirectToRoute('technos');
    }



    public function categoryAction(categoryRepository $categoryRepository){

        $categories = $categoryRepository->findAll();

        return $this->render('pages/admin/categories/categories.html.twig', [
            "categories" => $categories,
        ]);
    }

    public function categoryAddAction(Request $request)
    {
        $category = new Category();
        $categoryForm = $this->createForm('App\Form\CategoryType', $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted()) {
            $category = $categoryForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('categories');
        }

        return $this->render('pages/admin/categories/category_add.html.twig', [
            "categoryForm"=>$categoryForm->createView(),
        ]);
    }

    public function categoryUpdateAction(Request $request, $id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        $categoryForm = $this->createForm('App\Form\CategoryType',$category);

        $categoryForm->handleRequest($request);
        if($categoryForm->isSubmitted()){
            $category = $categoryForm->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('categories');
        }

        return $this->render('pages/admin/categories/category_update.html.twig', [
            "categoryForm"=>$categoryForm->createView()
        ]);
    }

    public function categoryDeleteAction(Request $request, $id , CategoryRepository $categoryRepository) {
        $category = $categoryRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute('categories');
    }




}





