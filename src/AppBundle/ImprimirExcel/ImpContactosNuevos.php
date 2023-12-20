<?php


namespace AppBundle\ImprimirExcel;


class ImpContactosNuevos
{
    public function DatosExcel($datos,$trimestre,$anno,$objectEnfermedad)
    {
        $objPHPExcel = new PHPExcel();

        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle($objectEnfermedad->getCodigo());

        $this->HeadBloq($objPHPExcel);

        $this->DimensionCells($objPHPExcel);

        $this->MergeCellsBloq($objPHPExcel);

        $this->TitlesCellBloq($objPHPExcel , $objectEnfermedad);

        $this->AllValues($objPHPExcel,$datos,$trimestre,$anno);

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

        $this->StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_6,$estiloBloque_7);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);


        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('img/minsapLogo.png');
        $objDrawing->setHeight(90);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setOffsetX(90);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Cohorte Cri Ent.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function HeadBloq($objPHPExcel){
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("MINISTERIO SALUD") // Nombre del autor
        ->setLastModifiedBy("MINISTERIO SALUD") //Ultimo usuario que lo modific�
        ->setTitle("COHORTE POR CRITERIOS DE ENTRADA") // Titulo
        ->setSubject("COHORTE POR CRITERIOS DE ENTRADA") //Asunto
        ->setDescription("COHORTE POR CRITERIOS DE ENTRADA") //Descripci�n
        ->setKeywords("COHORTE POR CRITERIOS DE ENTRADA") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function DimensionCells($objPHPExcel){
        //Se dimensiona la columna de arriba para que los nombres queden al ancho de la columna.
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(2);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(2);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(2);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(14);

        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('2')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('3')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('4')->setRowHeight(13);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('5')->setRowHeight(14);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('6')->setRowHeight(15);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('7')->setRowHeight(14);
    }

    public function MergeCellsBloq($objPHPExcel){

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:E5');//ESPACIO PARA LA IMAGEN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:E6');//
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:E7');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:K7');//COHORTE POR CRITERIOS DE ENTRADA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:N1');//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N3:N4');//ANNO

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O3:P3');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4');//Trimestral

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:P8');//CRITERIO DE ENTRADA

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:H11');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I9:I11');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J9:P9');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J10:K10');//Alta
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L10:L11');//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M10:M11');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N10:N11');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O10:O11');//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P10:P11');//Reparo de Diagnóstico
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A12:P12');//NUMERO DE CASOS

        for ($i = 13 ; $i < 30 ; $i++)
        {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':H'.$i);//NOMBRE DE PROVINCIA
        }

    }

    public function TitlesCellBloq($objPHPExcel , $objectEnfermedad){
        // Se agregan los titulos del reporte

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','MINISTERIO DE SALUD PÚBLICA');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7','SALUD PÚBLICA Y ASISTENCIA SOCIAL');//SALUD PÚBLICA Y ASISTENCIA SOCIAL

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','COHORTE POR CRITERIOS DE ENTRADA');//COHORTE POR CRITERIOS DE ENTRADA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','INFORME DEL PERÍODO TERMINADO EN:');//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3','I TRIMESTRE');//I TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','II TRIMESTRE');//II TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L5','III TRIMESTRE');//III TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L6','IV TRIMESTRE');//IV TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3','AÑO');//ANNO

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3','Periodicidad:');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','Trimestral');//Trimestral

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8','CRITERIO DE ENTRADA: Caso '.$objectEnfermedad->criterioCompleto().' ('.$objectEnfermedad->getCodigo().')');//CRITERIO DE ENTRADA

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9','PROVINCIA');//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I9','TOTAL DE CASOS');//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9','RESULTADOS DEL TRATAMIENTO');//RESULTADOS DEL TRATAMIENTO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10','Alta');//Alta
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11','Curados');//Curados
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K11','Tto completo');//Tto completo
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10','Fallecido');//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M10','Fracaso al tratamiento');//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10','Perdida en el seguimiento');//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O10','No evaluado');//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P10','Reparo de Diagnóstico');//Reparo de Diagnóstico
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12','NUMERO DE CASOS');//Reparo de Diagnóstico

    }

    public function StyleCellBloq($objPHPExcel,$estiloBloque_1,$estiloBloque_2,$estiloBloque_6,$estiloBloque_7){
        //aplicamos a las celdas los estilos creados anteriomente
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E7')->applyFromArray($estiloBloque_6);//MINISTERIO DE SALUD PUBLICA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:K7')->applyFromArray($estiloBloque_7);//

        $objPHPExcel->setActiveSheetIndex()->getStyle('F1:K7')->applyFromArray(array(
            'font' => array(
                'size' =>18
            )));
        $objPHPExcel->setActiveSheetIndex()->getStyle('F6:K7')->applyFromArray(array(
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
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O1:P7')->applyFromArray($estiloBloque_6);//INFORME DEL PERÍODO TERMINADO EN:
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:P8')->applyFromArray($estiloBloque_1);//CRITERIO DE ENTRADA

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9:H11')->applyFromArray($estiloBloque_2);//PROVINCIA
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I9:I11')->applyFromArray($estiloBloque_2);//TOTAL DE CASOS DEL GRUPO
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('J9:J11')->applyFromArray($estiloBloque_2);//RESULTADOS DEL TRATAMIENTO

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K9:P9')->applyFromArray($estiloBloque_2);//Alta
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K10:L10')->applyFromArray($estiloBloque_2);//Curados
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('K11')->applyFromArray($estiloBloque_2);//Tto completo
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('L11')->applyFromArray($estiloBloque_2);//Fallecido
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('M10:M11')->applyFromArray($estiloBloque_2);//Fracaso al tratamiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('N10:N11')->applyFromArray($estiloBloque_2);//Perdida en el seguimiento
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('O10:O11')->applyFromArray($estiloBloque_2);//No evaluado
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P10:P11')->applyFromArray($estiloBloque_2);//Reparo de Diagnóstico
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A12:P12')->applyFromArray($estiloBloque_2);//NUMERO DE CASOS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A13:A29')->applyFromArray($estiloBloque_1);//NOMBRE PROVINCIAS
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I13:P29')->applyFromArray($estiloBloque_2);//DATOS

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A13:H29')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I13:P28')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P13:P28')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);


    }

    public function AllValues($objPHPExcel,$datos,$trimestre,$anno){
        //VALORES DEL ENCABEZADO
        if($trimestre == 1)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 3 , 'X');
        if($trimestre == 2)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 4 , 'X');
        if($trimestre == 3)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 5 , 'X');
        if($trimestre == 4)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, 6 , 'X');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, 5 , $anno);

        //-------------------------------------------------------------------------------------------------
        //CICLOS PARA LLENAR LAS CELDAS QUE POSEEN DATOS---------------------------------------------------

        $fila = 13;
        foreach ($datos as $dato)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$fila, $dato['provincia']);
            for ($i = 'I' , $pos = 0; $i <= 'P' ; $i++ , $pos++)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.$fila,$dato['pacientes'][$pos]);
            }
            $fila++;
        }
    }

}