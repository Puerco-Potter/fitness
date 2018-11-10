<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineaPlanRepository")
 */
class LineaPlan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Musculo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $musculo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ejercicio")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ejercicio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dias6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $r6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $f7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $s7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c7;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMusculo(): ?musculo
    {
        return $this->musculo;
    }

    public function setMusculo(?musculo $musculo): self
    {
        $this->musculo = $musculo;

        return $this;
    }

    public function getEjercicio(): ?ejercicio
    {
        return $this->ejercicio;
    }

    public function setEjercicio(?ejercicio $ejercicio): self
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getDias1(): ?string
    {
        return $this->dias1;
    }

    public function setDias1(?string $dias1): self
    {
        $this->dias1 = $dias1;

        return $this;
    }

    public function getDias2(): ?string
    {
        return $this->dias2;
    }

    public function setDias2(?string $dias2): self
    {
        $this->dias2 = $dias2;

        return $this;
    }

    public function getDias3(): ?string
    {
        return $this->dias3;
    }

    public function setDias3(?string $dias3): self
    {
        $this->dias3 = $dias3;

        return $this;
    }

    public function getDias4(): ?string
    {
        return $this->dias4;
    }

    public function setDias4(?string $dias4): self
    {
        $this->dias4 = $dias4;

        return $this;
    }

    public function getDias5(): ?string
    {
        return $this->dias5;
    }

    public function setDias5(?string $dias5): self
    {
        $this->dias5 = $dias5;

        return $this;
    }

    public function getDias6(): ?string
    {
        return $this->dias6;
    }

    public function setDias6(?string $dias6): self
    {
        $this->dias6 = $dias6;

        return $this;
    }

    public function getF1(): ?string
    {
        return $this->f1;
    }

    public function setF1(?string $f1): self
    {
        $this->f1 = $f1;

        return $this;
    }

    public function getF2(): ?string
    {
        return $this->f2;
    }

    public function setF2(?string $f2): self
    {
        $this->f2 = $f2;

        return $this;
    }

    public function getF3(): ?string
    {
        return $this->f3;
    }

    public function setF3(?string $f3): self
    {
        $this->f3 = $f3;

        return $this;
    }

    public function getF4(): ?string
    {
        return $this->f4;
    }

    public function setF4(?string $f4): self
    {
        $this->f4 = $f4;

        return $this;
    }

    public function getF5(): ?string
    {
        return $this->f5;
    }

    public function setF5(?string $f5): self
    {
        $this->f5 = $f5;

        return $this;
    }

    public function getF6(): ?string
    {
        return $this->f6;
    }

    public function setF6(?string $f6): self
    {
        $this->f6 = $f6;

        return $this;
    }

    public function getS1(): ?string
    {
        return $this->s1;
    }

    public function setS1(?string $s1): self
    {
        $this->s1 = $s1;

        return $this;
    }

    public function getS2(): ?string
    {
        return $this->s2;
    }

    public function setS2(?string $s2): self
    {
        $this->s2 = $s2;

        return $this;
    }

    public function getS3(): ?string
    {
        return $this->s3;
    }

    public function setS3(?string $s3): self
    {
        $this->s3 = $s3;

        return $this;
    }

    public function getS4(): ?string
    {
        return $this->s4;
    }

    public function setS4(?string $s4): self
    {
        $this->s4 = $s4;

        return $this;
    }

    public function getS5(): ?string
    {
        return $this->s5;
    }

    public function setS5(?string $s5): self
    {
        $this->s5 = $s5;

        return $this;
    }

    public function getS6(): ?string
    {
        return $this->s6;
    }

    public function setS6(?string $s6): self
    {
        $this->s6 = $s6;

        return $this;
    }

    public function getR1(): ?string
    {
        return $this->r1;
    }

    public function setR1(?string $r1): self
    {
        $this->r1 = $r1;

        return $this;
    }

    public function getR2(): ?string
    {
        return $this->r2;
    }

    public function setR2(?string $r2): self
    {
        $this->r2 = $r2;

        return $this;
    }

    public function getR3(): ?string
    {
        return $this->r3;
    }

    public function setR3(?string $r3): self
    {
        $this->r3 = $r3;

        return $this;
    }

    public function getR4(): ?string
    {
        return $this->r4;
    }

    public function setR4(?string $r4): self
    {
        $this->r4 = $r4;

        return $this;
    }

    public function getR5(): ?string
    {
        return $this->r5;
    }

    public function setR5(?string $r5): self
    {
        $this->r5 = $r5;

        return $this;
    }

    public function getR6(): ?string
    {
        return $this->r6;
    }

    public function setR6(string $r6): self
    {
        $this->r6 = $r6;

        return $this;
    }

    public function getC1(): ?string
    {
        return $this->c1;
    }

    public function setC1(?string $c1): self
    {
        $this->c1 = $c1;

        return $this;
    }

    public function getC2(): ?string
    {
        return $this->c2;
    }

    public function setC2(?string $c2): self
    {
        $this->c2 = $c2;

        return $this;
    }

    public function getC3(): ?string
    {
        return $this->c3;
    }

    public function setC3(?string $c3): self
    {
        $this->c3 = $c3;

        return $this;
    }

    public function getC4(): ?string
    {
        return $this->c4;
    }

    public function setC4(?string $c4): self
    {
        $this->c4 = $c4;

        return $this;
    }

    public function getC5(): ?string
    {
        return $this->c5;
    }

    public function setC5(?string $c5): self
    {
        $this->c5 = $c5;

        return $this;
    }

    public function getC6(): ?string
    {
        return $this->c6;
    }

    public function setC6(?string $c6): self
    {
        $this->c6 = $c6;

        return $this;
    }

    public function getF7(): ?string
    {
        return $this->f7;
    }

    public function setF7(?string $f7): self
    {
        $this->f7 = $f7;

        return $this;
    }

    public function getS7(): ?string
    {
        return $this->s7;
    }

    public function setS7(?string $s7): self
    {
        $this->s7 = $s7;

        return $this;
    }

    public function getR7(): ?string
    {
        return $this->r7;
    }

    public function setR7(?string $r7): self
    {
        $this->r7 = $r7;

        return $this;
    }

    public function getC7(): ?string
    {
        return $this->c7;
    }

    public function setC7(?string $c7): self
    {
        $this->c7 = $c7;

        return $this;
    }
}
