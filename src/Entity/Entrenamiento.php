<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrenamientoRepository")
 */
class Entrenamiento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $series;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $peso;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $descansos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rutina", inversedBy="entrenamientos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Rutina;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ejercicio")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ejercicio;

    public function getId()
    {
        return $this->id;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getPeso(): ?int
    {
        return $this->peso;
    }

    public function setPeso(?int $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getDescansos(): ?int
    {
        return $this->descansos;
    }

    public function setDescansos(?int $descansos): self
    {
        $this->descansos = $descansos;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getRutina(): ?Rutina
    {
        return $this->Rutina;
    }

    public function setRutina(?Rutina $Rutina): self
    {
        $this->Rutina = $Rutina;

        return $this;
    }

    public function getEjercicio(): ?Ejercicio
    {
        return $this->Ejercicio;
    }

    public function setEjercicio(?Ejercicio $Ejercicio): self
    {
        $this->Ejercicio = $Ejercicio;

        return $this;
    }

    public function __toString()
    {
        return $this->getRutina()->__toString().' - '.(string) $this->getSeries();
    }
}
