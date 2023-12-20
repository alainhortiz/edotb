<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Enfermedad
 *
 * @ORM\Table(name="enfermedad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnfermedadRepository")
 */
class Enfermedad
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
     * @ORM\Column(name="localizacionAnatomica", type="string", length=100)
     */
    private $localizacionAnatomica;

    /**
     * @var string
     *
     * @ORM\Column(name="definicionCaso", type="string", length=100)
     */
    private $definicionCaso;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoEnfermo", type="string", length=100)
     */
    private $tipoEnfermo;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="enfermedad")
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Enfermedad
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
     * Set localizacionAnatomica
     *
     * @param string $localizacionAnatomica
     *
     * @return Enfermedad
     */
    public function setLocalizacionAnatomica($localizacionAnatomica)
    {
        $this->localizacionAnatomica = $localizacionAnatomica;

        return $this;
    }

    /**
     * Get localizacionAnatomica
     *
     * @return string
     */
    public function getLocalizacionAnatomica()
    {
        return $this->localizacionAnatomica;
    }

    /**
     * Set definicionCaso
     *
     * @param string $definicionCaso
     *
     * @return Enfermedad
     */
    public function setDefinicionCaso($definicionCaso)
    {
        $this->definicionCaso = $definicionCaso;

        return $this;
    }

    /**
     * Get definicionCaso
     *
     * @return string
     */
    public function getDefinicionCaso()
    {
        return $this->definicionCaso;
    }

    /**
     * Set tipoEnfermo
     *
     * @param string $tipoEnfermo
     *
     * @return Enfermedad
     */
    public function setTipoEnfermo($tipoEnfermo)
    {
        $this->tipoEnfermo = $tipoEnfermo;

        return $this;
    }

    /**
     * Get tipoEnfermo
     *
     * @return string
     */
    public function getTipoEnfermo()
    {
        return $this->tipoEnfermo;
    }

    public function criterioCompleto()
    {
        return $this->getTipoEnfermo().' '.$this->getLocalizacionAnatomica().' '.$this->getDefinicionCaso();
    }

    /**
     * Add pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return Enfermedad
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
