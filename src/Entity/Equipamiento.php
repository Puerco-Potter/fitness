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
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date")
     */
    private $proxMantenimiento;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $estado;

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getProxMantenimiento(): ?\DateTimeInterface
    {
        return $this->proxMantenimiento;
    }

    public function setProxMantenimiento(\DateTimeInterface $proxMantenimiento): self
    {
        $this->proxMantenimiento = $proxMantenimiento;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
	public function __toString()
    {
        return $this->getNombre();
    }

}
