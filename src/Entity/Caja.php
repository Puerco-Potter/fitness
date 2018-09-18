<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CajaRepository")
 */
class Caja
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $apertura;

    /**
     * @ORM\Column(type="time")
     */
    private $cierre;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $saldoInicial;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $saldoFinal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empleado")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Empleado;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="Caja")
     */
    private $Movimientos;

    public function __construct()
    {
        $this->Movimientos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getApertura(): ?\DateTimeInterface
    {
        return $this->apertura;
    }

    public function setApertura(\DateTimeInterface $apertura): self
    {
        $this->apertura = $apertura;

        return $this;
    }

    public function getCierre(): ?\DateTimeInterface
    {
        return $this->cierre;
    }

    public function setCierre(\DateTimeInterface $cierre): self
    {
        $this->cierre = $cierre;

        return $this;
    }

    public function getSaldoInicial()
    {
        return $this->saldoInicial;
    }

    public function setSaldoInicial($saldoInicial): self
    {
        $this->saldoInicial = $saldoInicial;

        return $this;
    }

    public function getSaldoFinal()
    {
        return $this->saldoFinal;
    }

    public function setSaldoFinal($saldoFinal): self
    {
        $this->saldoFinal = $saldoFinal;

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

    /**
     * @return Collection|Movimiento[]
     */
    public function getMovimientos(): Collection
    {
        return $this->Movimientos;
    }

    public function addMovimiento(Movimiento $movimiento): self
    {
        if (!$this->Movimientos->contains($movimiento)) {
            $this->Movimientos[] = $movimiento;
            $movimiento->setCaja($this);
        }

        return $this;
    }

    public function removeMovimiento(Movimiento $movimiento): self
    {
        if ($this->Movimientos->contains($movimiento)) {
            $this->Movimientos->removeElement($movimiento);
            // set the owning side to null (unless already changed)
            if ($movimiento->getCaja() === $this) {
                $movimiento->setCaja(null);
            }
        }

        return $this;
    }  
    
    public function __toString()
    {
        return (string) $this->getFecha()->format('Y/m/d');
    }
}
