<?php

ob_start();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$lista='';
$avisoLoad ='';
$centroGestion ='';


require_once dirname(__FILE__).'/classes/ConectorBD.php';
require_once dirname(__FILE__).'/classes/Indicativa.php';
require_once dirname(__FILE__).'/classes/Persona.php';
require_once dirname(__FILE__).'/classes/Sede.php';
require_once dirname(__FILE__).'/classes/Programa.php';

session_start();

foreach ($_POST as $key => $value) ${$key}=  $value;
foreach ($_GET as $key => $value) ${$key}= $value;
  
if (isset($_GET['CONTENIDO'])) {
        $contenido=$_GET['CONTENIDO'];
    } else {
        header("Location: index.php");       
    }  
if(isset($_SESSION['aviso'])){
    if($_SESSION['aviso']!=''){
        $avisoLoad=$_SESSION['aviso'];
        $_SESSION['aviso']='';
    } 
}   
?>

 <head>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="css/formulario.css">
        <link rel="stylesheet" href="css/seccion.css">
        <link rel="stylesheet" href="css/tablas.css">
        <link rel="stylesheet" href="css/buscar.css">
        <link rel="stylesheet" href="css/modal.css">
        <link rel="stylesheet" href="css/menu.css">
        <link rel="stylesheet" href="css/tabs.css">
        <link rel="icon" type="image/png" href="img/logo/sena.png" />  
      	<title>INDICATIVA</title>        
        <meta charset="UTF-8">
</head>
<body onload="aviso('<?=$avisoLoad?>')">
        <div class="modales" id="modales">
                <button class="fas fa-times-circle salir" onclick="cerrarventana()"></button>
   		<div class="formularioDiv" id="formularioDiv">   			
                        <form class="modalesV" id="modalesV" action="" method="POST" enctype='multipart/form-data'>   				
                            <p id="modalVentana"></p>                           
   			</form>
   		</div>
        </div>
        <div class="tituloInfo" id="tituloInfo">    
            <img class="logo" src="img/logo/sena.png">
            <div><label><?= print_r(date('l\, d \of F Y'))?> </label>    <button onclick="validarDatos('','','modalVentana','View/Menu/MenuFormulario.php')">CERRAR SESION</button></div>
            <img class="logoN" src="img/logo/nacional.png">
         </div>
    
    
    
       <label class="fas fa-bars menuI" for="chequear"></label>
        <input type="checkbox" name="chek" id='chequear' onclick='menudes();' style="display: none">
        <div class="menu" id="divmenu" style=" margin-top: 0px;">
            <nav id="nav" class="navDisplay">
                    <a href="http://direcciondeformacion.senaedu.edu.co/Eagle-nn/inicio.php?CONTENIDO=view/Usuario/Usuario.php">Mi Usuario  </a>
                    <a href="index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php" title="Cargar Catalogo" class="aUltima">Indicativa  </a>
                </nav>
        </div>  
    
    
    
        <div id="tableIntD" class="tableIntD">
              <div id="buscar" class="buscar">
                <form method="post" id="formBuscar">
                    <input type="serch" name="bucarPalabraClave" onkeyup="BuscarElementos()" id="bucarPalabraClave" class="bucarPalabraClave" placeholder="&#xf002; SEARCH" />
                        <input type="button" name="serch" id="serch" onclick="BuscarElementos()" value="BUSCAR"/>
                </form>   	
              </div><br><br>
            <?php 
                if(!isset($_SESSION['user'])){
                   header("Location: http://localhost/eagle-nn/index.php");       
                } else {
		   include $contenido;
		}
            ?>
        </div>
    </body>
    <script src="js/menu.js"> </script>