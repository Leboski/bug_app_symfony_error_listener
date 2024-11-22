<?php

namespace App\Controller;

use App\InMemoryRequestMethodStorer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Throwable;

#[AsController]
class ErrorController
{
    public function __construct(private InMemoryRequestMethodStorer $inMemoryRequestMethodStorer)
    {
    }

    public function showAction(Throwable $exception, Request $request): Response
    {
        $this->inMemoryRequestMethodStorer->addErrorControllerRequestMethodOccurrence($request->getMethod());

        $response = new JsonResponse("", Response::HTTP_BAD_REQUEST);

        return $response;
    }
}