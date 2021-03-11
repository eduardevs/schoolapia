<?php

namespace App\Entity;

use App\Repository\CarouselRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=CarouselRepository::class)
 */
class Carousel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=actualite::class, mappedBy="carousels")
     */
    private $actualites;

    public function __construct()
    {
        $this->actualites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|actualite[]
     */
    public function getActualites(): Collection
    {
        return $this->actualites;
    }

    public function addActualite(actualite $actualite): self
    {
        if (!$this->actualites->contains($actualite)) {
            $this->actualites[] = $actualite;
            $actualite->setCarousels($this);
        }

        return $this;
    }

    public function removeActualite(actualite $actualite): self
    {
        if ($this->actualites->removeElement($actualite)) {
            // set the owning side to null (unless already changed)
            if ($actualite->getCarousels() === $this) {
                $actualite->setCarousels(null);
            }
        }

        return $this;
    }
}
