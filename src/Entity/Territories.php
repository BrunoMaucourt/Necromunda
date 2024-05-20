<?php

namespace App\Entity;

use App\Repository\TerritoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerritoriesRepository::class)]
class Territories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'territories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang = null;

    #[ORM\Column]
    private ?int $incomeFixed = null;

    #[ORM\Column]
    private ?int $incomeVariable = null;

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

    public function getGang(): ?Gang
    {
        return $this->gang;
    }

    public function setGang(?Gang $gang): static
    {
        $this->gang = $gang;

        return $this;
    }

    public function getIncomeFixed(): ?int
    {
        return $this->incomeFixed;
    }

    public function setIncomeFixed(int $incomeFixed): static
    {
        $this->incomeFixed = $incomeFixed;

        return $this;
    }

    public function getIncomeVariable(): ?int
    {
        return $this->incomeVariable;
    }

    public function setIncomeVariable(int $incomeVariable): static
    {
        $this->incomeVariable = $incomeVariable;

        return $this;
    }
}
