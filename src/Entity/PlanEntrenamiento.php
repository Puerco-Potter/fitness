<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno")
     */
    private $Alumno;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profesor")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $Profesor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineaPlan", mappedBy="planEntrenamiento", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $lineas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias6;

    public function __construct()
    {
        $this->rutinas = new ArrayCollection();
        $this->lineas = new ArrayCollection();
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

    public function getAlumno(): ?Alumno
    {
        return $this->Alumno;
    }

    public function setAlumno(?Alumno $Alumno): self
    {
        $this->Alumno = $Alumno;

        return $this;
    }

    public function getProfesor(): ?Profesor
    {
        return $this->Profesor;
    }

    public function setProfesor(?Profesor $Profesor): self
    {
        $this->Profesor = $Profesor;

        return $this;
    }

    /**
     * @return Collection|LineaPlan[]
     */
    public function getLineas(): Collection
    {
        return $this->lineas;
    }

    public function addLinea(LineaPlan $linea): self
    {
        if (!$this->lineas->contains($linea)) {
            $this->lineas[] = $linea;
            $linea->setPlanEntrenamiento($this);
        }

        return $this;
    }

    public function removeLinea(LineaPlan $linea): self
    {
        if ($this->lineas->contains($linea)) {
            $this->lineas->removeElement($linea);
            // set the owning side to null (unless already changed)
            if ($linea->getPlanEntrenamiento() === $this) {
                $linea->setPlanEntrenamiento(null);
            }
        }

        return $this;
    }

    public function getDias1(): ?string
    {
        return $this->dias1;
    }

    public function setDias1(?string $dias1): self
    {
        $this->dias1 = $dias1;

        return $this;
    }

    public function getDias2(): ?string
    {
        return $this->dias2;
    }

    public function setDias2(?string $dias2): self
    {
        $this->dias2 = $dias2;

        return $this;
    }

    public function getDias3(): ?string
    {
        return $this->dias3;
    }

    public function setDias3(?string $dias3): self
    {
        $this->dias3 = $dias3;

        return $this;
    }

    public function getDias4(): ?string
    {
        return $this->dias4;
    }

    public function setDias4(?string $dias4): self
    {
        $this->dias4 = $dias4;

        return $this;
    }

    public function getDias5(): ?string
    {
        return $this->dias5;
    }

    public function setDias5(?string $dias5): self
    {
        $this->dias5 = $dias5;

        return $this;
    }

    public function getDias6(): ?string
    {
        return $this->dias6;
    }

    public function setDias6(?string $dias6): self
    {
        $this->dias6 = $dias6;

        return $this;
    }
}
