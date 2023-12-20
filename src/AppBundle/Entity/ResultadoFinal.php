<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoFinal
 *
 * @ORM\Table(name="resultado_final")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoFinalRepository")
 */
class ResultadoFinal
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
     * @ORM\ManyToOne(targetEntity="ResultadoTratamiento", inversedBy="ResultadoFinal")
     */
    private $resultadoTratamiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="ultimo", type="boolean")
     */
    private $ultimo;


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
     * @return ResultadoFinal
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
     * Set resultadoTratamiento
     *
     * @param \AppBundle\Entity\ResultadoTratamiento $resultadoTratamiento
     *
     * @return ResultadoFinal
     */
    public function setResultadoTratamiento(\AppBundle\Entity\ResultadoTratamiento $resultadoTratamiento = null)
    {
        $this->resultadoTratamiento = $resultadoTratamiento;

        return $this;
    }

    /**
     * Get resultadoTratamiento
     *
     * @return \AppBundle\Entity\ResultadoTratamiento
     */
    public function getResultadoTratamiento()
    {
        return $this->resultadoTratamiento;
    }

    /**
     * Set ultimo
     *
     * @param boolean $ultimo
     *
     * @return ResultadoFinal
     */
    public function setUltimo($ultimo)
    {
        $this->ultimo = $ultimo;

        return $this;
    }

    /**
     * Get ultimo
     *
     * @return boolean
     */
    public function getUltimo()
    {
        return $this->ultimo;
    }
}
