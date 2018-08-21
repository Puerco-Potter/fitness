<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="datetime")
     */
    private $fechaYHora;

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
     */
    private $Clase;

    public function __construct()
    {
        $this->fechaYHora = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaYHora(): ?\DateTimeInterface
    {
        return $this->fechaYHora;
    }

    public function setFechaYHora(\DateTimeInterface $fechaYHora): self
    {
        $this->fechaYHora = $fechaYHora;

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
        return (string) $this->getFechaYHora()->format('Y-m-d').' - '.$this->getProfesor().' / '.$this->getObservaciones();
    }
}
