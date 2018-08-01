<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RutinaRepository")
 */
class Rutina
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PlanEntrenamiento", inversedBy="rutinas")
     */
    private $PlanEntrenamiento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrenamiento", mappedBy="Rutina", orphanRemoval=true)
     */
    private $entrenamientos;

    public function __construct()
    {
        $this->PlanEntrenamiento = new ArrayCollection();
        $this->entrenamientos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|PlanEntrenamiento[]
     */
    public function getPlanEntrenamiento(): Collection
    {
        return $this->PlanEntrenamiento;
    }

    public function addPlanEntrenamiento(PlanEntrenamiento $planEntrenamiento): self
    {
        if (!$this->PlanEntrenamiento->contains($planEntrenamiento)) {
            $this->PlanEntrenamiento[] = $planEntrenamiento;
        }

        return $this;
    }

    public function removePlanEntrenamiento(PlanEntrenamiento $planEntrenamiento): self
    {
        if ($this->PlanEntrenamiento->contains($planEntrenamiento)) {
            $this->PlanEntrenamiento->removeElement($planEntrenamiento);
        }

        return $this;
    }

    /**
     * @return Collection|Entrenamiento[]
     */
    public function getEntrenamientos(): Collection
    {
        return $this->entrenamientos;
    }

    public function addEntrenamiento(Entrenamiento $entrenamiento): self
    {
        if (!$this->entrenamientos->contains($entrenamiento)) {
            $this->entrenamientos[] = $entrenamiento;
            $entrenamiento->setRutina($this);
        }

        return $this;
    }

    public function removeEntrenamiento(Entrenamiento $entrenamiento): self
    {
        if ($this->entrenamientos->contains($entrenamiento)) {
            $this->entrenamientos->removeElement($entrenamiento);
            // set the owning side to null (unless already changed)
            if ($entrenamiento->getRutina() === $this) {
                $entrenamiento->setRutina(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }
}
