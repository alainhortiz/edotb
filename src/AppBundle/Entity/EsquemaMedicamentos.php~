<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * EsquemaMedicamentos
 *
 * @ORM\Table(name="esquema_medicamentos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EsquemaMedicamentosRepository")
 */
class EsquemaMedicamentos
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @var bool
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * @ORM\ManyToMany(targetEntity="MedicamentoPrimeraLinea")
     * @ORM\JoinTable(name="esquemamedicamento_medicamento",
     *     joinColumns={@ORM\JoinColumn(name="esquemaMedicamento_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="medicamentoPrimeraLinea_id", referencedColumnName="id")}
     * )
     */
    private $medicamentos;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PacienteEvolucion", inversedBy="esquemasMedicamentos")
     */
    private $pacienteEvolucion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AsistenciaTratamiento", mappedBy="esquemaMedicamentos" , cascade={"remove"})
     * @OrderBy({"fecha" = "ASC"})
     */
    private $asistenciasTratamientos;

    /**
     * EsquemaMedicamentos constructor.
     */
    public function __construct()
    {
        $this->medicamentos = new ArrayCollection();
        $this->asistenciasTratamientos = new ArrayCollection();
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
     * Add medicamento
     *
     * @param \AppBundle\Entity\MedicamentoPrimeraLinea $medicamento
     *
     * @return EsquemaMedicamentos
     */
    public function addMedicamento(\AppBundle\Entity\MedicamentoPrimeraLinea $medicamento)
    {
        $this->medicamentos[] = $medicamento;

        return $this;
    }

    /**
     * Remove medicamento
     *
     * @param \AppBundle\Entity\MedicamentoPrimeraLinea $medicamento
     */
    public function removeMedicamento(\AppBundle\Entity\MedicamentoPrimeraLinea $medicamento)
    {
        $this->medicamentos->removeElement($medicamento);
    }

    /**
     * Get medicamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedicamentos()
    {
        return $this->medicamentos;
    }

    public function setMedicamentos($medicamentos)
    {
        $this->medicamentos = $medicamentos;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return EsquemaMedicamentos
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     *
     * @return EsquemaMedicamentos
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set current
     *
     * @param boolean $current
     *
     * @return EsquemaMedicamentos
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
     * Set pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return EsquemaMedicamentos
     */
    public function setPacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion = null)
    {
        $this->pacienteEvolucion = $pacienteEvolucion;

        return $this;
    }

    /**
     * Get pacienteEvolucion
     *
     * @return \AppBundle\Entity\PacienteEvolucion
     */
    public function getPacienteEvolucion()
    {
        return $this->pacienteEvolucion;
    }


    /**
     * Add asistenciasTratamiento
     *
     * @param \AppBundle\Entity\AsistenciaTratamiento $asistenciasTratamiento
     *
     * @return EsquemaMedicamentos
     */
    public function addAsistenciasTratamiento(\AppBundle\Entity\AsistenciaTratamiento $asistenciasTratamiento)
    {
        $this->asistenciasTratamientos[] = $asistenciasTratamiento;

        return $this;
    }

    /**
     * Remove asistenciasTratamiento
     *
     * @param \AppBundle\Entity\AsistenciaTratamiento $asistenciasTratamiento
     */
    public function removeAsistenciasTratamiento(\AppBundle\Entity\AsistenciaTratamiento $asistenciasTratamiento)
    {
        $this->asistenciasTratamientos->removeElement($asistenciasTratamiento);
    }

    /**
     * Get asistenciasTratamientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsistenciasTratamientos()
    {
        return $this->asistenciasTratamientos;
    }
}
