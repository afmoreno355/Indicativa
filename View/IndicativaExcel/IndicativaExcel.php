<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__).'/../../classes/ConectorBD.php';

date_default_timezone_set('America/Bogota');
$dateIndicativa= date('Y', time());

$permisos = ConectorBD::ejecutarQuery('select idtipo from persona where identificacion ='."'".$_SESSION['user']."'", 'eagle_admin');

if($permisos[0][0]!='A' && $permisos[0][0]!='GI'){   
          header("location: http://localhost/Eagle-nn/inicio.php?CONTENIDO=View/Usuario/Usuario.php");
}
 
        $nuevoNombre= explode('.', $_FILES['Excel']['name']);
        copy($_FILES['Excel']['tmp_name'], "/wamp64/www/eagle-IN/Archivos/".$dateIndicativa."_IMPORTARC_{$_SESSION['sede']}_{$_SESSION['user']}.".$nuevoNombre[1]);
        $_SESSION['ruta']="/wamp64/www/eagle-IN/Archivos/".$dateIndicativa."_IMPORTARC_{$_SESSION['sede']}_{$_SESSION['user']}.".$nuevoNombre[1]; 
       
?>
<style>    
     .navDisplay{
        display: none;
    }
</style>

<div class="tituloDonde">
   <label>IndicativaExcel :: Indicativa Excel Importar </label> 
</div>


<table id="tableIntT" class="tableIntT sombra tableIntTa">
</table>

<div id="formDetalle" style="display: none;">
      
</div>

 
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;">
     
</table>

<script src="./js/indicativa.js"></script>
<script src="./js/excel.js"> </script>
 
<script>

window.addEventListener('load',idexistentesReCa('','','tableIntT','View/IndicativaExcel/IndicativaExcelTabla.php'));

</script>