<?php

namespace App\Entity;

use App\Repository\DirectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectorRepository::class)
 */
class Director
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
    private $name_director;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname_director;

    /**
     * @ORM\Column(type="date")
     */
    private $dob_director;

    /**
     * @ORM\OneToMany(targetEntity=Film::class, mappedBy="director", orphanRemoval=true)
     */
    private $films;

    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDirector(): ?string
    {
        return $this->name_director;
    }

    public function setNameDirector(string $name_director): self
    {
        $this->name_director = $name_director;

        return $this;
    }

    public function getSurnameDirector(): ?string
    {
        return $this->surname_director;
    }

    public function setSurnameDirector(string $surname_director): self
    {
        $this->surname_director = $surname_director;

        return $this;
    }

    public function getDobDirector(): ?\DateTimeInterface
    {
        return $this->dob_director;
    }

    public function setDobDirector(\DateTimeInterface $dob_director): self
    {
        $this->dob_director = $dob_director;

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films[] = $film;
            $film->setDirector($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        if ($this->films->removeElement($film)) {
            // set the owning side to null (unless already changed)
            if ($film->getDirector() === $this) {
                $film->setDirector(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name_director.' '.$this->surname_director;
    }
}
