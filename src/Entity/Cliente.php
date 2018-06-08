<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 */
class Cliente
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
    private $dni;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $apellido;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $localidad;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_nacimiento;

    /**
     * @ORM\Column(type="float")
     */
    private $cuenta;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="Cliente", orphanRemoval=true)
     */
    private $FichaMedica;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Observacion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sala", mappedBy="cliente")
     */
    private $salas;

    public function __construct()
    {
        $this->FichaMedica = new ArrayCollection();
        $this->salas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDni(): ?int
    {
        return $this->dni;
    }

    public function setDni(int $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getCuenta(): ?float
    {
        return $this->cuenta;
    }

    public function setCuenta(float $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * @return Collection|FichaMedica[]
     */
    public function getFichaMedica(): Collection
    {
        return $this->FichaMedica;
    }

    public function addFichaMedica(FichaMedica $fichaMedica): self
    {
        if (!$this->FichaMedica->contains($fichaMedica)) {
            $this->FichaMedica[] = $fichaMedica;
            $fichaMedica->setCliente($this);
        }

        return $this;
    }

    public function removeFichaMedica(FichaMedica $fichaMedica): self
    {
        if ($this->FichaMedica->contains($fichaMedica)) {
            $this->FichaMedica->removeElement($fichaMedica);
            // set the owning side to null (unless already changed)
            if ($fichaMedica->getCliente() === $this) {
                $fichaMedica->setCliente(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    public function getObservacion(): ?string
    {
        return $this->Observacion;
    }

    public function setObservacion(?string $Observacion): self
    {
        $this->Observacion = $Observacion;

        return $this;
    }

    /**
     * @return Collection|Sala[]
     */
    public function getSalas(): Collection
    {
        return $this->salas;
    }

    public function addSala(Sala $sala): self
    {
        if (!$this->salas->contains($sala)) {
            $this->salas[] = $sala;
            $sala->setCliente($this);
        }

        return $this;
    }

    public function removeSala(Sala $sala): self
    {
        if ($this->salas->contains($sala)) {
            $this->salas->removeElement($sala);
            // set the owning side to null (unless already changed)
            if ($sala->getCliente() === $this) {
                $sala->setCliente(null);
            }
        }

        return $this;
    }
}
