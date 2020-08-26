<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$lista='';
$bucarPalabraClave='';

date_default_timezone_set('America/Bogota');
$date= date('Y', time());

$filtro="";
$auxPersona = null;
$idsProgramas;

require_once dirname(__FILE__)."/../../classes/ConectorBD.php";
require_once dirname(__FILE__)."/../../classes/Complementaria.php";
require_once dirname(__FILE__)."/../../classes/Persona.php";

foreach ($_POST as $key => $value) ${$key}=$value;

$persona= ConectorBD::ejecutarQuery("select idtipo, idsede from persona where identificacion='$user'", 'eagle_admin');
// selecccion id del programa 
if(!empty($programa_especial)){
    $idsProgramas= ConectorBD::ejecutarQuery("select id_programa from public.programas where programa_especial_id =$programa_especial", 'eagle_admin');
    //echo $programa_especial;
    //echo 'Programas' ;
    //print_r($idsProgramas);
 }

if($persona[0][0]!='SA' && $persona[0][0]!='AI' && $persona[0][0]!='IR'){
    $filtro.=" cod_centro='{$persona[0][1]}' and vigencia='".($date+1)."'";
    $centroGestion=$persona[0][1];
} elseif($persona[0][0]=='IR') {
     $filtro.=" cod_centro='$centroGestion' and validar<>''  and vigencia='".($date+1)."'";
}elseif($persona[0][0]=='AI' || $persona[0][0]!='IR') {
     $filtro.=" cod_centro='$centroGestion' and validar='E' and vigencia='".($date+1)."'";
}

if($bucarPalabraClave!=''){
    if($filtro!=''){
        $filtro.='  and  ';
    }
    $filtro.=" (id_programa like '%". strtoupper($bucarPalabraClave)."%')";
}

if(!empty($programa_especial)){
    $filtro.=" and id_programa in ";
    if(empty($idsProgramas))
        $filtro.="('0')";
    else 
        for ($i = 0; $i < count($idsProgramas); $i++) {
            if( $i == 0 ) $filtro.="('".$idsProgramas[$i][0]."'";
            if( $i == count($idsProgramas) - 1 ) $filtro.=",'".$idsProgramas[$i][0]."')";
            else $filtro.=",'".$idsProgramas[$i][0]."'";
        }
   //echo $filtro;
   //echo count($idsProgramas);
}

$datos= Complementaria::obtenerLista($filtro, $pagina, 5);

$numeroPaginas=ceil(Complementaria::contar($filtro)[0][0]/5);

