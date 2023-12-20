<?php

namespace AppBundle\Repository;
use AppBundle\Entity\ControlCalidadCultivo;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * ControlCalidadCultivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ControlCalidadCultivoRepository extends \Doctrine\ORM\EntityRepository
{
    public function agregarControlCalidadCultivo($data)
    {
        $msg = 'ok';

        if(!$this->buscaControlCalidadCultivoExiste($data['id_laboratorio'])){
            try{
                $em  = $this->getEntityManager();
                $obj = new ControlCalidadCultivo();

                $obj->setBMasCMas(    $data['b_mas_c_mas']  );
                $obj->setBMasCNr(     $data['b_mas_c_nr']   );
                $obj->setBMenosCMas(  $data['b_menos_c_mas']);
                $obj->setBMasCMenos(  $data['b_mas_c_menos']);
                $obj->setBMasCCont(   $data['b_mas_c_cont'] );
                $obj->setBNrCMas(     $data['b_nr_c_mas']   );
                $obj->setTotalLJInoc( $data['total_lj_inoc']);
                $obj->setTotalLJCont( $data['total_lj_cont']);

                $obj->setBMasCMasDiag(      $data['b_mas_c_mas_diag']    );
                $obj->setBMasCMenosDiag(    $data['b_mas_c_menos_diag']  );
                $obj->setBMasCContDiag(     $data['b_mas_c_cont_diag']   );
                $obj->setXpertMasCMasDiag(  $data['xpert_mas_c_mas_diag']);

                $lab  = $em->getRepository('AppBundle:AreaSalud')->find($data['id_laboratorio']);
                $obj->setLaboratorio($lab);
                $obj->setFechaEntrada(new \DateTime('now'));
                $obj->setFechaModificada(new \DateTime('now'));

                $em->persist($obj);
                $em->flush();

            }catch (\Exception $e)
            {
                $msg = 'Se produjo un error al insertar el Control de Calidad. Intente insertarlo nuevamente.';
            }
        }
        else
            $msg = 'El Control de Calidad del Cultivo ya fue insertado este mes.';

        return $msg;
    }

    public function modificarControlCalidadCultivo($data)
    {
        $msg = 'ok';

        try
        {
            $em  = $this->getEntityManager();
            $obj = $em->getRepository('AppBundle:ControlCalidadCultivo')->find($data['id_laboratorio']);

            $obj->setBMasCMas(   $data['b_mas_c_mas']);
            $obj->setBMasCNr(    $data['b_mas_c_nr']);
            $obj->setBMenosCMas( $data['b_menos_c_mas']);
            $obj->setBMasCMenos( $data['b_mas_c_menos']);
            $obj->setBMasCCont(  $data['b_mas_c_cont']);
            $obj->setBNrCMas(    $data['b_nr_c_mas']);

            $obj->setTotalLJInoc($data['total_lj_inoc']);
            $obj->setTotalLJCont($data['total_lj_cont']);

            $obj->setBMasCMasDiag(      $data['b_mas_c_mas_diag']);
            $obj->setBMasCMenosDiag(    $data['b_mas_c_menos_diag']);
            $obj->setBMasCContDiag(     $data['b_mas_c_cont_diag']);
            $obj->setXpertMasCMasDiag(  $data['xpert_mas_c_mas_diag']);

            $obj->setFechaModificada(new \DateTime('now'));

            $em->persist($obj);
            $em->flush();

        }catch (\Exception $e)
        {
            $msg = 'Error';
        }

        return $msg;
    }

    public function eliminarControlCalidadCultivo($id)
    {
        try
        {
            $em  = $this->getEntityManager();
            $obj = $em->getRepository('AppBundle:ControlCalidadCultivo')->find($id);

            $em->remove($obj);
            $em->flush();
            $msg = $obj;

        }catch (\Exception $e){

            if(strpos($e->getMessage() , 'foreign key') > 0)
            {
                $msg = 'Existen datos asociados a este Control, no se puede eliminar.';
            }
            else
            {
                $msg = 'Se produjo un error al eliminar el Control de Calidad del Cultivo.';
            }
        }
        return $msg;
    }

    public function buscaControlCalidadCultivoExiste($id_laboratorio)
    {
        $existe = false;

        $fechaActual = new \DateTime('now');

        $id_anno = $fechaActual->format('Y');
        $id_mes  = $fechaActual->format('m');

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

    public function reporteControlCalidadCultivoJson($id_laboratorio, $id_mes, $id_anno, $id_trimestre, $id_provincia, $id_municipio)
    {
        $em = $this->getEntityManager();

        if( $id_trimestre < 1 ){

            $rangoFecha = $this->fechaRangoMes($id_mes,$id_anno);

            $dql = "SELECT control FROM AppBundle:ControlCalidadCultivo control WHERE control.laboratorio = ?1 AND
                           control.fechaEntrada >= $rangoFecha[0] AND control.fechaEntrada <= $rangoFecha[1]";

        }
        else{

            $rangoFecha = $this->RangoTrimestre($id_trimestre, $id_anno);
            $dql        = $this->calidadCultivoTrimestral($rangoFecha[0], $rangoFecha[1], $id_laboratorio, $id_provincia, $id_municipio);

        }


        $query = $em->createQuery($dql);

        if( $id_trimestre < 1 )
            $query->setParameter(1,$id_laboratorio);

        $result = $query->getResult();

        if( count($result) == 1 && $id_trimestre < 1){

            $datos = array(
                'id_lab'          => $result[0]->getLaboratorio()->getId(),
                'b_Mas_c_Mas'     => $result[0]->getBMasCMas(),
                'b_Mas_c_Nr'      => $result[0]->getBMasCNr(),
                'b_Menos_c_Mas'   => $result[0]->getBMenosCMas(),
                'b_Mas_c_Menos'   => $result[0]->getBMasCMenos(),
                'b_Mas_c_Cont'    => $result[0]->getBMasCCont(),
                'b_Nr_c_Mas'      => $result[0]->getBNrCMas(),
                'total_LJ_Inoc'   => $result[0]->getTotalLJInoc(),
                'total_LJ_Cont'   => $result[0]->getTotalLJCont(),

                'b_mas_c_mas_diag'     => $result[0]->getBMasCMasDiag(),
                'b_mas_c_menos_diag'   => $result[0]->getBMasCMenosDiag(),
                'b_mas_c_cont_diag'    => $result[0]->getBMasCContDiag(),
                'xpert_mas_c_mas_diag' => $result[0]->getXpertMasCMasDiag(),

                'fechaEntrada'    => $result[0]->getFechaEntrada()->format('d-m-Y'),
                'fechaModificada' => $result[0]->getFechaModificada()->format('d-m-Y')
            );
            return $datos;
        }

        elseif( count($result) >= 1 ){

            $b_Mas_c_Mas           = 0;
            $b_Mas_c_Nr            = 0;
            $b_Menos_c_Mas         = 0;
            $b_Mas_c_Menos         = 0;
            $b_Mas_c_Cont          = 0;
            $b_Nr_c_Mas            = 0;
            $total_LJ_Inoc         = 0;
            $total_LJ_Cont         = 0;
            $b_mas_c_mas_diag      = 0;
            $b_mas_c_menos_diag    = 0;
            $b_mas_c_cont_diag     = 0;
            $xpert_mas_c_mas_diag  = 0;

            $fechaInicialTrimm = substr($rangoFecha[0], 1,10);
            $fechaFinalTrim    = substr($rangoFecha[1], 1,10);

            $fechaInicialTrim = new \DateTime($fechaInicialTrimm);
            $fechaFinalTrim   = new \DateTime($fechaFinalTrim);

            for( $i = 0; $i < count($result); $i++ ){

                $b_Mas_c_Mas     = $b_Mas_c_Mas   + $result[$i]->getBMasCMas();
                $b_Mas_c_Nr      = $b_Mas_c_Nr    + $result[$i]->getBMasCNr();
                $b_Menos_c_Mas   = $b_Menos_c_Mas + $result[$i]->getBMenosCMas();
                $b_Mas_c_Menos   = $b_Mas_c_Menos + $result[$i]->getBMasCMenos();
                $b_Mas_c_Cont    = $b_Mas_c_Cont  + $result[$i]->getBMasCCont();
                $b_Nr_c_Mas      = $b_Nr_c_Mas    + $result[$i]->getBNrCMas();
                $total_LJ_Inoc   = $total_LJ_Inoc + $result[$i]->getTotalLJInoc();
                $total_LJ_Cont   = $total_LJ_Cont + $result[$i]->getTotalLJCont();

                $b_mas_c_mas_diag      = $b_mas_c_mas_diag     + $result[$i]->getBMasCMasDiag();
                $b_mas_c_menos_diag    = $b_mas_c_menos_diag   + $result[$i]->getBMasCMenosDiag();
                $b_mas_c_cont_diag     = $b_mas_c_cont_diag    + $result[$i]->getBMasCContDiag();
                $xpert_mas_c_mas_diag  = $xpert_mas_c_mas_diag + $result[$i]->getXpertMasCMasDiag();

            }

            $datos = array(
                'id_lab'           => $result[0]->getLaboratorio()->getId(),
                'b_Mas_c_Mas'      => $b_Mas_c_Mas,
                'b_Mas_c_Nr'       => $b_Mas_c_Nr,
                'b_Menos_c_Mas'    => $b_Menos_c_Mas,
                'b_Mas_c_Menos'    => $b_Mas_c_Menos,
                'b_Mas_c_Cont'     => $b_Mas_c_Cont,
                'b_Nr_c_Mas'       => $b_Nr_c_Mas,
                'total_LJ_Inoc'    => $total_LJ_Inoc,
                'total_LJ_Cont'    => $total_LJ_Cont,

                'b_mas_c_mas_diag'     => $b_mas_c_mas_diag,
                'b_mas_c_menos_diag'   => $b_mas_c_menos_diag,
                'b_mas_c_cont_diag'    => $b_mas_c_cont_diag,
                'xpert_mas_c_mas_diag' => $xpert_mas_c_mas_diag,

                'fechaInicialTrim' => $fechaInicialTrim->format('d-m-Y'),
                'fechaFinalTrim'   => $fechaFinalTrim->format('d-m-Y')
            );

            return $datos;
        }

        else{

            $datos = array();
            return $datos;
        }

    }

    public function reporteControlCalidadCultivoExcel($id_laboratorio, $id_mes, $id_anno, $id_trimestre, $id_provincia, $id_municipio)
    {
        $matriz_resultado = $this->reporteControlCalidadCultivoJson($id_laboratorio, $id_mes, $id_anno, $id_trimestre, $id_provincia, $id_municipio);

        $nombre_provincia   = "Todas";
        $nombre_municipio   = "Todos";
        $nombre_laboratorio = "Todos";

        $em = $this->getEntityManager();

        if( count($matriz_resultado) > 0 ){

            $total_cociente = $matriz_resultado['b_Mas_c_Mas']   +
                              $matriz_resultado['b_Mas_c_Nr']    +
                              $matriz_resultado['b_Menos_c_Mas'] +
                              $matriz_resultado['b_Mas_c_Menos'] +
                              $matriz_resultado['b_Mas_c_Cont']  ;

            $total_cociente_diag =  $matriz_resultado['b_mas_c_mas_diag']     +
                                    $matriz_resultado['b_mas_c_menos_diag']   +
                                    $matriz_resultado['b_mas_c_cont_diag']    +
                                    $matriz_resultado['xpert_mas_c_mas_diag'] ;

            $acd    = ( $matriz_resultado['b_Menos_c_Mas']  / $total_cociente )*100;
            $bkcu   = ( $matriz_resultado['b_Mas_c_Menos']  / $total_cociente )*100;
            $tc     = ( $matriz_resultado['total_LJ_Cont']  / $matriz_resultado['total_LJ_Inoc'] )*100;
            $bkxcu  = (($matriz_resultado['b_mas_c_mas_diag'] + $matriz_resultado['xpert_mas_c_mas_diag']) / $total_cociente_diag) * 100;


            $acd   = round($acd,  2, PHP_ROUND_HALF_UP);
            $bkcu  = round($bkcu, 2, PHP_ROUND_HALF_UP);
            $tc    = round($tc,   2, PHP_ROUND_HALF_UP);
            $bkxcu = round($bkxcu,   2, PHP_ROUND_HALF_UP);

            if($id_provincia > 0){
                $provincia        = $em->getRepository('AppBundle:Provincia')->findOneBy(array( 'id' => $id_provincia));
                $nombre_provincia = $provincia->getNombre();
            }
            if($id_municipio > 0){
                $municipio        = $em->getRepository('AppBundle:Municipio')->findOneBy(array( 'id' => $id_municipio));
                $nombre_municipio = $municipio->getNombre();
            }
            if($id_laboratorio > 0){
                $laboratorio        = $em->getRepository('AppBundle:AreaSalud')->findOneBy(array( 'id' => $id_laboratorio));
                $nombre_laboratorio = $laboratorio->getNombre();
            }

            $datos = array(
                'nomLab'          => $nombre_laboratorio,
                'nomProv'         => $nombre_provincia,
                'nomMunic'        => $nombre_municipio,
                'b_Mas_c_Mas'     => $matriz_resultado['b_Mas_c_Mas'],
                'b_Mas_c_Nr'      => $matriz_resultado['b_Mas_c_Nr'],
                'b_Menos_c_Mas'   => $matriz_resultado['b_Menos_c_Mas'],
                'b_Mas_c_Menos'   => $matriz_resultado['b_Mas_c_Menos'],
                'b_Mas_c_Cont'    => $matriz_resultado['b_Mas_c_Cont'],
                'b_Nr_c_Mas'      => $matriz_resultado['b_Nr_c_Mas'],
                'total_LJ_Inoc'   => $matriz_resultado['total_LJ_Inoc'],
                'total_LJ_Cont'   => $matriz_resultado['total_LJ_Cont'],

                'b_mas_c_mas_diag'     => $matriz_resultado['b_mas_c_mas_diag']    ,
                'b_mas_c_menos_diag'   => $matriz_resultado['b_mas_c_menos_diag']  ,
                'b_mas_c_cont_diag'    => $matriz_resultado['b_mas_c_cont_diag']   ,
                'xpert_mas_c_mas_diag' => $matriz_resultado['xpert_mas_c_mas_diag'],

                'fechaEntrada'    => isset($matriz_resultado['fechaEntrada'])    ? $matriz_resultado['fechaEntrada']    : $matriz_resultado['fechaInicialTrim'],
                'fechaModificada' => isset($matriz_resultado['fechaModificada']) ? $matriz_resultado['fechaModificada'] : $matriz_resultado['fechaFinalTrim'],
                'acd'             => $acd,
                'bkcu'            => $bkcu,
                'tc'              => $tc,
                'bkxcu'           => $bkxcu,
                'trimestre'       => $id_trimestre,
                'anno'            => $id_anno,
            );
            return $datos;

        }
        else{
            $datos = array();
            return $datos;
        }


//        $rangoFecha = $this->fechaRangoMes($id_mes,$id_anno);
//
//        $em = $this->getEntityManager();
//
//        $dql = "SELECT control FROM AppBundle:ControlCalidadCultivo control
//                WHERE control.laboratorio = ?1 AND control.fechaEntrada >= $rangoFecha[0] AND control.fechaEntrada <= $rangoFecha[1]";
//
//        $query = $em->createQuery($dql);
//        $query->setParameter(1,$id_laboratorio);
//
//        $result = $query->getResult();
//
//        $total_cociente = $result[0]->getBMasCMas()   +
//                          $result[0]->getBMasCNr()    +
//                          $result[0]->getBMenosCMas() +
//                          $result[0]->getBMasCMenos() +
//                          $result[0]->getBMasCCont()  ;
//
//        $acd  = ( $result[0]->getBMenosCMas()  / $total_cociente )*100;
//        $bkcu = ( $result[0]->getBMasCMenos()  / $total_cociente )*100;
//        $tc   = ( $result[0]->getTotalLJCont() / $result[0]->getTotalLJInoc() )*100;
//
//        $acd  = round($acd, 2, PHP_ROUND_HALF_UP);
//        $bkcu = round($bkcu, 2, PHP_ROUND_HALF_UP);
//        $tc   = round($tc, 2, PHP_ROUND_HALF_UP);
//
//        if(count($result)>0){
//
//            $datos = array(
//                'nomLab'          => $result[0]->getLaboratorio()->getNombre(),
//                'nomProv'         => $result[0]->getLaboratorio()->getMunicipio()->getProvincia()->getNombre(),
//                'nomMunic'        => $result[0]->getLaboratorio()->getMunicipio()->getNombre(),
//                'b_Mas_c_Mas'     => $result[0]->getBMasCMas(),
//                'b_Mas_c_Nr'      => $result[0]->getBMasCNr(),
//                'b_Menos_c_Mas'   => $result[0]->getBMenosCMas(),
//                'b_Mas_c_Menos'   => $result[0]->getBMasCMenos(),
//                'b_Mas_c_Cont'    => $result[0]->getBMasCCont(),
//                'b_Nr_c_Mas'      => $result[0]->getBNrCMas(),
//                'total_LJ_Inoc'   => $result[0]->getTotalLJInoc(),
//                'total_LJ_Cont'   => $result[0]->getTotalLJCont(),
//                'fechaEntrada'    => $result[0]->getFechaEntrada()->format('d-m-Y'),
//                'fechaModificada' => $result[0]->getFechaModificada()->format('d-m-Y'),
//                'acd'             => $acd,
//                'bkcu'            => $bkcu,
//                'tc'              => $tc,
//            );
//            return $datos;
//        }
//
//        else{
//            $datos = array();
//            return $datos;
//        }

    }

    public function listadoControlCalidadCultivoMesActual()
    {
        $fechaActual = new \DateTime('now');

        $id_anno  =  $fechaActual->format('Y');
        $id_mes =  $fechaActual->format('m');

        $rangoFecha = $this->fechaRangoMes($id_mes, $id_anno);

        $em = $this->getEntityManager();

        $dql = "SELECT control FROM AppBundle:ControlCalidadCultivo control
                WHERE control.fechaEntrada >= $rangoFecha[0] AND control.fechaEntrada <= $rangoFecha[1]";

        $query = $em->createQuery($dql);
        $result = $query->getResult();

        if(count($result)>0)
        {
            $datos = array(
                'id_lab'          => $result[0]->getLaboratorio()->getId(),
                'nomLab'          => $result[0]->getLaboratorio()->getNombre(),
                'nomProv'         => $result[0]->getLaboratorio()->getMunicipio()->getProvincia()->getNombre(),
                'nomMunic'        => $result[0]->getLaboratorio()->getMunicipio()->getNombre(),
                'fechaModificada' => $result[0]->getFechaModificada()->format('d-m-Y')
            );
            return $result;
        }

        else{
            $datos = array();
            return $result;
        }
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

    public function RangoTrimestre($trimestre,$anno)
    {
        $fechaActual = new \DateTime('now');

        if(empty($anno))
            $year =  $fechaActual->format('Y');
        else
            $year = $anno;

        if($trimestre==1)
            return array("'".$year.'-01-01'."'","'".$year.'-03-31'."'");

        if($trimestre==2)
            return array("'".$year.'-04-01'."'","'".$year.'-06-30'."'");

        if($trimestre==3)
            return array("'".$year.'-07-01'."'","'".$year.'-09-30'."'");

        if($trimestre==4)
            return array("'".$year.'-10-01'."'","'".$year.'-12-31'."'");
    }

    public function calidadCultivoTrimestral($fechaInicio, $fechaFinal, $id_laboratorio, $id_provincia, $id_municipio){

        $dql_1 = "SELECT cc FROM AppBundle:ControlCalidadCultivo cc ";
        $dql_2 = "";
        $dql_4 = "";
        $dql_5 = "";
        $dql_6 = "";

        if($id_laboratorio > 0)
        {
            $dql_4 = " AND lab.id = $id_laboratorio ";
        }
        if($id_provincia > 0 && $id_provincia != '')
        {
            $dql_2 = " JOIN cc.laboratorio lab JOIN lab.municipio mnp JOIN mnp.provincia prov ";
            $dql_5 = " AND prov.id = $id_provincia ";
        }
        if($id_municipio > 0 && $id_municipio != '')
        {
            $dql_6 = " AND mnp.id = $id_municipio ";
        }

        $dql_3 = " WHERE cc.fechaEntrada >= $fechaInicio AND cc.fechaEntrada <= $fechaFinal";

        $dql = $dql_1.$dql_2.$dql_3.$dql_4.$dql_5.$dql_6;

        return $dql;

    }
}
