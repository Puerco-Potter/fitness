<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlumnoRepository")
 */
class Alumno
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $localidad;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $cuenta;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $ocupacion;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $balance;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $genero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $diasPrueba;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="alumno", orphanRemoval=true)
     */
    private $fichasMedicas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telefono", mappedBy="alumno")
     */
    private $telefonos;

    public function __construct()
    {
        $this->fichasMedicas = new ArrayCollection();
        $this->telefonos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(?string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getOcupacion(): ?string
    {
        return $this->ocupacion;
    }

    public function setOcupacion(?string $ocupacion): self
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDiasPrueba(): ?int
    {
        return $this->diasPrueba;
    }

    public function setDiasPrueba(?int $diasPrueba): self
    {
        $this->diasPrueba = $diasPrueba;

        return $this;
    }

    /**
     * @return Collection|FichaMedica[]
     */
    public function getFichasMedicas(): Collection
    {
        return $this->fichasMedicas;
    }

    public function addFichasMedica(FichaMedica $fichasMedica): self
    {
        if (!$this->fichasMedicas->contains($fichasMedica)) {
            $this->fichasMedicas[] = $fichasMedica;
            $fichasMedica->setAlumno($this);
        }

        return $this;
    }

    public function removeFichasMedica(FichaMedica $fichasMedica): self
    {
        if ($this->fichasMedicas->contains($fichasMedica)) {
            $this->fichasMedicas->removeElement($fichasMedica);
            // set the owning side to null (unless already changed)
            if ($fichasMedica->getAlumno() === $this) {
                $fichasMedica->setAlumno(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Telefono[]
     */
    public function getTelefonos(): Collection
    {
        return $this->telefonos;
    }

    public function addTelefono(Telefono $telefono): self
    {
        if (!$this->telefonos->contains($telefono)) {
            $this->telefonos[] = $telefono;
            $telefono->setAlumno($this);
        }

        return $this;
    }

    public function removeTelefono(Telefono $telefono): self
    {
        if ($this->telefonos->contains($telefono)) {
            $this->telefonos->removeElement($telefono);
            // set the owning side to null (unless already changed)
            if ($telefono->getAlumno() === $this) {
                $telefono->setAlumno(null);
            }
        }

        return $this;
    }
}
