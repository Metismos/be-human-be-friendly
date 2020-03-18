<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class HumanFriendlyTimeControllerTest extends WebTestCase
{
    public function testRetreiveSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/api/human-friendly-time');

        $this->assertResponseIsSuccessful();
    }

    public function testRetreiveFromTimeSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/api/human-friendly-time?time=12:00');

        $this->assertResponseIsSuccessful();
    }

    public function testRetreiveFromTimeMalformedInputFailure()
    {
        $client = static::createClient();
        $client->request('GET', '/api/human-friendly-time?time=12:004');

        $this->assertResponseStatusCodeSame(422, $client->getResponse()->getStatusCode());
    }
}
