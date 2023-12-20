<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaisRepository")
 */
class Pais
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
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="pais")
     */
    private $PacienteEvolucion;

    /**
     * @ORM\OneToMany(targetEntity="PacienteSintomatico", mappedBy="pais")
     */
    private $PacienteSintomatico;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->PacienteEvolucion = new ArrayCollection();
        $this->PacienteSintomatico = new ArrayCollection();
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
     * @return Pais
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
     * @return Pais
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
     * @return Pais
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

    /**
     * Add pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return Pais
     */
    public function addPacienteSintomatico(\AppBundle\Entity\PacienteSintomatico $pacienteSintomatico)
    {
        $this->PacienteSintomatico[] = $pacienteSintomatico;

        return $this;
    }

    /**
     * Remove pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     */
    public function removePacienteSintomatico(\AppBundle\Entity\PacienteSintomatico $pacienteSintomatico)
    {
        $this->PacienteSintomatico->removeElement($pacienteSintomatico);
    }

    /**
     * Get pacienteSintomatico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacienteSintomatico()
    {
        return $this->PacienteSintomatico;
    }
}
