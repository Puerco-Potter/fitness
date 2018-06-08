<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElementoRepository")
 */
class Elemento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $proxMantenimiento;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mantenimientoDias;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

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

    public function getMantenimientoDias(): ?int
    {
        return $this->mantenimientoDias;
    }

    public function setMantenimientoDias(?int $mantenimientoDias): self
    {
        $this->mantenimientoDias = $mantenimientoDias;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }
	
	public function __toString()
    {
        return $this->getNombre();
    }

	
}
