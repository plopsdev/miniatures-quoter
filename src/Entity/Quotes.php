<?php

namespace App\Entity;

use App\Repository\QuotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotesRepository::class)
 */
class Quotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, inversedBy="quotes", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=States::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $colorScheme;

    /**
     * @ORM\OneToMany(targetEntity=MiniaturesGroups::class, mappedBy="quote")
     */
    private $miniaturesGroups;

    public function __construct()
    {
        $this->miniaturesGroups = new ArrayCollection(); //tableau +++
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getState(): ?states
    {
        return $this->state;
    }

    public function setState(states $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getColorScheme(): ?string
    {
        return $this->colorScheme;
    }

    public function setColorScheme(string $colorScheme): self
    {
        $this->colorScheme = $colorScheme;

        return $this;
    }

    /**
     * @return Collection|MiniaturesGroups[]
     */
    public function getMiniaturesGroups(): Collection
    {
        return $this->miniaturesGroups;
    }

    public function addMiniaturesGroup(MiniaturesGroups $miniaturesGroup): self
    {
        if (!$this->miniaturesGroups->contains($miniaturesGroup)) {
            $this->miniaturesGroups[] = $miniaturesGroup;
            $miniaturesGroup->setQuote($this);
        }

        return $this;
    }

    public function removeMiniaturesGroup(MiniaturesGroups $miniaturesGroup): self
    {
        if ($this->miniaturesGroups->removeElement($miniaturesGroup)) {
            // set the owning side to null (unless already changed)
            if ($miniaturesGroup->getQuote() === $this) {
                $miniaturesGroup->setQuote(null);
            }
        }

        return $this;
    }
}
