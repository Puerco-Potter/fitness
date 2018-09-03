<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $dia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\empleado")
     */
    private $empleado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\equipamiento", inversedBy="mantenimientos")
     */
    private $equipamiento;

    public function getId()
    {
        return $this->id;
    }

    public function getDia(): ?\DateTimeInterface
    {
        return $this->dia;
    }

    public function setDia(\DateTimeInterface $dia): self
    {
        $this->dia = $dia;

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

    public function getEmpleado(): ?empleado
    {
        return $this->empleado;
    }

    public function setEmpleado(?empleado $empleado): self
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getEquipamiento(): ?equipamiento
    {
        return $this->equipamiento;
    }

    public function setEquipamiento(?equipamiento $equipamiento): self
    {
        $this->equipamiento = $equipamiento;

        return $this;
    }
public function __toString()
    {
        return $this->getNombre();
    }


}
