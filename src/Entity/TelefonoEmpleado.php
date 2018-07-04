<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelefonoEmpleadoRepository")
 */
class TelefonoEmpleado extends Telefono
{
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Empleado", inversedBy="Telefonos")
    * @ORM\JoinColumn(nullable=false)
    */
    private $Empleado;

    public function getEmpleado(): ?Empleado
    {
        return $this->Empleado;
    }

    public function setEmpleado(?Empleado $Empleado): self
    {
        $this->Empleado = $Empleado;
        return $this;
    }
}
