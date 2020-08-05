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
$sede=($centroGestion!='') ? ConectorBD::ejecutarQuery("select nombresede from sede where codigosede='$centroGestion'", 'eagle_admin')[0][0] : ConectorBD::ejecutarQuery("select nombresede from sede where codigosede='{$permisos->getidsede()}'", 'eagle_admin')[0][0] ;

if(!isset($_SESSION['centroGestion']) || $centroGestion!=''){
    $_SESSION['centroGestion']=$centroGestion;
}else{
    $centroGestion=$_SESSION['centroGestion'];
}

?>
<div class="tituloDonde">
    <label>CatalogoIndicativa :: CatalogoIndicativa </label><br> 
   <label>Centro :: <?=$sede?> </label> 
</div>

<table class="tableIntT c">   
      <tr>
        <td  colspan="3" class="noHover">
            <button class="fas fa-angle-double-left" name="Atras" id="Atras" title="Pag Atras" onclick="Atras('','user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value,'tableIntT','View/CatalogoIndicativa/CatalogoIndicativaTabla.php');"></button>
            <label class="pag" name="pag" id="pag">1</label>
            <button class="fas fa-angle-double-right" name="Adelante" id="Adelante" title="Pag Adelante" onclick="Adelante('', document.getElementById('numeroPaginas').value,'user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value,'tableIntT','View/CatalogoIndicativa/CatalogoIndicativaTabla.php');"></button>
        </td>  
      </tr>       
</table>

<table id="tableIntT" class="tableIntT sombra tableIntTa">
    
</table>

<div id="formDetalle" style="display: none;">
      
</div>

<script src="./js/indicativa.js"> </script>
 
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;">
     
</table>

<script>

window.addEventListener('load',idexistentesReCa('','user=<?=$_SESSION['user']?>&pagina=0&centroGestion=<?=$centroGestion?>','tableIntT','View/CatalogoIndicativa/CatalogoIndicativaTabla.php'));

</script>