<?php

namespace App\Entity;

use App\Repository\MiniaturesGroupsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MiniaturesGroupsRepository::class)
 */
class MiniaturesGroups
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("quotes_by_id:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quotes::class, inversedBy="miniaturesGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quote;

    /**
     * @ORM\ManyToOne(targetEntity=Scales::class, inversedBy="miniaturesGroups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("quotes_by_id:read")
     */
    private $scale;

    /**
     * @ORM\ManyToOne(targetEntity=Qualities::class, inversedBy="miniaturesGroups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("quotes_by_id:read")
     */
    private $quality;

    /**
     * @ORM\Column(type="integer")
     * @Groups("quotes_by_id:read")
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("quotes_by_id:read")
     */
    private $wantBuilt;

    /**
     * @ORM\Column(type="string", length=32)
     * @Assert\Length(min=5, max=32)
     * @Groups("quotes_by_id:read")
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     * @Groups("quotes_by_id:read")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     * @Groups("quotes_by_id:read")
     */
    private $name;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
