<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoVulnerable
 *
 * @ORM\Table(name="grupo_vulnerable")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GrupoVulnerableRepository")
 */
class GrupoVulnerable
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
     * @ORM\Column(name="numero", type="string", length=5, unique=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;

    /**
     * @ORM\OneToMany(targetEntity="PacienteSintomatico", mappedBy="grupoVulnerable")
     */
    private $PacienteSintomatico;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="grupoVulnerable")
     */
    private $PacienteEvolucion;


    /**
     * Contacto constructor.
     */
    public function __construct()
    {
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
     * Set numero
     *
     * @param string $numero
     *
     * @return GrupoVulnerable
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     *
     * @return GrupoVulnerable
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Add pacienteSintomatico
     *
     * @param \AppBundle\Entity\PacienteSintomatico $pacienteSintomatico
     *
     * @return GrupoVulnerable
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
     * @return GrupoVulnerable
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
