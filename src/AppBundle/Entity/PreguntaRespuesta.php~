<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * PreguntaRespuesta
 *
 * @ORM\Table(name="pregunta_respuesta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PreguntaRespuestaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PreguntaRespuesta
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
     * @ORM\Column(name="pregunta", type="string", length=254)
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="text")
     */
    private $respuesta;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="CategoriaPregunta", inversedBy="preguntas")
     */
    private $categoriaPregunta;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

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
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return PreguntaRespuesta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return PreguntaRespuesta
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PreguntaRespuesta
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFechaValue()
    {
        $this->fecha = new \DateTime();
    }

    /**
     * Set categoriaPregunta
     *
     * @param \AppBundle\Entity\CategoriaPregunta $categoriaPregunta
     *
     * @return PreguntaRespuesta
     */
    public function setCategoriaPregunta(\AppBundle\Entity\CategoriaPregunta $categoriaPregunta = null)
    {
        $this->categoriaPregunta = $categoriaPregunta;

        return $this;
    }

    /**
     * Get categoriaPregunta
     *
     * @return \AppBundle\Entity\CategoriaPregunta
     */
    public function getCategoriaPregunta()
    {
        return $this->categoriaPregunta;
    }
}
