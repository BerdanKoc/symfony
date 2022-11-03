<?php

namespace App\Entity;

use App\Repository\FilmsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmsRepository::class)
 */
class Films
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_de_sortie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $affiche;

    /**
     * @ORM\ManyToMany(targetEntity=Acteurs::class, inversedBy="films")
     */
    private $acteurs;

    /**
     * @ORM\ManyToOne(targetEntity=Genres::class, inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    public function __construct()
    {
        $this->acteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getAnneeDeSortie(): ?int
    {
        return $this->annee_de_sortie;
    }

    public function setAnneeDeSortie(int $annee_de_sortie): self
    {
        $this->annee_de_sortie = $annee_de_sortie;

        return $this;
    }

    public function getAffiche()
    {
        return $this->affiche;
    }

    public function setAffiche($affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * @return Collection<int, Acteurs>
     */
    public function getActeurs(): Collection
    {
        return $this->acteurs;
    }

    public function addActeur(Acteurs $acteur): self
    {
        if (!$this->acteurs->contains($acteur)) {
            $this->acteurs[] = $acteur;
        }

        return $this;
    }

    public function removeActeur(Acteurs $acteur): self
    {
        $this->acteurs->removeElement($acteur);

        return $this;
    }

    public function getGenre(): ?Genres
    {
        return $this->genre;
    }

    public function setGenre(?Genres $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
