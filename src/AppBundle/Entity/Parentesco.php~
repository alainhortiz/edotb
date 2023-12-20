<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parentesco
 *
 * @ORM\Table(name="parentesco")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParentescoRepository")
 */
class Parentesco
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
     * @ORM\OneToMany(targetEntity="ContactoSeguimientoFactorRiesgo", mappedBy="parantesco")
     */
    private $contactoSeguimientos;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->contactoSeguimientos = new ArrayCollection();
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
     * @return Parentesco
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
     * Add contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimiento
     *
     * @return Parentesco
     */
    public function addContactoSeguimiento(\AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimiento)
    {
        $this->contactoSeguimientos[] = $contactoSeguimiento;

        return $this;
    }

    /**
     * Remove contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimiento
     */
    public function removeContactoSeguimiento(\AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimiento)
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
}
