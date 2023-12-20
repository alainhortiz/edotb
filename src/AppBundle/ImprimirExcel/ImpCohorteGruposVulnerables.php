<?php


namespace AppBundle\ImprimirExcel;

use \PHPExcel;

class ImpCohorteGruposVulnerables
{
    public function DatosExcel($datos,$trimestre,$anno,$grupoVulnerable,$provincias,$municipios,$areasSalud,$hospitales)
    {
        $objPHPExcel = new PHPExcel();

        $cantidad = 0;
        if(!empty($provincias)) $cantidad = count($provincias);
        if(!empty($municipios)) $cantidad = count($municipios);
        if(!empty($areasSalud)) $cantidad += count($areasSalud);
        if(!empty($hospitales)) $cantidad += count($hospitales);

        $objPHPExcel->getActiveSheet()->setTitle('GRUPO V '.$grupoVulnerable->getNumero());
        $this->HeadBloq($objPHPExcel);

        $this->DimensionCells($objPHPExcel ,$provincias ,$municipios ,$areasSalud ,$hospitales ,$cantidad);

        $this->MergeCellsBloq($objPHPExcel ,$areasSalud ,$hospitales ,$cantidad);

        $this->TitlesCellBloq($objPHPExcel ,$grupoVulnerable,$trimestre ,$anno ,$provincias ,$municipios ,$areasSalud ,$hospitales ,$cantidad);

        $estiloBloque_1 = array(
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
                'size' =>18,
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
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                ),
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
            'fill' => array(
                'type'  => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'ffffff')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloBloque_4 = array(
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
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );


        $this->StyleCellBloq($objPHPExcel ,$estiloBloque_1 ,$estiloBloque_2 ,$estiloBloque_3 ,$estiloBloque_4 ,$cantidad);

        $this->AllValues($objPHPExcel,$datos,$cantidad);

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
        header('Content-Disposition: attachment;filename="Cohorte Grupos Vulnerables.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function HeadBloq($objPHPExcel){
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("MINISTERIO SALUD") // Nombre del autor
        ->setLastModifiedBy("MINISTERIO SALUD") //Ultimo usuario que lo modific�
        ->setTitle("COHORTE POR GRUPOS VULNERABLES") // Titulo
        ->setSubject("COHORTE POR GRUPOS VULNERABLES") //Asunto
        ->setDescription("COHORTE POR GRUPOS VULNERABLES") //Descripci�n
        ->setKeywords("COHORTE POR GRUPOS VULNERABLES") //Etiquetas
        ->setCategory("Reporte Excel"); //Categorias
    }

    public function DimensionCells($objPHPExcel,$provincias,$municipios,$areasSalud,$hospitales,$cantidad)
    {
        if($cantidad < 7) $cantidad = 7;
        $column = 'A';
        for($i = 1 ; $i <= $cantidad + 5 ; $i++)
        {
            if($column != 'A' and $column != 'B' and $column != 'C' and $cantidad == 7) $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($column)->setWidth(16);
            else $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($column)->setWidth(12);
            $column++;
        }
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension('10')->setRowHeight(40);
        for($i = 11 ; $i <= 27 ; $i++)
        {
            $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($i)->setRowHeight(30);
        }
    }

    public function MergeCellsBloq($objPHPExcel ,$areasSalud ,$hospitales ,$cantidad)
    {
        //poniendo una cantidad de columnas minima para que los titulos queden bien
        $cantReal = 0;
        if($cantidad < 7){ $cantReal = $cantidad; $cantidad = 7; }

        //inicio codigo de los primeros encabezados filas 1 - 8
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:C6');//ESPACIO PARA LA IMAGEN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:C7');//SALUD PÚBLICA Y ASISTENCIA SOCIAL
        $column = 'D';
        for($i = 1 ; $i <= $cantidad - 4 ; $i++){ $column++; }
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:'.$column.'7');//COHORTE POR GRUPOS VULNERABLES

        $nextColumn = $column;
        for($i = 1 ; $i <= 3 ; $i++){ $nextColumn++; }
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($column.'1:'.$nextColumn.'1');//INFORME DEL PERÍODO TERMINADO EN
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($nextColumn.'3:'.$nextColumn.'4');//Año
        $column = $nextColumn;
        for($i = 1 ; $i <= 2 ; $i++){ $nextColumn++; }
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($column.'3:'.$nextColumn.'3');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($column.'4:'.$nextColumn.'4');//Trimestral
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:'.$nextColumn.'8');//Grupo Vulnerable

        //inicio codigo de los primeros encabezados filas 1 - 8

        //la siguiente parte cambia de acuerdo a la cantidad real de columnas
        $nextColumn = 'E';
        for($i = 1 ; $i < $cantidad ; $i++){ $nextColumn++; }

        //el siguiente ciclo mezcla mas celdas si la cantidad es menor que 7
        $finMerge = 'D';
        if($cantReal != 0)  for($i = 1 ; $i <= $cantidad - $cantReal ; $i++){ $finMerge++; }

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:'.$finMerge.'10');//CÓDIGO DE ENTRADA A LA COHORTE
        //datos
        for($i = 11 ; $i <= 27 ; $i++)
        {
            if($i < 27)  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':'.$finMerge.$i);
            else  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':'.$finMerge.$i);
        }
        $finMerge++;
        if(empty($areasSalud) and empty($hospitales))  $objPHPExcel->setActiveSheetIndex(0)->mergeCells($finMerge.'9:'.$nextColumn.'9');//PROVINCIAS - MUNICIPIOS
        else{
            $column = $finMerge;
            if(!empty($areasSalud))
            {
                for($i = 1 ; $i < count($areasSalud) ; $i++){ $column++; }
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($finMerge.'9:'.$column.'9');//AREAS DE SALUD
            }
            if(!empty($hospitales))
            {
                $column++;
                if (!empty($hospitales)) $objPHPExcel->setActiveSheetIndex(0)->mergeCells($column.'9:'.$nextColumn.'9');//HOSPITALES
            }
        }
        $nextColumn++;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($nextColumn.'9:'.$nextColumn.'10');//TOTAL


    }

    public function TitlesCellBloq($objPHPExcel ,$grupoVulnerable ,$trimestre ,$anno ,$provincias ,$municipios ,$areasSalud ,$hospitales ,$cantidad)
    {
        //poniendo una cantidad de columnas minima para que los titulos queden bien
        $cantReal = 0;
        if($cantidad < 7){ $cantReal = $cantidad; $cantidad = 7; }
        //inicio codigo de los primeros encabezados filas 1 - 8
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','MINISTERIO DE SALUD PÚBLICA');//MINISTERIO DE SALUD PÚBLICA
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7','SALUD PÚBLICA Y ASISTENCIA SOCIAL');//SALUD PÚBLICA Y ASISTENCIA SOCIAL
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','COHORTE POR GRUPOS VULNERABLES');//COHORTE POR GRUPOS VULNERABLES

        $column = 'D';
        for($i = 1 ; $i <= $cantidad - 3 ; $i++){ $column++; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'1','INFORME DEL PERÍODO TERMINADO EN:');//INFORME DEL PERÍODO TERMINADO EN
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'3','I TRIMESTRE');//I TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'4','II TRIMESTRE');//II TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'5','III TRIMESTRE');//III TRIMESTRE
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'6','IV TRIMESTRE');//IV TRIMESTRE
        $column++;
        if($trimestre == 1)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'3','X');
        if($trimestre == 2)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'4','X');
        if($trimestre == 3)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'5','X');
        if($trimestre == 4)
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'6','X');
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'3','AÑO');//ANNO
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'5',$anno);//
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'3','Periodicidad:');//Periodicidad:
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'4','Trimestral');//Trimestral
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8','GRUPO VULNERABLE: '.$grupoVulnerable->getGrupo());//Grupo Vulnerable
        //inicio codigo de los primeros encabezados filas 1 - 8


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9','CÓDIGO DE ENTRADA A LA COHORTE');//CÓDIGO DE ENTRADA A LA COHORTE

        $column = 'E';
        if($cantReal != 0)  for($i = 1 ; $i <= $cantidad - $cantReal ; $i++){ $column++; }

        if(!empty($areasSalud) and !empty($hospitales))
        {
            if(!empty($areasSalud))
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'9','AREAS DE SALUD');//AREAS DE SALUD
                for($i = 1 ; $i <= count($areasSalud) ; $i++)
                {
                    $area = $areasSalud[$i - 1];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'10',$area->getNombre());
                    $column++;
                }
            }
            if(!empty($hospitales)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue( $column.'9','HOSPITALES');//HOSPITALES
                foreach ($hospitales as $hospital)
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'10',$hospital->getNombre());
                    $column++;
                }
            }

        }
        elseif (!empty($municipios))
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'9','MUNICIPIOS');//MUNICIPIOS
            foreach ($municipios as $municipio)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'10',$municipio->getNombre());
                $column++;
            }
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'9','PROVINCIAS');//PROVINCIAS
            foreach ($provincias as $provincia)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'10',$provincia->getNombre());
                $column++;
            }
        }

        $column = 'E';
        for($i = 1 ; $i <= $cantidad ; $i++){ $column++; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'9','TOTAL');//TOTAL

    }

    public function StyleCellBloq($objPHPExcel ,$estiloBloque_1 ,$estiloBloque_2 ,$estiloBloque_3 ,$estiloBloque_4 ,$cantidad)
    {
        //poniendo una cantidad de columnas minima para que los titulos queden bien
        $cantReal = 0;
        if($cantidad < 7){ $cantReal = $cantidad; $cantidad = 7; }

        //inicio codigo de los primeros encabezados filas 1 - 8
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:C7')->applyFromArray($estiloBloque_1);//MINISTERIO DE SALUD PUBLICA
        $column = 'D';
        for($i = 1 ; $i <= $cantidad - 4 ; $i++){ $column++; }
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:'.$column.'7')->applyFromArray($estiloBloque_2);//COHORTE POR GRUPOS VULNERABLES
        $nextColumn = $column;
        for($i = 1 ; $i <= 5 ; $i++){ $nextColumn++; }
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($column.'1:'.$nextColumn.'7')->applyFromArray($estiloBloque_1);//estilo de las 5 ultimas columnas
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($column.'1:'.$nextColumn.'7')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_NONE);//Todos los bordes
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($column.'3:'.$column.'6')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);//borde costado año
        $column++;
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($column.'1:'.$column.'7')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);//borde costado año

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:'.$nextColumn.'8')->applyFromArray($estiloBloque_3);//Grupo Vulnerable
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($nextColumn.'1:'.$nextColumn.'7')->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);//borde costado final

        //inicio codigo de los primeros encabezados filas 1 - 8

        $finMerge = 'E';
        if($cantReal != 0)  for($i = 1 ; $i <= $cantidad - $cantReal ; $i++){ $finMerge++; }

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9:'.$nextColumn.'9')->applyFromArray($estiloBloque_3);//CÓDIGO DE ENTRADA A LA COHORTE -  PROVINCIAS - MUNICIPIOS ... - TOTAL
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9:'.$nextColumn.'10')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle($finMerge.'10:'.$nextColumn.'10')->applyFromArray($estiloBloque_1);//subtitulos
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($finMerge.'10:'.$nextColumn.'10')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);

        //datos
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A11:'.$nextColumn.'27')->applyFromArray($estiloBloque_4);
        $finMerge = 'D';
        if($cantReal != 0)  for($i = 1 ; $i <= $cantidad - $cantReal ; $i++){ $finMerge++; }
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A11:'.$finMerge.'27')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle($nextColumn.'11:'.$nextColumn.'27')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A27:'.$nextColumn.'27')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B11:B27')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    }

    public function AllValues($objPHPExcel,$datos,$cantidad)
    {
        //ubicando el inicio de los datos
        $cantReal = 0;
        if($cantidad < 7){ $cantReal = $cantidad; $cantidad = 7; }
        $finMerge = 'E';
        if($cantReal != 0)  for($i = 1 ; $i <= $cantidad - $cantReal ; $i++){ $finMerge++; }
        $lastColumn = 'E';
        for($i = 1 ; $i <= $cantidad ; $i++){ $lastColumn++; }
        //-------------------------------------------------------------------------------------------------
        //CICLOS PARA LLENAR LAS CELDAS QUE POSEEN DATOS---------------------------------------------------

        $fila = 11;
        foreach ($datos as $dato)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$fila, $dato['enfemedadCodigo']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $dato['enfemedadCriterioCompleto']);
            for ($i = $finMerge , $pos = 0; $i <= $lastColumn ; $i++ , $pos++)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.$fila,$dato['pacientes'][$pos]);
            }
            $fila++;
        }

    }

}