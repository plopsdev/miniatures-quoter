<?php

namespace App\Entity;

use App\Repository\QualitiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QualitiesRepository::class)
 */
class Qualities
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity=MiniaturesGroups::class, mappedBy="quality")
     */
    private $miniaturesGroups;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"quotes_by_id:read", "scales-qualities:read"})
     */
    private $priceMultiplier;

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
        if ($miniaturesGroups->getQuality() !== $this) {
            $miniaturesGroups->setQuality($this);
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

    public function getPriceMultiplier(): ?float
    {
        return $this->priceMultiplier;
    }

    public function setPriceMultiplier(float $priceMultiplier): self
    {
        $this->priceMultiplier = $priceMultiplier;

        return $this;
    }

}
