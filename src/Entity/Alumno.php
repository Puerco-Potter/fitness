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
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "El nombre debe tener como máximo 60 caracteres"
     * )
     * @ORM\Column(type="string", length=60)
     */
    private $nombre;

    /**
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "El apellido debe tener como máximo 45 caracteres"
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $apellido;

    /**
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "La dirección debe tener como máximo 50 caracteres"
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $direccion;

    /**
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "La localidad debe tener como máximo 45 caracteres"
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $localidad;

    /**
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "El CP debe tener como máximo 10 caracteres"
     * )
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
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "La ocupación debe tener como máximo 45 caracteres"
     * )
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $ocupacion;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"default" : 0})
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
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "El género debe tener como máximo 10 caracteres"
     * )
     * @ORM\Column(type="string", length=10)
     */
    private $genero;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    private $diasPrueba;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="Alumno")
     */
    private $FichasMedicas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TelefonoAlumno", mappedBy="Alumno", orphanRemoval=true,  cascade={"persist", "remove"})
     */
    private $Telefonos;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $inactivo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Combo", mappedBy="Alumno")
     */
    private $Combos;
	
    public function __construct()
    {
        $this->localidad = "Resistencia";
        $this->balance = 0;
        $this->cp = 3500;
        $this->inactivo = 0;
        $this->Telefonos = new ArrayCollection();
        $this->FichasMedicas = new ArrayCollection();
        $this->Combos = new ArrayCollection();
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

    public function getInactivo(): ?bool
    {
        return $this->inactivo;
    }

    public function setInactivo(bool $inactivo): self
    {
        $this->inactivo = $inactivo;

        return $this;
    }

	public function __toString()
    {
        return $this->getApellido().', '.$this->getNombre();
    }
	
	/**
	* @return Collection|FichaMedica[]
	*/
	public function getFichasMedicas(): Collection
	{
		return $this->FichasMedicas;
	}
	public function addFichaMedica(FichaMedica $fichaMedica): self
	{
		if (!$this->FichasMedicas->contains($fichaMedica)) {
			$this->FichasMedicas[] = $fichaMedica;
			$fichaMedica->setAlumno($this);
		}
		return $this;
	}
	public function removeFichaMedica(FichaMedica $fichaMedica): self
	{
		if ($this->FichasMedicas->contains($fichaMedica)) {
			$this->FichasMedicas->removeElement($fichaMedica);
			// set the owning side to null (unless already changed)
			if ($fichaMedica->getAlumno() === $this) {
				$fichaMedica->setAlumno(null);
				}
			}
		return $this;
	}
	
	/**
	* @return Collection|TelefonoAlumno[]
	*/
	public function getTelefonos(): Collection
	{
		return $this->Telefonos;
    }
    
	public function addTelefono(TelefonoAlumno $telefono): self
	{
		if (!$this->Telefonos->contains($telefono)) {
			$this->Telefonos[] = $telefono;
			$telefono->setAlumno($this);
		}
		return $this;
    }
    
	public function removeTelefono(TelefonoAlumno $telefono): self
	{
		if ($this->Telefonos->contains($telefono)) {
			$this->Telefonos->removeElement($telefono);
			// set the owning side to null (unless already changed)
			if ($telefono->getAlumno() === $this) {
				$telefono->setAlumno(null);
				}
			}
		return $this;
	}
 /**
  * @return Collection|Combo[]
  */
 public function getCombos(): Collection
 {
     return $this->Combos;
 }
 public function addCombo(Combo $combo): self
 {
     if (!$this->Combos->contains($combo)) {
         $this->Combos[] = $combo;
         $combo->setAlumno($this);
     }
     return $this;
 }
 public function removeCombo(Combo $combo): self
 {
     if ($this->Combos->contains($combo)) {
         $this->Combos->removeElement($combo);
         // set the owning side to null (unless already changed)
         if ($combo->getAlumno() === $this) {
             $combo->setAlumno(null);
         }
     }
     return $this;
 }
}
