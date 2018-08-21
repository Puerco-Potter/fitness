<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ESEmpleadoRepository")
 */
class ESEmpleado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaYHora;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empleado")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Empleado;

    public function __construct()
    {
        $this->fechaYHora = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFechaYHora(): ?\DateTimeInterface
    {
        return $this->fechaYHora;
    }

    public function setFechaYHora(\DateTimeInterface $fechaYHora): self
    {
        $this->fechaYHora = $fechaYHora;

        return $this;
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
        return (string) $this->getFechaYHora()->format('Y-m-d');
    }
}
