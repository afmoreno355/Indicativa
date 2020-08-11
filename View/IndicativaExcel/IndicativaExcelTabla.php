<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../classes/ConectorBD.php';
require_once dirname(__FILE__).'/../../classes/Indicativa.php';

date_default_timezone_set('America/Bogota');
$dateIndicativa= date('Y', time());
$VigenciaEnvio=($dateIndicativa+1);

$listaAviso="<tr><th> Id Programa</th><th> Identificador Programa</th><th> Nombre Programa</th><th> Tipo Programa</th><th> Pertinencia</th><th> Acción</th></tr>";

session_start();

foreach ($_POST as $key => $value) ${$key}=$value;

require_once dirname(__FILE__) . '/../../Librerias/lib/trunk/Classes/PHPExcel/IOFactory.php';

        $objPHPExcel= PHPExcel_IOFactory::load($_SESSION['ruta']);
        $objPHPExcel->getActiveSheetIndex(0);  
        $numeroFilas= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        for ($i = 0; $i < count($numeroFilas); $i++) {
        $valor1=false;    
            if(is_numeric($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) && $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()>0 && $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()<=4){
                $datos=ConectorBD::ejecutarQuery("select * from programas where id_programa='".$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()."'", "eagle_admin"); 
                if(!empty($datos)){
                    if($datos[0][2]!='TECNOLOGIA' && $datos[0][2]!='ESPECIALIZACION TECNOLOGICA' ){
                        $valor1=true;
                    }else{
                        if(!empty(ConectorBD::ejecutarQuery("select id_sede , lugar_desarrollo.id_resolucion, resoluciones.id_resolucion,fecha_resolucion,denominacion_programa ,modalidad,nivel_programa ,modalidad   from lugar_desarrollo, resoluciones where resoluciones.id_resolucion=lugar_desarrollo.id_resolucion and lugar_desarrollo.id_sede='{$_SESSION['sede']}' and lugar_desarrollo.resuelve='OTORGAMIENTO' and fecha_resolucion::date+'7 year'::interval >= 'now()' and denominacion_programa ='".$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()."';", 'registro'))){
                        $valor1=true; 
                        }
                    }
                }                
                if(is_numeric($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()) && strlen($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue())<8 && $valor1==true ){
                    if(is_numeric($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()) && $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()>0 && $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()<=12){
                        if(is_numeric($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()) && (($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()%30)==0 || ($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()%25)==0)){
                            if(is_numeric($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue())){
                                if(is_numeric($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()) && ( $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()==($dateIndicativa+1) ||  $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()==($dateIndicativa+2) || $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()==($dateIndicativa+3) ) ) {
                                    if(is_numeric($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue())){
                                        if(is_numeric($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue())){
                                            if(strlen($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue())==1 && ( $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()=='n' || $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()=='s' || $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()=='N' || $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()=='S' ) ){
                                                if(strlen($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue())==1 && ( $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()=='n' || $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()=='s' || $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()=='N' || $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()=='S' ) ){
                                                    if(is_numeric($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()) && $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()>0 && $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()<=3){
                                                        if(trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue())=='ABIERTA' || trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue())=='ABIERTA DE FORMACION' || trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue())=='ESPECIAL' || trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue())=='ARTICULACION' ){
                                                            $cadena="accionU=ADICIONAR&cod_centro={$_SESSION['sede']}&vigencia=$VigenciaEnvio&inicio={$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()}&id_programa={$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()}&cupos={$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()}&municipio={$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue()}&anio_termina={$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()}&curso={$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()}&ambiente_requiere={$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()}&gira_tecnica={$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()}&programa_fic={$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()}&id_modalidad={$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()}&formacion={$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue()}";
                                                            $cadena2=Indicativa::encryptIt($cadena);
                                                            $listaAviso.="<tr>"; 
                                                            $listaAviso.="<td>{$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()}</td>"; 
                                                            $listaAviso.="<td>{$datos[0][0]}</td>"; 
                                                            $listaAviso.="<td>{$datos[0][1]}</td>"; 
                                                            $listaAviso.="<td>{$datos[0][2]}</td>"; 
                                                            $listaAviso.="<td>";
                                                            $listaAviso.=!empty(ConectorBD::ejecutarQuery("select indice_pertinencia from pertinencia where anio='$dateIndicativa' and centro='{$_SESSION['sede']}' and programa='{$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()}';", null)) ? ConectorBD::ejecutarQuery("select indice_pertinencia from pertinencia where anio='$dateIndicativa' and centro='{$_SESSION['sede']}' and programa='{$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()}';", null)[0][0]."%" : "0%";
                                                            $listaAviso."</td>"; 
                                                            $listaAviso.="<td>";
                                                            $listaAviso.="<input type='button'  name='1' id='accionU' value='ACEPTAR' onmouseup='reloadPadre()' onclick='idexistentesReCa(``,`cadenaValorNuevo=$cadena2`,``,`View/CatalogoIndicativa/CatalogoIndicativaModificar.php`)'/> ";
                                                            $listaAviso.="</td>"; 
                                                            $listaAviso.="</tr>"; 
                                                        }
                                                    }
                                                }
                                            }                                            
                                        }
                                    }
                                }
                            }
                        }    
                    }                    
                }  
            }       
        }
?>

<?=$listaAviso?>