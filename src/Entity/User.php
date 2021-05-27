<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Classe;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="utilisateurs", cascade={"persist", "remove"})
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Discussion::class, mappedBy="users")
     */
    private $discussions;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="envoyeur")
     */
    private $envoyeurs;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="receveur")
     */
    private $receveurs;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="utilisateurs", cascade={"persist", "remove"})
     */
    private $classes;

    private $roleDisplay = "";

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     */
    private $messages;


    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->envoyeurs = new ArrayCollection();
        $this->receveurs = new ArrayCollection();
    }

    public function __toString()
    {
        // if(is_null($this->prenom) && is_null($this->nom)){
        //     return $this->email;
        // }
        return $this->prenom . '  ' . $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of roleDisplay
     */
    public function getRoleDisplay()
    {
        if (in_array("ROLE_SUPER_ADMIN", $this->roles)) {
            return "SuperAdmin";
        } elseif (!in_array("ROLE_SUPER_ADMIN", $this->roles) && in_array("ROLE_ADMIN", $this->roles)) {
            return "Admin";
        } elseif (!in_array("ROLE_SUPER_ADMIN", $this->roles) && !in_array("ROLE_ADMIN", $this->roles)) {
            return "User";
        }
        return "On a un problème Houston";
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        global $kernel;
        if (method_exists($kernel, 'getKernel'))
            $kernel = $kernel->getKernel();

        $this->password = $kernel->getContainer()->get('security.password_encoder')->encodePassword($this, $password);
        return $this;
    }


    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }


    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUtilisateurs() === $this) {
                $note->setUtilisateurs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Discussion[]
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
            $discussion->addUser($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            $discussion->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getEnvoyeurs(): Collection
    {
        return $this->envoyeurs;
    }

    public function addEnvoyeur(Message $envoyeur): self
    {
        if (!$this->envoyeurs->contains($envoyeur)) {
            $this->envoyeurs[] = $envoyeur;
            $envoyeur->setEnvoyeur($this);
        }

        return $this;
    }

    public function removeEnvoyeur(Message $envoyeur): self
    {
        if ($this->envoyeurs->removeElement($envoyeur)) {
            // set the owning side to null (unless already changed)
            if ($envoyeur->getEnvoyeur() === $this) {
                $envoyeur->setEnvoyeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceveurs(): Collection
    {
        return $this->receveurs;
    }

    public function addReceveur(Message $receveur): self
    {
        if (!$this->receveurs->contains($receveur)) {
            $this->receveurs[] = $receveur;
            $receveur->setReceveur($this);
        }

        return $this;
    }

    public function removeReceveur(Message $receveur): self
    {
        if ($this->receveurs->removeElement($receveur)) {
            // set the owning side to null (unless already changed)
            if ($receveur->getReceveur() === $this) {
                $receveur->setReceveur(null);
            }
        }

        return $this;
    }

    public function getClasses(): ?Classe
    {
        return $this->classes;
    }

    public function setClasses(?Classe $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): ?Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
