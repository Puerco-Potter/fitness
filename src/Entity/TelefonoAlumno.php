<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelefonoAlumnoRepository")
 */
class TelefonoAlumno extends Telefono
{
	/**
	* @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="Telefonos")
    * @ORM\JoinColumn(nullable=false)
	*/
	private $Alumno;
	
	public function getAlumno(): ?Alumno
	{
		return $this->Alumno;
	}

	public function setAlumno(?Alumno $Alumno): self
	{
		$this->Alumno = $Alumno;
		return $this;
	}

}
