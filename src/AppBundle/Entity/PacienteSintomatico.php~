<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteSintomatico
 *
 * @ORM\Table(name="paciente_sintomatico")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteSintomaticoRepository")
 */
class PacienteSintomatico
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
     * @ORM\Column(name="carnetIdentidad", type="string", length=100, unique=true)
     */
    private $carnetIdentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=100)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="SegundoApellido", type="string", length=100)
     */
    private $segundoApellido;

    /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=20)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DireccionPaciente")
     */
    private $direccionPaciente;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteSintomatico")
     */
    private $areaSalud;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="PacienteSintomatico")
     */
    private $hospital;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="GrupoVulnerable", inversedBy="PacienteSintomatico")
     */
    private $grupoVulnerable;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="PacienteSintomatico")
     */
    private $pais;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrada", type="date")
     */
    private $fechaEntrada;

    /**
     * @var string
     *
     * @ORM\Column(name="proceso", type="string", length=20)
     */
    private $proceso;

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
     * Set carnetIdentidad
     *
     * @param string $carnetIdentidad
     *
     * @return PacienteSintomatico
     */
    public function setCarnetIdentidad($carnetIdentidad)
    {
        $this->carnetIdentidad = $carnetIdentidad;

        return $this;
    }

    /**
     * Get carnetIdentidad
     *
     * @return string
     */
    public function getCarnetIdentidad()
    {
        return $this->carnetIdentidad;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return PacienteSintomatico
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return PacienteSintomatico
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return PacienteSintomatico
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     *
     * @return PacienteSintomatico
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return int
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return PacienteSintomatico
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set grupoVulnerable
     *
     * @param \AppBundle\Entity\GrupoVulnerable $grupoVulnerable
     *
     * @return PacienteSintomatico
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
     * Set direccionPaciente
     *
     * @param \AppBundle\Entity\DireccionPaciente $direccionPaciente
     *
     * @return PacienteSintomatico
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
     * @return PacienteSintomatico
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
     * Set pais
     *
     * @param \AppBundle\Entity\Pais $pais
     *
     * @return PacienteSintomatico
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
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     *
     * @return PacienteSintomatico
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;

        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    /**
     * Set proceso
     *
     * @param string $proceso
     *
     * @return PacienteSintomatico
     */
    public function setProceso($proceso)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso
     *
     * @return string
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Set hospital
     *
     * @param \AppBundle\Entity\Hospital $hospital
     *
     * @return PacienteSintomatico
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
}
