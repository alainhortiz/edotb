<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PruebaSensibilidad
 *
 * @ORM\Table(name="prueba_sensibilidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PruebaSensibilidadRepository")
 */
class PruebaSensibilidad
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="pruebaSensibilidad")
     */
    private $PacienteEvolucion;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->PacienteEvolucion = new ArrayCollection();
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
     * @return PruebaSensibilidad
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
     * Add pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return PruebaSensibilidad
     */
    public function addPacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion)
    {
        $this->PacienteEvolucion[] = $pacienteEvolucion;

        return $this;
    }

    /**
     * Remove pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     */
    public function removePacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion)
    {
        $this->PacienteEvolucion->removeElement($pacienteEvolucion);
    }

    /**
     * Get pacienteEvolucion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacienteEvolucion()
    {
        return $this->PacienteEvolucion;
    }
}
