<?php
/**
 * Created by PhpStorm.
 * User: danielito
 * Date: 23/08/2017
 * Time: 20:19
 */

namespace AppBundle\ImprimirExcel;

use \PHPExcel;


class ImpCalidadBaciloscopia
{

    public function DatosPDF($datos)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Control Calidad Baciloscopia ');

        $this->HeadBloq($objPHPExcel);

        $this->MergeCellsBloq($objPHPExcel);

        $this->TitlesCellBloq($objPHPExcel);


        //Se dimensiona la columna de arriba para que los nombres queden al ancho de la columna.
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(4)->setRowHeight(15);

        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(27);

        $this->AllValues($objPHPExcel,$datos);

        //Creamos los estilos que seran aplicados a las celdas del excel
        $estiloBloque_1 = array(
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
//            'fill' => array(
//                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
//                'color' => array(
//                    'argb' => 'FF220835')
//            ),
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
                'name'      => 'Calibri',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>11,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
//            'fill' => array(
//                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
//                'color' => array(
//                    'argb' => 'FF220835')
//            ),

//            'borders' => array(
//                'allborders' => array(
//                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
//                )
//            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_3 = array(
            'font' => array(
                'name'      => 'Calibre',
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
                    'rgb' => '153662')
            ),

//            'borders' => array(
//                'allborders' => array(
//                    'style' => \PHPExcel_Style_Border::BORDER_THIN
//                )
//            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_4 = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>11,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'd9d9d9')
            ),

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_5 = array(
            'font' => array(
                'name'      => 'Calibri',
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
                    'rgb' => '16365c')
            ),

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );


        $this->StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5);

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);


        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteCB.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function HeadBloq($objPHPExcel){
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("MINISTERIO SALUD") // Nombre del autor
        ->setLastModifiedBy("MINISTERIO SALUD") //Ultimo usuario que lo modific�
        ->setTitle("REPORTE CONTROL CALIDAD BACILOSCOPIA") // Titulo
        ->setSubject("REPORTE CONTROL CALIDAD BACILOSCOPIA") //Asunto
        ->setDescription("REPORTE CONTROL CALIDAD BACILOSCOPIA") //Descripci�n
        ->setKeywords("REPORTE CONTROL CALIDAD BACILOSCOPIA") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function MergeCellsBloq($objPHPExcel){
        // Se combinan las celdas C2 hasta G2, para colocar ahi el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:G2');//REPORTE CONTROL DE CALIDAD DE LA BACILOSCOPIA

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:G4');//NOMBRE LABORATORIO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:G6');//FECHA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D7:G7');//PROVICNIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D8:G8');//MUNICIPIO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C10:G10');//MUESTRAS EVALUADAS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C12:F12');//TOTAL DE MUESTRAS EVALUADAS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C13:F13');//NUMEROS DE POSITIVAS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C14:F14');//NUMEROS DE NEGATIVAS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C15:F15');//FALSOS POSITIVOS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C16:F16');//FALSOS NEGATIVOS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C17:F17');//ERRORES DE CODIFICACION

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C19:G19');//LAMINAS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C21:F21');//LAMINAS CONCOORDANTES
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C22:F22');//LTA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C23:F23');//LEA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C24:F24');//LCA

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C26:G26');//INDICADORES A MEDIR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C28:F28');//TASA FP
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C29:F29');//TASA FN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C30:F30');//TASA EC
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C31:F31');//% CONCOORDANCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C32:F32');//% LAMINAS CON EXTENSION ADECUADA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C33:F33');//% LAMINAS CON ZN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C34:F34');//% LAMINAS CON CALIDAD ADECUADA

    }

    public function TitlesCellBloq($objPHPExcel){
        // Se agregan los titulos del reporte

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2','REPORTE CONTROL DE CALIDAD DE LA BACILOSCOPIA');//REPORTE CONTROL DE CALIDAD DEL CULTIVO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','Laboratorio');//Laboratorio
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6','Fecha');//Fecha
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7','Provincia');//Provincia
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8','Municipio');//Municipio

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C10','MUESTRAS EVALUADAS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C12','Total de muestras evaluadas');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C13','Números de positivas');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C14','Números de negativas');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C15','Falsos positivos');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C16','Falsos negativos');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C17','Errores de codificación');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C19','LAMINAS');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C21','Láminas concoordantes');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C22','LTA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C23','LEA');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C24','LCA');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C26','INDICADORES A MEDIR');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C28','Tasa FP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C29','Tasa FN');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C30','Tasa EC');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C31','% concordancia');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C32','% láminas con extensión adecuada');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C33','% de láminas con ZN adecuada');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C34','% láminas con calidad adecuada');
    }

    public function AllValues($objPHPExcel,$datos){

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 4 ,$datos['nomLab']);
        if( $datos['trimestre'] > 0 ){
            $trimestre_mat = $this->RangoTrimestre($datos['trimestre'],$datos['anno']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 6 ,$trimestre_mat[0].'     '.$trimestre_mat[1]);
        }
        else
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 6 ,$datos['fechaModificada']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 7 ,$datos['nomProv']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 8 ,$datos['nomMunic']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 12 ,$datos['total_muestra_eval']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 13 ,$datos['num_positivas']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 14 ,$datos['num_negativas']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 15 ,$datos['falsos_positivos']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 16 ,$datos['falsos_negativos']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 17 ,$datos['errores_cod']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 21 ,$datos['laminas_concord']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 22 ,$datos['lta']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 23 ,$datos['lea']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 24 ,$datos['lca']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 28 ,$datos['tasa_fp']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 29 ,$datos['tasa_fn']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 30 ,$datos['tasa_ec']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 31 ,$datos['pc_concordancia']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 32 ,$datos['pc_lta']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 33 ,$datos['pc_lea']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6 , 34 ,$datos['pc_lca']);

    }

    public function StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5){
        //aplicamos a las celdas los estilos creados anteriomente

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C2')->applyFromArray($estiloBloque_1);//REPORTE CONTROL DE CALIDAD DEL CULTIVO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C4')->applyFromArray($estiloBloque_2);//Laboratorio
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C6')->applyFromArray($estiloBloque_2);//Fecha
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C7')->applyFromArray($estiloBloque_2);//Provincia
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C8')->applyFromArray($estiloBloque_2);//Municipio

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C12:F12')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C13:F13')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C14:F14')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C15:F15')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C16:F16')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C17:F17')->applyFromArray($estiloBloque_4);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C28:F28')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C29:F29')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C30:F30')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C31:F31')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C32:F32')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C33:F33')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C34:F34')->applyFromArray($estiloBloque_4);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C21:F21')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C22:F22')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C23:F23')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C24:F24')->applyFromArray($estiloBloque_4);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C10')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C19')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C26')->applyFromArray($estiloBloque_3);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G12')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G13')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G14')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G15')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G16')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G17')->applyFromArray($estiloBloque_5);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G21')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G22')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G23')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G24')->applyFromArray($estiloBloque_5);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G28')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G29')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G30')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G31')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G32')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G33')->applyFromArray($estiloBloque_5);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G34')->applyFromArray($estiloBloque_5);
    }

    public function RangoTrimestre($trimestre,$anno)
    {
        $fechaActual = new \DateTime('now');

        if(empty($anno))
            $year =  $fechaActual->format('Y');
        else
            $year = $anno;

        if($trimestre==1)
            return array('01-01-'.$year,'31-03-'.$year);

        if($trimestre==2)
            return array('01-04-'.$year,'30-06-'.$year);

        if($trimestre==3)
            return array('01-07-'.$year,'30-09-'.$year);

        if($trimestre==4)
            return array('01-10-'.$year,'31-12-'.$year);
    }

}