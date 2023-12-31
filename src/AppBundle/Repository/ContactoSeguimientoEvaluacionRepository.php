<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ContactoSeguimientoEvaluacion;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ContactoSeguimientoEvaluacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactoSeguimientoEvaluacionRepository extends \Doctrine\ORM\EntityRepository
{

    public function masterAgregarSeguimientoEvaluacion($dataEvaluacion, $dataResultado, $user)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        try{

            $seguimiento = $em->getRepository('AppBundle:ContactoSeguimientoTPT')->obtenerSeguimiento($dataEvaluacion['idSeguimiento']);

            if(is_string($seguimiento)) {
                $em->rollback();
                return $seguimiento;
            }

            $evaluacion = $this->agregarEvaluacion($seguimiento,$dataEvaluacion);

            if(is_string($evaluacion)) {
                $em->rollback();
                return $evaluacion;
            }

            $resultado = $this->agregarResultado($seguimiento,$dataEvaluacion['mes'],$dataResultado);

            if(is_string($resultado)) {
                $em->rollback();
                return $resultado;
            }

            if ($resultado->getResultadoEvaluacion() === 'Infección tuberculosa') {
                $tpt =$this->modificarTPT($dataEvaluacion['idSeguimiento'],true);
            }else {
                $tpt =$this->modificarTPT($dataEvaluacion['idSeguimiento'],false);
            }

            if(is_string($tpt)) {
                $em->rollback();
                return $tpt;
            }

            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Insertar evaluación del mes ' . $dataEvaluacion['mes'],
                'descripcion' => 'Se insertó  la evaluación del contacto'
            );

            $em->getRepository('AppBundle:Traza')-> guardarTraza($dataTraza);
            $em->commit();
            $msg = 'ok';

        }catch (\Exception $e){

            $em->rollback();
            $msg = $e->getMessage();
        }
        return $msg;
    }

    public function agregarEvaluacion($seguimiento,$data)
    {
        try{
            $em = $this->getEntityManager();
            $evaluacion = new ContactoSeguimientoEvaluacion();
            $evaluacion->setMes($data['mes']);

            if($data['fechaInicioEvaluacion'] !== '')
            {
                $evaluacion->setFechaInicioEvaluacion(new DateTime($data['fechaInicioEvaluacion']));
            }
            $evaluacion->setExamenMedico($data['examenMedico']);

            if($data['fechaExamenMedico'] !== '')
            {
                $evaluacion->setFechaExamenMedico(new DateTime($data['fechaExamenMedico']));
            }
            $evaluacion->setSintomaRespiratorio($data['sintomaRespiratorio']);
            $evaluacion->setPctIgraIndicado($data['pctIgraIndicado']);

            if($data['fechaPctIgraIndicado'] !== '')
            {
                $evaluacion->setFechaPctIgraIndicado(new DateTime($data['fechaPctIgraIndicado']));
            }
            $evaluacion->setPctIgraRealizado($data['pctIgraRealizado']);

            if($data['fechaPctIgraRealizado'] !== '')
            {
                $evaluacion->setFechaPctIgraRealizado(new DateTime($data['fechaPctIgraRealizado']));
            }

            if($data['porqueNoPctIgra'] !== '')
            {
                $evaluacion->setPorqueNoPctIgra($data['porqueNoPctIgra']);
            }
            $evaluacion->setResultadoPCT($data['resultadoPCT']);

            if(isset($data['resultadoCuantitativo'])) {
                $evaluacion->setResultadoCuantitativo($data['resultadoCuantitativo']);
            }

            if($data['fechaLecturaPCT'] !== '')
            {
                $evaluacion->setFechaLecturaPCT(new DateTime($data['fechaLecturaPCT']));
            }
            $evaluacion->setResultadoIGRA($data['resultadoIGRA']);
            $evaluacion->setBaciloscopiaIndicado($data['baciloscopiaIndicado']);

            if($data['fechaBaciloscopiaIndicado'] !== '')
            {
                $evaluacion->setFechaBaciloscopiaIndicado(new DateTime($data['fechaBaciloscopiaIndicado']));
            }
            $evaluacion->setBaciloscopiaRealizado($data['baciloscopiaRealizado']);

            if($data['fechaBaciloscopiaRealizado'] !== '')
            {
                $evaluacion->setFechaBaciloscopiaRealizado(new DateTime($data['fechaBaciloscopiaRealizado']));
            }
            $evaluacion->setCultivoIndicado($data['cultivoIndicado']);

            if($data['fechaCultivoIndicado'] !== '')
            {
                $evaluacion->setFechaCultivoIndicado(new DateTime($data['fechaCultivoIndicado']));
            }
            $evaluacion->setCultivoRealizado($data['cultivoRealizado']);

            if($data['fechaCultivoRealizado'] !== '')
            {
                $evaluacion->setFechaCultivoRealizado(new DateTime($data['fechaCultivoRealizado']));
            }
            $evaluacion->setRayosXIndicado($data['rayosXIndicado']);

            if($data['fechaRayosXIndicado'] !== '')
            {
                $evaluacion->setFechaRayosXIndicado(new DateTime($data['fechaRayosXIndicado']));
            }
            $evaluacion->setRayosXRealizado($data['rayosXRealizado']);

            if($data['fechaRayosXRealizado'] !== '')
            {
                $evaluacion->setFechaRayosXRealizado(new DateTime($data['fechaRayosXRealizado']));
            }
            $evaluacion->setXpertIndicado($data['xpertIndicado']);

            $evaluacion->setContactoSeguimiento($seguimiento);

            $em->persist($evaluacion);
            $em->flush();
            $msg = $evaluacion;

        }catch (\Exception $e)
        {
            if(strpos($e->getMessage() , 'Duplicate entry') > 0)
            {
                $msg = 'La evaluación de este mes ya existe en este contacto, no se puede agregar';
            }
            else
            {
                $msg = 'Error al insertar la evaluación de este mes de este contacto, no se puede agregar';
            }
        }
        return $msg;
    }

    public function agregarResultado($seguimiento,$mes,$data)
    {
        try{
            $em = $this->getEntityManager();
            $resultado = $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->findOneBy(array('contactoSeguimiento' => $seguimiento, 'mes' => $mes));

            if (!empty($resultado)) {

                if ($data['fechaResultado'] !== '') {
                    $resultado->setFechaResultado(new DateTime($data['fechaResultado']));
                }
                $resultado->setHayResultadoBaciloscopia($data['hayResultadoBaciloscopia']);

                if ($data['fechaBaciloscopiaResultado'] !== '') {
                    $resultado->setFechaBaciloscopiaResultado(new DateTime($data['fechaBaciloscopiaResultado']));
                }
                $resultado->setResultadoBaciloscopia($data['resultadoBaciloscopia']);

                if (isset($data['codificacionBaciloscopia'])) {
                    $resultado->setCodificacionBaciloscopia($data['codificacionBaciloscopia']);
                }
                $resultado->setHayResultadoCultivo($data['hayResultadoCultivo']);

                if ($data['fechaCultivoResultado'] !== '') {
                    $resultado->setFechaCultivoResultado(new DateTime($data['fechaCultivoResultado']));
                }
                $resultado->setResultadoCultivo($data['resultadoCultivo']);

                if (isset($data['codificacionCultivo'])) {
                    $resultado->setCodificacionCultivo($data['codificacionCultivo']);
                }
                $resultado->setHayResultadoRayosX($data['hayResultadoRayosX']);

                if ($data['fechaRayosXResultado'] !== '') {
                    $resultado->setFechaRayosXResultado(new DateTime($data['fechaRayosXResultado']));
                }
                $resultado->setResultadoRayosX($data['resultadoRayosX']);
                $resultado->setRayoXLesionTB($data['rayoXLesionTB']);
                $resultado->setRayoXOtraLesion($data['rayoXOtraLesion']);

                if (isset($data['resultadoEvaluacion'])) {
                    $resultado->setResultadoEvaluacion($data['resultadoEvaluacion']);
                }

                if ($data['observaciones'] !== '') {
                    $resultado->setObservaciones($data['observaciones']);
                }

                if (isset($data['estadoPaciente'])) {
                    $resultado->setEstadoPaciente($data['estadoPaciente']);
                }

                $resultado->setContactoSeguimiento($seguimiento);

                $em->persist($resultado);
                $em->flush();
                $msg = $resultado;
            }else {
                $msg = $resultado;
            }

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al agregar el resultado de la evaluación de este mes de este contacto';
        }
        return $msg;
    }

    public function masterModificarSeguimientoEvaluacion($dataEvaluacion, $dataResultado, $user)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        try{

            if ($dataResultado['fechaResultado'] === '') {
                $evaluacion = $this->modificarEvaluacion($dataEvaluacion);

                if(is_string($evaluacion)) {
                    $em->rollback();
                    return $evaluacion;
                }
            }

            $resultado = $this->modificarResultado($dataEvaluacion['idEvaluacion'],$dataResultado);

            if(is_string($resultado)) {
                $em->rollback();
                return $resultado;
            }

            if ($resultado->getResultadoEvaluacion() === 'Infección tuberculosa') {
                $tpt =$this->modificarTPT($resultado->getContactoSeguimiento(),true);
            }else {
                $tpt =$this->modificarTPT($resultado->getContactoSeguimiento(),false);
            }

            if(is_string($tpt)) {
                $em->rollback();
                return $tpt;
            }

            $dataTraza = array(
                'username' => $user->getUsername(),
                'nombre' => $user->getNombre(),
                'operacion' => 'Modificar evaluación del mes ' .$resultado->getMes(),
                'descripcion' => 'Se modificó  la evaluación del contacto'
            );

            $em->getRepository('AppBundle:Traza')-> guardarTraza($dataTraza);
            $em->commit();
            $msg = 'ok';

        }catch (\Exception $e){

            $em->rollback();
            $msg = $e->getMessage();
        }
        return $msg;
    }

    public function modificarEvaluacion($data)
    {
        try{
            $em = $this->getEntityManager();
            $evaluacion = $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->find($data['idEvaluacion']);

            if (!empty($evaluacion)) {

                if ($data['fechaInicioEvaluacion'] !== '') {
                    $evaluacion->setFechaInicioEvaluacion(new DateTime($data['fechaInicioEvaluacion']));
                }
                $evaluacion->setExamenMedico($data['examenMedico']);

                if ($data['fechaExamenMedico'] !== '') {
                    $evaluacion->setFechaExamenMedico(new DateTime($data['fechaExamenMedico']));
                }
                $evaluacion->setSintomaRespiratorio($data['sintomaRespiratorio']);
                $evaluacion->setPctIgraIndicado($data['pctIgraIndicado']);

                if ($data['fechaPctIgraIndicado'] !== '') {
                    $evaluacion->setFechaPctIgraIndicado(new DateTime($data['fechaPctIgraIndicado']));
                }
                $evaluacion->setPctIgraRealizado($data['pctIgraRealizado']);

                if ($data['fechaPctIgraRealizado'] !== '') {
                    $evaluacion->setFechaPctIgraRealizado(new DateTime($data['fechaPctIgraRealizado']));
                }

                if ($data['porqueNoPctIgra'] !== '') {
                    $evaluacion->setPorqueNoPctIgra($data['porqueNoPctIgra']);
                }
                $evaluacion->setResultadoPCT($data['resultadoPCT']);

                if (isset($data['resultadoCuantitativo'])) {
                    $evaluacion->setResultadoCuantitativo($data['resultadoCuantitativo']);
                }

                if ($data['fechaLecturaPCT'] !== '') {
                    $evaluacion->setFechaLecturaPCT(new DateTime($data['fechaLecturaPCT']));
                }
                $evaluacion->setResultadoIGRA($data['resultadoIGRA']);
                $evaluacion->setBaciloscopiaIndicado($data['baciloscopiaIndicado']);

                if ($data['fechaBaciloscopiaIndicado'] !== '') {
                    $evaluacion->setFechaBaciloscopiaIndicado(new DateTime($data['fechaBaciloscopiaIndicado']));
                }
                $evaluacion->setBaciloscopiaRealizado($data['baciloscopiaRealizado']);

                if ($data['fechaBaciloscopiaRealizado'] !== '') {
                    $evaluacion->setFechaBaciloscopiaRealizado(new DateTime($data['fechaBaciloscopiaRealizado']));
                }
                $evaluacion->setCultivoIndicado($data['cultivoIndicado']);

                if ($data['fechaCultivoIndicado'] !== '') {
                    $evaluacion->setFechaCultivoIndicado(new DateTime($data['fechaCultivoIndicado']));
                }
                $evaluacion->setCultivoRealizado($data['cultivoRealizado']);

                if ($data['fechaCultivoRealizado'] !== '') {
                    $evaluacion->setFechaCultivoRealizado(new DateTime($data['fechaCultivoRealizado']));
                }
                $evaluacion->setRayosXIndicado($data['rayosXIndicado']);

                if ($data['fechaRayosXIndicado'] !== '') {
                    $evaluacion->setFechaRayosXIndicado(new DateTime($data['fechaRayosXIndicado']));
                }
                $evaluacion->setRayosXRealizado($data['rayosXRealizado']);

                if ($data['fechaRayosXRealizado'] !== '') {
                    $evaluacion->setFechaRayosXRealizado(new DateTime($data['fechaRayosXRealizado']));
                }
                $evaluacion->setXpertIndicado($data['xpertIndicado']);

                $em->persist($evaluacion);
                $em->flush();
                $msg = $evaluacion;
            }else {
                $msg = $evaluacion;
            }

        }catch (\Exception $e)
        {
            $msg = 'Error al modificar la evaluación de este mes de este contacto, no se puede agregar';
        }
        return $msg;

    }

    public function modificarResultado($idEvaluacion,$data)
    {
        try{
            $em = $this->getEntityManager();
            $resultado = $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->find($idEvaluacion);

            if (!empty($resultado)) {

                if ($data['fechaResultado'] !== '') {
                    $resultado->setFechaResultado(new DateTime($data['fechaResultado']));
                }
                $resultado->setHayResultadoBaciloscopia($data['hayResultadoBaciloscopia']);

                if ($data['fechaBaciloscopiaResultado'] !== '') {
                    $resultado->setFechaBaciloscopiaResultado(new DateTime($data['fechaBaciloscopiaResultado']));
                }
                $resultado->setResultadoBaciloscopia($data['resultadoBaciloscopia']);

                if (isset($data['codificacionBaciloscopia'])) {
                    $resultado->setCodificacionBaciloscopia($data['codificacionBaciloscopia']);
                }
                $resultado->setHayResultadoCultivo($data['hayResultadoCultivo']);

                if ($data['fechaCultivoResultado'] !== '') {
                    $resultado->setFechaCultivoResultado(new DateTime($data['fechaCultivoResultado']));
                }
                $resultado->setResultadoCultivo($data['resultadoCultivo']);

                if (isset($data['codificacionCultivo'])) {
                    $resultado->setCodificacionCultivo($data['codificacionCultivo']);
                }
                $resultado->setHayResultadoRayosX($data['hayResultadoRayosX']);

                if ($data['fechaRayosXResultado'] !== '') {
                    $resultado->setFechaRayosXResultado(new DateTime($data['fechaRayosXResultado']));
                }
                $resultado->setResultadoRayosX($data['resultadoRayosX']);
                $resultado->setRayoXLesionTB($data['rayoXLesionTB']);
                $resultado->setRayoXOtraLesion($data['rayoXOtraLesion']);

                if (isset($data['resultadoEvaluacion'])) {
                    $resultado->setResultadoEvaluacion($data['resultadoEvaluacion']);
                }

                if ($data['observaciones'] !== '') {
                    $resultado->setObservaciones($data['observaciones']);
                }

                if (isset($data['estadoPaciente'])) {
                    $resultado->setEstadoPaciente($data['estadoPaciente']);
                }

                $em->persist($resultado);
                $em->flush();
                $msg = $resultado;
            }else {
                $msg = $resultado;
            }

        }catch (\Exception $e)
        {
            $msg = 'Se produjo un error al agregar el resultado de la evaluación de este mes';
        }
        return $msg;
    }

    public function modificarTPT($seguimiento,$tpt)
    {
        try{
            $em = $this->getEntityManager();
            $forma = $em->getRepository('AppBundle:ContactoSeguimiento')->find($seguimiento);

            if (!empty($forma)) {

                $forma->setTpt($tpt);

                $em->flush();
                $msg = $forma;
            }else {
                $msg = $forma;
            }

        }catch (\Exception $e)
        {
            $msg = 'Error al modificar la forma 8 en este contacto';
        }
        return $msg;

    }

}
