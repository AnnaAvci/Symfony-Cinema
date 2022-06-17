<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 */
class Actor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name_actor;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname_actor;

    /**
     * @ORM\Column(type="date")
     */
    private $dob_actor;

    /**
     * @ORM\OneToMany(targetEntity=Casting::class, mappedBy="actor", orphanRemoval=true)
     */
    private $castings;

    public function __construct()
    {
        $this->castings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameActor(): ?string
    {
        return $this->name_actor;
    }

    public function setNameActor(string $name_actor): self
    {
        $this->name_actor = $name_actor;

        return $this;
    }

    public function getSurnameActor(): ?string
    {
        return $this->surname_actor;
    }

    public function setSurnameActor(string $surname_actor): self
    {
        $this->surname_actor = $surname_actor;

        return $this;
    }

    public function getDobActor(): ?\DateTimeInterface
    {
        return $this->dob_actor;
    }

    public function setDobActor(\DateTimeInterface $dob_actor): self
    {
        $this->dob_actor = $dob_actor;

        return $this;
    }

    public function __toString(){
        return $this->name_actor.' '.$this->surname_actor;
    }

    /**
     * @return Collection<int, Casting>
     */
    public function getCastings(): Collection
    {
        return $this->castings;
    }

    public function addCasting(Casting $casting): self
    {
        if (!$this->castings->contains($casting)) {
            $this->castings[] = $casting;
            $casting->setActor($this);
        }

        return $this;
    }

    public function removeCasting(Casting $casting): self
    {
        if ($this->castings->removeElement($casting)) {
            // set the owning side to null (unless already changed)
            if ($casting->getActor() === $this) {
                $casting->setActor(null);
            }
        }

        return $this;
    }
}
