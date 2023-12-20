<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoGrafico
 *
 * @ORM\Table(name="estado_grafico")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstadoGraficoRepository")
 */
class EstadoGrafico
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
     * @var int
     *
     * @ORM\Column(name="valorInicial", type="integer")
     */
    private $valorInicial;

    /**
     * @var int
     *
     * @ORM\Column(name="valorFinal", type="integer")
     */
    private $valorFinal;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", unique=true)
     */
    private $year;

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
     * Set valorInicial
     *
     * @param integer $valorInicial
     *
     * @return EstadoGrafico
     */
    public function setValorInicial($valorInicial)
    {
        $this->valorInicial = $valorInicial;

        return $this;
    }

    /**
     * Get valorInicial
     *
     * @return int
     */
    public function getValorInicial()
    {
        return $this->valorInicial;
    }

    /**
     * Set valorFinal
     *
     * @param integer $valorFinal
     *
     * @return EstadoGrafico
     */
    public function setValorFinal($valorFinal)
    {
        $this->valorFinal = $valorFinal;

        return $this;
    }

    /**
     * Get valorFinal
     *
     * @return int
     */
    public function getValorFinal()
    {
        return $this->valorFinal;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return EstadoGrafico
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }
}
