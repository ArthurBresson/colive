<?php

namespace App\Entity;

use App\Repository\TypeEspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeEspaceRepository::class)]
class TypeEspace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cdTpEspace = null;

    #[ORM\Column(length: 25)]
    private ?string $tpEspLib = null;

    /**
     * @var Collection<int, Espace>
     */
    #[ORM\OneToMany(targetEntity: Espace::class, mappedBy: 'typeEspace')]
    private Collection $espaces;

    public function __construct()
    {
        $this->espaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCdTpEspace(): ?int
    {
        return $this->cdTpEspace;
    }

    public function setCdTpEspace(int $cdTpEspace): static
    {
        $this->cdTpEspace = $cdTpEspace;

        return $this;
    }

    public function getTpEspLib(): ?string
    {
        return $this->tpEspLib;
    }

    public function setTpEspLib(string $tpEspLib): static
    {
        $this->tpEspLib = $tpEspLib;

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
            $espace->setTypeEspace($this);
        }

        return $this;
    }

    public function removeEspace(Espace $espace): static
    {
        if ($this->espaces->removeElement($espace)) {
            // set the owning side to null (unless already changed)
            if ($espace->getTypeEspace() === $this) {
                $espace->setTypeEspace(null);
            }
        }

        return $this;
    }
}
