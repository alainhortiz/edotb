<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PacienteTransferido
 *
 * @ORM\Table(name="paciente_transferido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteTransferidoRepository")
 */
class PacienteTransferido
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
     * @var bool
     *
     * @ORM\Column(name="visto", type="boolean")
     */
    private $visto;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel", type="string", length=20)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteTransferido")
     */
    private $origen;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="PacienteTransferido")
     */
    private $destino;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="PacienteTransferido")
     */
    private $origenHospital;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Hospital", inversedBy="PacienteTransferido")
     */
    private $destinoHospital;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Paciente", inversedBy="PacienteTransferido")
     */
    private $paciente;


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
     * @return PacienteTransferido
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
     * Set visto
     *
     * @param boolean $visto
     *
     * @return PacienteTransferido
     */
    public function setVisto($visto)
    {
        $this->visto = $visto;

        return $this;
    }

    /**
     * Get visto
     *
     * @return bool
     */
    public function getVisto()
    {
        return $this->visto;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     *
     * @return PacienteTransferido
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set origen
     *
     * @param \AppBundle\Entity\AreaSalud $origen
     *
     * @return PacienteTransferido
     */
    public function setOrigen(\AppBundle\Entity\AreaSalud $origen = null)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set destino
     *
     * @param \AppBundle\Entity\AreaSalud $destino
     *
     * @return PacienteTransferido
     */
    public function setDestino(\AppBundle\Entity\AreaSalud $destino = null)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return \AppBundle\Entity\AreaSalud
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return PacienteTransferido
     */
    public function setPaciente(\AppBundle\Entity\Paciente $paciente = null)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return \AppBundle\Entity\Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set origenHospital
     *
     * @param \AppBundle\Entity\Hospital $origenHospital
     *
     * @return PacienteTransferido
     */
    public function setOrigenHospital(\AppBundle\Entity\Hospital $origenHospital = null)
    {
        $this->origenHospital = $origenHospital;

        return $this;
    }

    /**
     * Get origenHospital
     *
     * @return \AppBundle\Entity\Hospital
     */
    public function getOrigenHospital()
    {
        return $this->origenHospital;
    }

    /**
     * Set destinoHospital
     *
     * @param \AppBundle\Entity\Hospital $destinoHospital
     *
     * @return PacienteTransferido
     */
    public function setDestinoHospital(\AppBundle\Entity\Hospital $destinoHospital = null)
    {
        $this->destinoHospital = $destinoHospital;

        return $this;
    }

    /**
     * Get destinoHospital
     *
     * @return \AppBundle\Entity\Hospital
     */
    public function getDestinoHospital()
    {
        return $this->destinoHospital;
    }
}
