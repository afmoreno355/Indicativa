<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$permisos = ConectorBD::ejecutarQuery('select idtipo from persona where identificacion ='."'".$_SESSION['user']."'", 'eagle_admin');

if($permisos[0][0]!='A' && $permisos[0][0]!='GI'){   
          header("location: http://localhost/Eagle-nn/inicio.php?CONTENIDO=View/Usuario/Usuario.php");
}
?>
<style>
    .navDisplay{
        display: none;
    }
</style>

<div class="tituloDonde">
   <label>Ficha :: Fichas Tablas </label> 
</div>

<table class="tableIntT c">   
      <tr>
        <td  colspan="3" class="noHover">
            <button class="fas fa-angle-double-left" name="Atras" id="Atras" title="Pag Atras" onclick="AtrasC('','user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value,'tableIntT','View/Ficha/FichaTabla.php');"></button>
            <label class="pag" name="pag" id="pag">1</label>
            <button class="fas fa-angle-double-right" name="Adelante" id="Adelante" title="Pag Adelante" onclick="AdelanteC('', document.getElementById('numeroPaginas').value,'user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value,'tableIntT','View/Ficha/FichaTabla.php');"></button>
        </td>  
      </tr>       
</table>

<table id="tableIntT" class="tableIntT sombra tableIntTa">
    
</table>

<div id="formDetalle" style="display: none;">
      
</div>

<script src="./js/ficha.js"> </script>
 
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;">
     
</table>

<script>

window.addEventListener('load',idexistentesF('','pagina=0&centroGestion=<?=$FichaGestiones?>','tableIntT','View/Ficha/FichaTabla.php'));

</script>