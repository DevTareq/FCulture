<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldProcessingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class FieldProcessing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tractor", inversedBy="fieldProcessings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tractor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Field", inversedBy="fieldProcessings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crop", inversedBy="fieldProcessings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crop;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fieldProcessings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getTractor(): ?Tractor
    {
        return $this->tractor;
    }

    public function setTractor(?Tractor $tractor): self
    {
        $this->tractor = $tractor;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getCrop(): ?Crop
    {
        return $this->crop;
    }

    public function setCrop(?Crop $crop): self
    {
        $this->crop = $crop;

        return $this;
    }

    /**
     * Tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getDate() == null) {
            $this->setDate(new \DateTime());
        }
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
}
