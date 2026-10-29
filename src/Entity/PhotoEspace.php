<?php

namespace App\Entity;

use App\Repository\PhotoEspaceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoEspaceRepository::class)]
class PhotoEspace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'photoEspaces')]
    private ?Espace $espace = null;

    #[ORM\Column(type: Types::BLOB)]
    private mixed $img = null;

    #[ORM\Column(length: 10)]
    private ?string $imgType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEspace(): ?Espace
    {
        return $this->espace;
    }

    public function setEspace(?Espace $espace): static
    {
        $this->espace = $espace;

        return $this;
    }

    public function getImg(): mixed
    {
        if (is_resource($this->img)) {
            return stream_get_contents($this->img);
        }

        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getImgType(): ?string
    {
        return $this->imgType;
    }

    public function setImgType(string $imgType): static
    {
        $this->imgType = $imgType;

        return $this;
    }

    public function getBase64Img(): string
    {
        return 'data:'.$this->getImgType().';base64,'.base64_encode($this->getImg());
    }
}
