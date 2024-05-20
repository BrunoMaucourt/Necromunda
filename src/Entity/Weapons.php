<?php

namespace App\Entity;

use App\Repository\WeaponsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponsRepository::class)]
class Weapons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'weapons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $ganger = null;

    #[ORM\Column]
    private ?int $cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGanger(): ?Ganger
    {
        return $this->Ganger;
    }

    public function setGanger(?Ganger $ganger): static
    {
        $this->Ganger = $ganger;

        return $this;
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
}
