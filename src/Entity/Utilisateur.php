<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nomUtil = null;

    #[ORM\Column(length: 50)]
    private ?string $prenomUtil = null;

    #[ORM\Column(length: 5)]
    private ?string $cpUtil = null;

    #[ORM\Column(length: 50)]
    private ?string $adresseUtil = null;

    #[ORM\Column(length: 50)]
    private ?string $villeUtil = null;

    /**
     * @var Collection<int, Espace>
     */
    #[ORM\ManyToMany(targetEntity: Espace::class, inversedBy: 'utilisateurs')]
    private Collection $espaces;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'followers')]
    #[ORM\JoinTable(name: 'utilisateur_utilisateur')]
    #[ORM\JoinColumn(name: 'utilisateur_source', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'utilisateur_target', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $following;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'following')]
    private Collection $followers;

    /**
     * @var Collection<int, Conversation>
     */
    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'participants')]
    private Collection $conversations;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'sender')]
    private Collection $messages;

    /**
     * @var Collection<int, Espace>
     */
    #[ORM\OneToMany(targetEntity: Espace::class, mappedBy: 'owner')]
    private Collection $espacesOwned;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'userAvis', orphanRemoval: true)]
    private Collection $avisUtilisateur;

    public function __construct()
    {
        $this->espaces = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->espacesOwned = new ArrayCollection();
        $this->avisUtilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getNomUtil(): ?string
    {
        return $this->nomUtil;
    }

    public function setNomUtil(string $nomUtil): static
    {
        $this->nomUtil = $nomUtil;

        return $this;
    }

    public function getPrenomUtil(): ?string
    {
        return $this->prenomUtil;
    }

    public function setPrenomUtil(string $prenomUtil): static
    {
        $this->prenomUtil = $prenomUtil;

        return $this;
    }

    public function getCpUtil(): ?string
    {
        return $this->cpUtil;
    }

    public function setCpUtil(string $cpUtil): static
    {
        $this->cpUtil = $cpUtil;

        return $this;
    }

    public function getAdresseUtil(): ?string
    {
        return $this->adresseUtil;
    }

    public function setAdresseUtil(string $adresseUtil): static
    {
        $this->adresseUtil = $adresseUtil;

        return $this;
    }

    public function getVilleUtil(): ?string
    {
        return $this->villeUtil;
    }

    public function setVilleUtil(string $villeUtil): static
    {
        $this->villeUtil = $villeUtil;

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
        }

        return $this;
    }

    public function removeEspace(Espace $espace): static
    {
        $this->espaces->removeElement($espace);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollowing(): Collection
    {
        return $this->following;
    }

    public function addFollowing(self $user): static
    {
        if (!$this->following->contains($user)) {
            $this->following->add($user);
        }

        return $this;
    }

    public function removeFollowing(self $user): static
    {
        $this->following->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->addParticipant($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            $conversation->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Espace>
     */
    public function getEspacesOwned(): Collection
    {
        return $this->espacesOwned;
    }

    public function addEspacesOwned(Espace $espacesOwned): static
    {
        if (!$this->espacesOwned->contains($espacesOwned)) {
            $this->espacesOwned->add($espacesOwned);
            $espacesOwned->setOwner($this);
        }

        return $this;
    }

    public function removeEspacesOwned(Espace $espacesOwned): static
    {
        if ($this->espacesOwned->removeElement($espacesOwned)) {
            // set the owning side to null (unless already changed)
            if ($espacesOwned->getOwner() === $this) {
                $espacesOwned->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisUtilisateur(): Collection
    {
        return $this->avisUtilisateur;
    }

    public function addAvisUtilisateur(Avis $avisUtilisateur): static
    {
        if (!$this->avisUtilisateur->contains($avisUtilisateur)) {
            $this->avisUtilisateur->add($avisUtilisateur);
            $avisUtilisateur->setUserAvis($this);
        }

        return $this;
    }

    public function removeAvisUtilisateur(Avis $avisUtilisateur): static
    {
        if ($this->avisUtilisateur->removeElement($avisUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($avisUtilisateur->getUserAvis() === $this) {
                $avisUtilisateur->setUserAvis(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenomUtil.' '.$this->nomUtil.' ('.$this->email.')';
    }
}
