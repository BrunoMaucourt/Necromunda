<?php

namespace App\Entity;

use App\Repository\GamesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamesRepository::class)]
class Games
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $scenario = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $Gang1 = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang2 = null;

    #[ORM\ManyToOne(inversedBy: 'win')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $winner = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $background = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScenario(): ?string
    {
        return $this->scenario;
    }

    public function setScenario(string $scenario): static
    {
        $this->scenario = $scenario;

        return $this;
    }

    public function getGang1(): ?Gang
    {
        return $this->Gang1;
    }

    public function setGang1(?Gang $Gang1): static
    {
        $this->Gang1 = $Gang1;

        return $this;
    }

    public function getGang2(): ?Gang
    {
        return $this->gang2;
    }

    public function setGang2(?Gang $gang2): static
    {
        $this->gang2 = $gang2;

        return $this;
    }

    public function getWinner(): ?Gang
    {
        return $this->winner;
    }

    public function setWinner(?Gang $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): static
    {
        $this->background = $background;

        return $this;
    }
}
