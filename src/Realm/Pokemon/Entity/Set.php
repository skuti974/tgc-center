<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Tgc\Entity\Media;
use Tgc\Realm\Pokemon\Repository\SetRepository;

#[ORM\Entity(repositoryClass: SetRepository::class)]
#[ORM\Table(name: "pokemon_set")]
class Set
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $code = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private ?DateTimeImmutable $releasedAt = null;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    private ?Media $logo = null;

    #[ORM\OneToOne(targetEntity: SetCardCount::class, mappedBy: 'set')]
    private ?SetCardCount $setCardCount = null;

    #[ORM\OneToMany(targetEntity: SetTranslation::class, mappedBy: 'set', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function releasedAt(): ?DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(DateTimeImmutable $releasedAt): static
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function logo(): ?Media
    {
        return $this->logo;
    }

    public function setLogo(?Media $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function setCardCount(): ?SetCardCount
    {
        return $this->setCardCount;
    }

    public function setSetCardCount(SetCardCount $setCardCount): static
    {
        $this->setCardCount = $setCardCount;
        if ($this !== $setCardCount->set()) {
            $setCardCount->setSet($this);
        }

        return $this;
    }

    /**
     * @return Collection|SetTranslation[]
     */
    public function translations(): Collection
    {
        return $this->translations;
    }

    public function localizedTranslation(string $locale): ?SerieTranslation
    {
        foreach ($this->translations() as $translation) {
            if ($translation->locale() === $locale) {
                return $translation;
            }
        }

        return null;
    }

    public function addTranslation(SetTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setSet($this);
        }

        return $this;
    }

    public function removeTranslation(SetTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            if ($translation->set() === $this) {
                $translation->setSet(null);
            }
        }

        return $this;
    }
}
