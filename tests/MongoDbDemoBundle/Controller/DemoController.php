<?php

namespace Tests\MongoDbDemoBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemoControllerTest extends WebTestCase
{
    /**
     * @var array
     */
    static $item;


    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdd()
    {
        $itemName = 'Demo test item';

        $client = static::createClient();
        $crawler = $client->request('POST', '/demo/add', array('name' => $itemName));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();

        $this->assertContains($itemName,$response->getContent());

        $jsonAnswer = json_decode($response->getContent(), TRUE);
        $this->assertArrayHasKey('id', $jsonAnswer);
        $this->assertArrayHasKey('name', $jsonAnswer);
        $this->assertContains($itemName,$jsonAnswer['name']);

        self::$item = $jsonAnswer;
    }

    public function testUpdate()
    {
        $item = self::$item;

        $newItemName = $item['name']. ' updated';
        $newValue = array('name' =>  $newItemName);
        $path =  '/demo/'. $item['id']. '/update';

        $client = static::createClient();
        $crawler = $client->request('POST', $path, $newValue);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();

        $this->assertContains($newItemName,$response->getContent());

        // JSON
        $jsonAnswer = json_decode($response->getContent(), TRUE);
        $this->assertArrayHasKey('id', $jsonAnswer);
        $this->assertArrayHasKey('name', $jsonAnswer);
        $this->assertContains($newItemName,$jsonAnswer['name']);
    }

    public function testShow()
    {
        $item = self::$item;

        $path =  '/demo/'. $item['id'];

        $client = static::createClient();
        $crawler = $client->request('GET', $path);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();

        $this->assertContains($item['name'],$response->getContent());

        // JSON
        $jsonAnswer = json_decode($response->getContent(), TRUE);
        $this->assertArrayHasKey('id', $jsonAnswer);
        $this->assertArrayHasKey('name', $jsonAnswer);
        $this->assertContains($item['name'],$jsonAnswer['name']);
    }

    public function testDelete()
    {
        $item = self::$item;

        $path =  '/demo/'. $item['id']. '/delete';

        $client = static::createClient();
        $crawler = $client->request('GET', $path);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();

        $this->assertContains($item['id'],$response->getContent());

        // JSON
        $jsonAnswer = json_decode($response->getContent(), TRUE);
        $this->assertArrayHasKey('id', $jsonAnswer);
        $this->assertContains($item['id'],$jsonAnswer['id']);

        self::$item = null;
    }
}


