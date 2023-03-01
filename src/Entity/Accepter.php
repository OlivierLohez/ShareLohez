<?php

namespace App\Entity;

use App\Repository\AccepterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccepterRepository::class)
 */
class Accepter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accepters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accepters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cible;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accepters")
     */



    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?User
    {
        return $this->source;
    }

    public function setSource(?User $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getCible(): ?User
    {
        return $this->cible;
    }

    public function setCible(?User $cible): self
    {
        $this->cible = $cible;

        return $this;
    }

}
