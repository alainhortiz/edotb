<?php
/**
 * Created by PhpStorm.
 * User: danielito
 * Date: 23/08/2017
 * Time: 20:19
 */

namespace AppBundle\ImprimirExcel;

use \PHPExcel;


class ImpMod49004
{

    public function DatosPDF($datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('241-490-04 ANV ');

        $newSheet = new \PHPExcel_Worksheet($objPHPExcel);
        $objPHPExcel->addSheet($newSheet, 1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('241-490-04 REV ');

        $this->HeadBloq($objPHPExcel);

        $this->DimensionCells($objPHPExcel);

        $this->MergeCellsBloq($objPHPExcel);

        $this->TitlesCellBloq($objPHPExcel);

        //$this->AllValues($objPHPExcel,$datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic);

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
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'ffffff')
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
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
                'bold'      => false,
                'italic'    => false,
                'strike'    => false,
                'size' =>9,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
//            'fill' => array(
//                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
//                'color' => array(
//                    'argb' => 'FF220835')
//            ),

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_DISTRIBUTED,
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
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FF220835')
            ),

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_DISTRIBUTED,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_5 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
//            'fill' => array(
//                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
//                'color' => array(
//                    'argb' => 'FF220835')
//            ),

            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        //Para pintar los bordes exteriores del primer encabezado
        $estiloBloque_6 = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>8,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'fill' => array(
            'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array(
                'rgb' => 'ffffff')
        ),
        'borders' => array(
            'outline' => array(
                'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
            )
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation' => 0,
            'wrap' => TRUE
        )
    );
        $estiloBloque_7 = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
//                'size' =>18,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'ffffff')
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM),
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloBloque_8 = array(
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
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFFFFF')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloTituloColumnas = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => true,
                'italic' => false,
                'strike' => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'       => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array(
                    'rgb' => 'FFFF00'
                ),
                'endcolor' => array(
                    'argb' => 'FFFF00'
                )
            ),
            'borders' => array(
                'top' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => 'FFFF00'
                    )
                ),
                'bottom' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => 'FFFF00'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'      => TRUE
            )
        );

        $estiloTituloSubColumnas = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => true,
                'italic' => false,
                'strike' => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
                'type'       => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
                'startcolor' => array(
                    'rgb' => 'FFFFFF'
                ),
                'endcolor' => array(
                    'argb' => 'FFFFFF'
                )
            ),
            'borders' => array(
                'top' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => 'FFFF00'
                    )
                ),
                'bottom' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'      => TRUE
            )
        );


        //$this->StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5,$estiloBloque_6,$estiloBloque_7,$estiloBloque_8);


//        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A6:B".($j+6));
//        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "D6:F".($k+6));


        // Inmovilizar paneles
