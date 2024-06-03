<?php

namespace App\Entity;

use App\Repository\AdvancementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdvancementRepository::class)]
class Advancement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'content')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $ganger = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'advancements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Games $game = null;

    #[ORM\ManyToOne(inversedBy: 'advancements')]
    private ?Skills $skill = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getGame(): ?Games
    {
        return $this->game;
    }

    public function setGame(?Games $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getSkill(): ?Skills
    {
        return $this->skill;
    }

    public function setSkill(?Skills $skill): static
    {
        $this->skill = $skill;

        return $this;
    }
}
