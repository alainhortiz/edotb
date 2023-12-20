<?php

namespace AppBundle\Repository;
use AppBundle\Entity\MuestraNoUtil;


/**
 * MuestraNoUtilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MuestraNoUtilRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarMuestraNoUtil($data)
    {
        try{
            $em = $this->getEntityManager();

            $muestra = new MuestraNoUtil();
            $muestra->setFecha(new \DateTime($data['fecha']));
            $muestra->setCantidad($data['cantidad']);

            $pacienteSintomatico = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $data['ci']));
            $muestra->setPacienteSintomatico($pacienteSintomatico);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $muestra->setAreaSalud($areaSalud);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $muestra->setHospital($hospital);
            }

            $em->persist($muestra);
            $em->flush();
            $msg = $muestra;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar la muestra';
        }

        return $msg;
    }

    public function modificarMuestraNoUtil($data)
    {
        try{
            $em = $this->getEntityManager();

            $muestra = $em->getRepository('AppBundle:MuestraNoUtil')->find($data['idMuestraNoUtil']);
            $muestra->setFecha(new \DateTime($data['fecha']));
            $muestra->setCantidad($data['cantidad']);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $muestra->setAreaSalud($areaSalud);
                $muestra->setHospital(null);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $muestra->setHospital($hospital);
                $muestra->setAreaSalud(null);
            }

            $em->persist($muestra);
            $em->flush();
            $msg = $muestra;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar la muestra';
        }

        return $msg;
    }

    public function eliminarMuestraNoUtil($id)
    {
        try {
            $em = $this->getEntityManager();
            $muestra = $em->getRepository('AppBundle:MuestraNoUtil')->find($id);

            $em->remove($muestra);
            $em->flush();
            $msg = $muestra;

        } catch (\Exception $e) {

            $msg = 'Se produjo un error al eliminar la muestra';
        }
        return $msg;
    }
}