<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LaboratorioController extends Controller
{

    /**
     * @Route("/ccbaciloscopia", name="ccbaciloscopia")
     */
    public function ccBaciloscopiaAccion()
    {
        return $this->render('Laboratorio/Control_Calidad_Baciloscopia.html.twig', array(
            'laboratorios' => $this->ListadoLaboratorios()));
    }

    /**
     * @Route("/cccultivo", name="cccultivo")
     */
    public function ccCultivoAccion()
    {
        return $this->render('Laboratorio/Control_Calidad_Cultivo.html.twig', array(
            'laboratorios' => $this->ListadoLaboratorios()));
    }

    /**
     * @Route("/susceptibiliad_paciente/{idEvolucion}", name="susceptibiliad_paciente")
     */
    public function SusceptibiliadPacienteAccion($idEvolucion)
    {
        $em = $this->getDoctrine()->getManager();

        $paciente        = $em->getRepository('AppBundle:PacienteEvolucion')->findById($idEvolucion);
        $listadoAnalisis = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->listaAnalisisRealizados($idEvolucion);

        //BUSCAR EL PACIENTE EN LA TABLA DONDE SE GUARDARAN LOS ANALISIS HECHOS DE SUSCEPTIBILIDAD
        //Y VERIFICAR SI EXISTEN ANALISIS HECHOS PARA ENVIARLOS A LISTAR

        $resistencias = $em->getRepository('AppBundle:Resistencia')->findAll();
        return $this->render('Laboratorio/Susceptibilidad_Antituberculosos.html.twig', array(
            'resistencias' => $resistencias, 'paciente' => $paciente, 'listadoAnalisis' => $listadoAnalisis));
    }

    //EL SIGUIENTE METODO SERA PARA ENVIAR A LA VISTA LOS RESULTADOS DE UN ANALISIS SELECCIONADO
    //PARA ELLO NECESITARE EL ID DEL PACIENTE EN EVOLUCION Y EL ID DEL ANALISIS SELECCIONADO
    //POR LO QUE ESTE METODO RECIBIRA 2 PARAMETROS POR URL
    //IGUAL DEBE DE DEVOLVER LOS ANALISIS HECHOS EN LABORATORIO
    //COMO LA VISTA TENDRA DATOS
    //ENVIAR UNA VARIABLE QUE IDENTIFIQUE QUE ES UN EDITAR PARA VISUALIZAR UN BOTON
    /**
     * @Route("/susceptibiliad_paciente/{idEvolucion}/{idSuscept}", name="susceptibiliad_analisis")
     */
    public function SusceptibiliadPacienteDatosAccion($idEvolucion, $idSuscept)
    {
        $em = $this->getDoctrine()->getManager();

        $paciente             = $em->getRepository('AppBundle:PacienteEvolucion')->findById($idEvolucion);
        $listadoAnalisis      = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->listaAnalisisRealizados($idEvolucion);
        $analisisSeleccionado = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->findById($idSuscept);
        $resistencias         = $em->getRepository('AppBundle:Resistencia')->findAll();

        //var_dump($analisisSeleccionado[0]->getResistencia());exit;

        $this->forward('AppBundle:Traza:insertTraza' , array(
            'operacion' => 'Laboratorio - Buscar resultados del analisis seleccionado',
            'descripcion' => 'Analisis de susceptibilidad seleccionado -'.$idSuscept
        ));

        return $this->render('Laboratorio/Susceptibilidad_Antituberculosos_Edit.html.twig', array(
            'resistencias'         => $resistencias,
            'paciente'             => $paciente,
            'listadoAnalisis'      => $listadoAnalisis,
            'analisisSeleccionado' => $analisisSeleccionado));

    }

    //EL SIGUIENTE METODO SERA EL DE GUARDAR LOS DATOS EN BD EN LA TABLA CORRESPONDIENTE
    /**
     * @Route("/insertSusceptibiliadPaciente", name="insertSusceptibiliadPaciente")
     */
    public function insertSusceptibiliadPacienteAccion()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'met_fen_nit_fh'     => $peticion->request->get('radio_nitra_H'),
            'met_fen_nit_fr'     => $peticion->request->get('radio_nitra_R'),
            'fechaFenoNitra'     => $peticion->request->get('date_metodo_nitratasa'),

            'met_fen_prop_fs'    => $peticion->request->get('radio_prop_S'),
            'fechaFenoPropFS'    => $peticion->request->get('date_metodo_proporcional_S'),

            'met_fen_prop_fe'    => $peticion->request->get('radio_prop_E'),
            'fechaFenoPropFE'    => $peticion->request->get('date_metodo_proporcional_E'),

            'met_fen_prop_fam'   => $peticion->request->get('radio_prop_AM'),
            'fechaFenoPropFAM'   => $peticion->request->get('date_metodo_proporcional_AM'),

            'met_fen_prop_fkm'   => $peticion->request->get('radio_prop_KM'),
            'fechaFenoPropFKM'   => $peticion->request->get('date_metodo_proporcional_KM'),

            'met_fen_prop_fcm'   => $peticion->request->get('radio_prop_CM'),
            'fechaFenoPropFCM'   => $peticion->request->get('date_metodo_proporcional_CM'),

            'met_fen_prop_fmfx'  => $peticion->request->get('radio_prop_MFX'),
            'fechaFenoPropFMFX'  => $peticion->request->get('date_metodo_proporcional_MFX'),

            'met_mtbdrplus_fh'   => $peticion->request->get('radio_mtbdrplus_H'),
            'met_mtbdrplus_fr'   => $peticion->request->get('radio_mtbdrplus_R'),
            'fechaMTBDRPlus'     => $peticion->request->get('date_genotype_mtbdrplus'),

            'met_mtbdrsl_ffq'    => $peticion->request->get('radio_prop_FQ'),
            'met_mtbdrsl_fagcp'  => $peticion->request->get('radio_prop_AGCP'),
            'met_mtbdrsl_fkan'   => $peticion->request->get('radio_prop_KANSL'),
            'fechaMTBDRSL'       => $peticion->request->get('date_genotype_mtbdrsl'),

            //EN EL CASO DE ESTE ID SI VIENE CON VALOR CERO ENTONCES ES UN CASO AISLADO SIN ESTUDIO DE SENSIBILIDAD
            //LO CUAL QUIERE DECIR QUE EL CHECKBOX FUE MARCADO Y POR LO TANTO LOS VALORES DE LOS RADIO BUTTONS Y
            //LOS CAMPOS FECHAS VIENEN VACIOS. (VALOR 0 LOS RADIOS Y NULL LAS FECHAS)
            'id_resistencia'     => $peticion->request->get('id_resistencia'),

            'id_resistencia_parc_nitra'      => $peticion->request->get('id_resistencia_parc_nitra'),
            'id_resistencia_parc_prop'       => $peticion->request->get('id_resistencia_parc_prop'),
            'id_resistencia_parc_mtbdrplus'  => $peticion->request->get('id_resistencia_parc_mtbdrplus'),
            'id_resistencia_parc_mtbdrsl'    => $peticion->request->get('id_resistencia_parc_mtbdrsl'),

            'id_PacienteEvol'    => $peticion->request->get('id_PacienteEvol'),
            'codigo_Muestra'     => $peticion->request->get('codigo_Muestra'),

            'observaciones'      => $peticion->request->get('observaciones'),
            'idTablaPac'         => $peticion->request->get('idTablaPac'),
        );

        $msg = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->agregarSusceptibilidadLab($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Insertar nuevo analisis de susceptibilidad',
                'descripcion' => 'Analisis de susceptibilidad insertado correctamente'
            ));
        }

        return new Response($msg);
    }

    //EL SIGUIENTE METODO SERA EL DE EDITAR LOS DATOS QUE SE HAYAN MODIFICADO
    /**
     * @Route("/updateSusceptibiliadPaciente", name="updateSusceptibiliadPaciente")
     */
    public function updateSusceptibiliadPacienteAccion()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'met_fen_nit_fh'     => $peticion->request->get('radio_nitra_H'),
            'met_fen_nit_fr'     => $peticion->request->get('radio_nitra_R'),
            'fechaFenoNitra'     => $peticion->request->get('date_metodo_nitratasa'),

            'met_fen_prop_fs'    => $peticion->request->get('radio_prop_S'),
            'fechaFenoPropFS'    => $peticion->request->get('date_metodo_proporcional_S'),

            'met_fen_prop_fe'    => $peticion->request->get('radio_prop_E'),
            'fechaFenoPropFE'    => $peticion->request->get('date_metodo_proporcional_E'),

            'met_fen_prop_fam'   => $peticion->request->get('radio_prop_AM'),
            'fechaFenoPropFAM'   => $peticion->request->get('date_metodo_proporcional_AM'),

            'met_fen_prop_fkm'   => $peticion->request->get('radio_prop_KM'),
            'fechaFenoPropFKM'   => $peticion->request->get('date_metodo_proporcional_KM'),

            'met_fen_prop_fcm'   => $peticion->request->get('radio_prop_CM'),
            'fechaFenoPropFCM'   => $peticion->request->get('date_metodo_proporcional_CM'),

            'met_fen_prop_fmfx'  => $peticion->request->get('radio_prop_MFX'),
            'fechaFenoPropFMFX'  => $peticion->request->get('date_metodo_proporcional_MFX'),

            'met_mtbdrplus_fh'   => $peticion->request->get('radio_mtbdrplus_H'),
            'met_mtbdrplus_fr'   => $peticion->request->get('radio_mtbdrplus_R'),
            'fechaMTBDRPlus'     => $peticion->request->get('date_genotype_mtbdrplus'),

            'met_mtbdrsl_ffq'    => $peticion->request->get('radio_prop_FQ'),
            'met_mtbdrsl_fagcp'  => $peticion->request->get('radio_prop_AGCP'),
            'met_mtbdrsl_fkan'   => $peticion->request->get('radio_prop_KANSL'),
            'fechaMTBDRSL'       => $peticion->request->get('date_genotype_mtbdrsl'),

            //EN EL CASO DE ESTE ID SI VIENE CON VALOR CERO ENTONCES ES UN CASO AISLADO SIN ESTUDIO DE SENSIBILIDAD
            //LO CUAL QUIERE DECIR QUE EL CHECKBOX FUE MARCADO Y POR LO TANTO LOS VALORES DE LOS RADIO BUTTONS Y
            //LOS CAMPOS FECHAS VIENEN VACIOS. (VALOR 0 LOS RADIOS Y NULL LAS FECHAS)
            'id_resistencia'     => $peticion->request->get('id_resistencia'),

            'id_resistencia_parc_nitra'      => $peticion->request->get('id_resistencia_parc_nitra'),
            'id_resistencia_parc_prop'       => $peticion->request->get('id_resistencia_parc_prop'),
            'id_resistencia_parc_mtbdrplus'  => $peticion->request->get('id_resistencia_parc_mtbdrplus'),
            'id_resistencia_parc_mtbdrsl'    => $peticion->request->get('id_resistencia_parc_mtbdrsl'),

            'id_PacienteEvol'    => $peticion->request->get('id_PacienteEvol'),
            'id_AnalisisSelect'  => $peticion->request->get('id_AnalisisSelect'),

            'observaciones'      => $peticion->request->get('observaciones'),
        );

        $msg = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->modificarSusceptibilidadLab($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Actualizar analisis de susceptibilidad',
                'descripcion' => 'Analisis de susceptibilidad actualizado con Id:'.$data['id_AnalisisSelect']
            ));
        }

        return new Response($msg);

    }

    /**
     * @Route("/insertControlCC", name="insertControlCC")
     */
    public function insertControlCCAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'b_mas_c_mas'          => $peticion->request->get('b_mas_c_mas'),
            'b_mas_c_nr'           => $peticion->request->get('b_mas_c_nr'),
            'b_menos_c_mas'        => $peticion->request->get('b_menos_c_mas'),
            'b_mas_c_menos'        => $peticion->request->get('b_mas_c_menos'),
            'b_mas_c_cont'         => $peticion->request->get('b_mas_c_cont'),
            'b_nr_c_mas'           => $peticion->request->get('b_nr_c_mas'),

            'total_lj_inoc'        => $peticion->request->get('total_lj_inoc'),
            'total_lj_cont'        => $peticion->request->get('total_lj_cont'),

            'b_mas_c_mas_diag'     => $peticion->request->get('b_mas_c_mas_diag'),
            'b_mas_c_menos_diag'   => $peticion->request->get('b_mas_c_menos_diag'),
            'b_mas_c_cont_diag'    => $peticion->request->get('b_mas_c_cont_diag'),
            'xpert_mas_c_mas_diag' => $peticion->request->get('xpert_mas_c_mas_diag'),

            'id_laboratorio'       => $peticion->request->get('id_laboratorio')
        );

        $msg = $em->getRepository('AppBundle:ControlCalidadCultivo')->agregarControlCalidadCultivo($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Insertar control de calidad del cultivo',
                'descripcion' => 'Control de calidad del cultivo insertado correctamente'
            ));
        }

        return new Response($msg);
    }

    /**
     * @Route("/updateControlCC", name="updateControlCC")
     */
    public function updateControlCCAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'b_mas_c_mas'          => $peticion->request->get('b_mas_c_mas'),
            'b_mas_c_nr'           => $peticion->request->get('b_mas_c_nr'),
            'b_menos_c_mas'        => $peticion->request->get('b_menos_c_mas'),
            'b_mas_c_menos'        => $peticion->request->get('b_mas_c_menos'),
            'b_mas_c_cont'         => $peticion->request->get('b_mas_c_cont'),
            'b_nr_c_mas'           => $peticion->request->get('b_nr_c_mas'),

            'total_lj_inoc'        => $peticion->request->get('total_lj_inoc'),
            'total_lj_cont'        => $peticion->request->get('total_lj_cont'),

            'b_mas_c_mas_diag'     => $peticion->request->get('b_mas_c_mas_diag'),
            'b_mas_c_menos_diag'   => $peticion->request->get('b_mas_c_menos_diag'),
            'b_mas_c_cont_diag'    => $peticion->request->get('b_mas_c_cont_diag'),
            'xpert_mas_c_mas_diag' => $peticion->request->get('xpert_mas_c_mas_diag'),

            'id_laboratorio'       => $peticion->request->get('id_laboratorio')
        );

        $msg = $em->getRepository('AppBundle:ControlCalidadCultivo')->modificarControlCalidadCultivo($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Actualizar control de calidad del cultivo',
                'descripcion' => 'Control de calidad del cultivo actualizado con Id: '.$data['id_laboratorio']
            ));
        }

        return new Response($msg);
    }

    /**
     * @Route("/insertControlCB", name="insertControlCB")
     */
    public function insertControlCBAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'total_muestras_eval' => $peticion->request->get('total_muestras_eval'),
            'num_positivas'       => $peticion->request->get('num_positivas'),
            'num_negativas'       => $peticion->request->get('num_negativas'),
            'falsos_positivos'    => $peticion->request->get('falsos_positivos'),
            'falsos_negativos'    => $peticion->request->get('falsos_negativos'),
            'errores_cod'         => $peticion->request->get('errores_cod'),

            'laminas_concordantes' => $peticion->request->get('laminas_concordantes'),
            'lta'                  => $peticion->request->get('lta'),
            'lca'                  => $peticion->request->get('lca'),
            'lea'                  => $peticion->request->get('lea'),
            'id_laboratorio'       => $peticion->request->get('id_laboratorio')
        );

        $msg = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->agregarControlCalidadBaciloscopia($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Insertar control de calidad de baciloscopia',
                'descripcion' => 'Insertado control de calidad de baciloscopia correctamente'
            ));
        }

        return new Response($msg);
    }

    /**
     * @Route("/updateControlCB", name="updateControlCB")
     */
    public function updateControlCBAction()
    {

        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'total_muestras_eval' => $peticion->request->get('total_muestras_eval'),
            'num_positivas'       => $peticion->request->get('num_positivas'),
            'num_negativas'       => $peticion->request->get('num_negativas'),
            'falsos_positivos'    => $peticion->request->get('falsos_positivos'),
            'falsos_negativos'    => $peticion->request->get('falsos_negativos'),
            'errores_cod'         => $peticion->request->get('errores_cod'),

            'laminas_concordantes' => $peticion->request->get('laminas_concordantes'),
            'lta'                  => $peticion->request->get('lta'),
            'lca'                  => $peticion->request->get('lca'),
            'lea'                  => $peticion->request->get('lea'),
            'id_laboratorio'       => $peticion->request->get('id_laboratorio')
        );

        $msg = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->modificarControlCalidadBaciloscopia($data);

        if((string)$msg == 'ok'){
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Laboratorio - Actualizar control de calidad de baciloscopia',
                'descripcion' => 'Control de calidad de baciloscopia actualizado el dia -'.$data['id_laboratorio']
            ));
        }

        return new Response($msg);
    }

    public function ListadoLaboratorios(){
        $em = $this->getDoctrine()->getManager();
//        $labs = $em->getRepository('AppBundle:Laboratorio')->findAll();
        $labs = $em->getRepository('AppBundle:AreaSalud')->findAll();
        return $labs;
    }

    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------

    /**
     * @Route("/buscarPacienteSintomatico", name="buscarPacienteSintomatico")
     */
    public function buscarPacienteSintomaticoAction()
    {
        $ci = $_POST['ciSintomatico'];
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $ci));

        if($paciente)
        {
            $baciloscopias = $em->getRepository('AppBundle:PacienteSintomatico')->listarBaciloscopiasPacienteSintomatico($ci);
            $cultivos = $em->getRepository('AppBundle:PacienteSintomatico')->listarCultivosPacienteSintomatico($ci);
            $xperts = $em->getRepository('AppBundle:PacienteSintomatico')->listarXpertsPacienteSintomatico($ci);
            $muestras = $em->getRepository('AppBundle:PacienteSintomatico')->listarMuestrasNoUtilesPacienteSintomatico($ci);
            $totalMuestrasNoUtiles = $em->getRepository('AppBundle:PacienteSintomatico')->totalMuestrasNoUtilesPacienteSintomatico($ci);

            return $this->render('Laboratorio/datosPacienteSintomatico.html.twig' , array(

                    'pacienteSintomatico' => $paciente,
                    'baciloscopias' => $baciloscopias ,
                    'cultivos' => $cultivos ,
                    'xperts' => $xperts,
                    'totalMuestrasNoUtiles' => $totalMuestrasNoUtiles,
                    'muestras' => $muestras,)
            );

        }else{
            $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
            $municipiosResid = $em->getRepository('AppBundle:Municipio')->findAll();
            $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            $paises = $em->getRepository('AppBundle:Pais')->findAll();
            $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
            $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);

            return $this->render('Laboratorio/addPacienteSintomatico.html.twig' , array(

                    'ci' => $ci,
                    'provincias' => $provincias ,
                    'paises' => $paises ,
                    'gruposVulnerable' => $gruposVulnerable,
                    'areasSalud' => $areasSalud ,
                    'hospitales' => $hospitales ,
                    'municipiosResid' => $municipiosResid,
                    'municipios' => $municipios,)
            );
        }
    }

    /**
     * @Route("/insertPacienteSintomatico", name="insertPacienteSintomatico")
     */
    public function insertPacienteSintomaticoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $dataDireccion = array(
            'direccion' => $peticion->request->get('direccion'),
            'municipioResid' => $peticion->request->get('municipioResid'),
        );

        $direccion = $em->getRepository('AppBundle:DireccionPaciente')->agregarDireccion($dataDireccion);

        if( is_string($direccion)) return new Response($direccion);

        $dataPaciente = array(

            'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'pais' => $peticion->request->get('pais'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'fechaEntrada' => $peticion->request->get('fechaEntrada'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->agregarPacienteSintomatico($dataPaciente , $direccion);

        if(is_string($paciente)) return new Response($paciente);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Nuevo Paciente Sintomático',
                'descripcion' => 'Se insertó  el paciente de nombre: '.$dataPaciente['nombre'].' '.$dataPaciente['primerApellido'].' '.$dataPaciente['segundoApellido'].' y carnet '.$dataPaciente['carnetIdentidad'],
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/pacientesSintomaticos", name="pacientesSintomaticos")
     */
    public function pacientesSintomaticosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $pacientes = $em->getRepository('AppBundle:PacienteSintomatico')->listarPacientesSintomaticos($user);

        return $this->render('Laboratorio/listadoPacientesSintomaticos.html.twig' , array('pacientes' => $pacientes));
    }

    /**
     * @Route("/actualizarPacienteSintomatico/{idPaciente}", name="actualizarPacienteSintomatico")
     */
    public function actualizarPacienteSintomaticoAction($idPaciente)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->find($idPaciente);
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $municipiosResid = $em->getRepository('AppBundle:Municipio')->findAll();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $paises = $em->getRepository('AppBundle:Pais')->findAll();
        $gruposVulnerable = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();

        return $this->render('Laboratorio/editPacienteSintomatico.html.twig' , array(

                'paciente' => $paciente,
                'provincias' => $provincias ,
                'paises' => $paises ,
                'gruposVulnerable' => $gruposVulnerable,
                'areasSalud' => $areasSalud ,
                'hospitales' => $hospitales ,
                'municipiosResid' => $municipiosResid,
                'municipios' => $municipios,)
        );
    }

    /**
     * @Route("/updatePacienteSintomatico", name="updatePacienteSintomatico")
     */
    public function updatePacienteSintomaticoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $dataDireccion = array(
            'idDireccion' => $peticion->request->get('idDireccion'),
            'direccion' => $peticion->request->get('direccion'),
            'municipioResid' => $peticion->request->get('municipioResid'),
        );

        $direccion = $em->getRepository('AppBundle:DireccionPaciente')->modificarDireccion($dataDireccion);


        if( is_string($direccion)) return new Response($direccion);

        $dataPaciente = array(

            'idPaciente' => $peticion->request->get('idPaciente'),
            /*'carnetIdentidad' => $peticion->request->get('carnetIdentidad'),*/
            'nombre' => $peticion->request->get('nombre'),
            'primerApellido' => $peticion->request->get('primerApellido'),
            'segundoApellido' => $peticion->request->get('segundoApellido'),
            'edad' => $peticion->request->get('edad'),
            'sexo' => $peticion->request->get('sexo'),
            'pais' => $peticion->request->get('pais'),
            'grupoVulnerable' => $peticion->request->get('grupoVulnerable'),
            'fechaEntrada' => $peticion->request->get('fechaEntrada'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->modificarPacienteSintomatico($dataPaciente);

        if(is_string($paciente)) return new Response($paciente);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Actualizar  Paciente Sintomático',
                'descripcion' => 'Se actualizó  el paciente de nombre: '.$dataPaciente['nombre'].' '.$dataPaciente['primerApellido'].' '.$dataPaciente['segundoApellido'].' y carnet '.$paciente->getCarnetIdentidad(),
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/deletePacienteSintomatico", name="deletePacienteSintomatico")
     */
    public function deletePacienteSintomaticoAction()
    {
        $peticion = Request::createFromGlobals();
        $idPaciente = $peticion->request->get('idPaciente');
        $em = $this->getDoctrine()->getManager();

        $paciente  = $em->getRepository('AppBundle:PacienteSintomatico')->eliminarPacienteSintomatico($idPaciente);

        if(is_string($paciente)) return new Response($paciente);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar  Paciente Sintomático',
                'descripcion' => 'Se eliminó  el paciente de nombre: '.$paciente->getNombre().' '.$paciente->getPrimerApellido().' '.$paciente->getSegundoApellido().' y carnet '.$paciente->getCarnetIdentidad(),
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/verPacienteSintomatico/{ci}", name="verPacienteSintomatico")
     */
    public function verPacienteSintomaticoAction($ci)
    {
        $em = $this->getDoctrine()->getManager();
        $paciente = $em->getRepository('AppBundle:PacienteSintomatico')->findOneBy(array('carnetIdentidad' => $ci));

        $baciloscopias = $em->getRepository('AppBundle:PacienteSintomatico')->listarBaciloscopiasPacienteSintomatico($ci);
        $cultivos = $em->getRepository('AppBundle:PacienteSintomatico')->listarCultivosPacienteSintomatico($ci);
        $xperts = $em->getRepository('AppBundle:PacienteSintomatico')->listarXpertsPacienteSintomatico($ci);
        $muestras = $em->getRepository('AppBundle:PacienteSintomatico')->listarMuestrasNoUtilesPacienteSintomatico($ci);
        $totalMuestrasNoUtiles = $em->getRepository('AppBundle:PacienteSintomatico')->totalMuestrasNoUtilesPacienteSintomatico($ci);

        return $this->render('Laboratorio/datosPacienteSintomatico.html.twig' , array(

                'pacienteSintomatico' => $paciente,
                'baciloscopias' => $baciloscopias ,
                'cultivos' => $cultivos ,
                'xperts' => $xperts,
                'totalMuestrasNoUtiles' => $totalMuestrasNoUtiles,
                'muestras' => $muestras,)
        );
    }

    /**
     * @Route("/pacientesSusceptHechos", name="pacientesSusceptHechos")
     */
    public function pacientesSusceptHechosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $pacientes = $em->getRepository('AppBundle:ControlSusceptibilidadLab')->obtenerListPacAnalisisRealizados($user);

        return $this->render('Laboratorio/listadoPacientesSusceptibilidadHecho.html.twig' , array('pacientes' => $pacientes));
    }

    /**
     * @Route("/addResultBaciloscopia/{ci}", name="addResultBaciloscopia")
     */
    public function addResultBaciloscopiaAction($ci)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();


        return $this->render('Laboratorio/addResultBaciloscopia.html.twig' , array(

                'ci' => $ci,
                'baciloscopias' => $baciloscopias,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );

    }

    /**
     * @Route("/insertResultBaciloscopia", name="insertResultBaciloscopia")
     */
    public function insertResultBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'ci' => $peticion->request->get('ci'),
            'fecha' => $peticion->request->get('fecha'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultBaciloscopia = $em->getRepository('AppBundle:ResultBaciloscopia')->agregarResultBaciloscopia($data);

        if(is_string($resultBaciloscopia)) return new Response($resultBaciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Análisis de Baciloscopía',
                'descripcion' => 'Se insertó una nueva baciloscopía de la fecha: '.$resultBaciloscopia->getFecha()->format('Y-m-d').' con codificación '.$resultBaciloscopia->getBaciloscopia()->getClasificacion().
                    '  al paciente  '. $resultBaciloscopia->getPacienteSintomatico()->getNombre().' '.$resultBaciloscopia->getPacienteSintomatico()->getPrimerApellido().' '.$resultBaciloscopia->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editResultBaciloscopia/{idResultBaciloscopia}", name="editResultBaciloscopia")
     */
    public function editResultBaciloscopiaAction($idResultBaciloscopia)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $resultBaciloscopia = $em->getRepository('AppBundle:ResultBaciloscopia')->find($idResultBaciloscopia);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);

        $baciloscopias = $em->getRepository('AppBundle:Baciloscopia')->findAll();


        return $this->render('Laboratorio/editResultBaciloscopia.html.twig' , array(

                'resultBaciloscopia' => $resultBaciloscopia,
                'baciloscopias' => $baciloscopias,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/updateResultBaciloscopia", name="updateResultBaciloscopia")
     */
    public function updateResultBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idResultBaciloscopia' => $peticion->request->get('idResultBaciloscopia'),
            'baciloscopia' => $peticion->request->get('baciloscopia'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultBaciloscopia = $em->getRepository('AppBundle:ResultBaciloscopia')->modificarResultBaciloscopia($data);

        if(is_string($resultBaciloscopia)) return new Response($resultBaciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Análisis de Baciloscopía',
                'descripcion' => 'Se modificó la baciloscopía de la fecha: '.$resultBaciloscopia->getFecha()->format('Y-m-d').'  del paciente  '. $resultBaciloscopia->getPacienteSintomatico()->getNombre().' '.$resultBaciloscopia->getPacienteSintomatico()->getPrimerApellido().' '.$resultBaciloscopia->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteResultBaciloscopia", name="deleteResultBaciloscopia")
     */
    public function deleteResultBaciloscopiaAction()
    {
        $peticion = Request::createFromGlobals();
        $idResultBaciloscopia = $peticion->request->get('idResultBaciloscopia');
        $em = $this->getDoctrine()->getManager();

        $resultBaciloscopia  = $em->getRepository('AppBundle:ResultBaciloscopia')->eliminarResultBaciloscopia($idResultBaciloscopia);

        if(is_string($resultBaciloscopia))  return new Response($resultBaciloscopia);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Análisis de Baciloscopía',
                'descripcion' => 'Se eliminó la baciloscopía de la fecha: '.$resultBaciloscopia->getFecha()->format('Y-m-d').' con codificación '.$resultBaciloscopia->getBaciloscopia()->getClasificacion().
                    '  del paciente  '. $resultBaciloscopia->getPacienteSintomatico()->getNombre().' '.$resultBaciloscopia->getPacienteSintomatico()->getPrimerApellido().' '.$resultBaciloscopia->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/addResultCultivo/{ci}", name="addResultCultivo")
     */
    public function addResultCultivoAction($ci)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();


        return $this->render('Laboratorio/addResultCultivo.html.twig' , array(

                'ci' => $ci,
                'cultivos' => $cultivos,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );

    }

    /**
     * @Route("/insertResultCultivo", name="insertResultCultivo")
     */
    public function insertResultCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'ci' => $peticion->request->get('ci'),
            'fecha' => $peticion->request->get('fecha'),
            'cultivo' => $peticion->request->get('cultivo'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->agregarResultCultivo($data);

        if(is_string($resultCultivo)) return new Response($resultCultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Análisis de Cultivo',
                'descripcion' => 'Se insertó un nuevo cultivo de la fecha: '.$resultCultivo->getFecha()->format('Y-m-d').' con codificación '.$resultCultivo->getCultivo()->getClasificacion().
                    '  al paciente  '. $resultCultivo->getPacienteSintomatico()->getNombre().' '.$resultCultivo->getPacienteSintomatico()->getPrimerApellido().' '.$resultCultivo->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editResultCultivo/{idResultCultivo}", name="editResultCultivo")
     */
    public function editResultCultivoAction($idResultCultivo)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->find($idResultCultivo);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $cultivos = $em->getRepository('AppBundle:Cultivo')->findAll();


        return $this->render('Laboratorio/editResultCultivo.html.twig' , array(

                'resultCultivo' => $resultCultivo,
                'cultivos' => $cultivos,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/updateResultCultivo", name="updateResultCultivo")
     */
    public function updateResultCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idResultCultivo' => $peticion->request->get('idResultCultivo'),
            'cultivo' => $peticion->request->get('cultivo'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultCultivo = $em->getRepository('AppBundle:ResultCultivo')->modificarResultCultivo($data);

        if(is_string($resultCultivo)) return new Response($resultCultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Análisis de Cultivo',
                'descripcion' => 'Se modificó el cultivo de la fecha: '.$resultCultivo->getFecha()->format('Y-m-d').'  del paciente  '. $resultCultivo->getPacienteSintomatico()->getNombre().' '.$resultCultivo->getPacienteSintomatico()->getPrimerApellido().' '.$resultCultivo->getPacienteSintomatico()->getSegundoApellido(),
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteResultCultivo", name="deleteResultCultivo")
     */
    public function deleteResultCultivoAction()
    {
        $peticion = Request::createFromGlobals();
        $idResultCultivo = $peticion->request->get('idResultCultivo');
        $em = $this->getDoctrine()->getManager();

        $resultCultivo  = $em->getRepository('AppBundle:ResultCultivo')->eliminarResultCultivo($idResultCultivo);

        if(is_string($resultCultivo))  return new Response($resultCultivo);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Análisis de Cultivo',
                'descripcion' => 'Se eliminó el cultivo de la fecha: '.$resultCultivo->getFecha()->format('Y-m-d').' con codificación '.$resultCultivo->getBaciloscopia()->getClasificacion().
                    '  del paciente  '. $resultCultivo->getPacienteSintomatico()->getNombre().' '.$resultCultivo->getPacienteSintomatico()->getPrimerApellido().' '.$resultCultivo->getPacienteSintomatico()->getSegundoApellido() ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/addResultXpert/{ci}", name="addResultXpert")
     */
    public function addResultXpertAction($ci)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $xperts = $em->getRepository('AppBundle:Xpert')->findAll();


        return $this->render('Laboratorio/addResultXpert.html.twig' , array(

                'ci' => $ci,
                'xperts' => $xperts,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/insertResultXpert", name="insertResultXpert")
     */
    public function insertResultXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'ci' => $peticion->request->get('ci'),
            'fecha' => $peticion->request->get('fecha'),
            'xpert' => $peticion->request->get('xpert'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultXpert = $em->getRepository('AppBundle:ResultXpert')->agregarResultXpert($data);

        if(is_string($resultXpert)) return new Response($resultXpert);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Insertar Análisis de Xpert',
//                'descripcion' => 'Se insertó un nuevo xpert de la fecha: '.$resultXpert->getFecha()->format('Y-m-d').' con codificación '.$resultXpert->getBaciloscopia()->getClasificacion().
                'descripcion' => 'Se insertó un nuevo xpert de la fecha: '.$resultXpert->getFecha()->format('Y-m-d').' con codificación '.$resultXpert->getXpert()->getClasificacion().
                    '  al paciente  '. $resultXpert->getPacienteSintomatico()->getNombre().' '.$resultXpert->getPacienteSintomatico()->getPrimerApellido().' '.$resultXpert->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editResultXpert/{idResultXpert}", name="editResultXpert")
     */
    public function editResultXpertAction($idResultXpert)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $resultXpert = $em->getRepository('AppBundle:ResultXpert')->find($idResultXpert);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);
        $xperts = $em->getRepository('AppBundle:Xpert')->findAll();


        return $this->render('Laboratorio/editResultXpert.html.twig' , array(

                'resultXpert' => $resultXpert,
                'xperts' => $xperts,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/updateResultXpert", name="updateResultXpert")
     */
    public function updateResultXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idResultXpert' => $peticion->request->get('idResultXpert'),
            'xpert' => $peticion->request->get('xpert'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $resultXpert = $em->getRepository('AppBundle:ResultXpert')->modificarResultXpert($data);

        if(is_string($resultXpert)) return new Response($resultXpert);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Análisis de Xpert',
                'descripcion' => 'Se modificó el xpert de la fecha: '.$resultXpert->getFecha()->format('Y-m-d').'  del paciente  '. $resultXpert->getPacienteSintomatico()->getNombre().' '.$resultXpert->getPacienteSintomatico()->getPrimerApellido().' '.$resultXpert->getPacienteSintomatico()->getSegundoApellido(),
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteResultXpert", name="deleteResultXpert")
     */
    public function deleteResultXpertAction()
    {
        $peticion = Request::createFromGlobals();
        $idResultXpert = $peticion->request->get('idResultXpert');
        $em = $this->getDoctrine()->getManager();

        $resultXpert  = $em->getRepository('AppBundle:ResultXpert')->eliminarResultXpert($idResultXpert);

        if(is_string($resultXpert))  return new Response($resultXpert);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Análisis de Xpert',
                'descripcion' => 'Se eliminó el xpert de la fecha: '.$resultXpert->getFecha()->format('Y-m-d').' con codificación '.$resultXpert->getBaciloscopia()->getClasificacion().
                    '  del paciente  '. $resultXpert->getPacienteSintomatico()->getNombre().' '.$resultXpert->getPacienteSintomatico()->getPrimerApellido().' '.$resultXpert->getPacienteSintomatico()->getSegundoApellido() ,
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/addMuestraNoUtil/{ci}", name="addMuestraNoUtil")
     */
    public function addMuestraNoUtilAction($ci)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);


        return $this->render('Laboratorio/addMuestraNoUtil.html.twig' , array(

                'ci' => $ci,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/insertMuestraNoUtil", name="insertMuestraNoUtil")
     */
    public function insertMuestraNoUtilAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'ci' => $peticion->request->get('ci'),
            'fecha' => $peticion->request->get('fecha'),
            'cantidad' => $peticion->request->get('cantidad'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $muestraNoUtil = $em->getRepository('AppBundle:MuestraNoUtil')->agregarMuestraNoUtil($data);

        if(is_string($muestraNoUtil)) return new Response($muestraNoUtil);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Agregar Muestras no Utiles',
                'descripcion' => 'Se insertaron '.$muestraNoUtil->getCantidad().'  muestras no utiles de la fecha: '.$muestraNoUtil->getFecha()->format('Y-m-d').
                    '  del paciente  '. $muestraNoUtil->getPacienteSintomatico()->getNombre().' '.$muestraNoUtil->getPacienteSintomatico()->getPrimerApellido().' '.$muestraNoUtil->getPacienteSintomatico()->getSegundoApellido(),
            ));
            return new Response('ok');
        }
    }

    /**
     * @Route("/editMuestraNoUtil/{idMuestraNoUtil}", name="editMuestraNoUtil")
     */
    public function editMuestraNoUtilAction($idMuestraNoUtil)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $muestraNoUtil = $em->getRepository('AppBundle:MuestraNoUtil')->find($idMuestraNoUtil);
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->listarMunicipios($user);
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSalud($user);
        $hospitales = $em->getRepository('AppBundle:Hospital')->listarHospitales($user);


        return $this->render('Laboratorio/editMuestraNoUtil.html.twig' , array(

                'muestraNoUtil' => $muestraNoUtil,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales ,
                'municipios' => $municipios,
                'provincias' => $provincias,)
        );
    }

    /**
     * @Route("/updateMuestraNoUtil", name="updateMuestraNoUtil")
     */
    public function updateMuestraNoUtilAction()
    {
        $peticion = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();

        $data = array(

            'idMuestraNoUtil' => $peticion->request->get('idMuestraNoUtil'),
            'fecha' => $peticion->request->get('fecha'),
            'cantidad' => $peticion->request->get('cantidad'),
            'areaSalud' => $peticion->request->get('areaSalud'),
            'hospital' => $peticion->request->get('hospital'),
        );

        $muestraNoUtil = $em->getRepository('AppBundle:MuestraNoUtil')->modificarMuestraNoUtil($data);

        if(is_string($muestraNoUtil)) return new Response($muestraNoUtil);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Modificar Muestras no Utiles',
                'descripcion' => 'Se modificaron las muestras no utiles de la fecha: '.$muestraNoUtil->getFecha()->format('Y-m-d').'  del paciente  '. $muestraNoUtil->getPacienteSintomatico()->getNombre().' '.$muestraNoUtil->getPacienteSintomatico()->getPrimerApellido().' '.$muestraNoUtil->getPacienteSintomatico()->getSegundoApellido()  ,
            ));
            return new Response('ok');
        }

    }

    /**
     * @Route("/deleteMuestraNoUtil", name="deleteMuestraNoUtil")
     */
    public function deleteMuestraNoUtilAction()
    {
        $peticion = Request::createFromGlobals();
        $idMuestraNoUtil = $peticion->request->get('idMuestraNoUtil');
        $em = $this->getDoctrine()->getManager();

        $muestraNoUtil  = $em->getRepository('AppBundle:MuestraNoUtil')->eliminarMuestraNoUtil($idMuestraNoUtil);

        if(is_string($muestraNoUtil))  return new Response($muestraNoUtil);
        else{
            $this->forward('AppBundle:Traza:insertTraza' , array(
                'operacion' => 'Eliminar Muestras no Utiles',
                'descripcion' => 'Se eliminaron '.$muestraNoUtil->getCantidad().'  muestras no utiles de la fecha: '.$muestraNoUtil->getFecha()->format('Y-m-d').
                    '  del paciente  '. $muestraNoUtil->getPacienteSintomatico()->getNombre().' '.$muestraNoUtil->getPacienteSintomatico()->getPrimerApellido().' '.$muestraNoUtil->getPacienteSintomatico()->getSegundoApellido(),
            ));
            return new Response('ok');
        }
    }

}