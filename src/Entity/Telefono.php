<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Mapping;

/**
 * @ORM\MappedSuperclass
 */
abstract class Telefono
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="string", length=6)
     */
    protected $caracteristica;

    /**
     * @ORM\Column(type="string", length=12)
     */
    protected $numero;

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
        return $this->getTipo().' - '.$this->getCaracteristica().'-'.$this->getNumero();
    }

}
