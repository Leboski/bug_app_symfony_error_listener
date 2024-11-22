<?php

namespace App\Controller;

use App\InMemoryRequestMethodStorer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class SomePostController
{
    public function __construct(private InMemoryRequestMethodStorer $inMemoryRequestMethodStorer)
    {
    }

    #[Route(path: '/some', name: 'some', methods: ['POST'])]
    public function setDailyIntakesAction(Request $request): Response
    {
        $this->inMemoryRequestMethodStorer->addOriginalRequestMethodOccurrence($request->getMethod());

        throw new BadRequestHttpException('Some error message');
    }
}