<?php

namespace AppBundle\Repository;

use AppBundle\Entity\NivelEducacional;

/**
 * NivelEducacionalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NivelEducacionalRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarNivelEducacional($data)
    {
        try{
            $em = $this->getEntityManager();
            $nivelEducacional = new NivelEducacional();
            $nivelEducacional->setNombre($data['nombre']);

            $em->persist($nivelEducacional);
            $em->flush();
            $msg = $nivelEducacional;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El nivel educacional ya existe, no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el nivel educacional';
            }
        }

        return $msg;
    }

    public function modificarNivelEducacional($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $nivelEducacional = $em->getRepository('AppBundle:NivelEducacional')->find($data['idNivelEducacional']);
            $nivelEducacional->setNombre($data['nombre']);

            $em->persist($nivelEducacional);
            $em->flush();
            $msg = $nivelEducacional;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el nivel educacional';
        }

        return $msg;
    }

    public function eliminarNivelEducacional($id)
    {
        try {
            $em = $this->getEntityManager();
            $nivelEducacional = $em->getRepository('AppBundle:NivelEducacional')->find($id);

            $em->remove($nivelEducacional);
            $em->flush();
            $msg = $nivelEducacional;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen contactos con este nivel educacional, no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el nivel educacional';
            }
        }
        return $msg;
    }

}
