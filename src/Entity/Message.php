<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
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
    private $sujet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=Discussion::class, inversedBy="messages")
     */
    private $discussions;

    /**
     * @ORM\ManyToOne(targetEntity=utilisateur::class, inversedBy="envoyeurs")
     */
    private $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity=utilisateur::class, inversedBy="receveurs")
     */
    private $receveur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->dateMessage;
    }

    public function setDateMessage(\DateTimeInterface $dateMessage): self
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPieceJointe(): ?string
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe(?string $pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    public function getDiscussions(): ?Discussion
    {
        return $this->discussions;
    }

    public function setDiscussions(?Discussion $discussions): self
    {
        $this->discussions = $discussions;

        return $this;
    }

    public function getEnvoyeur(): ?utilisateur
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?utilisateur $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    public function getReceveur(): ?utilisateur
    {
        return $this->receveur;
    }

    public function setReceveur(?utilisateur $receveur): self
    {
        $this->receveur = $receveur;

        return $this;
    }
}
