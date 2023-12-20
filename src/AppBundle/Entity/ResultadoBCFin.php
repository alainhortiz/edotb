<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoBCFin
 *
 * @ORM\Table(name="resultado_b_c_fin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoBCFinRepository")
 */
class ResultadoBCFin
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
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="ResultadoBCFin")
     */
    private $baciloscopia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Cultivo", inversedBy="ResultadoBCFin")
     */
    private $cultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="SalidaCultivo", inversedBy="ResultadoBCFin")
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
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }



    /**
     * Set baciloscopia
     *
     * @param \AppBundle\Entity\Baciloscopia $baciloscopia
     *
     * @return ResultadoBCFin
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
     * @return ResultadoBCFin
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
     * @return ResultadoBCFin
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
