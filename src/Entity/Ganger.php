<?php

namespace App\Entity;

use App\Enum\GangerTypeEnum;
use App\Repository\GangerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GangerRepository::class)]
class Ganger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $move = 4;

    #[ORM\Column]
    private ?int $weaponSkill = null;

    #[ORM\Column]
    private ?int $ballisticSkill = null;

    #[ORM\Column]
    private ?int $strength = 3;

    #[ORM\Column]
    private ?int $toughness = 3;

    #[ORM\Column]
    private ?int $wounds = 1;

    #[ORM\Column]
    private ?int $initiative = null;

    #[ORM\Column]
    private ?int $attacks = 1;

    #[ORM\Column]
    private ?int $leadership = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $background = null;

    #[ORM\Column]
    private ?bool $alive = true;

    #[ORM\Column]
    private ?int $experience = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\Column]
    private ?int $rating = null;

    /**
     * @var Collection<int, Injury>
     */
    #[ORM\OneToMany(targetEntity: Injury::class, mappedBy: 'victim', cascade: ['persist', 'remove'])]
    private Collection $injuries;

    /**
     * @var Collection<int, Weapon>
     */
    #[ORM\OneToMany(targetEntity: Weapon::class, mappedBy: 'ganger', cascade: ['persist', 'remove'])]
    private Collection $weapons;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\OneToMany(targetEntity: Equipement::class, mappedBy: 'ganger', cascade: ['persist', 'remove'])]
    private Collection $equipements;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\OneToMany(targetEntity: Skill::class, mappedBy: 'ganger', cascade: ['persist', 'remove'])]
    private Collection $skills;

    #[ORM\ManyToOne(inversedBy: 'gangers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gang $gang = null;

    #[ORM\Column(length: 255, enumType: GangerTypeEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?GangerTypeEnum $type = null;

    /**
     * @var Collection<int, Advancement>
     */
    #[ORM\OneToMany(targetEntity: Advancement::class, mappedBy: 'ganger', orphanRemoval: true)]
    private Collection $advancement;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'gangers')]
    private Collection $games;

    public function __construct()
    {
        $this->injuries = new ArrayCollection();
        $this->weapons = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->advancement = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->type->enumToString() . ' - ' . $this->name;
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

    public function getMove(): ?int
    {
        return $this->move;
    }

    public function setMove(int $move): static
    {
        $this->move = $move;

        return $this;
    }

    public function getWeaponSkill(): ?int
    {
        return $this->weaponSkill;
    }

    public function setWeaponSkill(int $weaponSkill): static
    {
        $this->weaponSkill = $weaponSkill;

        return $this;
    }

    public function getBallisticSkill(): ?int
    {
        return $this->ballisticSkill;
    }

    public function setBallisticSkill(int $ballisticSkill): static
    {
        $this->ballisticSkill = $ballisticSkill;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): static
    {
        $this->strength = $strength;

        return $this;
    }

    public function getToughness(): ?int
    {
        return $this->toughness;
    }

    public function setToughness(int $toughness): static
    {
        $this->toughness = $toughness;

        return $this;
    }

    public function getWounds(): ?int
    {
        return $this->wounds;
    }

    public function setWounds(int $wounds): static
    {
        $this->wounds = $wounds;

        return $this;
    }

    public function getInitiative(): ?int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): static
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getAttacks(): ?int
    {
        return $this->attacks;
    }

    public function setAttacks(int $attacks): static
    {
        $this->attacks = $attacks;

        return $this;
    }

    public function getLeadership(): ?int
    {
        return $this->leadership;
    }

    public function setLeadership(int $leadership): static
    {
        $this->leadership = $leadership;

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

    public function isAlive(): ?bool
    {
        return $this->alive;
    }

    public function setAlive(bool $alive): static
    {
        $this->alive = $alive;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRating(): ?int
    {
        $weaponsCost = 0;
        $equipementsCost = 0;

        $weapons = $this->weapons;

        foreach ($weapons as $weapon){
            $weaponsCost += $weapon->getCost();
        }

       $equipements = $this->equipements;
       foreach ($equipements as $equipement){
           $equipementsCost += $equipement->getCost();
       }

        return $this->experience + $this->cost + $weaponsCost + $equipementsCost;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

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
            $injury->setVictim($this);
        }

        return $this;
    }

    public function removeInjury(Injury $injury): static
    {
        if ($this->injuries->removeElement($injury)) {
            // set the owning side to null (unless already changed)
            if ($injury->getVictim() === $this) {
                $injury->setVictim(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Weapon>
     */
    public function getWeapons(): Collection
    {
        return $this->weapons;
    }

    public function addWeapon(Weapon $weapon): static
    {
        if (!$this->weapons->contains($weapon)) {
            $this->weapons->add($weapon);
            $weapon->setGanger($this);
        }

        return $this;
    }

    public function removeWeapon(Weapon $weapon): static
    {
        if ($this->weapons->removeElement($weapon)) {
            // set the owning side to null (unless already changed)
            if ($weapon->getGanger() === $this) {
                $weapon->setGanger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->setGanger($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getGanger() === $this) {
                $equipement->setGanger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setGanger($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getGanger() === $this) {
                $skill->setGanger(null);
            }
        }

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

    public function getType(): ?GangerTypeEnum
    {
        return $this->type;
    }

    public function setType(GangerTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Advancement>
     */
    public function getAdvancement(): Collection
    {
        return $this->advancement;
    }

    public function addAdvancement(Advancement $advancement): static
    {
        if (!$this->advancement->contains($advancement)) {
            $this->advancement->add($advancement);
            $advancement->setGanger($this);
        }
            return $this;
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
            $game->addGanger($this);

        }

        return $this;
    }


    public function removeAdvancement(Advancement $advancement): static
    {
        if ($this->advancement->removeElement($advancement)) {
            // set the owning side to null (unless already changed)
            if ($advancement->getGanger() === $this) {
                $advancement->setGanger(null);
            }
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removeGanger($this);
        }

        return $this;
    }
}