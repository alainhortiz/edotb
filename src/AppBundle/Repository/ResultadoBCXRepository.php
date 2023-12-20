<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ResultadoBCX;

/**
 * ResultadoBCXRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultadoBCXRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarResultadoBCX($data)
    {
        try{
            $em = $this->getEntityManager();
            $resultadoBCX = new ResultadoBCX();
            $resultadoBCX->setFecha(new \DateTime($data['fecha']));

            $xpert = $em->getRepository('AppBundle:Xpert')->findOneBy(array('clasificacion' => $data['xpert']));
            $resultadoBCX->setXpert($xpert);

            $baciloscopia = $em->getRepository('AppBundle:Baciloscopia')->findOneBy(array('clasificacion' => $data['baciloscopia']));
            $resultadoBCX->setBaciloscopia($baciloscopia);

            $baciloscopia2 = $em->getRepository('AppBundle:Baciloscopia')->findOneBy(array('clasificacion' => $data['baciloscopia2']));
            $resultadoBCX->setBaciloscopia2($baciloscopia2);

            $cultivo = $em->getRepository('AppBundle:Cultivo')->findOneBy(array('clasificacion' => $data['cultivo']));
            $resultadoBCX->setCultivo($cultivo);

            $salidaCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findOneBy(array('salida' => $data['salidaCultivo']));
            $resultadoBCX->setSalidaCultivo($salidaCultivo);

            $biopsia = $em->getRepository('AppBundle:Biopsia')->findOneBy(array('clasificacion' => $data['biopsia']));
            $resultadoBCX->setBiopsia($biopsia);

            $orina = $em->getRepository('AppBundle:Orina')->findOneBy(array('clasificacion' => $data['orina']));
            $resultadoBCX->setOrina($orina);

            $em->persist($resultadoBCX);
            $em->flush();
            $msg = $resultadoBCX;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar el resultado  de los análisis iniciales del tratamiento';
        }
        return $msg;
    }

    public function modificarResultadoBCX($data)
    {
        try{
            $em = $this->getEntityManager();
            $resultadoBCX = $em->getRepository('AppBundle:ResultadoBCX')->find($data['idResultadoBCX']);

            $xpert = $em->getRepository('AppBundle:Xpert')->findOneBy(array('clasificacion' => $data['xpert']));
            $resultadoBCX->setXpert($xpert);

            $baciloscopia = $em->getRepository('AppBundle:Baciloscopia')->findOneBy(array('clasificacion' => $data['baciloscopia']));
            $resultadoBCX->setBaciloscopia($baciloscopia);

            $baciloscopia2 = $em->getRepository('AppBundle:Baciloscopia')->findOneBy(array('clasificacion' => $data['baciloscopia2']));
            $resultadoBCX->setBaciloscopia2($baciloscopia2);

            $cultivo = $em->getRepository('AppBundle:Cultivo')->findOneBy(array('clasificacion' => $data['cultivo']));
            $resultadoBCX->setCultivo($cultivo);

            $salidaCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findOneBy(array('salida' => $data['salidaCultivo']));
            $resultadoBCX->setSalidaCultivo($salidaCultivo);

            $biopsia = $em->getRepository('AppBundle:Biopsia')->findOneBy(array('clasificacion' => $data['biopsia']));
            $resultadoBCX->setBiopsia($biopsia);

            $orina = $em->getRepository('AppBundle:Orina')->findOneBy(array('clasificacion' => $data['orina']));
            $resultadoBCX->setOrina($orina);

            $em->persist($resultadoBCX);
            $em->flush();
            $msg = $resultadoBCX;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el resultado  de los análisis iniciales del tratamiento';
        }
        return $msg;

    }
}
