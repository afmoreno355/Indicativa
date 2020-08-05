<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../classes/ConectorBD.php';
require_once dirname(__FILE__)."/../../classes/Persona.php";

date_default_timezone_set("America/Bogota");
$fecha_actual = date("d-m-Y",time());

foreach ($_POST as $key => $value) ${$key}=$value;

$lista='';

if($id==2){ ?>
<!--tercer capa-->
<!--contruccion de ventanas modales-->
   <label id='modalesT' class='modalesT'>SUBIR ARCHIVO PLANO EXCEL</label><br><br>   				
   				<table>
   					<tr>
   						<td>
   						       <label id='aviso'></label>  				
 						</td>
   					</tr>
   					<tr>
   						<td>
   							<label> Archivo Excel</label><br>
                                                        <img src='img/defecto/Excel.png' style='width: 200px; height: 200px'>
   						</td>
   					</tr>
   					<tr>
   						<td>
   							<label> Archivo Nuevo </label><br>
                                                        <input type='file' name ='Excel' value="" id="Excel" required /><br><br>
   						</td>
   					</tr>
   					<tr>
   						<td>
                                                        <input type='button' name ='accionU' id='accionU' value='PE-04' onclick="pe04('index.php?CONTENIDO=View/Sede/SedeModificar.php')"/>
   						</td>
   					</tr>
   				</table>
<?PHP } elseif($id==3){ ?>
    <div class='titulos'>
       <label>
           REPORTE NIVEL NACIONAL 
       </label> <br>
    </div>
    <div class="content">

        <div><pre>Id Indicativa               <input type="checkbox" class="content_largo" name="id_indicativa" id="id_indicativa" /></pre></div>
        <div><pre>Código del Centro           <input type="checkbox" class="content_largo" name="cod_centro" id="cod_centro" /></pre></div>
        <div><pre>Vigencia                    <input type="checkbox" class="content_largo" name="vigencia" id="vigencia" /></pre></div>
        <div><pre>Vigencia Actual             <input type="checkbox" class="content_largo" name="vigenciaA" id="vigenciaA" /></pre></div>
        <div><pre>Oferta                      <input type="checkbox" class="content_largo" name="oferta" id="oferta" /></pre></div>
        <div><pre>Codigo del Programa         <input type="checkbox" class="content_largo" name="id_programa" id="id_programa" /></pre></div>
        <div><pre>Inicio del Prograna         <input class="content_largo" type="checkbox" name="inicio" id="inicio" /></pre></div>
        <div><pre>cupos del programa          <input class="content_largo" type="checkbox" name="cupos" id="cupos" /></pre></div>
        <div><pre>Municipio                   <input class="content_largo" type="checkbox" name="municipio" id="municipio" /></pre></div>
        <div><pre>Año Termina                 <input type="checkbox" class="content_largo" name="anio_termina" id="anio_termina" ></pre></div>
        <div><pre>Cursos del Programa         <input type="checkbox" class="content_largo" name="curso" id="curso" ></pre></div>
        <div><pre>Ambiente que Requiere       <input class="content_largo" type="checkbox" name="ambiente_requiere" id="ambiente_requiere" /></pre></div>
        <div><pre>Gira Tecnica                <input type="checkbox" class="content_largo" name="gira_tecnica" id="gira_tecnica"/></pre></div>
        <div><pre>Programa Fic                <input type="checkbox" class="content_largo" name="programa_fic" id="programa_fic" /></pre></div>
        <div><pre>Modalida                    <input type="checkbox" class="content_largo" name="id_modalidad" id="id_modalidad"/></pre></div>
        <div><pre>Tipo de Oferta              <input type="checkbox" class="content_largo" name="formacion" id="formacion" /></pre></div>
        <div><pre>Fecha                       <input type="checkbox" class="content_largo" name="fecha" id="fecha" /></pre></div>
        <input type='button' name ='accionU' id='accionU' value='GENERAR' onclick="validarExportar('<?=$user?>')"/>
        <input type='reset' name='limpiarU'  value='LIMPIAR'/><br><br>
        </div><br>
        <table id="tablareporte" style="display: none;" >

        </table>

<?php  }elseif($id==4){ 
    
    $sql='';
    
    $permisos = new Persona(' identificacion ', "'$user'");
    
    $where=($where!='')?" where $where":'';
    
    if($permisos->getIdTipo()=='IR'){
       $regional = ConectorBD::ejecutarQuery("select departamento from sede where codigosede ='{$permisos->getidsede()}';", 'eagle_admin')[0][0];
       $centros = ConectorBD::ejecutarQuery("select codigosede from sede where departamento = $regional", 'eagle_admin'); 
       if($where!=''){
             $where.=' and ';  
       }else{
           $where.=' where ';
       }
       $where.=' ( '; 
       for ($k = 0; $k < count($centros); $k++) {
           if($k!=0){
               $where.=' or '; 
           }
            $where.=" cod_centro = '{$centros[$k][0]}' " ;
       }
       $where.=')';
    }
    
    $nCadena= explode(', ', $cadena);
    $lista="<tr  style='display: none'>
            <th>
                <a id='botonE'  title='Descargar Excel'>
                   sdada
                </a>
            </th>
          </tr>
          <tr>";
    for ($i = 0; $i < count($nCadena)-1; $i++) {
        $lista.="<th>{$nCadena[$i]}</th>";
        $sql.=$nCadena[$i];
        if(count($nCadena)-2>$i){
            $sql.=',';
        }
    }
    $datos= ConectorBD::ejecutarQuery("select $sql from indicativa $where" , null);
    $lista.='</tr>';    
    for ($j = 0; $j < count($datos); $j++) {
        $lista.='<tr>';
        for ($k = 0; $k < count($nCadena)-1; $k++) {
            $lista.="<td style='text-align: center; justify-content: center ; border: 1px solid black'>".str_replace('#', 'NUMERO', $datos[$j][$k])."</td>";
        }
        $lista.='</tr>';
    }
    print_r($lista) ;
    
}elseif($id==5){ ?>
<!--tercer capa-->
<!--contruccion de ventanas modales-->
   <label id='modalesT' class='modalesT'>SUBIR ARCHIVO PLANO EXCEL</label><br><br>   				
   				<table>
   					<tr>
   						<td>
   						       <label id='aviso'></label>  				
 						</td>
   					</tr>
   					<tr>
   						<td>
   							<label> Archivo Excel</label><br>
                                                        <img src='img/defecto/Excel.png' style='width: 200px; height: 200px'>
   						</td>
   					</tr>
   					<tr>
   						<td>
   							<label> Archivo Nuevo </label><br>
                                                        <input type='file' name ='Excel' value="" id="Excel" required /><br><br>
   						</td>
   					</tr>
   					<tr>
   						<td>
                                                        <input type='button' name ='accionU' id='accionU' value='PERTINENCIA' onclick="pe04('index.php?CONTENIDO=View/Sede/SedeModificar.php')"/>
   						</td>
   					</tr>
   				</table>
<?PHP }elseif (isset($id)) { 
     $primerCortar= explode('¬', $cadena); 
    for ($i = 0; $i < count($primerCortar)-1; $i++) {
        list($sede, $numero)= explode('|>', $primerCortar[$i]);
        $solicitudNumero= ConectorBD::ejecutarQuery("select count(*) from indicativa where validar='E' and cod_centro='$sede';", null)[0][0];
        $lista.="$sede|>$solicitudNumero"."¬";
    }
    print_r($lista);
}
