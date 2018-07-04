<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElementoRepository")
 */
class Elemento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *      max = 45,
     *      maxMessage = "La descripción debe tener como máximo 45 caracteres"
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date")
     */
    private $ultimaReposicion;

    /**
     * @ORM\Column(type="integer", options= {"default": 1})
     */
    private $cantidad;	

    public function __construct()
    {
        $this->ultimaReposicion = new \DateTime();
        $this->cantidad = 1;
    }

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

    public function getUltimaReposicion(): ?\DateTimeInterface
    {
        return $this->ultimaReposicion;
    }

    public function setUltimaReposicion(?\DateTimeInterface $ultimaReposicion): self
    {
        $this->ultimaReposicion = $ultimaReposicion;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }
	public function __toString()
    {
        return $this->getDescripcion();
    }
}
