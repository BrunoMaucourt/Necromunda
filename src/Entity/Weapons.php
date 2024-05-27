<?php

namespace App\Entity;

use App\Enum\WeaponsEnum;
use App\Repository\WeaponsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponsRepository::class)]
class Weapons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?WeaponsEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'weapons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $ganger = null;

    #[ORM\Column]
    private ?int $cost = 0;

    /**
     * @var Collection<int, Equipements>
     */
    #[ORM\OneToMany(targetEntity: Equipements::class, mappedBy: 'weapon')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $equipements;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?WeaponsEnum
    {
        return $this->name;
    }

    public function setName(WeaponsEnum $name): static
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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return Collection<int, Equipements>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipements $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->setWeapon($this);
        }

        return $this;
    }


    public function removeEquipement(Equipements $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getWeapon() === $this) {
                $equipement->setWeapon(null);
            }
        }

        return $this;
    }
}