<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use AppBundle\ImprimirExcel;

class ReporteController extends Controller
{

    /**
     * @Route("/reporteMod46203", name="reporteMod46203")
     */
    public function reporteMod46203Action()
    {
        $peticion = Request::createFromGlobals();

        $trim        = $peticion->request->get('trimestre');
        $anno        = $peticion->request->get('anno');
        $idAreaSalud = $peticion->request->get('idAreaSalud');
        $idHospital  = $peticion->request->get('idHospital');
        $idProvincia = $peticion->request->get('idProvincia');
        $idMunicipio = $peticion->request->get('idMunicipio');
        $vih = $peticion->request->get('vih');


        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();
        $areasSalud = $em->getRepository('AppBundle:AreaSalud')->findAll();
        $hospitales = $em->getRepository('AppBundle:Hospital')->findAll();

        if(empty($trim))
        {
            $pacientes = $this->ReporteInicial();
            return $this->render('Reportes/reporteMod46203.html.twig', array(
                'pacientes'  => $pacientes,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales
            ));
        }
        else
        {
            $pacientes = $this->ReporteTrimestreSeleccionado($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
            return $this->render('Reportes/reporteMod46203Replace.html.twig', array('pacientes' => $pacientes));
        }

    }

    /**
     * @Route("/reporteMod49004", name="reporteMod49004")
     */
    public function reporteMod49004Action()
    {
        $peticion = Request::createFromGlobals();

        $trim        = $peticion->request->get('trimestre');
        $anno        = $peticion->request->get('anno');
        $idAreaSalud = $peticion->request->get('idAreaSalud');
        $idProvincia = $peticion->request->get('idProvincia');
        $idMunicipio = $peticion->request->get('idMunicipio');


        $em = $this->getDoctrine()->getManager();
        $provincias  = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios  = $em->getRepository('AppBundle:Municipio')->findAll();
        $areasSalud  = $em->getRepository('AppBundle:AreaSalud')->findAll();

        return $this->render('Reportes/reporteMod49004.html.twig', array('provincias' => $provincias, 'municipios' => $municipios, 'areasSalud' => $areasSalud));

    }

    //-----------BLOQUE CASOS NUEVOS-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE LOS CASOS NUEVOS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-PULMONAR-Bacteriologicamente confirmado
    public function CNT_Pulmonar_BC($trimestre=1, $anno = '', $idAreaSalud = '', $idProvincia = '', $idMunicipio = '', $idHospital = '', $vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }

        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-PULMONAR-Clínicamente diagnosticado
    public function CNT_Pulmonar_CD($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '', $vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Bacteriologicamente confirmado
    public function CNT_EPulmonar_BC($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Clínicamente diagnosticado
    public function CNT_EPulmonar_CD($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' , $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------RECAÍDA DE TUBERCULOSIS-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE RECAÍDA DE TUBERCULOSIS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-PULMONAR-Bacteriologicamente confirmado
    public function RT_Pulmonar_BC($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-PULMONAR-Clínicamente diagnosticado
    public function RT_Pulmonar_CD($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Bacteriologicamente confirmado
    public function RT_EPulmonar_BC($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Clínicamente diagnosticado
    public function RT_EPulmonar_CD($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------BLOQUE CASO PREVIAMENTE TRATADO-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE LOS CASO PREVIAMENTE TRATADO EN 1ER TRIMESTRE
    //REPORTE: Fracaso terapeútico
    public function FRACASO_T($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 3 AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();


        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASO PREVIAMENTE TRATADO EN 1ER TRIMESTRE
    //REPORTE: Perdida al seguimiento
    public function PERDIDA_T($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 4 AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------BLOQUE TOTAL TRIMESTRE-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DEL TOTAL EN 1ER TRIMESTRE
    public function TOTAL_TRIMESTRE($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR'";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    /*******************************************************************************************/
    /*******************************************************************************************/
    /*******************************************************************************************/

    //-----------BLOQUE CASOS NUEVOS ACUMULADO-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE LOS CASOS NUEVOS  ACUMULADO
    //REPORTE: CASOS NUEVOS-PULMONAR-Bacteriologicamente confirmado
    public function CNA_Pulmonar_BC($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS  ACUMULADO
    //REPORTE: CASOS NUEVOS-PULMONAR-Clínicamente diagnosticado
    public function CNA_Pulmonar_CD($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS  ACUMULADO
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Bacteriologicamente confirmado
    public function CNA_EPulmonar_BC($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASOS NUEVOS  ACUMULADO
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Clínicamente diagnosticado
    public function CNA_EPulmonar_CD($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------RECAÍDA DE TUBERCULOSIS-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE RECAÍDA DE TUBERCULOSIS  ACUMULADO
    //REPORTE: CASOS NUEVOS-PULMONAR-Bacteriologicamente confirmado
    public function RTA_Pulmonar_BC($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $em = $this->getDoctrine()->getManager();

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS  ACUMULADO
    //REPORTE: CASOS NUEVOS-PULMONAR-Clínicamente diagnosticado
    public function RTA_Pulmonar_CD($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS  ACUMULADO
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Bacteriologicamente confirmado
    public function RTA_EPulmonar_BC($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Bacteriológicamente confirmado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE RECAÍDA DE TUBERCULOSIS  ACUMULADO
    //REPORTE: CASOS NUEVOS-EXTRAPULMONAR-Clínicamente diagnosticado
    public function RTA_EPulmonar_CD($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Extrapulmonar' AND m.definicionCaso = 'Clínicamente diagnosticado' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------BLOQUE CASO PREVIAMENTE TRATADO-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE LOS CASO PREVIAMENTE TRATADO  ACUMULADO
    //REPORTE: Fracaso terapeútico
    public function FRACASO_A($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 3 AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    //REPORTES DE LOS CASO PREVIAMENTE TRATADO  ACUMULADO
    //REPORTE: Perdida al seguimiento
    public function PERDIDA_A($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE m.tipoEnfermo = 4 AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-----------BLOQUE TOTAL TRIMESTRE-------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DEL TOTAL  ACUMULADO
    public function TOTAL_ACUMULADO($trimestre=1 , $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '', $idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";
        $dql_9 = "";
        $dql_10 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_7 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_7 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_9 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR'";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1.$dql_2.$dql_4.$dql_6.$dql_7.$dql_8.$dql_9.$dql_10.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 1 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 2 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 4 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 3 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 5 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3.$dql_2.$dql_4.$dql_5." 6 ".$dql_6.$dql_7.$dql_8.$dql_9.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------
    //-----------BLOQUE NEGATIVO POSITIVO DESCONOCIDO--------------------------------------------
    //-------------------------------------------------------------------------------------------
    public function TOTAL_NEG_POS_DESC_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres
                  JOIN m.baciloscopiaSeguimientos bseg JOIN bseg.baciloscopia bac ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7 AND bseg.categoria = 'Segundo Mes (Fin Primera fase)' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR'";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        //NEGATIVO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        //POSITIVO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        //DESCONOCIDO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        //NEGATIVO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND  bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();


        //POSITIVO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        //DESCONOCIDO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        //NEGATIVO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND  bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();


        //POSITIVO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        //DESCONOCIDO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1],$casilla_8[0][1],$casilla_9[0][1]) ;
    }

    public function TOTAL_NEG_POS_DESC_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres
                  JOIN m.baciloscopiaSeguimientos bseg JOIN bseg.baciloscopia bac";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7 AND bseg.categoria = 'Segundo Mes (Fin Primera fase)' AND mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR'";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        //NEGATIVO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        //POSITIVO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        //DESCONOCIDO CASO NUEVO
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 1 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        //NEGATIVO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();


        //POSITIVO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        //DESCONOCIDO RECAIDA
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo = 2 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        //NEGATIVO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();


        //POSITIVO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 1 AND bac.id < 11
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        //DESCONOCIDO TOTAL
        $dql = $dql_1.$dql_2." WHERE m.tipoEnfermo > 0 AND m.tipoEnfermo < 3 AND m.localizacionAnatomica = 'Pulmonar' AND 
                m.definicionCaso = 'Bacteriológicamente confirmado' AND bac.id > 10
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1],$casilla_8[0][1],$casilla_9[0][1]) ;
    }


    //-----------BLOQUE COHORTE DE TRATATAMIENTO DE TB-MDR---------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DE LOS CASOS NUEVOS EN 1ER TRIMESTRE
    //REPORTE: CASOS NUEVOS-PULMONAR-Bacteriologicamente confirmado
    public function COHORTE_MDR_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestre($trimestre, $year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ".$dql_2."
        WHERE rr.id = 2 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE  rr.id = 2 AND rt.id = 1 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 2 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 4 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 3 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 5 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 6 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_XDR_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestre($trimestre, $year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 4 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 1 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 2 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 4 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 3 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 5 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 6 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_RR_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestre($trimestre, $year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 1 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 1 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 2 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 4 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 3 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 5 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 6 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_MR_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestre($trimestre, $year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 3 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 1 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 2 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 4 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 3 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 5 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 6 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_DR_TRIM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestre($trimestre, $year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 7 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 1 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 2 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 4 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 3 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 5 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 6 AND rf.ultimo = 1
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_MDR_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ".$dql_2."
        WHERE rr.id = 2 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE  rr.id = 2 AND rt.id = 1 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 2 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 4 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 3 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 5 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 2 AND rt.id = 6 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_XDR_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 4 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 1 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 2 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 4 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 3 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 5 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 4 AND rt.id = 6 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_RR_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 1 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 1 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 2 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 4 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 3 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 5 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 1 AND rt.id = 6 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_MR_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 3 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 1 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 2 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 4 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 3 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 5 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 3 AND rt.id = 6 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function COHORTE_DR_ACUM($trimestre=1, $anno = '', $idAreaSalud = '',$idProvincia = '',$idMunicipio = '' ,$idHospital = '',$vih = 0){

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year = $fechaActual->modify('-1 year')->format('Y');

        }else $year = $anno -1;

        $rangoFecha = $this->RangoTrimestreAcumulado($trimestre,$year);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr ";
        $dql_2 = "";
        $dql_3 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = " AND rf.ultimo = 1 AND rt.id != 7";
        $dql_11 = "";

        if($vih == 1) $dql_11 = " AND m.resultadoVIH  = 'positivo'";

        if($idAreaSalud > 0)
        {
            $dql_3 = " AND aa.id = $idAreaSalud";
        }
        //cambios para usar los hospitales inicio
        if($idHospital > 0)
        {
            $dql_3 = " AND h.id = $idHospital";
        }
        if($idProvincia > 0 && $idProvincia != '')
        {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_4 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }
        if($idMunicipio > 0 && $idMunicipio != '')
        {
            $dql_5 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
        }
        //cambios para usar los hospitales fin

        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia rr".$dql_2."
                WHERE rr.id = 7 
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_6.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 1 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 2 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 4 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 3 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 5 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1.$dql_2." WHERE rr.id = 7 AND rt.id = 6 AND rf.ultimo = 1 AND rt.id != 7
                AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ".$dql_3.$dql_4.$dql_5.$dql_11;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        return array($casilla_1[0][1],$casilla_2[0][1],$casilla_3[0][1],$casilla_4[0][1],$casilla_5[0][1],$casilla_6[0][1],$casilla_7[0][1]) ;
    }

    public function ReporteInicial()
    {
        $pacientes[0] = $this->CNT_Pulmonar_BC();
        $pacientes[1] = $this->CNT_Pulmonar_CD();
        $pacientes[2] = $this->CNT_EPulmonar_BC();
        $pacientes[3] = $this->CNT_EPulmonar_CD();

        $pacientes[4] = $this->RT_Pulmonar_BC();
        $pacientes[5] = $this->RT_Pulmonar_CD();
        $pacientes[6] = $this->RT_EPulmonar_BC();
        $pacientes[7] = $this->RT_EPulmonar_CD();

        $pacientes[8] = $this->FRACASO_T();
        $pacientes[9] = $this->PERDIDA_T();

        $pacientes[10] = $this->TOTAL_TRIMESTRE();

        $pacientes[11] = $this->CNA_Pulmonar_BC();
        $pacientes[12] = $this->CNA_Pulmonar_CD();
        $pacientes[13] = $this->CNA_EPulmonar_BC();
        $pacientes[14] = $this->CNA_EPulmonar_CD();

        $pacientes[15] = $this->RTA_Pulmonar_BC();
        $pacientes[16] = $this->RTA_Pulmonar_CD();
        $pacientes[17] = $this->RTA_EPulmonar_BC();
        $pacientes[18] = $this->RTA_EPulmonar_CD();

        $pacientes[19] = $this->FRACASO_A();
        $pacientes[20] = $this->PERDIDA_A();

        $pacientes[21] = $this->TOTAL_ACUMULADO();

        $pacientes[22] = $this->TOTAL_NEG_POS_DESC_TRIM();
        $pacientes[23] = $this->TOTAL_NEG_POS_DESC_ACUM();

        //comienza la parte de resistentes
        $pacientes[24] = $this->COHORTE_MDR_TRIM();
        $pacientes[25] = $this->COHORTE_XDR_TRIM();
        $pacientes[26] = $this->COHORTE_RR_TRIM();
        $pacientes[27] = $this->COHORTE_MR_TRIM();
        $pacientes[28] = $this->COHORTE_DR_TRIM();

        $pacientes[29] = $this->COHORTE_MDR_ACUM();
        $pacientes[30] = $this->COHORTE_XDR_ACUM();
        $pacientes[31] = $this->COHORTE_RR_ACUM();
        $pacientes[32] = $this->COHORTE_MR_ACUM();
        $pacientes[33] = $this->COHORTE_DR_ACUM();

        return $pacientes;
    }

    public function ReporteTrimestreSeleccionado($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih)
    {
        $pacientes[0] = $this->CNT_Pulmonar_BC($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[1] = $this->CNT_Pulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[2] = $this->CNT_EPulmonar_BC($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[3] = $this->CNT_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[4] = $this->RT_Pulmonar_BC($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[5] = $this->RT_Pulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[6] = $this->RT_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[7] = $this->RT_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[8] = $this->FRACASO_T($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[9] = $this->PERDIDA_T($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[10] = $this->TOTAL_TRIMESTRE($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[11] = $this->CNA_Pulmonar_BC($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[12] = $this->CNA_Pulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[13] = $this->CNA_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[14] = $this->CNA_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[15] = $this->RTA_Pulmonar_BC($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[16] = $this->RTA_Pulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[17] = $this->RTA_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[18] = $this->RTA_EPulmonar_CD($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[19] = $this->FRACASO_A($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[20] = $this->PERDIDA_A($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[21] = $this->TOTAL_ACUMULADO($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[22] = $this->TOTAL_NEG_POS_DESC_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[23] = $this->TOTAL_NEG_POS_DESC_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        //comienza la parte de resistentes
        $pacientes[24] = $this->COHORTE_MDR_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[25] = $this->COHORTE_XDR_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[26] = $this->COHORTE_RR_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[27] = $this->COHORTE_MR_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[28] = $this->COHORTE_DR_TRIM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $pacientes[29] = $this->COHORTE_MDR_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[30] = $this->COHORTE_XDR_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[31] = $this->COHORTE_RR_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[32] = $this->COHORTE_MR_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);
        $pacientes[33] = $this->COHORTE_DR_ACUM($trim,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        return $pacientes;
    }


    public function RangoTrimestre($trimestre,$anno)
    {

        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year =  $fechaActual->format('Y');
        }
        else $year = $anno;

        if($trimestre==1)
            return array("'".$year.'-01-01'."'","'".$year.'-03-31'."'");

        if($trimestre==2)
            return array("'".$year.'-04-01'."'","'".$year.'-06-30'."'");

        if($trimestre==3)
            return array("'".$year.'-07-01'."'","'".$year.'-09-30'."'");

        if($trimestre==4)
            return array("'".$year.'-10-01'."'","'".$year.'-12-31'."'");

        //LOS SIGUIENTES DOS CASOS AUNQUE SERAN TRATADOS COMO 2 TRIMESTRES MAS
        //SON PARA ESCOGER LOS SEMESTRES O EL ANNO COMPLETO PARA EL REPORTE
        //DE LOS APORTES DEL CULTIVO
        if($trimestre==5)
            return array("'".$year.'-01-01'."'","'".$year.'-06-30'."'");//PRIMER SEMESTRE

        if($trimestre==6)
            return array("'".$year.'-07-01'."'","'".$year.'-12-31'."'");//SEGUNDO SEMESTRE

        if($trimestre==7)
            return array("'".$year.'-01-01'."'","'".$year.'-12-31'."'");//Año COMPLETO
    }

    public function AnnoActual($anno)
    {
        $fechaActual = new \DateTime('now');

        if(empty($anno))
            $year =  $fechaActual->format('Y');
        else
            $year = $anno;

        return array("'".$year.'-01-01'."'","'".$year.'-12-31'."'");
    }

    public function RangoTrimestreAcumulado($trimestre,$anno)
    {
        if(empty($anno))
        {
            $fechaActual = new \DateTime('now');
            $year =  $fechaActual->format('Y');
        }
        else $year = $anno;

        if($trimestre==1)
            return array("'".$year.'-01-01'."'","'".$year.'-03-31'."'");

        if($trimestre==2)
            return array("'".$year.'-01-01'."'","'".$year.'-06-30'."'");

        if($trimestre==3)
            return array("'".$year.'-01-01'."'","'".$year.'-09-30'."'");

        if($trimestre==4)
            return array("'".$year.'-01-01'."'","'".$year.'-12-31'."'");

    }


    //-----------BLOQUE IMPRIMIR-----------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTES DEL MODELO 46203
    /**
     * @Route("/impExcelModelo46203/{trimestre}/{anno}/{idAreaSalud}/{idProvincia}/{idMunicipio}/{idHospital}/{vih}", name="impExcelModelo46203")
     */
    public function impExcelModelo46203Action($trimestre,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih)
    {
        $em = $this->getDoctrine()->getManager();

        $nomAreaSalud = "REPORTE GENERAL";
        $provAreaSalud = "TODAS";
        $municAreaSalud = "TODOS";
        $codAreaSalud = "---";
        $codProv = "---";
        $codMunic = "---";

        if($idProvincia > 0){
            $provincia  = $em->getRepository('AppBundle:Provincia')->findById($idProvincia);
            $provAreaSalud  = $provincia[0]->getNombre();
            $codProv = $provincia[0]->getCodigo();
        }

        if($idMunicipio > 0){
            $municipio      = $em->getRepository('AppBundle:Municipio')->findById($idMunicipio);
            $provAreaSalud  = $municipio[0]->getProvincia()->getNombre();
            $municAreaSalud = $municipio[0]->getNombre();
            $codProv = $municipio[0]->getProvincia()->getCodigo();
            $codMunic = $municipio[0]->getCodigo();
        }

        if($idAreaSalud > 0)
        {
            $areaSalud  = $em->getRepository('AppBundle:AreaSalud')->findById($idAreaSalud);
            $nomAreaSalud = $areaSalud[0]->getNombre();
            $codAreaSalud = $areaSalud[0]->getCodigo();
        }
        if($idHospital > 0)
        {
            $hospital  = $em->getRepository('AppBundle:Hospital')->findById($idHospital);
            $nomAreaSalud = $hospital[0]->getNombre();
            $codAreaSalud = $hospital[0]->getCodigoCompleto();
        }

        $datos = $this->ReporteTrimestreSeleccionado($trimestre,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital,$vih);

        $imp_mes_grl = new ImprimirExcel\ImpMod46203();
        $imp_mes_grl->DatosPDF($datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic,$vih);
    }

    //REPORTES DEL MODELO 49004
    /**
     * @Route("/impExcelModelo49004/{trimestre}/{anno}/{idAreaSalud}/{idProvincia}/{idMunicipio}/{idHospital}", name="impExcelModelo49004")
     */
    public function impExcelModelo49004Action($trimestre,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital)
    {
        $em = $this->getDoctrine()->getManager();

        $nomAreaSalud = "REPORTE GENERAL";
        $provAreaSalud = "TODAS";
        $municAreaSalud = "TODOS";
        $codAreaSalud = "---";
        $codProv = "---";
        $codMunic = "---";

        if($idProvincia > 0){
            $provincia  = $em->getRepository('AppBundle:Provincia')->findById($idProvincia);
            $provAreaSalud  = $provincia[0]->getNombre();
            $codProv = $provincia[0]->getCodigo();
        }

        if($idMunicipio > 0){
            $municipio      = $em->getRepository('AppBundle:Municipio')->findById($idMunicipio);
            $provAreaSalud  = $municipio[0]->getProvincia()->getNombre();
            $municAreaSalud = $municipio[0]->getNombre();
            $codProv = $municipio[0]->getProvincia()->getCodigo();
            $codMunic = $municipio[0]->getCodigo();
        }

        if($idAreaSalud > 0)
        {
            $areaSalud  = $em->getRepository('AppBundle:AreaSalud')->findById($idAreaSalud);
            $nomAreaSalud = $areaSalud[0]->getNombre();
            $codAreaSalud = $areaSalud[0]->getCodigo();
        }
        if($idHospital > 0)
        {
            $hospital  = $em->getRepository('AppBundle:Hospital')->findById($idHospital);
            $nomAreaSalud = $hospital[0]->getNombre();
            $codAreaSalud = $hospital[0]->getCodigoCompleto();
        }

        $datos = $this->ReporteTrimestreSeleccionado($trimestre,$anno,$idAreaSalud,$idProvincia,$idMunicipio,$idHospital);

        $imp_mes_grl = new ImprimirExcel\ImpMod49004();
        $imp_mes_grl->DatosPDF($datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic);
    }

    //REPORTES DEL MODELO CALIDAD DE CULTIVO y BACILOSCOPIA
    /**
     * @Route("/impExcelCalidadCultivo/{idLab}/{anno}/{mes}/{trimestre}/{provincia}/{municipio}", name="impExcelCalidadCultivo")
     */
    public function impExcelCalidadCultivoAction($idLab, $anno, $mes, $trimestre, $provincia, $municipio)
    {
        $datos = $this->reporteCalidadCultivoExcel($idLab,$anno,$mes,$trimestre,$provincia,$municipio);

        $imp_cc = new ImprimirExcel\ImpCalidadCultivo();
        $imp_cc->DatosPDF($datos);
    }

    /**
     * @Route("/impExcelCalidadBaciloscopia/{idLab}/{anno}/{mes}/{trimestre}/{provincia}/{municipio}", name="impExcelCalidadBaciloscopia")
     */
    public function impExcelCalidadBaciloscopiaAction($idLab, $anno, $mes, $trimestre, $provincia, $municipio)
    {
        $datos = $this->reporteCalidadBaciloscopiaExcel($idLab,$anno,$mes,$trimestre,$provincia,$municipio);

        $imp_cc = new ImprimirExcel\ImpCalidadBaciloscopia();
        $imp_cc->DatosPDF($datos);
    }


    //-----------BLOQUE LABORATORIO--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //REPORTE DE CONTROL CALIDAD CULTIVO
    /**
     * @Route("/reporteCalidadCultivo", name="reporteCalidadCultivo")
     */
    public function reporteCalidadCultivoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $municipios   = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias   = $em->getRepository('AppBundle:Provincia')->findAll();
        $laboratorios = $this->ListadoLaboratorios();

        return $this->render('Reportes/reporteControlCalidadCultivo.html.twig', array(
            'laboratorios'  => $laboratorios,
            'municipios'    => $municipios,
            'provincias'    => $provincias
        ));

    }

    /**
     * @Route("/reporteCalidadCultivoJson", name="reporteCalidadCultivoJson")
     */
    public function reporteCalidadCultivoJsonAction()
    {
        $peticion = Request::createFromGlobals();

        $em = $this->getDoctrine()->getManager();

        $id_lab       = $peticion->request->get('id_lab');
        $id_mes       = $peticion->request->get('id_mes');
        $id_anno      = $peticion->request->get('id_anno');
        $id_trimestre = $peticion->request->get('id_trimestre');
        $id_provincia = $peticion->request->get('id_provincia');
        $id_municipio = $peticion->request->get('id_municipio');

        $respuesta = $em->getRepository('AppBundle:ControlCalidadCultivo')->reporteControlCalidadCultivoJson($id_lab, $id_mes, $id_anno, $id_trimestre, $id_provincia, $id_municipio);

        $resp = json_encode($respuesta);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($resp);

        return $respuesta;

    }

    //REPORTE DE CONTROL CALIDAD BACILOSCOPIA
    /**
     * @Route("/reporteCalidadBaciloscopia", name="reporteCalidadBaciloscopia")
     */
    public function reporteCalidadBaciloscopiaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $municipios   = $em->getRepository('AppBundle:Municipio')->findAll();
        $provincias   = $em->getRepository('AppBundle:Provincia')->findAll();
        $laboratorios = $this->ListadoLaboratorios();

        return $this->render('Reportes/reporteControlCalidadBaciloscopia.html.twig', array(
            'laboratorios' => $laboratorios,
            'municipios'   => $municipios,
            'provincias'   => $provincias
        ));

    }

    /**
     * @Route("/reporteCalidadBaciloscopiaJson", name="reporteCalidadBaciloscopiaJson")
     */
    public function reporteCalidadBaciloscopiaJsonAction()
    {
        $peticion = Request::createFromGlobals();

        $em = $this->getDoctrine()->getManager();

        $id_lab       = $peticion->request->get('id_lab');
        $id_mes       = $peticion->request->get('id_mes');
        $id_anno      = $peticion->request->get('id_anno');
        $id_trimestre = $peticion->request->get('id_trimestre');
        $id_provincia = $peticion->request->get('id_provincia');
        $id_municipio = $peticion->request->get('id_municipio');

        $respuesta = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->reporteControlCalidadBaciloscopiaJson($id_lab, $id_mes, $id_anno, $id_trimestre, $id_provincia, $id_municipio);

        $resp = json_encode($respuesta);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($resp);

        return $respuesta;
    }


    public function reporteCalidadCultivoExcel($idLab, $anno, $mes, $trimestre, $provincia, $municipio)
    {
        $em = $this->getDoctrine()->getManager();
        $respuesta = $em->getRepository('AppBundle:ControlCalidadCultivo')->reporteControlCalidadCultivoExcel($idLab, $mes, $anno, $trimestre, $provincia, $municipio);

        return $respuesta;
    }

    public function reporteCalidadBaciloscopiaExcel($idLab, $anno, $mes, $trimestre, $provincia, $municipio)
    {
        $em = $this->getDoctrine()->getManager();
        $respuesta = $em->getRepository('AppBundle:ControlCalidadBaciloscopia')->reporteControlCalidadBaciloscopiaExcel($idLab, $mes, $anno, $trimestre, $provincia, $municipio);

        return $respuesta;
    }

    //REPORTE APORTE DEL CULTIVO
    /**
     * @Route("/reporteAporteTBPulmonar", name="reporteAporteTBPulmonar")
     */
    public function reporteAporteTBPulmonarAction()
    {
        return $this->render('Reportes/reporteAporteTBPulmonar.html.twig', array(
        ));
    }

    /**
     * @Route("/reporteAporteTBPulmonarCalc", name="reporteAporteTBPulmonarCalc")
     */
    public function reporteAporteTBPulmonarCalcAction()
    {
        $peticion = Request::createFromGlobals();

        $anno         = $peticion->request->get('id_anno');
        $id_periodo   = $peticion->request->get('id_periodo');
        $id_radioCaso = $peticion->request->get('id_radioCaso');

        if($id_periodo == 0)
            $id_periodo = 7; //Anno completo

        if($id_radioCaso == 1) //En relación a la BACILOSCOPIA
            $respuesta = $this->CantidadCasosAporteCultivoBaciloscopia($anno, $id_periodo);
        else  //En relación a XPERT MTB/RIF
            $respuesta = $this->CantidadCasosAporteCultivoXpert($anno, $id_periodo);

        $resp = json_encode($respuesta);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($resp);

        return $respuesta;

    }

    public function ListadoLaboratorios(){
        $em = $this->getDoctrine()->getManager();
//        $labs = $em->getRepository('AppBundle:Laboratorio')->findAll();
        $labs = $em->getRepository('AppBundle:AreaSalud')->findAll();
        return $labs;
    }

    //Aporte del cultivo al diagnóstico de casos de TB pulmonar (en relación a la baciloscopia)
    public function CantidadCasosAporteCultivoBaciloscopia($anno, $trimestre){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(DISTINCT (p.id) )FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadoBCX rbcx JOIN rbcx.salidaCultivo sc ";
        $dql_2 = "WHERE m.current = 1 AND m.localizacionAnatomica = 'Pulmonar' AND sc.id = 1 ";

        $dql_3 = "JOIN rbcx.baciloscopia bac JOIN rbcx.baciloscopia2 bac2 ";
        $dql_4 = "AND bac.id = 1 AND bac2.id = 1 "; //casos con ambas baciloscopias negativas
        $dql_5 = "AND bac.id != 11 OR bac2.id != 1 "; //todos los casos con TB excepto los Sin Resultado(SB)
        $dql_6 = "AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();


        $dql_num = $dql_1.$dql_3.$dql_2.$dql_4.$dql_6;
        $dql_den = $dql_1.$dql_3.$dql_2.$dql_5.$dql_6;


        $query_num    = $em->createQuery($dql_num);
        $query_den    = $em->createQuery($dql_den);

        $cantidad_num = $query_num->getResult();
        $cantidad_den = $query_den->getResult();

        if( $cantidad_den[0][1] == 0 )
            return array( 'resultado' => ( '0 %' ));

        return array( 'resultado' => ( round( ($cantidad_num[0][1]/$cantidad_den[0][1]) * 100 , 2)).' %' );
    }

    //Aporte del cultivo al diagnóstico de casos de TB pulmonar (en relación a la prueba Xpert
    //MTB/RIF o XpertUltra MTB/RIF)
    public function CantidadCasosAporteCultivoXpert($anno, $trimestre){

        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(DISTINCT (p.id) )FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadoBCX rbcx JOIN rbcx.salidaCultivo sc ";
        $dql_2 = "WHERE m.current = 1 AND m.localizacionAnatomica = 'Pulmonar' AND sc.id = 1 ";

        $dql_3 = "JOIN rbcx.xpert xp ";
        $dql_4 = "AND xp.id = 4 "; //casos con xpert negativas (MTB no detectados)
        $dql_5 = "AND xp.id = 1 OR xp.id = 2 OR xp.id = 3 "; //todos los casos xpert T o RR o TI
        $dql_6 = "AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();


        $dql_num = $dql_1.$dql_3.$dql_2.$dql_4.$dql_6;
        $dql_den = $dql_1.$dql_3.$dql_2.$dql_5.$dql_6;


        $query_num    = $em->createQuery($dql_num);
        $query_den    = $em->createQuery($dql_den);

        $cantidad_num = $query_num->getResult();
        $cantidad_den = $query_den->getResult();

        if( $cantidad_den[0][1] == 0 )
            return array( 'resultado' => ( '0 %' ));

        return array( 'resultado' => ( round( ($cantidad_num[0][1]/$cantidad_den[0][1]) * 100 , 2)).' %' );
    }


}