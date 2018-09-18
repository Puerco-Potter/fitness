<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificacionRepository")
 */
class Notificacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Creacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Descripcion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreacion(): ?\DateTimeInterface
    {
        return $this->Creacion;
    }

    public function setCreacion(?\DateTimeInterface $Creacion): self
    {
        $this->Creacion = $Creacion;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(?string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }
}
