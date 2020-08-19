<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/../../classes/ConectorBD.php';
require_once dirname(__FILE__).'/../../classes/Indicativa.php';
require_once dirname(__FILE__).'/../../classes/Modalidad.php';
require_once dirname(__FILE__).'/../../classes/Persona.php';

$info='';
$sig='';
$nog='';
$sip='';
$nop='';
$tabla='';
$formacionT1='';
$formacionT2='';
$formacionT3='';
$jornada1=0;
$jornada2=0;
$jornada3=0;
$jornada4=0;
$inicio='';

date_default_timezone_set("America/Bogota");
$fecha_actual = date("d-m-Y",time());
$options="<option value=''>VIGENCIA</option>";  
$options1="<option value=''>AÑO TERMINO</option>";  

foreach ($_POST as $key => $value) ${$key}=$value;

if($info==''){
    $datos=new Indicativa(null, null);
    $inicio="<option value=''> MES INICIO </option>";
}elseif($info!=''){
    $datos=new Indicativa(' id_indicativa ', "'$info'");
    if($datos->getGira_tecnica()=='s'){
      $sig='checked';
    }elseif($datos->getGira_tecnica()=='n'){
      $nog='checked';
    }  
    if($datos->getPrograma_fic()=='s'){
      $sip='checked';
    }elseif($datos->getPrograma_fic()=='n'){
      $nop='checked';
    }  
    $valorJor = ConectorBD::ejecutarQuery("select * from jornada where id_indicativa={$datos->getId_indicativa()}", null);
    $jornada1=$valorJor[0][1];
    $jornada2=$valorJor[0][2];
    $jornada3=$valorJor[0][3];
    $jornada4=$valorJor[0][4];
    
    $inicio=Indicativa::listames($datos->getInicio(), $datos->getId_modalidad());
    
}
$anio= date('Y');
for ($j = 0; $j < 1; $j++) {
 $options.="<option value='".($anio+1)."' selected>".($anio+1)."</option>"; 
 $anio=$anio+1;
}
$anio= date('Y');
for ($j = 0; $j < 3; $j++) {
    $selection=(($anio+1)==$datos->getAnio_termina()) ? 'selected' : '' ;
 $options1.="<option value='".($anio+1)."' $selection>".($anio+1)."</option>"; 
 $anio=$anio+1;
}

