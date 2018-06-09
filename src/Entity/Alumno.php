<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlumnoRepository")
 */
class Alumno
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="alumno", orphanRemoval=true)
     */
    private $fichasMedicas;

    public function __construct()
    {
        $this->fichasMedicas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|FichaMedica[]
     */
    public function getFichasMedicas(): Collection
    {
        return $this->fichasMedicas;
    }

    public function addFichasMedica(FichaMedica $fichasMedica): self
    {
        if (!$this->fichasMedicas->contains($fichasMedica)) {
            $this->fichasMedicas[] = $fichasMedica;
            $fichasMedica->setAlumno($this);
        }

        return $this;
    }

    public function removeFichasMedica(FichaMedica $fichasMedica): self
    {
        if ($this->fichasMedicas->contains($fichasMedica)) {
            $this->fichasMedicas->removeElement($fichasMedica);
            // set the owning side to null (unless already changed)
            if ($fichasMedica->getAlumno() === $this) {
                $fichasMedica->setAlumno(null);
            }
        }

        return $this;
    }
}
