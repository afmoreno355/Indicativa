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
    $p_trimestre=0;
    $s_trimestre=0;
    $t_trimestre=0;
    $c_trimestre=0;
    $datos= ConectorBD::ejecutarQuery("select SUM(cupos), inicio from indicativa where cod_centro='{$centroGestion}' and validar='E' $filtro group by inicio order by inicio asc;", null);
    $numeroPaginas=20;
    
if($id==1){
        
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
    }
}elseif ($id==3) {
    for ($index = 0; $index < count($datos); $index++) {
        if($datos[$index][1]>=1 && $datos[$index][1]<=3){
            $p_trimestre=$p_trimestre+$datos[$index][0];
        }elseif($datos[$index][1]>=4 && $datos[$index][1]<=6){
            $s_trimestre=$s_trimestre+$datos[$index][0];
        }elseif($datos[$index][1]>=6 && $datos[$index][1]<=9){
            $t_trimestre=$t_trimestre+$datos[$index][0];
        }elseif($datos[$index][1]>=10 && $datos[$index][1]<=12){
            $c_trimestre=$c_trimestre+$datos[$index][0];
        }
    }
            $lista.="<tr><td>$p_trimestre</td><td>Primer Trimestre</td></tr>";
            $lista.="<tr><td>$s_trimestre</td><td>Segundo Trimestre</td></tr>";
            $lista.="<tr><td>$t_trimestre</td><td>Tercer Trimestre</td></tr>";
            $lista.="<tr><td>$c_trimestre</td><td>cuarto Trimestre</td></tr>";           
            
    $arreglo.="$p_trimestre<|Primer Trimestre¬";  
    $arreglo.="$s_trimestre<|Segundo Trimestre¬";  
    $arreglo.="$t_trimestre<|Tercer Trimestre¬";  
    $arreglo.="$c_trimestre<|Cuarto Trimestre¬";  
}elseif ($id==6) {
    for ($index = 0; $index < count($datos); $index++) {
        if($datos[$index][1]>=1 && $datos[$index][1]<=6){
            $p_trimestre=$p_trimestre+$datos[$index][0];
        }elseif($datos[$index][1]>=7 && $datos[$index][1]<=12){
            $s_trimestre=$s_trimestre+$datos[$index][0];
        }
    }
            $lista.="<tr><td>$p_trimestre</td><td>Primer Semestre</td></tr>";
            $lista.="<tr><td>$s_trimestre</td><td>Segundo Semestre</td></tr>";
    $arreglo.="$p_trimestre<|Primer Semestre¬";  
    $arreglo.="$s_trimestre<|Segundo Semestre¬"; 
}
?>
<br><br>
<table  class="tableIntT sombra tableIntTa">
    <tr>        
    <th>Numero de Cupos</th>           
    <th>Mes de Apertura</th>
        <input type="hidden" value="<?=$bucarPalabraClave?>" name="bucarPalabraClave" id="bucarPalabraClave"/>
        <input type="hidden" value="<?=$arreglo?>" name="arreglo" id="arreglo"/>
        <input type="hidden" value="<?=$id?>" name="id" id="id"/>
        <input type='hidden' id='centroGestion' value="<?=$centroGestion?>">
    </th>
    </tr>
    <?=$lista?>    
</table><br><br>

