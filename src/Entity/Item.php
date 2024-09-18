<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cost = 0;

    #[ORM\Column(type: 'boolean')]
    private ?bool $free = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function isFree(): ?bool
    {
        return $this->free;
    }

    public function setFree(bool $free): static
    {
        $this->free = $free;

        return $this;
    }
}