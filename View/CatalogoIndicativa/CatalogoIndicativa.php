<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor sin el FELIPE.
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

//tipos de formacion
$tiposFormacion = Programa::obtenerNivelesFormacion();
$lista="";
for ($i = 0; $i < count($tiposFormacion); $i++) {
    $lista.="<option value='{$tiposFormacion[$i][0]}'>{$tiposFormacion[$i][0]}</option>";
}

?>
<div class="tituloDonde">
    <label>CatalogoIndicativa :: CatalogoIndicativa </label><br> 
   <label>Centro :: <?=$sede?> </label> 
</div>

<div class="tab-container sombra" style="margin-top:15px">
    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'titulada')" title="Formación Titulada">Titulada</button>
        <button class="tablinks" onclick="openTab(event, 'complementaria')" title="Formación Complementaria">Complementaria</button>
    </div>

    <div id="titulada" class="tabcontent" style="display: block;">
        <div style="margin-top:15px;margin-bottom:15px">
            Tipo de Formación
            <select onchange="cargarTablaIndicadores()" class="content_largo" name="id_formacion" id="id_formacion" required="">
                <option value="" selected>Todas</option>
                <?=$lista?>
            </select>
        </div>
        
        <table id="tableIntT" class="tableIntT tableIntTa" style="width:100%;margin-left:0;"></table>

        <table class="tableIntT c">   
            <tr>
                <td  colspan="3" class="noHover">
                    <button class="fas fa-angle-double-left" name="Atras" id="Atras" title="Pag Atras" onclick="anterior()"></button>
                    <label class="pag" name="pag" id="pag">1</label>
                    <button class="fas fa-angle-double-right" name="Adelante" id="Adelante" title="Pag Adelante" onclick="siguiente()"></button>
                </td>  
            </tr>       
        </table>

        <div id="formDetalle" style="display: none;"></div>
        
        <table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;"></table>
    </div>

    <div id="complementaria" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p> 
    </div>
</div>


<script src="./js/indicativa.js"> </script>
<script src="./js/sede.js"> </script>
 
<table id='tablareporte' class="tableIntT tableIntTa" style="display: none;  border: 1px solid black;"></table>

<script>

    const obtenerParametroTipoFormacion = () => {
        const e = document.getElementById("id_formacion");
        const tipoFormacion = e.options[e.selectedIndex].value;
        return !tipoFormacion || tipoFormacion == "" ? "": "&tipoFormacion=" + tipoFormacion;  
    };

    const siguiente = () => {
        const param = obtenerParametroTipoFormacion();
        Adelante('', 
                 document.getElementById('numeroPaginas').value,
                 'user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value + param,
                 'tableIntT',
                 'View/CatalogoIndicativa/CatalogoIndicativaTabla.php');
    };

    const anterior = () => {
        const param = obtenerParametroTipoFormacion();
        Atras('',
              'user=<?=$_SESSION['user']?>&centroGestion='+document.getElementById('centroGestion').value+ param,
              'tableIntT',
              'View/CatalogoIndicativa/CatalogoIndicativaTabla.php');
    };

    const cargarTablaIndicadores = () => {
        const param = obtenerParametroTipoFormacion();
        idexistentesReCa('',
                        'user=<?=$_SESSION['user']?>&pagina=0&centroGestion=<?=$centroGestion?>' + param,
                        'tableIntT',
                        'View/CatalogoIndicativa/CatalogoIndicativaTabla.php')
    };

    window.addEventListener('load', cargarTablaIndicadores());

    function openTab(evt, tadId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tadId).style.display = "block";
        evt.currentTarget.className += " active";
    };


</script>
