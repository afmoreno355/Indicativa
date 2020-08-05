<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set('America/Bogota');

$date= date('Y', time());
$dateIn=$date+1;

switch ($accionU){
    case 'PE-04':
       
        $nuevoNombre= explode('.', $_FILES['Excel']['name']);
        copy($_FILES['Excel']['tmp_name'], "/wamp64/www/eagle-IN/Archivos/".$date.".".$nuevoNombre[1]);
        $_SESSION['aviso']="EL PE-04 DEL AÑO $date FUE CARGADO CON EXITO"; 
        $date= date('Y');
        require_once dirname(__FILE__) . '/../../Librerias/lib/trunk/Classes/PHPExcel/IOFactory.php';
        $ficheros1  = scandir("/wamp64/www/eagle-IN/Archivos");
        for ($j = 0; $j < count($ficheros1); $j++) {
           list($nombre, $ext)= explode(".", $ficheros1[$j]);
           if($nombre==$date){

             $objPHPExcel= PHPExcel_IOFactory::load("/wamp64/www/eagle-IN/Archivos/$ficheros1[$j]");
             $objPHPExcel->getActiveSheetIndex(0);             
             for ($i = 0; $i < 20000; $i++) {
                 
                $nombreTilde= array("Á", "É", "Í", "Ó", "Ú");
                $nombreSinTilde= array("A", "E", "I", "O", "U");

                $nombreMay= strtoupper($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
                $nombreExp= str_replace($nombreTilde, $nombreSinTilde, $nombreMay);
                $nombreMayDos= strtoupper($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue());
                $nombreDos= str_replace($nombreTilde, $nombreSinTilde, $nombreMayDos);
                
                 if(substr(strtoupper(trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue())), 6,8)==$dateIn+1 || substr(strtoupper(trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue())), 6,8)==$dateIn){
                     ConectorBD::ejecutarQuery("insert into pe04(regional,sede,ficha,fecha_fin,codigo_programa,municipio,total_aprendiz,tipo,jornada,programa_especial) values({$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()},"
                     . "'{$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()}',{$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()} ,'{$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()}',"
                     . "{$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()}, {$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue()} ,{$objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue()},"
                     . "'$nombreExp','{$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()}','$nombreDos')", null);
                 }
             }
               $j=count($ficheros1);
           }    
        }
        unlink("C:/wamp64/www/eagle-IN/Archivos/".$date.".".$nuevoNombre[1]) ;        
        header("location: index.php?CONTENIDO=View/Sede/Sede.php");
        ob_end_flush();
    break;    
     case 'PERTINENCIA':
       
        $nuevoNombre= explode('.', $_FILES['Excel']['name']);
        copy($_FILES['Excel']['tmp_name'], "/wamp64/www/eagle-IN/Archivos/".$date."PERTINENCIA.".$nuevoNombre[1]);
        $_SESSION['aviso']="LA PERTINENCIA DEL AÑO $date FUE CARGADO CON EXITO"; 
        $date= date('Y');
        require_once dirname(__FILE__) . '/../../Librerias/lib/trunk/Classes/PHPExcel/IOFactory.php';

             $objPHPExcel= PHPExcel_IOFactory::load("/wamp64/www/eagle-IN/Archivos/".$date."PERTINENCIA.".$nuevoNombre[1]);
             $objPHPExcel->getActiveSheetIndex(0);  
             $numeroFilas= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
             for ($i = 0; $i < count($numeroFilas); $i++) {

                
                $nombreExp= round($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue()*100);
                
                 if(is_numeric($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) && is_numeric($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()) && is_numeric($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()) && is_numeric($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()) && is_numeric($nombreExp)){
                     ConectorBD::ejecutarQuery("insert into pertinencia(anio, centro, programa, egresados, indice_pertinencia) values('{$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()}',"
                     . "'{$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()}','{$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()}',{$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()},"
                     . "$nombreExp)", null);
                 }
             }
               
        unlink("C:/wamp64/www/eagle-IN/Archivos/".$date."PERTINENCIA.".$nuevoNombre[1]) ;        
        
        header("location: index.php?CONTENIDO=View/Sede/Sede.php");
        ob_end_flush();
    break; 
}