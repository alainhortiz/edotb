<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContactoSeguimiento
 *
 * @ORM\Table(name="contacto_seguimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoSeguimientoRepository")
 */
class ContactoSeguimiento
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
     * @ORM\Column(name="fechaNotificacion", type="date")
     */
    private $fechaNotificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="contactoSeguimientos")
     */
    private $municipio;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="tpt", type="boolean")
     */
    private $tpt = false;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MotivoCierreContacto", inversedBy="contactoSeguimientos")
     */
    private $motivoCierre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Contacto", inversedBy="seguimientos")
     */
    private $contacto;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="ContactoSeguimientoFactorRiesgo" ,mappedBy="contactoSeguimiento" , cascade={"remove"})
     *
     */
    private $contactoSeguimientoFactorRiesgo;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="ContactoSeguimientoTPT" ,mappedBy="contactoSeguimiento" , cascade={"remove"})
     *
     */
    private $contactoSeguimientoTPT;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="ContactoSeguimientoEvaluacion", mappedBy="contactoSeguimiento" , cascade={"remove"})
     *
     */
    private $evaluaciones;

    /**
     * @ORM\ManyToOne(targetEntity="NivelEducacional",inversedBy="contactoSeguimientos")
     */
    protected $nivelEducacional;

    /**
     * @ORM\ManyToMany(targetEntity="Ocupacion")
     * @ORM\JoinTable(name="contacto_ocupacion",
     *     joinColumns={@ORM\JoinColumn(name="contacto_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="ocupacion_id", referencedColumnName="id")}
     * )
     */
    private $contacto_ocupacion;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->evaluaciones = new ArrayCollection();
        $this->contacto_ocupacion = new ArrayCollection();
    }


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
     * Set fechaNotificacion
     *
     * @param DateTime $fechaNotificacion
     *
     * @return ContactoSeguimiento
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return ContactoSeguimiento
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return ContactoSeguimiento
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return ContactoSeguimiento
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return ContactoSeguimiento
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set tpt
     *
     * @param boolean $tpt
     *
     * @return ContactoSeguimiento
     */
    public function setTpt($tpt)
    {
        $this->tpt = $tpt;

        return $this;
    }

    /**
     * Get tpt
     *
     * @return boolean
     */
    public function getTpt()
    {
        return $this->tpt;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return ContactoSeguimiento
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set motivoCierre
     *
     * @param \AppBundle\Entity\MotivoCierreContacto $motivoCierre
     *
     * @return ContactoSeguimiento
     */
    public function setMotivoCierre(\AppBundle\Entity\MotivoCierreContacto $motivoCierre = null)
    {
        $this->motivoCierre = $motivoCierre;

        return $this;
    }

    /**
     * Get motivoCierre
     *
     * @return \AppBundle\Entity\MotivoCierreContacto
     */
    public function getMotivoCierre()
    {
        return $this->motivoCierre;
    }

    /**
     * Set contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     *
     * @return ContactoSeguimiento
     */
    public function setContacto(\AppBundle\Entity\Contacto $contacto = null)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return \AppBundle\Entity\Contacto
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set contactoSeguimientoFactorRiesgo
     *
     * @param \AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimientoFactorRiesgo
     *
     * @return ContactoSeguimiento
     */
    public function setContactoSeguimientoFactorRiesgo(\AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimientoFactorRiesgo = null)
    {
        $this->contactoSeguimientoFactorRiesgo = $contactoSeguimientoFactorRiesgo;

        return $this;
    }

    /**
     * Get contactoSeguimientoFactorRiesgo
     *
     * @return \AppBundle\Entity\ContactoSeguimientoFactorRiesgo
     */
    public function getContactoSeguimientoFactorRiesgo()
    {
        return $this->contactoSeguimientoFactorRiesgo;
    }

    /**
     * Set contactoSeguimientoTPT
     *
     * @param \AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientoTPT
     *
     * @return ContactoSeguimiento
     */
    public function setContactoSeguimientoTPT(\AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientoTPT = null)
    {
        $this->contactoSeguimientoTPT = $contactoSeguimientoTPT;

        return $this;
    }

    /**
     * Get contactoSeguimientoTPT
     *
     * @return \AppBundle\Entity\ContactoSeguimientoTPT
     */
    public function getContactoSeguimientoTPT()
    {
        return $this->contactoSeguimientoTPT;
    }


    /**
     * Remove evaluacione
     *
     * @param \AppBundle\Entity\ContactoSeguimientoEvaluacion $evaluacione
     */
    public function removeEvaluacione(\AppBundle\Entity\ContactoSeguimientoEvaluacion $evaluacione)
    {
        $this->evaluaciones->removeElement($evaluacione);
    }

    /**
     * Get evaluaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluaciones()
    {
        return $this->evaluaciones;
    }

    /**
     * Set nivelEducacional
     *
     * @param \AppBundle\Entity\NivelEducacional $nivelEducacional
     *
     * @return ContactoSeguimiento
     */
    public function setNivelEducacional(\AppBundle\Entity\NivelEducacional $nivelEducacional = null)
    {
        $this->nivelEducacional = $nivelEducacional;

        return $this;
    }

    /**
     * Get nivelEducacional
     *
     * @return \AppBundle\Entity\NivelEducacional
     */
    public function getNivelEducacional()
    {
        return $this->nivelEducacional;
    }

    /**
     * Add contactoOcupacion
     *
     * @param \AppBundle\Entity\Ocupacion $contactoOcupacion
     *
     * @return ContactoSeguimiento
     */
    public function addContactoOcupacion(\AppBundle\Entity\Ocupacion $contactoOcupacion)
    {
        $this->contacto_ocupacion[] = $contactoOcupacion;

        return $this;
    }

    /**
     * Remove contactoOcupacion
     *
     * @param \AppBundle\Entity\Ocupacion $contactoOcupacion
     */
    public function removeContactoOcupacion(\AppBundle\Entity\Ocupacion $contactoOcupacion)
    {
        $this->contacto_ocupacion->removeElement($contactoOcupacion);
    }

    /**
     * Get contactoOcupacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactoOcupacion()
    {
        return $this->contacto_ocupacion;
    }

    public function setContactoOcupacion($ocupaciones)
    {
        $this->contacto_ocupacion = $ocupaciones;
    }

    /**
     * Add evaluacione
     *
     * @param \AppBundle\Entity\ContactoSeguimientoEvaluacion $evaluacione
     *
     * @return ContactoSeguimiento
     */
    public function addEvaluacione(\AppBundle\Entity\ContactoSeguimientoEvaluacion $evaluacione)
    {
        $this->evaluaciones = $evaluacione;

        return $this;
    }

    public function cantidadEvaluaciones()
    {
        return count($this->evaluaciones);
    }
}
