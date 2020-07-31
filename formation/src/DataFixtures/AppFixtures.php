<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('taldaitz@dawan.fr')
                ->setFirstname('Thomas')
                ->setLastname('Aldaitz')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$TDhSd3AuZ1FxWm44U2hKVg$QRZ9/1bL+p9nHbLX8aF+1LBsSfEHwrbdwzRcvlZnx14')
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
