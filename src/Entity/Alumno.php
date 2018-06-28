<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AlumnoRepository")
 * @UniqueEntity("dni") 
 */
class Alumno
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
	
	
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $localidad;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cp;
	
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $cuenta;

    /**
     * @Assert\Email(
     *     message = "El correo ingresado '{{ value }}' no es válido",
     *     checkMX = true
     * )
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $ocupacion;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $balance;

	/**
     * @Assert\Length(
     *      min = 6,
     *      max = 8,
     *      minMessage = "El DNI debe tener como mínimo 6 dígitos",
     *      maxMessage = "El DNI debe tener como máximo 8 dígitos"
     * )
     * @ORM\Column(type="string", length=8)
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $genero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $diasPrueba;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="Alumno")
     */
    private $fichaMedicas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telefono", mappedBy="Alumno",  cascade={"persist", "remove"})
     */
    private $telefonos;
	
    public function __construct()
    {
        $this->telefonos = new ArrayCollection();
        $this->fichaMedicas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

	
    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

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

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(?string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getOcupacion(): ?string
    {
        return $this->ocupacion;
    }

    public function setOcupacion(?string $ocupacion): self
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDiasPrueba(): ?int
    {
        return $this->diasPrueba;
    }

    public function setDiasPrueba(?int $diasPrueba): self
    {
        $this->diasPrueba = $diasPrueba;

        return $this;
    }

	public function __toString()
    {
        return $this->getApellido().', '.$this->getNombre();
    }
	
	/**
	* @return Collection|FichaMedica[]
	*/
	public function getFichaMedicas(): Collection
	{
		return $this->fichaMedicas;
	}
	public function addFichaMedica(FichaMedica $fichaMedica): self
	{
		if (!$this->fichaMedicas->contains($fichaMedica)) {
			$this->fichaMedicas[] = $fichaMedica;
			$fichaMedica->setAlumno($this);
		}
		return $this;
	}
	public function removeFichaMedica(FichaMedica $fichaMedica): self
	{
		if ($this->fichaMedicas->contains($fichaMedica)) {
			$this->fichaMedicas->removeElement($fichaMedica);
			// set the owning side to null (unless already changed)
			if ($fichaMedica->getAlumno() === $this) {
				$fichaMedica->setAlumno(null);
				}
			}
		return $this;
	}
	
	/**
	* @return Collection|Telefono[]
	*/
	public function getTelefonos(): Collection
	{
		return $this->telefonos;
	}
	public function addTelefono(Telefono $telefono): self
	{
		if (!$this->telefonos->contains($telefono)) {
			$this->telefonos[] = $telefono;
			$telefono->setAlumno($this);
		}
		return $this;
	}
	public function removeTelefono(Telefono $telefono): self
	{
		if ($this->telefonos->contains($telefono)) {
			$this->telefonos->removeElement($telefono);
			// set the owning side to null (unless already changed)
			if ($telefono->getAlumno() === $this) {
				$telefono->setAlumno(null);
				}
			}
		return $this;
	}

}
