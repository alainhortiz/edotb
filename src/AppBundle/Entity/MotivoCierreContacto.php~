<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MotivoCierreContacto
 *
 * @ORM\Table(name="motivo_cierre_contacto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MotivoCierreContactoRepository")
 */
class MotivoCierreContacto
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
     * @ORM\Column(name="nombre", type="string", length=254)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimiento", mappedBy="motivoCierre")
     */
    private $contactoSeguimientos;

    /**
     * constructor.
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
     * @return MotivoCierreContacto
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
     * @param \AppBundle\Entity\ContactoSeguimiento $contactoSeguimiento
     *
     * @return MotivoCierreContacto
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
}
