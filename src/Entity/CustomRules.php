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
    private ?bool $rocketFlare = false;

    #[ORM\Column]
    private ?bool $blindFightRemoved = false;

    #[ORM\Column]
    private ?bool $reRollAdvancementDices = false;

    #[ORM\Column]
    private ?bool $scenarioModifier = false;

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

    public function isRocketFlare(): ?bool
    {
        return $this->rocketFlare;
    }

    public function setRocketFlare(bool $rocketFlare): static
    {
        $this->rocketFlare = $rocketFlare;

        return $this;
    }

    public function isBlindFightRemoved(): ?bool
    {
        return $this->blindFightRemoved;
    }

    public function setBlindFightRemoved(bool $blindFightRemoved): static
    {
        $this->blindFightRemoved = $blindFightRemoved;

        return $this;
    }

    public function isReRollAdvancementDices(): ?bool
    {
        return $this->reRollAdvancementDices;
    }

    public function setReRollAdvancementDices(bool $reRollAdvancementDices): static
    {
        $this->reRollAdvancementDices = $reRollAdvancementDices;

        return $this;
    }

    public function isScenarioModifier(): ?bool
    {
        return $this->scenarioModifier;
    }

    public function setScenarioModifier(bool $scenarioModifier): static
    {
        $this->scenarioModifier = $scenarioModifier;

        return $this;
    }
}