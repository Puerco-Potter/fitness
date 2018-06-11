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
    private $Empleado;

    public function getId()
    {
        return $this->id;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->Empleado;
    }

    public function setEmpleado(Empleado $Empleado): self
    {
        $this->Empleado = $Empleado;

        return $this;
    }
	public function __toString()
    {
        return $this->getEmpleado();
    }

}
