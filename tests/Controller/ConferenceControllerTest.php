<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Hello World');
    }
    public function testShow()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/conference/{slug}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
