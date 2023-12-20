<?php


namespace AppBundle\Controller;


use Doctrine\DBAL\Types\VarDateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListadosController extends Controller
{
    # -------------------------------------------------------- #
    # ---------------- LISTADOS DE PACIENTES ----------------- #
    # -------------------------------------------------------- #

    // LOS SIGUIENTES LISTADOS SE CARGAN EN UN DATATABLE CON AJAX
    /**
     * @Route("/pacientesEnTratamiento", name="pacientesEnTratamiento")
     */
    public function pacientesEnTratamientoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $semanasEstadisticas = $em->getRepository('AppBundle:SemanaEstadistica')->findAll();

        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Pacientes en Tratamiento',
                'semanasEstadisticas' => $semanasEstadisticas,
                'semanaSeleccionada'  => null,
                'origen' => 'pacientesEnTratamiento')
        );
    }

    /**
     * @Route("/pacientesEnTratamientoAjax", name="pacientesEnTratamientoAjax")
     */
    public function pacientesEnTratamientoAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND rt.resultado = 'No evaluado')";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e 
                    JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND rt.resultado = 'No evaluado')";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesEnTratamiento');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/pacientesSemanaEstadistica", name="pacientesSemanaEstadistica")
     */
    public function pacientesSemanaEstadisticaAction()
    {
        $peticion = Request::createFromGlobals();
        $idSemana = $peticion->request->get('idSemana');
        $anno = $peticion->request->get('anno');

        return new Response($this->renderView('Pacientes/containerTablaSemanaEstadistica.html.twig' , array(

            'idSemana' => $idSemana,
            'anno' =>$anno,
        )));
    }

    /**
     * @Route("pacientesSemanaEstadisticaAjax/{idSemana}", name="pacientesSemanaEstadisticaAjax")
     */
    public function pacientesSemanaEstadisticaAjaxAction($idSemana)
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND rt.resultado = 'No evaluado')";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND rt.resultado = 'No evaluado')";

        if($idSemana != 0){
            $em = $this->getDoctrine()->getManager();
            $semanaSeleccionada = $em->getRepository('AppBundle:SemanaEstadistica')->find($idSemana);
            $fechaInicial = $semanaSeleccionada->getFechaInicio()->format('Y-m-d');
            $fechaFinal = $semanaSeleccionada->getFechaFinal()->format('Y-m-d');
            $consulta .= "  AND e.fechaNotificacion >= '".$fechaInicial."' AND e.fechaNotificacion <= '".$fechaFinal."'";
            $totalRecords .= "  AND e.fechaNotificacion >= '".$fechaInicial."' AND e.fechaNotificacion <= '".$fechaFinal."'";
        }

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesEnTratamiento');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/pacientesFueraTratamiento", name="pacientesFueraTratamiento")
     */
    public function pacientesFueraTratamientoAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Listado de Pacientes Pasivos',
                'origen' => 'pacientesFueraTratamiento')
        );
    }

    /**
     * @Route("/pacientesFueraTratamientoAjax", name="pacientesFueraTratamientoAjax")
     */
    public function pacientesFueraTratamientoAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND (rt.resultado = 'Curado' OR rt.resultado = 'Fallecido' OR rt.resultado = 'Reparo de Diagnóstico' OR rt.resultado = 'Tratamiento completo'))";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND (rt.resultado = 'Curado' OR rt.resultado = 'Fallecido' OR rt.resultado = 'Reparo de Diagnóstico' OR rt.resultado = 'Tratamiento completo'))";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesFueraTratamiento');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/pacientesResistentes", name="pacientesResistentes")
     */
    public function pacientesResistentesAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Listado de Pacientes Resistentes',
                'origen' => 'pacientesResistentes')
        );
    }

    /**
     * @Route("/pacientesResistentesAjax", name="pacientesResistentesAjax")
     */
    public function pacientesResistentesAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND (rt.resultado = 'Curado' OR rt.resultado = 'Fallecido' OR rt.resultado = 'Reparo de Diagnóstico' OR rt.resultado = 'Tratamiento completo'))";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND (rt.resultado = 'Curado' OR rt.resultado = 'Fallecido' OR rt.resultado = 'Reparo de Diagnóstico' OR rt.resultado = 'Tratamiento completo'))";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesResistentesAjax');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/pacientesEnFracasoAlTratamiento", name="pacientesEnFracasoAlTratamiento")
     */
    public function pacientesEnFracasoAlTratamientoAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Pacientes con Fracaso al Tratamiento',
                'origen' => 'pacientesEnFracasoAlTratamiento')
        );
    }

    /**
     * @Route("/pacientesEnFracasoAlTratamientoAjax", name="pacientesEnFracasoAlTratamientoAjax")
     */
    public function pacientesEnFracasoAlTratamientoAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND rt.resultado = 'Fracaso al tratamiento')";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND rt.resultado = 'Fracaso al tratamiento')";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesEnFracasoAlTratamiento');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/pacientesEnPerdidaDeSeguimiento", name="pacientesEnPerdidaDeSeguimiento")
     */
    public function pacientesEnPerdidaDeSeguimientoAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Pacientes en Perdida de Seguimiento',
                'origen' => 'pacientesEnPerdidaDeSeguimiento')
        );
    }

    /**
     * @Route("/pacientesEnPerdidaDeSeguimientoAjax", name="pacientesEnPerdidaDeSeguimientoAjax")
     */
    public function pacientesEnPerdidaDeSeguimientoAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest  
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id
                    AND rt.resultado = 'Pérdida en el seguimiento')";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id
                    AND rt.resultado = 'Pérdida en el seguimiento')";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesEnPerdidaDeSeguimiento');

        return new Response(json_encode($output));
    }

    // Los tratamiento terminado no es una salida del sistema pero se necesita un listado
    /**
     * @Route("/pacientesConTratamientoTerminado", name="pacientesConTratamientoTerminado")
     */
    public function pacientesConTratamientoTerminadoAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Pacientes con Tratamiento Terminado',
                'origen' => 'pacientesConTratamientoTerminado')
        );
    }

    /**
     * @Route("/pacientesConTratamientoTerminadoAjax", name="pacientesConTratamientoTerminadoAjax")
     */
    public function pacientesConTratamientoTerminadoAjaxAction()
    {
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.esquemasMedicamentos em  
                    LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND em.current = 1 AND SIZE(em.asistenciasTratamientos) > 107 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id  AND rt.resultado = 'No evaluado')";

        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.esquemasMedicamentos em 
                    LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1 AND em.current = 1 AND SIZE(em.asistenciasTratamientos) > 107 AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id AND rt.resultado = 'No evaluado')";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'pacientesConTratamientoTerminado');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/posiblesPacientesEnPerdidaDeSeguimiento", name="posiblesPacientesEnPerdidaDeSeguimiento")
     */
    public function posiblesPacientesEnPerdidaDeSeguimientoAction()
    {
        return $this->render('Pacientes/listadoPacientesGenerico.html.twig' , array(

                'titulo' => 'Pacientes que pueden estar en Pérdida de Seguimiento',
                'origen' => 'posiblesPacientesEnPerdidaDeSeguimiento')
        );
    }

    /**
     * @Route("/posiblesPacientesEnPerdidaDeSeguimientoAjax", name="posiblesPacientesEnPerdidaDeSeguimientoAjax")
     */
    public function posiblesPacientesEnPerdidaDeSeguimientoAjaxAction()
    {
        $actual = new \DateTime('now');
        $actualString = $actual->format('Y-m-d');
        $consulta = "SELECT e.id,p.carnetIdentidad,p.nombre AS nombre,SIZE(e.esquemasMedicamentos) AS esquemas,
                    p.primerApellido,p.segundoApellido,e.fechaNotificacion,enf.codigo,rest.resultado,aprov.nombre AS provincia,amun.nombre AS municipio 
                    FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.esquemasMedicamentos em  
                    LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1  AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1  AND rf.id = resf.id AND rt.resultado = 'No evaluado')
                    AND (e.esquemasMedicamentos IS EMPTY OR (em.asistenciasTratamientos IS EMPTY AND em.current = 1 AND DATE_DIFF('".$actualString."' , em.fechaInicio) > 30)
                        OR EXISTS (SELECT at FROM AppBundle:AsistenciaTratamiento at 
                        WHERE at MEMBER OF em.asistenciasTratamientos  AND DATE_DIFF('".$actualString."' , at.fecha) > 30))";

        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:PacienteEvolucion e JOIN e.paciente p LEFT JOIN e.enfermedad enf LEFT JOIN e.esquemasMedicamentos em 
                    LEFT JOIN e.resultadosFinales resf LEFT JOIN resf.resultadoTratamiento rest 
                    LEFT JOIN e.areaSalud aa LEFT JOIN aa.municipio amun LEFT JOIN amun.provincia aprov 
                    WHERE e.current = 1  AND EXISTS (SELECT rf FROM AppBundle:ResultadoFinal rf JOIN rf.resultadoTratamiento rt 
                    WHERE rf MEMBER OF e.resultadosFinales AND rf.ultimo = 1 AND rf.id = resf.id AND rt.resultado = 'No evaluado')
                    AND (e.esquemasMedicamentos IS EMPTY OR (em.asistenciasTratamientos IS EMPTY AND em.current = 1 AND DATE_DIFF('".$actualString."' , em.fechaInicio) > 30)
                        OR EXISTS (SELECT at FROM AppBundle:AsistenciaTratamiento at 
                        WHERE at MEMBER OF em.asistenciasTratamientos  AND DATE_DIFF('".$actualString."' , at.fecha) > 30))";

        $consulta .= $this->wherePorNivelesAccceso();
        $totalRecords .= $this->wherePorNivelesAccceso();

        $output = $this->dataTablePacienteAjax($consulta ,$totalRecords , 'posiblesPacientesEnPerdidaDeSeguimiento');

        return new Response(json_encode($output));
    }

    //genera la parte del where que se refiere al codigo de: provincia , municipio , area de salud , hospital
    //depende del nivel de acceso del usuario
    private function wherePorNivelesAccceso()
    {
        $user = $this->getUser();
        if($user->getNivelAcceso()->getNivel() == 'provincial')
        {
            $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();
            return " AND aprov.codigo = ".$provincia;
        }
        if($user->getNivelAcceso()->getNivel() == 'municipal')
        {
            $municipio = $user->getAreaSalud()->getMunicipio()->getCodigo();
            return " AND amun.codigo = ".$municipio;
        }
        if($user->getNivelAcceso()->getNivel() == 'unidad')
        {
            $codigo = $user->getAreaSalud()->getCodigo();
            return " AND (aa.codigo = ".$codigo;
        }
        return "";
    }

    //genera la cadena de ordenamiento pare devolver los valores en el datatable
    private function orderPorNivelesAccceso($orders)
    {
        $user = $this->getUser();
        $camposOrden = '';
        if($user->getNivelAcceso()->getId() == 4)
        {
            foreach ($orders as $order)
            {
                if($order['column'] != "")
                {
                    switch ($order['column'])
                    {
                        case '0':
                            $camposOrden .= ' TRIM(aprov.nombre) '.$order['dir'].',';
                            break;
                        case '1':
                            $camposOrden .= ' TRIM(amun.nombre) '.$order['dir'].',';
                            break;
                        case '2':
                            $camposOrden .= ' TRIM(p.nombre) '.$order['dir'].',';
                            break;
                        case '3':
                            $camposOrden .= ' TRIM(p.primerApellido) '.$order['dir'].',';
                            break;
                        case '4':
                            $camposOrden .= ' TRIM(p.segundoApellido) '.$order['dir'].',';
                            break;
                        case '5':
                            $camposOrden .= ' TRIM(e.fechaNotificacion) '.$order['dir'].',';
                            break;
                        case '6':
                            $camposOrden .= ' TRIM(enf.codigo) '.$order['dir'].',';
                            break;

                    }
                }
            }
        }
        elseif ($user->getNivelAcceso()->getId() == 3)
        {
            foreach ($orders as $order)
            {
                if($order['column'] != "")
                {
                    switch ($order['column'])
                    {
                        case '0':
                            $camposOrden .= ' TRIM(amun.nombre) '.$order['dir'].',';
                            break;
                        case '1':
                            $camposOrden .= ' TRIM(p.nombre) '.$order['dir'].',';
                            break;
                        case '2':
                            $camposOrden .= ' TRIM(p.primerApellido) '.$order['dir'].',';
                            break;
                        case '3':
                            $camposOrden .= ' TRIM(p.segundoApellido) '.$order['dir'].',';
                            break;
                        case '4':
                            $camposOrden .= ' TRIM(e.fechaNotificacion) '.$order['dir'].',';
                            break;
                        case '5':
                            $camposOrden .= ' TRIM(enf.codigo) '.$order['dir'].',';
                            break;

                    }
                }
            }
        }
        else{
            foreach ($orders as $order)
            {
                if($order['column'] != "")
                {
                    switch ($order['column'])
                    {
                        case '0':
                            $camposOrden .= ' TRIM(p.primerApellido) '.$order['dir'].',';
                            break;
                        case '1':
                            $camposOrden .= ' TRIM(p.segundoApellido) '.$order['dir'].',';
                            break;
                        case '2':
                            $camposOrden .= ' TRIM(e.fechaNotificacion) '.$order['dir'].',';
                            break;
                        case '3':
                            $camposOrden .= ' TRIM(enf.codigo) '.$order['dir'].',';
                            break;

                    }
                }
            }
        }
        return $camposOrden;
    }

    private function dataTablePacienteAjax($consulta ,$totalRecords , $origen)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dql = $consulta;
        $dqlTotalRecords = $totalRecords;
        $dqlCountFiltered = $totalRecords;

        //Esto es para armar el filtro que viene del front
        $sqlFilter = "";

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            $sqlFilter .= " (p.nombre LIKE '%".$strMainSearch."%' OR "
                ."p.primerApellido  LIKE '%".$strMainSearch."%' OR "
                ."p.segundoApellido  LIKE '%".$strMainSearch."%' OR "
                ."e.fechaNotificacion  LIKE '%".$strMainSearch."%' OR "
                ."enf.codigo  LIKE '%".$strMainSearch."%' OR "
                ."rest.resultado LIKE '%".$strMainSearch."%'";

            if($user->getNivelAcceso()->getId() > 2)
            {
                $sqlFilter .= " OR amun.nombre LIKE '%".$strMainSearch."%'";
            }

            if($user->getNivelAcceso()->getId() == 4)
            {
                $sqlFilter .= " OR aprov.nombre LIKE '%".$strMainSearch."%'";
            }
            $sqlFilter .= ") ";

        }

        //Armar el buscador de los footer
        // Filter columns with AND restriction
        $strColSearch = "";
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                /*$strColSearch .= ' t.'.$column['name']." LIKE '%".$column['search']['value']."%'";*/
                if (!empty($column['search']['value']))
                {
                    switch ($column['name'])
                    {
                        case 'provincia': $strColSearch .= " aprov.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'municipio': $strColSearch .= " amun.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'nombre':  $strColSearch .= " p.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'primerApellido':  $strColSearch .= " p.primerApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'segundoApellido':  $strColSearch .= " p.segundoApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'fechaNotificacion':  $strColSearch .= " e.fechaNotificacion LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'enfermedad':  $strColSearch .= " enf.codigo LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'resultadoTratamiento':  $strColSearch .= " rest.resultado LIKE '%".$column['search']['value']."%' ";
                            break;
                    }
                }
            }
        }
        if (!empty($sqlFilter) and !empty($strColSearch)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            if(strpos($dql , 'WHERE'))
            {
                $dql .= ' AND'.$sqlFilter;
                $dqlCountFiltered .= ' AND'.$sqlFilter;
            }else{
                $dql .= ' WHERE'.$sqlFilter;
                $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            }
        }

        //order
        $camposOrden = $this->orderPorNivelesAccceso($_GET['order']);
        if(substr($camposOrden , -1) === ',') $camposOrden = substr($camposOrden, 0, -1);
        $dql .=' ORDER BY'.$camposOrden;

        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

        $data = array();
        foreach ($items as $key => $value) {
            $provincia = $value['provincia'];
            $municipio = $value['municipio'];
            $vinculoVerPaciente = $this->generateUrl('verPaciente', array('ci' => $value['carnetIdentidad'], 'origen' => $origen ));
            $acciones = "<div class=\"btn-opt\" id=\"ver\" style=\"background: #ffffff; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Datos\">
                                    <a href=\"$vinculoVerPaciente\" style=\"text-decoration: none; color: #1f1f1f\">
                                        <i class=\"glyphicon glyphicon-eye-open\" style=\"font-size: 20px\"></i>
                                    </a>
                                </div>";
            $vinculoActualizar = $this->generateUrl('actualizarPaciente', array('idEvolucion' => $value['id'], 'origen' => $origen ));
            $acciones .= "<div class=\"btn-opt\" id=\"actualizar\" style=\"background: #3a81b8; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Actualizar\">
                                            <a href=\"$vinculoActualizar\" style=\"text-decoration: none; color: #ffffff\">
                                                <i class=\"glyphicon glyphicon-pencil\" style=\"font-size: 20px\"></i>
                                            </a>
                                        </div>";

            if(in_array("ROLE_EDITOR_LABORATORIO" , $user->getRoles()) or in_array("ROLE_SUPERUSUARIO" , $user->getRoles()))
            {
                $vinculoSuceptibilidad = $this->generateUrl('susceptibiliad_paciente', array('idEvolucion' => $value['id'] ));
                $acciones .= "<div class=\"btn-opt\" id=\"laboratorio\" style=\"background: #4d545a; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Laboratorio\">
                                            <a href=\"$vinculoSuceptibilidad\" style=\"text-decoration: none; color: #ffffff\">
                                                <i class=\"glyphicon glyphicon-filter\" style=\"font-size: 20px\"></i>
                                            </a>
                                        </div>";
                if($origen === 'pacientesEnTratamiento' or $origen === 'posiblesPacientesEnPerdidaDeSeguimiento' or $origen === 'pacientesConTratamientoTerminado')
                {
                    if($value['esquemas'] != 0){
                        $vinculoSeguimiento = $this->generateUrl('mostrarVistaSeguimientoPaciente', array('idEvolucion' => $value['id'] , 'tabActivo' => 'baciloscopia' ));
                        $acciones .= "<div class=\"btn-opt\" id=\"resultados\" style=\"background: #70cbb1; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Resultados\">
                                                <a href=\"$vinculoSeguimiento\" style=\"text-decoration: none; color: #ffffff\">
                                                    <i class=\"glyphicon glyphicon-list\" style=\"font-size: 20px\"></i>
                                                </a>
                                            </div>";
                    }
                }
            }
            if(in_array("ROLE_EDITOR_ESTADISTICA" , $user->getRoles()) or in_array("ROLE_SUPERUSUARIO" , $user->getRoles()))
            {
                if($origen === 'pacientesEnTratamiento' or $origen === 'posiblesPacientesEnPerdidaDeSeguimiento' or $origen === 'pacientesConTratamientoTerminado')
                {
                    if($value['esquemas'] != 0){
                        $vinculoAsistenciaTratamiento = $this->generateUrl('asistenciaTratamientoPaciente', array('idEvolucion' => $value['id'] ));
                        $acciones .= "<div class=\"btn-opt\" id=\"asistenciaTratamiento\" style=\"background: #901fcb; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Asistencia Tratamiento\">
                                                <a href=\"$vinculoAsistenciaTratamiento\" style=\"text-decoration: none; color: #ffffff\">
                                                    <i class=\"glyphicon glyphicon-tint\" style=\"font-size: 20px\"></i>
                                                </a>
                                            </div>";
                    }
                }
                if($user->getNivelAcceso()->getId() > 2)
                {
                    $id = $value['id'];
                    $acciones .= "<div class=\"btn-opt delete\" name=\"$id\"   id=\"$id\" style=\"background: #e42d26; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Borrar\">
                                            <i class=\"glyphicon glyphicon-erase\" style=\"font-size: 20px\"></i>
                                        </div>";
                }
            }

            if($user->getNivelAcceso()->getId() == 4){
                $data[] = array(
                    $provincia,
                    $municipio,
                    $value['nombre'],
                    $value['primerApellido'],
                    $value['segundoApellido'],
                    $value['fechaNotificacion']->format('Y-m-d'),
                    $value['codigo'],
                    $acciones,
                );
            }
            elseif ($user->getNivelAcceso()->getId() == 3){
                $data[] = array(
                    $municipio,
                    $value['nombre'],
                    $value['primerApellido'],
                    $value['segundoApellido'],
                    $value['fechaNotificacion']->format('Y-m-d'),
                    $value['codigo'],
                    $acciones,
                );
            }
            else{
                $data[] = array(
                    $value['nombre'],
                    $value['primerApellido'],
                    $value['segundoApellido'],
                    $value['fechaNotificacion']->format('Y-m-d'),
                    $value['codigo'],
                    $acciones,
                );
            }
        }

        $recordsTotal = $entityManager
            ->createQuery($dqlTotalRecords)
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        $output = array(
            'draw' => 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        );

        return $output;
    }

    // LOS SIGUIENTES LISTADOS SE CARGAN DE LA FORMA TRADICIONAL

    /**
     * @Route("/pacientesPendientesRegistro", name="pacientesPendientesRegistro")
     */
    public function pacientesPendientesRegistroAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $pacientes = $em->getRepository('AppBundle:PacienteSintomatico')->listarPacientesSintomaticosPendientes($user);

        return $this->render('Laboratorio/listadoPacientesPendientesRegistro.html.twig' , array('pacientes' => $pacientes));
    }

    /**
     * @Route("/pacientesTransferidos", name="pacientesTransferidos")
     */
    public function pacientesTransferidosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $pacientes = $em->getRepository('AppBundle:PacienteTransferido')->listarPacientesTransferidos($user);

        return $this->render('Pacientes/listadoPacientesTransferidos.html.twig' , array(

                'pacientes' => $pacientes,
                'titulo' => 'Pacientes Transferidos',
                'origen' => 'pacientesTransferidos')
        );
    }

    /**
     * @Route("/pacientesSinEvolucion", name="pacientesSinEvolucion")
     */
    public function pacientesSinEvolucionAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pacientes = $em->getRepository('AppBundle:Paciente')->listarPacientesSinEvolucion();

        return $this->render('Pacientes/listadoPacientesSinEvolucion.html.twig' , array('pacientes' => $pacientes,));
    }

    # -------------------------------------------------------- #
    # ---------------- LISTADOS DE CONTACTOS ----------------- #
    # -------------------------------------------------------- #

    /**
     * @Route("/contactosEnSeguimiento", name="contactosEnSeguimiento")
     */
    public function contactosEnSeguimientoAction()
    {

        return $this->render('Contactos/Listados/listadoContactosGenerico.html.twig' , array(

                'titulo' => 'Contactos en Seguimiento',
                'origen' => 'contactosEnSeguimiento')
        );
    }

    /**
     * @Route("/contactosEnSeguimientoAjax", name="contactosEnSeguimientoAjax")
     */
    public function contactosEnSeguimientoAjaxAction()
    {
        $consulta = "SELECT s.id, e.carnetIdentidad, e.nombre AS nombre, e.primerApellido, e.segundoApellido, s.fechaNotificacion
                    FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE s.isActive = 1 ";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE s.isActive = 1 ";

        $output = $this->dataTableContactoAjax($consulta ,$totalRecords , 'contactosEnSeguimiento');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/contactosPasivos", name="contactosPasivos")
     */
    public function contactosPasivosAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Contactos/Listados/listadoContactosGenerico.html.twig' , array(

                'titulo' => 'Contactos pasivos',
                'origen' => 'contactosPasivos')
        );
    }

    /**
     * @Route("/contactosPasivosAjax", name="contactosPasivosAjax")
     */
    public function contactosPasivosAjaxAction()
    {
        $consulta = "SELECT e.id, e.carnetIdentidad, e.nombre AS nombre, e.primerApellido, e.segundoApellido, s.fechaNotificacion
                    FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE e.isActive = 0 ";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE e.isActive = 0 ";

        $output = $this->dataTableContactoAjax($consulta ,$totalRecords , 'contactosPasivos');

        return new Response(json_encode($output));
    }

    /**
     * @Route("/contactosPerdidasSeguimiento", name="contactosPerdidasSeguimiento")
     */
    public function contactosPerdidasSeguimientoAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Contactos/Listados/listadoContactosGenerico.html.twig' , array(

                'titulo' => 'Contactos en pérdida de seguimiento',
                'origen' => 'contactosPerdidasSeguimiento')
        );
    }

    /**
     * @Route("/contactosPerdidasSeguimientoAjax", name="contactosPerdidasSeguimientoAjax")
     */
    public function contactosPerdidasSeguimientoAjaxAction()
    {
        $consulta = "SELECT s.id, e.carnetIdentidad, e.nombre AS nombre, e.primerApellido, e.segundoApellido, s.fechaNotificacion
                    FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE s.isActive = 0 ";
        $totalRecords = "SELECT COUNT(e.id) FROM AppBundle:Contacto e JOIN e.seguimientos s WHERE s.isActive = 0 ";

        $output = $this->dataTableContactoAjax($consulta ,$totalRecords , 'contactosEnSeguimiento');

        return new Response(json_encode($output));
    }

    //genera la cadena de ordenamiento pare devolver los valores en el datatable
    private function orderPorNivelesAcccesoContacto($orders)
    {
        $camposOrden = '';

            foreach ($orders as $order)
            {
                if($order['column'] != "")
                {
                    switch ($order['column'])
                    {
                        case '0':
                            $camposOrden .= ' TRIM(e.carnetIdentidad) '.$order['dir'].',';
                            break;
                        case '1':
                            $camposOrden .= ' TRIM(e.nombre) '.$order['dir'].',';
                            break;
                        case '2':
                            $camposOrden .= ' TRIM(e.primerApellido) '.$order['dir'].',';
                            break;
                        case '3':
                            $camposOrden .= ' TRIM(e.segundoApellido) '.$order['dir'].',';
                            break;
                        case '4':
                            $camposOrden .= ' TRIM(s.fechaNotificacion) '.$order['dir'].',';
                            break;
                    }
                }
            }
        return $camposOrden;
    }

    private function dataTableContactoAjax($consulta ,$totalRecords , $origen)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $dql = $consulta;
        $dqlTotalRecords = $totalRecords;
        $dqlCountFiltered = $totalRecords;

        //Esto es para armar el filtro que viene del front
        $sqlFilter = "";

        if (!empty($_GET['search']['value'])) {
            $strMainSearch = $_GET['search']['value'];

            $sqlFilter .= " (e.carnetIdentidad LIKE '%".$strMainSearch."%' OR "
                ."e.nombre  LIKE '%".$strMainSearch."%' OR "
                ."e.primerApellido  LIKE '%".$strMainSearch."%' OR "
                ."e.segundoApellido  LIKE '%".$strMainSearch."%' OR "
                ."s.fechaNotificacion  LIKE '%".$strMainSearch."%') ";
        }

        //Armar el buscador de los footer
        // Filter columns with AND restriction
        $strColSearch = "";
        foreach ($_GET['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if (!empty($strColSearch)) {
                    $strColSearch .= ' AND ';
                }
                if (!empty($column['search']['value']))
                {
                    switch ($column['name'])
                    {
                        case 'ci': $strColSearch .= " e.carnetIdentidad LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'nombre':  $strColSearch .= " e.nombre LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'primerApellido':  $strColSearch .= " e.primerApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'segundoApellido':  $strColSearch .= " e.segundoApellido LIKE '%".$column['search']['value']."%' ";
                            break;
                        case 'fechaNotificacion':  $strColSearch .= " s.fechaNotificacion LIKE '%".$column['search']['value']."%' ";
                            break;
                    }
                }
            }
        }
        if (!empty($sqlFilter) and !empty($strColSearch)) {
            $sqlFilter .= ' AND ('.$strColSearch.')';
        } else {
            $sqlFilter .= $strColSearch;
        }

        if (!empty($sqlFilter)) {
            if(strpos($dql , 'WHERE'))
            {
                $dql .= ' AND'.$sqlFilter;
                $dqlCountFiltered .= ' AND'.$sqlFilter;
            }else{
                $dql .= ' WHERE'.$sqlFilter;
                $dqlCountFiltered .= ' WHERE'.$sqlFilter;
            }
        }

        //order
        $camposOrden = $this->orderPorNivelesAcccesoContacto($_GET['order']);
        if(substr($camposOrden , -1) === ',') $camposOrden = substr($camposOrden, 0, -1);
        $dql .=' ORDER BY'.$camposOrden;

        $items = $entityManager
            ->createQuery($dql)
            ->setFirstResult($_GET['start'])
            ->setMaxResults($_GET['length'])
            ->getResult();

        $data = array();
        foreach ($items as $key => $value) {
            if(in_array("ROLE_CONTACTO" , $user->getRoles()) or in_array("ROLE_SUPERUSUARIO" , $user->getRoles())) {
                $vinculoVerContacto = $this->generateUrl('verContacto', array('carnetIdentidad' => $value['carnetIdentidad'] , 'idSeguimiento' => $value['id'], 'origen' => $origen ));
                $acciones = "<div class=\"btn-opt\" id=\"ver\" style=\"background: #ffffff; text-align: center\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Datos\">
                                    <a href=\"$vinculoVerContacto\" style=\"text-decoration: none; color: #1f1f1f\">
                                        <i class=\"glyphicon glyphicon-eye-open\" style=\"font-size: 20px\"></i>
                                    </a>
                                </div>";
            }

                $data[] = array(
                    $value['carnetIdentidad'],
                    $value['nombre'],
                    $value['primerApellido'],
                    $value['segundoApellido'],
                    $value['fechaNotificacion']->format('Y-m-d'),
                    $acciones,
                );

        }

        $recordsTotal = $entityManager
            ->createQuery($dqlTotalRecords)
            ->getSingleScalarResult();

        $recordsFiltered = $entityManager
            ->createQuery($dqlCountFiltered)
            ->getSingleScalarResult();

        $output = array(
            'draw' => 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'dql' => $dql,
            'dqlCountFiltered' => $dqlCountFiltered,
        );

        return $output;
    }

}