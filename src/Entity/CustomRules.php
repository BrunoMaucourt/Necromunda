<?php

namespace App\Entity;

use App\Repository\CustomRulesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomRulesRepository::class)]
class CustomRules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $enfoncers = false;

    #[ORM\Column]
    private ?bool $destinyScore = false;

    #[ORM\Column]
    private ?bool $photonFlare = false;

    #[ORM\Column]
    private ?bool $blindFight = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnfoncers(): ?bool
    {
        return $this->enfoncers;
    }

    public function setEnfoncers(bool $enfoncers): static
    {
        $this->enfoncers = $enfoncers;

        return $this;
    }

    public function isDestinyScore(): ?bool
    {
        return $this->destinyScore;
    }

    public function setDestinyScore(bool $destinyScore): static
    {
        $this->destinyScore = $destinyScore;

        return $this;
    }

    public function isPhotonFlare(): ?bool
    {
        return $this->photonFlare;
    }

    public function setPhotonFlare(bool $photonFlare): static
    {
        $this->photonFlare = $photonFlare;

        return $this;
    }

    public function isBlindFight(): ?bool
    {
        return $this->blindFight;
    }

    public function setBlindFight(bool $blindFight): static
    {
        $this->blindFight = $blindFight;

        return $this;
    }
}