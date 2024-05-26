<?php

namespace App\Entity;

use App\Enum\InjuriesEnum;
use App\Repository\InjuriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InjuriesRepository::class)]
class Injuries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: InjuriesEnum::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?InjuriesEnum $name = null;

    #[ORM\ManyToOne(inversedBy: 'injuries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ganger $victim = null;

    #[ORM\ManyToOne(inversedBy: 'injuries')]
    private ?Ganger $author = null;

    public function __toString(): string
    {
        return $this->name->enumToString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?InjuriesEnum
    {
        return $this->name;
    }

    public function setName(InjuriesEnum $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getVictim(): ?Ganger
    {
        return $this->victim;
    }

    public function setVictim(?Ganger $victim): static
    {
        $this->victim = $victim;

        return $this;
    }

    public function getAuthor(): ?Ganger
    {
        return $this->author;
    }

    public function setAuthor(?Ganger $author): static
    {
        $this->author = $author;

        return $this;
    }
}