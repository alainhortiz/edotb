<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Paciente
 *
 * @ORM\Table(name="paciente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteRepository")
 */
class Paciente
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
     * @ORM\Column(name="carnetIdentidad", type="string", length=100, unique=true)
     */
    private $carnetIdentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=100)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=100)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=20)
     */
    private $sexo;

    /**
     * @ORM\OneToMany(targetEntity="PacienteEvolucion", mappedBy="paciente" , cascade={"remove"})
     */
    private $evoluciones;

    /**
     * @ORM\OneToMany(targetEntity="Contacto", mappedBy="paciente" , cascade={"remove"})
     */
    private $contactos;

    /**
     * @ORM\OneToMany(targetEntity="PacienteTransferido", mappedBy="paciente" , cascade={"remove"})
     */
    private $PacienteTransferido;

    /**
     * Paciente constructor.
     */
    public function __construct()
    {
        $this->evoluciones = new ArrayCollection();
        $this->contactos = new ArrayCollection();
        $this->PacienteTransferido = new ArrayCollection();
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
     * Set carnetIdentidad
     *
     * @param string $carnetIdentidad
     *
     * @return Paciente
     */
    public function setCarnetIdentidad($carnetIdentidad)
    {
        $this->carnetIdentidad = $carnetIdentidad;

        return $this;
    }

    /**
     * Get carnetIdentidad
     *
     * @return string
     */
    public function getCarnetIdentidad()
    {
        return $this->carnetIdentidad;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Paciente
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
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return Paciente
     */
    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return Paciente
     */
    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Paciente
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Add evolucione
     *
     * @param \AppBundle\Entity\PacienteEvolucion $evolucione
     *
     * @return Paciente
     */
    public function addEvolucione(\AppBundle\Entity\PacienteEvolucion $evolucione)
    {
        $this->evoluciones[] = $evolucione;

        return $this;
    }

    /**
     * Remove evolucione
     *
     * @param \AppBundle\Entity\PacienteEvolucion $evolucione
     */
    public function removeEvolucione(\AppBundle\Entity\PacienteEvolucion $evolucione)
    {
        $this->evoluciones->removeElement($evolucione);
    }

    /**
     * Get evoluciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvoluciones()
    {
        return $this->evoluciones;
    }

    /**
     * Add contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     *
     * @return Paciente
     */
    public function addContacto(\AppBundle\Entity\Contacto $contacto)
    {
        $this->contactos[] = $contacto;

        return $this;
    }

    /**
     * Remove contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     */
    public function removeContacto(\AppBundle\Entity\Contacto $contacto)
    {
        $this->contactos->removeElement($contacto);
    }

    /**
     * Get contactos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactos()
    {
        return $this->contactos;
    }

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function nombreCompleto()
    {
        return $this->getNombre() . ' ' . $this->getPrimerApellido() . ' ' . $this->getSegundoApellido();
    }

    public function cantidadContactos()
    {
        return count($this->contactos);
    }

    /**
     * Add pacienteTransferido
     *
     * @param \AppBundle\Entity\PacienteTransferido $pacienteTransferido
     *
     * @return Paciente
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
}
