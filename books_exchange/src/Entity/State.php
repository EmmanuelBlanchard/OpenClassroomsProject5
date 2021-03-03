<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sulg;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="states")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=State::class, mappedBy="parent")
     */
    private $states;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="state")
     */
    private $books;

    public function __construct()
    {
        $this->states = new ArrayCollection();
        $this->books = new ArrayCollection();
    }

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

    public function getSulg(): ?string
    {
        return $this->sulg;
    }

    public function setSulg(string $sulg): self
    {
        $this->sulg = $sulg;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(self $state): self
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setParent($this);
        }

        return $this;
    }

    public function removeState(self $state): self
    {
        if ($this->states->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getParent() === $this) {
                $state->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setState($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getState() === $this) {
                $book->setState(null);
            }
        }

        return $this;
    }
}
