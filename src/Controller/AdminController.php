<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\SkillRepository;
use App\Entity\Skill;

class AdminController extends AbstractController
{
    public function adminAction(){
        return $this->render('pages/admin/dashboard.html.twig');
    }

    public function skillAction(SkillRepository $skillRepository){

        $skills = $skillRepository->findAll();

        return $this->render('pages/admin/skills/skills.html.twig', [
            "skills" => $skills,
        ]);
    }



    public function skillUpdateAction()
    {
        return $this->render('pages/admin/skill_update.html.twig');
    }
}
