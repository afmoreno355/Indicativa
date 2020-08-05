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
    .menu{
        display: none;
    }
    .buscar{
        display: none;
    }
</style>

<div class="tituloDonde">
   <label>Ficha :: Fichas Tablas </label> 
</div>


<table id="tableIntT" class="tableIntT sombra tableIntTa">
    
</table>

<div id="formDetalle" style="display: none;">
      
</div>

<script src="./js/ficha.js"> </script>
 
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;">
     
</table>

<script>

window.addEventListener('load',idexistentesF('','FichaGestiones=<?=$FichaGestiones?>','tableIntT','View/Ficha/FichaTabla.php'));

</script>