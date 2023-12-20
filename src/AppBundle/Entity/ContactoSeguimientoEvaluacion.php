<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * ContactoSeguimientoEvaluacion
 *
 * @ORM\Table(name="contacto_seguimiento_evaluacion",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA01", columns={"contacto_seguimiento_id", "mes"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoSeguimientoEvaluacionRepository")
 */
class ContactoSeguimientoEvaluacion
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
     * @var DateTime
     *
     * @ORM\Column(name="fechaInicioEvaluacion", type="date")
     */
    private $fechaInicioEvaluacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="examenMedico", type="boolean")
     */
    private $examenMedico = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaExamenMedico", type="date", nullable=true)
     */
    private $fechaExamenMedico;

    /**
     * @var bool
     *
     * @ORM\Column(name="sintomaRespiratorio", type="boolean")
     */
    private $sintomaRespiratorio = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="pctIgraIndicado", type="boolean", nullable=true)
     */
    private $pctIgraIndicado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaPctIgraIndicado", type="date", nullable=true)
     */
    private $fechaPctIgraIndicado;

    /**
     * @var bool
     *
     * @ORM\Column(name="pctIgraRealizado", type="boolean", nullable=true)
     */
    private $pctIgraRealizado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaPctIgraRealizado", type="date", nullable=true)
     */
    private $fechaPctIgraRealizado;

    /**
     * @var string
     *
     * @ORM\Column(name="porqueNoPctIgra", type="text", nullable=true)
     */
    private $porqueNoPctIgra;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoPCT", type="string", length=100, nullable=true)
     */
    private $resultadoPCT;

    /**
     * @var int
     *
     * @ORM\Column(name="resultadoCuantitativo", type="integer", nullable=true)
     */
    private $resultadoCuantitativo;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaLecturaPCT", type="date", nullable=true)
     */
    private $fechaLecturaPCT;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoIGRA", type="string", length=100, nullable=true)
     */
    private $resultadoIGRA;

    /**
     * @var bool
     *
     * @ORM\Column(name="baciloscopiaIndicado", type="boolean")
     */
    private $baciloscopiaIndicado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaBaciloscopiaIndicado", type="date", nullable=true)
     */
    private $fechaBaciloscopiaIndicado;

    /**
     * @var bool
     *
     * @ORM\Column(name="baciloscopiaRealizado", type="boolean")
     */
    private $baciloscopiaRealizado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaBaciloscopiaRealizado", type="date", nullable=true)
     */
    private $fechaBaciloscopiaRealizado;

    /**
     * @var string
     *
     * @ORM\Column(name="hayResultadoBaciloscopia", type="string", length=20, nullable=true)
     */
    private $hayResultadoBaciloscopia;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaBaciloscopiaResultado", type="date", nullable=true)
     */
    private $fechaBaciloscopiaResultado;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoBaciloscopia", type="string", length=20, nullable=true)
     */
    private $resultadoBaciloscopia;

    /**
     * @var int
     *
     * @ORM\Column(name="codificacionBaciloscopia", type="integer", nullable=true)
     */
    private $codificacionBaciloscopia = 0;


    /**
     * @var bool
     *
     * @ORM\Column(name="cultivoIndicado", type="boolean")
     */
    private $cultivoIndicado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaCultivoIndicado", type="date", nullable=true)
     */
    private $fechaCultivoIndicado;

    /**
     * @var bool
     *
     * @ORM\Column(name="cultivoRealizado", type="boolean")
     */
    private $cultivoRealizado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaCultivoRealizado", type="date", nullable=true)
     */
    private $fechaCultivoRealizado;

    /**
     * @var string
     *
     * @ORM\Column(name="hayResultadoCultivo", type="string", length=20, nullable=true)
     */
    private $hayResultadoCultivo;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaCultivoResultado", type="date", nullable=true)
     */
    private $fechaCultivoResultado;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoCultivo", type="string", length=20, nullable=true)
     */
    private $resultadoCultivo;

    /**
     * @var int
     *
     * @ORM\Column(name="codificacionCultivo", type="integer", nullable=true)
     */
    private $codificacionCultivo = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="rayosXIndicado", type="boolean")
     */
    private $rayosXIndicado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaRayosXIndicado", type="date", nullable=true)
     */
    private $fechaRayosXIndicado;

    /**
     * @var bool
     *
     * @ORM\Column(name="rayosXRealizado", type="boolean")
     */
    private $rayosXRealizado = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaRayosXRealizado", type="date", nullable=true)
     */
    private $fechaRayosXRealizado;

    /**
     * @var string
     *
     * @ORM\Column(name="hayResultadoRayosX", type="string", length=20, nullable=true)
     */
    private $hayResultadoRayosX;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaRayosXResultado", type="date", nullable=true)
     */
    private $fechaRayosXResultado;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoRayosX", type="string", length=20, nullable=true)
     */
    private $resultadoRayosX;

    /**
     * @var bool
     *
     * @ORM\Column(name="rayoXLesionTB", type="boolean", nullable=true)
     */
    private $rayoXLesionTB = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="rayoXOtraLesion", type="boolean", nullable=true)
     */
    private $rayoXOtraLesion = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="xpertIndicado", type="boolean")
     */
    private $xpertIndicado = false;

    /**
     * @ORM\ManyToOne(targetEntity="ContactoSeguimiento",inversedBy="evaluaciones")
     */
    protected $contactoSeguimiento;

    /**
     * @var int
     *
     * @ORM\Column(name="mes", type="integer",nullable=true)
     */
    private $mes = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaResultado", type="date", nullable=true)
     */
    private $fechaResultado;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoEvaluacion", type="string", length=100, nullable=true)
     */
    private $resultadoEvaluacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="estadoPaciente", type="string", length=100, nullable=true)
     */
    private $estadoPaciente;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaInicioEvaluacion
     *
     * @param DateTime $fechaInicioEvaluacion
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaInicioEvaluacion($fechaInicioEvaluacion)
    {
        $this->fechaInicioEvaluacion = $fechaInicioEvaluacion;

        return $this;
    }

    /**
     * Get fechaInicioEvaluacion
     *
     * @return DateTime
     */
    public function getFechaInicioEvaluacion()
    {
        return $this->fechaInicioEvaluacion;
    }

    /**
     * Set examenMedico
     *
     * @param boolean $examenMedico
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setExamenMedico($examenMedico)
    {
        $this->examenMedico = $examenMedico;

        return $this;
    }

    /**
     * Get examenMedico
     *
     * @return boolean
     */
    public function getExamenMedico()
    {
        return $this->examenMedico;
    }

    /**
     * Set fechaExamenMedico
     *
     * @param DateTime $fechaExamenMedico
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaExamenMedico($fechaExamenMedico)
    {
        $this->fechaExamenMedico = $fechaExamenMedico;

        return $this;
    }

    /**
     * Get fechaExamenMedico
     *
     * @return DateTime
     */
    public function getFechaExamenMedico()
    {
        return $this->fechaExamenMedico;
    }

    /**
     * Set sintomaRespiratorio
     *
     * @param boolean $sintomaRespiratorio
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setSintomaRespiratorio($sintomaRespiratorio)
    {
        $this->sintomaRespiratorio = $sintomaRespiratorio;

        return $this;
    }

    /**
     * Get sintomaRespiratorio
     *
     * @return boolean
     */
    public function getSintomaRespiratorio()
    {
        return $this->sintomaRespiratorio;
    }

    /**
     * Set pctIgraIndicado
     *
     * @param boolean $pctIgraIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setPctIgraIndicado($pctIgraIndicado)
    {
        $this->pctIgraIndicado = $pctIgraIndicado;

        return $this;
    }

    /**
     * Get pctIgraIndicado
     *
     * @return boolean
     */
    public function getPctIgraIndicado()
    {
        return $this->pctIgraIndicado;
    }

    /**
     * Set fechaPctIgraIndicado
     *
     * @param DateTime $fechaPctIgraIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaPctIgraIndicado($fechaPctIgraIndicado)
    {
        $this->fechaPctIgraIndicado = $fechaPctIgraIndicado;

        return $this;
    }

    /**
     * Get fechaPctIgraIndicado
     *
     * @return DateTime
     */
    public function getFechaPctIgraIndicado()
    {
        return $this->fechaPctIgraIndicado;
    }

    /**
     * Set pctIgraRealizado
     *
     * @param boolean $pctIgraRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setPctIgraRealizado($pctIgraRealizado)
    {
        $this->pctIgraRealizado = $pctIgraRealizado;

        return $this;
    }

    /**
     * Get pctIgraRealizado
     *
     * @return boolean
     */
    public function getPctIgraRealizado()
    {
        return $this->pctIgraRealizado;
    }

    /**
     * Set fechaPctIgraRealizado
     *
     * @param DateTime $fechaPctIgraRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaPctIgraRealizado($fechaPctIgraRealizado)
    {
        $this->fechaPctIgraRealizado = $fechaPctIgraRealizado;

        return $this;
    }

    /**
     * Get fechaPctIgraRealizado
     *
     * @return DateTime
     */
    public function getFechaPctIgraRealizado()
    {
        return $this->fechaPctIgraRealizado;
    }

    /**
     * Set porqueNoPctIgra
     *
     * @param string $porqueNoPctIgra
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setPorqueNoPctIgra($porqueNoPctIgra)
    {
        $this->porqueNoPctIgra = $porqueNoPctIgra;

        return $this;
    }

    /**
     * Get porqueNoPctIgra
     *
     * @return string
     */
    public function getPorqueNoPctIgra()
    {
        return $this->porqueNoPctIgra;
    }

    /**
     * Set resultadoPCT
     *
     * @param string $resultadoPCT
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoPCT($resultadoPCT)
    {
        $this->resultadoPCT = $resultadoPCT;

        return $this;
    }

    /**
     * Get resultadoPCT
     *
     * @return string
     */
    public function getResultadoPCT()
    {
        return $this->resultadoPCT;
    }

    /**
     * Set resultadoCuantitativo
     *
     * @param string $resultadoCuantitativo
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoCuantitativo($resultadoCuantitativo)
    {
        $this->resultadoCuantitativo = $resultadoCuantitativo;

        return $this;
    }

    /**
     * Get resultadoCuantitativo
     *
     * @return string
     */
    public function getResultadoCuantitativo()
    {
        return $this->resultadoCuantitativo;
    }

    /**
     * Set fechaLecturaPCT
     *
     * @param DateTime $fechaLecturaPCT
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaLecturaPCT($fechaLecturaPCT)
    {
        $this->fechaLecturaPCT = $fechaLecturaPCT;

        return $this;
    }

    /**
     * Get fechaLecturaPCT
     *
     * @return DateTime
     */
    public function getFechaLecturaPCT()
    {
        return $this->fechaLecturaPCT;
    }

    /**
     * Set resultadoIGRA
     *
     * @param string $resultadoIGRA
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoIGRA($resultadoIGRA)
    {
        $this->resultadoIGRA = $resultadoIGRA;

        return $this;
    }

    /**
     * Get resultadoIGRA
     *
     * @return string
     */
    public function getResultadoIGRA()
    {
        return $this->resultadoIGRA;
    }

    /**
     * Set baciloscopiaIndicado
     *
     * @param boolean $baciloscopiaIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setBaciloscopiaIndicado($baciloscopiaIndicado)
    {
        $this->baciloscopiaIndicado = $baciloscopiaIndicado;

        return $this;
    }

    /**
     * Get baciloscopiaIndicado
     *
     * @return boolean
     */
    public function getBaciloscopiaIndicado()
    {
        return $this->baciloscopiaIndicado;
    }

    /**
     * Set fechaBaciloscopiaIndicado
     *
     * @param DateTime $fechaBaciloscopiaIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaBaciloscopiaIndicado($fechaBaciloscopiaIndicado)
    {
        $this->fechaBaciloscopiaIndicado = $fechaBaciloscopiaIndicado;

        return $this;
    }

    /**
     * Get fechaBaciloscopiaIndicado
     *
     * @return DateTime
     */
    public function getFechaBaciloscopiaIndicado()
    {
        return $this->fechaBaciloscopiaIndicado;
    }

    /**
     * Set baciloscopiaRealizado
     *
     * @param boolean $baciloscopiaRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setBaciloscopiaRealizado($baciloscopiaRealizado)
    {
        $this->baciloscopiaRealizado = $baciloscopiaRealizado;

        return $this;
    }

    /**
     * Get baciloscopiaRealizado
     *
     * @return boolean
     */
    public function getBaciloscopiaRealizado()
    {
        return $this->baciloscopiaRealizado;
    }

    /**
     * Set fechaBaciloscopiaRealizado
     *
     * @param DateTime $fechaBaciloscopiaRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaBaciloscopiaRealizado($fechaBaciloscopiaRealizado)
    {
        $this->fechaBaciloscopiaRealizado = $fechaBaciloscopiaRealizado;

        return $this;
    }

    /**
     * Get fechaBaciloscopiaRealizado
     *
     * @return DateTime
     */
    public function getFechaBaciloscopiaRealizado()
    {
        return $this->fechaBaciloscopiaRealizado;
    }

    /**
     * Set hayResultadoBaciloscopia
     *
     * @param string $hayResultadoBaciloscopia
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setHayResultadoBaciloscopia($hayResultadoBaciloscopia)
    {
        $this->hayResultadoBaciloscopia = $hayResultadoBaciloscopia;

        return $this;
    }

    /**
     * Get hayResultadoBaciloscopia
     *
     * @return string
     */
    public function getHayResultadoBaciloscopia()
    {
        return $this->hayResultadoBaciloscopia;
    }

    /**
     * Set fechaBaciloscopiaResultado
     *
     * @param DateTime $fechaBaciloscopiaResultado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaBaciloscopiaResultado($fechaBaciloscopiaResultado)
    {
        $this->fechaBaciloscopiaResultado = $fechaBaciloscopiaResultado;

        return $this;
    }

    /**
     * Get fechaBaciloscopiaResultado
     *
     * @return DateTime
     */
    public function getFechaBaciloscopiaResultado()
    {
        return $this->fechaBaciloscopiaResultado;
    }

    /**
     * Set resultadoBaciloscopia
     *
     * @param string $resultadoBaciloscopia
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoBaciloscopia($resultadoBaciloscopia)
    {
        $this->resultadoBaciloscopia = $resultadoBaciloscopia;

        return $this;
    }

    /**
     * Get resultadoBaciloscopia
     *
     * @return string
     */
    public function getResultadoBaciloscopia()
    {
        return $this->resultadoBaciloscopia;
    }

    /**
     * Set codificacionBaciloscopia
     *
     * @param integer $codificacionBaciloscopia
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setCodificacionBaciloscopia($codificacionBaciloscopia)
    {
        $this->codificacionBaciloscopia = $codificacionBaciloscopia;

        return $this;
    }

    /**
     * Get codificacionBaciloscopia
     *
     * @return integer
     */
    public function getCodificacionBaciloscopia()
    {
        return $this->codificacionBaciloscopia;
    }

    /**
     * Set cultivoIndicado
     *
     * @param boolean $cultivoIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setCultivoIndicado($cultivoIndicado)
    {
        $this->cultivoIndicado = $cultivoIndicado;

        return $this;
    }

    /**
     * Get cultivoIndicado
     *
     * @return boolean
     */
    public function getCultivoIndicado()
    {
        return $this->cultivoIndicado;
    }

    /**
     * Set fechaCultivoIndicado
     *
     * @param DateTime $fechaCultivoIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaCultivoIndicado($fechaCultivoIndicado)
    {
        $this->fechaCultivoIndicado = $fechaCultivoIndicado;

        return $this;
    }

    /**
     * Get fechaCultivoIndicado
     *
     * @return DateTime
     */
    public function getFechaCultivoIndicado()
    {
        return $this->fechaCultivoIndicado;
    }

    /**
     * Set cultivoRealizado
     *
     * @param boolean $cultivoRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setCultivoRealizado($cultivoRealizado)
    {
        $this->cultivoRealizado = $cultivoRealizado;

        return $this;
    }

    /**
     * Get cultivoRealizado
     *
     * @return boolean
     */
    public function getCultivoRealizado()
    {
        return $this->cultivoRealizado;
    }

    /**
     * Set fechaCultivoRealizado
     *
     * @param DateTime $fechaCultivoRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaCultivoRealizado($fechaCultivoRealizado)
    {
        $this->fechaCultivoRealizado = $fechaCultivoRealizado;

        return $this;
    }

    /**
     * Get fechaCultivoRealizado
     *
     * @return DateTime
     */
    public function getFechaCultivoRealizado()
    {
        return $this->fechaCultivoRealizado;
    }

    /**
     * Set hayResultadoCultivo
     *
     * @param string $hayResultadoCultivo
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setHayResultadoCultivo($hayResultadoCultivo)
    {
        $this->hayResultadoCultivo = $hayResultadoCultivo;

        return $this;
    }

    /**
     * Get hayResultadoCultivo
     *
     * @return string
     */
    public function getHayResultadoCultivo()
    {
        return $this->hayResultadoCultivo;
    }

    /**
     * Set fechaCultivoResultado
     *
     * @param DateTime $fechaCultivoResultado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaCultivoResultado($fechaCultivoResultado)
    {
        $this->fechaCultivoResultado = $fechaCultivoResultado;

        return $this;
    }

    /**
     * Get fechaCultivoResultado
     *
     * @return DateTime
     */
    public function getFechaCultivoResultado()
    {
        return $this->fechaCultivoResultado;
    }

    /**
     * Set resultadoCultivo
     *
     * @param string $resultadoCultivo
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoCultivo($resultadoCultivo)
    {
        $this->resultadoCultivo = $resultadoCultivo;

        return $this;
    }

    /**
     * Get resultadoCultivo
     *
     * @return string
     */
    public function getResultadoCultivo()
    {
        return $this->resultadoCultivo;
    }

    /**
     * Set codificacionCultivo
     *
     * @param integer $codificacionCultivo
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setCodificacionCultivo($codificacionCultivo)
    {
        $this->codificacionCultivo = $codificacionCultivo;

        return $this;
    }

    /**
     * Get codificacionCultivo
     *
     * @return integer
     */
    public function getCodificacionCultivo()
    {
        return $this->codificacionCultivo;
    }

    /**
     * Set rayosXIndicado
     *
     * @param boolean $rayosXIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setRayosXIndicado($rayosXIndicado)
    {
        $this->rayosXIndicado = $rayosXIndicado;

        return $this;
    }

    /**
     * Get rayosXIndicado
     *
     * @return boolean
     */
    public function getRayosXIndicado()
    {
        return $this->rayosXIndicado;
    }

    /**
     * Set fechaRayosXIndicado
     *
     * @param DateTime $fechaRayosXIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaRayosXIndicado($fechaRayosXIndicado)
    {
        $this->fechaRayosXIndicado = $fechaRayosXIndicado;

        return $this;
    }

    /**
     * Get fechaRayosXIndicado
     *
     * @return DateTime
     */
    public function getFechaRayosXIndicado()
    {
        return $this->fechaRayosXIndicado;
    }

    /**
     * Set rayosXRealizado
     *
     * @param boolean $rayosXRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setRayosXRealizado($rayosXRealizado)
    {
        $this->rayosXRealizado = $rayosXRealizado;

        return $this;
    }

    /**
     * Get rayosXRealizado
     *
     * @return boolean
     */
    public function getRayosXRealizado()
    {
        return $this->rayosXRealizado;
    }

    /**
     * Set fechaRayosXRealizado
     *
     * @param DateTime $fechaRayosXRealizado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaRayosXRealizado($fechaRayosXRealizado)
    {
        $this->fechaRayosXRealizado = $fechaRayosXRealizado;

        return $this;
    }

    /**
     * Get fechaRayosXRealizado
     *
     * @return DateTime
     */
    public function getFechaRayosXRealizado()
    {
        return $this->fechaRayosXRealizado;
    }

    /**
     * Set hayResultadoRayosX
     *
     * @param string $hayResultadoRayosX
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setHayResultadoRayosX($hayResultadoRayosX)
    {
        $this->hayResultadoRayosX = $hayResultadoRayosX;

        return $this;
    }

    /**
     * Get hayResultadoRayosX
     *
     * @return string
     */
    public function getHayResultadoRayosX()
    {
        return $this->hayResultadoRayosX;
    }

    /**
     * Set fechaRayosXResultado
     *
     * @param DateTime $fechaRayosXResultado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaRayosXResultado($fechaRayosXResultado)
    {
        $this->fechaRayosXResultado = $fechaRayosXResultado;

        return $this;
    }

    /**
     * Get fechaRayosXResultado
     *
     * @return DateTime
     */
    public function getFechaRayosXResultado()
    {
        return $this->fechaRayosXResultado;
    }

    /**
     * Set resultadoRayosX
     *
     * @param string $resultadoRayosX
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoRayosX($resultadoRayosX)
    {
        $this->resultadoRayosX = $resultadoRayosX;

        return $this;
    }

    /**
     * Get resultadoRayosX
     *
     * @return string
     */
    public function getResultadoRayosX()
    {
        return $this->resultadoRayosX;
    }

    /**
     * Set rayoXLesionTB
     *
     * @param boolean $rayoXLesionTB
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setRayoXLesionTB($rayoXLesionTB)
    {
        $this->rayoXLesionTB = $rayoXLesionTB;

        return $this;
    }

    /**
     * Get rayoXLesionTB
     *
     * @return boolean
     */
    public function getRayoXLesionTB()
    {
        return $this->rayoXLesionTB;
    }

    /**
     * Set rayoXOtraLesion
     *
     * @param boolean $rayoXOtraLesion
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setRayoXOtraLesion($rayoXOtraLesion)
    {
        $this->rayoXOtraLesion = $rayoXOtraLesion;

        return $this;
    }

    /**
     * Get rayoXOtraLesion
     *
     * @return boolean
     */
    public function getRayoXOtraLesion()
    {
        return $this->rayoXOtraLesion;
    }

    /**
     * Set xpertIndicado
     *
     * @param boolean $xpertIndicado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setXpertIndicado($xpertIndicado)
    {
        $this->xpertIndicado = $xpertIndicado;

        return $this;
    }

    /**
     * Get xpertIndicado
     *
     * @return boolean
     */
    public function getXpertIndicado()
    {
        return $this->xpertIndicado;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set fechaResultado
     *
     * @param DateTime $fechaResultado
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setFechaResultado($fechaResultado)
    {
        $this->fechaResultado = $fechaResultado;

        return $this;
    }

    /**
     * Get fechaResultado
     *
     * @return DateTime
     */
    public function getFechaResultado()
    {
        return $this->fechaResultado;
    }

    /**
     * Set resultadoEvaluacion
     *
     * @param string $resultadoEvaluacion
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setResultadoEvaluacion($resultadoEvaluacion)
    {
        $this->resultadoEvaluacion = $resultadoEvaluacion;

        return $this;
    }

    /**
     * Get resultadoEvaluacion
     *
     * @return string
     */
    public function getResultadoEvaluacion()
    {
        return $this->resultadoEvaluacion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ContactoSeguimientoEvaluacion
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
     * Set estadoPaciente
     *
     * @param string $estadoPaciente
     *
     * @return ContactoSeguimientoEvaluacion
     */
    public function setEstadoPaciente($estadoPaciente)
    {
        $this->estadoPaciente = $estadoPaciente;

        return $this;
    }

    /**
     * Get estadoPaciente
     *
     * @return string
     */
    public function getEstadoPaciente()
    {
        return $this->estadoPaciente;
    }

    /**
     * Set contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     *
     * @return ContactoSeguimientoEvaluacion
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
}
