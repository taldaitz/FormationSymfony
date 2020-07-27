<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /** 
     * Cette vue est la page d'accueil
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    
    /**
     * @Route("/hello/{chiffre}", name="salutation", requirements={"chiffre"="\d+"})
     */
    public function hello($chiffre) {
        return new Response('Chiffre : ' . $chiffre);
    }


    /**
     * @Route("/hello/{prenom}", name="salutationPrenom")
     */
    public function helloPrenom($prenom = "Tout le monde") {
        return new Response('Bonjour ' . $prenom);
    }

    
}
