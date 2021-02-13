<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Quotes::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $quotes;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $mail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuotes(): ?Quotes
    {
        return $this->quotes;
    }

    public function setQuotes(Quotes $quotes): self
    {
        // set the owning side of the relation if necessary
        if ($quotes->getUser() !== $this) {
            $quotes->setUser($this);
        }

        $this->quotes = $quotes;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
