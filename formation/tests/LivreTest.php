<?php

namespace App\Tests;

use App\Entity\Livre;
use PHPUnit\Framework\TestCase;

class LivreTest extends TestCase
{
    public function testNicePresentation()
    {
        $livre = new Livre();
        $livre->setTitre('titre')
            ->setAuteur('auteur');

        $resultatAttendu = 'titre - auteur';
        $this->assertEquals($resultatAttendu, $livre->getNicePresentation());
    }

}
