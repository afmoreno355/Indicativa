<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lista='';
$bucarPalabraClave='';
$filtro='';
$validarCount=" validar='E' ";

//segunda capa
require_once dirname(__FILE__)."/../../classes/ConectorBD.php";
require_once dirname(__FILE__)."/../../classes/Indicativa.php";
require_once dirname(__FILE__)."/../../classes/Sede.php";
require_once dirname(__FILE__)."/../../classes/Persona.php";

date_default_timezone_set('America/Bogota');
$date= date('Y', time());

foreach ($_POST as $key => $value) ${$key}=$value;

//permisos del usuario si puede o no estar en esta file
$permisos = new Persona(' identificacion ', "'$user'");
//fin permisos

//si palabra clave diferente a '' ingresa al filtro de la busqueda
if($bucarPalabraClave!=''){   
    $filtro.=" (codigosede like '%". strtoupper($bucarPalabraClave)."%' OR nombresede like '%". strtoupper($bucarPalabraClave)."%')";
}
//fin si palabra clave diferente a '' ingresa al filtro de la busqueda
if($permisos->getIdTipo()=='IR'){
    if($filtro!=''){
        $filtro.=' and ';
    }
    $filtro.="  departamento='".ConectorBD::ejecutarQuery("select departamento from sede where codigosede='{$permisos->getidsede()}';", 'eagle_admin')[0][0]."'";
    $validarCount.= " or validar='F' ";    
}
//llamada a la class sede
$datos= Sede::datosobjetos($filtro, $pagina, 5);
//fin llamada a la class sede

//llamada a la class sede # paginas
$numeroPaginas=ceil(Sede::count($filtro)[0][0]/5);
//fin llamada a la class sede # paginas

//for que me crea las tablas
for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
        $solicitudNumero= ConectorBD::ejecutarQuery("select count(*) from indicativa where ($validarCount) and cod_centro='{$objeto->getCod()}' and vigencia='".($date+1)."' ;", null)[0][0];
        $lista.="<tr>";
        $lista.="<td class='codigoSede'>{$objeto->getCod()}</td>";
        $lista.="<td>{$objeto->getNombre()}</td>";
        $lista.="<td id='{$objeto->getCod()}' ><p style='border-radius:50%;' class='numeroSolicitud'>$solicitudNumero</p></td>";
        
        //botones de la tabla tablas
        $lista.="<td>";
                   $lista.=" <pre>  <input type='button' id='button' name='1' title='Gestionar' value='GESTIONAR' onclick='centroGestion({$objeto->getCod()},1, $user)'></pre>
                 </td>
                </tr>";
                //fin botones de la tabla tablas
}
//fin for que me crea las tablas
?>
   <!--tabla construida para posicionarla en la capa 1 en tablasInt-->
    <tr>
    <th>Codigo de Centro</th>
    <th>Nombre de Centro</th>
    <th>Notificaciones</th>
    <th>
        <?PHP if($permisos->getIdTipo()!=='IR'){?><pre> <input type='button' id='button' name='2' title='PE-04' value='PE-04' onclick="validarDatos('','id=2','modalVentana','View/Sede/SedeFormulario.php')"/></pre> 
        <pre> <input type='button' id='button' name='2' title='Indice de Pertinencia Excel' value='PERTINENCIA' onclick="validarDatos('','id=5','modalVentana','View/Sede/SedeFormulario.php')"/></pre><?php } ?>
        <pre> <input type='button' id='button' name='2' title='Reporte Nivel Nacional o Regional' value='REPORTE' onclick="validarDatos('','id=3&user=<?=$user?>','modalVentana','View/Sede/SedeFormulario.php')"/></pre>
    <input type='hidden' id='numeroPaginas' value="<?=$numeroPaginas?>">
    <input type='hidden' id='user' value="<?=$user?>">
    <input type='hidden' id='bucarPalabraClave' value="<?=$bucarPalabraClave?>">
    </th>
    </tr>
        <?=$lista?>
   <!--fin tabla construida para posicionarla en la capa 1 en tablasInt-->