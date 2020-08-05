<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

foreach ($_POST as $key => $value) ${$key}=$value;
if ($id==1) {      
    
?>
            
<label id='modalesT' class='modalesT'>AVISOS DEL SUPER ADMINISTRADOR</label>   				
            <table>
                <tr>
   		    <td>
   		        <label id='aviso'></label>  				
 		    </td>
   		</tr>
                <tr>
                    <td>
                        Aviso :<br>
                        Debe Elegir una Base de Datos<br>
                    </td><br>
                </tr>  <br>  
                <tr>
                    <td>
                        <pre><input type='radio' value="1" required name='bd' id="1" >Redirección  Bases de Datos</pre>
                    </td>
                </tr>    
                <tr>
                    <td>
                        <pre><input type='radio' value="2" required name='bd' id="2" >No mostrar mas este Aviso</pre>
                    </td>
                </tr>    
                <tr>
   		    <td>
                        <input type='button' name ='accionU' id='accionU' value='BD' onclick="dondeIrBd('inicio.php?CONTENIDO=validar.php')"/>
                        <input type='reset' name='limpiarU'  value='LIMPIAR' /><br><br>
   		    </td>
   		</tr>
            </table>  
<?php  }elseif ($id==2) {      
    
?>
            
<label id='modalesT' class='modalesT'>AVISOS DE ACCION</label>   				
            <table>
                <tr>
   		    <td>
   		        <label id='aviso'><?=$aviso?></label>  				
 		    </td>
   		</tr>
            </table>  <br><br>
<?php  }