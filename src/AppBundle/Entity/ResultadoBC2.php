<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoBC2
 *
 * @ORM\Table(name="resultado_b_c2")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoBC2Repository")
 */
class ResultadoBC2
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
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="ResultadoBC2")
     */
    private $baciloscopia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Cultivo", inversedBy="ResultadoBC2")
     */
    private $cultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="SalidaCultivo", inversedBy="ResultadoBC2")
     */
    private $salidaCultivo;


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
     * @return ResultadoBC2
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
     * @return ResultadoBC2
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
     * Set cultivo
     *
     * @param \AppBundle\Entity\Cultivo $cultivo
     *
     * @return ResultadoBC2
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
     * Set salidaCultivo
     *
     * @param \AppBundle\Entity\SalidaCultivo $salidaCultivo
     *
     * @return ResultadoBC2
     */
    public function setSalidaCultivo(\AppBundle\Entity\SalidaCultivo $salidaCultivo = null)
    {
        $this->salidaCultivo = $salidaCultivo;

        return $this;
    }

    /**
     * Get salidaCultivo
     *
     * @return \AppBundle\Entity\SalidaCultivo
     */
    public function getSalidaCultivo()
    {
        return $this->salidaCultivo;
    }
}
