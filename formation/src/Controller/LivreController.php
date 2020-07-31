<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre")
     */
    public function index()
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }

    /**
     * @Route("/creerBibli", name="bibliotheque")
     */
    public function creerBibli()
    {
        $livre1 = new Livre();
        $livre1->setTitre("Le comte de Monte-Cristo")
            ->setAuteur("Alexandre Dumas")
            ->setResume("Un prisonier s'évade et se venge")
            ->setDateParution(new DateTime('1810-01-01'));

        $livre2 = new Livre();
        $livre2->setTitre("Les trois mousquetaires")
            ->setAuteur("Alexandre Dumas")
            ->setResume("Des mousquetaires qui aiment la bagarre")
            ->setDateParution(new DateTime('1805-01-01'));

        $livre3 = new Livre();
        $livre3->setTitre("1Q84")
            ->setAuteur("Haruki Murakami")
            ->setResume("De trucs bizzare")
            ->setDateParution(new DateTime('2008-01-01'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($livre1);
        $em->persist($livre2);
        $em->persist($livre3);

        $em->flush();

        return new Response("Livres créés");
    }

    /**
     * @Route("/liste", name="listeLivre")
     */
    public function list(LivreRepository $livreRepository)
    {
        $livres = $livreRepository->findAll();

        return $this->render('livre/livreList.html.twig', [
            'livres' => $livres,
        ]);
    }

    /**
     * @Route("/creer", methods={"GET"}, name="creeLivre")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create()
    {
        $form = $this->createForm(LivreType::class);

        return $this->render("livre/edit.html.twig", [
            'form' => $form->createView(),
            'title' => 'Création de livre'
        ]);
    }

    /**
     * @Route("/creer", methods={"POST"}, name="creeLivrePost")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createPost(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($livre);
        $em->flush();

        return $this->redirectToRoute('listeLivre');
    }

    /**
     * @Route("/modifier/{id}", methods={"GET"}, name="editLivre")
     */
    public function edit(Livre $livre)
    {
        $form = $this->createForm(LivreType::class, $livre);

        return $this->render("livre/edit.html.twig", [
            'form' => $form->createView(),
            'title' => 'Modification de livre'
        ]);
    }

    /**
     * @Route("/modifier/{id}", methods={"POST"}, name="editLivrePost")
     */
    public function editPost(Livre $livre, Request $request)
    {
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);

        if($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('listeLivre');
        }

        return $this->render("livre/edit.html.twig", [
            'form' => $form->createView(),
            'title' => 'Modification de livre'
        ]);
    }
}
