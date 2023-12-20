<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaciloscopiaSeguimiento
 *
 * @ORM\Table(name="baciloscopia_seguimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BaciloscopiaSeguimientoRepository")
 */
class BaciloscopiaSeguimiento
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
     * @ORM\ManyToOne(targetEntity="Baciloscopia", inversedBy="baciloscopiasSeguimiento")
     */
    private $baciloscopia;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PacienteEvolucion", inversedBy="baciloscopiaSeguimientos")
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
     * @return BaciloscopiaSeguimiento
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
     * Set baciloscopia
     *
     * @param \AppBundle\Entity\Baciloscopia $baciloscopia
     *
     * @return BaciloscopiaSeguimiento
     */
    public function setBaciloscopia(\AppBundle\Entity\Baciloscopia $baciloscopia = null)
    {
        $this->baciloscopia = $baciloscopia;

        return $this;
    }

    /**
     * Get baciloscopia
     *
     * @return \AppBundle\Entity\Baciloscopia
     */
    public function getBaciloscopia()
    {
        return $this->baciloscopia;
    }

    /**
     * Set pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return BaciloscopiaSeguimiento
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
     * @return BaciloscopiaSeguimiento
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
