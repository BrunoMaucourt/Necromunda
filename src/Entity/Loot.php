<?php

namespace App\Entity;

use App\Enum\LootEnum;
use App\Repository\LootRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LootRepository::class)]
class Loot extends Item
{
    #[ORM\Column(length: 255)]
    private ?LootEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'loots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang = null;

    #[ORM\ManyToOne(inversedBy: 'loot')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getName(): ?LootEnum
    {
        return $this->name;
    }

    public function setName(LootEnum $name): static
    {
        $this->name = $name;

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
