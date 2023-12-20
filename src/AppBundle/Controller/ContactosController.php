<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactosController extends Controller
{

    /**
     * @Route("/formPacienteContacto", name="formPacienteContacto")
     */
    public function formPacienteContactoAction()
    {
        return $this->render('Contactos/Contactos/listadoContactos.html.twig', array('ci' => ''));
    }

    /**
     * @Route("/localizarPacienteContacto", name="localizarPacienteContacto")
     */
    public function localizarPacienteContactoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $motivos = $em->getRepository('AppBundle:MotivoCierreContacto')->findAll();
        $pacientes = $em->getRepository('AppBundle:Paciente')->findBy(array('carnetIdentidad' => $peticion->request->get('carnetIdentidad')));

        if(is_string($pacientes)) {
            return new Response($pacientes);
        }

        if(empty($pacientes)) {
            return new Response('no');
        }

        return new Response($this->renderView('Contactos/Contactos/tablaContactosEncontrados.html.twig', array(
            'pacientes' => $pacientes,
            'motivos' => $motivos
        )));
    }

    /**
     * @Route("/localizarPacienteContactoCI/{ci}", name="localizarPacienteContactoCI")
     */
    public function localizarPacienteContactoCIAction($ci)
    {
        return new Response($this->renderView('Contactos/Contactos/listadoContactos.html.twig', array('ci' => $ci)));
    }

    /**
     * @Route("/addContacto/{idPaciente}/{carnetIdentidad}/{nombreCompleto}", name="addContacto")
     */
    public function addContactoAction($idPaciente,$carnetIdentidad,$nombreCompleto)
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $niveles = $em->getRepository('AppBundle:NivelEducacional')->findAll();
        $ocupaciones = $em->getRepository('AppBundle:Ocupacion')->findAll();
        $parentescos = $em->getRepository('AppBundle:Parentesco')->findAll();
        $factoresRiesgo = $em->getRepository('AppBundle:FactorRiesgo')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Contacto'));

        return $this->render('Contactos/Contactos/addContacto.html.twig' , array(
                'idPaciente' => $idPaciente,
                'carnetIdentidad' => $carnetIdentidad,
                'nombreCompleto' => $nombreCompleto,
                'provincias' => $provincias,
                'niveles' => $niveles,
                'ocupaciones' => $ocupaciones,
                'parentescos' => $parentescos,
                'medicamentos' => $medicamentos,
                'factoresRiesgo' => $factoresRiesgo,
                'municipios' => $municipios)
        );

    }

    /**
     * @Route("/editContacto/{idSeguimiento}/{carnetIdentidad}", name="editContacto")
     */
    public function editContactoAction($idSeguimiento,$carnetIdentidad)
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $niveles = $em->getRepository('AppBundle:NivelEducacional')->findAll();
        $ocupaciones = $em->getRepository('AppBundle:Ocupacion')->findAll();
        $parentescos = $em->getRepository('AppBundle:Parentesco')->findAll();
        $factoresRiesgo = $em->getRepository('AppBundle:FactorRiesgo')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Contacto'));
        $seguimiento = $em->getRepository('AppBundle:ContactoSeguimiento')->find($idSeguimiento);

        return $this->render('Contactos/Contactos/editContacto.html.twig' , array(
                'seguimiento' => $seguimiento,
                'carnetIdentidad' => $carnetIdentidad,
                'provincias' => $provincias,
                'niveles' => $niveles,
                'ocupaciones' => $ocupaciones,
                'parentescos' => $parentescos,
                'medicamentos' => $medicamentos,
                'factoresRiesgo' => $factoresRiesgo,
                'municipios' => $municipios)
        );

    }

    /**
     * @Route("/cerrarContacto", name="cerrarContacto")
     */
    public function cerrarContactoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(
            'idSeguimiento' => $peticion->request->get('idSeguimiento'),
            'motivo' => $peticion->request->get('motivo')
        );

        $contacto  = $em->getRepository('AppBundle:ContactoSeguimiento')->cerrarContactoSeguimiento($data);

        if(is_string($contacto)) return new Response($contacto);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Cerrar Contacto',
                'descripcion' => 'Se cerró el contacto: '.$contacto->getContacto()->nombreCompleto() . ' del paciente ' .$contacto->getContacto()->getPaciente()->nombreCompleto()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/verContacto/{carnetIdentidad}/{idSeguimiento}/{origen}", name="verContacto")
     */
    public function verContactoAction($carnetIdentidad,$idSeguimiento,$origen)
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $niveles = $em->getRepository('AppBundle:NivelEducacional')->findAll();
        $ocupaciones = $em->getRepository('AppBundle:Ocupacion')->findAll();
        $parentescos = $em->getRepository('AppBundle:Parentesco')->findAll();
        $factoresRiesgo = $em->getRepository('AppBundle:FactorRiesgo')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Contacto'));
        $seguimiento = $em->getRepository('AppBundle:ContactoSeguimiento')->find($idSeguimiento);

        return $this->render('Contactos/Contactos/verContacto.html.twig' , array(
                'seguimiento' => $seguimiento,
                'carnetIdentidad' => $carnetIdentidad,
                'provincias' => $provincias,
                'niveles' => $niveles,
                'ocupaciones' => $ocupaciones,
                'parentescos' => $parentescos,
                'medicamentos' => $medicamentos,
                'factoresRiesgo' => $factoresRiesgo,
                'municipios' => $municipios,
                'origen' => $origen)
        );

    }

    /**
     * @Route("/localizarContacto", name="localizarContacto")
     */
    public function localizarContactoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $contactos = $em->getRepository('AppBundle:Contacto')->findBy(array('carnetIdentidad' => $peticion->request->get('carnetIdentidad')));

        if(empty($contactos)) {
            return new Response('no');
        } else {
            return new Response('si');
        }

    }

    /**
     * @Route("/insertContacto", name="insertContacto")
     */
    public function insertContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataContacto = array(
            'idPaciente' => $peticion->request->get('idPaciente'),
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
            'colorPiel' => $peticion->request->get('colorPiel')
        );

        $dataSeguimiento = array(
            'edad' => $peticion->request->get('edad'),
            'fechaNotificacion' => $peticion->request->get('fechaNotificacion'),
            'telefono' => $peticion->request->get('telefono'),
            'direccion' => $peticion->request->get('direccion'),
            'municipioResid' => $peticion->request->get('municipioResid'),
            'nivelEducacional' => $peticion->request->get('nivelEducacional'),
            'ocupaciones' => $peticion->request->get('ocupaciones')
        );

        $dataFactorRiesgo = array(
            'vacunado' => $peticion->request->get('vacunado'),
            'parentesco' => $peticion->request->get('parentesco'),
            'tratadoTB' => $peticion->request->get('tratadoTB'),
            'tratadoFechaNotificacion' => $peticion->request->get('tratadoFechaNotificacion'),
            'diagnosticoVIH' => $peticion->request->get('diagnosticoVIH'),
            'vihFechaRealizacion' => $peticion->request->get('vihFechaRealizacion'),
            'tarvae' => $peticion->request->get('tarvae'),
            'vihFechaInicio' => $peticion->request->get('vihFechaInicio'),
            'tptAnterior' => $peticion->request->get('tptAnterior'),
            'tptFechaInicio' => $peticion->request->get('tptFechaInicio'),
            'tptFechaFinal' => $peticion->request->get('tptFechaFinal'),
            'medicamento' => $peticion->request->get('medicamento'),
            'porqueTPT' => $peticion->request->get('porqueTPT'),
            'otroFactorRiesgo' => $peticion->request->get('otroFactorRiesgo'),
            'factoresRiesgo' => $peticion->request->get('factoresRiesgo'),
            'observaciones' => $peticion->request->get('observaciones'),
        );

        $contacto  =  $em->getRepository('AppBundle:Contacto')->masterAgregarContacto($dataContacto, $dataSeguimiento, $dataFactorRiesgo, $user);
        return new Response($contacto);
    }

    /**
     * @Route("/updateContacto", name="updateContacto")
     */
    public function updateContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataContacto = array(
            'idContacto' => $peticion->request->get('idContacto'),
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
            'colorPiel' => $peticion->request->get('colorPiel')
        );

        $dataSeguimiento = array(
            'idSeguimiento' => $peticion->request->get('idSeguimiento'),
            'edad' => $peticion->request->get('edad'),
            'fechaNotificacion' => $peticion->request->get('fechaNotificacion'),
            'telefono' => $peticion->request->get('telefono'),
            'direccion' => $peticion->request->get('direccion'),
            'municipioResid' => $peticion->request->get('municipioResid'),
            'nivelEducacional' => $peticion->request->get('nivelEducacional'),
            'ocupaciones' => $peticion->request->get('ocupaciones')
        );

        $dataFactorRiesgo = array(
            'idFactorRiesgo' => $peticion->request->get('idFactorRiesgo'),
            'vacunado' => $peticion->request->get('vacunado'),
            'parentesco' => $peticion->request->get('parentesco'),
            'tratadoTB' => $peticion->request->get('tratadoTB'),
            'tratadoFechaNotificacion' => $peticion->request->get('tratadoFechaNotificacion'),
            'diagnosticoVIH' => $peticion->request->get('diagnosticoVIH'),
            'vihFechaRealizacion' => $peticion->request->get('vihFechaRealizacion'),
            'tarvae' => $peticion->request->get('tarvae'),
            'vihFechaInicio' => $peticion->request->get('vihFechaInicio'),
            'tptAnterior' => $peticion->request->get('tptAnterior'),
            'tptFechaInicio' => $peticion->request->get('tptFechaInicio'),
            'tptFechaFinal' => $peticion->request->get('tptFechaFinal'),
            'medicamento' => $peticion->request->get('medicamento'),
            'porqueTPT' => $peticion->request->get('porqueTPT'),
            'otroFactorRiesgo' => $peticion->request->get('otroFactorRiesgo'),
            'factoresRiesgo' => $peticion->request->get('factoresRiesgo'),
            'observaciones' => $peticion->request->get('observaciones'),
        );

        $contacto  =  $em->getRepository('AppBundle:Contacto')->masterModificarContacto($dataContacto, $dataSeguimiento, $dataFactorRiesgo, $user);
        return new Response($contacto);
    }

    /**
     * @Route("/formSeguimientosContacto", name="formSeguimientosContacto")
     */
    public function formSeguimientosContactoAction()
    {
        return $this->render('Contactos/Seguimientos/listadoSeguimientos.html.twig');
    }

    /**
     * @Route("/localizarSeguimientosContacto", name="localizarSeguimientosContacto")
     */
    public function localizarSeguimientosContactoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $motivos = $em->getRepository('AppBundle:MotivoCierreContacto')->findAll();
        $contactos = $em->getRepository('AppBundle:Contacto')->findBy(array('carnetIdentidad' => $peticion->request->get('carnetIdentidad')));

        if(is_string($contactos)) {
            return new Response($contactos);
        }

        if(empty($contactos)) {
            return new Response('no');
        }

        return new Response($this->renderView('Contactos/Seguimientos/tablaSeguimientosEncontrados.html.twig', array(
            'contactos' => $contactos,
            'motivos' => $motivos
        )));
    }

    /**
     * @Route("/addSeguimientoContacto/{idSeguimiento}/{mes}/{ci}", name="addSeguimientoContacto")
     */
    public function addSeguimientoContactoAction($idSeguimiento,$mes,$ci)
    {
        $em = $this->getDoctrine()->getManager();

        $seguimiento = $em->getRepository('AppBundle:ContactoSeguimiento')->find($idSeguimiento);

        if(!empty($seguimiento)) {
            $evaluacion = $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->findOneBy(array('contactoSeguimiento' => $seguimiento, 'mes' => $mes));
        }

        if(empty($evaluacion)) {
            return $this->render('Contactos/Evaluaciones/addEvaluacion.html.twig' , array(
                    'seguimiento' => $seguimiento,
                    'ci' => $ci,
                    'mes' => $mes)
            );
        }

        return $this->render('Contactos/Evaluaciones/editEvaluacion.html.twig' , array(
                'evaluacion' => $evaluacion,
                'ci' => $ci,
                'mes' => $mes
            )
        );

    }

    /**
     * @Route("/addTPTContacto/{idSeguimiento}/{ci}", name="addTPTContacto")
     */
    public function addTPTContactoAction($idSeguimiento,$ci)
    {
        $em = $this->getDoctrine()->getManager();

        $causas = $em->getRepository('AppBundle:CausaNoPrescripcionTPT')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Contacto'));
        $resultados = $em->getRepository('AppBundle:ResultadoTratamiento')->findBy(array('modulo' => 'Contacto'));
        $seguimiento = $em->getRepository('AppBundle:ContactoSeguimiento')->find($idSeguimiento);

        if(!empty($seguimiento)) {
            $tpt = $em->getRepository('AppBundle:ContactoSeguimientoTPT')->findOneBy(array('contactoSeguimiento' => $seguimiento));
        }


        if(empty($tpt)) {
            return $this->render('Contactos/TPT/addTPT.html.twig' , array(
                    'seguimiento' => $seguimiento,
                    'causas' => $causas,
                    'medicamentos' => $medicamentos,
                    'resultados' => $resultados,
                    'ci' => $ci)
            );
        }

        return $this->render('Contactos/TPT/editTPT.html.twig' , array(
                'causas' => $causas,
                'medicamentos' => $medicamentos,
                'resultados' => $resultados,
                'ci' => $ci,
                'tpt' => $tpt
            )
        );
    }

    /**
     * @Route("/insertTPTContacto", name="insertTPTContacto")
     */
    public function insertTPTContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $data = array(
            'idSeguimiento' => $peticion->request->get('idSeguimiento'),
            'prescripcion' => $peticion->request->get('prescripcion'),
            'peso' => $peticion->request->get('peso'),
            'talla' => $peticion->request->get('talla'),
            'medicamento' => $peticion->request->get('medicamento'),
            'duracion' => $peticion->request->get('duracion'),
            'porqueDuracion' => $peticion->request->get('porqueDuracion'),
            'fechaPrescripcion' => $peticion->request->get('fechaPrescripcion'),
            'iniciacion' => $peticion->request->get('iniciacion'),
            'personaNegada' => $peticion->request->get('personaNegada'),
            'fechaPrimeraDosis' => $peticion->request->get('fechaPrimeraDosis'),
            'fechaUltimaDosis' => $peticion->request->get('fechaUltimaDosis'),
            'regimenPrescrito' => $peticion->request->get('regimenPrescrito'),
            'noTabletas' => $peticion->request->get('noTabletas'),
            'noDias' => $peticion->request->get('noDias'),
            'reaccionAdversa' => $peticion->request->get('reaccionAdversa'),
            'fechaInicioReaccionAdversa' => $peticion->request->get('fechaInicioReaccionAdversa'),
            'fechaFinalReaccionAdversa' => $peticion->request->get('fechaFinalReaccionAdversa'),
            'provocoSuspension' => $peticion->request->get('provocoSuspension'),
            'provocoModificacion' => $peticion->request->get('provocoModificacion'),
            'administracion' => $peticion->request->get('administracion'),
            'noDosisSaltadas' => $peticion->request->get('noDosisSaltadas'),
            'resultado' => $peticion->request->get('resultado'),
            'causaSuspension' => $peticion->request->get('causaSuspension'),
            'fechaNotificacionTB' => $peticion->request->get('fechaNotificacionTB'),
            'noRegistro' => $peticion->request->get('noRegistro'),
            'contactoCausaNoPrescripcion' => $peticion->request->get('contactoCausaNoPrescripcion'),
        );

        $tpt  =  $em->getRepository('AppBundle:ContactoSeguimientoTPT')->masterAgregarSeguimientoTPT($data, $user);
        return new Response($tpt);
    }

    /**
     * @Route("/updateTPTContacto", name="updateTPTContacto")
     */
    public function updateTPTContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $data = array(
            'idTPT' => $peticion->request->get('idTPT'),
            'prescripcion' => $peticion->request->get('prescripcion'),
            'peso' => $peticion->request->get('peso'),
            'talla' => $peticion->request->get('talla'),
            'medicamento' => $peticion->request->get('medicamento'),
            'duracion' => $peticion->request->get('duracion'),
            'porqueDuracion' => $peticion->request->get('porqueDuracion'),
            'fechaPrescripcion' => $peticion->request->get('fechaPrescripcion'),
            'iniciacion' => $peticion->request->get('iniciacion'),
            'personaNegada' => $peticion->request->get('personaNegada'),
            'fechaPrimeraDosis' => $peticion->request->get('fechaPrimeraDosis'),
            'fechaUltimaDosis' => $peticion->request->get('fechaUltimaDosis'),
            'regimenPrescrito' => $peticion->request->get('regimenPrescrito'),
            'noTabletas' => $peticion->request->get('noTabletas'),
            'noDias' => $peticion->request->get('noDias'),
            'reaccionAdversa' => $peticion->request->get('reaccionAdversa'),
            'fechaInicioReaccionAdversa' => $peticion->request->get('fechaInicioReaccionAdversa'),
            'fechaFinalReaccionAdversa' => $peticion->request->get('fechaFinalReaccionAdversa'),
            'provocoSuspension' => $peticion->request->get('provocoSuspension'),
            'provocoModificacion' => $peticion->request->get('provocoModificacion'),
            'administracion' => $peticion->request->get('administracion'),
            'noDosisSaltadas' => $peticion->request->get('noDosisSaltadas'),
            'resultado' => $peticion->request->get('resultado'),
            'causaSuspension' => $peticion->request->get('causaSuspension'),
            'fechaNotificacionTB' => $peticion->request->get('fechaNotificacionTB'),
            'noRegistro' => $peticion->request->get('noRegistro'),
            'contactoCausaNoPrescripcion' => $peticion->request->get('contactoCausaNoPrescripcion'),
        );

        $tpt  =  $em->getRepository('AppBundle:ContactoSeguimientoTPT')->masterModificarSeguimientoTPT($data, $user);
        return new Response($tpt);
    }

    /**
     * @Route("/insertEvaluacionContacto", name="insertEvaluacionContacto")
     */
    public function insertEvaluacionContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataEvaluacion = array(
            'idSeguimiento' => $peticion->request->get('idSeguimiento'),
            'mes' => $peticion->request->get('mes'),
            'fechaInicioEvaluacion' => $peticion->request->get('fechaInicioEvaluacion'),
            'examenMedico' => $peticion->request->get('examenMedico'),
            'fechaExamenMedico' => $peticion->request->get('fechaExamenMedico'),
            'sintomaRespiratorio' => $peticion->request->get('sintomaRespiratorio'),
            'pctIgraIndicado' => $peticion->request->get('pctIgraIndicado'),
            'fechaPctIgraIndicado' => $peticion->request->get('fechaPctIgraIndicado'),
            'pctIgraRealizado' => $peticion->request->get('pctIgraRealizado'),
            'fechaPctIgraRealizado' => $peticion->request->get('fechaPctIgraRealizado'),
            'porqueNoPctIgra' => $peticion->request->get('porqueNoPctIgra'),
            'resultadoPCT' => $peticion->request->get('resultadoPCT'),
            'resultadoCuantitativo' => $peticion->request->get('resultadoCuantitativo'),
            'fechaLecturaPCT' => $peticion->request->get('fechaLecturaPCT'),
            'resultadoIGRA' => $peticion->request->get('resultadoIGRA'),
            'baciloscopiaIndicado' => $peticion->request->get('baciloscopiaIndicado'),
            'fechaBaciloscopiaIndicado' => $peticion->request->get('fechaBaciloscopiaIndicado'),
            'baciloscopiaRealizado' => $peticion->request->get('baciloscopiaRealizado'),
            'fechaBaciloscopiaRealizado' => $peticion->request->get('fechaBaciloscopiaRealizado'),
            'cultivoIndicado' => $peticion->request->get('cultivoIndicado'),
            'fechaCultivoIndicado' => $peticion->request->get('fechaCultivoIndicado'),
            'cultivoRealizado' => $peticion->request->get('cultivoRealizado'),
            'fechaCultivoRealizado' => $peticion->request->get('fechaCultivoRealizado'),
            'rayosXIndicado' => $peticion->request->get('rayosXIndicado'),
            'fechaRayosXIndicado' => $peticion->request->get('fechaRayosXIndicado'),
            'rayosXRealizado' => $peticion->request->get('rayosXRealizado'),
            'fechaRayosXRealizado' => $peticion->request->get('fechaRayosXRealizado'),
            'xpertIndicado' => $peticion->request->get('xpertIndicado'),

        );

        $dataResultado = array(
            'fechaResultado' => $peticion->request->get('fechaResultado'),
            'hayResultadoBaciloscopia' => $peticion->request->get('hayResultadoBaciloscopia'),
            'fechaBaciloscopiaResultado' => $peticion->request->get('fechaBaciloscopiaResultado'),
            'resultadoBaciloscopia' => $peticion->request->get('resultadoBaciloscopia'),
            'codificacionBaciloscopia' => $peticion->request->get('codificacionBaciloscopia'),
            'hayResultadoCultivo' => $peticion->request->get('hayResultadoCultivo'),
            'fechaCultivoResultado' => $peticion->request->get('fechaCultivoResultado'),
            'resultadoCultivo' => $peticion->request->get('resultadoCultivo'),
            'codificacionCultivo' => $peticion->request->get('codificacionCultivo'),
            'hayResultadoRayosX' => $peticion->request->get('hayResultadoRayosX'),
            'fechaRayosXResultado' => $peticion->request->get('fechaRayosXResultado'),
            'resultadoRayosX' => $peticion->request->get('resultadoRayosX'),
            'rayoXLesionTB' => $peticion->request->get('rayoXLesionTB'),
            'rayoXOtraLesion' => $peticion->request->get('rayoXOtraLesion'),
            'resultadoEvaluacion' => $peticion->request->get('resultadoEvaluacion'),
            'observaciones' => $peticion->request->get('observaciones'),
            'estadoPaciente' => $peticion->request->get('estadoPaciente'),
        );

        $evaluacion  =  $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->masterAgregarSeguimientoEvaluacion($dataEvaluacion, $dataResultado, $user);

        return new Response($evaluacion);
    }

    /**
     * @Route("/updateEvaluacionContacto", name="updateEvaluacionContacto")
     */
    public function updateEvaluacionContactoAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataEvaluacion = array(
            'idEvaluacion' => $peticion->request->get('idEvaluacion'),
            'fechaInicioEvaluacion' => $peticion->request->get('fechaInicioEvaluacion'),
            'examenMedico' => $peticion->request->get('examenMedico'),
            'fechaExamenMedico' => $peticion->request->get('fechaExamenMedico'),
            'sintomaRespiratorio' => $peticion->request->get('sintomaRespiratorio'),
            'pctIgraIndicado' => $peticion->request->get('pctIgraIndicado'),
            'fechaPctIgraIndicado' => $peticion->request->get('fechaPctIgraIndicado'),
            'pctIgraRealizado' => $peticion->request->get('pctIgraRealizado'),
            'fechaPctIgraRealizado' => $peticion->request->get('fechaPctIgraRealizado'),
            'porqueNoPctIgra' => $peticion->request->get('porqueNoPctIgra'),
            'resultadoPCT' => $peticion->request->get('resultadoPCT'),
            'resultadoCuantitativo' => $peticion->request->get('resultadoCuantitativo'),
            'fechaLecturaPCT' => $peticion->request->get('fechaLecturaPCT'),
            'resultadoIGRA' => $peticion->request->get('resultadoIGRA'),
            'baciloscopiaIndicado' => $peticion->request->get('baciloscopiaIndicado'),
            'fechaBaciloscopiaIndicado' => $peticion->request->get('fechaBaciloscopiaIndicado'),
            'baciloscopiaRealizado' => $peticion->request->get('baciloscopiaRealizado'),
            'fechaBaciloscopiaRealizado' => $peticion->request->get('fechaBaciloscopiaRealizado'),
            'cultivoIndicado' => $peticion->request->get('cultivoIndicado'),
            'fechaCultivoIndicado' => $peticion->request->get('fechaCultivoIndicado'),
            'cultivoRealizado' => $peticion->request->get('cultivoRealizado'),
            'fechaCultivoRealizado' => $peticion->request->get('fechaCultivoRealizado'),
            'rayosXIndicado' => $peticion->request->get('rayosXIndicado'),
            'fechaRayosXIndicado' => $peticion->request->get('fechaRayosXIndicado'),
            'rayosXRealizado' => $peticion->request->get('rayosXRealizado'),
            'fechaRayosXRealizado' => $peticion->request->get('fechaRayosXRealizado'),
            'xpertIndicado' => $peticion->request->get('xpertIndicado'),

        );

        $dataResultado = array(
            'fechaResultado' => $peticion->request->get('fechaResultado'),
            'hayResultadoBaciloscopia' => $peticion->request->get('hayResultadoBaciloscopia'),
            'fechaBaciloscopiaResultado' => $peticion->request->get('fechaBaciloscopiaResultado'),
            'resultadoBaciloscopia' => $peticion->request->get('resultadoBaciloscopia'),
            'codificacionBaciloscopia' => $peticion->request->get('codificacionBaciloscopia'),
            'hayResultadoCultivo' => $peticion->request->get('hayResultadoCultivo'),
            'fechaCultivoResultado' => $peticion->request->get('fechaCultivoResultado'),
            'resultadoCultivo' => $peticion->request->get('resultadoCultivo'),
            'codificacionCultivo' => $peticion->request->get('codificacionCultivo'),
            'hayResultadoRayosX' => $peticion->request->get('hayResultadoRayosX'),
            'fechaRayosXResultado' => $peticion->request->get('fechaRayosXResultado'),
            'resultadoRayosX' => $peticion->request->get('resultadoRayosX'),
            'rayoXLesionTB' => $peticion->request->get('rayoXLesionTB'),
            'rayoXOtraLesion' => $peticion->request->get('rayoXOtraLesion'),
            'resultadoEvaluacion' => $peticion->request->get('resultadoEvaluacion'),
            'observaciones' => $peticion->request->get('observaciones'),
            'estadoPaciente' => $peticion->request->get('estadoPaciente'),
        );

        $evaluacion  =  $em->getRepository('AppBundle:ContactoSeguimientoEvaluacion')->masterModificarSeguimientoEvaluacion($dataEvaluacion, $dataResultado, $user);

        return new Response($evaluacion);
    }

}
