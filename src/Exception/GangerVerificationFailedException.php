<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class GangerVerificationFailedException extends HttpException
{
    public function __construct(string $message = 'Verification failed', int $statusCode = 302)
    {
        parent::__construct($statusCode, $message);
    }
}