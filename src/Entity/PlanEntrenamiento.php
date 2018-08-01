<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanEntrenamientoRepository")
 */
class PlanEntrenamiento
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
     * @ORM\Column(type="integer")
     */
    private $duracion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Rutina", mappedBy="PlanEntrenamiento")
     */
    private $rutinas;

    public function __construct()
    {
        $this->rutinas = new ArrayCollection();
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

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * @return Collection|Rutina[]
     */
    public function getRutinas(): Collection
    {
        return $this->rutinas;
    }

    public function addRutina(Rutina $rutina): self
    {
        if (!$this->rutinas->contains($rutina)) {
            $this->rutinas[] = $rutina;
            $rutina->addPlanEntrenamiento($this);
        }

        return $this;
    }

    public function removeRutina(Rutina $rutina): self
    {
        if ($this->rutinas->contains($rutina)) {
            $this->rutinas->removeElement($rutina);
            $rutina->removePlanEntrenamiento($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }
}
