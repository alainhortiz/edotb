<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalidaCultivo
 *
 * @ORM\Table(name="salida_cultivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalidaCultivoRepository")
 */
class SalidaCultivo
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
     * @ORM\Column(name="salida", type="string", length=100, unique=true)
     */
    private $salida;


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
     * Set salida
     *
     * @param string $salida
     *
     * @return SalidaCultivo
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return string
     */
    public function getSalida()
    {
        return $this->salida;
    }
}
