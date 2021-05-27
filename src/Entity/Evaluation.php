<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 * @Vich\Uploadable
 */
class Evaluation implements Serializable
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
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="evaluations", cascade={"persist", "remove"})
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fichier;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="files_upload", fileNameProperty="fichier")
     * 
     * @var File|null
     */
    private $fichierFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->note = new ArrayCollection();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->nomEvaluation;
        return $this->fichier;
    }

    //
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->matiere,
            $this->nomEvaluation,
            $this->note
        ));
    }
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->matiere,
            $this->nomEvaluation,
            $this->note
        ) = unserialize($serialized);
    }
    //

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier($fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function setFichierFile(?File $fichierFile = null): void
    {
        $this->fichierFile = $fichierFile;

        if (null !== $fichierFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFichierFile(): ?File
    {
        return $this->fichierFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getNomEvaluation(): ?string
    {
        return $this->nomEvaluation;
    }

    public function setNomEvaluation(string $nomEvaluation): self
    {
        $this->nomEvaluation = $nomEvaluation;

        return $this;
    }
}