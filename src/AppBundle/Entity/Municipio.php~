<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Municipio
 *
 * @ORM\Table(name="municipio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MunicipioRepository")
 */
class Municipio
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
     * @ORM\Column(name="codigo", type="string", length=20, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="municipios")
     */
    private $provincia;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AreaSalud", mappedBy="municipio" , cascade={"remove"})
     * @OrderBy({"id" = "ASC"})
     */
    private $areasSalud;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Hospital", mappedBy="municipio" , cascade={"remove"})
     * @OrderBy({"id" = "ASC"})
     */
    private $hospitales;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimiento", mappedBy="municipio" , cascade={"remove"})
     */
    private $contactoSeguimientos;

    /**
     * @ORM\OneToMany(targetEntity="Poblacion", mappedBy="municipio" , cascade={"remove"})
     */
    private $poblacion;

    /**
     * Municipio constructor.
     */
    public function __construct()
    {
        $this->areasSalud = new ArrayCollection();
        $this->hospitales = new ArrayCollection();
        $this->contactoSeguimientos = new ArrayCollection();
        $this->poblacion = new ArrayCollection();
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Municipio
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Municipio
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
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Municipio
     */
    public function setProvincia(\AppBundle\Entity\Provincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \AppBundle\Entity\Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Add areasSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areasSalud
     *
     * @return Municipio
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

    /**
     * Add hospitale
     *
     * @param \AppBundle\Entity\Hospital $hospitale
     *
     * @return Municipio
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

    /**
     * Add contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     *
     * @return Municipio
     */
    public function addContactoSeguimiento(\AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento)
    {
        $this->contactoSeguimientos[] = $contactoSeguimiento;

        return $this;
    }

    /**
     * Remove contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     */
    public function removeContactoSeguimiento(\AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento)
    {
        $this->contactoSeguimientos->removeElement($contactoSeguimiento);
    }

    /**
     * Get contactoSeguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactoSeguimientos()
    {
        return $this->contactoSeguimientos;
    }

    /**
     * Add poblacion
     *
     * @param \AppBundle\Entity\Poblacion $poblacion
     *
     * @return Municipio
     */
    public function addPoblacion(\AppBundle\Entity\Poblacion $poblacion)
    {
        $this->poblacion[] = $poblacion;

        return $this;
    }

    /**
     * Remove poblacion
     *
     * @param \AppBundle\Entity\Poblacion $poblacion
     */
    public function removePoblacion(\AppBundle\Entity\Poblacion $poblacion)
    {
        $this->poblacion->removeElement($poblacion);
    }

    /**
     * Get poblacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }
}
