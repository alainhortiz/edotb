<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultCultivo
 *
 * @ORM\Table(name="result_cultivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultCultivoRepository")
 */
class ResultCultivo
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
     * @ORM\ManyToOne(targetEntity="Cultivo", inversedBy="ResultCultivo")
     */
    private $cultivo;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="PacienteSintomatico", inversedBy="ResultCultivo")
     */
    private $pacienteSintomatico;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="ResultCultivo")
     */
    private $areaSalud;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="ResultCultivo")
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
     * @return ResultCultivo
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
     * Set cultivo
     *
     * @param \AppBundle\Entity\Cultivo $cultivo
     *
     * @return ResultCultivo
     */
    public function setCultivo(\AppBundle\Entity\Cultivo $cultivo = null)
    {
        $this->cultivo = $cultivo;

        return $this;
    }

    /**
     * Get cultivo
     *
     * @return \AppBundle\Entity\Cultivo
     */
    public function getCultivo()
    {
        return $this->cultivo;
    }

    /**
     * Set pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return ResultCultivo
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
     * @return ResultCultivo
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
     * @return ResultCultivo
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
