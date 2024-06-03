<?php

namespace App\Entity;

use App\Enum\SkillsEnum;
use App\Repository\SkillsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillsRepository::class)]
class Skills
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: SkillsEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SkillsEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $ganger = null;

    /**
     * @var Collection<int, Advancement>
     */
    #[ORM\OneToMany(targetEntity: Advancement::class, mappedBy: 'skill')]
    private Collection $advancements;

    /**
     * @var Collection<int, Games>
     */
    #[ORM\ManyToMany(targetEntity: Games::class, mappedBy: 'skills')]
    private Collection $games;

    public function __construct()
    {
        $this->advancements = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?SkillsEnum
    {
        return $this->name;
    }

    public function setName(SkillsEnum $name): static
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

    /**
     * @return Collection<int, Advancement>
     */
    public function getAdvancements(): Collection
    {
        return $this->advancements;
    }

    public function addAdvancement(Advancement $advancement): static
    {
        if (!$this->advancements->contains($advancement)) {
            $this->advancements->add($advancement);
            $advancement->setSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Games>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Games $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addSkill($this);
        }

        return $this;
    }

    public function removeAdvancement(Advancement $advancement): static
    {
        if ($this->advancements->removeElement($advancement)) {
            // set the owning side to null (unless already changed)
            if ($advancement->getSkill() === $this) {
                $advancement->setSkill(null);
            }
        }

        return $this;
    }

    public function removeGame(Games $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removeSkill($this);
        }

        return $this;
    }
}