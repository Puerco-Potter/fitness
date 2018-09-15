<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalaRepository")
 */
class Sala
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
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value = 1, message = "La capacidad debe ser mayor o igual que 1")
     */
    private $capacidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Clase", mappedBy="Sala")
     */
    private $Clases;

    public function __construct()
    {
        $this->Clases = new ArrayCollection();
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

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(int $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }
	public function __toString()
    {
        return $this->getDescripcion();
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
         $clase->setSala($this);
     }
     return $this;
 }
 
 public function removeClase(Clase $clase): self
 {
     if ($this->Clases->contains($clase)) {
         $this->Clases->removeElement($clase);
         // set the owning side to null (unless already changed)
         if ($clase->getSala() === $this) {
             $clase->setSala(null);
         }
     }
     return $this;
 }
}
