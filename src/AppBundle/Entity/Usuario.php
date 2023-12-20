<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements AdvancedUserInterface , \Serializable
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
     * @ORM\Column(name="username", type="string", length=50 , unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=50)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=50, nullable=true)
     */
    private $segundoApellido;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="usuario_role",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $usuario_roles;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AreaSalud", inversedBy="Usuario")
     */
    private $areaSalud;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="Usuario")
     */
    private $hospital;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="NivelAcceso", inversedBy="Usuario")
     */
    private $nivelAcceso;


    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->usuario_roles = new ArrayCollection();
        $this->isActive = true;
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
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add usuarioRole
     *
     * @param \AppBundle\Entity\Role $usuarioRole
     *
     * @return Usuario
     */
    public function addUsuarioRole(\AppBundle\Entity\Role $usuarioRole)
    {
        $this->usuario_roles[] = $usuarioRole;

        return $this;
    }

    /**
     * Remove usuarioRole
     *
     * @param \AppBundle\Entity\Role $usuarioRole
     */
    public function removeUsuarioRole(\AppBundle\Entity\Role $usuarioRole)
    {
        $this->usuario_roles->removeElement($usuarioRole);
    }

    /**
     * Get usuarioRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioRoles()
    {
        return $this->usuario_roles;
    }

    public function setUsuarioRoles($roles)
    {
        $this->usuario_roles = $roles;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function getRoles()
    {
        //IMPORTANTE: el mecanismo de seguridad de Sf2 requiere ésto como un array

        $roles = array();
        foreach ($this->usuario_roles as $role) {
            $roles[] = $role->getRole();
        }
        return $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * Set areaSalud
     *
     * @param \AppBundle\Entity\AreaSalud $areaSalud
     *
     * @return Usuario
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

    /**
     * Set nivelAcceso
     *
     * @param \AppBundle\Entity\NivelAcceso $nivelAcceso
     *
     * @return Usuario
     */
    public function setNivelAcceso(\AppBundle\Entity\NivelAcceso $nivelAcceso = null)
    {
        $this->nivelAcceso = $nivelAcceso;

        return $this;
    }

    /**
     * Get nivelAcceso
     *
     * @return \AppBundle\Entity\NivelAcceso
     */
    public function getNivelAcceso()
    {
        return $this->nivelAcceso;
    }

    /**
     * Set hospital
     *
     * @param \AppBundle\Entity\Hospital $hospital
     *
     * @return Usuario
     */
    public function setHospital(\AppBundle\Entity\Hospital $hospital = null)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Get hospital
     *
     * @return \AppBundle\Entity\Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }
}
