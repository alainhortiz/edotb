<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultXpert
 *
 * @ORM\Table(name="result_xpert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultXpertRepository")
 */
class ResultXpert
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
     * @ORM\ManyToOne(targetEntity="Xpert", inversedBy="ResultXpert")
     */
    private $xpert;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="PacienteSintomatico", inversedBy="ResultXpert")
     */
    private $pacienteSintomatico;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="ResultXpert")
     */
    private $areaSalud;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="ResultXpert")
     */
    private $hospital;


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
     * @return ResultXpert
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
     * Set xpert
     *
     * @param \AppBundle\Entity\Xpert $xpert
     *
     * @return ResultXpert
     */
    public function setXpert(\AppBundle\Entity\Xpert $xpert = null)
    {
        $this->xpert = $xpert;

        return $this;
    }

    /**
     * Get xpert
     *
     * @return \AppBundle\Entity\Xpert
     */
    public function getXpert()
    {
        return $this->xpert;
    }

    /**
     * Set pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return ResultXpert
     */
    public function setPacienteSintomatico(\AppBundle\Entity\PacienteSintomatico $pacienteSintomatico = null)
    {
        $this->pacienteSintomatico = $pacienteSintomatico;

        return $this;
    }

    /**
     * Get pacienteSintomatico
     *
     * @return \AppBundle\Entity\PacienteSintomatico
     */
    public function getPacienteSintomatico()
    {
        return $this->pacienteSintomatico;
    }

    /**
     * Set areaSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areaSalud
     *
     * @return ResultXpert
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
     * Set hospital
     *
     * @param \AppBundle\Entity\Hospital $hospital
     *
     * @return ResultXpert
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
