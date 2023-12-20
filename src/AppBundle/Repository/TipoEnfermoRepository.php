<?php

namespace AppBundle\Repository;
use AppBundle\Entity\TipoEnfermo;

/**
 * TipoEnfermoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoEnfermoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarTipoEnfermo($data)
    {
        try{
            $em = $this->getEntityManager();
            $tipoEnfermo = new TipoEnfermo();
            $tipoEnfermo->setTipo($data['tipo']);

            $em->persist($tipoEnfermo);
            $em->flush();
            $msg = $tipoEnfermo;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El Tipo de Enfermo ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el Tipo de Enfermo';
            }
        }

        return $msg;
    }

    public function modificarTipoEnfermo($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $tipoEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->find($data['idTipoEnfermo']);
            $tipoEnfermo->setTipo($data['tipo']);

            $em->persist($tipoEnfermo);
            $em->flush();
            $msg = $tipoEnfermo;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el Tipo de Enfermo';
        }

        return $msg;
    }

    public function eliminarTipoEnfermo($id)
    {
        try {
            $em = $this->getEntityManager();
            $tipoEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->find($id);

            $em->remove($tipoEnfermo);
            $em->flush();
            $msg = $tipoEnfermo;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes asociados de este tipo , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el Tipo de Enfermo';
            }
        }
        return $msg;
    }
}