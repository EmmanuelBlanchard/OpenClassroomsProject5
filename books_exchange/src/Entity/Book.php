<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\Table(name="book", indexes={@ORM\Index(columns={"title", "summary"}, flags={"fulltext"})})
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un titre de livre")
     * @Assert\NotNull(message="Veuillez définir le titre du livre")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir la catégorie du livre")
     * @Assert\NotNull(message="Veuillez définir la catégorie du livre")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Publisher::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir l'éditeur du livre")
     * @Assert\NotNull(message="Veuillez définir l'éditeur du livre")
     */
    private $publisher;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir la langue du livre")
     * @Assert\NotNull(message="Veuillez définir la langue du livre")
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Format::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir un format de livre")
     * @Assert\NotNull(message="Veuillez définir un format de livre")
     */
    private $format;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir l'état du livre")
     * @Assert\NotNull(message="Veuillez définir l'état du livre")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir un auteur")
     * @Assert\NotNull(message="Veuillez définir un auteur")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez saisir un résumé")
     * @Assert\NotNull(message="Veuillez définir un résumé")
     */
    private $summary;

    /**
     * @ORM\Column(type="boolean")
     */
    private $exchangeRequest;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $exchangeRequestAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $userexchange;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageFilename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getExchangeRequest(): ?bool
    {
        return $this->exchangeRequest;
    }

    public function setExchangeRequest(bool $exchangeRequest): self
    {
        $this->exchangeRequest = $exchangeRequest;

        return $this;
    }

    public function getExchangeRequestAt(): ?\DateTimeInterface
    {
        return $this->exchangeRequestAt;
    }

    public function setExchangeRequestAt(\DateTimeInterface $exchangeRequestAt): self
    {
        $this->exchangeRequestAt = $exchangeRequestAt;

        return $this;
    }

    public function getUserexchange(): ?User
    {
        return $this->userexchange;
    }

    public function setUserexchange(?User $userexchange): self
    {
        $this->userexchange = $userexchange;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getImagePath()
    {
        return 'uploads/book_image/'.$this->getImageFilename();
    }
}
