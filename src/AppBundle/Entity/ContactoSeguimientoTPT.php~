<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContactoSeguimientoTPT
 *
 * @ORM\Table(name="contacto_seguimiento_t_p_t")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoSeguimientoTPTRepository")
 */
class ContactoSeguimientoTPT
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
     * @ORM\OneToOne(targetEntity="ContactoSeguimiento" ,inversedBy="contactoSeguimientoTPT")
     * @ORM\JoinColumn(name="contacto_seguimiento_id" , referencedColumnName="id")
     */
    private $contactoSeguimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="prescripcion", type="boolean")
     */
    private $prescripcion = false;

    /**
     * @var int
     *
     * @ORM\Column(name="peso", type="integer")
     */
    private $peso = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="talla", type="integer", nullable=true)
     */
    private $talla = 0;

    /**
     * @ORM\ManyToOne(targetEntity="MedicamentoPrimeraLinea",inversedBy="contactoSeguimientosTPT")
     */
    protected $medicamento;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion", type="string", length=100, nullable=true)
     */
    private $duracion;

    /**
     * @var string
     *
     * @ORM\Column(name="porqueDuracion", type="text", nullable=true)
     */
    private $porqueDuracion;

    /**
     * @var bool
     *
     * @ORM\Column(name="vih", type="boolean")
     */
    private $vih = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaPrescripcion", type="date", nullable=true)
     */
    private $fechaPrescripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="iniciacion", type="boolean")
     */
    private $iniciacion = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="personaNegada", type="boolean")
     */
    private $personaNegada = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaPrimeraDosis", type="date", nullable=true)
     */
    private $fechaPrimeraDosis;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaUltimaDosis", type="date", nullable=true)
     */
    private $fechaUltimaDosis;

    /**
     * @var string
     *
     * @ORM\Column(name="regimenPrescrito", type="string", length=100, nullable=true)
     */
    private $regimenPrescrito;

    /**
     * @var int
     *
     * @ORM\Column(name="noTabletas", type="integer", nullable=true)
     */
    private $noTabletas = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="noDias", type="integer", nullable=true)
     */
    private $noDias = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="reaccionAdversa", type="boolean")
     */
    private $reaccionAdversa = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaInicioReaccionAdversa", type="date", nullable=true)
     */
    private $fechaInicioReaccionAdversa;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaFinalReaccionAdversa", type="date", nullable=true)
     */
    private $fechaFinalReaccionAdversa;

    /**
     * @var bool
     *
     * @ORM\Column(name="provocoSuspension", type="boolean")
     */
    private $provocoSuspension = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="provocoModificacion", type="boolean")
     */
    private $provocoModificacion = false;

    /**
     * @var string
     *
     * @ORM\Column(name="administracion", type="string", length=100)
     */
    private $administracion;

    /**
     * @var int
     *
     * @ORM\Column(name="noDosisSaltadas", type="integer", nullable=true)
     */
    private $noDosisSaltadas = 0;

    /**
     * @ORM\ManyToOne(targetEntity="ResultadoTratamiento",inversedBy="contactoSeguimientosTPT")
     */
    protected $resultado;

    /**
     * @var string
     *
     * @ORM\Column(name="causaSuspension", type="string", length=100, nullable=true)
     */
    private $causaSuspension;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaNotificacionTB", type="date", nullable=true)
     */
    private $fechaNotificacionTB;

    /**
     * @var string
     *
     * @ORM\Column(name="noRegistro", type="string", length=100, nullable=true)
     */
    private $noRegistro;

    /**
     * @ORM\ManyToMany(targetEntity="CausaNoPrescripcionTPT")
     * @ORM\JoinTable(name="contacto_causa_no_prescripcion",
     *     joinColumns={@ORM\JoinColumn(name="contacto_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="causa_no_prescripcion_id", referencedColumnName="id")}
     * )
     */
    private $contactoCausaNoPrescripcion;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->contactoCausaNoPrescripcion = new ArrayCollection();
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
     * Set prescripcion
     *
     * @param boolean $prescripcion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setPrescripcion($prescripcion)
    {
        $this->prescripcion = $prescripcion;

        return $this;
    }

    /**
     * Get prescripcion
     *
     * @return boolean
     */
    public function getPrescripcion()
    {
        return $this->prescripcion;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     *
     * @return ContactoSeguimientoTPT
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set talla
     *
     * @param integer $talla
     *
     * @return ContactoSeguimientoTPT
     */
    public function setTalla($talla)
    {
        $this->talla = $talla;

        return $this;
    }

    /**
     * Get talla
     *
     * @return integer
     */
    public function getTalla()
    {
        return $this->talla;
    }

    /**
     * Set duracion
     *
     * @param string $duracion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Get duracion
     *
     * @return string
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set porqueDuracion
     *
     * @param string $porqueDuracion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setPorqueDuracion($porqueDuracion)
    {
        $this->porqueDuracion = $porqueDuracion;

        return $this;
    }

    /**
     * Get porqueDuracion
     *
     * @return string
     */
    public function getPorqueDuracion()
    {
        return $this->porqueDuracion;
    }

    /**
     * Set vih
     *
     * @param boolean $vih
     *
     * @return ContactoSeguimientoTPT
     */
    public function setVih($vih)
    {
        $this->vih = $vih;

        return $this;
    }

    /**
     * Get vih
     *
     * @return boolean
     */
    public function getVih()
    {
        return $this->vih;
    }

    /**
     * Set fechaPrescripcion
     *
     * @param \DateTime $fechaPrescripcion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaPrescripcion($fechaPrescripcion)
    {
        $this->fechaPrescripcion = $fechaPrescripcion;

        return $this;
    }

    /**
     * Get fechaPrescripcion
     *
     * @return \DateTime
     */
    public function getFechaPrescripcion()
    {
        return $this->fechaPrescripcion;
    }

    /**
     * Set iniciacion
     *
     * @param boolean $iniciacion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setIniciacion($iniciacion)
    {
        $this->iniciacion = $iniciacion;

        return $this;
    }

    /**
     * Get iniciacion
     *
     * @return boolean
     */
    public function getIniciacion()
    {
        return $this->iniciacion;
    }

    /**
     * Set personaNegada
     *
     * @param boolean $personaNegada
     *
     * @return ContactoSeguimientoTPT
     */
    public function setPersonaNegada($personaNegada)
    {
        $this->personaNegada = $personaNegada;

        return $this;
    }

    /**
     * Get personaNegada
     *
     * @return boolean
     */
    public function getPersonaNegada()
    {
        return $this->personaNegada;
    }

    /**
     * Set fechaPrimeraDosis
     *
     * @param \DateTime $fechaPrimeraDosis
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaPrimeraDosis($fechaPrimeraDosis)
    {
        $this->fechaPrimeraDosis = $fechaPrimeraDosis;

        return $this;
    }

    /**
     * Get fechaPrimeraDosis
     *
     * @return \DateTime
     */
    public function getFechaPrimeraDosis()
    {
        return $this->fechaPrimeraDosis;
    }

    /**
     * Set fechaUltimaDosis
     *
     * @param \DateTime $fechaUltimaDosis
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaUltimaDosis($fechaUltimaDosis)
    {
        $this->fechaUltimaDosis = $fechaUltimaDosis;

        return $this;
    }

    /**
     * Get fechaUltimaDosis
     *
     * @return \DateTime
     */
    public function getFechaUltimaDosis()
    {
        return $this->fechaUltimaDosis;
    }

    /**
     * Set regimenPrescrito
     *
     * @param string $regimenPrescrito
     *
     * @return ContactoSeguimientoTPT
     */
    public function setRegimenPrescrito($regimenPrescrito)
    {
        $this->regimenPrescrito = $regimenPrescrito;

        return $this;
    }

    /**
     * Get regimenPrescrito
     *
     * @return string
     */
    public function getRegimenPrescrito()
    {
        return $this->regimenPrescrito;
    }

    /**
     * Set noTabletas
     *
     * @param integer $noTabletas
     *
     * @return ContactoSeguimientoTPT
     */
    public function setNoTabletas($noTabletas)
    {
        $this->noTabletas = $noTabletas;

        return $this;
    }

    /**
     * Get noTabletas
     *
     * @return integer
     */
    public function getNoTabletas()
    {
        return $this->noTabletas;
    }

    /**
     * Set noDias
     *
     * @param integer $noDias
     *
     * @return ContactoSeguimientoTPT
     */
    public function setNoDias($noDias)
    {
        $this->noDias = $noDias;

        return $this;
    }

    /**
     * Get noDias
     *
     * @return integer
     */
    public function getNoDias()
    {
        return $this->noDias;
    }

    /**
     * Set reaccionAdversa
     *
     * @param boolean $reaccionAdversa
     *
     * @return ContactoSeguimientoTPT
     */
    public function setReaccionAdversa($reaccionAdversa)
    {
        $this->reaccionAdversa = $reaccionAdversa;

        return $this;
    }

    /**
     * Get reaccionAdversa
     *
     * @return boolean
     */
    public function getReaccionAdversa()
    {
        return $this->reaccionAdversa;
    }

    /**
     * Set fechaInicioReaccionAdversa
     *
     * @param \DateTime $fechaInicioReaccionAdversa
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaInicioReaccionAdversa($fechaInicioReaccionAdversa)
    {
        $this->fechaInicioReaccionAdversa = $fechaInicioReaccionAdversa;

        return $this;
    }

    /**
     * Get fechaInicioReaccionAdversa
     *
     * @return \DateTime
     */
    public function getFechaInicioReaccionAdversa()
    {
        return $this->fechaInicioReaccionAdversa;
    }

    /**
     * Set fechaFinalReaccionAdversa
     *
     * @param \DateTime $fechaFinalReaccionAdversa
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaFinalReaccionAdversa($fechaFinalReaccionAdversa)
    {
        $this->fechaFinalReaccionAdversa = $fechaFinalReaccionAdversa;

        return $this;
    }

    /**
     * Get fechaFinalReaccionAdversa
     *
     * @return \DateTime
     */
    public function getFechaFinalReaccionAdversa()
    {
        return $this->fechaFinalReaccionAdversa;
    }

    /**
     * Set provocoSuspension
     *
     * @param boolean $provocoSuspension
     *
     * @return ContactoSeguimientoTPT
     */
    public function setProvocoSuspension($provocoSuspension)
    {
        $this->provocoSuspension = $provocoSuspension;

        return $this;
    }

    /**
     * Get provocoSuspension
     *
     * @return boolean
     */
    public function getProvocoSuspension()
    {
        return $this->provocoSuspension;
    }

    /**
     * Set provocoModificacion
     *
     * @param boolean $provocoModificacion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setProvocoModificacion($provocoModificacion)
    {
        $this->provocoModificacion = $provocoModificacion;

        return $this;
    }

    /**
     * Get provocoModificacion
     *
     * @return boolean
     */
    public function getProvocoModificacion()
    {
        return $this->provocoModificacion;
    }

    /**
     * Set administracion
     *
     * @param string $administracion
     *
     * @return ContactoSeguimientoTPT
     */
    public function setAdministracion($administracion)
    {
        $this->administracion = $administracion;

        return $this;
    }

    /**
     * Get administracion
     *
     * @return string
     */
    public function getAdministracion()
    {
        return $this->administracion;
    }

    /**
     * Set noDosisSaltadas
     *
     * @param integer $noDosisSaltadas
     *
     * @return ContactoSeguimientoTPT
     */
    public function setNoDosisSaltadas($noDosisSaltadas)
    {
        $this->noDosisSaltadas = $noDosisSaltadas;

        return $this;
    }

    /**
     * Get noDosisSaltadas
     *
     * @return integer
     */
    public function getNoDosisSaltadas()
    {
        return $this->noDosisSaltadas;
    }

    /**
     * Set causaSuspension
     *
     * @param string $causaSuspension
     *
     * @return ContactoSeguimientoTPT
     */
    public function setCausaSuspension($causaSuspension)
    {
        $this->causaSuspension = $causaSuspension;

        return $this;
    }

    /**
     * Get causaSuspension
     *
     * @return string
     */
    public function getCausaSuspension()
    {
        return $this->causaSuspension;
    }

    /**
     * Set fechaNotificacionTB
     *
     * @param \DateTime $fechaNotificacionTB
     *
     * @return ContactoSeguimientoTPT
     */
    public function setFechaNotificacionTB($fechaNotificacionTB)
    {
        $this->fechaNotificacionTB = $fechaNotificacionTB;

        return $this;
    }

    /**
     * Get fechaNotificacionTB
     *
     * @return \DateTime
     */
    public function getFechaNotificacionTB()
    {
        return $this->fechaNotificacionTB;
    }

    /**
     * Set noRegistro
     *
     * @param string $noRegistro
     *
     * @return ContactoSeguimientoTPT
     */
    public function setNoRegistro($noRegistro)
    {
        $this->noRegistro = $noRegistro;

        return $this;
    }

    /**
     * Get noRegistro
     *
     * @return string
     */
    public function getNoRegistro()
    {
        return $this->noRegistro;
    }

    /**
     * Set contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     *
     * @return ContactoSeguimientoTPT
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
     * Set medicamento
     *
     * @param \AppBundle\Entity\MedicamentoPrimeraLinea $medicamento
     *
     * @return ContactoSeguimientoTPT
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
     * Set resultado
     *
     * @param \AppBundle\Entity\ResultadoTratamiento $resultado
     *
     * @return ContactoSeguimientoTPT
     */
    public function setResultado(\AppBundle\Entity\ResultadoTratamiento $resultado = null)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return \AppBundle\Entity\ResultadoTratamiento
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Add contactoCausaNoPrescripcion
     *
     * @param \AppBundle\Entity\CausaNoPrescripcionTPT $contactoCausaNoPrescripcion
     *
     * @return ContactoSeguimientoTPT
     */
    public function addContactoCausaNoPrescripcion(\AppBundle\Entity\CausaNoPrescripcionTPT $contactoCausaNoPrescripcion)
    {
        $this->contactoCausaNoPrescripcion[] = $contactoCausaNoPrescripcion;

        return $this;
    }

    /**
     * Remove contactoCausaNoPrescripcion
     *
     * @param \AppBundle\Entity\CausaNoPrescripcionTPT $contactoCausaNoPrescripcion
     */
    public function removeContactoCausaNoPrescripcion(\AppBundle\Entity\CausaNoPrescripcionTPT $contactoCausaNoPrescripcion)
    {
        $this->contactoCausaNoPrescripcion->removeElement($contactoCausaNoPrescripcion);
    }

    /**
     * Get contactoCausaNoPrescripcion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactoCausaNoPrescripcion()
    {
        return $this->contactoCausaNoPrescripcion;
    }

    public function setContactoCausaNoPrescripcion($causas)
    {
        $this->contactoCausaNoPrescripcion = $causas;
    }
}