//        $objPHPExcel->getActiveSheet(0)->freezePane('C4');

        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue("MODELO 241-490-04\nPágina 2 de 2");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);


        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);


        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Modelo.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function HeadBloq($objPHPExcel){
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("MINISTERIO SALUD") // Nombre del autor
        ->setLastModifiedBy("MINISTERIO SALUD") //Ultimo usuario que lo modific�
        ->setTitle("INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS") // Titulo
        ->setSubject("INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS") //Asunto
        ->setDescription("INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS") //Descripci�n
        ->setKeywords("INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function DimensionCells($objPHPExcel){
        //Se dimensiona la columna de arriba para que los nombres queden al ancho de la columna.
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(7);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(7);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(7);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('W')->setWidth(10);

        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('2')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('3')->setRowHeight(20);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('4')->setRowHeight(25);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('5')->setRowHeight(20);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('6')->setRowHeight(20);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('7')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('8')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('9')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('10')->setRowHeight(15);

        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(22);
        $objPHPExcel->setActiveSheetIndex(1)->getRowDimension('1')->setRowHeight(27);
    }

    public function MergeCellsBloq($objPHPExcel){

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F4');//ESPACIO PARA LA IMAGEN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F6');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:Q6');//INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R1:T2');//INFORME DEL PERÍODO TERMINADO EN:

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T3:T4');//ANNO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V1:W1');//Modelo 241-462-03
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V2:W2');//Página 1 de 2
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V3:W3');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V4:W4');//Trimestre independiente
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V5:W5');//Unidad Medida
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V6:W6');//Uno

        // Se combinan las celdas C2 hasta J2, para colocar ahi el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:F7');//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:F8');//
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G7:Q8');//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R7:R10');//CÓDIGO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S7:W8');//ORG-CEN-INF-ESTAB.

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:F9');//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:F10');//
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G9:K9');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G10:K10');//
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L9:Q9');//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L10:Q10');//
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S9:W10');//CPCU

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:K12');//INDICADORES
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L11:M12');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N11:V11');//ESTRATIFICACIÓN SEGÚN RIESGO INDIVIDUAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W11:W12');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A13:K13');//A
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L13:M13');//B

        for($i = 1; $i < 35; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.($i + 13).':M'.($i + 13));//B
        }

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A14:C20');//POLICLINICO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A21:C31');//ESTUDIOS A GRUPOS VULNERABLES
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A32:C37');//HOSPITAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A38:C41');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A42:C45');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A46:C47');//CASO PREVIAMENTE TRATADO

        for($i = 1; $i < 14; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($i + 13).':K'.($i + 13));//B
        }
        for($i = 1; $i < 8; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($i + 30).':K'.($i + 30));//B
        }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D46:K46');//B
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D47:K47');//B

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D27:E30');//Terapia Preventiva con Isoniazida
        for($i = 1; $i < 5; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($i + 26).':K'.($i + 26));//B
        }
        for($i = 1; $i < 8; $i=$i+2){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($i + 37).':E'.($i + 38));//B
        }
        for($i = 1; $i < 9; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($i + 37).':K'.($i + 37));//B
        }


        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:X1');//Modelo 241-462-03 Página 2 de 2
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A2:X2');//RED DE LABORATORIOS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A3:L4');//INDICADORES
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M3:N4');//FILA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('O3:W3');//ESTRATIFICACIÓN SEGÚN RIESGO INDIVIDUAL
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('X3:X4');//TOTAL

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A5:L5');//A
        for($i = 1; $i < 13; $i++){
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M'.($i + 4).':N'.($i + 4));//B
        }

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A6:E8');//CULTIVOS REALIZADOS POR TÉCNICAS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A9:E10');//PRUEBAS DE SUSCEPTIBILIDAD
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('F9:G10');//MÉTODOS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('H9:L9');//Fenotípicos (proporciones y nitrato reductasa)
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('H10:L10');//Genotípicos (genotype)
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A11:B15');//CASOS DETECTADOS
        for($i = 1; $i < 6; $i++){
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C'.($i + 10).':L'.($i + 10));//B
        }
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A16:L16');//Determinaciones (patrones genéticos)
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A17:X17');//CONTROL DE LA CALIDAD EN LA RED
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A18:I18');//BACILOSCOPIAS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J18:K18');//FILA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M18:V18');//CULTIVOS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A19:I19');//C
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J19:K19');//D
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M19:V19');//E
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A20:I20');//Determinaciones (número de láminas analizadas)
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A21:E22');//CONCORDANCIA DE LÁMINAS (número)
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('F21:I21');//Positivas
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('F22:I22');//Negativas

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J20:K20');//46
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J21:K21');//47
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J22:K22');//48

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A23:L24');//ESPACIO VACIO RAYADO
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M20:Q24');//BACILOSCOPIA
        for($i = 1; $i < 6; $i++){
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('R'.($i + 19).':V'.($i + 19));//B
        }

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A25:X25');//OBSERVACIONES
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A26:X29');//OBSERVACIONES CUADRO

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A30:I33');//Certificamos que los datos contenidos en este modelo
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('D35:E35');//Anno
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('D36:E36');//Anno

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J30:O30');//Jefe Dpto. Estadística
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J33:O33');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J36:O36');//Firma

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('P30:S30');//Jefe Programa TBPS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('P33:S33');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('P36:S36');//Firma

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('T30:X30');//DirectorT
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('T33:X33');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('T36:X36');//Firma

    }

    public function TitlesCellBloq($objPHPExcel){
        // Se agregan los titulos del reporte

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','MINISTERIO DE SALUD PÚBLICA');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5','SALUD PÚBLICA Y ASISTENCIA SOCIAL');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS');//INDICADORES SELECCIONADOS DEL  PROGRAMA DE CONTROL DE LA TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1','INFORME DEL PERÍODO TERMINADO EN:');//INFORME DEL PERÍODO TERMINADO EN:

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3','I TRIMESTRE');//I TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4','II TRIMESTRE');//II TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R5','III TRIMESTRE');//III TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R6','IV TRIMESTRE');//IV TRIMESTRE

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3','AÑO');//AÑO

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1','MODELO 241-462-03');//Modelo 241-462-03
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2','Página 1 de 2');//Página 1 de 2
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3','PERIODICIDAD');//PERIODICIDAD:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4','Trimestre independiente');//Trimestre independiente
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V5','UNIDAD DE MEDIDA');//UNIDAD DE MEDIDA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V6','UNO');//Uno


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7','ORGANISMO:');//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G7','CENTRO INFORMANTE O ESTABLECIMIENTO:');//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R7','CÓDIGO');//CÓDIGO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S7','ORG-CEN-INF-ESTAB.');//ORG-CEN-INF-ESTAB.

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9','ACTIVIDAD FUNDAMENTAL:');//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9','PROVINCIA:');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L9','MUNICIPIO:');//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S9','CPCU');//CPCU

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11','INDICADORES');//INDICADORES
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L11','FILA');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N11','ESTRATIFICCIÓN SEGÚN RIESGO INDIVIDUAL');//ESTRATIFICCIÓN SEGÚN RIESGO INDIVIDUAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W11','TOTAL');//TOTAL


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N12','Contactos');//Contactos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O12','Reclusos Exreclusos');//Reclusos Exreclusos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P12','Personas Viviendo con VIH');//Personas Viviendo con VIH
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q12','Trabajadores SNS');//Trabajadores SNS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R12','Extranjero');//Extranjero
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S12','Fumadores');//Fumadores
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T12','Diabetes Mellitus');//Diabetes Mellitus
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U12','Alcohólicos');//Alcohólicos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V12','Otros');//Otros


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A13','A');//A
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L13','B');//B
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N13','1');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O13','2');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P13','3');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q13','4');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R13','5');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S13','6');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T13','7');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U13','8');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V13','9');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W13','10');//


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14','POLICLINICO');//POLICLINICO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A21','ESTUDIOS A GRUPOS VULNERABLES');//ESTUDIOS A GRUPOS VULNERABLES
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A32','HOSPITAL');//HOSPITAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A38','CASOS NUEVOS DE TUBERCULOSIS');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A42','RECAÍDA DE TUBERCULOSIS');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A46','CASO PREVIAMENTE TRATADO');//CASO PREVIAMENTE TRATADO


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D14','Consultas de medicina');//Consultas de medicina
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D15','Sintomático Respiratorio + 21 días (SR+21)');//Sintomático Respiratorio + 21 días (SR+21)
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D16','Examen Directo I y II realizados');//Examen Directo I y II realizados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D17','Total de positivos');//Total de positivos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D18','Cultivos realizados');//Cultivos realizados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D19','Total de positivos');//Total de positivos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D20','Positivos con prueba de sensibilidad realizada');//Positivos con prueba de sensibilidad realizada

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L14','1');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L15','2');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L16','3');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L17','4');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L18','5');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L19','6');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L20','7');//

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D21','Identificados');//Identificados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D22','De ello: - 5 años');//De ello: - 5 años
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D23','Pruebas de Tuberculina realizadas');//Pruebas de Tuberculina realizadas
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D24','De ello: - 5 años');//De ello: - 5 años
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D25','Positivas');//Positivas
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D26','De ello: - 5 años');//De ello: - 5 años
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D27','Terapia Preventiva con Isoniazida');//Terapia Preventiva con Isoniazida
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F27','Iniciaron');//Iniciaron
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F28','De ello: - 5 años');//De ello: - 5 años
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F29','Terminaron');//Terminaron
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F30','De ello: - 5 años');//De ello: - 5 años
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D31','Cotrimoxazol a pacientes coinfectados');//Cotrimoxazol a pacientes coinfectados

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L21','8');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L22','9');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L23','10');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L24','11');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L25','12');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L26','13');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L27','14');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L28','15');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L29','16');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L30','17');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L31','18');//


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D32','Examen Directo I y II realizados');//Examen Directo I y II realizados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D33','Total de positivos');//Total de positivos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D34','Cultivos realizados');//Cultivos realizados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D35','Total de positivos');//Total de positivos
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D36','Positivos con prueba de sensibilidad realizada');//Positivos con prueba de sensibilidad realizada
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D37','Positivos a otras pruebas diagnósticas');//Positivos a otras pruebas diagnósticas

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L32','19');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L33','20');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L34','21');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L35','22');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L36','23');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L37','24');//

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D38','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D40','EXTRA PULMONAR');//EXTRA PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D42','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D44','EXTRA PULMONAR');//EXTRA PULMONAR

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F38','Bacteriológicamente confirmado');//Bacteriológicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F39','Clínicamente diagnosticado');//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F40','Bacteriológicamente confirmado');//Bacteriológicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F41','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L38','25');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L39','26');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L40','27');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L41','28');//

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F42','Bacteriológicamente confirmado');//Bacteriológicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F43','Clínicamente diagnosticado');//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F44','Bacteriológicamente confirmado');//Bacteriológicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F45','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L42','29');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L43','30');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L44','31');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L45','32');//

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D46','Fracaso terapéutico');//Fracaso terapéutico
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D47','Perdida al seguimiento');//Perdida al seguimiento

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L46','33');//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L47','34');//



        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2','RED DE LABORATORIOS');//RED DE LABORATORIOS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3','INDICADORES');//INDICADORES
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M3','FILA');//FILA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O3','ESTRATIFICACIÓN SEGÚN RIESGO INDIVIDUAL');//ESTRATIFICACIÓN SEGÚN RIESGO INDIVIDUAL
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('X3','TOTAL');//TOTAL


        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O4','Contactos');         //Contactos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P4','Reclusos Exreclusos');         //Reclusos Exreclusos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q4','Personas Viviendo con VIH');   //Personas Viviendo con VIH
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R4','Trabajadores SNS');            //Trabajadores SNS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('S4','Extranjero');                  //Extranjero
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('T4','Fumadores');                   //Fumadores
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('U4','Diabetes Mellitus');           //Diabetes Mellitus
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('V4','Alcohólicos');                 //Alcohólicos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W4','Otros');                       //Otros

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A5','A');//A
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M5','B');//B
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O5','1');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P5','2');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q5','3');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R5','4');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('S5','5');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('T5','6');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('U5','7');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('V5','8');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W5','9');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('X5','10');//


        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A6','CULTIVOS REALIZADOS POR TÉCNICAS');//CULTIVOS REALIZADOS POR TÉCNICAS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A9','PRUEBAS DE SUSCEPTIBILIDAD');//PRUEBAS DE SUSCEPTIBILIDAD
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F9','MÉTODOS');//MÉTODOS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H9','Fenotípicos (proporciones y nitrato reductasa)');//Fenotípicos (proporciones y nitrato reductasa)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H10','Genotípicos (genotype)');//Genotípicos (genotype)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A11','CASOS DETECTADOS');//CASOS DETECTADOS

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F6','Convencional');//Convencional
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F7','Rápido en medio líquido');//Rápido en medio líquido
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F8','Gene-Xpert');//Gene-Xpert
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H9','Fenotípicos (proporciones y nitrato reductasa)');//Fenotípicos (proporciones y nitrato reductasa)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H10','Genotípicos (genotype)');//Genotípicos (genotype)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C11','Monorresistentes');//Monorresistentes
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C12','Multidrogorresistencia (MDR)');//Multidrogorresistencia (MDR)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C13','Polirresistentes');//Polirresistentes
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C14','Extensamente resistentes (XDR)');//Extensamente resistentes (XDR)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C15','Resistencia a la rifampicina');//Resistencia a la rifampicina
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A16','Determinaciones (patrones genéticos)');//Determinaciones (patrones genéticos)

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M6','35');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M7','36');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M8','37');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M9','38');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M10','39');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M11','40');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M12','41');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M13','42');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M14','43');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M15','44');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M16','45');//

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A17','CONTROL DE LA CALIDAD EN LA RED');//CONTROL DE LA CALIDAD EN LA RED

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A18','BACILOSCOPIAS');//BACILOSCOPIAS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J18','FILA');         //FILA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L18','NÚMERO');       //NÚMERO
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M18','CULTIVOS');     //CULTIVOS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W18','FILA');         //FILA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('X18','NÚMERO');       //NÚMERO

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A19','C');  //C
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J19','D');  //D
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L19','11'); //11
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M19','E');  //E
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W19','F');  //F
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('X19','12'); //12




        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A20','Determinaciones (número de láminas analizadas)');//Determinaciones (número de láminas analizadas)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A21','CONCORDANCIA DE LÁMINAS (número)');//CONCORDANCIA DE LÁMINAS (número)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F21','Positivas');//Positivas
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F22','Negativas');//Negativas

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J20','46');//46
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J21','47');//47
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J22','48');//48

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M20','BACILOSCOPIA');//BACILOSCOPIA

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R20','(- ) / cultivo (+)');//(- ) / cultivo (+)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R21','(+) / cultivo (+)');//(+) / cultivo (+)
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R22','(+) / cultivo (- )');//(+) / cultivo (- )
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R23','(+) cultivo contaminado');//(+) cultivo contaminado
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('R24','(+) cultivo no realizado');//(+) cultivo no realizado

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W20','49');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W21','50');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W22','51');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W23','52');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('W24','53');//


        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A25','OBSERVACIONES');//OBSERVACIONES

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A30','Certificamos que los datos contenidos en este modelo corresponden a los anotados en nuestros registros primarios y de acuerdo a las instrucciones vigentes para la elaboración del mismo.   ');//Certificamos que los datos contenidos en este modelo
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B36','DÍA');//DÍA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C36','MES');//MES
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D36','AÑO');//AÑO

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J30','Jefe Dpto. Estadística');//Jefe Dpto. Estadística
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J33','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J36','Firma');//Firma

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P30','Jefe Programa TBPS');//Jefe Programa TBPS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P33','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P36','Firma');//Firma

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('T30','DirectorT');//DirectorT
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('T33','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('T36','Firma');//Firma


    }
