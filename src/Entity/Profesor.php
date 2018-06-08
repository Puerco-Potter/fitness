<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesorRepository")
 */
class Profesor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Empleado", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEmpleado;

    public function getId()
    {
        return $this->id;
    }

    public function getIdEmpleado(): ?Empleado
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(Empleado $idEmpleado): self
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }
	public function __toString()
    {
        return $this->getIdEmpleado();
    }

}
