<?php

namespace AppBundle\Repository;
use AppBundle\Entity\PruebaSensibilidad;

/**
 * PruebaSensibilidadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PruebaSensibilidadRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPruebaSensibilidad($data)
    {
        try{
            $em = $this->getEntityManager();
            $pruebaSensibilidad = new PruebaSensibilidad();
            $pruebaSensibilidad->setNombre($data['nombre']);

            $em->persist($pruebaSensibilidad);
            $em->flush();
            $msg = $pruebaSensibilidad;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La Prueba de Sensibilidad ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar la  Prueba de Sensibilidad';
            }
        }

        return $msg;
    }

    public function modificarPruebaSensibilidad($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $pruebaSensibilidad = $em->getRepository('AppBundle:PruebaSensibilidad')->find($data['idPruebaSensibilidad']);
            $pruebaSensibilidad->setNombre($data['nombre']);

            $em->persist($pruebaSensibilidad);
            $em->flush();
            $msg = $pruebaSensibilidad;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la  Prueba de Sensibilidad';
        }

        return $msg;
    }

    public function eliminarPruebaSensibilidad($id)
    {
        try {
            $em = $this->getEntityManager();
            $pruebaSensibilidad = $em->getRepository('AppBundle:PruebaSensibilidad')->find($id);

            $em->remove($pruebaSensibilidad);
            $em->flush();
            $msg = $pruebaSensibilidad;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes con esta Prueba de Sensibilidad  , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar la Prueba de Sensibilidad';
            }
        }
        return $msg;
    }
}
