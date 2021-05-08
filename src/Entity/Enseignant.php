<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 */
class Enseignant extends User
{
    /**
     * @ORM\OneToMany(targetEntity=ClasseDeCours::class, mappedBy="enseignant", orphanRemoval=true)
     */
    private $classesDeCours;

    public function __construct()
    {
        $this->classesDeCours = new ArrayCollection();
    }

    /**
     * @return Collection|ClasseDeCours[]
     */
    public function getClassesDeCours(): Collection
    {
        return $this->classesDeCours;
    }

    public function addClassesDeCour(ClasseDeCours $classesDeCour): self
    {
        if (!$this->classesDeCours->contains($classesDeCour)) {
            $this->classesDeCours[] = $classesDeCour;
            $classesDeCour->setEnseignant($this);
        }

        return $this;
    }

    public function removeClassesDeCour(ClasseDeCours $classesDeCour): self
    {
        if ($this->classesDeCours->removeElement($classesDeCour)) {
            // set the owning side to null (unless already changed)
            if ($classesDeCour->getEnseignant() === $this) {
                $classesDeCour->setEnseignant(null);
            }
        }

        return $this;
    }
}
