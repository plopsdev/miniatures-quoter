<?php

namespace App\Entity;

use App\Repository\MiniaturesGroupsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MiniaturesGroupsRepository::class)
 */
class MiniaturesGroups
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=quotes::class, inversedBy="miniaturesGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quote;

    /**
     * @ORM\OneToOne(targetEntity=scales::class, inversedBy="miniaturesGroups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $scale;

    /**
     * @ORM\OneToOne(targetEntity=qualities::class, inversedBy="miniaturesGroups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $quality;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wantBuilt;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuote(): ?quotes
    {
        return $this->quote;
    }

    public function setQuote(?quotes $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getScale(): ?scales
    {
        return $this->scale;
    }

    public function setScale(scales $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getQuality(): ?qualities
    {
        return $this->quality;
    }

    public function setQuality(qualities $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getWantBuilt(): ?bool
    {
        return $this->wantBuilt;
    }

    public function setWantBuilt(bool $wantBuilt): self
    {
        $this->wantBuilt = $wantBuilt;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
