<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlCalidadBaciloscopia
 *
 * @ORM\Table(name="control_calidad_baciloscopia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ControlCalidadBaciloscopiaRepository")
 */
class ControlCalidadBaciloscopia
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
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="ControlCalidadBaciloscopia")
     */
    private $laboratorio;

    /**
     * @var int
     *
     * @ORM\Column(name="total_muestra_eval", type="integer")
     */
    private $total_Muestra_Eval;

    /**
     * @var int
     *
     * @ORM\Column(name="num_positivas", type="integer")
     */
    private $num_Positivas;

    /**
     * @var int
     *
     * @ORM\Column(name="num_negativas", type="integer")
     */
    private $num_Negativas;

    /**
     * @var int
     *
     * @ORM\Column(name="falsos_positivos", type="integer")
     */
    private $falsos_Positivos;

    /**
     * @var int
     *
     * @ORM\Column(name="falsos_negativos", type="integer")
     */
    private $falsos_Negativos;

    /**
     * @var int
     *
     * @ORM\Column(name="errores_cod", type="integer")
     */
    private $errores_Cod;

    /**
     * @var int
     *
     * @ORM\Column(name="laminas_concord", type="integer")
     */
    private $laminas_Concord;

    /**
     * @var int
     *
     * @ORM\Column(name="lta", type="integer")
     */
    private $lta;

    /**
     * @var int
     *
     * @ORM\Column(name="lea", type="integer")
     */
    private $lea;

    /**
     * @var int
     *
     * @ORM\Column(name="lca", type="integer")
     */
    private $lca;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrada", type="date")
     */
    private $fechaEntrada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificada", type="date")
     */
    private $fechaModificada;




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
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;

        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }


    /**
     * Set fechaModificada
     *
     * @param \DateTime $fechaModificada
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setFechaModificada($fechaModificada)
    {
        $this->fechaModificada = $fechaModificada;

        return $this;
    }

    /**
     * Get fechaModificada
     *
     * @return \DateTime
     */
    public function getFechaModificada()
    {
        return $this->fechaModificada;
    }

    /**
     * Set total_Muestra_Eval
     *
     * @param integer $total_Muestra_Eval
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setTotalMuestraEval($total_Muestra_Eval)
    {
        $this->total_Muestra_Eval = $total_Muestra_Eval;

        return $this;
    }

    /**
     * Get total_Muestra_Eval
     *
     * @return integer
     */
    public function getTotalMuestraEval()
    {
        return $this->total_Muestra_Eval;
    }

    /**
     * Set num_Positivas
     *
     * @param integer $num_Positivas
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setNumPositivas($num_Positivas)
    {
        $this->num_Positivas = $num_Positivas;

        return $this;
    }

    /**
     * Get num_Positivas
     *
     * @return integer
     */
    public function getNumPositivas()
    {
        return $this->num_Positivas;
    }

    /**
     * Set num_Negativas
     *
     * @param integer $num_Negativas
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setNumNegativas($num_Negativas)
    {
        $this->num_Negativas = $num_Negativas;

        return $this;
    }

    /**
     * Get num_Negativas
     *
     * @return integer
     */
    public function getNumNegativas()
    {
        return $this->num_Negativas;
    }

    /**
     * Set falsos_Positivos
     *
     * @param integer $falsos_Positivos
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setFalsosPositivos($falsos_Positivos)
    {
        $this->falsos_Positivos = $falsos_Positivos;

        return $this;
    }

    /**
     * Get falsos_Positivos
     *
     * @return integer
     */
    public function getFalsosPositivos()
    {
        return $this->falsos_Positivos;
    }

    /**
     * Set falsos_Negativos
     *
     * @param integer $falsos_Negativos
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setFalsosNegativos($falsos_Negativos)
    {
        $this->falsos_Negativos = $falsos_Negativos;

        return $this;
    }

    /**
     * Get falsos_Negativos
     *
     * @return integer
     */
    public function getFalsosNegativos()
    {
        return $this->falsos_Negativos;
    }

    /**
     * Set errores_Cod
     *
     * @param integer $errores_Cod
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setErroresCod($errores_Cod)
    {
        $this->errores_Cod = $errores_Cod;

        return $this;
    }

    /**
     * Get errores_Cod
     *
     * @return integer
     */
    public function getErroresCod()
    {
        return $this->errores_Cod;
    }

    /**
     * Set laminas_Concord
     *
     * @param integer $laminas_Concord
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setLaminasConcord($laminas_Concord)
    {
        $this->laminas_Concord = $laminas_Concord;

        return $this;
    }

    /**
     * Get laminas_Concord
     *
     * @return integer
     */
    public function getLaminasConcord()
    {
        return $this->laminas_Concord;
    }

    /**
     * Set lta
     *
     * @param integer $lta
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setLta($lta)
    {
        $this->lta = $lta;

        return $this;
    }

    /**
     * Get lta
     *
     * @return integer
     */
    public function getLta()
    {
        return $this->lta;
    }

    /**
     * Set lea
     *
     * @param integer $lea
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setLea($lea)
    {
        $this->lea = $lea;

        return $this;
    }

    /**
     * Get lea
     *
     * @return integer
     */
    public function getLea()
    {
        return $this->lea;
    }

    /**
     * Set lca
     *
     * @param integer $lca
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setLca($lca)
    {
        $this->lca = $lca;

        return $this;
    }

    /**
     * Get lca
     *
     * @return integer
     */
    public function getLca()
    {
        return $this->lca;
    }

    /**
     * Set laboratorio
     *
     * @param \AppBundle\Entity\AreaSalud $laboratorio
     *
     * @return ControlCalidadBaciloscopia
     */
    public function setLaboratorio(\AppBundle\Entity\AreaSalud $laboratorio = null)
    {
        $this->laboratorio = $laboratorio;

        return $this;
    }

    /**
     * Get laboratorio
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getLaboratorio()
    {
        return $this->laboratorio;
    }
}
