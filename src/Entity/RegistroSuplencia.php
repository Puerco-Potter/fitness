<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistroSuplenciaRepository")
 */
class RegistroSuplencia
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profesor")
     */
    private $Profesor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clase")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $Clase;

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

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

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

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

    public function getClase(): ?Clase
    {
        return $this->Clase;
    }

    public function setClase(?Clase $Clase): self
    {
        $this->Clase = $Clase;

        return $this;
    }
    
    public function __toString()
    {
        return (string) $this->getFecha()->format('Y-m-d').' - Suplencia de: '.$this->getProfesor().' / '.$this->getObservaciones();
    }
}
