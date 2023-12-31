<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ResultXpert;


/**
 * ResultXpertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultXpertRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarResultXpert($data)
    {
        try{
            $em = $this->getEntityManager();

            $dql = 'SELECT rx FROM AppBundle:ResultXpert rx JOIN rx.pacienteSintomatico p 
                    WHERE p.carnetIdentidad = :carnet ORDER BY rx.id DESC';
            $query = $em->createQuery($dql);
            $query->setParameter('carnet' , $data['ci']);
            $lastResult = $query->setMaxResults(1)->getResult();
            $fecha = new \DateTime($data['fecha']);

            if(count($lastResult) != 0 && $fecha < $lastResult[0]->getFecha()) return 'Error: Existe un resultado más reciente , no se puede agregar';

            $resultXpert = new ResultXpert();
            $resultXpert->setFecha($fecha);

            $pacienteSintomatico = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $data['ci']));
            $resultXpert->setPacienteSintomatico($pacienteSintomatico);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $resultXpert->setAreaSalud($areaSalud);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $resultXpert->setHospital($hospital);
            }

            $xpert = $em->getRepository('AppBundle:Xpert')->findOneBy(array('clasificacion' => $data['xpert']));
            $resultXpert->setXpert($xpert);

            if($pacienteSintomatico->getProceso() != 'registrado' && $pacienteSintomatico->getProceso() != 'pendiente' && $xpert->getClasificacion() != 'I' && $xpert->getClasificacion() != 'N'){

                $pacienteSintomatico->setProceso('pendiente');
                $em->persist($pacienteSintomatico);
            }

            $em->persist($resultXpert);
            $em->flush();
            $msg = $resultXpert;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar el resultado del xpert';
        }

        return $msg;
    }

    public function modificarResultXpert($data)
    {
        try{
            $em = $this->getEntityManager();

            $resultXpert = $em->getRepository('AppBundle:ResultXpert')->find($data['idResultXpert']);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $resultXpert->setAreaSalud($areaSalud);
                $resultXpert->setHospital(null);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $resultXpert->setHospital($hospital);
                $resultXpert->setAreaSalud(null);
            }

            $xpert = $em->getRepository('AppBundle:Xpert')->findOneBy(array('clasificacion' => $data['xpert']));
            $resultXpert->setXpert($xpert);

            $em->persist($resultXpert);
            $em->flush();

            $pacienteSintomatico = $resultXpert->getPacienteSintomatico();

            if($pacienteSintomatico->getProceso() != 'registrado'){

                $resultsXperts = $em->getRepository('AppBundle:PacienteSintomatico')->listarXpertsPacienteSintomatico($pacienteSintomatico->getCarnetIdentidad());
                $estado  = 'analisis';
                foreach ( $resultsXperts as $result)
                {
                    if($result->getXpert()->getClasificacion() != 'I' && $result->getXpert()->getClasificacion() != 'N')
                    {
                        $estado = 'pendiente';
                    }
                }
                $pacienteSintomatico->setProceso($estado);
                $em->persist($pacienteSintomatico);
                $em->flush();
            }
            $msg = $resultXpert;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el resultado del xpert';
        }

        return $msg;
    }

    public function eliminarResultXpert($id)
    {
        try {
            $em = $this->getEntityManager();
            $resultXpert = $em->getRepository('AppBundle:ResultXpert')->find($id);

            $em->remove($resultXpert);
            $em->flush();
            $msg = $resultXpert;

            $pacienteSintomatico = $resultXpert->getPacienteSintomatico();

            if($pacienteSintomatico->getProceso() != 'registrado'){

                $resultsXperts = $em->getRepository('AppBundle:PacienteSintomatico')->listarXpertsPacienteSintomatico($pacienteSintomatico->getCarnetIdentidad());
                $estado  = 'analisis';
                foreach ( $resultsXperts as $result)
                {
                    if($result->getXpert()->getClasificacion() != 'I' && $result->getXpert()->getClasificacion() != 'N')
                    {
                        $estado = 'pendiente';
                    }
                }
                $pacienteSintomatico->setProceso($estado);
                $em->persist($pacienteSintomatico);
                $em->flush();
            }

        } catch (\Exception $e) {

            $msg = 'Se produjo un error al eliminar el resultado del xpert';
        }
        return $msg;
    }

    public function lastXpertPositivo($idPaciente)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT rx FROM AppBundle:ResultXpert rx JOIN rx.pacienteSintomatico p JOIN rx.xpert x
                WHERE p.id = :id AND x.clasificacion != 'N' ORDER BY rx.id DESC";
        $query = $em->createQuery($dql);
        $query->setParameter('id' , $idPaciente);
        $resultXpert = $query->setMaxResults(1)->getResult();
        return count($resultXpert) == 0 ? null : $resultXpert[0];

    }
}
