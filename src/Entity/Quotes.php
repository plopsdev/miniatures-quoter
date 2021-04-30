<?php

namespace App\Entity;

use App\Repository\QuotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuotesRepository::class)
 */
class Quotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("quotes:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("quotes:read")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\Length(min=5, max=64)
     * @Groups("quotes:read")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("quotes:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\Length(max=64)
     * @Groups("quotes:read")
     */
    private $colorScheme;

    /**
     * @ORM\OneToMany(targetEntity=MiniaturesGroups::class, mappedBy="quote")
     * @Groups("quotes_by_id:read")
     */
    private $miniaturesGroups;
    /**
     * @ORM\ManyToOne(targetEntity=States::class, inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("quotes:read")
     */
    private $state;

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

    public function getState(): ?States
    {
        return $this->state;
    }

    public function setState(States $state): self
    {
        $this->state = $state;

        return $this;
    }
}
