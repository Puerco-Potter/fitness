<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EjercicioRepository")
 */
class Ejercicio
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
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipamiento")
     */
    private $Equipamiento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Elemento")
     */
    private $Elemento;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $zonaMuscular;

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEquipamiento(): ?Equipamiento
    {
        return $this->Equipamiento;
    }

    public function setEquipamiento(?Equipamiento $Equipamiento): self
    {
        $this->Equipamiento = $Equipamiento;

        return $this;
    }

    public function getElemento(): ?Elemento
    {
        return $this->Elemento;
    }

    public function setElemento(?Elemento $Elemento): self
    {
        $this->Elemento = $Elemento;

        return $this;
    }

    public function getZonaMuscular(): ?string
    {
        return $this->zonaMuscular;
    }

    public function setZonaMuscular(?string $zonaMuscular): self
    {
        $this->zonaMuscular = $zonaMuscular;

        return $this;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }
}
