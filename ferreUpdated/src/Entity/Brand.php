<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
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
     * @ORM\Column(type="string", length=510, nullable=true)
     */
    private $logoLink;

    /**
     * @ORM\OneToMany(targetEntity=BrandProductRelation::class, mappedBy="brand")
     */
    private $brandProductRelations;

    public function __construct()
    {
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

    public function getLogoLink(): ?string
    {
        return $this->logoLink;
    }

    public function setLogoLink(string $logoLink): self
    {
        $this->logoLink = $logoLink;

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
            $brandProductRelation->setBrand($this);
        }

        return $this;
    }

    public function removeBrandProductRelation(BrandProductRelation $brandProductRelation): self
    {
        if ($this->brandProductRelations->removeElement($brandProductRelation)) {
            // set the owning side to null (unless already changed)
            if ($brandProductRelation->getBrand() === $this) {
                $brandProductRelation->setBrand(null);
            }
        }

        return $this;
    }
}
