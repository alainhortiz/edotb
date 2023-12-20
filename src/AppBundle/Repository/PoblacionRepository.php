<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Poblacion;

/**
 * PoblacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PoblacionRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarPoblacion($data)
    {
        try{
            $em = $this->getEntityManager();
            $poblacion = new Poblacion();
            $poblacion->setYear($data['anno']);
            $poblacion->setEdad($data['edad']);
            $poblacion->setSexo($data['sexo']);
            $poblacion->setTotal($data['total']);

            $municipio = $em->getRepository('AppBundle:Municipio')->find($data['municipio']);
            $poblacion->setMunicipio($municipio);

            $em->persist($poblacion);
            $em->flush();
            $msg = $poblacion;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El total de esta población ya existe, no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el total de esta población';
            }
        }
        return $msg;
    }

    public function modificarPoblacion($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $poblacion = $em->getRepository('AppBundle:Poblacion')->find($data['idPoblacion']);

            if (!empty($poblacion)) {
                $poblacion->setYear($data['anno']);
                $poblacion->setEdad($data['edad']);
                $poblacion->setSexo($data['sexo']);
                $poblacion->setTotal($data['total']);

                $municipio = $em->getRepository('AppBundle:Municipio')->find($data['municipio']);
                $poblacion->setMunicipio($municipio);

                $em->flush();
                $msg = $poblacion;
            }else {
                $msg = $poblacion;
            }

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la población';
        }
        return $msg;

    }

    public function eliminarPoblacion($id)
    {
        try {
            $em = $this->getEntityManager();
            $poblacion = $em->getRepository('AppBundle:Poblacion')->find($id);

            $em->remove($poblacion);
            $em->flush();
            $msg = $poblacion;

        } catch (\Exception $e) {
            $msg = 'Se produjo un error al eliminar el total de población';
        }
        return $msg;
    }

}
