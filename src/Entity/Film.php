<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FilmRepository;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title_film;

    /**
     * @ORM\Column(type="integer")
     */
    private $length_film;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="date")
     */
    private $date_film;

    /**
     * @ORM\ManyToOne(targetEntity=Director::class, inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, mappedBy="films")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity=Casting::class, mappedBy="film", orphanRemoval=true)
     */
    private $castings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster_film;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->castings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleFilm(): ?string
    {
        return $this->title_film;
    }

    public function setTitleFilm(string $title_film): self
    {
        $this->title_film = $title_film;

        return $this;
    }

    public function getLengthFilm(): ?int
    {
        return $this->length_film;
    }

    public function setLengthFilm(int $length_film): self
    {
        $this->length_film = $length_film;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDateFilm(): ?\DateTimeInterface
    {
        return $this->date_film;
    }

    public function setDateFilm(\DateTimeInterface $date_film): self
    {
        $this->date_film = $date_film;

        return $this;
    }

    

    

    public function getDirector(): ?Director
    {
        return $this->director;
    }

    public function setDirector(?Director $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function __toString(){
        return $this->title_film;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->addFilm($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeFilm($this);
        }

        return $this;
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
            $casting->setFilm($this);
        }

        return $this;
    }

    public function removeCasting(Casting $casting): self
    {
        if ($this->castings->removeElement($casting)) {
            // set the owning side to null (unless already changed)
            if ($casting->getFilm() === $this) {
                $casting->setFilm(null);
            }
        }

        return $this;
    }

    public function getPosterFilm(): ?string
    {
        return $this->poster_film;
    }

    public function setPosterFilm(?string $poster_film): self
    {
        $this->poster_film = $poster_film;

        return $this;
    }


}
