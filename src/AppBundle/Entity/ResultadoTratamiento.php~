<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoTratamiento
 *
 * @ORM\Table(name="resultado_tratamiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoTratamientoRepository")
 */
class ResultadoTratamiento
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
     * @ORM\Column(name="resultado", type="string", length=255, unique=true)
     */
    private $resultado;

    /**
     * @var string
     *
     * @ORM\Column(name="modulo", type="string", length=100)
     */
    private $modulo;

    /**
     * @ORM\OneToMany(targetEntity="ResultadoFinal", mappedBy="resultadoTratamiento")
     */
    private $ResultadoFinal;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimientoTPT", mappedBy="resultado")
     */
    private $contactoSeguimientosTPT;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->ResultadoFinal = new ArrayCollection();
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
     * Set resultado
     *
     * @param string $resultado
     *
     * @return ResultadoTratamiento
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return string
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Set modulo
     *
     * @param string $modulo
     *
     * @return ResultadoTratamiento
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
     * Add resultadoFinal
     *
     * @param \AppBundle\Entity\ResultadoFinal $resultadoFinal
     *
     * @return ResultadoTratamiento
     */
    public function addResultadoFinal(\AppBundle\Entity\ResultadoFinal $resultadoFinal)
    {
        $this->ResultadoFinal[] = $resultadoFinal;

        return $this;
    }

    /**
     * Remove resultadoFinal
     *
     * @param \AppBundle\Entity\ResultadoFinal $resultadoFinal
     */
    public function removeResultadoFinal(\AppBundle\Entity\ResultadoFinal $resultadoFinal)
    {
        $this->ResultadoFinal->removeElement($resultadoFinal);
    }

    /**
     * Get resultadoFinal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultadoFinal()
    {
        return $this->ResultadoFinal;
    }

    /**
     * Add contactoSeguimientosTPT
     *
     * @param \AppBundle\Entity\ContactoSeguimientoTPT $contactoSeguimientosTPT
     *
     * @return ResultadoTratamiento
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
