<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlCalidadCultivo
 *
 * @ORM\Table(name="control_calidad_cultivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ControlCalidadCultivoRepository")
 */
class ControlCalidadCultivo
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
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="ControlCalidadCultivo")
     */
    private $laboratorio;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_mas", type="integer")
     */
    private $b_Mas_c_Mas;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_nr", type="integer")
     */
    private $b_Mas_c_Nr;

    /**
     * @var int
     *
     * @ORM\Column(name="b_menos_c_mas", type="integer")
     */
    private $b_Menos_c_Mas;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_menos", type="integer")
     */
    private $b_Mas_c_Menos;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_cont", type="integer")
     */
    private $b_Mas_c_Cont;

    /**
     * @var int
     *
     * @ORM\Column(name="b_nr_c_mas", type="integer")
     */
    private $b_Nr_c_Mas;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_mas_diag", type="integer")
     */
    private $b_Mas_c_Mas_Diag;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_menos_diag", type="integer")
     */
    private $b_Mas_c_Menos_Diag;

    /**
     * @var int
     *
     * @ORM\Column(name="b_mas_c_cont_diag", type="integer")
     */
    private $b_Mas_c_Cont_Diag;

    /**
     * @var int
     *
     * @ORM\Column(name="xpert_mas_c_mas_diag", type="integer")
     */
    private $xpert_Mas_c_Mas_Diag;

    /**
     * @var int
     *
     * @ORM\Column(name="total_lj_inoc", type="integer")
     */
    private $total_LJ_Inoc;

    /**
     * @var int
     *
     * @ORM\Column(name="total_lj_cont", type="integer")
     */
    private $total_LJ_Cont;

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
     * @return ControlCalidadCultivo
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
     * @return ControlCalidadCultivo
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
     * Set b_Mas_c_Mas
     *
     * @param integer $b_Mas_c_Mas
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCMas($b_Mas_c_Mas)
    {
        $this->b_Mas_c_Mas = $b_Mas_c_Mas;

        return $this;
    }

    /**
     * Get b_Mas_c_Mas
     *
     * @return integer
     */
    public function getBMasCMas()
    {
        return $this->b_Mas_c_Mas;
    }

    /**
     * Set b_Mas_c_Nr
     *
     * @param integer $b_Mas_c_Nr
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCNr($b_Mas_c_Nr)
    {
        $this->b_Mas_c_Nr = $b_Mas_c_Nr;

        return $this;
    }

    /**
     * Get b_Mas_c_Nr
     *
     * @return integer
     */
    public function getBMasCNr()
    {
        return $this->b_Mas_c_Nr;
    }

    /**
     * Set b_Menos_c_Mas
     *
     * @param integer $b_Menos_c_Mas
     *
     * @return ControlCalidadCultivo
     */
    public function setBMenosCMas($b_Menos_c_Mas)
    {
        $this->b_Menos_c_Mas = $b_Menos_c_Mas;

        return $this;
    }

    /**
     * Get b_Menos_c_Mas
     *
     * @return integer
     */
    public function getBMenosCMas()
    {
        return $this->b_Menos_c_Mas;
    }

    /**
     * Set b_Mas_c_Menos
     *
     * @param integer $b_Mas_c_Menos
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCMenos($b_Mas_c_Menos)
    {
        $this->b_Mas_c_Menos = $b_Mas_c_Menos;

        return $this;
    }

    /**
     * Get b_Mas_c_Menos
     *
     * @return integer
     */
    public function getBMasCMenos()
    {
        return $this->b_Mas_c_Menos;
    }

    /**
     * Set b_Mas_c_Cont
     *
     * @param integer $b_Mas_c_Cont
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCCont($b_Mas_c_Cont)
    {
        $this->b_Mas_c_Cont = $b_Mas_c_Cont;

        return $this;
    }

    /**
     * Get b_Mas_c_Cont
     *
     * @return integer
     */
    public function getBMasCCont()
    {
        return $this->b_Mas_c_Cont;
    }

    /**
     * Set b_Nr_c_Mas
     *
     * @param integer $b_Nr_c_Mas
     *
     * @return ControlCalidadCultivo
     */
    public function setBNrCMas($b_Nr_c_Mas)
    {
        $this->b_Nr_c_Mas = $b_Nr_c_Mas;

        return $this;
    }

    /**
     * Get b_Nr_c_Mas
     *
     * @return integer
     */
    public function getBNrCMas()
    {
        return $this->b_Nr_c_Mas;
    }

    /**
     * Set total_LJ_Inoc
     *
     * @param integer $total_LJ_Inoc
     *
     * @return ControlCalidadCultivo
     */
    public function setTotalLJInoc($total_LJ_Inoc)
    {
        $this->total_LJ_Inoc = $total_LJ_Inoc;

        return $this;
    }

    /**
     * Get total_LJ_Inoc
     *
     * @return integer
     */
    public function getTotalLJInoc()
    {
        return $this->total_LJ_Inoc;
    }

    /**
     * Set total_LJ_Cont
     *
     * @param integer $total_LJ_Cont
     *
     * @return ControlCalidadCultivo
     */
    public function setTotalLJCont($total_LJ_Cont)
    {
        $this->total_LJ_Cont = $total_LJ_Cont;

        return $this;
    }

    /**
     * Get total_LJ_Cont
     *
     * @return integer
     */
    public function getTotalLJCont()
    {
        return $this->total_LJ_Cont;
    }

    /**
     * Set laboratorio
     *
     * @param \AppBundle\Entity\AreaSalud $laboratorio
     *
     * @return ControlCalidadCultivo
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

    //---------------------------------------------------------------------------------------------
    //CAMPOS NUEVOS AGREGADOS PARA LOS CASOS DIAGNOSTICOS
    //---------------------------------------------------------------------------------------------

    /**
     * Set b_Mas_c_Mas_Diag
     *
     * @param integer $b_Mas_c_Mas_Diag
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCMasDiag($b_Mas_c_Mas_Diag)
    {
        $this->b_Mas_c_Mas_Diag = $b_Mas_c_Mas_Diag;

        return $this;
    }

    /**
     * Get b_Mas_c_Mas_Diag
     *
     * @return integer
     */
    public function getBMasCMasDiag()
    {
        return $this->b_Mas_c_Mas_Diag;
    }

    /**
     * Set b_Mas_c_Menos_Diag
     *
     * @param integer $b_Mas_c_Menos_Diag
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCMenosDiag($b_Mas_c_Menos_Diag)
    {
        $this->b_Mas_c_Menos_Diag = $b_Mas_c_Menos_Diag;

        return $this;
    }

    /**
     * Get b_Mas_c_Menos_Diag
     *
     * @return integer
     */
    public function getBMasCMenosDiag()
    {
        return $this->b_Mas_c_Menos_Diag;
    }

    /**
     * Set b_Mas_c_Cont_Diag
     *
     * @param integer $b_Mas_c_Cont_Diag
     *
     * @return ControlCalidadCultivo
     */
    public function setBMasCContDiag($b_Mas_c_Cont_Diag)
    {
        $this->b_Mas_c_Cont_Diag = $b_Mas_c_Cont_Diag;

        return $this;
    }

    /**
     * Get b_Mas_c_Cont_Diag
     *
     * @return integer
     */
    public function getBMasCContDiag()
    {
        return $this->b_Mas_c_Cont_Diag;
    }

    /**
     * Set xpert_Mas_c_Mas_Diag
     *
     * @param integer $xpert_Mas_c_Mas_Diag
     *
     * @return ControlCalidadCultivo
     */
    public function setXpertMasCMasDiag($xpert_Mas_c_Mas_Diag)
    {
        $this->xpert_Mas_c_Mas_Diag = $xpert_Mas_c_Mas_Diag;

        return $this;
    }

    /**
     * Get xpert_Mas_c_Mas_Diag
     *
     * @return integer
     */
    public function getXpertMasCMasDiag()
    {
        return $this->xpert_Mas_c_Mas_Diag;
    }
}