for ($i = 0; $i < count($datos); $i++) {
    $objeto=$datos[$i];
        $lista.="<tr>";
        $lista.="<td>{$objeto->GetCodigoCentro()}</td>";
        $lista.="<td>{$objeto->GetIdPrograma()}</td>";
        $lista.="<td>{$objeto->GetNombrePrograma()}</td>";
        $lista.="<td class='noDisplay'>{$objeto->GetOferta()}</td>";
        $lista.="<td class='noDisplay'>{$objeto->GetGrupos()}</td>";
        $lista.="<td class='noDisplay'>".Complementaria::getNombreMesInicio($objeto->GetMesInicio())."</td>";
        $lista.="<td class='noDisplay'>".Complementaria::getNombreMesInicio($objeto->GetMesFin())."</td>";
        $lista.="<td class='noDisplay'>".strtoupper($objeto->GetProgramaFic())."</td>";
        if($objeto->GetValidar()=='') {
            $lista.="<td>CENTRO</td>"; 
        } elseif ($objeto->GetValidar()=='F'){
            $lista.="<td style='background:rgba(51, 116, 255, 0.3)'>REGIONAL</td>";
        }  elseif ($objeto->GetValidar()=='E'){
            $lista.="<td style='background:rgba(51, 255, 119 , 0.3)'>NACIONAL</td>";
        } 
        $lista.="<td>";
                   $lista.=($persona[0][0]!='AI' && $objeto->GetValidar()!='E' && $objeto->GetValidar()!='F') ? " <pre>  <input type='button' id='button' name='1' title='Modificar' value='MODIFICAR' onclick='validarDatosInf({$objeto->GetId()},1, $user)'></pre> " : '';
                   $lista.=" <pre> <input type='button' id='button' name='3' onclick='validarDatosInf({$objeto->GetId()},2,$user)' title='Mas Informacion Resolución' value='INFO'></pre> 
                 </td><td>";
                   $lista.=($persona[0][0]!='AI' && $objeto->GetValidar()!='E' && $objeto->GetValidar()!='F') ? "  <pre><input type='button' id='button' name='3' onclick='Eliminar({$objeto->GetId()})' title='Eliminar' value='ELIMINAR'></pre>" : '';
                   $lista.=(($persona[0][0]=='IR' && $objeto->GetValidar()=='F') || ($persona[0][0]!='AI' && $objeto->GetValidar()!='E' && $objeto->GetValidar()!='F')) ? "<pre> <input type='button' id='button' name='1' onclick='validar({$objeto->GetId()},1)' title='Enviar al Administrador' value='ENVIAR'></pre>" : '';
                   $lista.="</td>"
         ."</tr>";
}
?>
 <tr>
        <th>Centro</th>
        <th>Identificador del Programa</th>
        <th>Programa</th>
        <th class="noDisplay">Tipo de Oferta</th>
        <th class="noDisplay">N° Cupos</th>
        <th class="noDisplay">Mes de Inicio</th>
        <th class="noDisplay">Mes de Fin</th>
        <th class="noDisplay">Programa Fic</th>
        <th>Estado</th>
        <th>
            <pre><input type='button' id='button' name='2' title='Analisis Pe-04' value='PE-04' onclick="validarDatos('','user=<?=$user?>&id=8&centroGestion=<?=$centroGestion?>','modalVentana','View/CatalogoIndicativa/CatalogoIndicativaFormulario.php')"/></pre>
            <?php if($persona!='AI' && $persona[0][0]!='SA' && $persona[0][0]!='IR' ){ if(count(ConectorBD::ejecutarQuery("select * from meta where anio='".($date+1)."'  and sede='$centroGestion' ", null))>=6) { ?><pre><input type='button' id='button' name='2' title='Adicionar Nuevo Registro de Catalogo al Sistema' value='ADICIONAR' onclick="validarDatos('','user=<?=$user?>&id=1&accion=ADICIONAR&info=','modalVentana','View/CatalogoIndicativa/CatalogoIndicativaFormulario.php')"/></pre> 
            <pre><input type='button' id='button' name='2' title='Importar Excel Catalogo al Sistema' value='IMPORTAR' onclick="validarDatos('','accion=IMPORTAR&id=6','modalVentana','View/Sede/SedeFormulario.php')"/></pre><?php } }?>
            </th>
            <th><pre> <input type='button' id='button' name='2' title='Exportar Archivo Plano de Excel' value='EXPORTAR' onclick="Exportar('','user=<?=$user?>&id=7&centroGestion=<?=$centroGestion?>','tablareporte','View/CatalogoIndicativa/CatalogoIndicativaFormulario.php')"/></pre>
            <pre> <input type='button' id='button' name='2' title='Diagrama Catalogo Vigencias' value='GRAFICAS' onclick="reportes('<?=$user?>','<?=$centroGestion?>')"/></pre>
          
            <input type='hidden' id='numeroPaginas' value="<?=$numeroPaginas?>">
            <input type='hidden' id='user' value="<?=$user?>">
            <input type='hidden' id='bucarPalabraClave' value="<?=$bucarPalabraClave?>">
            <input type='hidden' id='centroGestion' value="<?=$centroGestion?>">
        </th>
        </tr>
        <?=$lista?>  