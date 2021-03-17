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
     * @ORM\OneToOne(targetEntity=Classe::class, mappedBy="EmploiDuTemps", cascade={"persist", "remove"})
     */
    private $classes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, mappedBy="emploiDuTemps", cascade={"persist"})
     */
    private $matieres;



    public function __construct()
    {
        $this->matiere = new ArrayCollection();
        $this->matieres = new ArrayCollection();
    }

    public function __toString()
    {
        if (is_null($this->nom)) {
            return "";
        }
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasses()
    {
        if(is_null($this->classes)) return "Pas de classe.";
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres[] = $matiere;
            $matiere->addEmploiDuTemp($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matieres->removeElement($matiere)) {
            $matiere->removeEmploiDuTemp($this);
        }

        return $this;
    }

}
