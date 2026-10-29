<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $sujet = null;

    #[ORM\Column(length: 255)]
    private ?string $txt = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'La note doit être entre 1 et 5.', min: 1, max: 5)]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'avisUtilisateur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $userAvis = null;

    #[ORM\ManyToOne(inversedBy: 'avisEspace')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espace $espaceAvis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getTxt(): ?string
    {
        return $this->txt;
    }

    public function setTxt(string $txt): static
    {
        $this->txt = $txt;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUserAvis(): ?Utilisateur
    {
        return $this->userAvis;
    }

    public function setUserAvis(?Utilisateur $userAvis): static
    {
        $this->userAvis = $userAvis;

        return $this;
    }

    public function getEspaceAvis(): ?Espace
    {
        return $this->espaceAvis;
    }

    public function setEspaceAvis(?Espace $espaceAvis): static
    {
        $this->espaceAvis = $espaceAvis;

        return $this;
    }
}
