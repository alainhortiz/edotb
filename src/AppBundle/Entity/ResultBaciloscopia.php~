<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultBaciloscopia
 *
 * @ORM\Table(name="result_baciloscopia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultBaciloscopiaRepository")
 */
class ResultBaciloscopia
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
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="ResultBaciloscopia")
     */
    private $baciloscopia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="PacienteSintomatico", inversedBy="ResultBaciloscopia")
     */
    private $pacienteSintomatico;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="ResultBaciloscopia")
     */
    private $areaSalud;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="ResultBaciloscopia")
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
     * @return ResultBaciloscopia
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
     * Set baciloscopia
     *
     * @param \AppBundle\Entity\Baciloscopia $baciloscopia
     *
     * @return ResultBaciloscopia
     */
    public function setBaciloscopia(\AppBundle\Entity\Baciloscopia $baciloscopia = null)
    {
        $this->baciloscopia = $baciloscopia;

        return $this;
    }

    /**
     * Get baciloscopia
     *
     * @return \AppBundle\Entity\Baciloscopia
     */
    public function getBaciloscopia()
    {
        return $this->baciloscopia;
    }

    /**
     * Set pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return ResultBaciloscopia
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
     * @return ResultBaciloscopia
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
     * @return ResultBaciloscopia
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
