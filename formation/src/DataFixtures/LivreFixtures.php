<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++) {

            $livre = new Livre();
            $livre->setTitre($faker->sentence(6, true))
                  ->setResume($faker->realText())
                  ->setAuteur($faker->name())
                  ->setDateParution(new DateTime($faker->date()))
                  ;

            $manager->persist($livre);
            $manager->flush();

        }
    }
}
