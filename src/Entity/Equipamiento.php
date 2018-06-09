<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipamientoRepository")
 */
class Equipamiento
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
    private $descripcion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $proxMantenimiento;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     */
    private $mantenimientoDias;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaAdquisicion;

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getProxMantenimiento(): ?\DateTimeInterface
    {
        return $this->proxMantenimiento;
    }

    public function setProxMantenimiento(?\DateTimeInterface $proxMantenimiento): self
    {
        $this->proxMantenimiento = $proxMantenimiento;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getMantenimientoDias(): ?int
    {
        return $this->mantenimientoDias;
    }

    public function setMantenimientoDias(int $mantenimientoDias): self
    {
        $this->mantenimientoDias = $mantenimientoDias;

        return $this;
    }

    public function getFechaAdquisicion(): ?\DateTimeInterface
    {
        return $this->fechaAdquisicion;
    }

    public function setFechaAdquisicion(\DateTimeInterface $fechaAdquisicion): self
    {
        $this->fechaAdquisicion = $fechaAdquisicion;

        return $this;
    }
}
