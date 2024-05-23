<?php

namespace App\Entity;

use App\Enum\TerritoriesEnum;
use App\Repository\TerritoriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerritoriesRepository::class)]
class Territories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: TerritoriesEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TerritoriesEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'territories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $effect = null;

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?TerritoriesEnum
    {
        return $this->name;
    }

    public function setName(TerritoriesEnum $name): static
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

    public function getEffect(): ?string
    {
        return $this->effect;
    }

    public function setEffect(?string $effect): static
    {
        $this->effect = $effect;

        return $this;
    }

    public function getIncomeAsString(): string
    {
        $currentTerritory = $this->getName();
        return $currentTerritory->getFixedIncome() .' + ' . $currentTerritory->getVariableIncomeNumberOfDice() . ' D6 X ' . $currentTerritory->getVariableIncomeMultiplicator();
    }

    public function getIncomeAsMoney(): int
    {
        $currentTerritory = $this->getName();
        return $currentTerritory->getFixedIncome() +  $currentTerritory->getVariableIncomeNumberOfDice() * (mt_rand(1, 6) * $currentTerritory->getVariableIncomeMultiplicator());
    }
}