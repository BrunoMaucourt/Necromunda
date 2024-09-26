<?php

// src/Controller/ErrorController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($statusCode === Response::HTTP_NOT_FOUND) {
            return $this->render('error404.html.twig', ['exception' => $exception]);
        }

        if ($statusCode === Response::HTTP_INTERNAL_SERVER_ERROR) {
            return $this->render('error500.html.twig', ['exception' => $exception]);
        }

        return $this->render('error500.html.twig', ['status_code' => $statusCode, 'exception' => $exception]);
    }
}