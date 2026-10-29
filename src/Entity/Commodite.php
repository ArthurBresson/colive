<?php

namespace App\Entity;

use App\Repository\CommoditeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommoditeRepository::class)]
class Commodite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nomCom = null;

    /**
     * @var Collection<int, Espace>
     */
    #[ORM\ManyToMany(targetEntity: Espace::class, mappedBy: 'commodites')]
    private Collection $espaces;

    public function __construct()
    {
        $this->espaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNomCom(): ?string
    {
        return $this->nomCom;
    }

    public function setNomCom(string $nomCom): static
    {
        $this->nomCom = $nomCom;

        return $this;
    }

    /**
     * @return Collection<int, Espace>
     */
    public function getEspaces(): Collection
    {
        return $this->espaces;
    }

    public function addEspace(Espace $espace): static
    {
        if (!$this->espaces->contains($espace)) {
            $this->espaces->add($espace);
            $espace->addCommodite($this);
        }

        return $this;
    }

    public function removeEspace(Espace $espace): static
    {
        if ($this->espaces->removeElement($espace)) {
            $espace->removeCommodite($this);
        }

        return $this;
    }
}
