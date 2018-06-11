<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FichaMedicaRepository")
 */
class FichaMedica
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $enfermedades_cardiacas;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $lesiones_cronicas;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $rehabilitacion;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $perder_peso;

    /**
     * @ORM\Column(type="boolean")
     */
    private $diabetes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cirugia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dieta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $problemas_articulares;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dolores;

    /**
     * @ORM\Column(type="boolean")
     */
    private $problemas_espalda;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sobrepeso;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hipertension;

    /**
     * @ORM\Column(type="boolean")
     */
    private $medicamentos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $embarazo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hernias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hidratado;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $peso;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $altura;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $talla;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="FichaMedica")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cliente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="fichasMedicas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $alumno;

    public function getId()
    {
        return $this->id;
    }

    public function getEnfermedadesCardiacas(): ?bool
    {
        return $this->enfermedades_cardiacas;
    }

    public function setEnfermedadesCardiacas(?bool $enfermedades_cardiacas): self
    {
        $this->enfermedades_cardiacas = $enfermedades_cardiacas;

        return $this;
    }

    public function getLesionesCronicas(): ?bool
    {
        return $this->lesiones_cronicas;
    }

    public function setLesionesCronicas(?bool $lesiones_cronicas): self
    {
        $this->lesiones_cronicas = $lesiones_cronicas;

        return $this;
    }

    public function getRehabilitacion(): ?bool
    {
        return $this->rehabilitacion;
    }

    public function setRehabilitacion(?bool $rehabilitacion): self
    {
        $this->rehabilitacion = $rehabilitacion;

        return $this;
    }

    public function getPerderPeso(): ?bool
    {
        return $this->perder_peso;
    }

    public function setPerderPeso(?bool $perder_peso): self
    {
        $this->perder_peso = $perder_peso;

        return $this;
    }

    public function getDiabetes(): ?bool
    {
        return $this->diabetes;
    }

    public function setDiabetes(bool $diabetes): self
    {
        $this->diabetes = $diabetes;

        return $this;
    }

    public function getCirugia(): ?bool
    {
        return $this->cirugia;
    }

    public function setCirugia(bool $cirugia): self
    {
        $this->cirugia = $cirugia;

        return $this;
    }

    public function getDieta(): ?bool
    {
        return $this->dieta;
    }

    public function setDieta(bool $dieta): self
    {
        $this->dieta = $dieta;

        return $this;
    }

    public function getProblemasArticulares(): ?bool
    {
        return $this->problemas_articulares;
    }

    public function setProblemasArticulares(bool $problemas_articulares): self
    {
        $this->problemas_articulares = $problemas_articulares;

        return $this;
    }

    public function getDolores(): ?bool
    {
        return $this->dolores;
    }

    public function setDolores(bool $dolores): self
    {
        $this->dolores = $dolores;

        return $this;
    }

    public function getProblemasEspalda(): ?bool
    {
        return $this->problemas_espalda;
    }

    public function setProblemasEspalda(bool $problemas_espalda): self
    {
        $this->problemas_espalda = $problemas_espalda;

        return $this;
    }

    public function getSobrepeso(): ?bool
    {
        return $this->sobrepeso;
    }

    public function setSobrepeso(bool $sobrepeso): self
    {
        $this->sobrepeso = $sobrepeso;

        return $this;
    }

    public function getHipertension(): ?bool
    {
        return $this->hipertension;
    }

    public function setHipertension(bool $hipertension): self
    {
        $this->hipertension = $hipertension;

        return $this;
    }

    public function getMedicamentos(): ?bool
    {
        return $this->medicamentos;
    }

    public function setMedicamentos(bool $medicamentos): self
    {
        $this->medicamentos = $medicamentos;

        return $this;
    }

    public function getEmbarazo(): ?bool
    {
        return $this->embarazo;
    }

    public function setEmbarazo(bool $embarazo): self
    {
        $this->embarazo = $embarazo;

        return $this;
    }

    public function getHernias(): ?bool
    {
        return $this->hernias;
    }

    public function setHernias(bool $hernias): self
    {
        $this->hernias = $hernias;

        return $this;
    }

    public function getHidratado(): ?bool
    {
        return $this->hidratado;
    }

    public function setHidratado(bool $hidratado): self
    {
        $this->hidratado = $hidratado;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(?float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getAltura(): ?float
    {
        return $this->altura;
    }

    public function setAltura(?float $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getTalla(): ?string
    {
        return $this->talla;
    }

    public function setTalla(?string $talla): self
    {
        $this->talla = $talla;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->Cliente;
    }

    public function setCliente(?Cliente $Cliente): self
    {
        $this->Cliente = $Cliente;

        return $this;
    }
    public function __toString()
    {
        return strval($this->getId());
    }

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }
}
