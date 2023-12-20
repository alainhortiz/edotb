<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * PacienteEvolucion
 *
 * @ORM\Table(name="paciente_evolucion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteEvolucionRepository")
 */
class PacienteEvolucion
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
     * @ORM\Column(name="fechaInicioTrat", type="date", nullable=true)
     */
    private $fechaInicioTrat;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaVIH", type="date", nullable=true)
     */
    private $fechaVIH;

    /**
     * @var string
     *
     * @ORM\Column(name="resultadoVIH", type="string", length=20, nullable=true)
     */
    private $resultadoVIH;

    /**
     * @var bool
     *
     * @ORM\Column(name="covit", type="boolean")
     */
    private $covit = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaCovit", type="date", nullable=true)
     */
    private $fechaCovit;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarv", type="boolean")
     */
    private $tarv;

    /**
     * @var bool
     *
     * @ORM\Column(name="tcp", type="boolean")
     */
    private $tcp;

    /**
     * @var bool
     *
     * @ORM\Column(name="rayosX", type="boolean")
     */
    private $rayosX;

    /**
     * @var bool
     *
     * @ORM\Column(name="anatomiaPatologica", type="boolean")
     */
    private $anatomiaPatologica;

    /**
     * @var bool
     *
     * @ORM\Column(name="cambiadoTratSegundaLinea", type="boolean", nullable=true)
     */
    private $cambiadoTratSegundaLinea;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * @var string
     *
     * @ORM\Column(name="localizacionAnatomica", type="string", length=100)
     */
    private $localizacionAnatomica;

    /**
     * @var string
     *
     * @ORM\Column(name="definicionCaso", type="string", length=100)
     */
    private $definicionCaso;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Paciente", inversedBy="evoluciones")
     */
    private $paciente;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="PacienteEvolucion")
     */
    private $pais;

    /**
     * @var string
     * esta es la direccion de residencia
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DireccionPaciente" , cascade={"remove"})
     */
    private $direccionPaciente;

    /**
     * @var string
     * esta es la direccion de carnet
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DireccionPaciente" , cascade={"remove"})
     */
    private $direccionCarnet;

    /**
     * @var string
     * este es el centro de atencion
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteEvolucion")
     */
    private $areaSalud;

    /**
     * @var string
     * este es el centro de residencia
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteEvolucion")
     */
    private $centroResidencia;

    /**
     * @var string
     * este es el centro de diagnostico
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteEvolucion")
     */
    private $centroDiagnostico;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="PacienteEvolucion")
     */
    private $hospital;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="GrupoVulnerable", inversedBy="PacienteEvolucion")
     */
    private $grupoVulnerable;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="TipoEnfermo", inversedBy="PacienteEvolucion")
     */
    private $tipoEnfermo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EsquemaMedicamentos", mappedBy="pacienteEvolucion" , cascade={"remove"})
     * @OrderBy({"fechaInicio" = "ASC"})
     */
    private $esquemasMedicamentos;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="PruebaSensibilidad", inversedBy="PacienteEvolucion")
     */
    private $pruebaSensibilidad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="PacienteEvolucion")
     */
    private $resistencia;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResultadoBCX" , cascade={"remove"})
     */
    private $resultadoBCX;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResultadoBC2" , cascade={"remove"})
     */
    private $resultadoBC2;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResultadoBC5", cascade={"remove"})
     */
    private $resultadoBC5;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResultadoBCFin" , cascade={"remove"})
     */
    private $resultadoBCFin;

    /**
     * @ORM\ManyToMany(targetEntity="ResultadoFinal" , cascade={"remove"})
     * @ORM\JoinTable(name="resultados_evolucion",
     *     joinColumns={@ORM\JoinColumn(name="paciente_evolucion_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="resultado_final_id", referencedColumnName="id", unique=true)}
     * )
     * @OrderBy({"id" = "ASC"})
     */
    private $resultadosFinales;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaNotificacion", type="date")
     */
    private $fechaNotificacion;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fechaDiagnostico", type="date")
     */
    private $fechaDiagnostico;

    /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Enfermedad", inversedBy="PacienteEvolucion")
     */
    private $enfermedad;

    /**
     * @var bool
     *
     * @ORM\Column(name="necro", type="boolean")
     */
    private $necro;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BaciloscopiaSeguimiento", mappedBy="pacienteEvolucion" , cascade={"remove"})
     * @OrderBy({"fecha" = "ASC"})
     */
    private $baciloscopiaSeguimientos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CultivoSeguimiento", mappedBy="pacienteEvolucion" , cascade={"remove"})
     * @OrderBy({"fecha" = "ASC"})
     */
    private $cultivoSeguimientos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ControlSusceptibilidadLab", mappedBy="pacienteEvolucion" , cascade={"remove"})
     *
     */
    private $susceptibilidadControles;

    /**
     * @var string
     *
     * @ORM\Column(name="recluso", type="string", length=20)
     */
    private $recluso;



    /**
     * PacienteEvolucion constructor.
     */
    public function __construct()
    {
        $this->resultadosFinales = new ArrayCollection();
        $this->esquemasMedicamentos = new ArrayCollection();
        $this->baciloscopiaSeguimientos = new ArrayCollection();
        $this->cultivoSeguimientos = new ArrayCollection();
        $this->susceptibilidadControles = new ArrayCollection();
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
     * Set fechaInicioTrat
     *
     * @param DateTime $fechaInicioTrat
     *
     * @return PacienteEvolucion
     */
    public function setFechaInicioTrat($fechaInicioTrat)
    {
        $this->fechaInicioTrat = $fechaInicioTrat;

        return $this;
    }

    /**
     * Get fechaInicioTrat
     *
     * @return DateTime
     */
    public function getFechaInicioTrat()
    {
        return $this->fechaInicioTrat;
    }

    /**
     * Set fechaVIH
     *
     * @param DateTime $fechaVIH
     *
     * @return PacienteEvolucion
     */
    public function setFechaVIH($fechaVIH)
    {
        $this->fechaVIH = $fechaVIH;

        return $this;
    }

    /**
     * Get fechaVIH
     *
     * @return DateTime
     */
    public function getFechaVIH()
    {
        return $this->fechaVIH;
    }

    /**
     * Set tarv
     *
     * @param boolean $tarv
     *
     * @return PacienteEvolucion
     */
    public function setTarv($tarv)
    {
        $this->tarv = $tarv;

        return $this;
    }

    /**
     * Get tarv
     *
     * @return bool
     */
    public function getTarv()
    {
        return $this->tarv;
    }

    /**
     * Set tcp
     *
     * @param boolean $tcp
     *
     * @return PacienteEvolucion
     */
    public function setTcp($tcp)
    {
        $this->tcp = $tcp;

        return $this;
    }

    /**
     * Get tcp
     *
     * @return bool
     */
    public function getTcp()
    {
        return $this->tcp;
    }

    /**
     * Set cambiadoTratSegundaLinea
     *
     * @param boolean $cambiadoTratSegundaLinea
     *
     * @return PacienteEvolucion
     */
    public function setCambiadoTratSegundaLinea($cambiadoTratSegundaLinea)
    {
        $this->cambiadoTratSegundaLinea = $cambiadoTratSegundaLinea;

        return $this;
    }

    /**
     * Get cambiadoTratSegundaLinea
     *
     * @return bool
     */
    public function getCambiadoTratSegundaLinea()
    {
        return $this->cambiadoTratSegundaLinea;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return PacienteEvolucion
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
     * Set resultadoVIH
     *
     * @param string $resultadoVIH
     *
     * @return PacienteEvolucion
     */
    public function setResultadoVIH($resultadoVIH)
    {
        $this->resultadoVIH = $resultadoVIH;

        return $this;
    }

    /**
     * Get resultadoVIH
     *
     * @return string
     */
    public function getResultadoVIH()
    {
        return $this->resultadoVIH;
    }

    /**
     * Set rayosX
     *
     * @param boolean $rayosX
     *
     * @return PacienteEvolucion
     */
    public function setRayosX($rayosX)
    {
        $this->rayosX = $rayosX;

        return $this;
    }

    /**
     * Get rayosX
     *
     * @return boolean
     */
    public function getRayosX()
    {
        return $this->rayosX;
    }

    /**
     * Set anatomiaPatologica
     *
     * @param boolean $anatomiaPatologica
     *
     * @return PacienteEvolucion
     */
    public function setAnatomiaPatologica($anatomiaPatologica)
    {
        $this->anatomiaPatologica = $anatomiaPatologica;

        return $this;
    }

    /**
     * Get anatomiaPatologica
     *
     * @return boolean
     */
    public function getAnatomiaPatologica()
    {
        return $this->anatomiaPatologica;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacienteEvolucion
     */
    public function setPaciente(\AppBundle\Entity\Paciente $paciente = null)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return \AppBundle\Entity\Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set direccionPaciente
     *
     * @param \AppBundle\Entity\DireccionPaciente $direccionPaciente
     *
     * @return PacienteEvolucion
     */
    public function setDireccionPaciente(\AppBundle\Entity\DireccionPaciente $direccionPaciente = null)
    {
        $this->direccionPaciente = $direccionPaciente;

        return $this;
    }

    /**
     * Get direccionPaciente
     *
     * @return \AppBundle\Entity\DireccionPaciente
     */
    public function getDireccionPaciente()
    {
        return $this->direccionPaciente;
    }

    /**
     * Set areaSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areaSalud
     *
     * @return PacienteEvolucion
     */
    public function setAreaSalud(\AppBundle\Entity\AreaSalud $areaSalud = null)
    {
        $this->areaSalud = $areaSalud;

        return $this;
    }

    /**
     * Get areaSalud
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getAreaSalud()
    {
        return $this->areaSalud;
    }

    /**
     * Set grupoVulnerable
     *
     * @param \AppBundle\Entity\GrupoVulnerable $grupoVulnerable
     *
     * @return PacienteEvolucion
     */
    public function setGrupoVulnerable(\AppBundle\Entity\GrupoVulnerable $grupoVulnerable = null)
    {
        $this->grupoVulnerable = $grupoVulnerable;

        return $this;
    }

    /**
     * Get grupoVulnerable
     *
     * @return \AppBundle\Entity\GrupoVulnerable
     */
    public function getGrupoVulnerable()
    {
        return $this->grupoVulnerable;
    }

    /**
     * Set tipoEnfermo
     *
     * @param \AppBundle\Entity\TipoEnfermo $tipoEnfermo
     *
     * @return PacienteEvolucion
     */
    public function setTipoEnfermo(\AppBundle\Entity\TipoEnfermo $tipoEnfermo = null)
    {
        $this->tipoEnfermo = $tipoEnfermo;

        return $this;
    }

    /**
     * Get tipoEnfermo
     *
     * @return \AppBundle\Entity\TipoEnfermo
     */
    public function getTipoEnfermo()
    {
        return $this->tipoEnfermo;
    }

    /**
     * Set resistencia
     *
     * @param \AppBundle\Entity\Resistencia $resistencia
     *
     * @return PacienteEvolucion
     */
    public function setResistencia(\AppBundle\Entity\Resistencia $resistencia = null)
    {
        $this->resistencia = $resistencia;

        return $this;
    }

    /**
     * Get resistencia
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistencia()
    {
        return $this->resistencia;
    }

    /**
     * Set resultadoBCX
     *
     * @param \AppBundle\Entity\ResultadoBCX $resultadoBCX
     *
     * @return PacienteEvolucion
     */
    public function setResultadoBCX(\AppBundle\Entity\ResultadoBCX $resultadoBCX = null)
    {
        $this->resultadoBCX = $resultadoBCX;

        return $this;
    }

    /**
     * Get resultadoBCX
     *
     * @return \AppBundle\Entity\ResultadoBCX
     */
    public function getResultadoBCX()
    {
        return $this->resultadoBCX;
    }

    /**
     * Set resultadoBC2
     *
     * @param \AppBundle\Entity\ResultadoBC2 $resultadoBC2
     *
     * @return PacienteEvolucion
     */
    public function setResultadoBC2(\AppBundle\Entity\ResultadoBC2 $resultadoBC2 = null)
    {
        $this->resultadoBC2 = $resultadoBC2;

        return $this;
    }

    /**
     * Get resultadoBC2
     *
     * @return \AppBundle\Entity\ResultadoBC2
     */
    public function getResultadoBC2()
    {
        return $this->resultadoBC2;
    }

    /**
     * Set resultadoBC5
     *
     * @param \AppBundle\Entity\ResultadoBC5 $resultadoBC5
     *
     * @return PacienteEvolucion
     */
    public function setResultadoBC5(\AppBundle\Entity\ResultadoBC5 $resultadoBC5 = null)
    {
        $this->resultadoBC5 = $resultadoBC5;

        return $this;
    }

    /**
     * Get resultadoBC5
     *
     * @return \AppBundle\Entity\ResultadoBC5
     */
    public function getResultadoBC5()
    {
        return $this->resultadoBC5;
    }

    /**
     * Set resultadoBCFin
     *
     * @param \AppBundle\Entity\ResultadoBCFin $resultadoBCFin
     *
     * @return PacienteEvolucion
     */
    public function setResultadoBCFin(\AppBundle\Entity\ResultadoBCFin $resultadoBCFin = null)
    {
        $this->resultadoBCFin = $resultadoBCFin;

        return $this;
    }

    /**
     * Get resultadoBCFin
     *
     * @return \AppBundle\Entity\ResultadoBCFin
     */
    public function getResultadoBCFin()
    {
        return $this->resultadoBCFin;
    }

    /**
     * Set pais
     *
     * @param \AppBundle\Entity\Pais $pais
     *
     * @return PacienteEvolucion
     */
    public function setPais(\AppBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set pruebaSensibilidad
     *
     * @param \AppBundle\Entity\PruebaSensibilidad $pruebaSensibilidad
     *
     * @return PacienteEvolucion
     */
    public function setPruebaSensibilidad(\AppBundle\Entity\PruebaSensibilidad $pruebaSensibilidad = null)
    {
        $this->pruebaSensibilidad = $pruebaSensibilidad;

        return $this;
    }

    /**
     * Get pruebaSensibilidad
     *
     * @return \AppBundle\Entity\PruebaSensibilidad
     */
    public function getPruebaSensibilidad()
    {
        return $this->pruebaSensibilidad;
    }

    /**
     * Set current
     *
     * @param boolean $current
     *
     * @return PacienteEvolucion
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get current
     *
     * @return boolean
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set definicionCaso
     *
     * @param string $definicionCaso
     *
     * @return PacienteEvolucion
     */
    public function setDefinicionCaso($definicionCaso)
    {
        $this->definicionCaso = $definicionCaso;

        return $this;
    }

    /**
     * Get definicionCaso
     *
     * @return string
     */
    public function getDefinicionCaso()
    {
        return $this->definicionCaso;
    }

    /**
     * Set localizacionAnatomica
     *
     * @param string $localizacionAnatomica
     *
     * @return PacienteEvolucion
     */
    public function setLocalizacionAnatomica($localizacionAnatomica)
    {
        $this->localizacionAnatomica = $localizacionAnatomica;

        return $this;
    }

    /**
     * Get localizacionAnatomica
     *
     * @return string
     */
    public function getLocalizacionAnatomica()
    {
        return $this->localizacionAnatomica;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return PacienteEvolucion
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Add resultadosFinale
     *
     * @param \AppBundle\Entity\ResultadoFinal $resultadosFinale
     *
     * @return PacienteEvolucion
     */
    public function addResultadosFinale(\AppBundle\Entity\ResultadoFinal $resultadosFinale)
    {
        $this->resultadosFinales[] = $resultadosFinale;

        return $this;
    }

    /**
     * Remove resultadosFinale
     *
     * @param \AppBundle\Entity\ResultadoFinal $resultadosFinale
     */
    public function removeResultadosFinale(\AppBundle\Entity\ResultadoFinal $resultadosFinale)
    {
        $this->resultadosFinales->removeElement($resultadosFinale);
    }

    /**
     * Get resultadosFinales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultadosFinales()
    {
        return $this->resultadosFinales;
    }

    public function removeAllResultadosFinales()
    {
        $this->resultadosFinales->clear();
    }



    /**
     * Set fechaNotificacion
     *
     * @param DateTime $fechaNotificacion
     *
     * @return PacienteEvolucion
     */
    public function setFechaNotificacion($fechaNotificacion)
    {
        $this->fechaNotificacion = $fechaNotificacion;

        return $this;
    }

    /**
     * Get fechaNotificacion
     *
     * @return DateTime
     */
    public function getFechaNotificacion()
    {
        return $this->fechaNotificacion;
    }

    /**
     * Set fechaDiagnostico
     *
     * @param DateTime $fechaDiagnostico
     *
     * @return PacienteEvolucion
     */
    public function setFechaDiagnostico($fechaDiagnostico)
    {
        $this->fechaDiagnostico = $fechaDiagnostico;

        return $this;
    }

    /**
     * Get fechaDiagnostico
     *
     * @return DateTime
     */
    public function getFechaDiagnostico()
    {
        return $this->fechaDiagnostico;
    }

    /**
     * Set enfermedad
     *
     * @param \AppBundle\Entity\Enfermedad $enfermedad
     *
     * @return PacienteEvolucion
     */
    public function setEnfermedad(\AppBundle\Entity\Enfermedad $enfermedad = null)
    {
        $this->enfermedad = $enfermedad;

        return $this;
    }

    /**
     * Get enfermedad
     *
     * @return \AppBundle\Entity\Enfermedad
     */
    public function getEnfermedad()
    {
        return $this->enfermedad;
    }


    /**
     * Set hospital
     *
     * @param \AppBundle\Entity\Hospital $hospital
     *
     * @return PacienteEvolucion
     */
    public function setHospital(\AppBundle\Entity\Hospital $hospital = null)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Get hospital
     *
     * @return \AppBundle\Entity\Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }


    /**
     * Add esquemasMedicamento
     *
     * @param \AppBundle\Entity\EsquemaMedicamentos $esquemasMedicamento
     *
     * @return PacienteEvolucion
     */
    public function addEsquemasMedicamento(\AppBundle\Entity\EsquemaMedicamentos $esquemasMedicamento)
    {
        $this->esquemasMedicamentos[] = $esquemasMedicamento;

        return $this;
    }

    /**
     * Remove esquemasMedicamento
     *
     * @param \AppBundle\Entity\EsquemaMedicamentos $esquemasMedicamento
     */
    public function removeEsquemasMedicamento(\AppBundle\Entity\EsquemaMedicamentos $esquemasMedicamento)
    {
        $this->esquemasMedicamentos->removeElement($esquemasMedicamento);
    }

    /**
     * Get esquemasMedicamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEsquemasMedicamentos()
    {
        return $this->esquemasMedicamentos;
    }

    /**
     * Add baciloscopiaSeguimiento
     *
     * @param \AppBundle\Entity\BaciloscopiaSeguimiento $baciloscopiaSeguimiento
     *
     * @return PacienteEvolucion
     */
    public function addBaciloscopiaSeguimiento(\AppBundle\Entity\BaciloscopiaSeguimiento $baciloscopiaSeguimiento)
    {
        $this->baciloscopiaSeguimientos[] = $baciloscopiaSeguimiento;

        return $this;
    }

    /**
     * Remove baciloscopiaSeguimiento
     *
     * @param \AppBundle\Entity\BaciloscopiaSeguimiento $baciloscopiaSeguimiento
     */
    public function removeBaciloscopiaSeguimiento(\AppBundle\Entity\BaciloscopiaSeguimiento $baciloscopiaSeguimiento)
    {
        $this->baciloscopiaSeguimientos->removeElement($baciloscopiaSeguimiento);
    }

    /**
     * Get baciloscopiaSeguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBaciloscopiaSeguimientos()
    {
        return $this->baciloscopiaSeguimientos;
    }

    /**
     * Add cultivoSeguimiento
     *
     * @param \AppBundle\Entity\CultivoSeguimiento $cultivoSeguimiento
     *
     * @return PacienteEvolucion
     */
    public function addCultivoSeguimiento(\AppBundle\Entity\CultivoSeguimiento $cultivoSeguimiento)
    {
        $this->cultivoSeguimientos[] = $cultivoSeguimiento;

        return $this;
    }

    /**
     * Remove cultivoSeguimiento
     *
     * @param \AppBundle\Entity\CultivoSeguimiento $cultivoSeguimiento
     */
    public function removeCultivoSeguimiento(\AppBundle\Entity\CultivoSeguimiento $cultivoSeguimiento)
    {
        $this->cultivoSeguimientos->removeElement($cultivoSeguimiento);
    }

    /**
     * Get cultivoSeguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCultivoSeguimientos()
    {
        return $this->cultivoSeguimientos;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     *
     * @return PacienteEvolucion
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }


    /**
     * Set necro
     *
     * @param boolean $necro
     *
     * @return PacienteEvolucion
     */
    public function setNecro($necro)
    {
        $this->necro = $necro;

        return $this;
    }

    /**
     * Get necro
     *
     * @return boolean
     */
    public function getNecro()
    {
        return $this->necro;
    }

    /**
     * Add susceptibilidadControle
     *
     * @param \AppBundle\Entity\ControlSusceptibilidadLab $susceptibilidadControle
     *
     * @return PacienteEvolucion
     */
    public function addSusceptibilidadControle(\AppBundle\Entity\ControlSusceptibilidadLab $susceptibilidadControle)
    {
        $this->susceptibilidadControles[] = $susceptibilidadControle;

        return $this;
    }

    /**
     * Remove susceptibilidadControle
     *
     * @param \AppBundle\Entity\ControlSusceptibilidadLab $susceptibilidadControle
     */
    public function removeSusceptibilidadControle(\AppBundle\Entity\ControlSusceptibilidadLab $susceptibilidadControle)
    {
        $this->susceptibilidadControles->removeElement($susceptibilidadControle);
    }

    /**
     * Get susceptibilidadControles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSusceptibilidadControles()
    {
        return $this->susceptibilidadControles;
    }

    /**
     * Set recluso
     *
     * @param string $recluso
     *
     * @return PacienteEvolucion
     */
    public function setRecluso($recluso)
    {
        $this->recluso = $recluso;

        return $this;
    }

    /**
     * Get recluso
     *
     * @return string
     */
    public function getRecluso()
    {
        return $this->recluso;
    }

    /**
     * Set direccionCarnet
     *
     * @param \AppBundle\Entity\DireccionPaciente $direccionCarnet
     *
     * @return PacienteEvolucion
     */
    public function setDireccionCarnet(\AppBundle\Entity\DireccionPaciente $direccionCarnet = null)
    {
        $this->direccionCarnet = $direccionCarnet;

        return $this;
    }

    /**
     * Get direccionCarnet
     *
     * @return \AppBundle\Entity\DireccionPaciente
     */
    public function getDireccionCarnet()
    {
        return $this->direccionCarnet;
    }

    /**
     * Set centroResidencia
     *
     * @param \AppBundle\Entity\AreaSalud $centroResidencia
     *
     * @return PacienteEvolucion
     */
    public function setCentroResidencia(\AppBundle\Entity\AreaSalud $centroResidencia = null)
    {
        $this->centroResidencia = $centroResidencia;

        return $this;
    }

    /**
     * Get centroResidencia
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getCentroResidencia()
    {
        return $this->centroResidencia;
    }

    /**
     * Set centroDiagnostico
     *
     * @param \AppBundle\Entity\AreaSalud $centroDiagnostico
     *
     * @return PacienteEvolucion
     */
    public function setCentroDiagnostico(\AppBundle\Entity\AreaSalud $centroDiagnostico = null)
    {
        $this->centroDiagnostico = $centroDiagnostico;

        return $this;
    }

    /**
     * Get centroDiagnostico
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getCentroDiagnostico()
    {
        return $this->centroDiagnostico;
    }

    /**
     * Set covit
     *
     * @param boolean $covit
     *
     * @return PacienteEvolucion
     */
    public function setCovit($covit)
    {
        $this->covit = $covit;

        return $this;
    }

    /**
     * Get covit
     *
     * @return boolean
     */
    public function getCovit()
    {
        return $this->covit;
    }

    /**
     * Set fechaCovit
     *
     * @param DateTime $fechaCovit
     *
     * @return PacienteEvolucion
     */
    public function setFechaCovit($fechaCovit)
    {
        $this->fechaCovit = $fechaCovit;

        return $this;
    }

    /**
     * Get fechaCovit
     *
     * @return DateTime
     */
    public function getFechaCovit()
    {
        return $this->fechaCovit;
    }
}
