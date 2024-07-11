<?php

namespace App\service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasherService
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function hashPassword($user, string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }
}