<?php

// DONE cambiar nombre a precioFinal, clasesTotales y clasesRestantes

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateInterval;

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
     * @ORM\Column(type="date")
     */
    private $fechaFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clase")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
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
    private $clasesTotales;

    /**
     * @ORM\Column(type="integer")
     */
    private $clasesRestantes;

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
     * @Assert\GreaterThanOrEqual(value = 0, message = "La cuota debe ser mayor a $0")
     */
    private $cuota;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Combo", inversedBy="Inscripciones")
     */
    private $Combo;
    
    public function __construct()
    {
        $this->fechaInscripcion = new \DateTime();
        $this->fechaFin = (new \DateTime())->add(new DateInterval('P30D'));
        $this->lunes = FALSE;
        $this->martes = FALSE;
        $this->miercoles = FALSE;
        $this->jueves = FALSE;
        $this->viernes = FALSE;
        $this->sabado = FALSE;
        $this->clasesTotales = 12;
        $this->clasesRestantes = 12;
        $this->cuota = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
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

    public function getClasesTotales(): ?int
    {
        return $this->clasesTotales;
    }

    public function setClasesTotales(int $clasesTotales): self
    {
        $this->clasesTotales = $clasesTotales;

        return $this;
    }

    public function getclasesRestantes(): ?int
    {
        return $this->clasesRestantes;
    }

    public function setClasesRestantes(int $clasesRestantes): self
    {
        $this->clasesRestantes = $clasesRestantes;

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

    public function getCuota()
    {
        return $this->cuota;
    }

    public function setCuota($cuota): self
    {
        $this->cuota = $cuota;

        return $this;
    }
	public function __toString()
    {
        return 'Alumno: '.$this->getAlumno()->getDni().' - '.$this->getClase();
        //return $this->getAlumno().' - '.$this->getClase().' - '.(string) $this->getFechaInscripcion()->format('Y-m-d');
    }

    public function conseguir_asistencia()
    {
        return $this->getClase();
        //return $this->getAlumno().' - '.$this->getClase().' - '.(string) $this->getFechaInscripcion()->format('Y-m-d');
    }

    public function getCombo(): ?Combo
    {
        return $this->Combo;
    }

    public function setCombo(?Combo $Combo): self
    {
        $this->Combo = $Combo;

        return $this;
    }
}
