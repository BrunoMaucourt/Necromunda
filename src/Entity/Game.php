<?php

namespace App\Entity;

use App\Enum\ScenariosEnum;
use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamesRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: ScenariosEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ScenariosEnum $scenario = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang1 = null;

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

    #[ORM\Column]
    private ?int $gang1RatingBeforeGame = null;

    #[ORM\Column]
    private ?int $gang1RatingAfterGame = null;

    #[ORM\Column]
    private ?int $gang2RatingBeforeGame = null;

    #[ORM\Column]
    private ?int $gang2RatingAfterGame = null;

    #[ORM\Column]
    private ?int $gang1creditsBeforeGame = null;

    #[ORM\Column]
    private ?int $gang2creditsBeforeGame = null;

    #[ORM\Column]
    private ?int $gang1creditsAfterGame = null;

    #[ORM\Column]
    private ?int $gang2creditsAfterGame = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    /**
     * @var Collection<int, Advancement>
     */
    #[ORM\OneToMany(targetEntity: Advancement::class, mappedBy: 'game', cascade: ['persist', 'remove'])]
    private Collection $advancements;

    /**
     * @var Collection<int, Ganger>
     */
    #[ORM\ManyToMany(targetEntity: Ganger::class, inversedBy: 'games', cascade: ['persist'])]
    private Collection $gangers;

    /**
     * @var Collection<int, Territory>
     */
    #[ORM\ManyToMany(targetEntity: Territory::class, inversedBy: 'games', cascade: ['persist', 'remove'])]
    private Collection $territories;

    /**
     * @var Collection<int, Injury>
     */
    #[ORM\ManyToMany(targetEntity: Injury::class, inversedBy: 'games', cascade: ['persist', 'remove'])]
    private Collection $injuries;

    /**
     * @var Collection<int, Loot>
     */
    #[ORM\OneToMany(targetEntity: Loot::class, mappedBy: 'game', cascade: ['persist', 'remove'])]
    private Collection $loots;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $history = null;

    #[ORM\Column(nullable: true)]
    private ?string $picture = null;

    public function __construct()
    {
        $this->advancements = new ArrayCollection();
        $this->gangers = new ArrayCollection();
        $this->territories = new ArrayCollection();
        $this->injuries = new ArrayCollection();
        $this->loots = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d') . ' - ' . $this->scenario->enumToString();
    }

    public function getName(): string
    {
        return $this->date->format('Y-m-d') . ' - ' . $this->scenario->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScenario(): ?ScenariosEnum
    {
        return $this->scenario;
    }

    public function setScenario(ScenariosEnum $scenario): static
    {
        $this->scenario = $scenario;

        return $this;
    }

    public function getGang1(): ?Gang
    {
        return $this->gang1;
    }

    public function setGang1(?Gang $gang1): static
    {
        $this->gang1 = $gang1;

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
            $advancement->setGame($this);
        }

        return $this;
    }

    public function getGang1RatingBeforeGame(): ?int
    {
        return $this->gang1RatingBeforeGame;
    }

    public function setGang1RatingBeforeGame(int $gang1RatingBeforeGame): static
    {
        $this->gang1RatingBeforeGame = $gang1RatingBeforeGame;

        return $this;
    }

    public function getGang1RatingAfterGame(): ?int
    {
        return $this->gang1RatingAfterGame;
    }

    public function setGang1RatingAfterGame(int $gang1RatingAfterGame): static
    {
        $this->gang1RatingAfterGame = $gang1RatingAfterGame;

        return $this;
    }

    public function getGang2RatingBeforeGame(): ?int
    {
        return $this->gang2RatingBeforeGame;
    }

    public function setGang2RatingBeforeGame(int $gang2RatingBeforeGame): static
    {
        $this->gang2RatingBeforeGame = $gang2RatingBeforeGame;

        return $this;
    }

    public function getGang2RatingAfterGame(): ?int
    {
        return $this->gang2RatingAfterGame;
    }

    public function setGang2RatingAfterGame(int $gang2RatingAfterGame): static
    {
        $this->gang2RatingAfterGame = $gang2RatingAfterGame;

        return $this;
    }

    public function getGang1creditsAfterGame(): ?int
    {
        return $this->gang1creditsAfterGame;
    }

    public function setGang1creditsAfterGame(int $gang1creditsAfterGame): static
    {
        $this->gang1creditsAfterGame = $gang1creditsAfterGame;

        return $this;
    }

    public function getGang2creditsAfterGame(): ?int
    {
        return $this->gang2creditsAfterGame;
    }

    public function setGang2creditsAfterGame(int $gang2creditsAfterGame): static
    {
        $this->gang2creditsAfterGame = $gang2creditsAfterGame;

        return $this;
    }

    /**
     * @return Collection<int, Ganger>
     */
    public function getGangers(): Collection
    {
        return $this->gangers;
    }

    public function addGanger(Ganger $ganger): static
    {
        if (!$this->gangers->contains($ganger)) {
            $this->gangers->add($ganger);
        }

        return $this;
    }

    public function removeAdvancement(Advancement $advancement): static
    {
        if ($this->advancements->removeElement($advancement)) {
            // set the owning side to null (unless already changed)
            if ($advancement->getGame() === $this) {
                $advancement->setGame(null);
            }
        }

        return $this;
    }

    public function removeGanger(Ganger $ganger): static
    {
        $this->gangers->removeElement($ganger);

        return $this;
    }

    /**
     * @return Collection<int, Territory>
     */
    public function getTerritories(): Collection
    {
        return $this->territories;
    }

    public function addTerritory(Territory $territory): static
    {
        if (!$this->territories->contains($territory)) {
            $this->territories->add($territory);
        }

        return $this;
    }

    public function removeTerritory(Territory $territory): static
    {
        $this->territories->removeElement($territory);

        return $this;
    }

    /**
     * @return Collection<int, Injury>
     */
    public function getInjuries(): Collection
    {
        return $this->injuries;
    }

    public function addInjury(Injury $injury): static
    {
        if (!$this->injuries->contains($injury)) {
            $this->injuries->add($injury);
        }

        return $this;
    }

    public function removeInjury(Injury $injury): static
    {
        $this->injuries->removeElement($injury);

        return $this;
    }

    public function getGang1creditsBeforeGame(): ?int
    {
        return $this->gang1creditsBeforeGame;
    }

    public function setGang1creditsBeforeGame(int $gang1creditsBeforeGame): static
    {
        $this->gang1creditsBeforeGame = $gang1creditsBeforeGame;

        return $this;
    }

    public function getGang2creditsBeforeGame(): ?int
    {
        return $this->gang2creditsBeforeGame;
    }

    public function setGang2creditsBeforeGame(int $gang2creditsBeforeGame): static
    {
        $this->gang2creditsBeforeGame = $gang2creditsBeforeGame;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return Collection<int, Loot>
     */
    public function getLoots(): Collection
    {
        return $this->loots;
    }

    public function addLoots(Loot $loots): static
    {
        if (!$this->loots->contains($loots)) {
            $this->loots->add($loots);
            $loots->setGame($this);
        }

        return $this;
    }

    public function removeLoots(Loot $loots): static
    {
        if ($this->loots->removeElement($loots)) {
            // set the owning side to null (unless already changed)
            if ($loots->getGame() === $this) {
                $loots->setGame(null);
            }
        }

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(?string $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }
}