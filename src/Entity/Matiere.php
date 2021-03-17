<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
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
    private $nomMatiere;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="matiere")
     */
    private $evaluations;

    /**
     * @ORM\ManyToMany(targetEntity=Horaire::class, inversedBy="matieres")
     */
    private $horaire;

    /**
     * @ORM\ManyToMany(targetEntity=EmploiDuTemps::class, inversedBy="matieres", cascade={"persist"})
     */
    private $emploiDuTemps;

        /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $backgroundColor;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $borderColor;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $textColor;

    public function __construct()
    {
        $this->emploiDuTemps = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->horaire = new ArrayCollection();
    }

    public function __toString()
    {
        if(is_null($this->nomMatiere)){
            return "";
        }
        return $this->nomMatiere;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMatiere(): ?string
    {
        return $this->nomMatiere;
    }

    public function setNomMatiere(string $nomMatiere): self
    {
        $this->nomMatiere = $nomMatiere;

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setMatiere($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getMatiere() === $this) {
                $evaluation->setMatiere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Horaire[]
     */
    public function getHoraire(): Collection
    {
        return $this->horaire;
    }

    public function addHoraire(Horaire $horaire): self
    {
        if (!$this->horaire->contains($horaire)) {
            $this->horaire[] = $horaire;
        }

        return $this;
    }

    public function removeHoraire(Horaire $horaire): self
    {
        $this->horaire->removeElement($horaire);

        return $this;
    }

    /**
     * @return Collection|EmploiDuTemps[]
     */
    public function getEmploiDuTemps(): Collection
    {
        return $this->emploiDuTemps;
    }

    public function addEmploiDuTemp(EmploiDuTemps $emploiDuTemp): self
    {
        if (!$this->emploiDuTemps->contains($emploiDuTemp)) {
            $this->emploiDuTemps[] = $emploiDuTemp;
        }

        return $this;
    }

    public function removeEmploiDuTemp(EmploiDuTemps $emploiDuTemp): self
    {
        $this->emploiDuTemps->removeElement($emploiDuTemp);

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    public function setBorderColor(string $borderColor): self
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }
}
