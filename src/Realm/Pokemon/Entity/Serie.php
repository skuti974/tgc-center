<?php

namespace Tgc\Realm\Pokemon\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Tgc\Entity\Media;
use Tgc\Realm\Pokemon\Repository\SerieRepository;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
#[ORM\Table(name: "pokemon_serie")]
#[Gedmo\TranslationEntity(class: SerieTranslation::class)]
class Serie implements Translatable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $code = null;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ['persist', 'remove'])]
    private ?Media $logo = null;

    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: SerieTranslation::class, cascade: ['persist', 'remove'])]
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

    public function logo(): ?Media
    {
        return $this->logo;
    }

    public function setLogo(?Media $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|SerieTranslation[]
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

    public function addTranslation(SerieTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setSerie($this);
        }

        return $this;
    }

    public function removeTranslation(SerieTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            if ($translation->serie() === $this) {
                $translation->setSerie(null);
            }
        }

        return $this;
    }
}