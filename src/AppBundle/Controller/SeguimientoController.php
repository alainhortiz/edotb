<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeguimientoController extends Controller
{
    /**
     * @Route("/mostrarVistaSeguimientoPaciente/{idEvolucion}/{tabActivo}", name="mostrarVistaSeguimientoPaciente")
     */
    public function mostrarVistaSeguimientoPacienteAction($idEvolucion , $tabActivo = 'baciloscopia')
    {
        $em = $this->getDoctrine()->getManager();
        $evolucion  = $em->getRepository('AppBundle:PacienteEvolucion')->find($idEvolucion);
        $xperts = $em->getRepository('AppBundle:Xpert')->findAll();
        $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();
        $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();
        $salidasCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findAll();
        $biopsias = $em->getRepository('AppBundle:Biopsia')->findAll();
        $orinas = $em->getRepository('AppBundle:Orina')->findAll();

        $currentEsquema = $evolucion->getEsquemasMedicamentos()->last();
        $cantBaciloscopiaFinEtapa = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->cantidadBaciloscopiaFinEtapa($idEvolucion);
        $categoriaBaciloscopia = $this->definirCategoriaAnalisisSeguimiento($currentEsquema , $cantBaciloscopiaFinEtapa);
        $cantCultivoFinEtapa = $em->getRepository('AppBundle:CultivoSeguimiento')->cantidadCultivoFinEtapa($idEvolucion);
        $categoriaCultivo = $this->definirCategoriaAnalisisSeguimiento($currentEsquema , $cantCultivoFinEtapa);

        return $this->render('Pacientes/seguimientosAnalisisPaciente.html.twig' , array(

                'evolucion' => $evolucion,
                'xperts' => $xperts,
                'baciloscopias' => $baciloscopias,
                'cultivos' => $cultivos,
                'biopsias' => $biopsias,
                'orinas' => $orinas,
                'categoriaBaciloscopia' => $categoriaBaciloscopia,
                'categoriaCultivo' => $categoriaCultivo,
                'tabActivo' => $tabActivo,
                'salidasCultivo' => $salidasCultivo,)
        );
    }

    //Parametros: el esquema actual de la evolucion y la cantidad de AnalisisSeguimiento que no son de categoria Seguimiento
    //Devuelve la categoria del analisis seguimniento proximo a insertar
    private function definirCategoriaAnalisisSeguimiento($esquema , $cantidad)
    {
        $cantAsistencias = count($esquema->getAsistenciasTratamientos());
        if ($cantidad == 2 and $cantAsistencias > 107) return 'Sexto Mes (Fin de Tratamiento)';
        elseif ($cantidad == 1 and $cantAsistencias > 83) return 'Cuarto Mes (Segunda Fase)';
        elseif ($cantidad == 0 and $cantAsistencias > 59) return 'Segundo Mes (Fin Primera fase)';
        else return 'Seguimiento';
    }

    /**
     * @Route("/insertBaciloscopiaSeguimiento", name="insertBaciloscopiaSeguimiento")
     */
    public function insertBaciloscopiaSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idEvolucion' => $peticion->request->get('idEvolucion'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'fecha' => $peticion->request->get('fechaBaciloscopiaAdd'),
            'categoria' => $peticion->request->get('categoria'),
        );

        $baciloscopiaSeguimiento = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->agregarBaciloscopiaSeguimiento($data);

        if(is_string($baciloscopiaSeguimiento)) return new Response($baciloscopiaSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Nueva Baciloscopía para el Seguimiento',
                'descripcion' => 'Se insertó una nueva baciloscopía de seguimiento en la fecha: '.$baciloscopiaSeguimiento->getFecha()->format('Y-m-d').' con codificación '.$baciloscopiaSeguimiento->getBaciloscopia()->getClasificacion().
                    '  al paciente  '. $baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/insertCultivoSeguimiento", name="insertCultivoSeguimiento")
     */
    public function insertCultivoSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idEvolucion' => $peticion->request->get('idEvolucion'),
            'cultivo' => $peticion->request->get('cultivo'),
            'salidaCultivo' => $peticion->request->get('salidaCultivo'),
            'fecha' => $peticion->request->get('fechaCultivoAdd'),
            'categoria' => $peticion->request->get('categoria'),
        );

        $cultivoSeguimiento = $em->getRepository('AppBundle:CultivoSeguimiento')->agregarCultivoSeguimiento($data);

        if(is_string($cultivoSeguimiento)) return new Response($cultivoSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Nuevo Cultivo para el Seguimiento',
                'descripcion' => 'Se insertó un nuevo cultivo de seguimiento en la fecha: '.$cultivoSeguimiento->getFecha()->format('Y-m-d').' con codificación '.$cultivoSeguimiento->getCultivo()->getClasificacion().
                    '  al paciente  '. $cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/updateBaciloscopiaSeguimiento", name="updateBaciloscopiaSeguimiento")
     */
    public function updateBaciloscopiaSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idBaciloscopiaSeguimmiento' => $peticion->request->get('idBaciloscopiaSeguimmiento'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
        );

        $baciloscopiaSeguimiento = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->modificarBaciloscopiaSeguimiento($data);

        if(is_string($baciloscopiaSeguimiento)) return new Response($baciloscopiaSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Baciloscopía para el Seguimiento',
                'descripcion' => 'Se modificó la baciloscopía de seguimiento con fecha: '.$baciloscopiaSeguimiento->getFecha()->format('Y-m-d').' y codificación '.$baciloscopiaSeguimiento->getBaciloscopia()->getClasificacion().
                    '  del paciente  '. $baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/updateCultivoSeguimiento", name="updateCultivoSeguimiento")
     */
    public function updateCultivoSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idCultivoSeguimiento' => $peticion->request->get('idCultivoSeguimiento'),
            'cultivo' => $peticion->request->get('cultivo'),
            'salidaCultivo' => $peticion->request->get('salidaCultivo'),
        );

        $cultivoSeguimiento = $em->getRepository('AppBundle:CultivoSeguimiento')->modificarCultivoSeguimiento($data);

        if(is_string($cultivoSeguimiento)) return new Response($cultivoSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Cultivo para el Seguimiento',
                'descripcion' => 'Se modificó el cultivo de seguimiento de la fecha: '.$cultivoSeguimiento->getFecha()->format('Y-m-d').' y codificación '.$cultivoSeguimiento->getCultivo()->getClasificacion().
                    '  del paciente  '. $cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteBaciloscopiaSeguimiento", name="deleteBaciloscopiaSeguimiento")
     */
    public function deleteBaciloscopiaSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $idBaciloscopiaSeguimiento = $peticion->request->get('idBaciloscopiaSeguimiento');
        $em = $this->getDoctrine()->getManager();

        $baciloscopiaSeguimiento  = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->eliminarBaciloscopiaSeguimiento($idBaciloscopiaSeguimiento);

        if(is_string($baciloscopiaSeguimiento))  return new Response($baciloscopiaSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Baciloscopía de Seguimiento',
                'descripcion' => 'Se eliminó la baciloscopía de la fecha: '.$baciloscopiaSeguimiento->getFecha()->format('Y-m-d').' con codificación '.$baciloscopiaSeguimiento->getBaciloscopia()->getClasificacion().
                    '  del paciente  '. $baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$baciloscopiaSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deleteCultivoSeguimiento", name="deleteCultivoSeguimiento")
     */
    public function deleteCultivoSeguimientoAction()
    {
        $peticion = Request::createFromGlobals();
        $idCultivoSeguimiento = $peticion->request->get('idCultivoSeguimiento');
        $em = $this->getDoctrine()->getManager();

        $cultivoSeguimiento  = $em->getRepository('AppBundle:CultivoSeguimiento')->eliminarCultivoSeguimiento($idCultivoSeguimiento);

        if(is_string($cultivoSeguimiento))  return new Response($cultivoSeguimiento);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Cultivo de Seguimiento',
                'descripcion' => 'Se eliminó el cultivo de la fecha: '.$cultivoSeguimiento->getFecha()->format('Y-m-d').' con codificación '.$cultivoSeguimiento->getCultivo()->getClasificacion().
                    '  del paciente  '. $cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getNombre().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$cultivoSeguimiento->getPacienteEvolucion()->getPaciente()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/updateAnalisisIniciales", name="updateAnalisisIniciales")
     */
    public function updateAnalisisInicialesAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $idEvolucion = $peticion->request->get('idEvolucion');
        $evolucion = $em->getRepository('AppBundle:PacienteEvolucion')->find($idEvolucion);

        $dataBCX = array(
            'idResultadoBCX' => $evolucion->getResultadoBCX()->getId(),
            'xpert' => $peticion->request->get('xpertBCX'),
            'baciloscopia' => $peticion->request->get('baciloscopiaBCX'),
            'baciloscopia2' => $peticion->request->get('baciloscopia2BCX'),
            'cultivo' => $peticion->request->get('cultivoBCX'),
            'salidaCultivo' => $peticion->request->get('salidaCultivoBCX'),
            'biopsia' => $peticion->request->get('biopsia'),
            'orina' => $peticion->request->get('orina'),
        );
        $this->generaTrazaAnalisisIniciales($evolucion ,$dataBCX);
        $resultadoBCX = $em->getRepository('AppBundle:ResultadoBCX')->modificarResultadoBCX($dataBCX);
        if( is_string($resultadoBCX)) return new Response($resultadoBCX);

        if(($resultadoBCX->getXpert()->getClasificacion() != 'N' && $resultadoBCX->getXpert()->getClasificacion() != 'I' && $resultadoBCX->getXpert()->getClasificacion() != 'NRX') ||
            ($resultadoBCX->getBaciloscopia()->getClasificacion() != '0' && $resultadoBCX->getBaciloscopia()->getClasificacion() != 'SB') ||
            ($resultadoBCX->getBaciloscopia2()->getClasificacion() != '0' && $resultadoBCX->getBaciloscopia2()->getClasificacion() != 'SB') ||
            ($resultadoBCX->getCultivo()->getClasificacion() != '0' && $resultadoBCX->getCultivo()->getClasificacion() != 'SC' && $resultadoBCX->getSalidaCultivo()->getSalida() == 'Complejo Mycobacterium tuberculosis'))
        {
            if($evolucion->getDefinicionCaso() != 'Bacteriológicamente confirmado')
            {
                $evolucion->setDefinicionCaso('Bacteriológicamente confirmado');
                $em->persist($evolucion);
                $em->flush();
            }
        }

        return new Response('ok');
    }

    private function generaTrazaAnalisisIniciales($evolucion , $data){

        if($evolucion->getResultadoBCX()->getXpert()->getClasificacion() != $data['xpert']){

            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar análisis iniciales',
                'descripcion' => 'Se modificó el resultado del xpert de los análisis iniciales de codificación: '.$evolucion->getResultadoBCX()->getXpert()->getClasificacion().' a codificación '.$data['xpert'] ,
            ));
        }
        if($evolucion->getResultadoBCX()->getBaciloscopia()->getClasificacion() != $data['baciloscopia']){

            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar análisis iniciales',
                'descripcion' => 'Se modificó el resultado de la baciloscopía de los análisis iniciales de codificación: '.$evolucion->getResultadoBCX()->getBaciloscopia()->getClasificacion().' a  codificación '.$data['baciloscopia'] ,
            ));
        }
        if($evolucion->getResultadoBCX()->getBaciloscopia2()->getClasificacion() != $data['baciloscopia2']){

            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar análisis iniciales',
                'descripcion' => 'Se modificó el resultado de la baciloscopía2 de los análisis iniciales de codificación: '.$evolucion->getResultadoBCX()->getBaciloscopia2()->getClasificacion().' a  codificación '.$data['baciloscopia2'] ,
            ));
        }
        if($evolucion->getResultadoBCX()->getCultivo()->getClasificacion() != $data['cultivo']){

            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar análisis iniciales',
                'descripcion' => 'Se modificó el resultado del cultivo de los análisis iniciales de codificación: '.$evolucion->getResultadoBCX()->getCultivo()->getClasificacion().' a codificación '.$data['cultivo'] ,
            ));
        }
        if($evolucion->getResultadoBCX()->getSalidaCultivo()->getSalida() != $data['salidaCultivo']){

            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar análisis iniciales',
                'descripcion' => 'Se modificó la salida del cultivo de los análisis iniciales de: '.$evolucion->getResultadoBCX()->getSalidaCultivo()->getSalida().' a '.$data['salidaCultivo'] ,
            ));
        }
    }


}
