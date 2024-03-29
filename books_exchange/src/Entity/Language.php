<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
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
     * @Assert\NotBlank(message = "Veuillez saisir le nom de la langue")
     * @Assert\NotNull(message="Veuillez définir le nom de la langue")
     * @Assert\Length(
     *      min = 1,
     *      max = 30,
     *      minMessage = "Le nom de la langue doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la langue ne peut pas comporter plus de {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]$/",
     *     match=false,
     *     message="Le nom de la langue ne peut pas comporter des chiffres"
     * )
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="languages")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Language::class, mappedBy="parent")
     */
    private $languages;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="language")
     */
    private $books;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
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
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(self $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
            $language->setParent($this);
        }

        return $this;
    }

    public function removeLanguage(self $language): self
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getParent() === $this) {
                $language->setParent(null);
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
            $book->setLanguage($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getLanguage() === $this) {
                $book->setLanguage(null);
            }
        }

        return $this;
    }
}
