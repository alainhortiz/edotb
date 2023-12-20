<?php


namespace AppBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\ImprimirExcel;


class ReporteSalidaController extends Controller
{
    //-----------BLOQUE REPORTE COHORTE POR CRITERIOS DE ENTRADA--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteCohorteCriteriosEntrada", name="reporteCohorteCriteriosEntrada")
     */
    public function reporteCohorteCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $trim = $peticion->request->get('trimestre');
        $anno = $peticion->request->get('anno');
        $enfermedad = $peticion->request->get('enfermedad');

        $em = $this->getDoctrine()->getManager();
        $enfermedades = $em->getRepository('AppBundle:Enfermedad')->findAll();

        if (empty($trim)) {
            $datos = $this->datosCohorteEntrada();
            return $this->render('Reportes/reporteCohorteCriteriosEntrada.html.twig', array('datos' => $datos, 'enfermedades' => $enfermedades));
        } else {
            $datos = $this->datosCohorteEntrada($trim, $anno, $enfermedad);
            return $this->render('Reportes/reporteCohorteCriteriosEntradaReplace.html.twig', array('datos' => $datos));
        }


    }

    public function datosCohorteEntrada($trim = 1, $anno = '', $enfermedad = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $datos = [];
        foreach ($provincias as $provincia) {
            $datos[] = array(
                'provincia' => $provincia->getNombre(),
                'pacientes' => $this->filaProvinciaReporte($trim, $anno, $provincia->getId(), $enfermedad)
            );
        }
        $datos[] = array(
            'provincia' => 'TOTAL',
            'pacientes' => $this->filaProvinciaReporte($trim, $anno, '0', $enfermedad)
        );
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE-------------------------------------------------------------
    public function filaProvinciaReporte($trimestre = 1, $anno = '', $idProvincia = '', $enfermedad = 1)
    {
        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_7 = " AND menf.id = $enfermedad";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        if ($enfermedad != 0) $dql_4 .= $dql_7;
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 7 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1]);
    }

    //-----------BLOQUE REPORTE COHORTE BACILOSCOPIA FIN PRIMERA ETAPA--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteCohorteBaciloscopiaFinPrimeraEtapa", name="reporteCohorteBaciloscopiaFinPrimeraEtapa")
     */
    public function reporteCohorteBaciloscopiaFinPrimeraEtapaAction()
    {
        $peticion = Request::createFromGlobals();

        $trim = $peticion->request->get('trimestre');
        $anno = $peticion->request->get('anno');

        $em = $this->getDoctrine()->getManager();
        $enfermedades = $em->getRepository('AppBundle:Enfermedad')->findAll();

        if (empty($trim)) {
            $datos = $this->datosCohorteBaciloscopiaFinPrimera();
            return $this->render('Reportes/reporteCohorteBaciloscopiaFinPrimeraEtapa.html.twig', array('datos' => $datos, 'enfermedades' => $enfermedades));
        } else {
            $datos = $this->datosCohorteBaciloscopiaFinPrimera($trim, $anno);
            return $this->render('Reportes/reporteCohorteBaciloscopiaFinPrimeraEtapaReplace.html.twig', array('datos' => $datos));
        }
    }

    public function datosCohorteBaciloscopiaFinPrimera($trim = 1, $anno = '')
    {
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $datos = [];
        foreach ($provincias as $provincia) {
            $datos[] = array(
                'provincia' => $provincia->getNombre(),
                'pacientes' => $this->filaProvinciaBaciloscopiaReporte($trim, $anno, $provincia->getId())
            );
        }
        $datos[] = array(
            'provincia' => 'TOTAL',
            'pacientes' => $this->filaProvinciaBaciloscopiaReporte($trim, $anno, '0')
        );
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE-------------------------------------------------------------
    public function filaProvinciaBaciloscopiaReporte($trimestre = 1, $anno = '', $idProvincia = '')
    {
        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_2 = "";
        $dql_7 = "";
        $dql_8 = "";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.baciloscopiaSeguimientos bseg JOIN bseg.baciloscopia bac ";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_7 = " AND m.tipoEnfermo = ";
        $dql_5 = " AND rf.ultimo = 1  AND bseg.categoria = 'Segundo Mes (Fin Primera fase)' AND ";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";

        $em = $this->getDoctrine()->getManager();

        //NEGATIVO CASO NUEVO
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 1 " . $dql_5 . " bac.id = 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        //POSITIVO CASO NUEVO
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 1 " . $dql_5 . " bac.id > 1 AND bac.id < 11 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        //DESCONOCIDO CASO NUEVO
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 1 " . $dql_5 . " bac.id > 10 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        //NEGATIVO RECAIDA
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 2 " . $dql_5 . " bac.id = 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        //POSITIVO RECAIDA
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 2 " . $dql_5 . " bac.id > 1 AND bac.id < 11 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        //DESCONOCIDO RECAIDA
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_7 . " 2 " . $dql_5 . " bac.id > 10 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        //NEGATIVO TOTAL
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " bac.id = 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        //POSITIVO TOTAL
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " bac.id > 1 AND bac.id < 11 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        //DESCONOCIDO TOTAL
        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " bac.id > 10 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();


        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1]);
    }

    //-----------BLOQUE REPORTE COHORTE POR GRUPOS VULNERABLES--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteCohorteCritEntGruposVulnerables", name="reporteCohorteCritEntGruposVulnerables")
     */
    public function reporteCohorteCritEntGruposVulnerablesAction()
    {
        $peticion = Request::createFromGlobals();

        $trim = $peticion->request->get('trimestre');
        $anno = $peticion->request->get('anno');
        $grupoVulnerable = $peticion->request->get('grupoVulnerable');
        $idProvincia = $peticion->request->get('idProvincia');
        $idMunicipio = $peticion->request->get('idMunicipio');

        $em = $this->getDoctrine()->getManager();
        $gruposVulnerables = $em->getRepository('AppBundle:GrupoVulnerable')->findAll();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $municipios = $em->getRepository('AppBundle:Municipio')->findAll();

        if (empty($trim)) {
            $datos = $this->datosCohorteGruposVulnerables();
            return $this->render('Reportes/reporteCohorteGruposVulnerables.html.twig', array(
                'gruposVulnerables' => $gruposVulnerables,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'datos' => $datos,
            ));
        } else {
            $areasSalud = "";
            $hospitales = "";
            $provMunicipios = "";
            if ($idMunicipio != '0' and $idMunicipio != '') {
                $municipio = $em->getRepository('AppBundle:Municipio')->find($idMunicipio);
                $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSaludMunicipio($idMunicipio);
                $hospitales = $em->getRepository('AppBundle:Hospital')->findBy(array('municipio' => $municipio));
            } else {
                if ($idProvincia != '0' and $idProvincia != '') {
                    $provincia = $em->getRepository('AppBundle:Provincia')->find($idProvincia);
                    $provMunicipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
                }
            }
            $datos = $this->datosCohorteGruposVulnerables($trim, $anno, $grupoVulnerable, $idProvincia, $idMunicipio);
            return $this->render('Reportes/reporteCohorteGruposVulnerablesReplace.html.twig', array(
                'datos' => $datos,
                'gruposVulnerables' => $gruposVulnerables,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'provMunicipios' => $provMunicipios,
                'areasSalud' => $areasSalud,
                'hospitales' => $hospitales,
            ));
        }
    }

    public function datosCohorteGruposVulnerables($trim = 1, $anno = '', $grupoVulnerable = 1, $idProvincia = '', $idMunicipio = '')
    {
        $em = $this->getDoctrine()->getManager();
        $enfermedades = $em->getRepository('AppBundle:Enfermedad')->findAll();
        $datos = [];
        foreach ($enfermedades as $enfermedad) {
            $datos[] = array(
                'enfemedadCodigo' => $enfermedad->getCodigo(),
                'enfemedadCriterioCompleto' => $enfermedad->criterioCompleto(),
                'pacientes' => $this->filaEnfermedadReporte($trim, $anno, $enfermedad->getId(), $grupoVulnerable, $idProvincia, $idMunicipio)
            );
        }
        $datos[] = array(
            'enfemedadCodigo' => 'TOTAL',
            'enfemedadCriterioCompleto' => 'TOTAL',
            'pacientes' => $this->filaEnfermedadReporte($trim, $anno, '0', $grupoVulnerable, $idProvincia, $idMunicipio)
        );
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE-------------------------------------------------------------
    public function filaEnfermedadReporte($trimestre = 1, $anno = '', $enfermedad = '', $grupoVulnerable = 1, $idProvincia = '', $idMunicipio = '')
    {
        $rangoFecha = $this->RangoTrimestre($trimestre, $anno);

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.grupoVulnerable gruv JOIN m.resistencia mres JOIN m.enfermedad menf ";
        $dql_2 = "";
        $dql_3 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_4 = "";
        $dql_5 = " AND menf.id = $enfermedad";
        $dql_6 = " AND m.fechaNotificacion >= $rangoFecha[0] AND m.fechaNotificacion <= $rangoFecha[1] ";
        $dql_7 = " AND gruv.id = $grupoVulnerable ";

        if ($grupoVulnerable != 0) $dql_3 .= $dql_7;
        if ($enfermedad != 0) $dql_3 .= $dql_5;
        $dql_3 .= $dql_6;

        $fila = [];
        $em = $this->getDoctrine()->getManager();

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN m.hospital h LEFT JOIN h.municipio mh ";
            $municipio = $em->getRepository('AppBundle:Municipio')->find($idMunicipio);
            foreach ($municipio->getAreasSalud() as $area) {
                if ($area->getIsArea() == 1) {
                    $idArea = $area->getId();
                    $dql_4 = " AND aa.id = $idArea";
                    $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
                    $query = $em->createQuery($dql);
                    $casilla = $query->getResult();
                    $fila[] = $casilla[0][1];
                }
            }
            foreach ($municipio->getHospitales() as $hospital) {
                $idHospital = $hospital->getId();
                $dql_4 = " AND h.id = $idHospital";
                $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
                $query = $em->createQuery($dql);
                $casilla = $query->getResult();
                $fila[] = $casilla[0][1];
            }
            $dql_4 = " AND (mnp.id = $idMunicipio OR mh.id = $idMunicipio)";
            $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
            $query = $em->createQuery($dql);
            $casilla = $query->getResult();
            $fila[] = $casilla[0][1];

        } elseif ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh ";
            $provincia = $em->getRepository('AppBundle:Provincia')->find($idProvincia);
            foreach ($provincia->getMunicipios() as $mun) {
                $idMun = $mun->getId();
                $dql_4 = "  AND (mnp.id = $idMun OR mh.id = $idMun)";
                $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
                $query = $em->createQuery($dql);
                $casilla = $query->getResult();
                $fila[] = $casilla[0][1];

            }
            $dql_4 = "  AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
            $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
            $query = $em->createQuery($dql);
            $casilla = $query->getResult();
            $fila[] = $casilla[0][1];
        } else {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh ";
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $idProv = $prov->getId();
                $dql_4 = "  AND (prov.id = $idProv OR provh.id = $idProv) ";
                $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
                $query = $em->createQuery($dql);
                $casilla = $query->getResult();
                $fila[] = $casilla[0][1];
            }
            $dql = $dql_1 . $dql_2 . $dql_3;
            $query = $em->createQuery($dql);
            $casilla = $query->getResult();
            $fila[] = $casilla[0][1];
        }
        return $fila;
    }

    public function RangoTrimestre($trimestre, $anno)
    {
        $fechaActual = new DateTime('now');

        if (empty($anno))
            $year = $fechaActual->format('Y');
        else
            $year = $anno;

        if ($trimestre == 1)
            return array("'" . $year . '-01-01' . "'", "'" . $year . '-03-31' . "'");

        if ($trimestre == 2)
            return array("'" . $year . '-04-01' . "'", "'" . $year . '-06-30' . "'");

        if ($trimestre == 3)
            return array("'" . $year . '-07-01' . "'", "'" . $year . '-09-30' . "'");

        if ($trimestre == 4)
            return array("'" . $year . '-10-01' . "'", "'" . $year . '-12-31' . "'");

        //LOS SIGUIENTES DOS CASOS AUNQUE SERAN TRATADOS COMO 2 TRIMESTRES MAS
        //SON PARA ESCOGER LOS SEMESTRES O EL ANNO COMPLETO PARA EL REPORTE
        //DE LOS APORTES DEL CULTIVO
        if ($trimestre == 5)
            return array("'" . $year . '-01-01' . "'", "'" . $year . '-06-30' . "'");//PRIMER SEMESTRE

        if ($trimestre == 6)
            return array("'" . $year . '-07-01' . "'", "'" . $year . '-12-31' . "'");//SEGUNDO SEMESTRE

        if ($trimestre == 7)
            return array("'" . $year . '-01-01' . "'", "'" . $year . '-12-31' . "'");//Año COMPLETO
    }


    //-----------BLOQUE EXPORTAR-----------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    // EXPORTAR REPORTE  COHORTE POR CRITERIOS DE ENTRADA
    /**
     * @Route("/excelCohorteCriteriosEntrada/{trimestre}/{anno}/{enfermedad}", name="excelCohorteCriteriosEntrada")
     */
    public function excelCohorteCriteriosEntradaAction($trimestre, $anno, $enfermedad)
    {
        $em = $this->getDoctrine()->getManager();
        $objectEnfermedad = $em->getRepository('AppBundle:Enfermedad')->find($enfermedad);

        $datos = $this->datosCohorteEntrada($trimestre, $anno, $objectEnfermedad->getId());

        $imp_mes_grl = new ImprimirExcel\ImpCohorteCriteriosEntrada();
        $imp_mes_grl->DatosExcel($datos, $trimestre, $anno, $objectEnfermedad);
    }

    // EXPORTAR REPORTE COHORTE BACILOSCOPIA FIN PRIMERA ETAPA

    /**
     * @Route("/excelCohorteBaciloscopiaFinPrimera/{trimestre}/{anno}", name="excelCohorteBaciloscopiaFinPrimera")
     */
    public function excelCohorteBaciloscopiaFinPrimeraAction($trimestre, $anno)
    {
        $datos = $this->datosCohorteBaciloscopiaFinPrimera($trimestre, $anno);

        $imp_mes_grl = new ImprimirExcel\ImpCohorteBaciloscopiaFinPrimera();
        $imp_mes_grl->DatosExcel($datos, $trimestre, $anno);
    }

    // EXPORTAR REPORTE COHORTE POR GRUPOS VULNERABLES

    /**
     * @Route("/excelCohorteCritEntGruposVulnerables/{trimestre}/{anno}/{grupoVulnerable}/{idProvincia}/{idMunicipio}", name="excelCohorteCritEntGruposVulnerables")
     */
    public function excelCohorteCritEntGruposVulnerablesAction($trimestre, $anno, $grupoVulnerable, $idProvincia, $idMunicipio)
    {
        $em = $this->getDoctrine()->getManager();
        $areasSalud = "";
        $hospitales = "";
        $municipios = "";
        $provincias = "";
        if ($idMunicipio != '0' and $idMunicipio != '') {
            $municipio = $em->getRepository('AppBundle:Municipio')->find($idMunicipio);
            $areasSalud = $em->getRepository('AppBundle:AreaSalud')->listarAreasSaludMunicipio($idMunicipio);
            $hospitales = $em->getRepository('AppBundle:Hospital')->findBy(array('municipio' => $municipio));
        } elseif ($idProvincia != '0' and $idProvincia != '') {

            $provincia = $em->getRepository('AppBundle:Provincia')->find($idProvincia);
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
        } else {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        }
        $objGrupo = $em->getRepository('AppBundle:GrupoVulnerable')->find($grupoVulnerable);
        $datos = $this->datosCohorteGruposVulnerables($trimestre, $anno, $grupoVulnerable, $idProvincia, $idMunicipio);

        $imp_mes_grl = new ImprimirExcel\ImpCohorteGruposVulnerables();
        $imp_mes_grl->DatosExcel($datos, $trimestre, $anno, $objGrupo, $provincias, $municipios, $areasSalud, $hospitales);
    }

    // EXPORTAR REPORTE CONTACTOS NUEVOS
    /**
     * @Route("/excelContactosNuevos/{fechaInicio}/{fechaFinal}/{provincia}", name="excelContactosNuevos")
     */
    public function excelContactosNuevosAction($fechaInicio, $fechaFinal, $provincia)
    {
        $em = $this->getDoctrine()->getManager();
//        $objectEnfermedad = $em->getRepository('AppBundle:Enfermedad')->find($enfermedad);

//        $datos = $this->datosCohorteEntrada($trimestre, $anno, $objectEnfermedad->getId());

        $imp_mes_grl = new ImprimirExcel\ImpContactosNuevos();
//        $imp_mes_grl->DatosExcel($datos, $trimestre, $anno, $objectEnfermedad);
    }

    //-----------BLOQUE REPORTE CASOS NUEVOS POR CRITERIOS DE ENTRADA--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteCasosNuevosCriteriosEntrada", name="reporteCasosNuevosCriteriosEntrada")
     */
    public function reporteCasosNuevosCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosCasosNuevosEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteCasosNuevosCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteCasosNuevosCriteriosEntrada", name="buscarReporteCasosNuevosCriteriosEntrada")
     */
    public function buscarReporteCasosNuevosCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosCasosNuevosEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos,
            'provincia' => $provincia,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    public function datosCasosNuevosEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteCasosNuevos($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteCasosNuevos($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteCasosNuevos($fechaInicio, $fechaFinal, $municipio->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaMunicipalReporteCasosNuevos($fechaInicio, $fechaFinal, '0')
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteCasosNuevos($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteCasosNuevos($fechaInicio, $fechaFinal, $idMunicipio)
    {
        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh";
            $dql_8 = " AND mh.id = $idMunicipio";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1]);
    }

    //-----------BLOQUE REPORTE RECAIDAS NOTIFICADAS POR CRITERIOS DE ENTRADA--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteRecaidasCriteriosEntrada", name="reporteRecaidasCriteriosEntrada")
     */
    public function reporteRecaidasCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosRecaidasEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteRecaidasCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteRecaidasCriteriosEntrada", name="buscarReporteRecaidasCriteriosEntrada")
     */
    public function buscarReporteRecaidasCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $fechaInicio = $peticion->request->get('fechaInicio');
        $fechaFinal = $peticion->request->get('fechaFinal');
        $provincia = $peticion->request->get('provincia');

        $fechaActual = new DateTime('now');

        if (empty($fechaInicio)) {
            $fechaInicio = $fechaActual->format('Y') . '-01-01';
        }

        if (empty($fechaFinal)) {
            $fechaFinal = $fechaActual->format('Y-m-d');
        }

        $datos = $this->datosRecaidasEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos,
            'provincia' => $provincia,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    public function datosRecaidasEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteRecaidas($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteRecaidas($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteRecaidas($fechaInicio, $fechaFinal, $municipio->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaMunicipalReporteRecaidas($fechaInicio, $fechaFinal, '0')
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteRecaidas($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteRecaidas($fechaInicio, $fechaFinal, $idMunicipio)
    {
        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh";
            $dql_8 = " AND mh.id = $idMunicipio";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1]);
    }

    //-----------BLOQUE REPORTE VIH POR CRITERIOS DE ENTRADA--------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    /**
     * @Route("/reporteVIHCriteriosEntrada", name="reporteVIHCriteriosEntrada")
     */
    public function reporteVIHCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosVIHEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteVIHCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteVIHCriteriosEntrada", name="buscarReporteVIHCriteriosEntrada")
     */
    public function buscarReporteVIHCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $fechaInicio = $peticion->request->get('fechaInicio');
        $fechaFinal = $peticion->request->get('fechaFinal');
        $provincia = $peticion->request->get('provincia');

        $fechaActual = new DateTime('now');

        if (empty($fechaInicio)) {
            $fechaInicio = $fechaActual->format('Y') . '-01-01';
        }

        if (empty($fechaFinal)) {
            $fechaFinal = $fechaActual->format('Y-m-d');
        }

        $datos = $this->datosVIHEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos,
            'provincia' => $provincia,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    public function datosVIHEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteVIH($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteVIH($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteVIH($fechaInicio, $fechaFinal, $municipio->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaMunicipalReporteVIH($fechaInicio, $fechaFinal, '0')
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteVIH($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteVIH($fechaInicio, $fechaFinal, $idMunicipio)
    {
        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh";
            $dql_8 = " AND mh.id = $idMunicipio";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1]);
    }

    //-----------BLOQUE REPORTE CONTACTOS NUEVOS POR CRITERIOS DE ENTRADA---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosNuevosCriteriosEntrada", name="reporteContactosNuevosCriteriosEntrada")
     */
    public function reporteContactosNuevosCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosNuevosEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosNuevosCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosNuevosCriteriosEntrada", name="buscarReporteContactosNuevosCriteriosEntrada")
     */
    public function buscarReporteContactosNuevosCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosNuevosEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosNuevosEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosNuevos($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosNuevos($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosNuevos($fechaInicio, $fechaFinal, $municipio->getId(), $provincia)
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosNuevos($fechaInicio, $fechaFinal, $provincia)
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosNuevos($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_total = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs";
        $dql_1 = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p";
        $dql_2 = " WHERE c.isActive = true";
        $dql_8 = "";
        $dql_12 = " AND cs.fechaNotificacion >='" . $fechaInicio . "' AND cs.fechaNotificacion <='" . $fechaFinal . "'";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_8 = " AND p.id = $idProvincia";
        }

        $dql_3 = " AND c.sexo = 'Masculino'";
        $dql_4 = " AND c.sexo = 'Femenino'";
        $dql_5 = " JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_6 = " AND csfr.tratadoTB = true";
        $dql_7 = " AND csfr.tratadoTB = false";
        $dql_9 = " AND csfr.diagnosticoVIH = 'Positivo'";
        $dql_10 = " AND csfr.diagnosticoVIH = 'Negativo'";
        $dql_11 = " AND csfr.diagnosticoVIH = 'No realizado'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_2 . $dql_12;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_3 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_6;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_7;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_9;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_11;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosNuevos($fechaInicio, $fechaFinal, $idMunicipio, $idProvincia)
    {
        $dql_total = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p";
        $dql_1 = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs LEFT JOIN cs.municipio m";
        $dql_2 = " WHERE c.isActive = true";
        $dql_8 = "";
        $dql_12 = " AND cs.fechaNotificacion >='" . $fechaInicio . "' AND cs.fechaNotificacion <='" . $fechaFinal . "'";
        $dql_13 = " AND p.id = $idProvincia";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_8 = " AND m.id = $idMunicipio";
        }

        $dql_3 = " AND c.sexo = 'Masculino'";
        $dql_4 = " AND c.sexo = 'Femenino'";
        $dql_5 = " JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_6 = " AND csfr.tratadoTB = true";
        $dql_7 = " AND csfr.tratadoTB = false";
        $dql_9 = " AND csfr.diagnosticoVIH = 'Positivo'";
        $dql_10 = " AND csfr.diagnosticoVIH = 'Negativo'";
        $dql_11 = " AND csfr.diagnosticoVIH = 'No realizado'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_2 . $dql_12 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_3 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_6;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_7;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_9;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_2 . $dql_8 . $dql_12 . $dql_11;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1]);
    }

    //-----------BLOQUE REPORTE CONTACTOS CON PCT/IGRA POR CRITERIOS DE ENTRADA---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosPCTCriteriosEntrada", name="reporteContactosPCTCriteriosEntrada")
     */
    public function reporteContactosPCTCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosPCTEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosPCTCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosPCTCriteriosEntrada", name="buscarReporteContactosPCTCriteriosEntrada")
     */
    public function buscarReporteContactosPCTCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosPCTEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosPCTEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosPCT($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosPCT($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosPCT($fechaInicio, $fechaFinal, $municipio->getId(), $provincia)
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosPCT($fechaInicio, $fechaFinal, $provincia)
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosPCT($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";
        $dql_13 = " AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_8 = " AND p.id = $idProvincia";
        }

        $dql_3 = " WHERE cse.pctIgraIndicado = true AND cse.fechaPctIgraIndicado >='" . $fechaInicio . "' AND cse.fechaPctIgraIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.pctIgraRealizado = true AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.resultadoPCT = 'Positiva' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.resultadoPCT = 'Negativa' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.resultadoPCT = 'No leida' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.resultadoIGRA = 'Positivo' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.resultadoIGRA = 'Negativo' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_11 = " WHERE cse.resultadoIGRA = 'Indeterminado' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado = $query->getResult();

        $dql = $dql_total . $dql_5 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_pct_pos = $query->getResult();

        $dql = $dql_total . $dql_9 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_igra_pos = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_1 . $dql_11 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $por = 0;
        $por_realizado = 0;
        $por_pct_pos = 0;
        $por_igra_pos = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
           $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado[0][1] !== 0 ) {
            $por_realizado = ($casilla_3[0][1]/$casilla_total_realizado[0][1])*100;
        }
        if((int) $casilla_total_pct_pos[0][1] !== 0 ) {
            $por_pct_pos = ($casilla_4[0][1]/$casilla_total_pct_pos[0][1])*100;
        }
        if((int) $casilla_total_igra_pos[0][1] !== 0 ) {
            $por_igra_pos = ($casilla_7[0][1]/$casilla_total_igra_pos[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado, $casilla_4[0][1], $por_pct_pos, $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $por_igra_pos, $casilla_8[0][1], $casilla_9[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosPCT($fechaInicio, $fechaFinal, $idMunicipio, $idProvincia)
    {
        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";
        $dql_13 = " AND p.id = $idProvincia";
        $dql_14 = " AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_8 = " AND m.id = $idMunicipio";
        }

        $dql_3 = " WHERE cse.pctIgraIndicado = true AND cse.fechaPctIgraIndicado >='" . $fechaInicio . "' AND cse.fechaPctIgraIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.pctIgraRealizado = true AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.resultadoPCT = 'Positiva' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.resultadoPCT = 'Negativa' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.resultadoPCT = 'No leida' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.resultadoIGRA = 'Positivo' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.resultadoIGRA = 'Negativo' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";
        $dql_11 = " WHERE cse.resultadoIGRA = 'Indeterminado' AND cse.fechaPctIgraRealizado >='" . $fechaInicio . "' AND cse.fechaPctIgraRealizado <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4 . $dql_14;
        $query = $em->createQuery($dql);
        $casilla_total_realizado = $query->getResult();

        $dql = $dql_total . $dql_5 . $dql_14;
        $query = $em->createQuery($dql);
        $casilla_total_pct_pos = $query->getResult();

        $dql = $dql_total . $dql_9 . $dql_14;
        $query = $em->createQuery($dql);
        $casilla_total_igra_pos = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_1 . $dql_11 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $por = 0;
        $por_realizado = 0;
        $por_pct_pos = 0;
        $por_igra_pos = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado[0][1] !== 0 ) {
            $por_realizado = ($casilla_3[0][1]/$casilla_total_realizado[0][1])*100;
        }
        if((int) $casilla_total_pct_pos[0][1] !== 0 ) {
            $por_pct_pos = ($casilla_4[0][1]/$casilla_total_pct_pos[0][1])*100;
        }
        if((int) $casilla_total_igra_pos[0][1] !== 0 ) {
            $por_igra_pos = ($casilla_7[0][1]/$casilla_total_igra_pos[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado, $casilla_4[0][1], $por_pct_pos, $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $por_igra_pos, $casilla_8[0][1], $casilla_9[0][1]);
    }

    //-----------BLOQUE REPORTE CONTACTOS CON SINTOMAS RESPIRATORIOS POR CRITERIOS DE ENTRADA---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosSintomasCriteriosEntrada", name="reporteContactosSintomasCriteriosEntrada")
     */
    public function reporteContactosSintomasCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosSintomasEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosSintomasCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosSintomasCriteriosEntrada", name="buscarReporteContactosSintomasCriteriosEntrada")
     */
    public function buscarReporteContactosSintomasCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosSintomasEntrada($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosSintomasEntrada($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosSintomas($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosSintomas($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosSintomas($fechaInicio, $fechaFinal, $municipio->getId(), $provincia)
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosSintomas($fechaInicio, $fechaFinal, $provincia)
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosSintomas($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_8 = " AND p.id = $idProvincia";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $casilla_4[0][1], $casilla_5[0][1], $por_realizado_cult, $casilla_6[0][1], $casilla_7[0][1], $por_realizado_rayo, $casilla_8[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosSintomas($fechaInicio, $fechaFinal, $idMunicipio, $idProvincia)
    {
        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";
        $dql_13 = " AND p.id = $idProvincia";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_8 = " AND m.id = $idMunicipio";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $casilla_4[0][1], $casilla_5[0][1], $por_realizado_cult, $casilla_6[0][1], $casilla_7[0][1], $por_realizado_rayo, $casilla_8[0][1]);
    }

    //-----------BLOQUE REPORTE CONTACTOS CON FACTORES DE RIESGOS POR CRITERIOS DE ENTRADA---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosFactoresCriteriosEntrada", name="reporteContactosFactoresCriteriosEntrada")
     */
    public function reporteContactosFactoresCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosFactoresEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosFactoresCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosFactoresCriteriosEntrada", name="buscarReporteContactosFactoresCriteriosEntrada")
     */
    public function buscarReporteContactosFactoresCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosFactoresEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteReplaceFactor.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosFactoresEntrada($fechaInicio = '', $fechaFinal = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        $factores = $em->getRepository('AppBundle:FactorRiesgo')->findAll();
        foreach ($factores as $factor) {
            $datos[] = array(
                'factor' => $factor->getNombre(),
                'pacientes' => $this->filaProvinciaReporteContactosFactores($fechaInicio, $fechaFinal, $factor->getId())
            );
        }
        $datos[] = array(
            'factor' => 'TOTAL',
            'pacientes' => $this->filaProvinciaReporteContactosFactores($fechaInicio, $fechaFinal, '0')
        );
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosFactores($fechaInicio, $fechaFinal, $idFactor)
    {

        $dql_total = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_1 = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_2 = " WHERE c.isActive = true";
        $dql_3 = " AND cs.fechaNotificacion >='" . $fechaInicio . "' AND cs.fechaNotificacion <='" . $fechaFinal . "'";
        $dql_4 = " AND csfr.id = $idFactor";

        if ($idFactor === '0') {
            $dql_4 = "";
        }

        $em = $this->getDoctrine()->getManager();
        $dql = $dql_total . $dql_2 . $dql_3;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();
        $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();
        $provincias = $em->getRepository('AppBundle:Provincia')->findBy(array(),array('id' => 'ASC'));
        foreach ($provincias as $prov) {
            $dql_5 = " AND p.id =" . $prov->getId();
            $dql = $dql_1 . $dql_2 . $dql_3 . $dql_5 . $dql_4;
            $query = $em->createQuery($dql);
            switch ($prov->getId())
            {
                case '1':
                    $casilla_2 = $query->getResult();
                    break;
                case '2':
                    $casilla_3 = $query->getResult();
                    break;
                case '3':
                    $casilla_4 = $query->getResult();
                    break;
                case '4':
                    $casilla_5 = $query->getResult();
                    break;
                case '5':
                    $casilla_6 = $query->getResult();
                    break;
                case '6':
                    $casilla_7 = $query->getResult();
                    break;
                case '7':
                    $casilla_8 = $query->getResult();
                    break;
                case '8':
                    $casilla_9 = $query->getResult();
                    break;
                case '9':
                    $casilla_10 = $query->getResult();
                    break;
                case '10':
                    $casilla_11 = $query->getResult();
                    break;
                case '11':
                    $casilla_12 = $query->getResult();
                    break;
                case '12':
                    $casilla_13 = $query->getResult();
                    break;
                case '13':
                    $casilla_14 = $query->getResult();
                    break;
                case '14':
                    $casilla_15 = $query->getResult();
                    break;
                case '15':
                    $casilla_16 = $query->getResult();
                    break;
                case '16':
                    $casilla_17 = $query->getResult();
                    break;

            }

        }
        $por = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1], $casilla_16[0][1], $casilla_17[0][1]);
    }

    //--------------------------BLOQUE REPORTE CONTACTOS DE CASOS RESISTENTES---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosCasosResistentes", name="reporteContactosCasosResistentes")
     */
    public function reporteContactosCasosResistentesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosResistentes($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosResistentes.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosCasosResistentes", name="buscarReporteContactosCasosResistentes")
     */
    public function buscarReporteContactosCasosResistentesAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosResistentes($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosResistentes($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosResistentes($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosResistentes($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosResistentes($fechaInicio, $fechaFinal, $municipio->getId(), $provincia)
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosResistentes($fechaInicio, $fechaFinal, $provincia)
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosResistentes($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_8 = " AND p.id = $idProvincia";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $casilla_4[0][1], $casilla_5[0][1], $por_realizado_cult, $por_realizado_rayo);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosResistentes($fechaInicio, $fechaFinal, $idMunicipio, $idProvincia)
    {
        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";
        $dql_13 = " AND p.id = $idProvincia";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_8 = " AND m.id = $idMunicipio";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $casilla_4[0][1], $casilla_5[0][1], $por_realizado_cult, $por_realizado_rayo);
    }

    //--------------------------BLOQUE REPORTE REPORTE CONTACTOS SIN PRUEBAS---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosSinPruebas", name="reporteContactosSinPruebas")
     */
    public function reporteContactosSinPruebasAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosSinPruebas($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosSinPruebas.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosSinPruebas", name="buscarReporteContactosSinPruebas")
     */
    public function buscarReporteContactosSinPruebasAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));
        $provincia = $peticion->request->get('provincia');

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosSinPruebas($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosSinPruebas($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosSinPruebas($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosSinPruebas($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosSinPruebas($fechaInicio, $fechaFinal, $municipio->getId(), $provincia)
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosSinPruebas($fechaInicio, $fechaFinal, $provincia)
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosSinPruebas($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_8 = " AND p.id = $idProvincia";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $por_realizado_cult, $por_realizado_rayo);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosSinPruebas($fechaInicio, $fechaFinal, $idMunicipio, $idProvincia)
    {
        $dql_total = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.evaluaciones cse";
        $dql_1 = "SELECT COUNT(cs) FROM AppBundle:ContactoSeguimiento cs LEFT JOIN cs.municipio m JOIN cs.evaluaciones cse";
        $dql_8 = "";
        $dql_12 = " WHERE cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";
        $dql_13 = " AND p.id = $idProvincia";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_8 = " AND m.id = $idMunicipio";
        }

        $dql_3 = " WHERE cse.baciloscopiaIndicado = true AND cse.fechaBaciloscopiaIndicado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaIndicado <='" . $fechaFinal . "'";
        $dql_4 = " WHERE cse.baciloscopiaRealizado = true AND cse.fechaBaciloscopiaRealizado >='" . $fechaInicio . "' AND cse.fechaBaciloscopiaRealizado <='" . $fechaFinal . "'";
        $dql_5 = " WHERE cse.cultivoIndicado = true AND cse.fechaCultivoIndicado >='" . $fechaInicio . "' AND cse.fechaCultivoIndicado <='" . $fechaFinal . "'";
        $dql_6 = " WHERE cse.cultivoRealizado = true AND cse.fechaCultivoRealizado >='" . $fechaInicio . "' AND cse.fechaCultivoRealizado <='" . $fechaFinal . "'";
        $dql_7 = " WHERE cse.rayosXIndicado = true AND cse.fechaRayosXIndicado >='" . $fechaInicio . "' AND cse.fechaRayosXIndicado <='" . $fechaFinal . "'";
        $dql_9 = " WHERE cse.rayosXRealizado = true AND cse.fechaRayosXRealizado >='" . $fechaInicio . "' AND cse.fechaRayosXRealizado <='" . $fechaFinal . "'";
        $dql_10 = " WHERE cse.xpertIndicado = true AND cse.fechaInicioEvaluacion >='" . $fechaInicio . "' AND cse.fechaInicioEvaluacion <='" . $fechaFinal . "'";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_total . $dql_12 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();

        $dql = $dql_total . $dql_4 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_baci = $query->getResult();

        $dql = $dql_total . $dql_6 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_cult = $query->getResult();

        $dql = $dql_total . $dql_9 . $dql_13;
        $query = $em->createQuery($dql);
        $casilla_total_realizado_rayo = $query->getResult();

        $dql = $dql_1 . $dql_12 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_1 . $dql_3 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_1 . $dql_4 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_1 . $dql_5 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_1 . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_1 . $dql_7 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_1 . $dql_9 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_1 . $dql_10 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $por = 0;
        $por_realizado_baci = 0;
        $por_realizado_cult = 0;
        $por_realizado_rayo = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        if((int) $casilla_total_realizado_baci[0][1] !== 0 ) {
            $por_realizado_baci = ($casilla_3[0][1]/$casilla_total_realizado_baci[0][1])*100;
        }
        if((int) $casilla_total_realizado_cult[0][1] !== 0 ) {
            $por_realizado_cult = ($casilla_5[0][1]/$casilla_total_realizado_cult[0][1])*100;
        }
        if((int) $casilla_total_realizado_rayo[0][1] !== 0 ) {
            $por_realizado_rayo = ($casilla_7[0][1]/$casilla_total_realizado_rayo[0][1])*100;
        }

        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $por_realizado_baci, $por_realizado_cult, $por_realizado_rayo);
    }

    //-----------BLOQUE REPORTE CONTACTOS QUE RECIBIERON TPT POR GRUPOS DE EDADES----------------//
    //-------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosTPTGrupoEdades", name="reporteContactosTPTGrupoEdades")
     */
    public function reporteContactosTPTGrupoEdadesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosTPTGrupoEdades($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosTPTGrupoEdades.html.twig', array(
            'datos' => $datos,
            'provincias' => $provincias,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosTPTGrupoEdades", name="buscarReporteContactosTPTGrupoEdades")
     */
    public function buscarReporteContactosTPTGrupoEdadesAction()
    {
        $peticion = Request::createFromGlobals();

        $fechaInicio = $peticion->request->get('fechaInicio');
        $fechaFinal = $peticion->request->get('fechaFinal');
        $provincia = $peticion->request->get('provincia');

        $fechaActual = new DateTime('now');

        if (empty($fechaInicio)) {
            $fechaInicio = $fechaActual->format('Y') . '-01-01';
        }

        if (empty($fechaFinal)) {
            $fechaFinal = $fechaActual->format('Y-m-d');
        }

        $datos = $this->datosContactosTPTGrupoEdades($fechaInicio, $fechaFinal, $provincia);

        return $this->render('Reportes/reporteReplace.html.twig', array(
            'datos' => $datos,
            'provincia' => $provincia,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    public function datosContactosTPTGrupoEdades($fechaInicio = '', $fechaFinal = '', $provincia = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        if (empty($provincia)) {
            $provincias = $em->getRepository('AppBundle:Provincia')->findAll();
            foreach ($provincias as $prov) {
                $datos[] = array(
                    'provincia' => $prov->getNombre(),
                    'pacientes' => $this->filaProvinciaReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, $prov->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, '0')
            );
        } else {
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(array('provincia' => $provincia));
            foreach ($municipios as $municipio) {
                $datos[] = array(
                    'provincia' => $municipio->getNombre(),
                    'pacientes' => $this->filaMunicipalReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, $municipio->getId())
                );
            }
            $datos[] = array(
                'provincia' => 'TOTAL',
                'pacientes' => $this->filaProvinciaReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, '0')
            );
        }
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, $idProvincia)
    {

        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idProvincia > 0 && $idProvincia != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh LEFT JOIN mh.provincia provh";
            $dql_8 = " AND (prov.id = $idProvincia OR provh.id = $idProvincia)";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1]);
    }

    //-----------CALCULA UNA FILA DE UNA PROVINCIA----------------------------------------------------------//
    public function filaMunicipalReporteContactosTPTGrupoEdades($fechaInicio, $fechaFinal, $idMunicipio)
    {
        $dql_1 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf  JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_2 = "";
        $dql_8 = "";
        $dql_10 = " AND rf.ultimo = 1";

        if ($idMunicipio > 0 && $idMunicipio != '') {
            $dql_2 = " LEFT JOIN m.areaSalud aa LEFT JOIN aa.municipio mnp LEFT JOIN mnp.provincia prov LEFT JOIN m.hospital h LEFT JOIN h.municipio mh";
            $dql_8 = " AND mh.id = $idMunicipio";
        }

        $dql_3 = "SELECT COUNT(m) FROM AppBundle:PacienteEvolucion m JOIN m.paciente p JOIN m.resultadosFinales rf JOIN rf.resultadoTratamiento rt JOIN m.resistencia mres JOIN m.enfermedad menf";
        $dql_4 = " WHERE mres.clasificacion != 'MDR' AND mres.clasificacion != 'XDR' AND mres.clasificacion != 'RR' ";
        $dql_5 = " AND rf.ultimo = 1 AND rt.id = ";
        $dql_6 = " AND m.fechaNotificacion >= $fechaInicio AND m.fechaNotificacion <= $fechaFinal ";

        $em = $this->getDoctrine()->getManager();

        $dql = $dql_1 . $dql_2 . $dql_4 . $dql_6 . $dql_8 . $dql_10;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 1 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_2 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 2 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_3 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 4 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_4 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 3 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_5 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 5 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_6 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_7 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_8 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_9 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_10 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_11 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_12 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_13 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_14 = $query->getResult();

        $dql = $dql_3 . $dql_2 . $dql_4 . $dql_5 . " 6 " . $dql_6 . $dql_8;
        $query = $em->createQuery($dql);
        $casilla_15 = $query->getResult();

        return array($casilla_1[0][1], $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1]);
    }

    //-----------BLOQUE REPORTE CONTACTOS TB CON FACTORES DE RIESGOS POR CRITERIOS DE ENTRADA---------------------------------------//
    //--------------------------------------------------------------------------------------------------------------//
    /**
     * @Route("/reporteContactosTBFactoresCriteriosEntrada", name="reporteContactosTBFactoresCriteriosEntrada")
     */
    public function reporteContactosTBFactoresCriteriosEntradaAction()
    {

        $em = $this->getDoctrine()->getManager();
        $fechaActual = new DateTime('now');
        $fechaInicio = $fechaActual->format('Y') . '-01-01';
        $fechaFinal = $fechaActual->format('Y-m-d');

        $datos = $this->datosContactosTBFactoresEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteContactosTBFactoresCriteriosEntrada.html.twig', array(
            'datos' => $datos,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal));

    }

    /**
     * @Route("/buscarReporteContactosTBFactoresCriteriosEntrada", name="buscarReporteContactosTBFactoresCriteriosEntrada")
     */
    public function buscarReporteContactosTBFactoresCriteriosEntradaAction()
    {
        $peticion = Request::createFromGlobals();

        $inicio = new DateTime($peticion->request->get('fechaInicio'));
        $final = new DateTime($peticion->request->get('fechaFinal'));

        $fechaInicio = $inicio->format('Y-m-d');
        $fechaFinal = $final->format('Y-m-d');

        $datos = $this->datosContactosTBFactoresEntrada($fechaInicio, $fechaFinal);

        return $this->render('Reportes/reporteReplaceFactor.html.twig', array(
            'datos' => $datos));

    }

    public function datosContactosTBFactoresEntrada($fechaInicio = '', $fechaFinal = '')
    {
        $em = $this->getDoctrine()->getManager();
        $datos = [];

        $factores = $em->getRepository('AppBundle:FactorRiesgo')->findAll();
        foreach ($factores as $factor) {
            $datos[] = array(
                'factor' => $factor->getNombre(),
                'pacientes' => $this->filaProvinciaReporteContactosTBFactores($fechaInicio, $fechaFinal, $factor->getId())
            );
        }
        $datos[] = array(
            'factor' => 'TOTAL',
            'pacientes' => $this->filaProvinciaReporteContactosTBFactores($fechaInicio, $fechaFinal, '0')
        );
        return $datos;
    }

    //-----------CALCULA UNA FILA DEL REPORTE NACIONAL----------------------------------------------------------//
    public function filaProvinciaReporteContactosTBFactores($fechaInicio, $fechaFinal, $idFactor)
    {

        $dql_total = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_1 = "SELECT COUNT(DISTINCT(c)) FROM AppBundle:Contacto c JOIN c.seguimientos cs LEFT JOIN cs.municipio m LEFT JOIN m.provincia p JOIN cs.contactoSeguimientoFactorRiesgo csfr";
        $dql_2 = " WHERE c.isActive = true";
        $dql_3 = " AND cs.fechaNotificacion >='" . $fechaInicio . "' AND cs.fechaNotificacion <='" . $fechaFinal . "'";
        $dql_4 = " AND csfr.id = $idFactor";

        if ($idFactor === '0') {
            $dql_4 = "";
        }

        $em = $this->getDoctrine()->getManager();
        $dql = $dql_total . $dql_2 . $dql_3;
        $query = $em->createQuery($dql);
        $casilla_total = $query->getResult();
        $dql = $dql_1 . $dql_2 . $dql_3 . $dql_4;
        $query = $em->createQuery($dql);
        $casilla_1 = $query->getResult();
        $provincias = $em->getRepository('AppBundle:Provincia')->findBy(array(),array('id' => 'ASC'));
        foreach ($provincias as $prov) {
            $dql_5 = " AND p.id =" . $prov->getId();
            $dql = $dql_1 . $dql_2 . $dql_3 . $dql_5 . $dql_4;
            $query = $em->createQuery($dql);
            switch ($prov->getId())
            {
                case '1':
                    $casilla_2 = $query->getResult();
                    break;
                case '2':
                    $casilla_3 = $query->getResult();
                    break;
                case '3':
                    $casilla_4 = $query->getResult();
                    break;
                case '4':
                    $casilla_5 = $query->getResult();
                    break;
                case '5':
                    $casilla_6 = $query->getResult();
                    break;
                case '6':
                    $casilla_7 = $query->getResult();
                    break;
                case '7':
                    $casilla_8 = $query->getResult();
                    break;
                case '8':
                    $casilla_9 = $query->getResult();
                    break;
                case '9':
                    $casilla_10 = $query->getResult();
                    break;
                case '10':
                    $casilla_11 = $query->getResult();
                    break;
                case '11':
                    $casilla_12 = $query->getResult();
                    break;
                case '12':
                    $casilla_13 = $query->getResult();
                    break;
                case '13':
                    $casilla_14 = $query->getResult();
                    break;
                case '14':
                    $casilla_15 = $query->getResult();
                    break;
                case '15':
                    $casilla_16 = $query->getResult();
                    break;
                case '16':
                    $casilla_17 = $query->getResult();
                    break;

            }

        }
        $por = 0;
        if((int) $casilla_total[0][1] !== 0 ) {
            $por = ($casilla_1[0][1]/$casilla_total[0][1])*100;
        }
        return array($casilla_1[0][1], $por, $casilla_2[0][1], $casilla_3[0][1], $casilla_4[0][1], $casilla_5[0][1], $casilla_6[0][1], $casilla_7[0][1], $casilla_8[0][1], $casilla_9[0][1], $casilla_10[0][1], $casilla_11[0][1], $casilla_12[0][1], $casilla_13[0][1], $casilla_14[0][1], $casilla_15[0][1], $casilla_16[0][1], $casilla_17[0][1]);
    }

}