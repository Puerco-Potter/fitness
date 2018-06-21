<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelefonoRepository")
 */
class Telefono
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $caracteristica;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $numero;

    

    public function getId()
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getCaracteristica(): ?string
    {
        return $this->caracteristica;
    }

    public function setCaracteristica(string $caracteristica): self
    {
        $this->caracteristica = $caracteristica;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
	public function __toString()
    {
        return $this->getCaracteristica().' - '.$this->getNumero();
    }
	/**
	* @ORM\ManyToOne(targetEntity="App\Entity\Empleado")
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
 
	/**
	* @ORM\ManyToOne(targetEntity="App\Entity\FichaMedica")
	*/
	private $FichaMedica;
	
	public function getFichaMedica(): ?FichaMedica
	{
		return $this->FichaMedica;
	}

	public function setFichaMedica(?FichaMedica $FichaMedica): self
	{
		$this->FichaMedica = $FichaMedica;
		return $this;
	}
 
	/**
	* @ORM\ManyToOne(targetEntity="App\Entity\Alumno")
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
