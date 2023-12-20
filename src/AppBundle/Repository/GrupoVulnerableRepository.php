<?php

namespace AppBundle\Repository;
use AppBundle\Entity\GrupoVulnerable;

/**
 * GrupoVulnerableRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GrupoVulnerableRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarGrupoVulnerable($data)
    {
        try{
            $em = $this->getEntityManager();
            $grupoVulnerable = new GrupoVulnerable();
            $grupoVulnerable->setNumero($data['numero']);
            $grupoVulnerable->setGrupo($data['grupo']);

            $em->persist($grupoVulnerable);
            $em->flush();
            $msg = $grupoVulnerable;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'El Grupo Vulnerable ya existe , no se puede agregar';
            }
            else
            {
                $msg = 'Se produjo un error al insertar el  Grupo Vulnerable';
            }
        }

        return $msg;
    }

    public function modificarGrupoVulnerable($data)
    {
        try
        {
            $em = $this->getEntityManager();
            $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($data['idGrupoVulnerable']);
            $grupoVulnerable->setGrupo($data['grupo']);

            $em->persist($grupoVulnerable);
            $em->flush();
            $msg = $grupoVulnerable;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el  Grupo Vulnerable';
        }

        return $msg;
    }

    public function eliminarGrupoVulnerable($id)
    {
        try {
            $em = $this->getEntityManager();
            $grupoVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->find($id);

            $em->remove($grupoVulnerable);
            $em->flush();
            $msg = $grupoVulnerable;

        } catch (\Exception $e) {

            if (strpos($e->getMessage(), 'foreign key') > 0) {
                $msg = 'Existen pacientes asociados a este Grupo Vulnerable , no se puede eliminar';
            } else {
                $msg = 'Se produjo un error al eliminar el Grupo Vulnerable';
            }
        }
        return $msg;
    }
}