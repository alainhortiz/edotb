<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AsistenciaTratamiento
 *
 * @ORM\Table(name="asistencia_tratamiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsistenciaTratamientoRepository")
 */
class AsistenciaTratamiento
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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EsquemaMedicamentos", inversedBy="asistenciasTratamientos")
     */
    private $esquemaMedicamentos;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AsistenciaTratamiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set esquemaMedicamentos
     *
     * @param \AppBundle\Entity\EsquemaMedicamentos $esquemaMedicamentos
     *
     * @return AsistenciaTratamiento
     */
    public function setEsquemaMedicamentos(\AppBundle\Entity\EsquemaMedicamentos $esquemaMedicamentos = null)
    {
        $this->esquemaMedicamentos = $esquemaMedicamentos;

        return $this;
    }

    /**
     * Get esquemaMedicamentos
     *
     * @return \AppBundle\Entity\EsquemaMedicamentos
     */
    public function getEsquemaMedicamentos()
    {
        return $this->esquemaMedicamentos;
    }
}
