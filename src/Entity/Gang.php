<?php

namespace App\Entity;

use App\Repository\GangRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GangRepository::class)]
class Gang
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $credits = 1000;

    #[ORM\Column]
    private ?bool $active = true;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $background = null;

    /**
     * @var Collection<int, Ganger>
     */
    #[ORM\OneToMany(targetEntity: Ganger::class, mappedBy: 'gang')]
    private Collection $gangers;

    #[ORM\ManyToOne(inversedBy: 'gang')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Territories>
     */
    #[ORM\OneToMany(targetEntity: Territories::class, mappedBy: 'gang')]
    private Collection $territories;

    /**
     * @var Collection<int, Games>
     */
    #[ORM\OneToMany(targetEntity: Games::class, mappedBy: 'gang1')]
    private Collection $games;

    /**
     * @var Collection<int, Games>
     */
    #[ORM\OneToMany(targetEntity: Games::class, mappedBy: 'winner')]
    private Collection $win;

    #[ORM\Column(length: 255)]
    private ?string $house = null;

    public function __construct()
    {
        $this->gangers = new ArrayCollection();
        $this->territories = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->win = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name . ' - ' . $this->house;
    }

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

    public function getRating(): ?int
    {
        return 0;
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): static
    {
        $this->credits = $credits;

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
            $ganger->setGang($this);
        }

        return $this;
    }

    public function removeGanger(Ganger $ganger): static
    {
        if ($this->gangers->removeElement($ganger)) {
            // set the owning side to null (unless already changed)
            if ($ganger->getGang() === $this) {
                $ganger->setGang(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Territories>
     */
    public function getTerritories(): Collection
    {
        return $this->territories;
    }

    public function addTerritory(Territories $territory): static
    {
        if (!$this->territories->contains($territory)) {
            $this->territories->add($territory);
            $territory->setGang($this);
        }

        return $this;
    }

    public function removeTerritory(Territories $territory): static
    {
        if ($this->territories->removeElement($territory)) {
            // set the owning side to null (unless already changed)
            if ($territory->getGang() === $this) {
                $territory->setGang(null);
            }
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
            $game->setGang1($this);
        }

        return $this;
    }

    public function removeGame(Games $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getGang1() === $this) {
                $game->setGang1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Games>
     */
    public function getWin(): Collection
    {
        return $this->win;
    }

    public function addWin(Games $win): static
    {
        if (!$this->win->contains($win)) {
            $this->win->add($win);
            $win->setWinner($this);
        }

        return $this;
    }

    public function removeWin(Games $win): static
    {
        if ($this->win->removeElement($win)) {
            // set the owning side to null (unless already changed)
            if ($win->getWinner() === $this) {
                $win->setWinner(null);
            }
        }

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(string $house): static
    {
        $this->house = $house;

        return $this;
    }
}