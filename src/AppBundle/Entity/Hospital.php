<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hospital
 *
 * @ORM\Table(name="hospital")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HospitalRepository")
 */
class Hospital
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
     * @ORM\Column(name="codigo", type="string", length=5, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoCompleto", type="string", length=20, unique=true)
     */
    private $codigoCompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=200)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="hospitales")
     */
    private $municipio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="TipoHospital", inversedBy="hospitales")
     */
    private $tipoHospistal;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="hospital")
     */
    private $Usuario;

    /**
     * @ORM\OneToMany(targetEntity="PacienteTransferido", mappedBy="origenHospital")
     */
    private $PacienteTransferido;

    /**
     * @ORM\OneToMany(targetEntity="PacienteSintomatico", mappedBy="hospital")
     */
    private $PacienteSintomatico;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="hospital")
     */
    private $PacienteEvolucion;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->Usuario = new ArrayCollection();
        $this->PacienteTransferido = new ArrayCollection();
        $this->PacienteSintomatico = new ArrayCollection();
        $this->PacienteEvolucion = new ArrayCollection();
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Hospital
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hospital
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
     * Set codigoCompleto
     *
     * @param string $codigoCompleto
     *
     * @return Hospital
     */
    public function setCodigoCompleto($codigoCompleto)
    {
        $this->codigoCompleto = $codigoCompleto;

        return $this;
    }

    /**
     * Get codigoCompleto
     *
     * @return string
     */
    public function getCodigoCompleto()
    {
        return $this->codigoCompleto;
    }

    /**
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return Hospital
     */
    public function setMunicipio(\AppBundle\Entity\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set tipoHospistal
     *
     * @param \AppBundle\Entity\TipoHospital $tipoHospistal
     *
     * @return Hospital
     */
    public function setTipoHospistal(\AppBundle\Entity\TipoHospital $tipoHospistal = null)
    {
        $this->tipoHospistal = $tipoHospistal;

        return $this;
    }

    /**
     * Get tipoHospistal
     *
     * @return \AppBundle\Entity\TipoHospital
     */
    public function getTipoHospistal()
    {
        return $this->tipoHospistal;
    }

    /**
     * Add usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Hospital
     */
    public function addUsuario(\AppBundle\Entity\Usuario $usuario)
    {
        $this->Usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\AppBundle\Entity\Usuario $usuario)
    {
        $this->Usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

    /**
     * Add pacienteTransferido
     *
     * @param \AppBundle\Entity\PacienteTransferido $pacienteTransferido
     *
     * @return Hospital
     */
    public function addPacienteTransferido(\AppBundle\Entity\PacienteTransferido $pacienteTransferido)
    {
        $this->PacienteTransferido[] = $pacienteTransferido;

        return $this;
    }

    /**
     * Remove pacienteTransferido
     *
     * @param \AppBundle\Entity\PacienteTransferido $pacienteTransferido
     */
    public function removePacienteTransferido(\AppBundle\Entity\PacienteTransferido $pacienteTransferido)
    {
        $this->PacienteTransferido->removeElement($pacienteTransferido);
    }

    /**
     * Get pacienteTransferido
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacienteTransferido()
    {
        return $this->PacienteTransferido;
    }

    /**
     * Add pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return Hospital
     */
    public function addPacienteSintomatico(\AppBundle\Entity\PacienteSintomatico $pacienteSintomatico)
    {
        $this->PacienteSintomatico[] = $pacienteSintomatico;

        return $this;
    }

    /**
     * Remove pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     */
    public function removePacienteSintomatico(\AppBundle\Entity\PacienteSintomatico $pacienteSintomatico)
    {
        $this->PacienteSintomatico->removeElement($pacienteSintomatico);
    }

    /**
     * Get pacienteSintomatico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacienteSintomatico()
    {
        return $this->PacienteSintomatico;
    }

    /**
     * Add pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return Hospital
     */
    public function addPacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion)
    {
        $this->PacienteEvolucion[] = $pacienteEvolucion;

        return $this;
    }

    /**
     * Remove pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     */
    public function removePacienteEvolucion(\AppBundle\Entity\PacienteEvolucion $pacienteEvolucion)
    {
        $this->PacienteEvolucion->removeElement($pacienteEvolucion);
    }

    /**
     * Get pacienteEvolucion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacienteEvolucion()
    {
        return $this->PacienteEvolucion;
    }
}
