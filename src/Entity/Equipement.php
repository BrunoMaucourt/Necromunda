<?php

namespace App\Entity;

use App\Enum\EquipementsEnum;
use App\Repository\EquipementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementsRepository::class)]
class Equipement extends Item
{
    #[ORM\Column]
    private ?EquipementsEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ganger $ganger = null;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Weapon $weapon = null;

    #[ORM\Column]
    private ?bool $loot = null;

    public function __toString(): string
    {
        return $this->name->enumToString();
    }


    public function getName(): ?EquipementsEnum
    {
        return $this->name;
    }

    public function setName(EquipementsEnum $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGanger(): ?Ganger
    {
        return $this->ganger;
    }

    public function setGanger(?Ganger $ganger): static
    {
        $this->ganger = $ganger;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): static
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function isLoot(): ?bool
    {
        return $this->loot;
    }

    public function setLoot(?bool $loot): static
    {
        $this->loot = $loot;

        return $this;
    }
}