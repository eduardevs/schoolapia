<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="discussions")
     */
    private $Users;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->Users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $User): self
    {
        if (!$this->Users->contains($User)) {
            $this->Users[] = $User;
        }

        return $this;
    }

    public function removeUser(User $User): self
    {
        $this->Users->removeElement($User);

        return $this;
    }
}
