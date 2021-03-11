<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscussionRepository::class)
 */
class Discussion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=message::class, mappedBy="discussions")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=utilisateur::class, inversedBy="discussions")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setDiscussions($this);
        }

        return $this;
    }

    public function removeMessage(message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDiscussions() === $this) {
                $message->setDiscussions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }
}
