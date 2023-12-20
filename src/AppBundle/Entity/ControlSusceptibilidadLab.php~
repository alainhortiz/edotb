<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlSusceptibilidadLab
 *
 * @ORM\Table(name="control_susceptibilidad_lab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ControlSusceptibilidadLabRepository")
 */
class ControlSusceptibilidadLab
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
     * @ORM\ManyToOne(targetEntity="PacienteEvolucion", inversedBy="susceptibilidadControles")
     */
    private $pacienteEvolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoMuestra", type="string", length=60)
     */
    private $codigoMuestra;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="ControlSusceptibilidadLab")
     */
    private $resistencia;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_nit_fh", type="integer")
     */
    private $met_fen_nit_fh;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_nit_fr", type="integer")
     */
    private $met_fen_nit_fr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoNitra", type="date", nullable = true)
     */
    private $fechaFenoNitra;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fs", type="integer")
     */
    private $met_fen_prop_fs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFS", type="date", nullable = true)
     */
    private $fechaFenoPropFS;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fe", type="integer")
     */
    private $met_fen_prop_fe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFE", type="date", nullable = true)
     */
    private $fechaFenoPropFE;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fam", type="integer")
     */
    private $met_fen_prop_fam;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFAM", type="date", nullable = true)
     */
    private $fechaFenoPropFAM;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fkm", type="integer")
     */
    private $met_fen_prop_fkm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFKM", type="date", nullable = true)
     */
    private $fechaFenoPropFKM;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fcm", type="integer")
     */
    private $met_fen_prop_fcm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFCM", type="date", nullable = true)
     */
    private $fechaFenoPropFCM;

    /**
     * @var int
     *
     * @ORM\Column(name="met_fen_prop_fmfx", type="integer")
     */
    private $met_fen_prop_fmfx;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFenoPropFMFX", type="date", nullable = true)
     */
    private $fechaFenoPropFMFX;

    /**
     * @var int
     *
     * @ORM\Column(name="met_mtbdrplus_fh", type="integer")
     */
    private $met_mtbdrplus_fh;

    /**
     * @var int
     *
     * @ORM\Column(name="met_mtbdrplus_fr", type="integer")
     */
    private $met_mtbdrplus_fr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaMTBDRPlus", type="date", nullable = true)
     */
    private $fechaMTBDRPlus;

    /**
     * @var int
     *
     * @ORM\Column(name="met_mtbdrsl_ffq", type="integer")
     */
    private $met_mtbdrsl_ffq;

    /**
     * @var int
     *
     * @ORM\Column(name="met_mtbdrsl_fagcp", type="integer")
     */
    private $met_mtbdrsl_fagcp;

    /**
     * @var int
     *
     * @ORM\Column(name="met_mtbdrsl_fkan", type="integer")
     */
    private $met_mtbdrsl_fkan;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaMTBDRSL", type="date", nullable = true)
     */
    private $fechaMTBDRSL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntradaFila", type="date")
     */
    private $fechaEntradaFila;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificadaFila", type="date")
     */
    private $fechaModificadaFila;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var int
     *
     * @ORM\Column(name="idTablaPac", type="integer")
     */
    private $idTablaPac;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="ControlSusceptibilidadLab")
     */
    private $resistenciaParcNitra;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="ControlSusceptibilidadLab")
     */
    private $resistenciaParcProp;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="ControlSusceptibilidadLab")
     */
    private $resistenciaParcMtbdrplus;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Resistencia", inversedBy="ControlSusceptibilidadLab")
     */
    private $resistenciaParcMtbdrsl;



    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------



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
     * Set pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return PacienteEvolucion
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
     * Set codigoMuestra
     *
     * @param string $codigoMuestra
     *
     * @return Pais
     */
    public function setCodigoMuestra($codigoMuestra)
    {
        $this->codigoMuestra = $codigoMuestra;
        return $this;
    }

    /**
     * Get codigoMuestra
     *
     * @return string
     */
    public function getCodigoMuestra()
    {
        return $this->codigoMuestra;
    }

    /**
     * Set resistencia
     *
     * @param \AppBundle\Entity\Resistencia $resistencia
     *
     * @return ControlSusceptibilidadLab
     */
    public function setResistencia(\AppBundle\Entity\Resistencia $resistencia = null)
    {
        $this->resistencia = $resistencia;
        return $this;
    }

    /**
     * Get resistencia
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistencia()
    {
        return $this->resistencia;
    }


    /**
     * Set met_fen_nit_fh;
     *
     * @param integer $met_fen_nit_fh;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenNitFh($met_fen_nit_fh)
    {
        $this->met_fen_nit_fh = $met_fen_nit_fh;
        return $this;
    }

    /**
     * Get met_fen_nit_fh
     *
     * @return integer
     */
    public function getMetFenNitFh()
    {
        return $this->met_fen_nit_fh;
    }


    /**
     * Set met_fen_nit_fr;
     *
     * @param integer $met_fen_nit_fr;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenNitFr($met_fen_nit_fr)
    {
        $this->met_fen_nit_fr = $met_fen_nit_fr;
        return $this;
    }

    /**
     * Get met_fen_nit_fr
     *
     * @return integer
     */
    public function getMetFenNitFr()
    {
        return $this->met_fen_nit_fr;
    }



    /**
     * Set fechaFenoNitra;
     *
     * @param \DateTime $fechaFenoNitra;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoNitra($fechaFenoNitra)
    {
        $this->fechaFenoNitra = $fechaFenoNitra;
        return $this;
    }

    /**
     * Get fechaFenoNitra
     *
     * @return \DateTime
     */
    public function getFechaFenoNitra()
    {
        return $this->fechaFenoNitra;
    }


    /**
     * Set met_fen_prop_fs;
     *
     * @param integer $met_fen_prop_fs;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFs($met_fen_prop_fs)
    {
        $this->met_fen_prop_fs = $met_fen_prop_fs;
        return $this;
    }

    /**
     * Get met_fen_prop_fs
     *
     * @return integer
     */
    public function getMetFenPropFs()
    {
        return $this->met_fen_prop_fs;
    }

    /**
     * Set fechaFenoPropFS;
     *
     * @param \DateTime $fechaFenoPropFS;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFs($fechaFenoPropFS)
    {
        $this->fechaFenoPropFS = $fechaFenoPropFS;
        return $this;
    }

    /**
     * Get fechaFenoPropFS
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFs()
    {
        return $this->fechaFenoPropFS;
    }


    /**
     * Set met_fen_prop_fe;
     *
     * @param integer $met_fen_prop_fe;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFe($met_fen_prop_fe)
    {
        $this->met_fen_prop_fe = $met_fen_prop_fe;
        return $this;
    }

    /**
     * Get met_fen_prop_fe
     *
     * @return integer
     */
    public function getMetFenPropFe()
    {
        return $this->met_fen_prop_fe;
    }

    /**
     * Set fechaFenoPropFE;
     *
     * @param \DateTime $fechaFenoPropFE;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFE($fechaFenoPropFE)
    {
        $this->fechaFenoPropFE = $fechaFenoPropFE;
        return $this;
    }

    /**
     * Get fechaFenoPropFE
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFE()
    {
        return $this->fechaFenoPropFE;
    }


    /**
     * Set met_fen_prop_fam;
     *
     * @param integer $met_fen_prop_fam;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFam($met_fen_prop_fam)
    {
        $this->met_fen_prop_fam = $met_fen_prop_fam;
        return $this;
    }

    /**
     * Get met_fen_prop_fam
     *
     * @return integer
     */
    public function getMetFenPropFam()
    {
        return $this->met_fen_prop_fam;
    }

    /**
     * Set fechaFenoPropFAM;
     *
     * @param \DateTime $fechaFenoPropFAM;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFAM($fechaFenoPropFAM)
    {
        $this->fechaFenoPropFAM = $fechaFenoPropFAM;
        return $this;
    }

    /**
     * Get fechaFenoPropFAM
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFAM()
    {
        return $this->fechaFenoPropFAM;
    }


    /**
     * Set met_fen_prop_fkm;
     *
     * @param integer $met_fen_prop_fkm;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFkm($met_fen_prop_fkm)
    {
        $this->met_fen_prop_fkm = $met_fen_prop_fkm;
        return $this;
    }

    /**
     * Get met_fen_prop_fkm
     *
     * @return integer
     */
    public function getMetFenPropFkm()
    {
        return $this->met_fen_prop_fkm;
    }

    /**
     * Set fechaFenoPropFKM;
     *
     * @param \DateTime $fechaFenoPropFKM;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFKM($fechaFenoPropFKM)
    {
        $this->fechaFenoPropFKM = $fechaFenoPropFKM;
        return $this;
    }

    /**
     * Get fechaFenoPropFKM
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFKM()
    {
        return $this->fechaFenoPropFKM;
    }


    /**
     * Set met_fen_prop_fcm;
     *
     * @param integer $met_fen_prop_fcm;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFcm($met_fen_prop_fcm)
    {
        $this->met_fen_prop_fcm = $met_fen_prop_fcm;
        return $this;
    }

    /**
     * Get met_fen_prop_fcm
     *
     * @return integer
     */
    public function getMetFenPropFcm()
    {
        return $this->met_fen_prop_fcm;
    }

    /**
     * Set fechaFenoPropFCM;
     *
     * @param \DateTime $fechaFenoPropFCM;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFCM($fechaFenoPropFCM)
    {
        $this->fechaFenoPropFCM = $fechaFenoPropFCM;
        return $this;
    }

    /**
     * Get fechaFenoPropFCM
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFCM()
    {
        return $this->fechaFenoPropFCM;
    }


    /**
     * Set met_fen_prop_fmfx;
     *
     * @param integer $met_fen_prop_fmfx;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetFenPropFmfx($met_fen_prop_fmfx)
    {
        $this->met_fen_prop_fmfx = $met_fen_prop_fmfx;
        return $this;
    }

    /**
     * Get met_fen_prop_fmfx
     *
     * @return integer
     */
    public function getMetFenPropFmfx()
    {
        return $this->met_fen_prop_fmfx;
    }

    /**
     * Set fechaFenoPropFMFX;
     *
     * @param \DateTime $fechaFenoPropFMFX;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaFenoPropFMFX($fechaFenoPropFMFX)
    {
        $this->fechaFenoPropFMFX = $fechaFenoPropFMFX;
        return $this;
    }

    /**
     * Get fechaFenoPropFMFX
     *
     * @return \DateTime
     */
    public function getFechaFenoPropFMFX()
    {
        return $this->fechaFenoPropFMFX;
    }


    /**
     * Set met_mtbdrplus_fh;
     *
     * @param integer $met_mtbdrplus_fh;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetMtbdrplusFh($met_mtbdrplus_fh)
    {
        $this->met_mtbdrplus_fh = $met_mtbdrplus_fh;
        return $this;
    }

    /**
     * Get met_mtbdrplus_fh
     *
     * @return integer
     */
    public function getMetMtbdrplusFh()
    {
        return $this->met_mtbdrplus_fh;
    }

    /**
     * Set met_mtbdrplus_fr;
     *
     * @param integer $met_mtbdrplus_fr;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetMtbdrplusFr($met_mtbdrplus_fr)
    {
        $this->met_mtbdrplus_fr = $met_mtbdrplus_fr;
        return $this;
    }

    /**
     * Get met_mtbdrplus_fr
     *
     * @return integer
     */
    public function getMetMtbdrplusFr()
    {
        return $this->met_mtbdrplus_fr;
    }

    /**
     * Set fechaMTBDRPlus;
     *
     * @param \DateTime $fechaMTBDRPlus;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaMTBDRPlus($fechaMTBDRPlus)
    {
        $this->fechaMTBDRPlus = $fechaMTBDRPlus;
        return $this;
    }

    /**
     * Get fechaMTBDRPlus
     *
     * @return \DateTime
     */
    public function getFechaMTBDRPlus()
    {
        return $this->fechaMTBDRPlus;
    }

    /**
     * Set met_mtbdrsl_ffq;
     *
     * @param integer $met_mtbdrsl_ffq;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetMtbdrslFfq($met_mtbdrsl_ffq)
    {
        $this->met_mtbdrsl_ffq = $met_mtbdrsl_ffq;
        return $this;
    }

    /**
     * Get met_mtbdrsl_ffq
     *
     * @return integer
     */
    public function getMetMtbdrslFfq()
    {
        return $this->met_mtbdrsl_ffq;
    }

    /**
     * Set met_mtbdrsl_fagcp;
     *
     * @param integer $met_mtbdrsl_fagcp;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetMtbdrslFagcp($met_mtbdrsl_fagcp)
    {
        $this->met_mtbdrsl_fagcp = $met_mtbdrsl_fagcp;
        return $this;
    }

    /**
     * Get met_mtbdrsl_fagcp
     *
     * @return integer
     */
    public function getMetMtbdrslFagcp()
    {
        return $this->met_mtbdrsl_fagcp;
    }

    /**
     * Set met_mtbdrsl_fkan;
     *
     * @param integer $met_mtbdrsl_fkan;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setMetMtbdrslFkan($met_mtbdrsl_fkan)
    {
        $this->met_mtbdrsl_fkan = $met_mtbdrsl_fkan;
        return $this;
    }

    /**
     * Get met_mtbdrsl_fkan
     *
     * @return integer
     */
    public function getMetMtbdrslFkan()
    {
        return $this->met_mtbdrsl_fkan;
    }

    /**
     * Set fechaMTBDRSL;
     *
     * @param \DateTime $fechaMTBDRSL;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaMTBDRSL($fechaMTBDRSL)
    {
        $this->fechaMTBDRSL = $fechaMTBDRSL;
        return $this;
    }

    /**
     * Get fechaMTBDRSL
     *
     * @return \DateTime
     */
    public function getFechaMTBDRSL()
    {
        return $this->fechaMTBDRSL;
    }


    /**
     * Set fechaEntradaFila
     *
     * @param \DateTime $fechaEntradaFila
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaEntradaFila($fechaEntradaFila)
    {
        $this->fechaEntradaFila = $fechaEntradaFila;
        return $this;
    }

    /**
     * Get fechaEntradaFila
     *
     * @return \DateTime
     */
    public function getFechaEntradaFila()
    {
        return $this->fechaEntradaFila;
    }


    /**
     * Set fechaModificadaFila
     *
     * @param \DateTime $fechaModificadaFila
     *
     * @return ControlSusceptibilidadLab
     */
    public function setFechaModificadaFila($fechaModificadaFila)
    {
        $this->fechaModificadaFila = $fechaModificadaFila;
        return $this;
    }

    /**
     * Get fechaModificadaFila
     *
     * @return \DateTime
     */
    public function getFechaModificadaFila()
    {
        return $this->fechaModificadaFila;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ControlSusceptibilidadLab
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set idTablaPac;
     *
     * @param integer $idTablaPac;
     *
     * @return ControlSusceptibilidadLab
     */
    public function setIdTablaPac($idTablaPac)
    {
        $this->idTablaPac = $idTablaPac;
        return $this;
    }

    /**
     * Get idTablaPac
     *
     * @return integer
     */
    public function getIdTablaPac()
    {
        return $this->idTablaPac;
    }

    /**
     * Set resistenciaParcNitra
     *
     * @param \AppBundle\Entity\Resistencia $resistenciaParcNitra
     *
     * @return ControlSusceptibilidadLab
     */
    public function setResistenciaParcNitra(\AppBundle\Entity\Resistencia $resistenciaParcNitra = null)
    {
        $this->resistenciaParcNitra = $resistenciaParcNitra;
        return $this;
    }

    /**
     * Get resistenciaParcNitra
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistenciaParcNitra()
    {
        return $this->resistenciaParcNitra;
    }

    /**
     * Set resistenciaParcProp
     *
     * @param \AppBundle\Entity\Resistencia $resistenciaParcProp
     *
     * @return ControlSusceptibilidadLab
     */
    public function setResistenciaParcProp(\AppBundle\Entity\Resistencia $resistenciaParcProp = null)
    {
        $this->resistenciaParcProp = $resistenciaParcProp;
        return $this;
    }

    /**
     * Get resistenciaParcNitra
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistenciaParcProp()
    {
        return $this->resistenciaParcProp;
    }

    /**
     * Set resistenciaParcMtbdrplus
     *
     * @param \AppBundle\Entity\Resistencia $resistenciaParcMtbdrplus
     *
     * @return ControlSusceptibilidadLab
     */
    public function setResistenciaParcMtbdrplus(\AppBundle\Entity\Resistencia $resistenciaParcMtbdrplus = null)
    {
        $this->resistenciaParcMtbdrplus = $resistenciaParcMtbdrplus;
        return $this;
    }

    /**
     * Get resistenciaParcMtbdrplus
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistenciaParcMtbdrplus()
    {
        return $this->resistenciaParcMtbdrplus;
    }

    /**
     * Set resistenciaParcMtbdrsl
     *
     * @param \AppBundle\Entity\Resistencia $resistenciaParcMtbdrsl
     *
     * @return ControlSusceptibilidadLab
     */
    public function setResistenciaParcMtbdrsl(\AppBundle\Entity\Resistencia $resistenciaParcMtbdrsl = null)
    {
        $this->resistenciaParcMtbdrsl = $resistenciaParcMtbdrsl;
        return $this;
    }

    /**
     * Get resistenciaParcMtbdrsl
     *
     * @return \AppBundle\Entity\Resistencia
     */
    public function getResistenciaParcMtbdrsl()
    {
        return $this->resistenciaParcMtbdrsl;
    }


}
