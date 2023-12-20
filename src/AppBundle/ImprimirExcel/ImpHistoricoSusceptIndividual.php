<?php
/**
 * Created by PhpStorm.
 * User: danielito
 * Date: 23/08/2017
 * Time: 20:19
 */

namespace AppBundle\ImprimirExcel;

use \PHPExcel;


class ImpHistoricoSusceptIndividual
{

    public function DatosPDF($datos)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Análisis de susceptibilidad ');

        $this->HeadBloq($objPHPExcel);

        $this->MergeCellsBloq($objPHPExcel);

        $this->TitlesCellBloq($objPHPExcel,$datos);


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

        $this->AllValues($objPHPExcel,$datos);

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


        $this->StyleCellBloq($objPHPExcel, $estiloBloque_HEAD, $estiloBloque_1, $estiloBloque_2, $estiloBloque_3, $estiloBloque_4, $estiloBloque_5
            , $estiloBloque_6, $estiloBloque_7, $estiloBloque_8, $estiloBloque_9, $estiloBloque_10, $estiloBloque_11, $estiloBloque_12, $estiloBloque_13
            , $estiloBloque_14);

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

    public function MergeCellsBloq($objPHPExcel){
        // Se combinan las celdas A1 hasta R1, para colocar ahi el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:R1');//ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:G3');//NOMBRE DEL PACIENTE
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J3:O3');//RESULTADO XPERT DEL PACIENTE

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:K4');//RESULTADO FENOTÍPICO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L4:R4');//RESULTADO GENOTÍPICO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:D5');//MÉTODO DE LA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:K5');//MÉTODO PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M5:N5');//Genotype MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P5:R5');//Genotype MTBDRsl

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T4:U4');//PATRÓN DE RESISTENCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V4:X4');//PATRÓN DE RESISTENCIA RESULTADO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B7');//FECHA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:E7');//FECHA PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L6:L7');//FECHA MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:O7');//FECHA MTBDRsl

    }

    public function TitlesCellBloq($objPHPExcel,$datos){
        // Se agregan los titulos del reporte

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','PACIENTE:');
        $nombreCompletoPac = $datos[0]->getPacienteEvolucion()->getPaciente()->getNombre().' '.$datos[0]->getPacienteEvolucion()->getPaciente()->getPrimerApellido().' '.$datos[0]->getPacienteEvolucion()->getPaciente()->getSegundoApellido();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3',$nombreCompletoPac);


        $resultado_xpert = $datos[0]->getPacienteEvolucion()->getResultadoBCX()->getXpert()->getClasificacion().' --- '.$datos[0]->getPacienteEvolucion()->getResultadoBCX()->getXpert()->getDescripcion();

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3','XPERT:');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3',$resultado_xpert);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4',$datos[0]->getCodigoMuestra());

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','RESULTADO FENOTÍPICO');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','RESULTADO GENOTÍPICO');

        $FechaFenoNitra = $datos[0]->getFechaFenoNitra();
        ( is_null($FechaFenoNitra) || $FechaFenoNitra == '') ? $FechaFenoNitra = '' : $FechaFenoNitra = $FechaFenoNitra->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5','FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', $FechaFenoNitra );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5','MÉTODO DE LA NITRATASA');

        $FechaFenoPropFS = $datos[0]->getFechaFenoPropFS();
        ( is_null($FechaFenoPropFS) || $FechaFenoPropFS == '' )? $FechaFenoPropFS = '' : $FechaFenoPropFS = $FechaFenoPropFS->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5','FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', $FechaFenoPropFS );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5','MÉTODO PROPORCIONAL');

        $FechaMTBDRPlus = $datos[0]->getFechaMTBDRPlus();
        ( is_null($FechaMTBDRPlus) || $FechaMTBDRPlus == '' ) ? $FechaMTBDRPlus = '' : $FechaMTBDRPlus = $FechaMTBDRPlus->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L5','FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L6', $FechaMTBDRPlus );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M5','Genotype MTBDRplus');

        $FechaMTBDRSL = $datos[0]->getFechaMTBDRSL();
        ( is_null($FechaMTBDRSL) || $FechaMTBDRSL == '' ) ? $FechaMTBDRSL = '' : $FechaMTBDRSL = $FechaMTBDRSL->format('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O5','FECHA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O6', $FechaMTBDRSL );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P5','Genotype MTBDRsl');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6','H');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6','R');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6','S');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6','E');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6','Amk');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I6','Kan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J6','Cam');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K6','Mfx');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M6','H');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N6','R');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P6','FQ');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q6','AG/PC');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R6','Kan');

        //Si el diagnostico de la muestra fue un caso aislado entonces el id de la resistencia en la tabla es NULL
        if(is_null( $datos[0]->getResistencia())){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','AISLADO SIN ESTUDIO');
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','PATRÓN DE RESISTENCIA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4', strtoupper( $datos[0]->getResistencia()->getDescripcion().' -- ('.$datos[0]->getResistencia()->getClasificacion().')' ));
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z4','OBSERVACIONES');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA4', strtoupper( $datos[0]->getObservaciones() ));

    }

    public function AllValues($objPHPExcel,$datos){

    //      'met_fen_nit_fh'    : 0=>S 1=>R
    //      'met_fen_nit_fr'    : 0=>S 1=>R
    //      'met_fen_prop_fs'   : 0=>S 1=>R
    //      'met_fen_prop_fe'   : 0=>S 1=>R
    //      'met_fen_prop_fam'  : 0=>S 1=>R
    //      'met_fen_prop_fkm'  : 0=>S 1=>R
    //      'met_fen_prop_fcm'  : 0=>S 1=>R
    //      'met_fen_prop_fmfx' : 0=>S 1=>R
    //      'met_mtbdrplus_fh'  : 0=>RND 1=>RI 2=>RD
    //      'met_mtbdrplus_fr'  : 0=>RND 1=>RI 2=>RD
    //      'met_mtbdrsl_ffq'   : 0=>RND 1=>RI 2=>RD
    //      'met_mtbdrsl_fagcp' : 0=>RND 1=>RI 2=>RD
    //      'met_mtbdrsl_fkan'  : 0=>RND 1=>RI 2=>RD


        switch($datos[0]->getMetFenNitFh()){
            case 0:  $met_fen_nit_fh = '';  break;
            case 1:  $met_fen_nit_fh = 'S'; break;
            default: $met_fen_nit_fh = 'R';
        }

        switch($datos[0]->getMetFenNitFr()){
            case 0:  $met_fen_nit_fr = '';  break;
            case 1:  $met_fen_nit_fr = 'S'; break;
            default: $met_fen_nit_fr = 'R';
        }

        switch($datos[0]->getMetFenPropFs()){
            case 0:  $met_fen_prop_fs = '';  break;
            case 1:  $met_fen_prop_fs = 'S'; break;
            default: $met_fen_prop_fs = 'R';
        }

        switch($datos[0]->getMetFenPropFe()){
            case 0:  $met_fen_prop_fe = '';  break;
            case 1:  $met_fen_prop_fe = 'S'; break;
            default: $met_fen_prop_fe = 'R';
        }

        switch($datos[0]->getMetFenPropFam()){
            case 0:  $met_fen_prop_fam = '';  break;
            case 1:  $met_fen_prop_fam = 'S'; break;
            default: $met_fen_prop_fam = 'R';
        }

        switch($datos[0]->getMetFenPropFkm()){
            case 0:  $met_fen_prop_fkm = '';  break;
            case 1:  $met_fen_prop_fkm = 'S'; break;
            default: $met_fen_prop_fkm = 'R';
        }

        switch($datos[0]->getMetFenPropFcm()){
            case 0:  $met_fen_prop_fcm = '';  break;
            case 1:  $met_fen_prop_fcm = 'S'; break;
            default: $met_fen_prop_fcm = 'R';
        }

        switch($datos[0]->getMetFenPropFmfx()){
            case 0:  $met_fen_prop_fmfx = '';  break;
            case 1:  $met_fen_prop_fmfx = 'S'; break;
            default: $met_fen_prop_fmfx = 'R';
        }

        switch($datos[0]->getMetMtbdrplusFh()){
            case 0:  $met_mtbdrplus_fh = '';  break;
            case 1:  $met_mtbdrplus_fh = 'RND'; break;
            case 2:  $met_mtbdrplus_fh = 'RI'; break;
            default: $met_mtbdrplus_fh = 'RD';
        }

        switch($datos[0]->getMetMtbdrplusFr()){
            case 0:  $met_mtbdrplus_fr = '';  break;
            case 1:  $met_mtbdrplus_fr = 'RND'; break;
            case 2:  $met_mtbdrplus_fr = 'RI'; break;
            default: $met_mtbdrplus_fr = 'RD';
        }

        switch($datos[0]->getMetMtbdrslFfq()){
            case 0:  $met_mtbdrsl_ffq = '';  break;
            case 1:  $met_mtbdrsl_ffq = 'RND'; break;
            case 2:  $met_mtbdrsl_ffq = 'RI'; break;
            default: $met_mtbdrsl_ffq = 'RD';
        }

        switch($datos[0]->getMetMtbdrslFagcp()){
            case 0:  $met_mtbdrsl_fagcp = '';  break;
            case 1:  $met_mtbdrsl_fagcp = 'RND'; break;
            case 2:  $met_mtbdrsl_fagcp = 'RI'; break;
            default: $met_mtbdrsl_fagcp = 'RD';
        }

        switch($datos[0]->getMetMtbdrslFkan()){
            case 0:  $met_mtbdrsl_fkan = '';  break;
            case 1:  $met_mtbdrsl_fkan = 'RND'; break;
            case 2:  $met_mtbdrsl_fkan = 'RI'; break;
            default: $met_mtbdrsl_fkan = 'RD';
        }


        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 2, 7, $met_fen_nit_fh);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 3, 7, $met_fen_nit_fr);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 5, 7, $met_fen_prop_fs);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 6, 7, $met_fen_prop_fe);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 7, 7, $met_fen_prop_fam);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 8, 7, $met_fen_prop_fkm);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 9, 7, $met_fen_prop_fcm);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 10, 7, $met_fen_prop_fmfx);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 12, 7, $met_mtbdrplus_fh);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 13, 7, $met_mtbdrplus_fr);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 15, 7, $met_mtbdrsl_ffq);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 16, 7, $met_mtbdrsl_fagcp);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 17, 7, $met_mtbdrsl_fkan);

    }

    public function StyleCellBloq($objPHPExcel, $estiloBloque_HEAD, $estiloBloque_1, $estiloBloque_2, $estiloBloque_3, $estiloBloque_4, $estiloBloque_5
        , $estiloBloque_6, $estiloBloque_7, $estiloBloque_8, $estiloBloque_9, $estiloBloque_10, $estiloBloque_11, $estiloBloque_12, $estiloBloque_13
        , $estiloBloque_14){
        //aplicamos a las celdas los estilos creados anteriomente

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->applyFromArray($estiloBloque_HEAD);//ESTUDIO DE SUSCEPTIBILIDAD A FÁRMACOS ANTITUBERCULOSOS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C3')->applyFromArray($estiloBloque_11);//PACIENTE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->applyFromArray($estiloBloque_12);//NOMBRE PACIENTE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I3')->applyFromArray($estiloBloque_11);//XPERT
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J3')->applyFromArray($estiloBloque_12);//RESULTADO XPERT
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A4')->applyFromArray($estiloBloque_1);//CODIGO DE LA CEPA


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B4')->applyFromArray($estiloBloque_2);//RESULTADO FENOTÍPICO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L4')->applyFromArray($estiloBloque_2);//RESULTADO GENOTÍPICO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B5')->applyFromArray($estiloBloque_2);//FECHA DE LA NITRATASA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C5')->applyFromArray($estiloBloque_2);//MÉTODO DE LA NITRATASA

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E5')->applyFromArray($estiloBloque_2);//FECHA PROPORCIONAL
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F5')->applyFromArray($estiloBloque_2);//MÉTODO PROPORCIONAL

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L5')->applyFromArray($estiloBloque_2);//FECHA Genotype MTBDRplus
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M5')->applyFromArray($estiloBloque_2);//Genotype MTBDRplus

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O5')->applyFromArray($estiloBloque_2);//FECHA Genotype MTBDRsl
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P5')->applyFromArray($estiloBloque_2);//Genotype MTBDRsl


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B4')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L4')->applyFromArray($estiloBloque_8);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B5')->applyFromArray($estiloBloque_6);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C5:D6')->applyFromArray($estiloBloque_6);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E5')->applyFromArray($estiloBloque_7);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F5:K6')->applyFromArray($estiloBloque_7);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L5')->applyFromArray($estiloBloque_9);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M5:N6')->applyFromArray($estiloBloque_9);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O5')->applyFromArray($estiloBloque_10);//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P5:R6')->applyFromArray($estiloBloque_10);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B6:R6')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C7:R7')->applyFromArray($estiloBloque_4);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('T4')->applyFromArray($estiloBloque_13);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('V4')->applyFromArray($estiloBloque_14);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Z4')->applyFromArray($estiloBloque_13);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B4:R7')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P7:R7')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('T4:X4')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Z4')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

    }

}