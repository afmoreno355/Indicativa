<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//primera capa 
//permisos del usuario si puede o no estar en esta file
$permisos = new Persona(' identificacion ', "'".$_SESSION['user']."'");
//fin permisos
//redireccion si no existen permisos
if($permisos->getIdTipo()!='SA' && $permisos->getIdTipo()!='AI' && $permisos->getIdTipo()!='IR'){   
          header("location: index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php");
}
//fin redireccion
?>
<!--titulo-->
<div class="tituloDonde">
    <label>Sede :: Sede Centros de formación </label><br>
<!--fin titulo-->

<!--adelante atras paginas-->
<table class="tableIntT c">   
      <tr>
        <td  colspan="3" class="noHover">
            <button class="fas fa-angle-double-left" name="Atras" id="Atras" title="Pag Atras" onclick="Atras('','user=<?=$_SESSION['user']?>','tableIntT','View/Sede/SedeTabla.php');"></button>
            <label class="pag" name="pag" id="pag">1</label>
            <button class="fas fa-angle-double-right" name="Adelante" id="Adelante" title="Pag Adelante" onclick="Adelante('', document.getElementById('numeroPaginas').value,'user=<?=$_SESSION['user']?>','tableIntT','View/Sede/SedeTabla.php');"></button>
        </td>  
      </tr>       
</table>
<!--fin adelante atras paginas-->

<!--ajax trae las tablas a esta posicion-->
<table id="tableIntT" class="tableIntT sombra tableIntTa">
    
</table>
<!--fin ajax trae las tablas a esta posicion-->

<!--apertura de ventana modal del navegador-->
<div id="formDetalle" style="display: none;">
      
</div>
<!-- fin apertura de ventana modal del navegador-->

<!--llamada a javascript-->
<script src="./js/indicativa.js"> </script>
<script src="./js/sede.js"> </script>
<!--fin llamada a javascript-->

<!--tabla de reportes para excel-->
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;">
     
</table>
<!--fin tabla de reportes para excel-->

<!--load llama a ajax-->
<script>

window.addEventListener('load',idexistentesReCa('','user=<?=$_SESSION['user']?>&pagina=0','tableIntT','View/Sede/SedeTabla.php'));

</script>
<!--fin load llama a ajax-->
