<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Tgc\Realm\Pokemon\Repository\SetRepository;

#[ORM\Entity]
#[ORM\Table(name: "pokemon_set_translation")]
class SetTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 5)]
    private ?string $locale = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Set::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Set $set = null;

    public function id(): ?int
    {
        return $this->id;
    }

    public function locale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function set(): ?Set
    {
        return $this->set;
    }

    public function setSet(?Set $set): self
    {
        $this->set = $set;

        return $this;
    }
}
