<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class UserListener
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof User) {
            return;
        }

        $changes = $event->getEntityChangeSet();

        if (isset($changes['temporaryPassword'])) {

            $newPassword = $changes['temporaryPassword'][1];
            $hashedPassword = $this->passwordHasher->hashPassword($object, $newPassword);
            $object->setPassword($hashedPassword);
            $object->setTemporaryPassword(null);
        }
    }

    public function hashPassword($user, string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }
}