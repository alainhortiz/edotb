<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstudioGrupoVulnerable
 *
 * @ORM\Table(name="estudio_grupo_vulnerable")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstudioGrupoVulnerableRepository")
 */
class EstudioGrupoVulnerable
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
     * @var int
     *
     * @ORM\Column(name="identificados", type="integer")
     */
    private $identificados;

    /**
     * @var int
     *
     * @ORM\Column(name="identificadosMenoresCinco", type="integer", nullable=true)
     */
    private $identificadosMenoresCinco;

    /**
     * @var int
     *
     * @ORM\Column(name="tuberculinasRealizadas", type="integer", nullable=true)
     */
    private $tuberculinasRealizadas;

    /**
     * @var int
     *
     * @ORM\Column(name="tuberculinasRealizadasMenoresCinco", type="integer",  nullable=true)
     */
    private $tuberculinasRealizadasMenoresCinco;

    /**
     * @var int
     *
     * @ORM\Column(name="tuberculinasPositivas", type="integer", nullable=true)
     */
    private $tuberculinasPositivas;

    /**
     * @var int
     *
     * @ORM\Column(name="tuberculinasPositivasMenoresCinco", type="integer", nullable=true)
     */
    private $tuberculinasPositivasMenoresCinco;

    /**
     * @var int
     *
     * @ORM\Column(name="terapiaPreventivaIsoniazidaIniciadas", type="integer", nullable=true)
     */
    private $terapiaPreventivaIsoniazidaIniciadas;

    /**
     * @var int
     *
     * @ORM\Column(name="terapiaPreventivaIsoniazidaIniciadasMenoresCinco", type="integer", nullable=true)
     */
    private $terapiaPreventivaIsoniazidaIniciadasMenoresCinco;

    /**
     * @var int
     *
     * @ORM\Column(name="terapiaPreventivaIsoniazidaTerminadas", type="integer", nullable=true)
     */
    private $terapiaPreventivaIsoniazidaTerminadas;

    /**
     * @var int
     *
     * @ORM\Column(name="terapiaPreventivaIsoniazidaTerminadasMenoresCinco", type="integer", nullable=true)
     */
    private $terapiaPreventivaIsoniazidaTerminadasMenoresCinco;

    /**
     * @var int
     *
     * @ORM\Column(name="cotrimoxazolPacientesCoinfectados", type="integer", nullable=true)
     */
    private $cotrimoxazolPacientesCoinfectados;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="GrupoVulnerable", inversedBy="EstudioGrupoVulnerable")
     */
    private $grupoVulnerable;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="EstudioGrupoVulnerable")
     */
    private $areaSalud;


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
     * @return EstudioGrupoVulnerable
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
     * Set identificados
     *
     * @param integer $identificados
     *
     * @return EstudioGrupoVulnerable
     */
    public function setIdentificados($identificados)
    {
        $this->identificados = $identificados;

        return $this;
    }

    /**
     * Get identificados
     *
     * @return int
     */
    public function getIdentificados()
    {
        return $this->identificados;
    }

    /**
     * Set identificadosMenoresCinco
     *
     * @param integer $identificadosMenoresCinco
     *
     * @return EstudioGrupoVulnerable
     */
    public function setIdentificadosMenoresCinco($identificadosMenoresCinco)
    {
        $this->identificadosMenoresCinco = $identificadosMenoresCinco;

        return $this;
    }

    /**
     * Get identificadosMenoresCinco
     *
     * @return int
     */
    public function getIdentificadosMenoresCinco()
    {
        return $this->identificadosMenoresCinco;
    }

    /**
     * Set tuberculinasRealizadas
     *
     * @param integer $tuberculinasRealizadas
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTuberculinasRealizadas($tuberculinasRealizadas)
    {
        $this->tuberculinasRealizadas = $tuberculinasRealizadas;

        return $this;
    }

    /**
     * Get tuberculinasRealizadas
     *
     * @return int
     */
    public function getTuberculinasRealizadas()
    {
        return $this->tuberculinasRealizadas;
    }

    /**
     * Set tuberculinasRealizadasMenoresCinco
     *
     * @param integer $tuberculinasRealizadasMenoresCinco
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTuberculinasRealizadasMenoresCinco($tuberculinasRealizadasMenoresCinco)
    {
        $this->tuberculinasRealizadasMenoresCinco = $tuberculinasRealizadasMenoresCinco;

        return $this;
    }

    /**
     * Get tuberculinasRealizadasMenoresCinco
     *
     * @return int
     */
    public function getTuberculinasRealizadasMenoresCinco()
    {
        return $this->tuberculinasRealizadasMenoresCinco;
    }

    /**
     * Set tuberculinasPositivas
     *
     * @param integer $tuberculinasPositivas
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTuberculinasPositivas($tuberculinasPositivas)
    {
        $this->tuberculinasPositivas = $tuberculinasPositivas;

        return $this;
    }

    /**
     * Get tuberculinasPositivas
     *
     * @return int
     */
    public function getTuberculinasPositivas()
    {
        return $this->tuberculinasPositivas;
    }

    /**
     * Set tuberculinasPositivasMenoresCinco
     *
     * @param integer $tuberculinasPositivasMenoresCinco
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTuberculinasPositivasMenoresCinco($tuberculinasPositivasMenoresCinco)
    {
        $this->tuberculinasPositivasMenoresCinco = $tuberculinasPositivasMenoresCinco;

        return $this;
    }

    /**
     * Get tuberculinasPositivasMenoresCinco
     *
     * @return int
     */
    public function getTuberculinasPositivasMenoresCinco()
    {
        return $this->tuberculinasPositivasMenoresCinco;
    }

    /**
     * Set terapiaPreventivaIsoniazidaIniciadas
     *
     * @param integer $terapiaPreventivaIsoniazidaIniciadas
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTerapiaPreventivaIsoniazidaIniciadas($terapiaPreventivaIsoniazidaIniciadas)
    {
        $this->terapiaPreventivaIsoniazidaIniciadas = $terapiaPreventivaIsoniazidaIniciadas;

        return $this;
    }

    /**
     * Get terapiaPreventivaIsoniazidaIniciadas
     *
     * @return int
     */
    public function getTerapiaPreventivaIsoniazidaIniciadas()
    {
        return $this->terapiaPreventivaIsoniazidaIniciadas;
    }

    /**
     * Set terapiaPreventivaIsoniazidaIniciadasMenoresCinco
     *
     * @param integer $terapiaPreventivaIsoniazidaIniciadasMenoresCinco
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTerapiaPreventivaIsoniazidaIniciadasMenoresCinco($terapiaPreventivaIsoniazidaIniciadasMenoresCinco)
    {
        $this->terapiaPreventivaIsoniazidaIniciadasMenoresCinco = $terapiaPreventivaIsoniazidaIniciadasMenoresCinco;

        return $this;
    }

    /**
     * Get terapiaPreventivaIsoniazidaIniciadasMenoresCinco
     *
     * @return int
     */
    public function getTerapiaPreventivaIsoniazidaIniciadasMenoresCinco()
    {
        return $this->terapiaPreventivaIsoniazidaIniciadasMenoresCinco;
    }

    /**
     * Set terapiaPreventivaIsoniazidaTerminadas
     *
     * @param integer $terapiaPreventivaIsoniazidaTerminadas
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTerapiaPreventivaIsoniazidaTerminadas($terapiaPreventivaIsoniazidaTerminadas)
    {
        $this->terapiaPreventivaIsoniazidaTerminadas = $terapiaPreventivaIsoniazidaTerminadas;

        return $this;
    }

    /**
     * Get terapiaPreventivaIsoniazidaTerminadas
     *
     * @return int
     */
    public function getTerapiaPreventivaIsoniazidaTerminadas()
    {
        return $this->terapiaPreventivaIsoniazidaTerminadas;
    }

    /**
     * Set terapiaPreventivaIsoniazidaTerminadasMenoresCinco
     *
     * @param integer $terapiaPreventivaIsoniazidaTerminadasMenoresCinco
     *
     * @return EstudioGrupoVulnerable
     */
    public function setTerapiaPreventivaIsoniazidaTerminadasMenoresCinco($terapiaPreventivaIsoniazidaTerminadasMenoresCinco)
    {
        $this->terapiaPreventivaIsoniazidaTerminadasMenoresCinco = $terapiaPreventivaIsoniazidaTerminadasMenoresCinco;

        return $this;
    }

    /**
     * Get terapiaPreventivaIsoniazidaTerminadasMenoresCinco
     *
     * @return int
     */
    public function getTerapiaPreventivaIsoniazidaTerminadasMenoresCinco()
    {
        return $this->terapiaPreventivaIsoniazidaTerminadasMenoresCinco;
    }

    /**
     * Set cotrimoxazolPacientesCoinfectados
     *
     * @param integer $cotrimoxazolPacientesCoinfectados
     *
     * @return EstudioGrupoVulnerable
     */
    public function setCotrimoxazolPacientesCoinfectados($cotrimoxazolPacientesCoinfectados)
    {
        $this->cotrimoxazolPacientesCoinfectados = $cotrimoxazolPacientesCoinfectados;

        return $this;
    }

    /**
     * Get cotrimoxazolPacientesCoinfectados
     *
     * @return int
     */
    public function getCotrimoxazolPacientesCoinfectados()
    {
        return $this->cotrimoxazolPacientesCoinfectados;
    }

    /**
     * Set grupoVulnerable
     *
     * @param \AppBundle\Entity\GrupoVulnerable $grupoVulnerable
     *
     * @return EstudioGrupoVulnerable
     */
    public function setGrupoVulnerable(\AppBundle\Entity\GrupoVulnerable $grupoVulnerable = null)
    {
        $this->grupoVulnerable = $grupoVulnerable;

        return $this;
    }

    /**
     * Get grupoVulnerable
     *
     * @return \AppBundle\Entity\GrupoVulnerable
     */
    public function getGrupoVulnerable()
    {
        return $this->grupoVulnerable;
    }

    /**
     * Set areaSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areaSalud
     *
     * @return EstudioGrupoVulnerable
     */
    public function setAreaSalud(\AppBundle\Entity\AreaSalud $areaSalud = null)
    {
        $this->areaSalud = $areaSalud;

        return $this;
    }

    /**
     * Get areaSalud
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getAreaSalud()
    {
        return $this->areaSalud;
    }
}
