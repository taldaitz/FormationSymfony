<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", name="catalog")
     */
    public function index(ProductRepository $repository)
    {
        $products = $repository->findAll();

        return $this->render('catalog/listProducts.html.twig', [
            'products' => $products
        ]);
    }


    /**
     * @Route("/catalog/page/{id}", name="pageProduit")
     */
    public function pageProduit($id, ProductRepository $repository)
    {
        $product = $repository->find($id);

        return $this->render('catalog/pageProduit.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/catalog/create", methods={"GET"}, name="createProduit")
     */
    public function createProduit()
    {
        $productForm = $this->createForm(ProductType::class);

        return $this->render('catalog/editProduit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    /**
     * @Route("/catalog/create", methods={"POST"}, name="postBackCreateProduit")
     */
    public function postBackCreateProduit(Request $request)
    {
        $product = new Product();
        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            
        }

        return $this->redirectToRoute('catalog');
    }


    /**
     * @Route("/catalog/facilite_paiement", name="facilitePaiement")
     */
    public function facilitePaiement()
    {
        return new Response("Vive les facilités de paiements !!");
    }

    /**
     * @Route("/catalog/create_data", name="createData")
     */
    public function createData(ProductRepository $productRepository, 
    CategoryRepository $categoryRepository)
    {
        $em = $this->getDoctrine()->getManager();

        foreach($productRepository->findAll() as $product) {
            $em->remove($product);
        }

        foreach($categoryRepository->findAll() as $category) {
            $em->remove($category);
        }
        
        $em->flush();

        $cat1 = new Category();
        $cat1->setName('Ustensile de cuisine');

        $cat2 = new Category();
        $cat2->setName('Accessoires PC');

        $product = new Product();
        $product->setName("Gobelet")
                ->setDescription("Ceci est un goblete pour boire")
                ->setPrix(5)
                ->setImage("images/gobelet.jpg");

        $product2 = new Product();
        $product2->setName("Gourde en metal")
                ->setDescription("Ceci est une groude en métal")
                ->setPrix(35)
                ->setImage("imagesgroude.jpg");
        
        $product3 = new Product();
        $product3->setName("Souris")
                ->setDescription("Ceci est une d'ordinateur")
                ->setPrix(24)
                ->setImage("images/souris.jpg");

        $cat1->addProduct($product);
        $cat1->addProduct($product2);

        $cat2->addProduct($product3);

        
        $em->persist($cat1);
        $em->persist($cat2);
        $em->persist($product);
        $em->persist($product2);
        $em->persist($product3);

        $em->flush();

        return new Response("Produits créés.");
    }

    /**
     * @Route("/catalog/cheap_products", name="cheapProducts")
     */
    public function cheapProducts(ProductRepository $repository)
    {
        $products = $repository->findCheapProducts();

        return $this->render('catalog/listProducts.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/catalog/category/{id}", name="showCategory")
     */
    public function showCategory($id, CategoryRepository $repository)
    {
        $category = $repository->findByIdWithProducts($id);

        return $this->render('catalog/category.html.twig', [
            'category' => $category
        ]);
    }
}
