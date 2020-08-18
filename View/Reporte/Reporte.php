<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$permisos = new Persona(' identificacion ', "'".$_SESSION['user']."'");

if($permisos->getIdTipo()!='SA' && $permisos->getIdTipo()!='A' && $permisos->getIdTipo()!='AI' && $permisos->getIdTipo()!='GI' && $permisos->getIdTipo()!='IR'){   
        header("location: http://localhost/Eagle-nn/inicio.php?CONTENIDO=View/Usuario/Usuario.php");
}

?>
<style>
    .navDisplay{
        display: none;
    }
</style>
<link rel="stylesheet" href="css/reporte.css">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<div class="tituloDonde">
    <label>Reporte :: Reporte General del Sistema de Información</label><br>
    <label>Reporte :: programas del Catalogo por Mes sin Filtro</label><br>
    <label>centro :: <?=ConectorBD::ejecutarQuery("select nombresede from sede where codigosede='$centroGestion'", 'eagle_admin')[0][0]?></label><br><br> 
</div>

<div id="formDetalle" style="display: none;">
      
</div>

<div id="piechart_3d" class="tableIntD piechart_3d" style="margin-top: 50px;  margin-left: 5%; width: 90%;"></div>

<div style="width: 100%; text-align: center; align-content: center">
    <pre>
        <input type="radio" value='1' onclick="meses(this.value, document.getElementById('bucarPalabraClave').value)" name="meses" checked/> Mes     <input type="radio" value='3' onclick="meses(this.value, document.getElementById('bucarPalabraClave').value)" name="meses"/> Trimestral    <input type="radio" value='6' onclick="meses(this.value, document.getElementById('bucarPalabraClave').value)" name="meses"/> Semestral
    </pre>  
</div>

<table class="tableIntT c" style="display: none">   
      <tr>
        <td  colspan="3" class="noHover">
            <button class="fas fa-angle-double-left" name="Atras" id="Atras" title="Pag Atras" onclick="Atras('','user=<?=$_SESSION['user']?>','tableIntT','View/Sede/SedeTabla.php');"></button>
            <label class="pag" name="pag" id="pag">1</label>
            <button class="fas fa-angle-double-right" name="Adelante" id="Adelante" title="Pag Adelante" onclick="Adelante('', document.getElementById('numeroPaginas').value,'user=<?=$_SESSION['user']?>','tableIntT','View/Sede/SedeTabla.php');"></button>
        </td>  
      </tr>       
</table>
 
 <div id="tableIntT" class="tableIntDa" style="margin-top: 500px;">
    
</div>
 
<script src="./js/indicativa.js"></script>
<script src="./js/reporte.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
 
<script>

window.addEventListener('load',idexistentesGraficas('','id=1&centroGestion=<?=$centroGestion?>','tableIntT','View/Reporte/ReporteTabla.php'));

</script>
