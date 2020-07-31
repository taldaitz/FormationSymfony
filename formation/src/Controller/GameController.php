<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/games", name="games")
     */
    public function index(GameRepository $gameRepository)
    {
        $games = $gameRepository->findAllOrderedByTime();

        $game = $games[0];


        return $this->render('game/index.html.twig', [
            'games' => $games,
            'dumpGame' => $game
        ]);
    }
}
