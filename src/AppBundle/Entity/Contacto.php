<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contacto
 *
 * @ORM\Table(name="contacto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contacto
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
     * @ORM\Column(name="carnetIdentidad", type="string", length=11)
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
     * @var string
     *
     * @ORM\Column(name="colorPiel", type="string", length=100)
     */
    private $colorPiel;

    /**
     * @var string
     *
     * @ORM\Column(name="fonNombre", type="string", length=100)
     */
    private $fonNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="fonPrimerApellido", type="string", length=100)
     */
    private $fonPrimerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="fonSegundoApellido", type="string", length=100)
     */
    private $fonSegundoApellido;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Paciente", inversedBy="contactos")
     */
    private $paciente;

    /**
     * @ORM\OneToMany(targetEntity="ContactoSeguimiento", mappedBy="contacto" , cascade={"remove"})
     */
    private $seguimientos;

    /**
     * Contacto constructor.
     */
    public function __construct()
    {
        $this->seguimientos = new ArrayCollection();
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
     * @return Contacto
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
     * @return Contacto
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
     * @return Contacto
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
     * @return Contacto
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonNombreValue()
    {
        $this->fonNombre = metaphone($this->nombre,5);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonPrimerApellidoValue()
    {
        $this->fonPrimerApellido = metaphone($this->primerApellido,5);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setFonSegundoApellidoValue()
    {
        $this->fonSegundoApellido = metaphone($this->segundoApellido,5);
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Contacto
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
     * Set fonNombre
     *
     * @param string $fonNombre
     *
     * @return Contacto
     */
    public function setFonNombre($fonNombre)
    {
        $this->fonNombre = $fonNombre;

        return $this;
    }

    /**
     * Get fonNombre
     *
     * @return string
     */
    public function getFonNombre()
    {
        return $this->fonNombre;
    }

    /**
     * Set fonPrimerApellido
     *
     * @param string $fonPrimerApellido
     *
     * @return Contacto
     */
    public function setFonPrimerApellido($fonPrimerApellido)
    {
        $this->fonPrimerApellido = $fonPrimerApellido;

        return $this;
    }

    /**
     * Get fonPrimerApellido
     *
     * @return string
     */
    public function getFonPrimerApellido()
    {
        return $this->fonPrimerApellido;
    }

    /**
     * Set fonSegundoApellido
     *
     * @param string $fonSegundoApellido
     *
     * @return Contacto
     */
    public function setFonSegundoApellido($fonSegundoApellido)
    {
        $this->fonSegundoApellido = $fonSegundoApellido;

        return $this;
    }

    /**
     * Get fonSegundoApellido
     *
     * @return string
     */
    public function getFonSegundoApellido()
    {
        return $this->fonSegundoApellido;
    }

     /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return Contacto
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
     * Add seguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $seguimiento
     *
     * @return Contacto
     */
    public function addSeguimiento(\AppBundle\Entity\ContactoSeguimiento $seguimiento)
    {
        $this->seguimientos[] = $seguimiento;

        return $this;
    }

    /**
     * Remove seguimiento
     *
     * @param \AppBundle\Entity\ContactoSeguimiento $seguimiento
     */
    public function removeSeguimiento(\AppBundle\Entity\ContactoSeguimiento $seguimiento)
    {
        $this->seguimientos->removeElement($seguimiento);
    }

    /**
     * Get seguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimientos()
    {
        return $this->seguimientos;
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

    public function cantidadSeguimientos()
    {
        return count($this->seguimientos);
    }


    /**
     * Set colorPiel
     *
     * @param string $colorPiel
     *
     * @return Contacto
     */
    public function setColorPiel($colorPiel)
    {
        $this->colorPiel = $colorPiel;

        return $this;
    }

    /**
     * Get colorPiel
     *
     * @return string
     */
    public function getColorPiel()
    {
        return $this->colorPiel;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Contacto
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
