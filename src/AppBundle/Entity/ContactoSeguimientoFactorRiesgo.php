<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContactoSeguimientoFactorRiesgo
 *
 * @ORM\Table(name="contacto_seguimiento_factor_riesgo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoSeguimientoFactorRiesgoRepository")
 */
class ContactoSeguimientoFactorRiesgo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="ContactoSeguimiento" ,inversedBy="contactoSeguimientoFactorRiesgo")
     * @ORM\JoinColumn(name="contacto_seguimiento_id" , referencedColumnName="id")
     */
    private $contactoSeguimiento;

    /**
     * @ORM\ManyToOne(targetEntity="Parentesco",inversedBy="contactoSeguimientos")
     */
    protected $parantesco;

    /**
     * @var bool
     *
     * @ORM\Column(name="vacunado", type="boolean")
     */
    private $vacunado = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="tratadoTB", type="boolean")
     */
    private $tratadoTB = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaTratadoTB", type="date", nullable=true)
     */
    private $fechaTratadoTB;

    /**
     * @var string
     *
     * @ORM\Column(name="diagnosticoVIH", type="string", length=100)
     */
    private $diagnosticoVIH;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaRealizacionVIH", type="date", nullable=true)
     */
    private $fechaRealizacionVIH;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarvae", type="boolean")
     */
    private $tarvae = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaInicioTarvae", type="date", nullable=true)
     */
    private $fechaInicioTarvae;

    /**
     * @var bool
     *
     * @ORM\Column(name="tptTB", type="boolean")
     */
    private $tptTB = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaInicioTptTB", type="date", nullable=true)
     */
    private $fechaInicioTptTB;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaFinalTptTB", type="date", nullable=true)
     */
    private $fechaFinalTptTB;

    /**
     * @ORM\ManyToOne(targetEntity="MedicamentoPrimeraLinea",inversedBy="contactoSeguimientos")
     */
    protected $medicamento;

    /**
     * @var string
     *
     * @ORM\Column(name="porqueTPT", type="text", nullable=true)
     */
    private $porqueTPT;

    /**
     * @var bool
     *
     * @ORM\Column(name="otroFR", type="boolean")
     */
    private $otroFR = false;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToMany(targetEntity="FactorRiesgo")
     * @ORM\JoinTable(name="contacto_factorRiesgo",
     *     joinColumns={@ORM\JoinColumn(name="contacto_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="factorRiesgo_id", referencedColumnName="id")}
     * )
     */
    private $contacto_factorRiesgo;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->contacto_factorRiesgo = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setContactoSeguimiento(\AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento = null)
    {
        $this->contactoSeguimiento = $contactoSeguimiento;

        return $this;
    }

    /**
     * Get contactoSeguimiento
     *
     * @return \AppBundle\Entity\ContactoSeguimiento
     */
    public function getContactoSeguimiento()
    {
        return $this->contactoSeguimiento;
    }

    /**
     * Set vacunado
     *
     * @param boolean $vacunado
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setVacunado($vacunado)
    {
        $this->vacunado = $vacunado;

        return $this;
    }

    /**
     * Get vacunado
     *
     * @return boolean
     */
    public function getVacunado()
    {
        return $this->vacunado;
    }

    /**
     * Set tratadoTB
     *
     * @param boolean $tratadoTB
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setTratadoTB($tratadoTB)
    {
        $this->tratadoTB = $tratadoTB;

        return $this;
    }

    /**
     * Get tratadoTB
     *
     * @return boolean
     */
    public function getTratadoTB()
    {
        return $this->tratadoTB;
    }

    /**
     * Set fechaTratadoTB
     *
     * @param \DateTime $fechaTratadoTB
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setFechaTratadoTB($fechaTratadoTB)
    {
        $this->fechaTratadoTB = $fechaTratadoTB;

        return $this;
    }

    /**
     * Get fechaTratadoTB
     *
     * @return \DateTime
     */
    public function getFechaTratadoTB()
    {
        return $this->fechaTratadoTB;
    }

    /**
     * Set fechaRealizacionVIH
     *
     * @param \DateTime $fechaRealizacionVIH
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setFechaRealizacionVIH($fechaRealizacionVIH)
    {
        $this->fechaRealizacionVIH = $fechaRealizacionVIH;

        return $this;
    }

    /**
     * Get fechaRealizacionVIH
     *
     * @return \DateTime
     */
    public function getFechaRealizacionVIH()
    {
        return $this->fechaRealizacionVIH;
    }

    /**
     * Set tarvae
     *
     * @param boolean $tarvae
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setTarvae($tarvae)
    {
        $this->tarvae = $tarvae;

        return $this;
    }

    /**
     * Get tarvae
     *
     * @return boolean
     */
    public function getTarvae()
    {
        return $this->tarvae;
    }

    /**
     * Set fechaInicioTarvae
     *
     * @param \DateTime $fechaInicioTarvae
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setFechaInicioTarvae($fechaInicioTarvae)
    {
        $this->fechaInicioTarvae = $fechaInicioTarvae;

        return $this;
    }

    /**
     * Get fechaInicioTarvae
     *
     * @return \DateTime
     */
    public function getFechaInicioTarvae()
    {
        return $this->fechaInicioTarvae;
    }

    /**
     * Set tptTB
     *
     * @param boolean $tptTB
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setTptTB($tptTB)
    {
        $this->tptTB = $tptTB;

        return $this;
    }

    /**
     * Get tptTB
     *
     * @return boolean
     */
    public function getTptTB()
    {
        return $this->tptTB;
    }

    /**
     * Set fechaInicioTptTB
     *
     * @param \DateTime $fechaInicioTptTB
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setFechaInicioTptTB($fechaInicioTptTB)
    {
        $this->fechaInicioTptTB = $fechaInicioTptTB;

        return $this;
    }

    /**
     * Get fechaInicioTptTB
     *
     * @return \DateTime
     */
    public function getFechaInicioTptTB()
    {
        return $this->fechaInicioTptTB;
    }

    /**
     * Set fechaFinalTptTB
     *
     * @param \DateTime $fechaFinalTptTB
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setFechaFinalTptTB($fechaFinalTptTB)
    {
        $this->fechaFinalTptTB = $fechaFinalTptTB;

        return $this;
    }

    /**
     * Get fechaFinalTptTB
     *
     * @return \DateTime
     */
    public function getFechaFinalTptTB()
    {
        return $this->fechaFinalTptTB;
    }

    /**
     * Set porqueTPT
     *
     * @param string $porqueTPT
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setPorqueTPT($porqueTPT)
    {
        $this->porqueTPT = $porqueTPT;

        return $this;
    }

    /**
     * Get porqueTPT
     *
     * @return string
     */
    public function getPorqueTPT()
    {
        return $this->porqueTPT;
    }

    /**
     * Set otroFR
     *
     * @param boolean $otroFR
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setOtroFR($otroFR)
    {
        $this->otroFR = $otroFR;

        return $this;
    }

    /**
     * Get otroFR
     *
     * @return boolean
     */
    public function getOtroFR()
    {
        return $this->otroFR;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set parantesco
     *
     * @param \AppBundle\Entity\Parentesco $parantesco
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setParantesco(\AppBundle\Entity\Parentesco $parantesco = null)
    {
        $this->parantesco = $parantesco;

        return $this;
    }

    /**
     * Get parantesco
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getParantesco()
    {
        return $this->parantesco;
    }

    /**
     * Set medicamento
     *
     * @param \AppBundle\Entity\MedicamentoPrimeraLinea $medicamento
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setMedicamento(\AppBundle\Entity\MedicamentoPrimeraLinea $medicamento = null)
    {
        $this->medicamento = $medicamento;

        return $this;
    }

    /**
     * Get medicamento
     *
     * @return \AppBundle\Entity\MedicamentoPrimeraLinea
     */
    public function getMedicamento()
    {
        return $this->medicamento;
    }

    /**
     * Add contactoFactorRiesgo
     *
     * @param \AppBundle\Entity\FactorRiesgo $contactoFactorRiesgo
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function addContactoFactorRiesgo(\AppBundle\Entity\FactorRiesgo $contactoFactorRiesgo)
    {
        $this->contacto_factorRiesgo[] = $contactoFactorRiesgo;

        return $this;
    }

    /**
     * Remove contactoFactorRiesgo
     *
     * @param \AppBundle\Entity\FactorRiesgo $contactoFactorRiesgo
     */
    public function removeContactoFactorRiesgo(\AppBundle\Entity\FactorRiesgo $contactoFactorRiesgo)
    {
        $this->contacto_factorRiesgo->removeElement($contactoFactorRiesgo);
    }

    /**
     * Get contactoFactorRiesgo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactoFactorRiesgo()
    {
        return $this->contacto_factorRiesgo;
    }

    public function setContactoFactorRiesgo($factores)
    {
        $this->contacto_factorRiesgo = $factores;
    }

    /**
     * Set diagnosticoVIH
     *
     * @param string $diagnosticoVIH
     *
     * @return ContactoSeguimientoFactorRiesgo
     */
    public function setDiagnosticoVIH($diagnosticoVIH)
    {
        $this->diagnosticoVIH = $diagnosticoVIH;

        return $this;
    }

    /**
     * Get diagnosticoVIH
     *
     * @return string
     */
    public function getDiagnosticoVIH()
    {
        return $this->diagnosticoVIH;
    }
}
