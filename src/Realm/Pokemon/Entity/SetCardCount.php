<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tgc\Realm\Pokemon\Repository\SetCardCountRepository;

#[ORM\Entity(repositoryClass: SetCardCountRepository::class)]
#[ORM\Table(name: "pokemon_set_card_count")]
class SetCardCount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $firstEdition = 0;

    #[ORM\Column]
    private ?int $holo = 0;

    #[ORM\Column]
    private ?int $normal = 0;

    #[ORM\Column]
    private ?int $official = 0;

    #[ORM\Column]
    private ?int $reverse = 0;

    #[ORM\Column]
    private ?int $total = 0;

    #[ORM\OneToOne(targetEntity: Set::class, inversedBy: 'setCardCount')]
    #[ORM\JoinColumn(name: 'set_id', referencedColumnName: 'id')]
    private ?Set $set = null;

    public function id(): ?int
    {
        return $this->id;
    }

    public function firstEdition(): ?int
    {
        return $this->firstEdition;
    }

    public function setFirstEdition(int $firstEdition): static
    {
        $this->firstEdition = $firstEdition;

        return $this;
    }

    public function holo(): ?int
    {
        return $this->holo;
    }

    public function setHolo(int $holo): static
    {
        $this->holo = $holo;

        return $this;
    }

    public function normal(): ?int
    {
        return $this->normal;
    }

    public function setNormal(int $normal): static
    {
        $this->normal = $normal;

        return $this;
    }

    public function official(): ?int
    {
        return $this->official;
    }

    public function setOfficial(int $official): static
    {
        $this->official = $official;

        return $this;
    }

    public function reverse(): ?int
    {
        return $this->reverse;
    }

    public function setReverse(int $reverse): static
    {
        $this->reverse = $reverse;

        return $this;
    }

    public function total(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function set(): ?Set
    {
        return $this->set;
    }

    public function setSet(Set $set): static
    {
        $this->set = $set;
        if ($this !== $set->setCardCount()) {
            $set->setSetCardCount($this);
        }

        return $this;
    }
}