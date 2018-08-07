<?php

// TODO cambiar nombre a precioFinal, clases y clasesDisponibles

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscripcionRepository")
 */
class Inscripcion
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
    private $fechaInscripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clase")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Clase;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Alumno;

    /**
     * @ORM\Column(type="integer")
     */
    private $clases;

    /**
     * @ORM\Column(type="integer")
     */
    private $clasesDisponibles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lunes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $martes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $miercoles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $jueves;

    /**
     * @ORM\Column(type="boolean")
     */
    private $viernes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sabado;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $precioFinal;

    public function __construct()
    {
        $this->fechaInscripcion = new \DateTime();
        $this->lunes = FALSE;
        $this->martes = FALSE;
        $this->miercoles = FALSE;
        $this->jueves = FALSE;
        $this->viernes = FALSE;
        $this->sabado = FALSE;
        $this->clases = 12;
        $this->clasesDisponibles = 12;
        $this->precioFinal = 300;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaInscripcion(): ?\DateTimeInterface
    {
        return $this->fechaInscripcion;
    }

    public function setFechaInscripcion(\DateTimeInterface $fechaInscripcion): self
    {
        $this->fechaInscripcion = $fechaInscripcion;

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

    public function getAlumno(): ?Alumno
    {
        return $this->Alumno;
    }

    public function setAlumno(?Alumno $Alumno): self
    {
        $this->Alumno = $Alumno;

        return $this;
    }

    public function getClases(): ?int
    {
        return $this->clases;
    }

    public function setClases(int $clases): self
    {
        $this->clases = $clases;

        return $this;
    }

    public function getClasesDisponibles(): ?int
    {
        return $this->clasesDisponibles;
    }

    public function setClasesDisponibles(int $clasesDisponibles): self
    {
        $this->clasesDisponibles = $clasesDisponibles;

        return $this;
    }

    public function getLunes(): ?bool
    {
        return $this->lunes;
    }

    public function setLunes(bool $lunes): self
    {
        $this->lunes = $lunes;

        return $this;
    }

    public function getMartes(): ?bool
    {
        return $this->martes;
    }

    public function setMartes(bool $martes): self
    {
        $this->martes = $martes;

        return $this;
    }

    public function getMiercoles(): ?bool
    {
        return $this->miercoles;
    }

    public function setMiercoles(bool $miercoles): self
    {
        $this->miercoles = $miercoles;

        return $this;
    }

    public function getJueves(): ?bool
    {
        return $this->jueves;
    }

    public function setJueves(bool $jueves): self
    {
        $this->jueves = $jueves;

        return $this;
    }

    public function getViernes(): ?bool
    {
        return $this->viernes;
    }

    public function setViernes(bool $viernes): self
    {
        $this->viernes = $viernes;

        return $this;
    }

    public function getSabado(): ?bool
    {
        return $this->sabado;
    }

    public function setSabado(bool $sabado): self
    {
        $this->sabado = $sabado;

        return $this;
    }

    public function getPrecioFinal()
    {
        return $this->precioFinal;
    }

    public function setPrecioFinal($precioFinal): self
    {
        $this->precioFinal = $precioFinal;

        return $this;
    }
	public function __toString()
    {
        return $this->getAlumno().' - '.$this->getClase().' - '.$this->getFechaInscripcion();
    }
}
