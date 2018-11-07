<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     */
    private $Inscripcion;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\GreaterThanOrEqual(value = 0, message = "El monto debe ser mayor a $0")
     */
    private $monto;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value = 1, message = "El mes debe ser entre 1 y 12")
     * @Assert\LessThanOrEqual(value = 12, message = "El mes debe ser entre 1 y 12")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value = 2000, message = "Ingrese un año de 4 dígitos")
     * @Assert\LessThanOrEqual(value = 9999, message = "Ingrese un año de 4 dígitos")
     */
    private $ano;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaYHora;
	
	/**
     * @ORM\Column(type="string")
     */
    
	/**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */

	private $Cajero;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Combo", inversedBy="PagoCuotas")
    */
    private $Combo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Movimiento", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Movimiento;

    
	public function __construct()
    {
        $this->monto = 500;
        $this->fechaYHora =  new \DateTime();
        $this->mes =  (new \DateTime())->format('m');

        $this->ano =  (new \DateTime())->format('Y');

        $this->ano =  (new \DateTime())->format('Y');
		#$this->cajero = getUsername();

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

    public function getCajero(): ?User
    {
        return $this->Cajero;
    }

    public function setCajero(?User $User): self
    {
        $this->Cajero = $User;

        return $this;
    }
	
	#$this->get('security.token_storage')->getToken()->getUser();
	
	
    public function __toString()
    {
        return ' Pago de $ '.(string) $this->getMonto().' del '.$this->getMes().'/'.$this->getAno().'';
    }

    public function getFechaYHora(): ?\DateTimeInterface
    {
        return $this->fechaYHora;
    }

    public function setFechaYHora(\DateTimeInterface $fechaYHora): self
    {
        $this->fechaYHora = $fechaYHora;

        return $this;
    }

    public function getCombo(): ?Combo
    {
        return $this->Combo;
    }

    public function setCombo(?Combo $Combo): self
    {
        $this->Combo = $Combo;

        return $this;
    }

    public function getMovimiento(): ?Movimiento
    {
        return $this->Movimiento;
    }

    public function setMovimiento(Movimiento $Movimiento): self
    {
        $this->Movimiento = $Movimiento;

        return $this;
    }
}
