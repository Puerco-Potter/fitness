<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AsistenciaAlumnoRepository")
 */
class AsistenciaAlumno
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscripcion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Inscripcion;

    public function getId()
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getInscripcion(): ?Inscripcion
    {
        return $this->Inscripcion;
    }

    public function setInscripcion(?Inscripcion $Inscripcion): self
    {
        $this->Inscripcion = $Inscripcion;

        return $this;
    }
    
    public function __toString()
    {
        return (string) $this->getFecha().' - '.(string) $this->getHora();
    }
}
