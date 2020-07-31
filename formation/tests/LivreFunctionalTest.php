<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LivreFunctionalTest extends WebTestCase
{
    public function testListeLivre()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/livre/liste');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Ma bibliothèque');

        $link = $crawler->selectLink('Créer un nouveau livre')->link();
        $client->click($link);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->followRedirect();

        $this->assertSelectorTextContains('label', 'Email');
    }

    public function testAccesModifierLivre()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/livre/liste');

        $link = $crawler->selectLink('Modifier')->link();


        //Il faut changer le crawler sinon il garde l'ancienne page en mémoire...
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(0, $crawler->filter('label:contains("Titre")')->count());
        $this->assertGreaterThan(0, $crawler->filter('label:contains("Auteur")')->count());
        $this->assertGreaterThan(0, $crawler->filter('label:contains("Resume")')->count());
    }
}
