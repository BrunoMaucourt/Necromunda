<?php

namespace App\Entity;

use App\Repository\LootRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LootRepository::class)]
class Loot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\ManyToOne(inversedBy: 'loots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang = null;

    #[ORM\ManyToOne(inversedBy: 'loot')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function __toString(): string
    {
        return $this->name;
    }

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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getGang(): ?Gang
    {
        return $this->gang;
    }

    public function setGang(?Gang $gang): static
    {
        $this->gang = $gang;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }
}
