<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="proprietaire")
     */
    private $fichiers;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Dateinscription;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="users")
     */
    private $inviter;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="inviter")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Accepter::class, mappedBy="source", orphanRemoval=true)
     */
    private $accepters;

    /**
     * @ORM\ManyToMany(targetEntity=Fichier::class, mappedBy="user")
     */
    private $fichier;

    /**
     * @ORM\OneToMany(targetEntity=Telecharger::class, mappedBy="user", orphanRemoval=true)
     */
    private $telechargers;
    

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->inviter = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->accepters = new ArrayCollection();
        $this->fichier = new ArrayCollection();
        $this->telechargers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setProprietaire($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getProprietaire() === $this) {
                $fichier->setProprietaire(null);
            }
        }

        return $this;
    }

    public function getDateinscription(): ?\DateTimeInterface
    {
        return $this->Dateinscription;
    }

    public function setDateinscription(\DateTimeInterface $Dateinscription): self
    {
        $this->Dateinscription = $Dateinscription;
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getInviter(): Collection
    {
        return $this->inviter;
    }

    public function addInviter(self $inviter): self
    {
        if (!$this->inviter->contains($inviter)) {
            $this->inviter[] = $inviter;
        }

        return $this;
    }

    public function removeInviter(self $inviter): self
    {
        $this->inviter->removeElement($inviter);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addInviter($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeInviter($this);
        }

        return $this;
    }

    /**
     * @return Collection|Accepter[]
     */
    public function getAccepters(): Collection
    {
        return $this->accepters;
    }

    public function addAccepter(Accepter $accepter): self
    {
        if (!$this->accepters->contains($accepter)) {
            $this->accepters[] = $accepter;
            $accepter->setSource($this);
        }

        return $this;
    }

    public function removeAccepter(Accepter $accepter): self
    {
        if ($this->accepters->removeElement($accepter)) {
            // set the owning side to null (unless already changed)
            if ($accepter->getSource() === $this) {
                $accepter->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichier(): Collection
    {
        return $this->fichier;
    }

    /**
     * @return Collection|Telecharger[]
     */
    public function getTelechargers(): Collection
    {
        return $this->telechargers;
    }

    public function addTelecharger(Telecharger $telecharger): self
    {
        if (!$this->telechargers->contains($telecharger)) {
            $this->telechargers[] = $telecharger;
            $telecharger->setUser($this);
        }

        return $this;
    }

    public function removeTelecharger(Telecharger $telecharger): self
    {
        if ($this->telechargers->removeElement($telecharger)) {
            // set the owning side to null (unless already changed)
            if ($telecharger->getUser() === $this) {
                $telecharger->setUser(null);
            }
        }

        return $this;
    }
}
