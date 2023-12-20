<?php
/**
 * Created by PhpStorm.
 * User: danielito
 * Date: 23/08/2017
 * Time: 20:19
 */

namespace AppBundle\ImprimirExcel;

use \PHPExcel;


class ImpHistoricoSusceptTotal
{

    public function DatosPDF($datos)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Análisis de susceptibilidad ');

        $this->HeadBloq($objPHPExcel);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:R1');//ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:G3');//NOMBRE DEL PACIENTE
        //Se coloca el 4 para empezar en B4
        $pos = 4;
        for($i = 0; $i < count($datos); $i++)
        {
            $this->MergeCellsBloq($objPHPExcel,$pos);
            $pos = $pos + 8;
        }


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','PACIENTE:');
        $nombreCompletoPac = $datos[0]->getPacienteEvolucion()->getPaciente()->getNombre().' '.$datos[0]->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$datos[0]->getPacienteEvolucion()->getPaciente()->getSegundoApellido();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3',$nombreCompletoPac);
        $pos = 4;
        for($i = 0; $i < count($datos); $i++)
        {
            $this->TitlesCellBloq($objPHPExcel, $datos[$i], $pos);
            $pos = $pos + 8;
        }


        //Se dimensiona la columna de arriba para que los nombres queden al ancho de la columna.
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(16);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setWidth(12);

        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('W')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('X')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Z')->setWidth(20);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('AA')->setWidth(100);


        $pos = 0;
        for($i = 0; $i < count($datos); $i++)
        {
            $this->AllValues($objPHPExcel, $datos[$i], $pos);
            $pos = $pos + 8;
        }


        //Creamos los estilos que seran aplicados a las celdas del excel
        $estiloBloque_HEAD = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>12,
                'color'     => array(
                    'argb' => '000'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'D9D9D9')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_1 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>12,
                'color'     => array(
                    'rgb' => 'ffffff'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => '16365C')
            ),
