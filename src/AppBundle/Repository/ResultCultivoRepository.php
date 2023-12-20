<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ResultCultivo;


/**
 * ResultCultivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultCultivoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarResultCultivo($data)
    {
        try{
            $em = $this->getEntityManager();

            $dql = 'SELECT rc FROM AppBundle:ResultCultivo rc JOIN rc.pacienteSintomatico p 
                    WHERE p.carnetIdentidad = :carnet ORDER BY rc.id DESC';
            $query = $em->createQuery($dql);
            $query->setParameter('carnet' , $data['ci']);
            $lastResult = $query->setMaxResults(1)->getResult();
            $fecha = new \DateTime($data['fecha']);

            if(count($lastResult) != 0 && $fecha < $lastResult[0]->getFecha()) return 'Error: Existe un resultado más reciente , no se puede agregar';

            $resultCultivo = new ResultCultivo();
            $resultCultivo->setFecha($fecha);

            $pacienteSintomatico = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $data['ci']));
            $resultCultivo->setPacienteSintomatico($pacienteSintomatico);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $resultCultivo->setAreaSalud($areaSalud);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $resultCultivo->setHospital($hospital);
            }

            $cultivo = $em->getRepository('AppBundle:Cultivo')->findOneBy(array('clasificacion' => $data['cultivo']));
            $resultCultivo->setCultivo($cultivo);

            if($pacienteSintomatico->getProceso() != 'registrado' && $pacienteSintomatico->getProceso() != 'pendiente' && $cultivo->getClasificacion() != '0') {

                $pacienteSintomatico->setProceso('pendiente');
                $em->persist($pacienteSintomatico);
            }

            $em->persist($resultCultivo);
            $em->flush();
            $msg = $resultCultivo;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al insertar el resultado del cultivo';
        }

        return $msg;
    }

    public function modificarResultCultivo($data)
    {
        try{
            $em = $this->getEntityManager();

            $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->find($data['idResultCultivo']);

            if($data['areaSalud'] != '0')
            {
                $areaSalud = $em->getRepository('AppBundle:AreaSalud')->find($data['areaSalud']);
                $resultCultivo->setAreaSalud($areaSalud);
                $resultCultivo->setHospital(null);
            }else{
                $hospital = $em->getRepository('AppBundle:Hospital')->find($data['hospital']);
                $resultCultivo->setHospital($hospital);
                $resultCultivo->setAreaSalud(null);
            }

            $cultivo = $em->getRepository('AppBundle:Cultivo')->findOneBy(array('clasificacion' => $data['cultivo']));
            $resultCultivo->setCultivo($cultivo);

            $em->persist($resultCultivo);
            $em->flush();

            $pacienteSintomatico = $resultCultivo->getPacienteSintomatico();

            if($pacienteSintomatico->getProceso() != 'registrado'){

                $resultsCultivos = $em->getRepository('AppBundle:PacienteSintomatico')->listarCultivosPacienteSintomatico($pacienteSintomatico->getCarnetIdentidad());
                $estado  = 'analisis';
                foreach ( $resultsCultivos as $result)
                {
                    if($result->getCultivo()->getClasificacion() != '0')
                    {
                        $estado = 'pendiente';
                    }
                }
                $pacienteSintomatico->setProceso($estado);
                $em->persist($pacienteSintomatico);
                $em->flush();
            }
            $msg = $resultCultivo;

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al modificar el resultado del cultivo';
        }

        return $msg;
    }

    public function eliminarResultCultivo($id)
    {
        try {
            $em = $this->getEntityManager();
            $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->find($id);

            $em->remove($resultCultivo);
            $em->flush();
            $msg = $resultCultivo;

            $pacienteSintomatico = $resultCultivo->getPacienteSintomatico();

            if($pacienteSintomatico->getProceso() != 'registrado'){

                $resultsCultivos = $em->getRepository('AppBundle:PacienteSintomatico')->listarCultivosPacienteSintomatico($pacienteSintomatico->getCarnetIdentidad());
                $estado  = 'analisis';
                foreach ( $resultsCultivos as $result)
                {
                    if($result->getCultivo()->getClasificacion() != '0')
                    {
                        $estado = 'pendiente';
                    }
                }
                $pacienteSintomatico->setProceso($estado);
                $em->persist($pacienteSintomatico);
                $em->flush();
            }

        } catch (\Exception $e) {

            $msg = 'Se produjo un error al eliminar el resultado del cultivo';
        }
        return $msg;
    }

    public function lastCultivoPositivo($idPaciente)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT rc FROM AppBundle:ResultCultivo rc JOIN rc.pacienteSintomatico p JOIN rc.cultivo cult
                WHERE p.id = :id AND cult.clasificacion != '0' ORDER BY rc.id DESC";
        $query = $em->createQuery($dql);
        $query->setParameter('id' , $idPaciente);
        $resultCultivo = $query->setMaxResults(1)->getResult();
        return count($resultCultivo) == 0 ? null : $resultCultivo[0];
    }
}