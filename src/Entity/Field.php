<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldRepository")
 */
class Field
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FieldProcessing", mappedBy="field")
     */
    private $fieldProcessings;


    public function __construct()
    {
        $this->fieldProcessings = new ArrayCollection();
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

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection|FieldProcessing[]
     */
    public function getFieldProcessings(): Collection
    {
        return $this->fieldProcessings;
    }

    public function addFieldProcessing(FieldProcessing $fieldProcessing): self
    {
        if (!$this->fieldProcessings->contains($fieldProcessing)) {
            $this->fieldProcessings[] = $fieldProcessing;
            $fieldProcessing->setField($this);
        }

        return $this;
    }

    public function removeFieldProcessing(FieldProcessing $fieldProcessing): self
    {
        if ($this->fieldProcessings->contains($fieldProcessing)) {
            $this->fieldProcessings->removeElement($fieldProcessing);
            // set the owning side to null (unless already changed)
            if ($fieldProcessing->getField() === $this) {
                $fieldProcessing->setField(null);
            }
        }

        return $this;
    }
}
