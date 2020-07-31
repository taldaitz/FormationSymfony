<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        
        $teams = $manager->getRepository(Team::class)->findAll();

        for ($i=0; $i < 20; $i++) { 

            $in = $out = 0;
            while ($in == $out) {
                $in = array_rand($teams);
                $out = array_rand($teams);
            }

            $game = new Game();
            $game->setDate($faker->dateTimeInInterval('now', '+1 years'))
                    ->setTeamIn($teams[$in])
                    ->setTeamOut($teams[$out])
            ;

            $manager->persist($game);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return array(
            PlayerFixtures::class,
        );
    }
}
