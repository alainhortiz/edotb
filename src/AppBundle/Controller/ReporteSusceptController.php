<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\ImprimirExcel;

class ReporteSusceptController extends Controller
{

    //-----------BLOQUE LABORATORIO SUSCEPTIBILIDAD----------------------------------------------
    //-------------------------------------------------------------------------------------------
    //ANALISIS DE SUSCEPTIBILIDAD REALIZADOS A UN PACIENTE
    /**
     * @Route("/analisisSusceptHechosPac", name="analisisSusceptHechosPac")
     */
    public function analisisSusceptHechosPacAction()
    {
        $peticion = Request::createFromGlobals();

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $id_pac_listado = $peticion->request->get('idPacListado');
        if( isset($id_pac_listado) ){
            $idPaciente =  $id_pac_listado;
        }
        else{
            $id_evolucion       = $peticion->request->get('idPacEvolucion');
            $pacienteEvolucion  = $em->getRepository('AppBundle:PacienteEvolucion')->find($id_evolucion);
            $idPaciente         = $pacienteEvolucion->getPaciente()->getId();
        }

        $datos = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->listaAnalisisRealizadosHistorico($idPaciente);

        if( count($datos) < 1 )
            $resp = array();
        else
        {
            for( $i = 0; $i < count($datos); $i++ ){
                $resp[$i] = array(
                    'id'            => $datos[$i]->getId(),
                    'idEvolucion'   => $datos[$i]->getPacienteEvolucion()->getId(),
                    'codigoMuestra' => $datos[$i]->getCodigoMuestra()
                );
            }
        }

        $resp = json_encode($resp);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($resp);
        return $respuesta;

    }

    //REPORTE DE LOS ANALISIS DE SUSCEPTIBILIDAD REALIZADOS A UN PACIENTE
    //PUEDE ESCOGERSE EXPORTAR SOLO UNO $todos=0
    //PUEDE ESCOGERSE EXPORTAR TODOS $todos=1
    /**
     * @Route("/rpteSusceptHechosPac/{idEvolucion}/{todos}/{idTablaSuscept}", name="rpteSusceptHechosPac")
     */
    public function rpteSusceptHechosPacAction($idEvolucion, $todos, $idTablaSuscept)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $pacienteEvolucion  = $em->getRepository('AppBundle:PacienteEvolucion')->find($idEvolucion);
        $idPaciente         = $pacienteEvolucion->getPaciente()->getId();

        if($todos == 0)
        {
            $datos = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->obtenerAnalisisRealizadoHistorico($idTablaSuscept);
            $imp_suscept = new ImprimirExcel\ImpHistoricoSusceptIndividual();
            $imp_suscept->DatosPDF($datos);
        }

        if($todos == 1)
        {
            $datos = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->listaAnalisisRealizadosHistorico($idPaciente);
            $imp_suscept = new ImprimirExcel\ImpHistoricoSusceptTotal();
            $imp_suscept->DatosPDF($datos);
        }


    }

    public function ListadoLaboratorios(){

        $em     = $this->getDoctrine()->getManager();
        $labs   = $em->getRepository('AppBundle:Laboratorio')->findAll();

        return $labs;
    }

    public function AnnoActual()
    {
        $fechaActual = new \DateTime('now');

        return $year =  $fechaActual->format('Y');
    }



}