<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__)."/../../classes/ConectorBD.php";

foreach ($_POST as $key => $value) ${$key}=$value;

   $lista='';
   $anioFin= date('Y');

   $datosReporte= ConectorBD::ejecutarQuery("select ficha, codigo_programa, tipo, date_part('month',fecha_fin), date_part('year',fecha_fin), jornada, total_aprendiz from pe04 where sede='$FichaGestiones' and (date_part('year',fecha_fin)='".($anioFin+1)."' or date_part('year',fecha_fin)='".($anioFin+2)."' or date_part('year',fecha_fin)='".($anioFin+3)."') order by ficha, tipo, codigo_programa, date_part('month',fecha_fin), date_part('year',fecha_fin)", null);    
        $columns= count($datosReporte)+1;
        for ($i = 0; $i < count($datosReporte); $i++) {
            $lista.="<tr>";
            $lista.="<td>".($i+1)."</td>";
            $lista.="<td>{$datosReporte[$i][0]}</td>";
            $lista.="<td>{$datosReporte[$i][1]}</td>";
            $lista.="<td>";
            $lista.=(!empty(ConectorBD::ejecutarQuery("select nombre_programa from programas where id_programa ='{$datosReporte[$i][1]}';", "eagle_admin"))) ? ConectorBD::ejecutarQuery("select nombre_programa from programas where id_programa ='{$datosReporte[$i][1]}';", "eagle_admin")[0][0] : '';
            $lista.="</td>";
            $lista.="<td>{$datosReporte[$i][2]}</td>";
            $lista.="<td>{$datosReporte[$i][3]}</td>";
            $lista.="<td>{$datosReporte[$i][4]}</td>";
            $lista.="<td>{$datosReporte[$i][5]}</td>";
            $lista.="<td>";
            $lista.=(!empty(ConectorBD::ejecutarQuery("select indice_pertinencia from pertinencia where centro='$FichaGestiones' and  programa = '{$datosReporte[$i][1]}' and anio='2019'", null)[0][0])) ? ConectorBD::ejecutarQuery("select indice_pertinencia from pertinencia where centro='$FichaGestiones' and  programa = '{$datosReporte[$i][1]}' and anio='2019'", null)[0][0]."%" : '0%' ;
            $lista.="</td>";
            $lista.="</tr>";
           
        }   
   ?>
                    <th> Item Numero </th>
                    <th> Ficha </th>
                    <th> Codigo del Programa</th>
                    <th> Nombre del Programa</th>
                    <th> Tipo</th>
                    <th> Mes Finaliza</th>
                    <th> Año Finaliza</th>
                    <th> Jornada</th>
                    <th> Pertinencia</th>
                </tr>   
                <?=$lista?>