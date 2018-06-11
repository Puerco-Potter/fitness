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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="telefonos")
     */
    private $alumno;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FichaMedica", inversedBy="telefonos")
     */
    private $fichaMedica;

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

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }

    public function getFichaMedica(): ?FichaMedica
    {
        return $this->fichaMedica;
    }

    public function setFichaMedica(?FichaMedica $fichaMedica): self
    {
        $this->fichaMedica = $fichaMedica;

        return $this;
    }
}
