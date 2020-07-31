<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="player")
     */
    public function index()
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/list", name="listPlayer")
     */
    public function list(PlayerRepository $playerRepository)
    {
        $players = $playerRepository->findAll();

        return $this->render('player/list.html.twig', [
            'players' => $players,
        ]);
    }

    /**
     * @Route("/show/{id}", name="showPlayer")
     */
    public function show(Player $player)
    {
        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }   

    /**
     * @Route("/create", methods={"GET"}, name="createPlayer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create()
    {
        $form = $this->createForm(PlayerType::class);

        return $this->render('player/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create", methods={"POST"}, name="createPlayerPostBack")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createPostBack(Request $request)
    {
        $user = $this->getUser();

        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirectToRoute('listPlayer');
    }


    /**
     * @Route("/edit/{id}", methods={"GET"}, name="editPlayer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Player $player)
    {
        $form = $this->createForm(PlayerType::class, $player);

        return $this->render('player/edit.html.twig', [
            'form' => $form->createView(),
            'player' => $player
        ]);
    }

    /**
     * @Route("/edit/{id}", methods={"POST"}, name="editPlayerPostBack")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPostBack(Player $player, Request $request)
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('showPlayer', ['id' => $player->getId()]);
        }

        return $this->render('player/edit.html.twig', [
            'form' => $form->createView(),
            'player' => $player
        ]);
    }




    /**
     * @Route("/reset_data", name="resetData")
     */
    public function reset(TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $em = $this->getDoctrine()->getManager();

        foreach($playerRepository->findAll() as $player) {
            $em->remove($player);
        }
        $em->flush();

        foreach($teamRepository->findAll() as $team) {
            $em->remove($team);
        }
        $em->flush();

        $team1 = new Team();
        $team2 = new Team();

        $team1->setName('OL')->setCity('Lyon')->setLevel('Pro');
        $team2->setName('PSG')->setCity('Paris')->setLevel('Pro');

        $playerLyon1 = new Player();
        $playerLyon2 = new Player();
        $playerLyon3 = new Player();

        $playerParis1 = new Player();
        $playerParis2 = new Player();
        $playerParis3 = new Player();


        $playerLyon1->setFirstname('Thomas')->setLastname('Lyon')->setBirthdate(new DateTime('1980-04-18'))->setNumber(1)->setPosition('attaquant');
        $playerLyon2->setFirstname('Vincent')->setLastname('Lyon')->setBirthdate(new DateTime('1986-09-18'))->setNumber(3)->setPosition('milieu');
        $playerLyon3->setFirstname('Didier')->setLastname('Lyon')->setBirthdate(new DateTime('1988-03-28'))->setNumber(12)->setPosition('défenseur');


        $playerParis1->setFirstname('Jean')->setLastname('Paris')->setBirthdate(new DateTime('1980-04-18'))->setNumber(9)->setPosition('attaquant');
        $playerParis2->setFirstname('Robert')->setLastname('Paris')->setBirthdate(new DateTime('1986-09-18'))->setNumber(5)->setPosition('milieu');
        $playerParis3->setFirstname('Yves')->setLastname('Paris')->setBirthdate(new DateTime('1988-03-28'))->setNumber(12)->setPosition('défenseur');
        
        $team1->addPlayer($playerLyon1);
        $team1->addPlayer($playerLyon2);
        $team1->addPlayer($playerLyon3);

        $team2->addPlayer($playerParis1);
        $team2->addPlayer($playerParis2);
        $team2->addPlayer($playerParis3);

        $em->persist($team1);
        $em->persist($team2);
        $em->persist($playerLyon1);
        $em->persist($playerLyon2);
        $em->persist($playerLyon3);
        $em->persist($playerParis1);
        $em->persist($playerParis2);
        $em->persist($playerParis3);

        $em->flush();
        
        return new Response("Jeu de données créé !");
    }
}
