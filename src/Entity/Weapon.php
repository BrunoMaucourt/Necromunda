<?php

namespace App\Entity;

use App\Enum\WeaponsEnum;
use App\Repository\WeaponsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: WeaponsRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?WeaponsEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'weapons')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ganger $ganger = null;

    #[ORM\Column]
    private ?int $cost = 0;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\OneToMany(targetEntity: Equipement::class, mappedBy: 'weapon')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $equipements;

    #[ORM\ManyToOne(inversedBy: 'weapons')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Gang $stash = null;

    private ?bool $free = false;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addConstraint(new Assert\Callback('validateGangerOrGang'));
    }

    public function validateGangerOrGang(ExecutionContextInterface $context): void
    {
        if ($this->ganger === null && $this->stash === null) {
            $context->buildViolation('A weapon must be associated with either a Ganger or a Gang.')
                ->atPath('ganger')
                ->addViolation();
        }
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
            $equipement->setWeapon($this);
        }

        return $this;
    }


    public function removeEquipement(Equipement $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getWeapon() === $this) {
                $equipement->setWeapon(null);
            }
        }

        return $this;
    }

    public function getStash(): ?Gang
    {
        return $this->stash;
    }

    public function setStash(?Gang $stash): static
    {
        $this->stash = $stash;

        return $this;
    }

    public function isFree(): ?bool
    {
        return $this->free;
    }

    public function setFree(bool $free): static
    {
        $this->free = $free;

        return $this;
    }
}