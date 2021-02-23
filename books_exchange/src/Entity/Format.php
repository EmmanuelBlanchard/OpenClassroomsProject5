<?php

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormatRepository::class)
 */
class Format
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
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Format::class, inversedBy="formats")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Format::class, mappedBy="parent")
     */
    private $formats;

    public function __construct()
    {
        $this->formats = new ArrayCollection();
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

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
    public function getFormats(): Collection
    {
        return $this->formats;
    }

    public function addFormat(self $format): self
    {
        if (!$this->formats->contains($format)) {
            $this->formats[] = $format;
            $format->setParent($this);
        }

        return $this;
    }

    public function removeFormat(self $format): self
    {
        if ($this->formats->removeElement($format)) {
            // set the owning side to null (unless already changed)
            if ($format->getParent() === $this) {
                $format->setParent(null);
            }
        }

        return $this;
    }
}
