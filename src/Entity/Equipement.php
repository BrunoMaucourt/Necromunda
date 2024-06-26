<?php

namespace App\Entity;

use App\Enum\EquipementsEnum;
use App\Repository\EquipementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementsRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?EquipementsEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ganger $ganger = null;

    #[ORM\Column]
    private ?int $cost = 0;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Weapon $weapon = null;

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $newGangCredits = $this->ganger->getGang()->getCredits() - $cost;
        $this->ganger->getGang()->setCredits($newGangCredits);

        $this->cost = $cost;

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
}