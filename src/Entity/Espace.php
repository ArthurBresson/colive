<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspaceRepository::class)]
class Espace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    #[Assert\Length(
        min: 5,
        max: 5,
        exactMessage: 'Le code postal doit faire exactement {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]{5}$/',
        message: 'Le code postal doit être composé de 5 chiffres.'
    )]
    private ?string $cpEsp = null;
    #[ORM\Column(length: 50)]
    private ?string $adresseEsp = null;

    #[ORM\Column(length: 50)]
    private ?string $villeEsp = null;

    #[ORM\ManyToOne(inversedBy: 'espaces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeEspace $typeEspace = null;

    /**
     * @var Collection<int, Commodite>
     */
    #[ORM\ManyToMany(targetEntity: Commodite::class, inversedBy: 'espaces')]
    private Collection $commodites;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'espaces')]
    private Collection $utilisateurs;

    #[ORM\Column(length: 255)]
    private ?string $titreEsp = null;

    #[ORM\Column]
    private ?\DateTime $datePubliEsp = null;

    #[ORM\Column]
    private ?float $surface = null;

    #[ORM\Column(length: 255)]
    private ?string $descEsp = null;

    /**
     * @var Collection<int, PhotoEspace>
     */
    #[ORM\OneToMany(targetEntity: PhotoEspace::class, mappedBy: 'espace', cascade: ['remove'], orphanRemoval: true)]
    private Collection $photoEspaces;

    #[ORM\Column(type: 'integer')]
    private ?int $nbMaxColocEsp = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $availableFromEsp = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $availableToEsp = null;

    #[ORM\ManyToOne(inversedBy: 'espacesOwned')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $owner = null;

    #[ORM\Column]
    private ?int $tarif = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'espaceAvis', orphanRemoval: true)]
    private Collection $avisEspace;

    public function __construct()
    {
        $this->commodites = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->photoEspaces = new ArrayCollection();
        $this->avisEspace = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpEsp(): ?string
    {
        return $this->cpEsp;
    }

    public function setCpEsp(string $cpEsp): static
    {
        $this->cpEsp = $cpEsp;

        return $this;
    }

    public function getAdresseEsp(): ?string
    {
        return $this->adresseEsp;
    }

    public function setAdresseEsp(string $adresseEsp): static
    {
        $this->adresseEsp = $adresseEsp;

        return $this;
    }

    public function getVilleEsp(): ?string
    {
        return $this->villeEsp;
    }

    public function setVilleEsp(string $villeEsp): static
    {
        $this->villeEsp = $villeEsp;

        return $this;
    }

    public function getTypeEspace(): ?TypeEspace
    {
        return $this->typeEspace;
    }

    public function setTypeEspace(?TypeEspace $typeEspace): static
    {
        $this->typeEspace = $typeEspace;

        return $this;
    }

    /**
     * @return Collection<int, Commodite>
     */
    public function getCommodites(): Collection
    {
        return $this->commodites;
    }

    public function addCommodite(Commodite $commodite): static
    {
        if (!$this->commodites->contains($commodite)) {
            $this->commodites->add($commodite);
        }

        return $this;
    }

    public function removeCommodite(Commodite $commodite): static
    {
        $this->commodites->removeElement($commodite);

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addEspace($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeEspace($this);
        }

        return $this;
    }

    public function getTitreEsp(): ?string
    {
        return $this->titreEsp;
    }

    public function setTitreEsp(string $titreEsp): static
    {
        $this->titreEsp = $titreEsp;

        return $this;
    }

    public function getDatePubliEsp(): ?\DateTime
    {
        return $this->datePubliEsp;
    }

    public function setDatePubliEsp(\DateTime $datePubliEsp): static
    {
        $this->datePubliEsp = $datePubliEsp;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getDescEsp(): ?string
    {
        return $this->descEsp;
    }

    public function setDescEsp(string $descEsp): static
    {
        $this->descEsp = $descEsp;

        return $this;
    }

    /**
     * @return Collection<int, PhotoEspace>
     */
    public function getPhotoEspaces(): Collection
    {
        return $this->photoEspaces;
    }

    public function addPhotoEspace(PhotoEspace $photoEspace): static
    {
        if (!$this->photoEspaces->contains($photoEspace)) {
            $this->photoEspaces->add($photoEspace);
            $photoEspace->setEspace($this);
        }

        return $this;
    }

    public function removePhotoEspace(PhotoEspace $photoEspace): static
    {
        if ($this->photoEspaces->removeElement($photoEspace)) {
            // set the owning side to null (unless already changed)
            if ($photoEspace->getEspace() === $this) {
                $photoEspace->setEspace(null);
            }
        }

        return $this;
    }

    public function getNbMaxColocEsp(): ?int
    {
        return $this->nbMaxColocEsp;
    }

    public function setNbMaxColocEsp(int $nbMaxColocEsp): static
    {
        $this->nbMaxColocEsp = $nbMaxColocEsp;

        return $this;
    }

    public function getAvailableFromEsp(): ?\DateTime
    {
        return $this->availableFromEsp;
    }

    public function setAvailableFromEsp(\DateTime $availableFromEsp): static
    {
        $this->availableFromEsp = $availableFromEsp;

        return $this;
    }

    public function getAvailableToEsp(): ?\DateTime
    {
        return $this->availableToEsp;
    }

    public function setAvailableToEsp(\DateTime $availableToEsp): static
    {
        $this->availableToEsp = $availableToEsp;

        return $this;
    }

    public function getOwner(): ?Utilisateur
    {
        return $this->owner;
    }

    public function setOwner(?Utilisateur $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisEspace(): Collection
    {
        return $this->avisEspace;
    }

    public function addAvisEspace(Avis $avisEspace): static
    {
        if (!$this->avisEspace->contains($avisEspace)) {
            $this->avisEspace->add($avisEspace);
            $avisEspace->setEspaceAvis($this);
        }

        return $this;
    }

    public function removeAvisEspace(Avis $avisEspace): static
    {
        if ($this->avisEspace->removeElement($avisEspace)) {
            // set the owning side to null (unless already changed)
            if ($avisEspace->getEspaceAvis() === $this) {
                $avisEspace->setEspaceAvis(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        // On affiche le titre s'il existe, sinon l'adresse et la ville
        return $this->titreEsp ?? ($this->adresseEsp.' - '.$this->villeEsp);
    }
}
