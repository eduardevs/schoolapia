<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $appreciations;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="note")
     */
    private $evaluations;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notes")
     */
    private $utilisateurs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAppreciations(): ?string
    {
        return $this->appreciations;
    }

    public function setAppreciations(?string $appreciations): self
    {
        $this->appreciations = $appreciations;

        return $this;
    }

    public function getEvaluations(): ?Evaluation
    {
        return $this->evaluations;
    }

    public function setEvaluations(?Evaluation $evaluations): self
    {
        $this->evaluations = $evaluations;

        return $this;
    }

    public function getUtilisateurs(): ?User
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?User $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }
}
