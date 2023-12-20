<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CultivoSeguimiento
 *
 * @ORM\Table(name="cultivo_seguimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CultivoSeguimientoRepository")
 */
class CultivoSeguimiento
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Cultivo", inversedBy="cultivoSeguimientos")
     */
    private $cultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="SalidaCultivo", inversedBy="cultivoSeguimientos")
     */
    private $salidaCultivo;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PacienteEvolucion", inversedBy="cultivoSeguimientos")
     */
    private $pacienteEvolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=100)
     */
    private $categoria;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CultivoSeguimiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cultivo
     *
     * @param \AppBundle\Entity\Cultivo $cultivo
     *
     * @return CultivoSeguimiento
     */
    public function setCultivo(\AppBundle\Entity\Cultivo $cultivo = null)
    {
        $this->cultivo = $cultivo;

        return $this;
    }

    /**
     * Get cultivo
     *
     * @return \AppBundle\Entity\Cultivo
     */
    public function getCultivo()
    {
        return $this->cultivo;
    }

    /**
     * Set salidaCultivo
     *
     * @param \AppBundle\Entity\SalidaCultivo $salidaCultivo
     *
     * @return CultivoSeguimiento
     */
    public function setSalidaCultivo(\AppBundle\Entity\SalidaCultivo $salidaCultivo = null)
    {
        $this->salidaCultivo = $salidaCultivo;

        return $this;
    }

    /**
     * Get salidaCultivo
     *
     * @return \AppBundle\Entity\SalidaCultivo
     */
    public function getSalidaCultivo()
    {
        return $this->salidaCultivo;
    }

    /**
     * Set pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return CultivoSeguimiento
     */
    public function setPacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion = null)
    {
        $this->pacienteEvolucion = $pacienteEvolucion;

        return $this;
    }

    /**
     * Get pacienteEvolucion
     *
     * @return \AppBundle\Entity\PacienteEvolucion
     */
    public function getPacienteEvolucion()
    {
        return $this->pacienteEvolucion;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return CultivoSeguimiento
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
