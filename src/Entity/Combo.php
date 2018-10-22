<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComboRepository")
 */
class Combo
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $monto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscripcion", mappedBy="Combo", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Inscripciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="Combos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Alumno;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PagoCuota", mappedBy="Combo")
     */
    private $PagoCuotas;

    public function __construct()
    {
        $this->fecha = new \DateTime();
        $this->Inscripciones = new ArrayCollection();
        $this->PagoCuotas = new ArrayCollection();
        $this->monto = 100;
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

    public function getMonto()
    {
        return $this->monto;
    }

    public function setMonto($monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * @return Collection|Inscripcion[]
     */
    public function getInscripciones(): Collection
    {
        return $this->Inscripciones;
    }

    public function addInscripcione(Inscripcion $inscripcione): self
    {
        if (!$this->Inscripciones->contains($inscripcione)) {
            $this->Inscripciones[] = $inscripcione;
            $inscripcione->setCombo($this);
        }

        return $this;
    }

    public function removeInscripcione(Inscripcion $inscripcione): self
    {
        if ($this->Inscripciones->contains($inscripcione)) {
            $this->Inscripciones->removeElement($inscripcione);
            // set the owning side to null (unless already changed)
            if ($inscripcione->getCombo() === $this) {
                $inscripcione->setCombo(null);
            }
        }

        return $this;
    }

    public function getAlumno(): ?Alumno
    {
        return $this->Alumno;
    }

    public function setAlumno(?Alumno $Alumno): self
    {
        $this->Alumno = $Alumno;

        return $this;
    }

    /**
     * @return Collection|PagoCuota[]
     */
    public function getPagoCuotas(): Collection
    {
        return $this->PagoCuotas;
    }

    public function addPagoCuota(PagoCuota $pagoCuota): self
    {
        if (!$this->PagoCuotas->contains($pagoCuota)) {
            $this->PagoCuotas[] = $pagoCuota;
            $pagoCuota->setCombo($this);
        }

        return $this;
    }

    public function removePagoCuota(PagoCuota $pagoCuota): self
    {
        if ($this->PagoCuotas->contains($pagoCuota)) {
            $this->PagoCuotas->removeElement($pagoCuota);
            // set the owning side to null (unless already changed)
            if ($pagoCuota->getCombo() === $this) {
                $pagoCuota->setCombo(null);
            }
        }

        return $this;
    }

	public function __toString()
    {
        $cadena = $this->getAlumno();
        foreach ($this->getInscripciones() as $x)
        {
            $cadena = $cadena.' - '.(string) $x->getClase()->getActividad();
        }
        return $cadena;

    }
}
