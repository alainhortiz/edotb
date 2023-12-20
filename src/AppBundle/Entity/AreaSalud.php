<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * AreaSalud
 *
 * @ORM\Table(name="area_salud",uniqueConstraints={@UniqueConstraint(name="IDX__UNIQUETUPLA01", columns={"codigo", "tipo_area_salud_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AreaSaludRepository")
 */
class AreaSalud
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
     * @ORM\Column(name="codigo", type="string", length=20)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="isArea", type="boolean")
     */
    private $isArea;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="areasSalud")
     */
    private $municipio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="TipoAreaSalud", inversedBy="areasSalud")
     */
    private $tipoAreaSalud;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="areaSalud")
     */
    private $Usuario;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="areaSalud")
     */
    private $PacienteEvolucion;

    /**
     * @ORM\OneToMany(targetEntity="PacienteTransferido", mappedBy="origen")
     */
    private $PacienteTransferido;

    /**
     * @ORM\OneToMany(targetEntity="PacienteSintomatico", mappedBy="areaSalud")
     */
    private $PacienteSintomatico;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->Usuario = new ArrayCollection();
        $this->PacienteEvolucion = new ArrayCollection();
        $this->PacienteTransferido = new ArrayCollection();
        $this->PacienteSintomatico = new ArrayCollection();
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
     * @return AreaSalud
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
     * @return AreaSalud
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
     * Set municipio
     *
     * @param \AppBundle\Entity\Municipio $municipio
     *
     * @return AreaSalud
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
     * Set current
     *
     * @param boolean $isArea
     *
     * @return AreaSalud
     */
    public function setIsArea($isArea)
    {
        $this->isArea = $isArea;

        return $this;
    }

    /**
     * Get isArea
     *
     * @return boolean
     */
    public function getIsArea()
    {
        return $this->isArea;
    }

    /**
     * Set tipoAreaSalud
     *
     * @param \AppBundle\Entity\TipoAreaSalud $tipoAreaSalud
     *
     * @return AreaSalud
     */
    public function setTipoAreaSalud(\AppBundle\Entity\TipoAreaSalud $tipoAreaSalud = null)
    {
        $this->tipoAreaSalud = $tipoAreaSalud;

        return $this;
    }

    /**
     * Get tipoAreaSalud
     *
     * @return \AppBundle\Entity\TipoAreaSalud
     */
    public function getTipoAreaSalud()
    {
        return $this->tipoAreaSalud;
    }

    /**
     * Add usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return AreaSalud
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
     * Add pacienteEvolucion
     *
     * @param \AppBundle\Entity\PacienteEvolucion $pacienteEvolucion
     *
     * @return AreaSalud
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

    /**
     * Add pacienteTransferido
     *
     * @param \AppBundle\Entity\PacienteTransferido $pacienteTransferido
     *
     * @return AreaSalud
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
     * @return AreaSalud
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
}
