<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="evaluations")
     */
    private $matiere;

    /**
     * @ORM\OneToMany(targetEntity=note::class, mappedBy="evaluations")
     */
    private $note;

    public function __construct()
    {
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection|note[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(note $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
            $note->setEvaluations($this);
        }

        return $this;
    }

    public function removeNote(note $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEvaluations() === $this) {
                $note->setEvaluations(null);
            }
        }

        return $this;
    }
}
