<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Cultivo;

/**
 * CultivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CultivoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarCultivo($data)
    {
        try{
            $em = $this->getEntityManager();
            $cultivo = new Cultivo();
            $cultivo->setClasificacion($data['clasificacion']);
            $cultivo->setDescripcion($data['descripcion']);

            $em->persist($cultivo);
            $em->flush();
            $msg = $cultivo;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El Cultivo ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el Cultivo';
            }
        }

        return $msg;
    }

    public function modificarCultivo($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $cultivo = $em->getRepository('AppBundle:Cultivo')->find($data['idCultivo']);
            $cultivo->setDescripcion($data['descripcion']);

            $em->persist($cultivo);
            $em->flush();
            $msg = $cultivo;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el Cultivo';
        }

        return $msg;
    }

    public function eliminarCultivo($id)
    {
        try {
            $em = $this->getEntityManager();
            $cultivo = $em->getRepository('AppBundle:Cultivo')->find($id);

            $em->remove($cultivo);
            $em->flush();
            $msg = $cultivo;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes con resultados asociados a este Cultivo , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el Cultivo';
            }
        }
        return $msg;
    }
}
