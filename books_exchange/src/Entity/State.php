<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Type(
     *     type="string",
     *     message="La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\NotBlank(message = "Veuillez saisir le nom de l'état du livre")
     * @Assert\NotNull(message="Veuillez définir le nom de l'état du livre")
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Le nom de l'état du livre doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de l'état du livre ne peut pas comporter plus de {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]$/",
     *     match=false,
     *     message="Le nom de l'état du livre ne peut pas comporter des chiffres"
     * )
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
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

    public function __toString()
    {
        return $this->name;
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
