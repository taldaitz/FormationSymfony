<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PlayerFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
       for($i = 0; $i < 10; $i++) {
            $team = new Team();

            $team->setName(substr($faker->word(), 0, 4))
                    ->setCity($faker->city())
                    ->setLevel('professionel')
            ;

            $manager->persist($team);
            $manager->flush();
       }

       $positions = [
           'attaquant',
           'milieu',
           'défenseur',
           'gardien'
       ];

       $teams = $manager->getRepository(Team::class)->findAll();

       for($i = 0; $i < 100; $i++) {
            $player = new Player();

            $player->setLastname($faker->lastName())
                    ->setFirstname($faker->firstName())
                    ->setBirthdate($faker->dateTime('2000-01-01'))
                    ->setNumber($faker->numberBetween(0, 22))
                    ->setPosition($positions[array_rand($positions)])
                    ->setTeam($teams[array_rand($teams)])
            ;

            $manager->persist($player);
            $manager->flush();
        }
    }
}
