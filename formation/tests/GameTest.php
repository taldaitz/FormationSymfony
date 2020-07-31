<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Team;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testTeamsHasSameNbOfPlayers()
    {
        //Arrange
        $team1 = new Team();
        $team2 = new Team();

        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $player4 = new Player();
        $player5 = new Player();
        $player6 = new Player();

        $team1->addPlayer($player1);
        $team1->addPlayer($player2);
        $team1->addPlayer($player3);

        $team2->addPlayer($player4);
        $team2->addPlayer($player5);
        $team2->addPlayer($player6);

        $game = new Game();
        $game->setTeamIn($team1);
        $game->setTeamOut($team2);

        //Act
        $result = $game->hasTheSameNbOfPlayers();

        //Assert

        $this->assertTrue($result);
    }

    public function testTeamsHasSameNbOfPlayersFalse()
    {
        //Arrange
        $team1 = new Team();
        $team2 = new Team();

        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $player4 = new Player();
        $player5 = new Player();

        $team1->addPlayer($player1);
        $team1->addPlayer($player2);
        $team1->addPlayer($player3);

        $team2->addPlayer($player4);
        $team2->addPlayer($player5);

        $game = new Game();
        $game->setTeamIn($team1);
        $game->setTeamOut($team2);

        //Act
        $result = $game->hasTheSameNbOfPlayers();

        //Assert

        $this->assertFalse($result);
    }
}
