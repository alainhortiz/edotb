<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MedicamentoPrimeraLinea
 *
 * @ORM\Table(name="medicamento_primera_linea")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedicamentoPrimeraLineaRepository")
 */
class MedicamentoPrimeraLinea
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
     * @var string
     *
     * @ORM\Column(name="modulo", type="string", length=100)
     */
    private $modulo;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimientoFactorRiesgo", mappedBy="medicamento")
     */
    private $contactoSeguimientos;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimientoTPT", mappedBy="medicamento")
     */
    private $contactoSeguimientosTPT;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->contactoSeguimientos = new ArrayCollection();
        $this->contactoSeguimientosTPT = new ArrayCollection();
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
     * @return MedicamentoPrimeraLinea
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
     * Set modulo
     *
     * @param string $modulo
     *
     * @return MedicamentoPrimeraLinea
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return string
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Add contactoSeguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimientoFactorRiesgo $contactoSeguimiento
     *
     * @return MedicamentoPrimeraLinea
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

    /**
     * Add contactoSeguimientosTPT
     *
     * @param \AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientosTPT
     *
     * @return MedicamentoPrimeraLinea
     */
    public function addContactoSeguimientosTPT(\AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientosTPT)
    {
        $this->contactoSeguimientosTPT[] = $contactoSeguimientosTPT;

        return $this;
    }

    /**
     * Remove contactoSeguimientosTPT
     *
     * @param \AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientosTPT
     */
    public function removeContactoSeguimientosTPT(\AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientosTPT)
    {
        $this->contactoSeguimientosTPT->removeElement($contactoSeguimientosTPT);
    }

    /**
     * Get contactoSeguimientosTPT
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactoSeguimientosTPT()
    {
        return $this->contactoSeguimientosTPT;
    }
}
