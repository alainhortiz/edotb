<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriaPregunta
 *
 * @ORM\Table(name="categoria_pregunta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaPreguntaRepository")
 */
class CategoriaPregunta
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
     * @ORM\OneToMany(targetEntity="PreguntaRespuesta", mappedBy="categoriaPregunta" , cascade={"remove"})
     */
    private $preguntas;

    /**
     * Expedientes constructor.
     */
    public function __construct()
    {
        $this->preguntas  = new ArrayCollection();
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
     * @return CategoriaPregunta
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
     * Add pregunta
     *
     * @param \AppBundle\Entity\PreguntaRespuesta $pregunta
     *
     * @return CategoriaPregunta
     */
    public function addPregunta(\AppBundle\Entity\PreguntaRespuesta $pregunta)
    {
        $this->preguntas[] = $pregunta;

        return $this;
    }

    /**
     * Remove pregunta
     *
     * @param \AppBundle\Entity\PreguntaRespuesta $pregunta
     */
    public function removePregunta(\AppBundle\Entity\PreguntaRespuesta $pregunta)
    {
        $this->preguntas->removeElement($pregunta);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    public function cantidadPreguntas()
    {
        return count($this->preguntas);
    }
}
