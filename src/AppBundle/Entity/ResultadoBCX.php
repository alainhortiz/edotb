<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoBCX
 *
 * @ORM\Table(name="resultado_b_c_x")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoBCXRepository")
 */
class ResultadoBCX
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
     * @ORM\ManyToOne(targetEntity="Xpert", inversedBy="ResultadoBCX")
     */
    private $xpert;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="ResultadoBCX")
     */
    private $baciloscopia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="ResultadoBCX")
     */
    private $baciloscopia2;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Cultivo", inversedBy="ResultadoBCX")
     */
    private $cultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="SalidaCultivo", inversedBy="ResultadoBCX")
     */
    private $salidaCultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Biopsia", inversedBy="ResultadoBCX")
     */
    private $biopsia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Orina", inversedBy="ResultadoBCX")
     */
    private $orina;


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
     * @return ResultadoBCX
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
     * @return ResultadoBCX
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
     * Set baciloscopia
     *
     * @param \AppBundle\Entity\Baciloscopia $baciloscopia
     *
     * @return ResultadoBCX
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
     * @return ResultadoBCX
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
     * Set baciloscopia2
     *
     * @param \AppBundle\Entity\Baciloscopia $baciloscopia2
     *
     * @return ResultadoBCX
     */
    public function setBaciloscopia2(\AppBundle\Entity\Baciloscopia $baciloscopia2 = null)
    {
        $this->baciloscopia2 = $baciloscopia2;

        return $this;
    }

    /**
     * Get baciloscopia2
     *
     * @return \AppBundle\Entity\Baciloscopia
     */
    public function getBaciloscopia2()
    {
        return $this->baciloscopia2;
    }

    /**
     * Set salidaCultivo
     *
     * @param \AppBundle\Entity\SalidaCultivo $salidaCultivo
     *
     * @return ResultadoBCX
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

    /**
     * Set biopsia
     *
     * @param \AppBundle\Entity\Biopsia $biopsia
     *
     * @return ResultadoBCX
     */
    public function setBiopsia(\AppBundle\Entity\Biopsia $biopsia = null)
    {
        $this->biopsia = $biopsia;

        return $this;
    }

    /**
     * Get biopsia
     *
     * @return \AppBundle\Entity\Biopsia
     */
    public function getBiopsia()
    {
        return $this->biopsia;
    }

    /**
     * Set orina
     *
     * @param \AppBundle\Entity\Orina $orina
     *
     * @return ResultadoBCX
     */
    public function setOrina(\AppBundle\Entity\Orina $orina = null)
    {
        $this->orina = $orina;

        return $this;
    }

    /**
     * Get orina
     *
     * @return \AppBundle\Entity\Orina
     */
    public function getOrina()
    {
        return $this->orina;
    }
}
