<?php

namespace App\Entity;

use App\Enum\AdvancementEnum;
use App\Repository\AdvancementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdvancementRepository::class)]
class Advancement
{
    const CHOOSE_ANY_TABLE = "Choose a new skill in any table";

    const RANDON_STANDARD_TABLE ="Random skill in standard table";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'content')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $ganger = null;

    #[ORM\Column(length: 255, enumType: AdvancementEnum::class)]
    private ?AdvancementEnum $content = null;

    #[ORM\ManyToOne(inversedBy: 'advancements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'advancements')]
    private ?Skill $skill = null;

    #[ORM\Column]
    private ?bool $reRoll = true;

    #[ORM\Column]
    private ?bool $active = true;

    public function __toString(): string
    {
        return $this->content->enumToString();
    }

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

    public function getContent(): ?AdvancementEnum
    {
        return $this->content;
    }

    public function setContent(AdvancementEnum $content): static
    {
        $this->content = $content;

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

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    public function isReRoll(): ?bool
    {
        return $this->reRoll;
    }

    public function setReRoll(bool $reRoll): static
    {
        $this->reRoll = $reRoll;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
