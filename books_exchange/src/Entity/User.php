<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte avec cette adresse e-mail")
 * @UniqueEntity(fields={"pseudo"}, message="Il existe déjà un compte avec ce pseudo")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un e-mail",
     * )
     * @Assert\Email(
     *     message = "L'e-mail '{{ value }}' n'est pas un e-mail valide.",
     *     mode = "strict",
     *     normalizer = "trim"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="user")
     */
    private $books;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut pas contenir un nombre"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-ZÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]'?[- a-zA-ZéèàêâùïüëçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]+$/",
     *      match=true,
     *     message="Votre nom doit contenir une lettre majuscule en première lettre"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœ])*[-'\s]{0,1}(([a-zàâäçéèêëîïôöùûüÿæœ]+)[-'\s]{0,1})*$/",
     *     match=true,
     *     message="Votre prénom doit contenir une lettre majuscule pour le premier caractère puis des lettres minuscules (les caractères espace, apostrophe, tiret sont autorisés entre deux prénoms)"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=16, unique=true)
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un pseudo",
     * )
     * @Assert\Length(
     *      min = 7,
     *      max = 15,
     *      minMessage = "Votre pseudo doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Votre pseudo ne peut pas comporter plus de {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *     pattern="/^([-\S\w]{7,15})$/",
     *     match=true,
     *     message="Votre pseudo doit contenir entre 7 et 15 caractères (les caractères - et _ sont autorisés, pas pas le caractère espace)"
     * )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *      message = "Veuillez saisir un code postal",
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Votre code postal doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Votre code postal ne peut pas comporter plus de {{ limit }} caractères",
     *      exactMessage = "Votre code postal doit comporter exactement {{ limit }} caractères.",
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]{5}$/",
     *     match=true,
     *     message="Votre code postal doit contenir cinq chiffres"
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=170)
     * @Assert\NotBlank(
     *      message = "Veuillez saisir une ville",
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Votre ville doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Votre ville ne peut pas comporter plus de {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/",
     *     match=true,
     *     message="Votre ville ne doit contenir que des caractères minuscules, majuscules et tirets"
     * )
     */
    private $city;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
