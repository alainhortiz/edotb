<?php
/**
 * Created by PhpStorm.
 * User: danielito
 * Date: 23/08/2017
 * Time: 20:19
 */

namespace AppBundle\ImprimirExcel;

use \PHPExcel;


class ImpMod46203
{

    public function DatosPDF($datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic,$vih)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('462-03 (anv) ');

        $newSheet = new \PHPExcel_Worksheet($objPHPExcel);
        $objPHPExcel->addSheet($newSheet, 1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('462-03(rev) ');

        $this->HeadBloq($objPHPExcel);

        $this->DimensionCells($objPHPExcel);

        $this->MergeCellsBloq($objPHPExcel);

        $this->TitlesCellBloq($objPHPExcel);

        $this->AllValues($objPHPExcel,$datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic,$vih);

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


        $this->StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5,$estiloBloque_6,$estiloBloque_7,$estiloBloque_8);


//        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A6:B".($j+6));
//        $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "D6:F".($k+6));


        // Inmovilizar paneles
//        $objPHPExcel->getActiveSheet(0)->freezePane('C4');

        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue("MODELO 241-462-04\nPágina 2 de 2");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);


        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('img/minsapLogo.png');
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setOffsetX(110);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


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
        ->setTitle("SEGUIMIENTO DE COHORTES DE TUBERCULOSIS") // Titulo
        ->setSubject("SEGUIMIENTO DE COHORTES DE TUBERCULOSIS") //Asunto
        ->setDescription("SEGUIMIENTO DE COHORTES DE TUBERCULOSIS") //Descripci�n
        ->setKeywords("SEGUIMIENTO DE COHORTES DE TUBERCULOSIS") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function DimensionCells($objPHPExcel){
        //Se dimensiona la columna de arriba para que los nombres queden al ancho de la columna.
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(21);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(9);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(11);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(11);

        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('2')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('3')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('4')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('5')->setRowHeight(14);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('6')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('7')->setRowHeight(14);

        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('17')->setRowHeight(31);

        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('B')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('C')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('J')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('K')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('L')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('M')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('N')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('O')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('P')->setWidth(13);
        $objPHPExcel->setActiveSheetIndex(1)->getRowDimension('1')->setRowHeight(27);
    }

    public function MergeCellsBloq($objPHPExcel){

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:E5');//ESPACIO PARA LA IMAGEN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:E7');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:K4');//SEGUIMIENTO DE COHORTES DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:N1');//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F6:H6');//Variante: Total
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F7:H7');//VIH
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N3:N4');//ANNO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:Q1');//Modelo 241-462-03
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O2:Q2');//Página 1 de 2
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O3:Q3');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:Q4');//Trimestral
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:Q5');//EN BLANCO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:Q6');//Unidad Medida
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O7:Q7');//Uno



        // Se combinan las celdas C2 hasta J2, para colocar ahi el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:C8');//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D8:L8');//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D9:L9');//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M8:M13');//CÓDIGO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N8:Q8');//ORG-CEN-INF-ESTAB.

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A11:C11');//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D11:I11');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D12:I12');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J11:L11');//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J12:L12');//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N11:O11');//CPCU
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P11:Q11');//PROV-MUN

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A14:Q14');//TRIMESTRE

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A15:H17');//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I15:I17');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J15:J17');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K15:P15');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K16:L16');//Alta
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M16:M17');//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N16:N17');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O16:O17');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P16:P17');//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q15:Q17');//Pruebas de sensibilidad

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A18:H18');//A

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A19:A22');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B19:C20');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D19:H19');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D20:H20');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B21:C22');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D21:H21');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D22:H22');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A23:A26');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B23:C24');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D23:H23');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D24:H24');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B25:C26');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D25:H25');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D26:H26');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A27:A28');//CASO PREVIAMENTE TRATADO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B27:H27');//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B28:H28');//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A29:H29');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A30:Q30');//ACUMULADO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A31:A34');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B31:C32');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D31:H31');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D32:H32');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B33:C34');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D33:H33');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D34:H34');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A35:A38');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B35:C36');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D35:H35');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D36:H36');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B37:C38');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D37:H37');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D38:H38');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A39:A40');//CASO PREVIAMENTE TRATADO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B39:H39');//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B40:H40');//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A41:H41');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A42:H43');//TB PULMONAR BACTERIOLOGICAMENTE CONFIRMADA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I42:I43');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J42:K42');//NEGATIVO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M42:N42');//POSITIVO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P42:Q42');//DESCONOCIDO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A44:H44');//C
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A45:H45');//CASOS NUEVOS
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A46:H46');//RECAÍDA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A47:H47');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L42:L47');//VACIOS EN BLANCO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O42:O47');//VACIOS EN BLANCO

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:P1');//Modelo 241-462-04 Página 2 de 2
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A2:P2');//CATEGORÍA DE EGRESOS PARA LA COHORTE DE TRATATAMIENTO DE TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A3:P3');//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A4:H6');//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('I4:I6');//FILA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('J4:J6');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K4:P4');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K5:L5');//ALTA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('M5:M6');//FALLECIDOS
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N5:N6');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('O5:O6');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('P5:P6');//No evaluado
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A7:H7');//D
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A8:H8');//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A9:H9');//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A10:H10');//TB-RR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A11:P11');//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A12:H12');//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A13:H13');//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A14:H14');//TB-RR
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A15:P15');//OBSERVACIONES
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A16:P19');//OBSERVACIONES JUSTIFICACION
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A20:F23');//Certificamos que los datos contenidos en este modelo
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('D24:E24');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('D25:E25');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('D26:E26');//Año

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G20:J20');//Jefe Dpto. Estadística
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G21:J21');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G22:J22');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G23:J23');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G24:J24');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G25:J25');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G26:J26');//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('G27:J27');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K20:M20');//Jefe Programa TB
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K21:M21');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K22:M22');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K23:M23');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K24:M24');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K25:M25');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K26:M26');//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('K27:M27');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N20:P20');//Director
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N21:P21');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N22:P22');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N23:P23');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N24:P24');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N25:P25');//
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N26:P26');//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('N27:P27');//
    }

    public function TitlesCellBloq($objPHPExcel){
        // Se agregan los titulos del reporte

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','MINISTERIO DE SALUD PÚBLICA');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6','SALUD PÚBLICA Y ASISTENCIA SOCIAL');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','SEGUIMIENTO DE COHORTES DE TUBERCULOSIS');//SEGUIMIENTO DE COHORTES DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','INFORME DEL PERÍODO TERMINADO EN:');//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3','I TRIMESTRE');//I TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','II TRIMESTRE');//II TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L5','III TRIMESTRE');//III TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L6','IV TRIMESTRE');//IV TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6','Variante: Total');//Variante: Total
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7','VIH');//VIH
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3','AÑO');//ANNO

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1','Modelo 241-462-04');//Modelo 241-462-03
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2','Página 1 de 2');//Página 1 de 2
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3','Periodicidad:');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','Trimestral');//Trimestral
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O6','Unidad Medida');//Unidad Medida
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O7','Uno');//Uno

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8','ORGANISMO');//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9','MINSAP');//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8','CENTRO INFORMANTE O ESTABLECIMIENTO');//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8','CÓDIGO');//CÓDIGO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N8','ORG-CEN-INF-ESTAB.');//ORG-CEN-INF-ESTAB.

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11','ACTIVIDAD FUNDAMENTAL');//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12','SALUD');//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11','PROVINCIA');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11','MUNICIPIO');//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N11','CPCU');//CPCU
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P11','PROV-MUN');//PROV-MUN

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14','TRIMESTRE');//TRIMESTRE

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A15','CATEGORÍA DE ENTRADA A LA COHORTE');//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I15','FILA');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J15','TOTAL DE CASOS DEL GRUPO');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K15','RESULTADOS DEL TRATAMIENTO');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K16','Alta');//Alta
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K17','Curados');//Curados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L17','Tto completo');//Tto completo
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M16','Fallecido');//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N16','Fracaso al tratamiento');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O16','Perdida en el seguimiento');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P16','No evaluado');//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q15','Pruebas de sensibilidad');//Pruebas de sensibilidad

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A18','A');//A
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I18','B');//B
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J18','1');//1
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K18','2');//2
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L18','3');//3
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M18','4');//4
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N18','5');//5
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O18','6');//6
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P18','7');//7
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q18','8');//8


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A19','CASOS NUEVOS DE TUBERCULOSIS');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B19','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D19','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D20','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B21','EXTRA-PULMONAR');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D21','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D22','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A23','RECAÍDA DE TUBERCULOSIS');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B23','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D23','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D24','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B25','EXTRA-PULMONAR');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D25','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D26','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A27','CASO PREVIAMENTE TRATADO');//CASO PREVIAMENTE TRATADO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B27','Fracaso terapeútico');//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B28','Perdida al seguimiento');//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A29','TOTAL');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A30','ACUMULADO');//ACUMULADO

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A31','CASOS NUEVOS DE TUBERCULOSIS');//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B31','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D31','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D32','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B33','EXTRA-PULMONAR');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D33','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D34','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A35','RECAÍDA DE TUBERCULOSIS');//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B35','PULMONAR');//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D35','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D36','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B37','EXTRA-PULMONAR');//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D37','Bacteriologicamente confirmado');//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D38','Clínicamente diagnosticado');//Clínicamente diagnosticado

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A39','CASO PREVIAMENTE TRATADO');//CASO PREVIAMENTE TRATADO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B39','Fracaso terapeútico');//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B40','Perdida al seguimiento');//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A41','TOTAL');//TOTAL


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I19','1');//1
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I20','2');//2
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I21','3');//3
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I22','4');//4
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I23','5');//5
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I24','6');//6
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I25','7');//7
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I26','8');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I27','9');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I28','10');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I29','11');//8

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I31','12');//1
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I32','13');//2
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I33','14');//3
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I34','15');//4
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I35','16');//5
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I36','17');//6
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I37','18');//7
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I38','19');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I39','20');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I40','21');//8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I41','22');//8

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A42','TB PULMONAR BACTERIOLOGICAMENTE CONFIRMADA');//TB PULMONAR BACTERIOLOGICAMENTE CONFIRMADA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I42','FILA');//FILA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J42','NEGATIVO');//NEGATIVO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M42','POSITIVO');//POSITIVO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P42','DESCONOCIDO');//DESCONOCIDO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A44','C');//C
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A45','CASOS NUEVOS');//CASOS NUEVOS
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A46','RECAÍDA');//RECAÍDA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A47','TOTAL');//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J43','TRIMESTRE');//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M43','TRIMESTRE');//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P43','TRIMESTRE');//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K43','ACUMULADO');//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N43','ACUMULADO');//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q43','ACUMULADO');//ACUMULADO

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I44','D');//D
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J44','9');//9
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K44','10');//10
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M44','11');//11
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N44','12');//12
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P44','13');//13
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q44','14');//14
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I45','23');//23
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I46','24');//24
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I47','25');//25

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2','CATEGORÍA DE EGRESOS PARA LA COHORTE DE TRATAMIENTO DE TB-DR');//CATEGORÍA DE EGRESOS PARA LA COHORTE DE TRATATAMIENTO DE TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3','TRIMESTRE');//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4','CATEGORÍA DE ENTRADA A LA COHORTE');//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I4','FILA');//FILA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J4','TOTAL DE CASOS DEL GRUPO');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K4','RESULTADOS DEL TRATAMIENTO');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K5','ALTA');//ALTA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K6','Curados');//Curados
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L6','Tto completo');//Tto completo
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M5','FALLECIDOS');//FALLECIDOS
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N5','Fracaso al tratamiento');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O5','Perdida en el seguimiento');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P5','No evaluado');//No evaluado
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A7','D');//D
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I7','E');//E
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J7','15');//15
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K7','16');//16
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L7','17');//17
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M7','18');//18
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N7','19');//19
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O7','20');//20
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P7','21');//21
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I8','26');//26
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I9','27');//27
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I10','28');//28
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I12','29');//29
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I13','30');//29
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I14','31');//29
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A8','TB-MDR');//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A9','TB-XDR');//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A10','TB-RR');//TB-RR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A11','ACUMULADO');//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A12','TB-MDR');//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A13','TB-XDR');//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A14','TB-RR');//TB-RR
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A15','OBSERVACIONES:');//OBSERVACIONES
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A20','Certificamos que los datos contenidos en este modelo corresponden a los anotados en nuestros registros primarios y de acuerdo a las instrucciones vigentes para la elaboración del mismo.');//Certificamos que los datos contenidos en este modelo
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B26','DÍA');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C26','MES');//
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D26','AÑO');//

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G20','Jefe Dpto. Estadística');//Jefe Dpto. Estadística
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G23','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G26','FIRMA');//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K20','Jefe Programa TB');//Jefe Programa TB
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K23','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K26','FIRMA');//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N20','Director');//Director
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N23','Nombre y Apellidos');//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N26','FIRMA');//FIRMA
    }

    public function AllValues($objPHPExcel,$datos,$trimestre,$anno,$nomAreaSalud,$provAreaSalud,$municAreaSalud,$codAreaSalud,$codProv,$codMunic,$vih){
        //VALORES DEL ENCABEZADO
        if($trimestre == 1)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 3 , 'X');
        if($trimestre == 2)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 4 , 'X');
        if($trimestre == 3)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 5 , 'X');
        if($trimestre == 4)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 6 , 'X');
        //Si es la variante VIH se maraca en el excel
        if($vih == 1)  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 7 , 'X');
        else  $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, 6 , 'X');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 5 , $anno);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 9 , $nomAreaSalud);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3 , 12, $provAreaSalud);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9 , 12 ,$municAreaSalud);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13 , 12 ,$codAreaSalud);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15 , 12 ,$codProv.'-'.$codMunic);




        //-------------------------------------------------------------------------------------------------
        //CICLOS PARA LLENAR LAS CELDAS QUE POSEEN DATOS---------------------------------------------------
        //-------------------------------------------------------------------------------------------------
        $i = 0; //ESTA VARIABLE SE IRA INCREMENTANDO A MEDIDA QUE SE VAYAN CONSULTANDO LOS ARRAYS EN $datos.

        //FILA 19
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 19 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 19 ,$value);

        //FILA 20
        $i = 1;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 20 ,$value);
        }

        //FILA 21
        $i = 2;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 21 ,$value);
        }

        //FILA 22
        $i = 3;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 22 ,$value);
        }

        //FILA 23
        $i = 4;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 23 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 23 ,$value);

        //FILA 24
        $i = 5;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 24 ,$value);
        }

        //FILA 25
        $i = 6;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 25 ,$value);
        }

        //FILA 26
        $i = 7;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 26 ,$value);
        }

        //FILA 27
        $i = 8;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 27 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 27 ,$value);

        //FILA 28
        $i = 9;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 28 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 28 ,$value);

        //FILA 29
        $i = 10;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 29 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 29 ,$value);

        //FILA 31
        $i = 11;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 31 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 31 ,$value);

        //FILA 32
        $i = 12;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 32 ,$value);
        }

        //FILA 33
        $i = 13;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 33 ,$value);
        }

        //FILA 34
        $i = 14;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 34 ,$value);
        }

        //FILA 35
        $i = 15;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 35 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 35 ,$value);

        //FILA 36
        $i = 16;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 36 ,$value);
        }

        //FILA 37
        $i = 17;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 37 ,$value);
        }

        //FILA 38
        $i = 18;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 38 ,$value);
        }

        //FILA 39
        $i = 19;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 39 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 39 ,$value);

        //FILA 40
        $i = 20;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 40 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 40 ,$value);

        //FILA 41
        $i = 21;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 41 ,$value);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9+$j , 41 ,$value);

        //FILA 45,46,47
        $i = 22;
        for( $j = 0; $j < 9; $j++)
        {
            $value = $datos[$i][$j];
            if($j<3)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9 , 45+$j ,$value);
            if($j>2 && $j<6)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12 , 42+$j ,$value);
            if($j>5 && $j<9)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15 , 39+$j ,$value);
        }

        //FILA 45,46,47
        $i = 23;
        for( $j = 0; $j < 9; $j++)
        {
            $value = $datos[$i][$j];
            if($j<3)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10 , 45+$j ,$value);
            if($j>2 && $j<6)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13 , 42+$j ,$value);
            if($j>5 && $j<9)
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16 , 39+$j ,$value);
        }

        //FILA 8 HOJA 2
        $i = 24;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 8 ,$value);
        }

        //FILA 9 HOJA 2
        $i = 25;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 9 ,$value);
        }

        //FILA 10 HOJA 2
        $i = 26;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 10 ,$value);
        }

        //FILA 12 HOJA 2
        $i = 27;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 12 ,$value);
        }

        //FILA 13 HOJA 2
        $i = 28;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 13 ,$value);
        }

        //FILA 14 HOJA 2
        $i = 29;
        for( $j = 0; $j < 7; $j++)
        {
            $value = $datos[$i][$j];
            $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9+$j , 14 ,$value);
        }
        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
    }

    public function StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_3,$estiloBloque_4,$estiloBloque_5,$estiloBloque_6,$estiloBloque_7,$estiloBloque_8){
        //aplicamos a las celdas los estilos creados anteriomente
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E7')->applyFromArray($estiloBloque_6);//MINISTERIO DE SALUD PUBLICA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:K7')->applyFromArray($estiloBloque_7);//

        $objPHPExcel->setActiveSheetIndex()->getStyle('F1:K4')->applyFromArray(array(
            'font' => array(
                'size' =>18
            )));
        $objPHPExcel->setActiveSheetIndex()->getStyle('F6:H7')->applyFromArray(array(
            'font' => array(
                'size' =>12
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )));


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L1:N7')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex()->getStyle('L3:L6')->applyFromArray(array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )));
        $objPHPExcel->setActiveSheetIndex()->getStyle('M3:M6')->applyFromArray(array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            ),
            'borders' => array(
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                )
            )));

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O1:Q2')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O3:Q5')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O6:Q7')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:C10')->applyFromArray($estiloBloque_1);//ORGANISMO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D8:L10')->applyFromArray($estiloBloque_1);//CENTRO INFORMANTE O ESTABLECIMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N8:Q10')->applyFromArray($estiloBloque_1);//ORG-CEN-INF-ESTAB.

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A11:C13')->applyFromArray($estiloBloque_1);//ACTIVIDAD FUNDAMENTAL
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D11:I13')->applyFromArray($estiloBloque_1);//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J11:L13')->applyFromArray($estiloBloque_1);//MUNICIPIO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N11:O13')->applyFromArray($estiloBloque_1);//CPCU
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P11:Q13')->applyFromArray($estiloBloque_1);//PROV-MUN

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D19:H19')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D20:H20')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D21:H21')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D22:H22')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D23:H23')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D24:H24')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D25:H25')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D26:H26')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B27:H27')->applyFromArray($estiloBloque_1);//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B28:H28')->applyFromArray($estiloBloque_1);//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A29:H29')->applyFromArray($estiloBloque_1);//TOTAL
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D31:H31')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D32:H32')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D33:H33')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D34:H34')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D35:H35')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D36:H36')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D37:H37')->applyFromArray($estiloBloque_1);//Bacteriologicamente confirmado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D38:H38')->applyFromArray($estiloBloque_1);//Clínicamente diagnosticado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B39:H39')->applyFromArray($estiloBloque_1);//Fracaso terapeútico
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B40:H40')->applyFromArray($estiloBloque_1);//Perdida al seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A41:H41')->applyFromArray($estiloBloque_1);//TOTAL

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A45:H45')->applyFromArray($estiloBloque_1);//CASOS NUEVOS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A46:H46')->applyFromArray($estiloBloque_1);//RECAÍDA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A47:H47')->applyFromArray($estiloBloque_1);//TOTAL



        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M8:M13')->applyFromArray($estiloBloque_2);//CÓDIGO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A14:Q14')->applyFromArray($estiloBloque_2);//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A15:H17')->applyFromArray($estiloBloque_2);//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I15:I17')->applyFromArray($estiloBloque_2);//FILA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J15:J17')->applyFromArray($estiloBloque_2);//TOTAL DE CASOS DEL GRUPO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K15:P15')->applyFromArray($estiloBloque_2);//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K16:L16')->applyFromArray($estiloBloque_2);//Alta
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K17')->applyFromArray($estiloBloque_2);//Curados
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L17')->applyFromArray($estiloBloque_2);//Tto completo
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M16:M17')->applyFromArray($estiloBloque_2);//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N16:N17')->applyFromArray($estiloBloque_2);//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O16:O17')->applyFromArray($estiloBloque_2);//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P16:P17')->applyFromArray($estiloBloque_2);//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q15:Q17')->applyFromArray($estiloBloque_2);//Pruebas de sensibilidad

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A18:H18')->applyFromArray($estiloBloque_2);//A
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I18','B')->applyFromArray($estiloBloque_2);//B
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J18','1')->applyFromArray($estiloBloque_2);//1
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K18','2')->applyFromArray($estiloBloque_2);//2
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L18','3')->applyFromArray($estiloBloque_2);//3
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M18','4')->applyFromArray($estiloBloque_2);//4
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N18','5')->applyFromArray($estiloBloque_2);//5
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O18','6')->applyFromArray($estiloBloque_2);//6
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P18','7')->applyFromArray($estiloBloque_2);//7
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q18','8')->applyFromArray($estiloBloque_2);//8

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A19:A22')->applyFromArray($estiloBloque_2);//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B19:C20')->applyFromArray($estiloBloque_2);//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B21:C22')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A23:A26')->applyFromArray($estiloBloque_2);//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B23:C24')->applyFromArray($estiloBloque_2);//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B25:C26')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A27:A28')->applyFromArray($estiloBloque_2);//CASO PREVIAMENTE TRATADO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A30:Q30')->applyFromArray($estiloBloque_2);//ACUMULAD
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A31:A34')->applyFromArray($estiloBloque_2);//CASOS NUEVOS DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B31:C32')->applyFromArray($estiloBloque_2);//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B33:C34')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A35:A38')->applyFromArray($estiloBloque_2);//RECAÍDA DE TUBERCULOSIS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B35:C36')->applyFromArray($estiloBloque_2);//PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B37:C38')->applyFromArray($estiloBloque_2);//EXTRA-PULMONAR
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A39:A40')->applyFromArray($estiloBloque_2);//CASO PREVIAMENTE TRATADO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I19:I29')->applyFromArray($estiloBloque_2);//NUMEROS DEL 1 AL 11
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I31:I41')->applyFromArray($estiloBloque_2);//NUMEROS DEL 12 AL 22

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A42:H43')->applyFromArray($estiloBloque_2);//TB PULMONAR BACTERIOLOGICAMENTE CONFIRMADA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I42:I43')->applyFromArray($estiloBloque_2);//FILA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J42:K42')->applyFromArray($estiloBloque_2);//NEGATIVO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M42:N42')->applyFromArray($estiloBloque_2);//POSITIVO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P42:Q42')->applyFromArray($estiloBloque_2);//DESCONOCIDO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A44:H44')->applyFromArray($estiloBloque_2);//C
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P43','TRIMESTRE')->applyFromArray($estiloBloque_2);//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q43','ACUMULADO')->applyFromArray($estiloBloque_2);//ACUMULADO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I44','D')->applyFromArray($estiloBloque_2);//D
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J44','9')->applyFromArray($estiloBloque_2);//9
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K44','10')->applyFromArray($estiloBloque_2);//10
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M44','11')->applyFromArray($estiloBloque_2);//11
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N44','12')->applyFromArray($estiloBloque_2);//12
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P44','13')->applyFromArray($estiloBloque_2);//13
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q44','14')->applyFromArray($estiloBloque_2);//14
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I45','23')->applyFromArray($estiloBloque_2);//23
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I46','24')->applyFromArray($estiloBloque_2);//24
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I47','25')->applyFromArray($estiloBloque_2);//25


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J19:Q29')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J31:Q41')->applyFromArray($estiloBloque_3);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J45:K47')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M45:N47')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P45:Q47')->applyFromArray($estiloBloque_3);


        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q20:Q22')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q24:Q26')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q32:Q34')->applyFromArray($estiloBloque_4);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q36:Q38')->applyFromArray($estiloBloque_4);

        //rectificando borders de la primera hoja
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A29:Q29')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A41:Q41')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A47:Q47')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J47:K47')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M47:N47')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P47:Q47')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L45:L47')->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L45:L47')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O45:O47')->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O45:O47')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q45:Q47')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);

        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getFont()->setName('Arial');
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getFont()->setSize(10);
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A1:P1')->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A2:P2')->applyFromArray($estiloBloque_5);//CATEGORÍA DE EGRESOS PARA LA COHORTE DE TRATATAMIENTO DE TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A3:P3')->applyFromArray($estiloBloque_5);//TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A11:P11')->applyFromArray($estiloBloque_5);//ACUMULADO

        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A4:H6')->applyFromArray($estiloBloque_2);//CATEGORÍA DE ENTRADA A LA COHORTE
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I4:I6')->applyFromArray($estiloBloque_2);//FILA
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J4:J6')->applyFromArray($estiloBloque_2);//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K4:P4')->applyFromArray($estiloBloque_2);//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K5:L5')->applyFromArray($estiloBloque_2);//ALTA
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K6')->applyFromArray($estiloBloque_2);//Curados
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('L6')->applyFromArray($estiloBloque_2);//Tto completo
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('M5:M6')->applyFromArray($estiloBloque_2);//FALLECIDOS
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N5:N6')->applyFromArray($estiloBloque_2);//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('O5:O6')->applyFromArray($estiloBloque_2);//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('P5:P6')->applyFromArray($estiloBloque_2);//No evaluado
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A7:H7')->applyFromArray($estiloBloque_2);//D
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I7:P7')->applyFromArray($estiloBloque_2);//NUMEROS
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I8:I10')->applyFromArray($estiloBloque_2);//NUMEROS
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('I12:I14')->applyFromArray($estiloBloque_2);//NUMEROS


        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A8:H8')->applyFromArray($estiloBloque_1);//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A9:H9')->applyFromArray($estiloBloque_1);//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A10:H10')->applyFromArray($estiloBloque_1);//TB-XRR

        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A12:H12')->applyFromArray($estiloBloque_1);//TB-MDR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A13:H13')->applyFromArray($estiloBloque_1);//TB-XDR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A14:H14')->applyFromArray($estiloBloque_1);//TB-RR
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A15:P15')->applyFromArray($estiloBloque_8);//OBSERVACIONES
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A16:P19')->applyFromArray($estiloBloque_8);//OBSERVACIONES
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A15:P15')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A16:P19')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);




        $objPHPExcel->setActiveSheetIndex(1)->getStyle('A20:F23')->applyFromArray($estiloBloque_1);//Certificamos que los datos contenidos en este modelo
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A23:F23')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A24:F24')->getBorders()->getOutline()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A24:F27')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A24:F27')->getFill()->getStartColor()->setARGB('FFFFFF');
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('A27:F27')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('F24:F27')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G20:P27')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G20:P27')->getFill()->getStartColor()->setARGB('FFFFFF');
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J20:J27')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M20:M27')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P20:P27')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);



            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B25:E26')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B26:D26')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B26:D26')->getFont()->setName('Arial');
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B26:D26')->getFont()->setSize(8);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('B26:D26')->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G20:J20')->applyFromArray($estiloBloque_2);//Jefe Dpto. Estadística
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G23:J23')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('G26:J26')->applyFromArray($estiloBloque_2);//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K20:M20')->applyFromArray($estiloBloque_2);//Jefe Programa TB
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K23:M23')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('K26:M26')->applyFromArray($estiloBloque_2);//FIRMA
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N20:P20')->applyFromArray($estiloBloque_2);//Director
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N23:P23')->applyFromArray($estiloBloque_2);//Nombre y Apellidos
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('N26:P26')->applyFromArray($estiloBloque_2);//FIRMA

            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G20:P20')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G23:P23')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G26:P26')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);

            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G23:P23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G26:P26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G27:P27')->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);

            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('G26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);

            $objPHPExcel->setActiveSheetIndex(1)->getStyle('K23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('K26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('M26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);

            $objPHPExcel->setActiveSheetIndex(1)->getStyle('N23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('N26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P23')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('P26')->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);

        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J8:P10')->applyFromArray($estiloBloque_3);
        $objPHPExcel->setActiveSheetIndex(1)->getStyle('J12:P14')->applyFromArray($estiloBloque_3);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J8:P10')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
            $objPHPExcel->setActiveSheetIndex(1)->getStyle('J12:P14')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);

    }

}