<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelefonoEmpleadoRepository")
 */
class TelefonoEmpleado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tipo;

    /**
     * @ORM\Column(type="integer")
     */
    private $Caracteristica;

    /**
     * @ORM\Column(type="integer")
     */
    private $Numero;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empleado", inversedBy="Telefonos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Empleado;

    public function getId()
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->Tipo;
    }

    public function setTipo(string $Tipo): self
    {
        $this->Tipo = $Tipo;

        return $this;
    }

    public function getCaracteristica(): ?int
    {
        return $this->Caracteristica;
    }

    public function setCaracteristica(int $Caracteristica): self
    {
        $this->Caracteristica = $Caracteristica;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->Empleado;
    }

    public function setEmpleado(?Empleado $Empleado): self
    {
        $this->Empleado = $Empleado;

        return $this;
    }
    public function __toString()
    {
        return $this->getCaracteristica().' - '.$this->getNumero();
    }
}