//
//    public function AllValues($objPHPExcel,$datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic){
//        //VALORES DEL ENCABEZADO
//        if($trimestre == 1)
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 3 , 'X');
//        if($trimestre == 2)
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 4 , 'X');
//        if($trimestre == 3)
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 5 , 'X');
//        if($trimestre == 4)
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 6 , 'X');
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 5 , $anno);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 9 , $nomAreaSalud);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 12, $provAreaSalud);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9 , 12 ,$municAreaSalud);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13 , 12 ,$codAreaSalud);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15 , 12 ,$codProv.'-'.$codMunic);
//
//
//
//
//        //-------------------------------------------------------------------------------------------------
//        //CICLOS PARA LLENAR LAS CELDAS QUE POSEEN DATOS---------------------------------------------------
//        //-------------------------------------------------------------------------------------------------
//        $i = 0; //ESTA VARIABLE SE IRA INCREMENTANDO A MEDIDA QUE SE VAYAN CONSULTANDO LOS ARRAYS EN $datos.
//
//        //FILA 19
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 19 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 19 ,$value);
//
//        //FILA 20
//        $i = 1;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 20 ,$value);
//        }
//
//        //FILA 21
//        $i = 2;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 21 ,$value);
//        }
//
//        //FILA 22
//        $i = 3;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 22 ,$value);
//        }
//
//        //FILA 23
//        $i = 4;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 23 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 23 ,$value);
//
//        //FILA 24
//        $i = 5;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 24 ,$value);
//        }
//
//        //FILA 25
//        $i = 6;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 25 ,$value);
//        }
//
//        //FILA 26
//        $i = 7;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 26 ,$value);
//        }
//
//        //FILA 27
//        $i = 8;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 27 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 27 ,$value);
//
//        //FILA 28
//        $i = 9;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 28 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 28 ,$value);
//
//        //FILA 29
//        $i = 10;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 29 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 29 ,$value);
//
//        //FILA 31
//        $i = 11;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 31 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 31 ,$value);
//
//        //FILA 32
//        $i = 12;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 32 ,$value);
//        }
//
//        //FILA 33
//        $i = 13;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 33 ,$value);
//        }
//
//        //FILA 34
//        $i = 14;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 34 ,$value);
//        }
//
//        //FILA 35
//        $i = 15;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 35 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 35 ,$value);
//
//        //FILA 36
//        $i = 16;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 36 ,$value);
//        }
//
//        //FILA 37
//        $i = 17;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 37 ,$value);
//        }
//
//        //FILA 38
//        $i = 18;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 38 ,$value);
//        }
//
//        //FILA 39
//        $i = 19;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 39 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 39 ,$value);
//
//        //FILA 40
//        $i = 20;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 40 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 40 ,$value);
//
//        //FILA 41
//        $i = 21;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 41 ,$value);
//        }
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 41 ,$value);
//
//        //FILA 45,46,47
//        $i = 22;
//        for( $j = 0; $j < 9; $j++)
//        {
//            $value = $datos[$i][$j];
//            if($j<3)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9 , 45+$j ,$value);
//            if($j>2 && $j<6)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12 , 42+$j ,$value);
//            if($j>5 && $j<9)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15 , 39+$j ,$value);
//        }
//
//        //FILA 45,46,47
//        $i = 23;
//        for( $j = 0; $j < 9; $j++)
//        {
//            $value = $datos[$i][$j];
//            if($j<3)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10 , 45+$j ,$value);
//            if($j>2 && $j<6)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13 , 42+$j ,$value);
//            if($j>5 && $j<9)
//                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16 , 39+$j ,$value);
//        }
//
//        //FILA 8 HOJA 2
//        $i = 24;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 8 ,$value);
//        }
//
//        //FILA 9 HOJA 2
//        $i = 25;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 9 ,$value);
//        }
//
//        //FILA 11 HOJA 2
//        $i = 26;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 11 ,$value);
//        }
//
//        //FILA 12 HOJA 2
//        $i = 27;
//        for( $j = 0; $j < 7; $j++)
//        {
//            $value = $datos[$i][$j];
//            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 12 ,$value);
//        }
//        //---------------------------------------------------------------------------------------------------------
//        //---------------------------------------------------------------------------------------------------------
//        //---------------------------------------------------------------------------------------------------------
//    }
//
//    public function StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5,$estiloBloque_6,$estiloBloque_7,$estiloBloque_8){
//        //aplicamos a las celdas los estilos creados anteriomente
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E7')->applyFromArray($estiloBloque_6);//MINISTERIO DE SALUD PUBLICA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:K7')->applyFromArray($estiloBloque_7);//
//
//        $objPHPExcel->setActiveSheetIndex()->getStyle('F1:K7')->applyFromArray(array(
//            'font' => array(
//                'size' =>18
//            )));
//        $objPHPExcel->setActiveSheetIndex()->getStyle('F6:K7')->applyFromArray(array(
//            'font' => array(
//                'size' =>12
//            ),
//            'alignment' => array(
//                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
//                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
//                'rotation' => 0,
//                'wrap' => TRUE
//            )));
//
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:N7')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
//        $objPHPExcel->setActiveSheetIndex()->getStyle('L3:L6')->applyFromArray(array(
//            'alignment' => array(
//                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
//                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
//                'rotation' => 0,
//                'wrap' => TRUE
//            )));
//        $objPHPExcel->setActiveSheetIndex()->getStyle('M3:M6')->applyFromArray(array(
//            'alignment' => array(
//                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
//                'rotation' => 0,
//                'wrap' => TRUE
//            ),
//            'borders' => array(
//                'right' => array(
//                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
//                )
//            )));
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O1:Q2')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O3:Q5')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O6:Q7')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:C10')->applyFromArray($estiloBloque_1);//ORGANISMO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D8:L10')->applyFromArray($estiloBloque_1);//CENTRO INFORMANTE O ESTABLECIMIENTO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N8:Q10')->applyFromArray($estiloBloque_1);//ORG-CEN-INF-ESTAB.
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A11:C13')->applyFromArray($estiloBloque_1);//ACTIVIDAD FUNDAMENTAL
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D11:I13')->applyFromArray($estiloBloque_1);//PROVINCIA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J11:L13')->applyFromArray($estiloBloque_1);//MUNICIPIO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N11:O13')->applyFromArray($estiloBloque_1);//CPCU
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P11:Q13')->applyFromArray($estiloBloque_1);//PROV-MUN
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D19:H19')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D20:H20')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D21:H21')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D22:H22')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D23:H23')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D24:H24')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D25:H25')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D26:H26')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B27:H27')->applyFromArray($estiloBloque_1);//Fracaso terapeútico
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B28:H28')->applyFromArray($estiloBloque_1);//Perdida al seguimiento
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A29:H29')->applyFromArray($estiloBloque_1);//TOTAL
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D31:H31')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D32:H32')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D33:H33')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D34:H34')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D35:H35')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D36:H36')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D37:H37')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D38:H38')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B39:H39')->applyFromArray($estiloBloque_1);//Fracaso terapeútico
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B40:H40')->applyFromArray($estiloBloque_1);//Perdida al seguimiento
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A41:H41')->applyFromArray($estiloBloque_1);//TOTAL
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A45:H45')->applyFromArray($estiloBloque_1);//CASOS NUEVOS
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A46:H46')->applyFromArray($estiloBloque_1);//RECAÍDA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A47:H47')->applyFromArray($estiloBloque_1);//TOTAL
//
//
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M8:M13')->applyFromArray($estiloBloque_2);//CÓDIGO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A14:Q14')->applyFromArray($estiloBloque_2);//TRIMESTRE
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A15:H17')->applyFromArray($estiloBloque_2);//CATEGORÍA DE ENTRADA A LA COHORTE
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I15:I17')->applyFromArray($estiloBloque_2);//FILA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J15:J17')->applyFromArray($estiloBloque_2);//TOTAL DE CASOS DEL GRUPO
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K15:P15')->applyFromArray($estiloBloque_2);//RESULTADOS DEL TRATAMIENTO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K16:L16')->applyFromArray($estiloBloque_2);//Alta
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K17')->applyFromArray($estiloBloque_2);//Curados
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L17')->applyFromArray($estiloBloque_2);//Tto completo
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M16:M17')->applyFromArray($estiloBloque_2);//Fallecido
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N16:N17')->applyFromArray($estiloBloque_2);//Fracaso al tratamiento
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O16:O17')->applyFromArray($estiloBloque_2);//Perdida en el seguimiento
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P16:P17')->applyFromArray($estiloBloque_2);//No evaluado
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q15:Q17')->applyFromArray($estiloBloque_2);//Pruebas de sensibilidad
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A18:H18')->applyFromArray($estiloBloque_2);//A
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I18','B')->applyFromArray($estiloBloque_2);//B
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J18','1')->applyFromArray($estiloBloque_2);//1
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K18','2')->applyFromArray($estiloBloque_2);//2
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L18','3')->applyFromArray($estiloBloque_2);//3
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M18','4')->applyFromArray($estiloBloque_2);//4
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N18','5')->applyFromArray($estiloBloque_2);//5
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O18','6')->applyFromArray($estiloBloque_2);//6
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P18','7')->applyFromArray($estiloBloque_2);//7
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q18','8')->applyFromArray($estiloBloque_2);//8
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A19:A22')->applyFromArray($estiloBloque_2);//CASOS NUEVOS DE TUBERCULOSIS
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B19:C20')->applyFromArray($estiloBloque_2);//PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B21:C22')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A23:A26')->applyFromArray($estiloBloque_2);//RECAÍDA DE TUBERCULOSIS
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B23:C24')->applyFromArray($estiloBloque_2);//PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B25:C26')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A27:A28')->applyFromArray($estiloBloque_2);//CASO PREVIAMENTE TRATADO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A30:Q30')->applyFromArray($estiloBloque_2);//ACUMULAD
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A31:A34')->applyFromArray($estiloBloque_2);//CASOS NUEVOS DE TUBERCULOSIS
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B31:C32')->applyFromArray($estiloBloque_2);//PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B33:C34')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A35:A38')->applyFromArray($estiloBloque_2);//RECAÍDA DE TUBERCULOSIS
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B35:C36')->applyFromArray($estiloBloque_2);//PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B37:C38')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A39:A40')->applyFromArray($estiloBloque_2);//CASO PREVIAMENTE TRATADO
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I19:I29')->applyFromArray($estiloBloque_2);//NUMEROS DEL 1 AL 11
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I31:I41')->applyFromArray($estiloBloque_2);//NUMEROS DEL 12 AL 22
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A42:H43')->applyFromArray($estiloBloque_2);//TB PULMONAR BACTERIOLOGICAMENTE CONFIRMADA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I42:I43')->applyFromArray($estiloBloque_2);//FILA
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J42:K42')->applyFromArray($estiloBloque_2);//NEGATIVO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M42:N42')->applyFromArray($estiloBloque_2);//POSITIVO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P42:Q42')->applyFromArray($estiloBloque_2);//DESCONOCIDO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A44:H44')->applyFromArray($estiloBloque_2);//C
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I44','D')->applyFromArray($estiloBloque_2);//D
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J44','9')->applyFromArray($estiloBloque_2);//9
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K44','10')->applyFromArray($estiloBloque_2);//10
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M44','11')->applyFromArray($estiloBloque_2);//11
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N44','12')->applyFromArray($estiloBloque_2);//12
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P44','13')->applyFromArray($estiloBloque_2);//13
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q44','14')->applyFromArray($estiloBloque_2);//14
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I45','23')->applyFromArray($estiloBloque_2);//23
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I46','24')->applyFromArray($estiloBloque_2);//24
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I47','25')->applyFromArray($estiloBloque_2);//25
//
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J19:Q29')->applyFromArray($estiloBloque_3);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J31:Q41')->applyFromArray($estiloBloque_3);
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J45:K47')->applyFromArray($estiloBloque_3);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M45:N47')->applyFromArray($estiloBloque_3);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P45:Q47')->applyFromArray($estiloBloque_3);
//
//
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q20:Q22')->applyFromArray($estiloBloque_4);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q24:Q26')->applyFromArray($estiloBloque_4);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q32:Q34')->applyFromArray($estiloBloque_4);
//        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q36:Q38')->applyFromArray($estiloBloque_4);
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getFont()->setName('Arial');
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getFont()->setSize(10);
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:X1')->getFont()->setBold(true);
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A2:P2')->applyFromArray($estiloBloque_5);//CATEGORÍA DE EGRESOS PARA LA COHORTE DE TRATATAMIENTO DE TB-MDR
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A3:P3')->applyFromArray($estiloBloque_5);//TRIMESTRE
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A10:P10')->applyFromArray($estiloBloque_5);//ACUMULADO
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A4:H6')->applyFromArray($estiloBloque_2);//CATEGORÍA DE ENTRADA A LA COHORTE
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I4:I6')->applyFromArray($estiloBloque_2);//FILA
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J4:J6')->applyFromArray($estiloBloque_2);//TOTAL DE CASOS DEL GRUPO
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K4:P4')->applyFromArray($estiloBloque_2);//RESULTADOS DEL TRATAMIENTO
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K5:L5')->applyFromArray($estiloBloque_2);//ALTA
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K6')->applyFromArray($estiloBloque_2);//Curados
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('L6')->applyFromArray($estiloBloque_2);//Tto completo
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('M5:M6')->applyFromArray($estiloBloque_2);//FALLECIDOS
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N5:N6')->applyFromArray($estiloBloque_2);//Fracaso al tratamiento
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('O5:O6')->applyFromArray($estiloBloque_2);//Perdida en el seguimiento
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('P5:P6')->applyFromArray($estiloBloque_2);//No evaluado
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A7:H7')->applyFromArray($estiloBloque_2);//D
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I7:P7')->applyFromArray($estiloBloque_2);//NUMEROS
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I8:I9')->applyFromArray($estiloBloque_2);//NUMEROS
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I11:I12')->applyFromArray($estiloBloque_2);//NUMEROS
//
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A8:H8')->applyFromArray($estiloBloque_1);//TB-MDR
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A9:H9')->applyFromArray($estiloBloque_1);//TB-XDR
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A11:H11')->applyFromArray($estiloBloque_1);//TB-MDR
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A12:H12')->applyFromArray($estiloBloque_1);//TB-XDR
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A13:P13')->applyFromArray($estiloBloque_5);//OBSERVACIONES
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A14:P17')->applyFromArray($estiloBloque_8);//OBSERVACIONES
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A13:P13')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A14:P17')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//
//
//
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A18:F21')->applyFromArray($estiloBloque_1);//Certificamos que los datos contenidos en este modelo
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A21:F21')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A22:F22')->getBorders()->getOutline()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A22:F25')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A22:F25')->getFill()->getStartColor()->setARGB('FFFFFF');
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A25:F25')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('F22:F25')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G18:P25')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G18:P25')->getFill()->getStartColor()->setARGB('FFFFFF');
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J18:J25')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M18:M25')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P18:P25')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//
//
//
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B23:E24')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B24:D24')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B24:D24')->getFont()->setName('Arial');
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B24:D24')->getFont()->setSize(8);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B24:D24')->getFont()->setBold(true);
//
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G18:J18')->applyFromArray($estiloBloque_2);//Jefe Dpto. Estadística
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G21:J21')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G24:J24')->applyFromArray($estiloBloque_2);//FIRMA
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K18:M18')->applyFromArray($estiloBloque_2);//Jefe Programa TB
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K21:M21')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K24:M24')->applyFromArray($estiloBloque_2);//FIRMA
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N18:P18')->applyFromArray($estiloBloque_2);//Director
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N21:P21')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N24:P24')->applyFromArray($estiloBloque_2);//FIRMA
//
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G18:P18')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G21:P21')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G21:P21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G24:P24')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G24:P24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G25:P25')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
//
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('K21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('K24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('N21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('N24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P21')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P24')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
//
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J8:P9')->applyFromArray($estiloBloque_3);
//        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J11:P12')->applyFromArray($estiloBloque_3);
//
//    }

}