//            'borders' => array(
//                'allborders' => array(
//                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
//                )
//            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_2 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>12,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_3 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>10,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_4 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => false,
                'italic'    => false,
                'strike'    => false,
                'size' =>9,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_5 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => '76933C')
            )
        );
        $estiloBloque_6 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'D8E4BC')
            )
        );
        $estiloBloque_7 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'C4D79B')
            )
        );
        $estiloBloque_8 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => '538DD5')
            )
        );
        $estiloBloque_9 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'B3D9FF')
            )
        );
        $estiloBloque_10 = array(
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'CCECFF')
            )
        );
        $estiloBloque_11 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>11,
                'color'     => array(
                    'rgb' => 'ffffff'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => '16365C')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_12 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => false,
                'italic'    => false,
                'strike'    => false,
                'size' =>11,
                'color'     => array(
                    'rgb' => 'ffffff'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => '16365C')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_13 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>10,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'D9D9D9')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_14 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => false,
                'italic'    => false,
                'strike'    => false,
                'size' =>9,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'D9D9D9')
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );


        $pos = 4;
        for($i = 0; $i < count($datos); $i++)
        {
            $this->StyleCellBloq($objPHPExcel, $estiloBloque_HEAD, $estiloBloque_1, $estiloBloque_2, $estiloBloque_3, $estiloBloque_4, $estiloBloque_5
                , $estiloBloque_6, $estiloBloque_7, $estiloBloque_8, $estiloBloque_9, $estiloBloque_10, $estiloBloque_11, $estiloBloque_12, $estiloBloque_13
                , $estiloBloque_14, $pos);
            $pos = $pos + 8;
        }


        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);


        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteSuscept.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function HeadBloq($objPHPExcel){
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("MINISTERIO SALUD") // Nombre del autor
        ->setLastModifiedBy("MINISTERIO SALUD") //Ultimo usuario que lo modific�
        ->setTitle("REPORTE Análisis de Susceptibilidad") // Titulo
        ->setSubject("REPORTE Análisis de Susceptibilidad") //Asunto
        ->setDescription("REPORTE Análisis de Susceptibilidad") //Descripci�n
        ->setKeywords("REPORTE Análisis de Susceptibilidad") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function MergeCellsBloq($objPHPExcel, $pos){

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.($pos-1).':O'.($pos-1));//RESULTADO XPERT DEL PACIENTE

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$pos.':K'.$pos);//RESULTADO FENOTÍPICO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$pos.':R'.$pos);//RESULTADO GENOTÍPICO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($pos+1).':D'.($pos+1));//MÉTODO DE LA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($pos+1).':K'.($pos+1));//MÉTODO PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.($pos+1).':N'.($pos+1));//Genotype MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P'.($pos+1).':R'.($pos+1));//Genotype MTBDRsl

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T'.($pos).':U'.($pos));//PATRÓN DE RESISTENCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V'.($pos).':X'.($pos));//PATRÓN DE RESISTENCIA RESULTADO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($pos+2).':B'.($pos+3));//FECHA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.($pos+2).':E'.($pos+3));//FECHA PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.($pos+2).':L'.($pos+3));//FECHA MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.($pos+2).':O'.($pos+3));//FECHA MTBDRsl
    }

    public function TitlesCellBloq($objPHPExcel, $datos, $pos){
        // Se agregan los titulos del reporte

        $resultado_xpert = $datos->getPacienteEvolucion()->getResultadoBCX()->getXpert()->getClasificacion().' --- '.$datos->getPacienteEvolucion()->getResultadoBCX()->getXpert()->getDescripcion();

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($pos-1),'XPERT:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($pos-1),$resultado_xpert);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pos,$datos->getCodigoMuestra());

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pos,'RESULTADO FENOTÍPICO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$pos,'RESULTADO GENOTÍPICO');

        $FechaFenoNitra = $datos->getFechaFenoNitra();
        ( is_null($FechaFenoNitra) || $FechaFenoNitra == '') ? $FechaFenoNitra = '' : $FechaFenoNitra = $FechaFenoNitra->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($pos+1),'FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($pos+2), $FechaFenoNitra );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($pos+1),'MÉTODO DE LA NITRATASA');

        $FechaFenoPropFS = $datos->getFechaFenoPropFS();
        ( is_null($FechaFenoPropFS) || $FechaFenoPropFS == '' )? $FechaFenoPropFS = '' : $FechaFenoPropFS = $FechaFenoPropFS->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($pos+1),'FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($pos+2), $FechaFenoPropFS );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($pos+1),'MÉTODO PROPORCIONAL');

        $FechaMTBDRPlus = $datos->getFechaMTBDRPlus();
        ( is_null($FechaMTBDRPlus) || $FechaMTBDRPlus == '' ) ? $FechaMTBDRPlus = '' : $FechaMTBDRPlus = $FechaMTBDRPlus->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($pos+1),'FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($pos+2), $FechaMTBDRPlus );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($pos+1),'Genotype MTBDRplus');

        $FechaMTBDRSL = $datos->getFechaMTBDRSL();
        ( is_null($FechaMTBDRSL) || $FechaMTBDRSL == '' ) ? $FechaMTBDRSL = '' : $FechaMTBDRSL = $FechaMTBDRSL->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($pos+1),'FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($pos+2), $FechaMTBDRSL );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($pos+1),'Genotype MTBDRsl');


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($pos+2),'H');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($pos+2),'R');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($pos+2),'S');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($pos+2),'E');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($pos+2),'Amk');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($pos+2),'Kan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($pos+2),'Cam');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($pos+2),'Mfx');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($pos+2),'H');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($pos+2),'R');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($pos+2),'FQ');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($pos+2),'AG/PC');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($pos+2),'Kan');

        //Si el diagnostico de la muestra fue un caso aislado entonces el id de la resistencia en la tabla es NULL
        if(is_null( $datos->getResistencia())){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$pos,'AISLADO SIN ESTUDIO');
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$pos,'PATRÓN DE RESISTENCIA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$pos, strtoupper( $datos->getResistencia()->getDescripcion().' -- ('.$datos->getResistencia()->getClasificacion().')' ));
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$pos,'OBSERVACIONES');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$pos, strtoupper( $datos->getObservaciones() ));

    }

    public function AllValues($objPHPExcel, $datos, $pos){

    //      'met_fen_nit_fh'    : 0=>S 1=>R
    //      'met_fen_nit_fr'    : 0=>S 1=>R
    //      'met_fen_prop_fs'   : 0=>S 1=>R
    //      'met_fen_prop_fe'   : 0=>S 1=>R
    //      'met_fen_prop_fam'  : 0=>S 1=>R
    //      'met_fen_prop_fkm'  : 0=>S 1=>R
    //      'met_fen_prop_fcm'  : 0=>S 1=>R
    //      'met_fen_prop_fmfx' : 0=>S 1=>R
    //      'met_mtbdrplus_fh'  : 0=>S 1=>R 2=>NC
    //      'met_mtbdrplus_fr'  : 0=>S 1=>R 2=>NC
    //      'met_mtbdrsl_ffq'   : 0=>S 1=>R 2=>NC
    //      'met_mtbdrsl_fagcp' : 0=>S 1=>R 2=>NC
    //      'met_mtbdrsl_fkan'  : 0=>S 1=>R 2=>NC


        switch($datos->getMetFenNitFh()){
            case 0:  $met_fen_nit_fh = '';  break;
            case 1:  $met_fen_nit_fh = 'S'; break;
            default: $met_fen_nit_fh = 'R';
        }

        switch($datos->getMetFenNitFr()){
            case 0:  $met_fen_nit_fr = '';  break;
            case 1:  $met_fen_nit_fr = 'S'; break;
            default: $met_fen_nit_fr = 'R';
        }

        switch($datos->getMetFenPropFs()){
            case 0:  $met_fen_prop_fs = '';  break;
            case 1:  $met_fen_prop_fs = 'S'; break;
            default: $met_fen_prop_fs = 'R';
        }

        switch($datos->getMetFenPropFe()){
            case 0:  $met_fen_prop_fe = '';  break;
            case 1:  $met_fen_prop_fe = 'S'; break;
            default: $met_fen_prop_fe = 'R';
        }

        switch($datos->getMetFenPropFam()){
            case 0:  $met_fen_prop_fam = '';  break;
            case 1:  $met_fen_prop_fam = 'S'; break;
            default: $met_fen_prop_fam = 'R';
        }

        switch($datos->getMetFenPropFkm()){
            case 0:  $met_fen_prop_fkm = '';  break;
            case 1:  $met_fen_prop_fkm = 'S'; break;
            default: $met_fen_prop_fkm = 'R';
        }

        switch($datos->getMetFenPropFcm()){
            case 0:  $met_fen_prop_fcm = '';  break;
            case 1:  $met_fen_prop_fcm = 'S'; break;
            default: $met_fen_prop_fcm = 'R';
        }

        switch($datos->getMetFenPropFmfx()){
            case 0:  $met_fen_prop_fmfx = '';  break;
            case 1:  $met_fen_prop_fmfx = 'S'; break;
            default: $met_fen_prop_fmfx = 'R';
        }

        switch($datos->getMetMtbdrplusFh()){
            case 0:  $met_mtbdrplus_fh = '';  break;
            case 1:  $met_mtbdrplus_fh = 'RND'; break;
            case 2:  $met_mtbdrplus_fh = 'RI'; break;
            default: $met_mtbdrplus_fh = 'RD';
        }

        switch($datos->getMetMtbdrplusFr()){
            case 0:  $met_mtbdrplus_fr = '';  break;
            case 1:  $met_mtbdrplus_fr = 'RND'; break;
            case 2:  $met_mtbdrplus_fr = 'RI'; break;
            default: $met_mtbdrplus_fr = 'RD';
        }

        switch($datos->getMetMtbdrslFfq()){
            case 0:  $met_mtbdrsl_ffq = '';  break;
            case 1:  $met_mtbdrsl_ffq = 'RND'; break;
            case 2:  $met_mtbdrsl_ffq = 'RI'; break;
            default: $met_mtbdrsl_ffq = 'RD';
        }

        switch($datos->getMetMtbdrslFagcp()){
            case 0:  $met_mtbdrsl_fagcp = '';  break;
            case 1:  $met_mtbdrsl_fagcp = 'RND'; break;
            case 2:  $met_mtbdrsl_fagcp = 'RI'; break;
            default: $met_mtbdrsl_fagcp = 'RD';
        }

        switch($datos->getMetMtbdrslFkan()){
            case 0:  $met_mtbdrsl_fkan = '';  break;
            case 1:  $met_mtbdrsl_fkan = 'RND'; break;
            case 2:  $met_mtbdrsl_fkan = 'RI'; break;
            default: $met_mtbdrsl_fkan = 'RD';
        }


        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 2, 7 + $pos, $met_fen_nit_fh);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 3, 7 + $pos, $met_fen_nit_fr);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 5, 7 + $pos, $met_fen_prop_fs);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 6, 7 + $pos, $met_fen_prop_fe);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 7, 7 + $pos, $met_fen_prop_fam);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 8, 7 + $pos, $met_fen_prop_fkm);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 9, 7 + $pos, $met_fen_prop_fcm);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 10, 7 + $pos, $met_fen_prop_fmfx);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 12, 7 + $pos, $met_mtbdrplus_fh);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 13, 7 + $pos, $met_mtbdrplus_fr);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 15, 7 + $pos, $met_mtbdrsl_ffq);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 16, 7 + $pos, $met_mtbdrsl_fagcp);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 17, 7 + $pos, $met_mtbdrsl_fkan);

    }

    public function StyleCellBloq($objPHPExcel, $estiloBloque_HEAD, $estiloBloque_1, $estiloBloque_2, $estiloBloque_3, $estiloBloque_4, $estiloBloque_5
        , $estiloBloque_6, $estiloBloque_7, $estiloBloque_8, $estiloBloque_9, $estiloBloque_10, $estiloBloque_11, $estiloBloque_12, $estiloBloque_13
        , $estiloBloque_14, $pos){
        //aplicamos a las celdas los estilos creados anteriomente


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->applyFromArray($estiloBloque_HEAD);//ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C3')->applyFromArray($estiloBloque_11);//NOMBRE DEL PACIENTE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->applyFromArray($estiloBloque_12);//NOMBRE DEL PACIENTE

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I'.($pos-1))->applyFromArray($estiloBloque_11);//XPERT
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.($pos-1))->applyFromArray($estiloBloque_12);//RESULTADO XPERT
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$pos)->applyFromArray($estiloBloque_1);//CODIGO DE LA CEPA

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$pos)->applyFromArray($estiloBloque_2);//RESULTADO FENOTÍPICO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.$pos)->applyFromArray($estiloBloque_2);//RESULTADO GENOTÍPICO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.($pos+1))->applyFromArray($estiloBloque_2);//FECHA DE LA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.($pos+1))->applyFromArray($estiloBloque_2);//MÉTODO DE LA NITRATASA

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.($pos+1))->applyFromArray($estiloBloque_2);//FECHA PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.($pos+1))->applyFromArray($estiloBloque_2);//MÉTODO PROPORCIONAL

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.($pos+1))->applyFromArray($estiloBloque_2);//FECHA MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M'.($pos+1))->applyFromArray($estiloBloque_2);//Genotype MTBDRplus

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.($pos+1))->applyFromArray($estiloBloque_2);//FECHA MTBDRsl
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P'.($pos+1))->applyFromArray($estiloBloque_2);//Genotype MTBDRsl

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$pos)->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.$pos)->applyFromArray($estiloBloque_8);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.($pos+1))->applyFromArray($estiloBloque_6);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.($pos+1).':D'.($pos+2))->applyFromArray($estiloBloque_6);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.($pos+1))->applyFromArray($estiloBloque_7);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.($pos+1).':K'.($pos+2))->applyFromArray($estiloBloque_7);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.($pos+1))->applyFromArray($estiloBloque_9);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M'.($pos+1).':N'.($pos+2))->applyFromArray($estiloBloque_9);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.($pos+1))->applyFromArray($estiloBloque_10);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P'.($pos+1).':R'.($pos+2))->applyFromArray($estiloBloque_10);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.($pos+2).':R'.($pos+2))->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.($pos+3).':R'.($pos+3))->applyFromArray($estiloBloque_4);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('T'.$pos)->applyFromArray($estiloBloque_13);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('V'.$pos)->applyFromArray($estiloBloque_14);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Z'.$pos)->applyFromArray($estiloBloque_13);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$pos.':R'.($pos+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P'.($pos+3).':R'.($pos+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('T'.$pos.':X'.$pos)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Z'.$pos)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

    }

}