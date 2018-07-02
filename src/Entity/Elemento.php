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
     * @ORM\Column(type="string", length=45)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ultReposicion;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

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

    public function getUltReposicion(): ?\DateTimeInterface
    {
        return $this->ultReposicion;
    }

    public function setUltReposicion(?\DateTimeInterface $ultReposicion): self
    {
        $this->ultReposicion = $ultReposicion;

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
