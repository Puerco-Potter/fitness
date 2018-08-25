<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PagoCuotaRepository")
 */
class PagoCuota
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscripcion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Inscripcion;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $monto;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $ano;

    public function __construct()
    {
        $this->monto = 500;
        $this->mes =  (new \DateTime())->format('m');
        $this->ano =  (new \DateTime())->format('y');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getInscripcion(): ?Inscripcion
    {
        return $this->Inscripcion;
    }

    public function setInscripcion(?Inscripcion $Inscripcion): self
    {
        $this->Inscripcion = $Inscripcion;

        return $this;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setMonto($monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function setAno(int $ano): self
    {
        $this->ano = $ano;

        return $this;
    }
    
    public function __toString()
    {
        return '$ '.(string) $this->getMonto().' - '.$this->getMes().' - '.$this->getAno();
    }
}
