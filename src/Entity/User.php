<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FieldProcessing", mappedBy="user")
     */
    private $fieldProcessings;

    public function __construct()
    {
        $this->isActive         = true;
        $this->fieldProcessings = new ArrayCollection();
        // may not be needed, see section on salt below
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;

    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
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
            $fieldProcessing->setUser($this);
        }

        return $this;
    }

    public function removeFieldProcessing(FieldProcessing $fieldProcessing): self
    {
        if ($this->fieldProcessings->contains($fieldProcessing)) {
            $this->fieldProcessings->removeElement($fieldProcessing);
            // set the owning side to null (unless already changed)
            if ($fieldProcessing->getUser() === $this) {
                $fieldProcessing->setUser(null);
            }
        }

        return $this;
    }
}