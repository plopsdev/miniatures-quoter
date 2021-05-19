<?php

namespace App\Entity;

use App\Repository\ScalesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ScalesRepository::class)
 */
class Scales
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity=MiniaturesGroups::class, mappedBy="scale")
     */
    private $miniaturesGroups;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $paintPrice;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $buildPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMiniaturesGroups(): ?MiniaturesGroups
    {
        return $this->miniaturesGroups;
    }

    public function setMiniaturesGroups(MiniaturesGroups $miniaturesGroups): self
    {
        // set the owning side of the relation if necessary
        if ($miniaturesGroups->getScale() !== $this) {
            $miniaturesGroups->setScale($this);
        }

        $this->miniaturesGroups = $miniaturesGroups;

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

    public function getPaintPrice(): ?int
    {
        return $this->paintPrice;
    }

    public function setPaintPrice(int $paintPrice): self
    {
        $this->paintPrice = $paintPrice;

        return $this;
    }

    public function getBuildPrice(): ?int
    {
        return $this->buildPrice;
    }

    public function setBuildPrice(int $buildPrice): self
    {
        $this->buildPrice = $buildPrice;

        return $this;
    }
}
