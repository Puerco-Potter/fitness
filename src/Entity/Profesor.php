<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesorRepository")
 */
class Profesor extends Empleado
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Clase", mappedBy="Profesor")
    */
    private $Clases;
 
    public function __construct()
    {
        parent::__construct();
        $this->Clases = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getApellido().', '.$this->getNombre();
    }

    /**
     * @return Collection|Clase[]
    */
    public function getClases(): Collection
    {
        return $this->Clases;
    }

    public function addClase(Clase $clase): self
    {
        if (!$this->Clases->contains($clase)) {
            $this->Clases[] = $clase;
            $clase->setProfesor($this);
        }
        return $this;
    }
    public function removeClase(Clase $clase): self
    {
        if ($this->Clases->contains($clase)) {
            $this->Clases->removeElement($clase);
            // set the owning side to null (unless already changed)
            if ($clase->getProfesor() === $this) {
                $clase->setProfesor(null);
            }
        }
        return $this;
    }

}
