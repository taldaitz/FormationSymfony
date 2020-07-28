<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", name="catalog")
     */
    public function index()
    {
        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
        ]);
    }


    /**
     * @Route("/catalog/page/{id}", name="pageProduit")
     */
    public function pageProduit($id)
    {
        $products = [
            [
                'nom' => 'Gobelet Rouge',
                'description' => 'C\'est un gobelet rouge pour boire.',
                'prix' => 5,
                'image' => 'images/gobelet.jpg',
            ],
            [
                'nom' => 'Gourde en fer',
                'description' => 'C\'est une gourde en fer pour boire.',
                'prix' => 35,
                'image' => 'images/gourde.jpg',
            ]
        ];

        return $this->render('catalog/pageProduit.html.twig', [
            'nom_product' => $products[$id - 1]['nom'],
            'description_product' => $products[$id - 1]['description'],
            'prix_product' => $products[$id - 1]['prix'],
            'photo_product' => $products[$id - 1]['image'],
        ]);
    }


    /**
     * @Route("/catalog/facilite_paiement", name="facilitePaiement")
     */
    public function facilitePaiement()
    {
        return new Response("Vive les facilités de paiements !!");
    }
}
