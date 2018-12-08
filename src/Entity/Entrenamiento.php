<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ejercicio")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
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
    /*
    public function getRutina(): ?Rutina
    {
        return $this->Rutina;
    }

    public function setRutina(?Rutina $Rutina): self
    {
        $this->Rutina = $Rutina;

        return $this;
    }
    */
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
        $a1 = '';
        $b1 = '';
        $c1 = '';
        $cadena = '';
        if ($this->getObservaciones() )
        {
            $a1 = $this->getObservaciones();
        }
        if ($this->getDescansos())
        {
            $b1 = ' '.$this->getDescansos(). ' s';
        }
        if ($this->getPeso())
        {
            $c1 = ' ' .$this->getPeso(). ' kg';
        }
        if ($this->getObservaciones() or $this->getPeso() or $this->getObservaciones())
        {
            $cadena = ' ('.$a1.$b1.$c1.')';
        }
        
        return (string) $this->getSeries().' series de '.$this->getEjercicio().$cadena;
    }
}
