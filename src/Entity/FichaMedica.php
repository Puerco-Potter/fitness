<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FichaMedicaRepository")
 */
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

 
class FichaMedica
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
	/**
	 * @Assert\NotBlank()
	 * @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="FichasMedicas")
	 * @ORM\JoinColumn(nullable=false)
     */
    private $Alumno;
    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enfermedadesCardiacas;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lesionesCronicas;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rehabilitacion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $perderPeso;

    /**
     * @ORM\Column(type="boolean")
     */
    private $diabetes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bajoTratamiento;

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
    private $conoceImc;

    /**
     * @ORM\Column(type="boolean")
     */
    private $problemasArticulares;

    /**
     * @ORM\Column(type="boolean")
     */
    private $problemasEspalda;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dolores;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sobrepeso;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hipertenso;

    /**
     * @ORM\Column(type="boolean")
     */
    private $medicamentos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $embarazada;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hernias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hidratado;

    /**
	 * @Assert\NotBlank()
     * @ORM\Column(type="float", nullable=true)
     * @Assert\GreaterThanOrEqual(value = 0, message = "El peso debe ser un valor positivo")
     */
    private $peso;

    /**
	 * @Assert\NotBlank()
     * @ORM\Column(type="float", nullable=true)
     */
    private $altura;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $talla;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $tiempoEmbarazo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $listaMedicamentos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $listaEnfermedades;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telefonoEmergencia;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $grupoSanguineo;

    public function __construct()
    {
        $this->fecha = new \DateTime();
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

    public function getEnfermedadesCardiacas(): ?bool
    {
        return $this->enfermedadesCardiacas;
    }

    public function setEnfermedadesCardiacas(int $enfermedadesCardiacas): self
    {
        $this->enfermedadesCardiacas = $enfermedadesCardiacas;

        return $this;
    }

    public function getLesionesCronicas(): ?bool
    {
        return $this->lesionesCronicas;
    }

    public function setLesionesCronicas(bool $lesionesCronicas): self
    {
        $this->lesionesCronicas = $lesionesCronicas;

        return $this;
    }

    public function getRehabilitacion(): ?bool
    {
        return $this->rehabilitacion;
    }

    public function setRehabilitacion(bool $rehabilitacion): self
    {
        $this->rehabilitacion = $rehabilitacion;

        return $this;
    }

    public function getPerderPeso(): ?bool
    {
        return $this->perderPeso;
    }

    public function setPerderPeso(bool $perderPeso): self
    {
        $this->perderPeso = $perderPeso;

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

    public function getBajoTratamiento(): ?bool
    {
        return $this->bajoTratamiento;
    }

    public function setBajoTratamiento(bool $bajoTratamiento): self
    {
        $this->bajoTratamiento = $bajoTratamiento;

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

    public function getConoceImc(): ?bool
    {
        return $this->conoceImc;
    }

    public function setConoceImc(bool $conoceImc): self
    {
        $this->conoceImc = $conoceImc;

        return $this;
    }

    public function getProblemasArticulares(): ?bool
    {
        return $this->problemasArticulares;
    }

    public function setProblemasArticulares(bool $problemasArticulares): self
    {
        $this->problemasArticulares = $problemasArticulares;

        return $this;
    }

    public function getProblemasEspalda(): ?bool
    {
        return $this->problemasEspalda;
    }

    public function setProblemasEspalda(bool $problemasEspalda): self
    {
        $this->problemasEspalda = $problemasEspalda;

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

    public function getSobrepeso(): ?bool
    {
        return $this->sobrepeso;
    }

    public function setSobrepeso(bool $sobrepeso): self
    {
        $this->sobrepeso = $sobrepeso;

        return $this;
    }

    public function getHipertenso(): ?bool
    {
        return $this->hipertenso;
    }

    public function setHipertenso(bool $hipertenso): self
    {
        $this->hipertenso = $hipertenso;

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

    public function getEmbarazada(): ?bool
    {
        return $this->embarazada;
    }

    public function setEmbarazada(bool $embarazada): self
    {
        $this->embarazada = $embarazada;

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

    public function getTiempoEmbarazo(): ?string
    {
        return $this->tiempoEmbarazo;
    }

    public function setTiempoEmbarazo(string $tiempoEmbarazo): self
    {
        $this->tiempoEmbarazo = $tiempoEmbarazo;

        return $this;
    }

    public function getListaMedicamentos(): ?string
    {
        return $this->listaMedicamentos;
    }

    public function setListaMedicamentos(?string $listaMedicamentos): self
    {
        $this->listaMedicamentos = $listaMedicamentos;

        return $this;
    }

    public function getListaEnfermedades(): ?string
    {
        return $this->listaEnfermedades;
    }

    public function setListaEnfermedades(?string $listaEnfermedades): self
    {
        $this->listaEnfermedades = $listaEnfermedades;

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

    public function __toString()
    {
        return (string) $this->getAlumno().' - '. (string) $this->getFecha()->format('Y-m-d');
    }

    public function getTelefonoEmergencia(): ?string
    {
        return $this->telefonoEmergencia;
    }

    public function setTelefonoEmergencia(?string $TelefonoEmergencia): self
    {
        $this->telefonoEmergencia = $TelefonoEmergencia;

        return $this;
    }

    public function getGrupoSanguineo(): ?string
    {
        return $this->grupoSanguineo;
    }

    public function setGrupoSanguineo(?string $grupoSanguineo): self
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

}
