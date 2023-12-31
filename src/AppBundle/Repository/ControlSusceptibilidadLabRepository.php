<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ControlSusceptibilidadLab;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * ControlSusceptibilidadLabRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ControlSusceptibilidadLabRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarSusceptibilidadLab($data)
    {
        $msg = 'ok';

            try{
                $em  = $this->getEntityManager();
                $obj = new ControlSusceptibilidadLab();

                $pacEvolucion  = $em->getRepository('AppBundle:PacienteEvolucion')->find($data['id_PacienteEvol']);
                $obj->setPacienteEvolucion($pacEvolucion);

                $obj->setCodigoMuestra($data['codigo_Muestra']);

                $resistencia  = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia']);
                $obj->setResistencia($resistencia);

                $obj->setMetFenNitFh($data['met_fen_nit_fh']);
                $obj->setMetFenNitFr($data['met_fen_nit_fr']);
                if($data['fechaFenoNitra'] != '' || $data['fechaFenoNitra'] != '')
                    $obj->setFechaFenoNitra(new \DateTime($data['fechaFenoNitra']));

                $obj->setMetFenPropFs($data['met_fen_prop_fs']);
                if($data['fechaFenoPropFS'] != '' || $data['fechaFenoPropFS'] != '')
                    $obj->setFechaFenoPropFs(new \DateTime($data['fechaFenoPropFS']));

                $obj->setMetFenPropFe($data['met_fen_prop_fe']);
//                if($data['fechaFenoPropFE'] != '' || $data['fechaFenoPropFE'] != '')
//                    $obj->setFechaFenoPropFe(new \DateTime($data['fechaFenoPropFE']));
//
                $obj->setMetFenPropFam($data['met_fen_prop_fam']);
//                if($data['fechaFenoPropFAM'] != '' || $data['fechaFenoPropFAM'] != '')
//                    $obj->setFechaFenoPropFAM(new \DateTime($data['fechaFenoPropFAM']));
//
                $obj->setMetFenPropFcm($data['met_fen_prop_fcm']);
//                if($data['fechaFenoPropFCM'] != '' || $data['fechaFenoPropFCM'] != '')
//                    $obj->setFechaFenoPropFCM(new \DateTime($data['fechaFenoPropFCM']));
//
                $obj->setMetFenPropFkm($data['met_fen_prop_fkm']);
//                if($data['fechaFenoPropFKM'] != '' || $data['fechaFenoPropFKM'] != '')
//                    $obj->setFechaFenoPropFKM(new \DateTime($data['fechaFenoPropFKM']));
//
                $obj->setMetFenPropFmfx($data['met_fen_prop_fmfx']);
//                if($data['fechaFenoPropFMFX'] != '' || $data['fechaFenoPropFMFX'] != '')
//                    $obj->setFechaFenoPropFMFX(new \DateTime($data['fechaFenoPropFMFX']));

                $obj->setMetMtbdrplusFh($data['met_mtbdrplus_fh']);
                $obj->setMetMtbdrplusFr($data['met_mtbdrplus_fr']);
                if($data['fechaMTBDRPlus'] != '' || $data['fechaMTBDRPlus'] != '')
                    $obj->setFechaMTBDRPlus(new \DateTime($data['fechaMTBDRPlus']));

                $obj->setMetMtbdrslFfq(   $data['met_mtbdrsl_ffq']  );
                $obj->setMetMtbdrslFagcp( $data['met_mtbdrsl_fagcp']);
                $obj->setMetMtbdrslFkan(  $data['met_mtbdrsl_fkan'] );
                if($data['fechaMTBDRSL'] != '' || $data['fechaMTBDRSL'] != '')
                    $obj->setFechaMTBDRSL(new \DateTime($data['fechaMTBDRSL']));

                $obj->setFechaEntradaFila(new \DateTime('now'));
                $obj->setFechaModificadaFila(new \DateTime('now'));

                $obj->setObservaciones($data['observaciones']);
                $obj->setIdTablaPac($data['idTablaPac']);

                $resistencia_parc_nitra      = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_nitra']);
                $obj->setResistenciaParcNitra($resistencia_parc_nitra);
                $resistencia_parc_prop       = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_prop']);
                $obj->setResistenciaParcProp($resistencia_parc_prop);
                $resistencia_parc_mtbdrplus  = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_mtbdrplus']);
                $obj->setResistenciaParcMtbdrplus($resistencia_parc_mtbdrplus);
                $resistencia_parc_mtbdrsl    = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_mtbdrsl']);
                $obj->setResistenciaParcMtbdrsl($resistencia_parc_mtbdrsl);

                $em->persist($obj);
                $em->flush();

            }catch (\Exception $e)
            {
                $msg = 'Se produjo un error al insertar el Control de Susceptibilidad. Intente insertarlo nuevamente.';
            }

        return $msg;
    }

    public function modificarSusceptibilidadLab($data)
    {
        $msg = 'ok';

        //if(){}
        try{
            $em = $this->getEntityManager();

            $obj= $em->getRepository('AppBundle:ControlSusceptibilidadLab')->find($data['id_AnalisisSelect']);

            $resistencia  = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia']);
            $obj->setResistencia($resistencia);

            $obj->setMetFenNitFh($data['met_fen_nit_fh']);
            $obj->setMetFenNitFr($data['met_fen_nit_fr']);
            if($data['fechaFenoNitra'] != '' || $data['fechaFenoNitra'] != '')
                $obj->setFechaFenoNitra(new \DateTime($data['fechaFenoNitra']));

            $obj->setMetFenPropFs($data['met_fen_prop_fs']);
            if($data['fechaFenoPropFS'] != '' || $data['fechaFenoPropFS'] != '')
                $obj->setFechaFenoPropFs(new \DateTime($data['fechaFenoPropFS']));

            $obj->setMetFenPropFe($data['met_fen_prop_fe']);
//            if($data['fechaFenoPropFE'] != '' || $data['fechaFenoPropFE'] != '')
//                $obj->setFechaFenoPropFe(new \DateTime($data['fechaFenoPropFE']));
//
            $obj->setMetFenPropFam($data['met_fen_prop_fam']);
//            if($data['fechaFenoPropFAM'] != '' || $data['fechaFenoPropFAM'] != '')
//                $obj->setFechaFenoPropFAM(new \DateTime($data['fechaFenoPropFAM']));
//
            $obj->setMetFenPropFcm($data['met_fen_prop_fcm']);
//            if($data['fechaFenoPropFCM'] != '' || $data['fechaFenoPropFCM'] != '')
//                $obj->setFechaFenoPropFCM(new \DateTime($data['fechaFenoPropFCM']));
//
            $obj->setMetFenPropFkm($data['met_fen_prop_fkm']);
//            if($data['fechaFenoPropFKM'] != '' || $data['fechaFenoPropFKM'] != '')
//                $obj->setFechaFenoPropFKM(new \DateTime($data['fechaFenoPropFKM']));
//
            $obj->setMetFenPropFmfx($data['met_fen_prop_fmfx']);
//            if($data['fechaFenoPropFMFX'] != '' || $data['fechaFenoPropFMFX'] != '')
//                $obj->setFechaFenoPropFMFX(new \DateTime($data['fechaFenoPropFMFX']));

            $obj->setMetMtbdrplusFh($data['met_mtbdrplus_fh']);
            $obj->setMetMtbdrplusFr($data['met_mtbdrplus_fr']);
            if($data['fechaMTBDRPlus'] != '' || $data['fechaMTBDRPlus'] != '')
                $obj->setFechaMTBDRPlus(new \DateTime($data['fechaMTBDRPlus']));

            $obj->setMetMtbdrslFfq($data['met_mtbdrsl_ffq']);
            $obj->setMetMtbdrslFagcp($data['met_mtbdrsl_fagcp']);
            $obj->setMetMtbdrslFkan($data['met_mtbdrsl_fkan']);
            if($data['fechaMTBDRSL'] != '' || $data['fechaMTBDRSL'] != '')
                $obj->setFechaMTBDRSL(new \DateTime($data['fechaMTBDRSL']));

            $obj->setFechaModificadaFila(new \DateTime('now'));

            $obj->setObservaciones($data['observaciones']);

            $resistencia_parc_nitra      = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_nitra']);
            $obj->setResistenciaParcNitra($resistencia_parc_nitra);
            $resistencia_parc_prop       = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_prop']);
            $obj->setResistenciaParcProp($resistencia_parc_prop);
            $resistencia_parc_mtbdrplus  = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_mtbdrplus']);
            $obj->setResistenciaParcMtbdrplus($resistencia_parc_mtbdrplus);
            $resistencia_parc_mtbdrsl    = $em->getRepository('AppBundle:Resistencia')->find($data['id_resistencia_parc_mtbdrsl']);
            $obj->setResistenciaParcMtbdrsl($resistencia_parc_mtbdrsl);

            $em->persist($obj);
            $em->flush();

        }catch (\Exception $e)
        {
            $msg = $e->getMessage().'Se produjo un error al actualizar el Control de Susceptibilidad. Intente actualizarlo nuevamente.';
        }

        return $msg;
    }

    public function eliminarSusceptibilidadLab($id)
    {

    }

    public function buscaSusceptibilidadLabExiste($id_laboratorio)
    {
        $existe = false;

        $fechaActual = new \DateTime('now');

        $id_anno  =  $fechaActual->format('Y');
        $id_mes =  $fechaActual->format('m');

        $rangoFecha = $this->fechaRangoMes($id_mes, $id_anno);

        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(control) FROM AppBundle:ControlCalidadCultivo control
                WHERE control.laboratorio = ?1 AND control.fechaEntrada >= $rangoFecha[0] AND control.fechaEntrada <= $rangoFecha[1]";

        $query = $em->createQuery($dql);
        $query->setParameter(1,$id_laboratorio);

        $result = $query->getResult();

        if($result[0][1]>0)
            $existe = true;

        return $existe;
    }

    public function fechaRangoMes($id_mes, $id_anno)
    {
        $fecha = new \DateTime( $id_anno."-".$id_mes."-01" );

        $year  =  $fecha->format('Y');
        $month =  $fecha->format('m');

        //CANTIDAD DE DIAS QUE TIENE EL MES EN EL AÑO ESCOGIDO
        $numDaysMonth = cal_days_in_month (CAL_GREGORIAN, $month,$year);

        return array("'".$year.'-'.$month.'-01'."'","'".$id_anno.'-'.$id_mes.'-'.$numDaysMonth."'");

    }

    //ESTE METODO SOLO LISTARA LOS ANALISIS DE SUSCEPTIBILIDAD REALIZADOS A LA CEPA O CEPAS DEL PACIENTE DE LA EVOLUCION ACTUAL
    //QUIERE DECIR QUE EL PACIENTE SE ENCUENTRA EN ESTUDIO
    public function listaAnalisisRealizados($idEvolucion){

        $em = $this->getEntityManager();

        $dql = "SELECT control FROM AppBundle:ControlSusceptibilidadLab control
                WHERE control.pacienteEvolucion = ?1 ORDER BY control.fechaEntradaFila";

        $query = $em->createQuery($dql);
        $query->setParameter(1,$idEvolucion);
        $result = $query->getResult();

        return $result;
    }

    //ESTE METODO LISTARA TODOS LOS ANALISIS DE SUSCEPTIBILIDAD REALIZADOS A LAS CEPAS DEL PACIENTE DE TODAS LAS VECES
    //QUE HA SIDO INSERTADO EN EL ESTUDIO
    public function listaAnalisisRealizadosHistorico($idPaciente){

        $em = $this->getEntityManager();

        $dql = "SELECT control FROM AppBundle:ControlSusceptibilidadLab control
            WHERE control.idTablaPac = ?1 ORDER BY control.fechaEntradaFila";

        $query = $em->createQuery($dql);
        $query->setParameter(1,$idPaciente);
        $result = $query->getResult();

        return $result;
    }

    //ESTE METODO BUSCARA EL ANALISIS DE SUSCEPTIBILIDAD SELECCIONADO EN EL HISTORICO
    public function obtenerAnalisisRealizadoHistorico($idTablaSuscept){

        $em = $this->getEntityManager();

        $dql = "SELECT control FROM AppBundle:ControlSusceptibilidadLab control
            WHERE control.id = ?1";

        $query = $em->createQuery($dql);
        $query->setParameter(1,$idTablaSuscept);
        $result = $query->getResult();

        return $result;
    }

    //ESTE METODO BUSCARA LOS PACIENTES QUE TIENEN REALIZADOS ANALISIS DE SUSCEPTIBILIDAD
    //ES DECIR TODOS LOS QUE SE ENCUENTRAN EN LA TABLA DE CONTROL_SUSCEPTIBILAD_LAB
    public function obtenerListPacAnalisisRealizados($user)
    {
        //Se buscara por la columna de idTablaPac y se agrupara por ella. Con ello se obtienen los pacientes que tienen
        //realizados al menos un analisis de susceptibilidad
        $em = $this->getEntityManager();

        $nivelAcceso = $user->getNivelAcceso()->getNivel();

        if($nivelAcceso == 'nacional')
        {
            $dql = 'SELECT control FROM AppBundle:ControlSusceptibilidadLab control JOIN control.pacienteEvolucion e
            WHERE control.pacienteEvolucion IS NOT NULL
            GROUP BY control.idTablaPac ORDER BY control.fechaEntradaFila DESC';

            $query = $em->createQuery($dql);
        }
        elseif($nivelAcceso == 'provincial')
        {
            $provincia = $user->getAreaSalud()->getMunicipio()->getProvincia()->getCodigo();

            $dql = 'SELECT control FROM AppBundle:ControlSusceptibilidadLab control JOIN control.pacienteEvolucion e
                    JOIN e.areaSalud a JOIN a.municipio m JOIN m.provincia p
                    WHERE control.pacienteEvolucion IS NOT NULL AND  p.codigo = :codigo GROUP BY control.idTablaPac ORDER BY control.fechaEntradaFila DESC';

            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $provincia);
        }
        elseif($nivelAcceso == 'municipal')
        {
            $municipio = $user->getAreaSalud()->getMunicipio()->getCodigo();

            $dql = 'SELECT control FROM AppBundle:ControlSusceptibilidadLab control JOIN control.pacienteEvolucion e
                    JOIN e.areaSalud a JOIN a.municipio m
                    WHERE control.pacienteEvolucion IS NOT NULL AND  m.codigo = :codigo GROUP BY control.idTablaPac ORDER BY control.fechaEntradaFila DESC';

            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $municipio);
        }
        else
        {
            $areaSalud = $user->getAreaSalud()->getCodigo();

            $dql = 'SELECT control FROM AppBundle:ControlSusceptibilidadLab control JOIN control.pacienteEvolucion e
                    JOIN e.areaSalud a
                    WHERE control.pacienteEvolucion IS NOT NULL AND  a.codigo = :codigo GROUP BY control.idTablaPac ORDER BY control.fechaEntradaFila DESC';

            $query = $em->createQuery($dql);
            $query->setParameter('codigo' , $areaSalud);
        }

        $result = $query->getResult();

        return $result;
    }
}
