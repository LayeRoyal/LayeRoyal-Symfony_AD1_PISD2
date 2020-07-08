<?php

namespace App\Entity;

use App\Repository\BatimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BatimentRepository::class)
 */
class Batiment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Chambre::class, mappedBy="batiment", orphanRemoval=true)
     */
    private $numBat;

    public function __construct()
    {
        $this->numBat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Chambre[]
     */
    public function getNumBat(): Collection
    {
        return $this->numBat;
    }

    public function addNumBat(Chambre $numBat): self
    {
        if (!$this->numBat->contains($numBat)) {
            $this->numBat[] = $numBat;
            $numBat->setBatiment($this);
        }

        return $this;
    }

    public function removeNumBat(Chambre $numBat): self
    {
        if ($this->numBat->contains($numBat)) {
            $this->numBat->removeElement($numBat);
            // set the owning side to null (unless already changed)
            if ($numBat->getBatiment() === $this) {
                $numBat->setBatiment(null);
            }
        }

        return $this;
    }
}
