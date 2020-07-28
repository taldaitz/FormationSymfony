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

    public function notFound()
    {
        return new Response("Désolé, cette page n'existe pas !");
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

    /**
     * @Route("/addition/{chiffre1}/{chiffre2}", name="addition",
     * requirements={"chiffre1"="\d+", "chiffre2"="\d+"})
     */
    public function addition($chiffre1, $chiffre2) {
        $resultat = $chiffre1 + $chiffre2;
        return new Response("Le résultat est $resultat");
    }


    /**
     * @Route("/contact/nom/{nom}/prenom/{prenom}", name="contact")
     */
    public function contact($nom, $prenom) {
        return new Response("Nom : $nom <br>
                            Prenom: $prenom");
    }


    /**
     * @Route("/addition/{chiffre1}+{chiffre2}", name="additionPlus")
     */
    public function additionPlus($chiffre1, $chiffre2) 
    {
        //return $this->redirect("/addition/$chiffre1/$chiffre2");

        return $this->redirectToRoute('addition', ['chiffre1' => $chiffre1, 
                                        'chiffre2' => $chiffre2]);
    }
    
}
