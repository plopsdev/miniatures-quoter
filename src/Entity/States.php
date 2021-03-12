<?php

namespace App\Entity;

use App\Repository\StatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatesRepository::class)
 */
class States
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Quotes::class, mappedBy="state", cascade={"persist", "remove"})
     */
    private $quotes;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuotes(): ?Quotes
    {
        return $this->quotes;
    }

    public function setQuotes(Quotes $quotes): self
    {
        // set the owning side of the relation if necessary
        if ($quotes->getState() !== $this) {
            $quotes->setState($this);
        }

        $this->quotes = $quotes;

        return $this;
    }
}
