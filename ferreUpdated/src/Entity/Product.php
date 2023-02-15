<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\Column(type="string", length=780, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=510)
     */
    private $imageLink;

    /**
     * @ORM\OneToMany(targetEntity=FamilyProductRelation::class, mappedBy="product")
     */
    private $familyProductRelations;

    /**
     * @ORM\OneToMany(targetEntity=BrandProductRelation::class, mappedBy="product")
     */
    private $brandProductRelations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inStock;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedDate;

    public function __construct()
    {
        $this->familyProductRelations = new ArrayCollection();
        $this->brandProductRelations = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * @return Collection|FamilyProductRelation[]
     */
    public function getFamilyProductRelations(): Collection
    {
        return $this->familyProductRelations;
    }

    public function addFamilyProductRelation(FamilyProductRelation $familyProductRelation): self
    {
        if (!$this->familyProductRelations->contains($familyProductRelation)) {
            $this->familyProductRelations[] = $familyProductRelation;
            $familyProductRelation->setProduct($this);
        }

        return $this;
    }

    public function removeFamilyProductRelation(FamilyProductRelation $familyProductRelation): self
    {
        if ($this->familyProductRelations->removeElement($familyProductRelation)) {
            // set the owning side to null (unless already changed)
            if ($familyProductRelation->getProduct() === $this) {
                $familyProductRelation->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BrandProductRelation[]
     */
    public function getBrandProductRelations(): Collection
    {
        return $this->brandProductRelations;
    }

    public function addBrandProductRelation(BrandProductRelation $brandProductRelation): self
    {
        if (!$this->brandProductRelations->contains($brandProductRelation)) {
            $this->brandProductRelations[] = $brandProductRelation;
            $brandProductRelation->setProduct($this);
        }

        return $this;
    }

    public function removeBrandProductRelation(BrandProductRelation $brandProductRelation): self
    {
        if ($this->brandProductRelations->removeElement($brandProductRelation)) {
            // set the owning side to null (unless already changed)
            if ($brandProductRelation->getProduct() === $this) {
                $brandProductRelation->setProduct(null);
            }
        }

        return $this;
    }

    public function getInStock(): ?bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?\DateTimeInterface $updatedDate): self
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }
}
