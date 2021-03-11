<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomUtilisateur;

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
     * @ORM\Column(type="string", length=100)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="utilisateurs")
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Discussion::class, mappedBy="utilisateurs")
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
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="utilisateurs")
     */
    private $classes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->envoyeurs = new ArrayCollection();
        $this->receveurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
            $discussion->addUtilisateur($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            $discussion->removeUtilisateur($this);
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
}
