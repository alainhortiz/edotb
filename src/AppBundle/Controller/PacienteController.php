<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PacienteController extends Controller
{
    /**
     * @Route("/buscarPaciente/{carnet}", name="buscarPaciente")
     */
    public function buscarPacienteAction($carnet = null)
    {
        $ci = $carnet == null ? $_POST['ci'] : $carnet ;
        $em = $this->getDoctrine()->getManager();
        $evoluciones = $em->getRepository('AppBundle:PacienteEvolucion')->buscarPaciente($ci);
        $cant = count($evoluciones);


        if( $cant== 0)
        {
            $pacienteSintomaticoPendiente = $em->getRepository('AppBundle:PacienteSintomatico')->buscarPacientesintomaticoPendienteRegistro($ci);
            if(count($pacienteSintomaticoPendiente) != 0 ) return $this->registrarPacienteSintomaticoAction($pacienteSintomaticoPendiente[0]->getId());
            $areasSalud = $em->getRepository('AppBundle:AreaSalud')->findAll();
            $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
            $resistencias = $em->getRepository('AppBundle:Resistencia')->findAll();
            $pruebas = $em->getRepository('AppBundle:PruebaSensibilidad')->findAll();
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            $paises = $em->getRepository('AppBundle:Pais')->findAll();
            $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
            $tiposEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->findAll();
            $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Registro de Casos'));
            $xperts = $em->getRepository('AppBundle:Xpert')->findAll();
            $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();
            $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();
            $biopsias = $em->getRepository('AppBundle:Biopsia')->findAll();
            $orinas = $em->getRepository('AppBundle:Orina')->findAll();
            $salidasCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findAll();
            $pacientes = $em->getRepository('AppBundle:Paciente')->listarPacientesDBAccess();

            return $this->render('Pacientes/addPaciente.html.twig' , array(

                    'ci' => $ci,
                    'areasSalud' => $areasSalud ,
                    'provincias' => $provincias ,
                    'paises' => $paises ,
                    'pacientes' => $pacientes ,
                    'gruposVulnerable' => $gruposVulnerable,
                    'resistencias' => $resistencias,
                    'pruebas' => $pruebas,
                    'tiposEnfermo' => $tiposEnfermo,
                    'medicamentos' => $medicamentos,
                    'xperts' => $xperts,
                    'baciloscopias' => $baciloscopias,
                    'cultivos' => $cultivos,
                    'biopsias' => $biopsias,
                    'orinas' => $orinas,
                    'salidasCultivo' => $salidasCultivo,
                    'municipios' => $municipios,)
            );
        }
        else
        {
            return $this->render('Pacientes/evolucionPaciente.html.twig' , array('evoluciones' => $evoluciones , 'origen' => 'inicio' , 'ci' =>-1));
        }
    }

    /**
     * @Route("/insertPaciente", name="insertPaciente")
     */
    public function insertPacienteAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataPaciente = array(

            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
        );
        $dataDirecciones = array(
            'direccionCarnet' => $peticion->request->get('direccionCarnet'),
            'municipioCarnet' => $peticion->request->get('municipioCarnet'),
            'direccionResidencia' => $peticion->request->get('direccionResidencia'),
            'municipioResidencia' => $peticion->request->get('municipioResidencia'),
        );

        $dataBCX = array(
            'xpert' => $peticion->request->get('xpert'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'baciloscopia2' => $peticion->request->get('baciloscopia2'),
            'cultivo' => $peticion->request->get('cultivo'),
            'salidaCultivo' => $peticion->request->get('salidaCultivo'),
            'biopsia' => $peticion->request->get('biopsia'),
            'orina' => $peticion->request->get('orina'),
            'fecha' => $peticion->request->get('fechaNotificacion'),
        );
        $dataFinal = array(
            'resultadoTratamiento' => 'No evaluado',
            'fecha' =>  $peticion->request->get('fechaNotificacion'),
        );
        $fechaVIH = $peticion->request->get('fechaVIH');
        if($fechaVIH == '') $fechaVIH = '1700-01-01';
        $dataEvolucion = array(
            'telefono' => $peticion->request->get('telefono'),
            'pais' => $peticion->request->get('pais'),
            'definicionCaso' => $peticion->request->get('definicionCaso'),
            'rayosX' => $peticion->request->get('rayosX'),
            'anatomiaPatologica' => $peticion->request->get('anatomiaPatologica'),
            'localizacionAnatomica' => $peticion->request->get('localizacionAnatomica'),
            'tipoEnfermo' => $peticion->request->get('tipoEnfermo'),
            'fechaVIH' => $fechaVIH,
            'diagnosticoVIH' => $peticion->request->get('diagnosticoVIH'),
            'tARV' => $peticion->request->get('tARV'),
            'tCP' => $peticion->request->get('tCP'),
            'pruebaSensibilidad' => $peticion->request->get('pruebaSensibilidad'),
            'resistencia' => $peticion->request->get('resistencia'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'esquemasMedicamentos' => $peticion->request->get('esquemasMedicamentos'),
            'observaciones' => $peticion->request->get('observaciones'),
            'fechaNotificacion' => $peticion->request->get('fechaNotificacion'),
            'fechaDiagnostico' => $peticion->request->get('fechaDiagnostico'),
            'edad' => $peticion->request->get('edad'),
            'necro' => $peticion->request->get('necro'),
            'covit' => $peticion->request->get('covit'),
            'fechaCovit' => $peticion->request->get('fechaCovit'),
            'centroResidencia' => $peticion->request->get('centroResidencia'),
            'centroDiagnostico' => $peticion->request->get('centroDiagnostico'),
            'centroAtencion' => $peticion->request->get('centroAtencion'),
            'recluso' => $peticion->request->get('recluso') != '0' ? $peticion->request->get('recluso') : null,
        );

        if($peticion->request->get('cambiarEstado'))
        {
            $dataEvolucion['cambiarEstado'] = $peticion->request->get('cambiarEstado');
        }

        $paciente  =  $em->getRepository('AppBundle:Paciente')->masterAgregarPaciente($dataPaciente, $dataDirecciones, $dataBCX , $dataFinal , $dataEvolucion ,  $user);
        return new Response($paciente);
    }

    /**
     * @Route("/verPaciente/{ci}/{origen}", name="verPaciente")
     */
    public function verPacienteAction($ci, $origen = null)
    {
        $em = $this->getDoctrine()->getManager();
        $evoluciones = $em->getRepository('AppBundle:PacienteEvolucion')->buscarPaciente($ci);
        if(strpos($origen , 'addPaciente') === false){

           return $this->render('Pacientes/evolucionPaciente.html.twig' , array(
               'evoluciones' => $evoluciones,
               'ci' => '-1',
               'origen' => $origen)
           );
        }
        else{
            $arreglo = explode('-',$origen);
            return $this->render('Pacientes/evolucionPaciente.html.twig' , array(
                    'evoluciones' => $evoluciones,
                    'ci' => $arreglo[1],
                    'origen' => 'inicio')
            );
        }
    }

    /**
     * @Route("/actualizarPaciente/{idEvolucion}/{origen}", name="actualizarPaciente")
     */
    public function actualizarPacienteAction($idEvolucion , $origen)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $evolucion = $em->getRepository('AppBundle:PacienteEvolucion')->find($idEvolucion);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $resistencias = $em->getRepository('AppBundle:Resistencia')->findAll();
        $pruebas = $em->getRepository('AppBundle:PruebaSensibilidad')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $paises = $em->getRepository('AppBundle:Pais')->findAll();
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $tiposEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->findAll();
        $resultadosTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->findBy(array('modulo' => 'Registro de Casos'));
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Registro de Casos'));
        $xperts = $em->getRepository('AppBundle:Xpert')->findAll();
        $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();
        $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();
        $biopsias = $em->getRepository('AppBundle:Biopsia')->findAll();
        $orinas = $em->getRepository('AppBundle:Orina')->findAll();
        $salidasCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findAll();

        return $this->render('Pacientes/editPaciente.html.twig' , array(

                'evolucion' => $evolucion,
                'areasSalud' => $areasSalud ,
                'paises' => $paises ,
                'provincias' => $provincias ,
                'gruposVulnerable' => $gruposVulnerable,
                'tiposEnfermo' => $tiposEnfermo,
                'resistencias' => $resistencias,
                'pruebas' => $pruebas,
                'medicamentos' => $medicamentos,
                'resultadosTratamiento' => $resultadosTratamiento,
                'origen' => $origen,
                'xperts' => $xperts,
                'baciloscopias' => $baciloscopias,
                'cultivos' => $cultivos,
                'biopsias' => $biopsias,
                'orinas' => $orinas,
                'salidasCultivo' => $salidasCultivo,
                'municipios' => $municipios,)
        );
    }

    /**
     * @Route("/updatePaciente", name="updatePaciente")
     */
    public function updatePacienteAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dataPaciente = array(

            'idPaciente' => $peticion->request->get('idPaciente'),
            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'sexo' => $peticion->request->get('sexo'),
        );

        $dataDirecciones = array(
            'idDireccionCarnet' => $peticion->request->get('idDireccionCarnet'),
            'direccionCarnet' => $peticion->request->get('direccionCarnet'),
            'municipioCarnet' => $peticion->request->get('municipioCarnet'),
            'idDireccionResidencia' => $peticion->request->get('idDireccionResidencia'),
            'direccionResidencia' => $peticion->request->get('direccionResidencia'),
            'municipioResidencia' => $peticion->request->get('municipioResidencia'),
        );
        $fechaVIH = $peticion->request->get('fechaVIH');
        if($fechaVIH == '') $fechaVIH = '1700-01-01';

        $dataBCX = array(
            'xpert' => $peticion->request->get('xpert'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'baciloscopia2' => $peticion->request->get('baciloscopia2'),
            'cultivo' => $peticion->request->get('cultivo'),
            'salidaCultivo' => $peticion->request->get('salidaCultivo'),
            'biopsia' => $peticion->request->get('biopsia'),
            'orina' => $peticion->request->get('orina'),
            'fecha' => $peticion->request->get('fechaNotificacion'),
        );


        $dataEvolucion = array(
            'idEvolucion' => $peticion->request->get('idEvolucion'),
            'telefono' => $peticion->request->get('telefono'),
            'pais' => $peticion->request->get('pais'),
            'localizacionAnatomica' => $peticion->request->get('localizacionAnatomica'),
            'tipoEnfermo' => $peticion->request->get('tipoEnfermo'),
            'fechaVIH' => $fechaVIH,
            'diagnosticoVIH' => $peticion->request->get('diagnosticoVIH'),
            'tARV' => $peticion->request->get('tARV'),
            'tCP' => $peticion->request->get('tCP'),
            'pruebaSensibilidad' => $peticion->request->get('pruebaSensibilidad'),
            'resistencia' => $peticion->request->get('resistencia'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'esquemasMedicamentos' =>  $peticion->request->get('esquemasMedicamentos'),
            'observaciones' => $peticion->request->get('observaciones'),
            'cambiadoTratSegundaLinea' => $peticion->request->get('cambiadoTratSegundaLinea'),
            'fechaNotificacion' => $peticion->request->get('fechaNotificacion'),
            'fechaDiagnostico' => $peticion->request->get('fechaDiagnostico'),
            'resultadoTratamiento' => $peticion->request->get('resultadoTratamiento'),
            'fechaResultadoFinal' => $peticion->request->get('fechaResultadoFinal'),
            'edad' => $peticion->request->get('edad'),
            'necro' => $peticion->request->get('necro'),
            'covit' => $peticion->request->get('covit'),
            'fechaCovit' => $peticion->request->get('fechaCovit'),
            'definicionCaso' => $peticion->request->get('definicionCaso'),
            'centroResidencia' => $peticion->request->get('centroResidencia'),
            'centroDiagnostico' => $peticion->request->get('centroDiagnostico'),
            'centroAtencion' => $peticion->request->get('centroAtencion'),
            'recluso' => $peticion->request->get('recluso') != '0' ? $peticion->request->get('recluso') : null,
        );

        $paciente  =  $em->getRepository('AppBundle:Paciente')->masterModificarPaciente($dataPaciente, $dataDirecciones , $dataBCX , $dataEvolucion , $user);
        return new Response($paciente);
    }

    /**
     * @Route("/nuevaEvolucion/{ci}/{carnet}/{origen}", name="nuevaEvolucion")
     */
    public function nuevaEvolucionAction($ci , $carnet = null , $origen = null)
    {
        $em = $this->getDoctrine()->getManager();

        if($carnet != -1){
            $result = $em->getRepository('AppBundle:PacienteEvolucion')->buscarPaciente($ci);
            $evolucion = $result[0];

        }else $evolucion = $em->getRepository('AppBundle:PacienteEvolucion')->getCurrentEvolucion($ci);

        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $resistencias = $em->getRepository('AppBundle:Resistencia')->findAll();
        $pruebas = $em->getRepository('AppBundle:PruebaSensibilidad')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $paises = $em->getRepository('AppBundle:Pais')->findAll();
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $tiposEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Registro de Casos'));
        $xperts = $em->getRepository('AppBundle:Xpert')->findAll();
        $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();
        $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();
        $salidasCultivo = $em->getRepository('AppBundle:SalidaCultivo')->findAll();
        $biopsias = $em->getRepository('AppBundle:Biopsia')->findAll();
        $orinas = $em->getRepository('AppBundle:Orina')->findAll();

        return $this->render('Pacientes/nuevaEvolucion.html.twig' , array(

                'evolucion' => $evolucion,
                'origen' => $origen,
                'carnet' => $carnet,
                'areasSalud' => $areasSalud ,
                'provincias' => $provincias ,
                'paises' => $paises ,
                'gruposVulnerable' => $gruposVulnerable,
                'resistencias' => $resistencias,
                'pruebas' => $pruebas,
                'tiposEnfermo' => $tiposEnfermo,
                'medicamentos' => $medicamentos,
                'xperts' => $xperts,
                'baciloscopias' => $baciloscopias,
                'cultivos' => $cultivos,
                'salidasCultivo' => $salidasCultivo,
                'biopsias' => $biopsias,
                'orinas' => $orinas,
                'municipios' => $municipios,)
        );
    }

    /**
     * @Route("/addNuevaEvolucion", name="addNuevaEvolucion")
     */
    public function addNuevaEvolucionAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $ci = $peticion->request->get('carnetIdentidad');
        $carnet = $peticion->request->get('carnet');
        $dataDirecciones = array(
            'direccionCarnet' => $peticion->request->get('direccionCarnet'),
            'municipioCarnet' => $peticion->request->get('municipioCarnet'),
            'direccionResidencia' => $peticion->request->get('direccionResidencia'),
            'municipioResidencia' => $peticion->request->get('municipioResidencia'),
        );
        $dataBCX = array(
            'xpert' => $peticion->request->get('xpert'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'baciloscopia2' => $peticion->request->get('baciloscopia2'),
            'cultivo' => $peticion->request->get('cultivo'),
            'salidaCultivo' => $peticion->request->get('salidaCultivo'),
            'biopsia' => $peticion->request->get('biopsia'),
            'orina' => $peticion->request->get('orina'),
            'fecha' => $peticion->request->get('fechaNotificacion'),
        );
        $dataFinal = array(
            'resultadoTratamiento' => 'No evaluado',
            'fecha' =>  $peticion->request->get('fechaNotificacion'),
        );

        $fechaVIH = $peticion->request->get('fechaVIH');
        if($fechaVIH == '') $fechaVIH = '1700-01-01';

        $dataEvolucion = array(
            'telefono' => $peticion->request->get('telefono'),
            'pais' => $peticion->request->get('pais'),
            'definicionCaso' => $peticion->request->get('definicionCaso'),
            'rayosX' => $peticion->request->get('rayosX'),
            'anatomiaPatologica' => $peticion->request->get('anatomiaPatologica'),
            'localizacionAnatomica' => $peticion->request->get('localizacionAnatomica'),
            'tipoEnfermo' => $peticion->request->get('tipoEnfermo'),
            'fechaVIH' => $fechaVIH,
            'diagnosticoVIH' => $peticion->request->get('diagnosticoVIH'),
            'tARV' => $peticion->request->get('tARV'),
            'tCP' => $peticion->request->get('tCP'),
            'pruebaSensibilidad' => $peticion->request->get('pruebaSensibilidad'),
            'resistencia' => $peticion->request->get('resistencia'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
            'esquemasMedicamentos' => $peticion->request->get('esquemasMedicamentos'),
            'observaciones' => $peticion->request->get('observaciones'),
            'fechaNotificacion' => $peticion->request->get('fechaNotificacion'),
            'fechaDiagnostico' => $peticion->request->get('fechaDiagnostico'),
            'edad' => $peticion->request->get('edad'),
            'necro' => $peticion->request->get('necro'),
            'centroResidencia' => $peticion->request->get('centroResidencia'),
            'centroDiagnostico' => $peticion->request->get('centroDiagnostico'),
            'centroAtencion' => $peticion->request->get('centroAtencion'),
            'recluso' => $peticion->request->get('recluso') != '0' ? $peticion->request->get('recluso') : null,
        );

        $paciente  =  $em->getRepository('AppBundle:Paciente')->masterNuevaEvolucion($ci , $carnet, $dataDirecciones , $dataBCX , $dataFinal , $dataEvolucion ,  $user);
        return new Response($paciente);
    }

    /**
     * @Route("/continuarEvolucion/{ci}/{origen}", name="continuarEvolucion")
     */
    public function continuarEvolucionAction($ci , $origen)
    {
        $em = $this->getDoctrine()->getManager();
        $evolucion = $em->getRepository('AppBundle:PacienteEvolucion')->getCurrentEvolucion($ci);

        return $this->actualizarPacienteAction($evolucion->getId(), $origen);
    }

    /**
     * @Route("/gestionarPartesDiariosEstudioGruposVulnerables", name="gestionarPartesDiariosEstudioGruposVulnerables")
     */
    public function gestionarPartesDiariosEstudioGruposVulnerablesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $partesDiariosEstudioGruposVulnerables = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->listarPartesDiariosEstudioGruposVulnerables($user);

        return $this->render('Pacientes/gestionPartesDiariosEstudioGruposVulnerables.html.twig' , array('partesDiariosEstudioGruposVulnerables' => $partesDiariosEstudioGruposVulnerables));
    }

    /**
     * @Route("/insertParteDiarioEstudioGruposVulnerables", name="insertParteDiarioEstudioGruposVulnerables")
     */
    public function insertParteDiarioEstudioGruposVulnerablesAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'fecha' => $peticion->request->get('fecha'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'identificados' => $peticion->request->get('identificados'),
            'identificadosMenoresCinco' => $peticion->request->get('identificadosMenoresCinco'),
            'tuberculinasRealizadas' => $peticion->request->get('tuberculinasRealizadas'),
            'tuberculinasRealizadasMenoresCinco' => $peticion->request->get('tuberculinasRealizadasMenoresCinco'),
            'tuberculinasPositivas' => $peticion->request->get('tuberculinasPositivas'),
            'tuberculinasPositivasMenoresCinco' => $peticion->request->get('tuberculinasPositivasMenoresCinco'),
            'terapiaPreventivaIsoniazidaIniciadas' => $peticion->request->get('terapiaPreventivaIsoniazidaIniciadas'),
            'terapiaPreventivaIsoniazidaIniciadasMenoresCinco' => $peticion->request->get('terapiaPreventivaIsoniazidaIniciadasMenoresCinco'),
            'terapiaPreventivaIsoniazidaTerminadas' => $peticion->request->get('terapiaPreventivaIsoniazidaTerminadas'),
            'terapiaPreventivaIsoniazidaTerminadasMenoresCinco' => $peticion->request->get('terapiaPreventivaIsoniazidaTerminadasMenoresCinco'),
            'cotrimoxazolPacientesCoinfectados' => $peticion->request->get('cotrimoxazolPacientesCoinfectados'),
            'areaSalud' => $peticion->request->get('areaSalud'),
        );

        $parteDiarioEstudioGruposVulnerables = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->agregarParteDiarioEstudioGruposVulnerables($data);

        if(is_string($parteDiarioEstudioGruposVulnerables)) return new Response($parteDiarioEstudioGruposVulnerables);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Parte Diario del Estudio a Grupos Vulnerables',
                'descripcion' => 'Se insertó un nuevo parte diario para el grupo vulnerable: '.$data['grupoVulnerable']. ' de la fecha '.$data['fecha'] ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/addParteDiarioEstudioGruposVulnerables/{origen}", name="addParteDiarioEstudioGruposVulnerables")
     */
    public function addParteDiarioEstudioGruposVulnerablesAction($origen)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);


        return $this->render('Pacientes/addParteDiarioEstudioGruposVulnerables.html.twig' , array(

                'areasSalud' => $areasSalud,
                'gruposVulnerable' => $gruposVulnerable,
                'municipios' => $municipios,
                'hospitales' => $hospitales,
                'origen' => $origen,
                'provincias' => $provincias,)
        );

    }

    /**
     * @Route("/editParteDiarioEstudioGV/{idParteDiarioEstudioGV}", name="editParteDiarioEstudioGV")
     */
    public function editParteDiarioEstudioGruposVulnerablesAction($idParteDiarioEstudioGV)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $parteDiarioEstudioGruposVulnerables = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->find($idParteDiarioEstudioGV);

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Formulario editar  Parte Diario del Estudio a Grupos Vulnerables',
            'descripcion' => 'Formulario para editar el parte diario para el grupo vulnerable: '.$parteDiarioEstudioGruposVulnerables->getGrupoVulnerable()->getNumero(). ' de la fecha '.$parteDiarioEstudioGruposVulnerables->getFecha()->format('Y-m-d'),
        ));

        return $this->render('Pacientes/editParteDiarioEstudioGruposVulnerables.html.twig' , array(

                'areasSalud' => $areasSalud,
                'gruposVulnerable' => $gruposVulnerable,
                'municipios' => $municipios,
                'hospitales' => $hospitales,
                'parteDiarioEstudioGruposVulnerables' => $parteDiarioEstudioGruposVulnerables,
                'provincias' => $provincias,)
        );

    }

    /**
     * @Route("/updateParteDiarioEstudioGruposVulnerables", name="updateParteDiarioEstudioGruposVulnerables")
     */
    public function updateParteDiarioEstudioGruposVulnerablesAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idParteDiarioEstudioGV' => $peticion->request->get('idParteDiarioEstudioGV'),
            'fecha' => $peticion->request->get('fecha'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'identificados' => $peticion->request->get('identificados'),
            'identificadosMenoresCinco' => $peticion->request->get('identificadosMenoresCinco'),
            'tuberculinasRealizadas' => $peticion->request->get('tuberculinasRealizadas'),
            'tuberculinasRealizadasMenoresCinco' => $peticion->request->get('tuberculinasRealizadasMenoresCinco'),
            'tuberculinasPositivas' => $peticion->request->get('tuberculinasPositivas'),
            'tuberculinasPositivasMenoresCinco' => $peticion->request->get('tuberculinasPositivasMenoresCinco'),
            'terapiaPreventivaIsoniazidaIniciadas' => $peticion->request->get('terapiaPreventivaIsoniazidaIniciadas'),
            'terapiaPreventivaIsoniazidaIniciadasMenoresCinco' => $peticion->request->get('terapiaPreventivaIsoniazidaIniciadasMenoresCinco'),
            'terapiaPreventivaIsoniazidaTerminadas' => $peticion->request->get('terapiaPreventivaIsoniazidaTerminadas'),
            'terapiaPreventivaIsoniazidaTerminadasMenoresCinco' => $peticion->request->get('terapiaPreventivaIsoniazidaTerminadasMenoresCinco'),
            'cotrimoxazolPacientesCoinfectados' => $peticion->request->get('cotrimoxazolPacientesCoinfectados'),
            'areaSalud' => $peticion->request->get('areaSalud'),
        );

        $parteDiarioEstudioGruposVulnerables = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->modificarParteDiarioEstudioGruposVulnerables($data);

        if(is_string($parteDiarioEstudioGruposVulnerables)) return new Response($parteDiarioEstudioGruposVulnerables);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar  Parte Diario del Estudio a Grupos Vulnerables',
                'descripcion' => 'Se modificó el parte diario para el grupo vulnerable: '.$data['grupoVulnerable']. ' de la fecha '.$data['fecha'] ,
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteParteDiarioEstudioGruposVulnerables", name="deleteParteDiarioEstudioGruposVulnerables")
     */
    public function deleteParteDiarioEstudioGruposVulnerablesAction()
    {
        $peticion = Request::createFromGlobals();
        $idParteDiarioEstudioGruposVulnerables = $peticion->request->get('idParteDiarioEstudioGruposVulnerables');
        $em = $this->getDoctrine()->getManager();

        $resp  = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->eliminarParteDiarioEstudioGruposVulnerables($idParteDiarioEstudioGruposVulnerables);

        if(is_string($resp)) return new Response($resp);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Parte Diario del Estudio a Grupos Vulnerables',
                'descripcion' => 'Se eliminó el parte diario para el grupo vulnerable: '.$resp->getGrupoVulnerable()->getNumero(). ' de la fecha '.$resp->getFecha()->format('Y-m-d'),
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/reporteDiarioMensual", name="reporteDiarioMensual")
     */
    public function reporteDiarioMensualAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);


        return $this->render('Pacientes/reporteDiarioMensual.html.twig' , array(

                'areasSalud' => $areasSalud,
                'gruposVulnerable' => $gruposVulnerable,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/buscarReporteDiarioMensual", name="buscarReporteDiarioMensual")
     */
    public function buscarReporteDiarioMensualAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'mes' => $peticion->request->get('mes'),
            'anno' => $peticion->request->get('anno'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'provincia' => $peticion->request->get('provincia'),
            'municipio' => $peticion->request->get('municipio'),
            'areaSalud' => $peticion->request->get('areaSalud'),
        );

        $tablaReporteDiarioMensual = $em->getRepository('AppBundle:EstudioGrupoVulnerable')->buscarDatosReporteDiarioMensual($data);
        $diasMes = $this->cantidadDias($data['mes'],$data['anno']);

        if(is_string($tablaReporteDiarioMensual)) return new Response($tablaReporteDiarioMensual);
        else return new Response($this->renderView('Pacientes/tablaReporteDiarioMensual.html.twig', array('tablaReporteDiarioMensual' => $tablaReporteDiarioMensual ,'diasMes' => $diasMes)));
    }

    private function cantidadDias($mes,$anno)
    {
        switch ($mes){
            case 4:
            case 6:
            case 9:
            case 11: $cantidad = 30;
                break;
            case 2: $this->esBisiesto($anno) ? $cantidad = 29 : $cantidad = 28;
                break;
            default: $cantidad = 31;
                break;
        }
        return $cantidad;
    }

    private function esBisiesto($anno)
    {
        if($anno % 400 == 0) return true;
        if($anno % 100 == 0) return false;
        if($anno % 4 == 0) return true;
        return false;
    }

    /**
     * @Route("/registrarPacienteSintomatico/{idPaciente}", name="registrarPacienteSintomatico")
     */
    public function registrarPacienteSintomaticoAction($idPaciente)
    {
        $em = $this->getDoctrine()->getManager();
        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->find($idPaciente);
        $resistencias = $em->getRepository('AppBundle:Resistencia')->findAll();
        $pruebas = $em->getRepository('AppBundle:PruebaSensibilidad')->findAll();
        $tiposEnfermo = $em->getRepository('AppBundle:TipoEnfermo')->findAll();
        $medicamentos = $em->getRepository('AppBundle:MedicamentoPrimeraLinea')->findBy(array('modulo' => 'Registro de Casos'));
        $resultBaciloscopia = $em->getRepository('AppBundle:ResultBaciloscopia')->lastBaciloscopiaPositiva($idPaciente);
        $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->lastCultivoPositivo($idPaciente);
        $resultXpert = $em->getRepository('AppBundle:ResultXpert')->lastXpertPositivo($idPaciente);
        $baciloscopiaNegativa = $em->getRepository('AppBundle:Baciloscopia')->findOneBy(array('clasificacion' => '0'));
        $cultivoNegativo = $em->getRepository('AppBundle:Cultivo')->findOneBy(array('clasificacion' => '0'));
        $xpertNegativo = $em->getRepository('AppBundle:Xpert')->findOneBy(array('clasificacion' => 'N'));
        $biopsias = $em->getRepository('AppBundle:Biopsia')->findAll();
        $orinas = $em->getRepository('AppBundle:Orina')->findAll();


        return $this->render('Pacientes/registrarPacienteSintomatico.html.twig' , array(

                'paciente' => $paciente,
                'resistencias' => $resistencias,
                'pruebas' => $pruebas,
                'tiposEnfermo' => $tiposEnfermo,
                'medicamentos' => $medicamentos,
                'resultXpert' => $resultXpert,
                'resultBaciloscopia' => $resultBaciloscopia,
                'resultCultivo' => $resultCultivo,
                'baciloscopiaNegativa' => $baciloscopiaNegativa,
                'cultivoNegativo' => $cultivoNegativo,
                'biopsias' => $biopsias,
                'orinas' => $orinas,
                'xpertNegativo' => $xpertNegativo, )
        );
    }

    /**
     * @Route("/deletePaciente", name="deletePaciente")
     */
    public function deletePacienteAction()
    {
        $peticion = Request::createFromGlobals();
        $idEvolucion = $peticion->request->get('idEvolucion');
        $em = $this->getDoctrine()->getManager();

        $paciente  = $em->getRepository('AppBundle:PacienteEvolucion')->eliminarPacienteEvolucion($idEvolucion);

        if(is_string($paciente)) return new Response($paciente);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Paciente',
                'descripcion' => 'Se eliminó el paciente: '.$paciente->getNombre(). ' ' .$paciente->getPrimerApellido(). ' '.$paciente->getSegundoApellido()
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deletePacienteSinEvolucion", name="deletePacienteSinEvolucion")
     */
    public function deletePacienteSinEvolucionAction()
    {
        $peticion = Request::createFromGlobals();
        $idPaciente = $peticion->request->get('idPaciente');
        $em = $this->getDoctrine()->getManager();

        $paciente  = $em->getRepository('AppBundle:Paciente')->eliminarPacienteSinEvolucion($idPaciente);

        if(is_string($paciente)) return new Response($paciente);
        else return new Response('ok');
    }

    /**
     * @Route("/deletePacienteTransferidoBorrado", name="deletePacienteTransferidoBorrado")
     */
    public function deletePacienteTransferidoBorradoAction()
    {
        $peticion = Request::createFromGlobals();
        $idPaciente = $peticion->request->get('idPaciente');
        $em = $this->getDoctrine()->getManager();

        $paciente  = $em->getRepository('AppBundle:PacienteTransferido')->eliminarPacienteTransferidoBorrado($idPaciente);

        if(is_string($paciente)) return new Response($paciente);
        else return new Response('ok');
    }

    /**
     * @Route("/pacientesNotificadosAnno", name="pacientesNotificadosAnno")
     */
    public function pacientesNotificadosAnnoAction()
    {
        $fecha  = new \DateTime('now');
        $actual = $fecha->format('Y');
        $anno = $_POST == null ? $actual : $_POST['anno'] ;
        $em = $this->getDoctrine()->getManager();
        $semanasEstadisticas = $em->getRepository('AppBundle:SemanaEstadistica')->findAll();
        $resultadosTratamiento = $em->getRepository('AppBundle:ResultadoTratamiento')->findAll();
        $user = $this->getUser();

        $evoluciones = $em->getRepository('AppBundle:PacienteEvolucion')->listarPacientesNotificadosAnno($user , $anno);

        return $this->render('Pacientes/listadoPacientesNotificadosAnno.html.twig' , array(
            'evoluciones' => $evoluciones ,
            'semanasEstadisticas' => $semanasEstadisticas,
            'resultadosTratamiento' => $resultadosTratamiento,
            'anno' => $anno
        ));
    }

    /**
     * @Route("/buscarPacientesNotificadosAnno", name="buscarPacientesNotificadosAnno")
     */
    public function buscarPacientesNotificadosAnnoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $data = array(

            'anno' => $peticion->request->get('anno'),
            'idSemana' => $peticion->request->get('idSemana'),
            'resultadoTratamiento' => $peticion->request->get('resultadoTratamiento'),
        );

        $evoluciones = $em->getRepository('AppBundle:PacienteEvolucion')->buscarPacientesNotificadosAnno($data,$user);

        return new Response($this->renderView('Pacientes/containerPacientesNotificadosAnno.html.twig' , array(
            'evoluciones' => $evoluciones ,
        )));
    }

    /**
     * @Route("/asistenciaTratamientoPaciente/{idEvolucion}", name="asistenciaTratamientoPaciente")
     */
    public function asistenciaTratamientoPacienteAction($idEvolucion)
    {
        $em = $this->getDoctrine()->getManager();
        $evolucion = $em->getRepository('AppBundle:PacienteEvolucion')->find($idEvolucion);
        $esquemasMedicamentos = $evolucion->getEsquemasMedicamentos();
        $currentEsquema = $esquemasMedicamentos[count($esquemasMedicamentos) - 1];
        $asistencia = $em->getRepository('AppBundle:AsistenciaTratamiento')->ultimaAsistenciaTratamientoEsquema($currentEsquema->getId());
        $fechas = [];

        if($asistencia)
        {
            $fecha = $asistencia->getFecha();
            $mes = $fecha->format('m');
            $anno = $fecha->format('Y');
            $asistenciasTratamientos = $em->getRepository('AppBundle:AsistenciaTratamiento')->asistenciasTratamientosMesEsquema($mes , $anno , $asistencia->getEsquemaMedicamentos()->getId());
            foreach ($asistenciasTratamientos as $asistencia)
            {
                $fecha = $asistencia->getFecha()->format('Y-m-d');
                $fechas[] = $fecha;
            }
        }
        else{
            $asistenciasTratamientos = null;
            $mes = $currentEsquema->getFechaInicio()->format('m');
            $anno = $currentEsquema->getFechaInicio()->format('Y');
        }
        $diasMes = $this->cantidadDias($mes,$anno);
        $fechaActual = new \DateTime('now');
        $fechaTope = $fechaActual->format('Y-m-d');

        $bacFinEtapa = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->cantidadBaciloscopiaFinEtapa($idEvolucion);
        $cultFinEtapa = $em->getRepository('AppBundle:CultivoSeguimiento')->cantidadCultivoFinEtapa($idEvolucion);

        return $this->render('Pacientes/asistenciaTratamientoPaciente.html.twig' , array(

            'currentEsquema' => $currentEsquema,
            'mes' => $mes,
            'anno' =>$anno,
            'fechaTope' => $fechaTope,
            'diasMes' => $diasMes,
            'bacFinEtapa' => $bacFinEtapa,
            'cultFinEtapa' => $cultFinEtapa,
            'fechas' => $fechas)
        );
    }

    /**
     * @Route("/buscarAsistenciasTratamiento", name="buscarAsistenciasTratamiento")
     */
    public function buscarAsistenciasTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $idEsquema = $peticion->request->get('idEsquema');
        $mes = $peticion->request->get('mes');
        $anno = $peticion->request->get('anno');

        $em = $this->getDoctrine()->getManager();
        $esquema = $em->getRepository('AppBundle:EsquemaMedicamentos')->find($idEsquema);
        $fechas = [];
        $asistenciasTratamientos = $em->getRepository('AppBundle:AsistenciaTratamiento')->asistenciasTratamientosMesEsquema($mes , $anno , $esquema->getId());
        foreach ($asistenciasTratamientos as $asistencia)
        {
            $fecha = $asistencia->getFecha()->format('Y-m-d');
            $fechas[] = $fecha;
        }

        $diasMes = $this->cantidadDias($mes,$anno);
        $pos = 0 ;
        $esquemas = $esquema->getPacienteEvolucion()->getEsquemasMedicamentos();
        for($i = 0, $iMax = count($esquemas); $i < $iMax; $i++)
        {
            if($esquemas[$i]->getId() == $idEsquema) $pos = $i;
        }

        if($pos == count($esquemas) - 1)
        {
            $fechaActual = new \DateTime('now');
            $fechaTope = $fechaActual->format('Y-m-d');
        }else{
            $fechaTope = $esquemas[$pos + 1]->getFechaInicio()->modify("-1 day")->format('Y-m-d');
        }

        $idEvolucion = $esquema->getPacienteEvolucion()->getId();
        $bacFinEtapa = $em->getRepository('AppBundle:BaciloscopiaSeguimiento')->cantidadBaciloscopiaFinEtapa($idEvolucion);
        $cultFinEtapa = $em->getRepository('AppBundle:CultivoSeguimiento')->cantidadCultivoFinEtapa($idEvolucion);


        return new Response($this->renderView('Pacientes/containerCalendarioAT.html.twig' , array(

                'currentEsquema' => $esquema,
                'mes' => $mes,
                'anno' =>$anno,
                'fechaTope' => $fechaTope,
                'diasMes' => $diasMes,
                'bacFinEtapa' => $bacFinEtapa,
                'cultFinEtapa' => $cultFinEtapa,
                'fechas' => $fechas)
        ));
    }

    /**
     * @Route("/actualizarAsistenciasTratamiento", name="actualizarAsistenciasTratamiento")
     */
    public function actualizarAsistenciasTratamientoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $idEsquema = $peticion->request->get('idEsquema');
        $fechasMarcadas = $peticion->request->get('fechasMarcadas');
        $fecha = $peticion->request->get('fecha');
        $asistencias = $em->getRepository('AppBundle:AsistenciaTratamiento')->actualizarAsistenciasMes($idEsquema , $fechasMarcadas , $fecha);

        return new Response($asistencias);
    }



}
