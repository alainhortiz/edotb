<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Resistencia
 *
 * @ORM\Table(name="resistencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResistenciaRepository")
 */
class Resistencia
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
     * @ORM\Column(name="clasificacion", type="string", length=20, unique=true)
     */
    private $clasificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="resistencia")
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
     * Set clasificacion
     *
     * @param string $clasificacion
     *
     * @return Resistencia
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return string
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Resistencia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return Resistencia
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
