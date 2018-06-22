<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmpleadoRepository")
 * @UniqueEntity("DNI") 
 * @UniqueEntity("CUIT") 
 */
class Empleado
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
     * @Assert\Length(
     *      min = 6,
     *      max = 8,
     *      minMessage = "El DNI debe tener como mínimo 6 dígitos",
     *      maxMessage = "El DNI debe tener como máximo 8 dígitos"
     * )
     * @ORM\Column(type="string", length=8)
     */
    private $DNI;

    /**
     * @Assert\Length(
     *      min = 11,
     *      max = 11,
     *      minMessage = "El CUIT debe tener 11 dígitos",
     *      maxMessage = "El CUIT debe tener 11 dígitos",
     *      exactMessage = "El CUIT debe tener 11 dígitos"
     * )
     * @ORM\Column(type="string", length=11)
     */
    private $CUIT;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $relacion;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $direccion;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

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

    public function getDNI(): ?string
    {
        return $this->DNI;
    }

    public function setDNI(string $DNI): self
    {
        $this->DNI = $DNI;

        return $this;
    }

    public function getCUIT(): ?string
    {
        return $this->CUIT;
    }

    public function setCUIT(string $CUIT): self
    {
        $this->CUIT = $CUIT;

        return $this;
    }

    public function getRelacion(): ?string
    {
        return $this->relacion;
    }

    public function setRelacion(string $relacion): self
    {
        $this->relacion = $relacion;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }
	public function __toString()
    {
        return $this->getApellido().', '.$this->getNombre();
    }

}
