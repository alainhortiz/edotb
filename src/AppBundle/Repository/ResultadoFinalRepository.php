<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ResultadoFinal;

/**
 * ResultadoFinalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultadoFinalRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarResultadoFinal($data)
    {
        try{
            $em = $this->getEntityManager();
            $resultadoFinal = new ResultadoFinal();
            $resultadoFinal->setFecha(new \DateTime($data['fecha']));
            $resultadoFinal->setUltimo(1);

            $resultadoTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->findOneBy(array('resultado' => $data['resultadoTratamiento']));
            $resultadoFinal->setResultadoTratamiento($resultadoTratamiento);

            $em->persist($resultadoFinal);
            $em->flush();
            $msg = $resultadoFinal;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar el resultado ';
        }
        return $msg;
    }

    public function modificarResultadoFinal($data)
    {
        try{
            $em = $this->getEntityManager();
            $resultadoFinal = $em->getRepository('AppBundle:ResultadoFinal')->find($data['idResultadoFinal']);

            $resultadoTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->findOneBy(array('resultado' => $data['resultadoTratamiento']));
            $resultadoFinal->setResultadoTratamiento($resultadoTratamiento);

            $em->persist($resultadoFinal);
            $em->flush();
            $msg = $resultadoFinal;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el resultado  final del tratamiento';
        }
        return $msg;
    }
}