if($id==1){ ?>

 <div class="titulos">
                <label>
                    FORMULARIO SUBIR CATALOGO INDICATIVA
                </label> <br>
                <label id="aviso">
                </label> 
            </div>           
            <div class="content">
                <div><pre>Fecha de Registro  <?=$fecha_actual?></pre></div>                 
                <div class="titulos" id="infoCentrosF" style='margin-left: -5px; margin-top:-30px;'>
                <?PHP $infoCentroConector=ConectorBD::ejecutarQuery("select codigosede, nombresede, nom_departamento, id from sede, departamento where sede.departamento=departamento.id and codigosede=(select idsede from persona where identificacion='$user');", 'eagle_admin');
                 print_r("<label style='font-size:0.9em;'><br>
                        Codigo de Centro:  {$infoCentroConector[0][0]}<br>
                        Nombre de Centro:  {$infoCentroConector[0][1]}<br>
                        Id Regional:       {$infoCentroConector[0][3]}<br>
                        Departamento:      {$infoCentroConector[0][2]}<br><br>
                   </label>");
                ?>
                </div>
                <div><pre>Vigencia*            <select class="content_largo" name='vigencia' value='<?=$datos->getVigencia()?>' id="vigencia" required>
                                                     <?=$options?>
                                               </select></pre></div>
                <div><pre>Codigo Programa*     <input class="content_largo" list='codigosP' name='id_programa' oninput="infoCentro(this.value, 'infoCentrosP', 'View/CatalogoIndicativa/CatalogoIndicativaFormulario.php', '2&user=<?=$user?>')" value='<?=$datos->getId_programa()?>' id="id_programa" required>
                                               <datalist id='codigosP'>
                                                    <?= Indicativa::listaprogramas($infoCentroConector[0][0])?>
                                               </datalist>
                </pre></div>   
                <div class="titulos" id="infoCentrosP" style='margin-left: -5px; margin-top:-30px;'></div>
                <div><pre>Modalidad*           <select class="content_largo" name="id_modalidad" id="id_modalidad" required onclick="idexistentesReCa('','id=9&virtual='+this.value,'inicio','View/CatalogoIndicativa/CatalogoIndicativaFormulario')"><?= Modalidad::lista($datos->getId_modalidad())?></select></pre></div>
                <div><pre>Mes de Inicio*       <select class="content_largo" name="inicio" id="inicio" required>
                                                           <?=$inicio?>
                                               </select></pre></div> 
                <div><pre>Tipo Oferta*         <select class="content_largo" name="formacion" id="formacion" value="<?php if($datos->getFormacion()=='ABIERTA DE FORMACION'){$formacionT1='selected';}elseif($datos->getFormacion()=='ESPECIAL EMPRESARIAL'){$formacionT2='selected';}elseif($datos->getFormacion()=='ESPECIAL SOCIAL'){$formacionT3='selected';}?>" required>
                                                           <option value=''>TIPO OFERTA</option>
                                                           <option value="ABIERTA DE FORMACION" <?=$formacionT1?>>ABIERTA DE FORMACION</option>
                                                           <option value="ESPECIAL EMPRESARIAL" <?=$formacionT2?>>ESPECIAL EMPRESARIAL</option>
                                                           <option value="ESPECIAL SOCIAL" <?=$formacionT3?>>ESPECIAL SOCIAL</option>
                                               </select></pre></div>
                <div><pre>Cupos*               <input class="content_largo" type="text" class="cupos" name='cupos' id="cupos" value='<?=$datos->getCupos()?>' required /></pre></div>
                <div><pre>Departamento*        <select class="content_largo" name="departamento" id="departamento" required onchange="infoCentro(this.value, 'municipio', 'View/CatalogoIndicativa/CatalogoIndicativaFormulario.php', 3)"><?= Indicativa::listadepartamentos($datos->getMunicipio())?></select></pre></div>
                <div><pre>Municipios*          <select class="content_largo" name="municipio" id="municipio" required><option value="">MUNICIPIOS</option></select></pre></div>
                <div><pre>Año Termino*         <select class="content_largo" name='anio_termina' value='<?=$datos->getAnio_termina()?>' id="anio_termina" required>
                                                     <?=$options1?>
                                               </select></pre></div>
                <div><pre>Cursos*              <input class="content_largo" type="text" class="curso" name='curso' id="curso" value='<?=$datos->getCurso()?>' required/></pre></div>
                <div><pre>Ambientes Requiere*  <input class="content_largo" type="text" class="ambiente_requiere" name='ambiente_requiere' id="ambiente_requiere" value='<?=$datos->getAmbiente_requiere()?>' required /></pre></div>
                <div><pre>Gira Tecnica*    si<input value="s" type="radio" name="gira_tecnica" id="gira_tecnica1" <?= $sig ?>/>  no<input value="n" type="radio" name="gira_tecnica" id="gira_tecnica2" <?= $nog ?>/></pre></div>
                <div><pre>Programa Fic*    si<input value="s" type="radio" name="programa_fic" id="programa_fic1" <?= $sip ?>/>  no<input value="n" type="radio" name="programa_fic" id="programa_fic2" <?= $nop ?>/></pre></div>
                <div class="table">
                    <table>
                        <tr>
                            <th colspan='4'>
                                <div class="titulos"><label> Ingresar Numero de Cursos por Jornada</label></div>
                            </th>
                        </tr> 
                        <tr>
                            <td>
                            MADRUGADA<br><br>
                            <input class="content_largo" type="text" class="cursos" name='cursos[1]' id="cursos1" value='<?=$jornada1?>' onkeyup="validarCursos(this.value)" required />
                           
                            </td>
                            <td>
                            DIURNA<br><br>
                            <input class="content_largo" type="text" class="cursos" name='cursos[2]' id="cursos2" value='<?=$jornada2?>' onkeyup="validarCursos(this.value)" required/>
                           
                            </td>
                            <td>
                            NOCTURNA<br><br>
                            <input class="content_largo" type="text" class="cursos" name='cursos[3]' id="cursos3" value='<?=$jornada3?>' onkeyup="validarCursos(this.value)" required/>
                            </td>
                            <td>
                            MIXTA<br><br>
                            <input class="content_largo" type="text" class="cursos" name='cursos[4]' id="cursos4" value='<?=$jornada4?>' onkeyup="validarCursos(this.value)" required/>
                            </td>
                        </tr>    
                       <?=$tabla?>
                    </table>
                </div><br>
                <input type='hidden' name ='id_indicativa' id='cod_centro' value='<?=$datos->getId_indicativa()?>' />
                <input type='hidden' name ='cod_centro' id='cod_centro' value='<?=$infoCentroConector[0][0]?>' />
                <input type='hidden' name ='pro' id='pro' value='<?=$datos->getMunicipio()?>' />
                <input type='button' name ='accionU' id='accionU' value='<?=$accion?>' onclick="dondeIrModal('index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativaModificar.php')"/>
                <input type='reset' name='limpiarU'  value='LIMPIAR'/><br><br>
               </div> 
<?php }elseif ($id==2) {
     date_default_timezone_set("America/Bogota");
     $anio = date("Y",time());
     $lista='';
     $permisos = new Persona(' identificacion ', "'$user'");

     $infoCentroConector=ConectorBD::ejecutarQuery("select id_programa,nombre_programa,nivel_formacion,duracion from  programas where id_programa='$cod_centro';", 'eagle_admin');
     $registroCalificado=ConectorBD::ejecutarQuery("select id_sede , lugar_desarrollo.id_resolucion, resoluciones.id_resolucion,fecha_resolucion,denominacion_programa ,modalidad,nivel_programa ,modalidad   from lugar_desarrollo, resoluciones where resoluciones.id_resolucion=lugar_desarrollo.id_resolucion and lugar_desarrollo.id_sede='{$permisos->getidsede()}' and lugar_desarrollo.resuelve='OTORGAMIENTO' and fecha_resolucion::date+'7 year'::interval >= 'now()' and denominacion_programa ='$cod_centro';", 'registro');
     $pertinencia= ConectorBD::ejecutarQuery("select indice_pertinencia from pertinencia where centro='{$permisos->getidsede()}' and  programa = '$cod_centro' and anio='$anio'", null); 
     
     if(!empty($infoCentroConector)){
        if((empty($registroCalificado) && ($infoCentroConector[0][2]=='TECNOLOGIA' || $infoCentroConector[0][2]=='ESPECIALIZACION TECNOLOGICA' ))){
            print_r("<label style='font-size:0.9em;'><br>
                PROGRAMA SIN REGISTRO CALIFICADO O NO REGISTRA EN EL SISTEMA!!
           </label>");
        }else{
           $lista="<label style='font-size:0.9em;'><br>
                Codigo de Programa:  {$infoCentroConector[0][0]}<br>
                Nombre de Programa:  {$infoCentroConector[0][1]}<br>
                Nivel de Formacion:  {$infoCentroConector[0][2]}<br>
                Duracion:            {$infoCentroConector[0][3]} Meses<br>";
                    
           $lista.=(!empty($pertinencia))?"Pertinencia:         {$pertinencia[0][0]}%<br><br>":'Pertinencia:         0%<br><br>';
           $lista.="</label>";
           print_r($lista);
        } 
     }else{
         print_r("<label style='font-size:0.9em;'><br>
                BUSCANDO PROGRAMA.....
           </label>");
     }
     
 }elseif ($id==3) {
     $lista="<option value=''>MUNICIPIOS</option>";     
     $infoCentroConector=ConectorBD::ejecutarQuery("select * from municipio where id_departamento=$cod_centro;", 'eagle_admin');
     for ($i = 0; $i < count($infoCentroConector); $i++) {
         $selected=(isset($municipio) && $municipio==$infoCentroConector[$i][0]) ? 'selected' : '';
          $lista.="<option value='{$infoCentroConector[$i][0]}' $selected>{$infoCentroConector[$i][1]}</option>";
     }
     print_r($lista);
 } elseif ($id==4) {  
?> 
            <label id='modalesT' class='modalesT'>ELIMINAR FORMULARIO</label>   				
            <table>
                <tr>
                    <td>
                        Accion:<br>
                        Esta Seguro de Elimira al Registro con Id N° <?=$id_indicativa?><br><br>
                    </td>
                </tr>                              
                <tr>
                    <td>
                        <input type="hidden"  name="id_indicativa" value="<?=$id_indicativa?>"/> 
                        <input type="button"  name="accionU" id="accionU" value="BORRAR" onclick="dondeIrModales('index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativaModificar.php')"/> 
                    </td>
                </tr>                
            </table>    
<?php }elseif ($id==5) {      
    $datos=new Indicativa(' id_indicativa ', $info);
    $datosCentro= ConectorBD::ejecutarQuery("select codigosede, nombresede, nom_departamento, id  from sede, departamento where sede.departamento=departamento.id and codigosede='{$datos->getCod_centro()}'", 'eagle_admin');
    $datosPrograma=ConectorBD::ejecutarQuery("select id_programa,nombre_programa,nivel_formacion,duracion from  programas where id_programa='{$datos->getId_programa()}';", 'eagle_admin');
?>
            
<label id='modalesT' class='modalesT'>INFORMACION DE INDICATIVA</label>   				
            <table>
                <tr>
                    <td>
                        Codigo Centro : 
                        <?=$datos->getCod_centro()?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre Centro : 
                        <?= strtoupper($datosCentro[0][1])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Codigo Regional : 
                        <?= strtoupper($datosCentro[0][2])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre Regional : 
                        <?= strtoupper($datosCentro[0][3])?><br><br> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Vigencia : 
                        <?= strtoupper($datos->getVigencia())?><br><br> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Codigo de Programa : 
                        <?= strtoupper($datos->getId_programa())?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre de Programa : 
                        <?= strtoupper($datosPrograma[0][1])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nivel de Programa : 
                        <?= strtoupper($datosPrograma[0][2])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Duración de Programa : 
                        <?= strtoupper($datosPrograma[0][3])?><br><br> 
                    </td>
                </tr> 
                <tr>
                    <td>
                        Modalidad : 
                        <?= strtoupper($datos->Id_modalidad())?>
                    </td>
                </tr> 
                <tr>
                    <td>
                        Nivel Formación : 
                        <?= strtoupper($datos->getFormacion())?>
                    </td>
                </tr> 
                <tr>
                    <td>
                        Mes Inicio : 
                        <?PHP
                           if($datos->getInicio()==1){
                               print_r('ENERO');
                           } elseif($datos->getInicio()==2){
                               print_r('FEBRERO');
                           }elseif($datos->getInicio()==3){
                               print_r('MARZO'); 
                           }elseif($datos->getInicio()==4){
                               print_r('ABRIL'); 
                           }elseif($datos->getInicio()==5){
                               print_r('MAYO'); 
                           }elseif($datos->getInicio()==6){
                               print_r('JUNIO'); 
                           }elseif($datos->getInicio()==7){
                               print_r('JULIO'); 
                           }elseif($datos->getInicio()==8){
                               print_r('AGOSTO'); 
                           }elseif($datos->getInicio()==9){
                               print_r('SEPTIEMBRE'); 
                           }elseif($datos->getInicio()==10){
                               print_r('OCTUBRE'); 
                           }elseif($datos->getInicio()==11){
                               print_r('NOVIEMBRE'); 
                           }elseif($datos->getInicio()==12){
                               print_r('DICIEMBRE'); 
                           }
                        ?>
                    </td>
                </tr> 
                 <tr>
                    <td>
                        Cupos : 
                        <?= strtoupper($datos->getCupos())?>
                    </td>
                </tr>
                 <tr>
                    <td>
                        Año Termino: 
                        <?= strtoupper($datos->getAnio_termina())?>
                    </td>
                </tr>
                 <tr>
                    <td>
                        Cursos: 
                        <?= strtoupper($datos->getCurso())?>
                    </td>
                </tr>
                 <tr>
                    <td>
                        Ambientes Requiere: 
                        <?= strtoupper($datos->getAmbiente_requiere())?>
                    </td>
                </tr>
            </table> <br><br>  
            
<?php  }elseif ($id==6) {  
?> 
            <label id='modalesT' class='modalesT'>ENVIAR FORMULARIO</label>   				
            <table>
                <tr>
                    <td>
                        Accion:<br>
                        Esta Seguro de Enviar al Registro con Id N° <?=$id_indicativa?><br><br>
                    </td>
                </tr>                              
                <tr>
                    <td>
                        <input type="hidden"  name="id_indicativa" value="<?=$id_indicativa?>"/> 
                        <input type="button"  name="accionU" id="accionU" value="ENVIAR" onclick="dondeIrModales('index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativaModificar.php')"/> 
                    </td>
                </tr>                
            </table>    
<?php }elseif ($id==7) {
     $resultadosReporte=ConectorBD::ejecutarQuery("select * from indicativa where cod_centro='$centroGestion' and vigencia='".(date('Y')+1)."' and validar='E'", null);
    
    $tabla="<tr  style='display: none' >
            <th colspan='26'>
                <a id='botonE'  title='Descargar Excel'>
                   sdada
                </a>
            </th>
          </tr>";
    $tabla.="<tr style='background : yellow;'>
            <th>CODIGO DE CENTRO</th>
            <th>NOMBRE DEL CENTRO DE FORMACION</th>
            <th>CODIGO DE REGIONAL</th>
            <th>NOMBRE DE LA REGIONAL</th>
            <th>VIGENCIA</th>
            <th>OFERTA</th>
            <th>CODIGO PROGRAMA</th>
            <th>NOMBRE PROGRAMA DE FORMACION</th>
            <th>RED DE CONOCIMIENTO</th>
            <th>LINEA O RED TECNOLOGICA</th>
            <th>NIVEL</th>
            <th>MODALIDAD</th>
            <th>TIPO DE FORMACION</th>
            <th>MES INICIO</th>
            <th>CUPOS</th>
            <th>DEPARTAMENTO</th>
            <th>MUNICIPIO</th>
            <th>AÑO  TERMINA</th>
            <th>CURSOS</th>
            <th>MADRUGADA</th>
            <th>DIURNA</th>
            <th>NOCTURNA</th>
            <th>MIXTO</th>
            <th>AMBIENTES QUE REQUIERA</th>
            <th>REQUIERE GIRA TECNICA</th>
            <th>ES PROGRAMA FIC</th>
            </tr>";
    for ($i = 0; $i < count($resultadosReporte); $i++) {
        
        $datosCentroReporte= ConectorBD::ejecutarQuery("select codigosede, nombresede, nom_departamento, id  from sede, departamento where sede.departamento=departamento.id and codigosede='{$resultadosReporte[$i][1]}'", 'eagle_admin');
        $datosProgramaReporte=ConectorBD::ejecutarQuery("select id_programa,nombre_programa,nivel_formacion,duracion,red_conocimiento from  programas where id_programa='{$resultadosReporte[$i][4]}'", 'eagle_admin');
        $datosRedReporte=ConectorBD::ejecutarQuery("select red from red_conocimiento where id={$datosProgramaReporte[0][4]}", 'registro');
        $datosJornadaReporte=ConectorBD::ejecutarQuery("select * from jornada where id_indicativa ='{$resultadosReporte[$i][0]}'", null);
        $datosDepartamentoReporte=ConectorBD::ejecutarQuery("select nom_departamento, municipio from municipio, departamento where id_departamento=departamento.id and municipio.id={$resultadosReporte[$i][7]}", 'eagle_admin');

        $tabla.="<tr style='border : 1px solid black;'>";
        $tabla.="<td>{$resultadosReporte[$i][1]}</td>";
        $tabla.="<td>{$datosCentroReporte[0][1]}</td>";
        $tabla.="<td>{$datosCentroReporte[0][3]}</td>";
        $tabla.="<td>{$datosCentroReporte[0][2]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][2]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][3]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][4]}</td>";
        $tabla.="<td>{$datosProgramaReporte[0][1]}</td>";
        $tabla.="<td>{$datosRedReporte[0][0]}</td>";
        $tabla.="<td></td>";
        $tabla.="<td>{$datosProgramaReporte[0][2]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][13]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][14]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][5]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][6]}</td>";
        $tabla.="<td>{$datosDepartamentoReporte[0][0]}</td>";
        $tabla.="<td>{$datosDepartamentoReporte[0][1]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][8]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][9]}</td>";
        $tabla.="<td>{$datosJornadaReporte[0][1]}</td>";
        $tabla.="<td>{$datosJornadaReporte[0][2]}</td>";
        $tabla.="<td>{$datosJornadaReporte[0][3]}</td>";
        $tabla.="<td>{$datosJornadaReporte[0][4]}</td>";
        $tabla.="<td>{$resultadosReporte[$i][10]}</td>";
        $tabla.="<td>".strtoupper($resultadosReporte[$i][11])."</td>";
        $tabla.="<td>".strtoupper($resultadosReporte[$i][12])."</td>";       
        $tabla.="</tr>";
    }
   print_r($tabla);
}  elseif ($id==8){ 
   $lista='';
   $listaD='';
   $contador=0;
   $aprendiz=0;
   $trimestres='';
   $anioFin= date('Y');

   $persona= ConectorBD::ejecutarQuery("select  idtipo from persona where identificacion='$user'", 'eagle_admin')[0][0];
   $datosReporte= ConectorBD::ejecutarQuery("select count(sede), sede, tipo, date_part('month',fecha_fin), date_part('year',fecha_fin), jornada, SUM(total_aprendiz) from pe04 where sede='$centroGestion' and (date_part('year',fecha_fin)='".($anioFin+1)."' or date_part('year',fecha_fin)='".($anioFin+2)."' or date_part('year',fecha_fin)='".($anioFin+3)."') group by sede, tipo, date_part('month',fecha_fin), date_part('year',fecha_fin), jornada  order by date_part('year',fecha_fin), date_part('month',fecha_fin), tipo;", null);    
   if(!empty($datosReporte)){
        $columns= count($datosReporte)+1;
        for ($i = 0; $i < count($datosReporte); $i++) {
            if($datosReporte[$i][3]>=1 && $datosReporte[$i][3]<=3){
                $trimestres="PRIMER"; $style="background: rgba(130, 224, 170)";
            }elseif($datosReporte[$i][3]>=4 && $datosReporte[$i][3]<=6){
                $trimestres="SEGUNDO"; $style="background: rgba(247, 220, 111)";
            }elseif($datosReporte[$i][3]>=7 && $datosReporte[$i][3]<=9){
                $trimestres="TERCERO"; $style="background: rgba(245, 176, 65)";
            }elseif($datosReporte[$i][3]>=10 && $datosReporte[$i][3]<=12){
                $trimestres="CUARTO"; $style="background: rgba(186, 74, 0 )";
            }

            if($i==0){
                $anio=$datosReporte[$i][4];
                $color="background: rgba(214, 234, 248)";
            }elseif($anio!=$datosReporte[$i][4]){
                $color="background: rgba(252, 243, 207)";
            }

            $lista.="<tr>";
            $lista.="<td style='border: 1px black solid; $color'>{$datosReporte[$i][4]}</td>";
            $lista.="<td style='$style'>{$trimestres}</td>";
            $lista.="<td style='border: 1px black solid'>{$datosReporte[$i][3]}</td>";
            $lista.="<td style='border: 1px black solid'>{$datosReporte[$i][2]}</td>";
            $lista.="<td style='border: 1px black solid'>{$datosReporte[$i][5]}</td>";
            $lista.="<td style='border: 1px black solid'>{$datosReporte[$i][0]}</td>";
            $lista.="<td style='border: 1px black solid'>{$datosReporte[$i][6]}</td>";
            $lista.="</tr>";
            $contador=$contador+$datosReporte[$i][0];
            $aprendiz=$aprendiz+$datosReporte[$i][6];
        }  
        
   $tipos= ConectorBD::ejecutarQuery("select tipo, modalidad from pe04 group by tipo, modalidad order by modalidad asc;", null);
   $cursos_esp= ConectorBD::ejecutarQuery("select count(sede), tipo, SUM(total_aprendiz), programa_especial, modalidad from pe04 where sede='$centroGestion' and (date_part('year',fecha_fin)='".($anioFin+1)."' or date_part('year',fecha_fin)='".($anioFin+2)."' or date_part('year',fecha_fin)='".($anioFin+3)."') group by tipo, programa_especial, modalidad order by modalidad asc;", null);    
   
   $integracion=0;
   $integracionNo=0;
   $titulo='';
   
   for ($j = 0; $j < count($tipos); $j++) {
        $integracion=0;
        $integracionNo=0;
        $titulo='';
       for ($k = 0; $k < count($cursos_esp); $k++) {
           if($tipos[$j][0]==$cursos_esp[$k][1] && substr($cursos_esp[$k][3], 0,15)!='INTEGRACION CON' && $tipos[$j][1]==$cursos_esp[$k][4]){
               $integracionNo=$integracionNo+$cursos_esp[$k][2];
               $titulo=$cursos_esp[$k][1];
           }else if(substr($cursos_esp[$k][3], 0,15)=='INTEGRACION CON' && $tipos[$j][0]==$cursos_esp[$k][1] && $tipos[$j][1]==$cursos_esp[$k][4]){
               $integracion=$integracion+$cursos_esp[$k][2]; 
           }   
       } 
        $listaD.="<tr>";
        $listaD.="<td style='border: 1px black solid'>{$tipos[$j][0]}<br>{$tipos[$j][1]}</td>";
        $listaD.= (!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? "<td style='border: 1px black solid' name='".trim($tipos[$j][0].$tipos[$j][1])."' >".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][2]."</td>" : " <td style='border: 1px black solid' name='".trim($tipos[$j][0].$tipos[$j][1])."'>$integracionNo</td> "; 
        $listaD.="<td style='border: 1px black solid'><input type='number' ";
         if($persona=='SA' || $persona=='GI'){
            $listaD.= (!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? " value='".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][3]."'" : " onkeyup='llenarForm(this.value, this.name, $integracionNo, `$centroGestion`)' "; 
        }else{
            $listaD.= (!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? " value='".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0].$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][3]."'" : ""; 
        }
        $listaD.=" name='".trim($tipos[$j][0].$tipos[$j][1])."' id='".trim($tipos[$j][0].$tipos[$j][1])."' style='height:25px;width:80px;background:rgba(245, 176, 65, 0.7);margin:2px;'/></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0].$tipos[$j][1])."'></td>";
        $listaD.="</tr>";  
       if($integracion!=0){
            $listaD.="<tr>";
            $listaD.="<td style='border: 1px black solid'>{$tipos[$j][0]} CON INTEGRACION<br>{$tipos[$j][1]}</td>";
            $listaD.=(!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? "<td style='border: 1px black solid' name='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'>".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][2]."</td>" : " <td style='border: 1px black solid' name='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'>$integracion</td> " ;
            $listaD.="<td style='border: 1px black solid'><input type='number' ";
            if($persona=='SA' || $persona=='GI'){
                $listaD.=(!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? "value='".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][3]."'" : " onkeyup='llenarForm(this.value, this.name, $integracion, `$centroGestion`)' " ;
            }else{
                $listaD.=(!empty(ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null))) ? "value='".ConectorBD::ejecutarQuery("select * from meta where anio='".($anioFin+1)."' and nombre_tipo='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' and sede='$centroGestion' ", null)[0][3]."'" : "" ;
            }
            $listaD.=" name='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' id='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."' style='height:25px;width:80px;background:rgba(245, 176, 65, 0.7);margin:2px;'/></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="<td style='border: 1px black solid' class='".trim($tipos[$j][0]."INTEGRACION".$tipos[$j][1])."'></td>";
            $listaD.="</tr>";
       }      
   }
         
    ?>
            <link rel="stylesheet" href="css/CatalogoIndicativa.css">
            <label id='avisoIndicativa'></label>
            <table style='border: 1px black solid'>
                <tr style='background: rgb(52, 152, 219)'>
                    <td> CENTRO</td>
                    <td> AÑO</td>
                    <td> TRIMESTRE</td>
                    <td> MES TERMINA</td>
                    <td> TIPO PROGRAMA</td>
                    <td> JORNADA</td>
                    <td> NUMERO GRUPOS</td>
                    <td> APRENDIZ ACTIVO</td>
                </tr>   
                <tr>
                    <td rowspan="<?=$columns?>" style='background: rgb(52, 152, 219); width: 150px;'><?=$datosReporte[0][1]?> <p><?PHP print_r(ConectorBD::ejecutarQuery("SELECT nombresede FROM SEDE WHERE CODIGOSEDE='{$datosReporte[0][1]}'", 'eagle_admin')[0][0])?></p></td>
                </tr>   
                <?=$lista?>
                <tr style='background: rgb(52, 152, 219)'>
                    <td colspan="6" style='border: 1px black solid'>
                        TOTALES
                    </td>
                    <td style='border: 1px black solid'>
                        <?=$contador?>
                    </td>
                    <td style='border: 1px black solid'>
                        <?=$aprendiz?>
                    </td>
                    <?PHP if($persona=='A' || $persona=='GI'){ print_r("<tr><td colspan='6'> VER INFORMACION DE FICHAS ACTIVAS </td><td  colspan='2'><input type='button' style='margin-right:50px' id='button' name='accionU' title='Ver Fichas Activas del Centro' value='FICHAS' onclick='validarDatosFicha($centroGestion)'></td></tr>");} ?>
                </tr>
            </table><br><br>
            
            <table style='border: 1px black solid'>
                <tr style='background: rgb(52, 152, 219)'>
                    <td> NIVEL</td>
                    <td> CUPOS PASAN</td>
                    <td> META ASIGNADA</td>  
                    <td> META A PROGRAMAR</td>
                    <td> PRIMER TRIM. (60%)</td>
                    <td> SEGUNDO TRIM. (10%)</td>
                    <td> TERCER TRIM. (20%)</td>
                    <td> CUARTO TRIM. (10%)</td>
                    <td style="background: rgba(130, 224, 170)"> PRIMER TRIM. (Total)</td>
                    <td style="background: rgba(130, 224, 170)"> SEGUNDO TRIM. (Total)</td>
                    <td style="background: rgba(130, 224, 170)"> TERCER TRIM. (Total)</td>
                    <td style="background: rgba(130, 224, 170)"> CUARTO TRIM. (Total)</td>
                    <td style="background: rgba(245, 176, 65)"> ENVIAR META</td>
                </tr>   
                <?=$listaD?>
            </table>

<?php }else{     print_r("NO HAY INFORMACIÓN PE-04 ");}
      }elseif ($id==9) {
            print_r(Indicativa::listames('',$virtual)); 
      }