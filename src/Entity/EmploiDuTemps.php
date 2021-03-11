<?php

namespace App\Entity;

use App\Repository\EmploiDuTempsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmploiDuTempsRepository::class)
 */
class EmploiDuTemps
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heureFin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $jour;

    /**
     * @ORM\OneToOne(targetEntity=Classe::class, mappedBy="EmploiDuTemps", cascade={"persist", "remove"})
     */
    private $classes;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, inversedBy="emploiDuTemps")
     */
    private $matiere;

    public function __construct()
    {
        $this->matiere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getClasses(): ?Classe
    {
        return $this->classes;
    }

    public function setClasses(?Classe $classes): self
    {
        // unset the owning side of the relation if necessary
        if ($classes === null && $this->classes !== null) {
            $this->classes->setEmploiDuTemps(null);
        }

        // set the owning side of the relation if necessary
        if ($classes !== null && $classes->getEmploiDuTemps() !== $this) {
            $classes->setEmploiDuTemps($this);
        }

        $this->classes = $classes;

        return $this;
    }

    /**
     * @return Collection|matiere[]
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(matiere $matiere): self
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere[] = $matiere;
        }

        return $this;
    }

    public function removeMatiere(matiere $matiere): self
    {
        $this->matiere->removeElement($matiere);

        return $this;
    }
}
