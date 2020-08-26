<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once dirname(__FILE__).'/../../classes/ConectorBD.php';
require_once dirname(__FILE__)."/../../classes/Persona.php";

date_default_timezone_set("America/Bogota");
$fecha_actual = date("d-m-Y",time());

foreach ($_POST as $key => $value) ${$key}=$value;

$lista='';
$user=$_SESSION['user'];

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
        <div><pre>Nombre del Centro           <input type="checkbox" class="content_largo" name="nombresede" id="nombresede" /></pre></div>
        <div><pre>Codigo de Regional          <input type="checkbox" class="content_largo" name="departamento" id="departamento" /></pre></div>
        <div><pre>Nombre de Regional          <input type="checkbox" class="content_largo" name="nom_departamento" id="nom_departamento" /></pre></div>
        <div><pre>Vigencia                    <input type="checkbox" class="content_largo" name="vigencia" id="vigencia" /></pre></div>
        <div><pre>Vigencia Actual             <input type="checkbox" class="content_largo" name="vigenciaA" id="vigenciaA" /></pre></div>
        <div><pre>Oferta                      <input type="checkbox" class="content_largo" name="oferta" id="oferta" /></pre></div>
        <div><pre>Codigo del Programa         <input type="checkbox" class="content_largo" name="id_programa" id="id_programa" /></pre></div>
        <div><pre>Nombre del Programa         <input type="checkbox" class="content_largo" name="nombre_programa" id="nombre_programa" /></pre></div>
        <div><pre>Nivel del Programa          <input type="checkbox" class="content_largo" name="nivel_formacion" id="nivel_formacion" /></pre></div>
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
    
    $where=($where!='')?" where $where and":' where ';
    
    if($permisos->getIdTipo()=='IR'){
       $regional = ConectorBD::ejecutarQuery("select departamento from sede where codigosede ='{$permisos->getidsede()}';", 'eagle_admin')[0][0];
       $centros = ConectorBD::ejecutarQuery("select codigosede from sede where departamento = $regional", 'eagle_admin'); 
      
       $where.=' ( '; 
       for ($k = 0; $k < count($centros); $k++) {
           if($k!=0){
               $where.=' or '; 
           }
            $where.=" cod_centro = '{$centros[$k][0]}' " ;
       }
       $where.=') and ';
    }
    
    $nCadena= explode(', ', $cadena);
    $lista="<tr  style='display: none'>
                <th>
                    <a id='botonE'  title='Descargar Excel'>
                        s
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
    $datos= ConectorBD::ejecutarQuery("select $sql from indicativa, dblink('dbname=eagle_admin port=5432 user=felipe password=123' , 'select codigosede, nombresede, departamento, nom_departamento from sede, departamento where sede.departamento=departamento.id') as t2  (codigosede  text, nombresede text, departamento text, nom_departamento text  ), dblink('dbname=eagle_admin port=5432 user=felipe password=123' , 'select id_programa,nombre_programa ,nivel_formacion,red_conocimiento from programas') as t3  (id_programa text, nombre_programa  text, nivel_formacion text, red_conocimiento text  ) $where t2.codigosede=cod_centro and t3.id_programa=indicativa.id_programa" , null);
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
<?PHP }elseif($id==6){ ?>
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
                                                        <input type='button' name ='accionU' id='accionU' value='IMPORTAR' onclick="pe04('index.php?CONTENIDO=View/IndicativaExcel/IndicativaExcel.php')"/>
   						</td>
   					</tr>
   				</table>
<?PHP }elseif($id==7){
    $lista="<div class='titulos'>
                <label>
                    REPORTE POR RED DE CONOCIMIENTO
                </label> <br>
             </div>
             <div class='content'>";
    $redeConocimiento= ConectorBD::ejecutarQuery("select * from red_conocimiento;", 'registro');
    foreach ($redeConocimiento as $key => $value) {
        if(strlen($value[1])<=60){
            $nuevoValue = str_pad($value[1], 44, ' ', STR_PAD_RIGHT); 
        }
      
        $lista.=" <div  class='title' title='$nuevoValue'><pre>".substr($nuevoValue, 0, 35)." <input type='checkbox' class='content_largo reporte' name='$value[0]' id='$value[0]' /></pre></div>";
    }
    $lista.="   <br>
                <input type='button' name ='accionU' id='accionU' value='GENERAR' onclick='nuevoReporteRed()'/>
                <input type='reset' name='limpiarU'  value='LIMPIAR'/><br><br>
            </div><br>
            
            <table id='tablareporte' style='display: none; border: 1px solid black  '>

            </table>";
    print_r($lista);
}elseif($id==8){
    $lista = "<tr colspan='22' style='display: none'>
                <th>
                    <a id='botonE'  title='Descargar Excel'>
                        s
                    </a>
                </th>
            </tr>";
    $lista .= '<tr><th> id_indicativa </th><th> cod_centro </th><th> nombresede </th><th> departamento </th><th> nom_departamento </th><th> vigencia </th><th> oferta </th><th> id_programa </th><th> nombre_programa </th><th> nivel_formacion </th><th> formacion </th><th> id_modalidad </th><th> red </th><th> inicio </th><th> cupos </th><th> municipio </th><th> anio_termina </th><th> curso </th><th> ambiente_requiere </th><th> gira_tecnica </th><td> programa_fic </th><th> fecha </th></tr>' ;
    $in = '' ;
    $listaRed = explode("¬", $listaRed);
    for ($i = 0; $i < count($listaRed)-1; $i++) {
        $in .= count($listaRed)-2 == $i ? "'$listaRed[$i]'" : "'$listaRed[$i]',";
    }
    
    if(!empty($redes= ConectorBD::ejecutarQuery("select id_indicativa, cod_centro, nombresede, departamento, nom_departamento, vigencia, oferta, indicativa.id_programa, nombre_programa, nivel_formacion, formacion, id_modalidad, red, inicio, cupos, municipio, anio_termina, curso, ambiente_requiere, gira_tecnica, programa_fic, fecha  from indicativa, dblink('dbname=eagle_admin port=5432 user=felipe password=123' , 'select id_programa , nombre_programa , nivel_formacion , red_conocimiento , linea_tecnologica  from programas') as t2  (id_programa text, nombre_programa text, nivel_formacion text, red_conocimiento text, linea_tecnologica text ), dblink('dbname=eagle_admin port=5432 user=felipe password=123' , 'select codigosede, nombresede, departamento, nom_departamento from sede, departamento where sede.departamento=departamento.id') as t3  (codigosede  text, nombresede text, departamento text, nom_departamento text  ), dblink('dbname=registro port=5432 user=felipe password=123' , 'select id, red from red_conocimiento') as t4  (id  text, red text ) where t2.id_programa=indicativa.id_programa and t3.codigosede=cod_centro and t2.red_conocimiento =t4.id and t2.red_conocimiento in ($in) ;", null)))
    {   
        for ($j = 0; $j < count($redes); $j++) 
        {
            $lista .= "<tr>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][0]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][1]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][2]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][3]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][4]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][5]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][6]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][7]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][8]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][9]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][10]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][11]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][12]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][13]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][14]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][15]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][16]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][15]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][18]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][19]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][20]} </td>" ;
            $lista .= "<td style='text-align: center; justify-content: center ; border: 1px solid black'> {$redes[$j][21]} </td>" ;
            $lista .= "</tr>" ;
        } 
    }
    else 
    {  }  
    
    print_r($lista);
    
}elseif (isset($id)) { 
     $primerCortar= explode('¬', $cadena); 
    for ($i = 0; $i < count($primerCortar)-1; $i++) {
        list($sede, $numero)= explode('|>', $primerCortar[$i]);
        $solicitudNumero= ConectorBD::ejecutarQuery("select count(*) from indicativa where validar='E' and cod_centro='$sede';", null)[0][0];
        $lista.="$sede|>$solicitudNumero"."¬";
    }
    print_r($lista);
}
