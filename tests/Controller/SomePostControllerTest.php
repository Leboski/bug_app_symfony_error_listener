<?php

namespace App\Tests\Controller;

use App\InMemoryRequestMethodStorer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SomePostControllerTest extends WebTestCase
{
    public function testSomethingToAssertTheBug(): void
    {
        $client = static::createClient();
        /** @var InMemoryRequestMethodStorer $requestMethodStorer */
        $requestMethodStorer = $this->getContainer()->get(InMemoryRequestMethodStorer::class);
        $requestMethodStorer->clearRequestMethodOccurrences();

        $client->request(Request::METHOD_POST, '/some');

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $originalMethodOccurrences = $requestMethodStorer->getOriginalRequestMethodOccurrences();
        $this->assertCount(1, $originalMethodOccurrences);
        $this->assertEquals(Request::METHOD_POST, $originalMethodOccurrences[0]);

        /**
         * We think Here is the bug, it seems it's introduced by the framework file Symfony\Component\HttpKernel\EventListener\ErrorListener.php
         * when it's used along with the `App\ErrorController` class configured as the framework `error_controller`, in the method `ErrorListener::duplicateRequest`
         * there is a line that sets the request method to `GET`: `$request->setMethod('GET');` and later it's not restored to the original method.
         *
         * If the `App\ErrorController` is not present/configured, then there is no such bug.
        **/
        $errorControllerMethodOccurrences = $requestMethodStorer->getErrorControllerRequestMethodOccurrences();
        $this->assertCount(1, $errorControllerMethodOccurrences);
        $this->assertEquals(Request::METHOD_GET, $errorControllerMethodOccurrences[0]);
    }
}