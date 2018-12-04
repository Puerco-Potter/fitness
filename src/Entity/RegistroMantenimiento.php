<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistroMantenimientoRepository")
 */
class RegistroMantenimiento
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
     * @ORM\Column(type="text")
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empleado")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $Empleado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipamiento", inversedBy="Mantenimientos")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $Equipamiento;

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

    public function setObservaciones(string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->Empleado;
    }

    public function setEmpleado(?Empleado $Empleado): self
    {
        $this->Empleado = $Empleado;

        return $this;
    }

    public function getEquipamiento(): ?Equipamiento
    {
        return $this->Equipamiento;
    }

    public function setEquipamiento(?Equipamiento $Equipamiento): self
    {
        $this->Equipamiento = $Equipamiento;

        return $this;
    }

	public function __toString()
    {
        return (string) $this->getFecha()->format('Y-m-d').' - '.$this->getEquipamiento().' - '.$this->getObservaciones();
    }
}
