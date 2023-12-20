<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoAreaSalud
 *
 * @ORM\Table(name="tipo_area_salud")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoAreaSaludRepository")
 */
class TipoAreaSalud
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AreaSalud", mappedBy="tipoAreaSalud" , cascade={"remove"})
     */
    private $areasSalud;

    /**
     * Expedientes constructor.
     */
    public function __construct()
    {
        $this->areasSalud  = new ArrayCollection();
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
     * @return TipoAreaSalud
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
     * Add areasSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areasSalud
     *
     * @return TipoAreaSalud
     */
    public function addAreasSalud(\AppBundle\Entity\AreaSalud $areasSalud)
    {
        $this->areasSalud[] = $areasSalud;

        return $this;
    }

    /**
     * Remove areasSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areasSalud
     */
    public function removeAreasSalud(\AppBundle\Entity\AreaSalud $areasSalud)
    {
        $this->areasSalud->removeElement($areasSalud);
    }

    /**
     * Get areasSalud
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAreasSalud()
    {
        return $this->areasSalud;
    }
}
