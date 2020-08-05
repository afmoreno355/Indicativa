<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

$accion='menu';
$filtro='';
$lista='';
$bucarPalabraClave='';

require_once dirname(__FILE__)."/../../classes/ConectorBD.php";

foreach ($_POST as $key => $value) ${$key}=$value;

if ($bucarPalabraClave!='') {
        $filtro=" and vigencia like '%".strtoupper($bucarPalabraClave)."%' ";
    }
    $arreglo='';
    $datos= ConectorBD::ejecutarQuery("select SUM(cupos), inicio from indicativa where cod_centro='{$centroGestion}' and validar='E' $filtro group by inicio order by inicio asc;", null);
    $numeroPaginas=20;
    for ($i = 0; $i < count($datos); $i++) {
        
        $lista.="<tr>";
        $lista.="<td>{$datos[$i][0]}</td>";
           if($datos[$i][1]===1){
               $valor='ENERO';
            }else if($datos[$i][1]===2){
               $valor='FEBRERO';
            }else if($datos[$i][1]===3){
               $valor='MARZO';
            }else if($datos[$i][1]===4){
               $valor='ABRIL';
            }else if($datos[$i][1]===5){
               $valor='MAYO';
            }else if($datos[$i][1]===6){
               $valor='JUNIO';
            }else if($datos[$i][1]===7){
               $valor='JULIO';
            }else if($datos[$i][1]===8){
               $valor='AGOSTO';
            }else if($datos[$i][1]===9){
               $valor='SEPTIEMBRE';
            }else if($datos[$i][1]===10){
               $valor='OCTUBRE';
            }else if($datos[$i][1]===11){
               $valor='NOVIEMBRE';
            }else if($datos[$i][1]===12){
               $valor='DICIEMBRE';
            }
        $lista.="<td>$valor</td>";
        $lista.="</tr>";
        
     $arreglo.="{$datos[$i][0]}<|{$datos[$i][1]}¬";     
        
} ?>
<br><br>
<table  class="tableIntT sombra tableIntTa">
    <tr>        
    <th>Numero de Cupos</th>           
    <th>Mes de Apertura</th>
        <input type="hidden" value="<?=$bucarPalabraClave?>" name="bucarPalabraClave" id="bucarPalabraClave"/>
        <input type="hidden" value="<?=$arreglo?>" name="arreglo" id="arreglo"/>
        <input type='hidden' id='centroGestion' value="<?=$centroGestion?>">
    </th>
    </tr>
    <?=$lista?>    
</table><br><br>

