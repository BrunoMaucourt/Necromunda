<?php

namespace App\Entity;

use App\Enum\TerritoriesEnum;
use App\Repository\TerritoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerritoriesRepository::class)]
class Territory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: TerritoriesEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TerritoriesEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'territories')]
    #[ORM\JoinColumn(nullable: false, onDelete:'cascade')]
    private ?Gang $gang = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'territories')]
    private Collection $games;

    public function __construct()
    {
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

    public function getName(): ?TerritoriesEnum
    {
        return $this->name;
    }

    public function getNameAsString(): ?string
    {
        return $this->name->enumToString();
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
        return $this->name->getEffect();
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

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addTerritory($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removeTerritory($this);
        }

        return $this;
    }
}