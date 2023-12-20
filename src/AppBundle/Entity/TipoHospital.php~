<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoHospital
 *
 * @ORM\Table(name="tipo_hospital")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoHospitalRepository")
 */
class TipoHospital
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=5, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=150, unique=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Hospital", mappedBy="tipoHospistal" , cascade={"remove"})
     */
    private $hospitales;


    /**
     * Expedientes constructor.
     */
    public function __construct()
    {
        $this->hospitales  = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoHospital
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return TipoHospital
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Add hospitale
     *
     * @param \AppBundle\Entity\Hospital $hospitale
     *
     * @return TipoHospital
     */
    public function addHospitale(\AppBundle\Entity\Hospital $hospitale)
    {
        $this->hospitales[] = $hospitale;

        return $this;
    }

    /**
     * Remove hospitale
     *
     * @param \AppBundle\Entity\Hospital $hospitale
     */
    public function removeHospitale(\AppBundle\Entity\Hospital $hospitale)
    {
        $this->hospitales->removeElement($hospitale);
    }

    /**
     * Get hospitales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHospitales()
    {
        return $this->hospitales;
    }

    public function cantidadHospitales()
    {
        return count($this->hospitales);
    }
}
