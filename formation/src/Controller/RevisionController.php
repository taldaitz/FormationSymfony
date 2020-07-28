<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RevisionController extends AbstractController
{
    /**
     * @Route("/revision", name="revision")
     */
    public function index()
    {
        return $this->render('revision/index.html.twig', [
            'controller_name' => 'RevisionController',
        ]);
    }


    /**
     * @Route("/revision/mardi/{prenom}", name="revisionMardi")
     */
    public function mardi($prenom) {
        return $this->render('revision/mardi.html.twig', ['prenom'=> $prenom]);
    }
}
