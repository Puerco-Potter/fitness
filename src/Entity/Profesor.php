<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesorRepository")
 */
class Profesor extends Empleado
{
	public function __toString()
    {
        return $this->getApellido().', '.$this->getNombre();
    }

}
