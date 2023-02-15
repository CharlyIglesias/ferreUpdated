<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilyRepository::class)
 */
class Family
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
     * @ORM\OneToMany(targetEntity=FamilyProductRelation::class, mappedBy="familyId")
     */
    private $familyProductRelations;

    public function __construct()
    {
        $this->familyProductRelations = new ArrayCollection();
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
            $familyProductRelation->setFamilyId($this);
        }

        return $this;
    }

    public function removeFamilyProductRelation(FamilyProductRelation $familyProductRelation): self
    {
        if ($this->familyProductRelations->removeElement($familyProductRelation)) {
            // set the owning side to null (unless already changed)
            if ($familyProductRelation->getFamilyId() === $this) {
                $familyProductRelation->setFamilyId(null);
            }
        }

        return $this;
    }
}
