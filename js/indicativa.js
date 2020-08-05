/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function llenarForm(numero, nombre, activo){
    segundoT=10;
    tercerT=20;
    cuartoT=10;
    if(numero>=activo && numero!==null){
        document.getElementsByClassName(nombre)[0].innerHTML=(parseInt(numero)-parseInt(activo));
        porcentaje=Math.round((activo*100)/numero);
        
        document.getElementsByClassName(nombre)[1].innerHTML=porcentaje+'%';
        if(porcentaje<60){
            nuevoporsentaje=60-porcentaje;
            nuevoNumero=Math.round(numero*nuevoporsentaje/100);
            document.getElementsByClassName(nombre)[5].innerHTML=nuevoNumero;
        }else if (porcentaje>60) {
            segundoT=segundoT-(porcentaje-60);
            if (segundoT<0){
                document.getElementsByClassName(nombre)[2].innerHTML='0%';
                tercerT=tercerT+segundoT; 
                if (tercerT<0){
                    document.getElementsByClassName(nombre)[3].innerHTML='0%';
                    cuartoT=cuartoT+tercerT; 
                    if (cuartoT<=0){
                        document.getElementsByClassName(nombre)[4].innerHTML='0%';
                    }else if (cuartoT>0) {
                        document.getElementsByClassName(nombre)[4].innerHTML=cuartoT+'%';
                    }
                }else if (tercerT>0) {
                    document.getElementsByClassName(nombre)[3].innerHTML=tercerT+'%';                    
                }
            }else if (segundoT>0) {
                document.getElementsByClassName(nombre)[2].innerHTML=segundoT+'%';
            }            
        }
        if(segundoT>0){
                document.getElementsByClassName(nombre)[2].innerHTML=segundoT+'%';
                nuevoNumero=Math.round(numero*segundoT/100);
                document.getElementsByClassName(nombre)[6].innerHTML=nuevoNumero;
        }
        if(tercerT>0){
                document.getElementsByClassName(nombre)[3].innerHTML=tercerT+'%';
                nuevoNumero=Math.round(numero*tercerT/100);
                document.getElementsByClassName(nombre)[7].innerHTML=nuevoNumero;
        }
        if(cuartoT>0){
                document.getElementsByClassName(nombre)[4].innerHTML=cuartoT+'%';
                nuevoNumero=Math.round(numero*cuartoT/100);
                document.getElementsByClassName(nombre)[8].innerHTML=nuevoNumero;
                document.getElementsByClassName(nombre)[9].innerHTML=`<button type='button' id='button' name='${nombre}' onclick='enviarInfo(this.name, ${activo}, ${numero})' title=''><i class='far fa-check-square botonModal'></i></button></pre>`;
        }
    }else{
        document.getElementsByClassName(nombre)[0].innerHTML='X';
        document.getElementsByClassName(nombre)[1].innerHTML='X';
        document.getElementsByClassName(nombre)[5].innerHTML='X';
        document.getElementsByClassName(nombre)[2].innerHTML='X';
        document.getElementsByClassName(nombre)[6].innerHTML='X';
        document.getElementsByClassName(nombre)[3].innerHTML='X';
        document.getElementsByClassName(nombre)[7].innerHTML='X';
        document.getElementsByClassName(nombre)[4].innerHTML='X';
        document.getElementsByClassName(nombre)[8].innerHTML='X';
        document.getElementsByClassName(nombre)[9].innerHTML='';
    }
}

function enviarInfo(nombre, activos , meta ){
    idexistentesReCa('',`accionU=INDICATIVA&meta=${meta}&activos=${activos}&nombre=${nombre}`,'avisoIndicativa','View/CatalogoIndicativa/CatalogoIndicativaModificar.php')
}

function validarDatosFicha(FichaGestiones){
    document.getElementById('formDetalle').innerHTML="<form target='print_popup' method='post' action='index.php?CONTENIDO=View/Ficha/Ficha.php' onsubmit='"+window.open('about:blank','print_popup','width=1000,height=700,left=200,top=150,scrollbars=no,status=no,toolbar=no,directories=no,location=no,menubar=no')+"'>"
             +"<input type='hidden' value='"+FichaGestiones+"' id='FichaGestiones' name='FichaGestiones' required/>" 
             +"<input type='submit' value='accion' id='accionForm' name='accionForm'/> "
         +"</form>";
    document.getElementById('accionForm').click();
}

function idexistentesReCa(id, postcad, donde, accion) {
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function (){
        if(this.readyState==4 && this.status==200){
               var respuesta=this.responseText;  
               document.getElementById(donde).innerHTML=respuesta; 
        }        
    };
    xhr.open('POST',accion, true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send(postcad);  
}

function validarDatos(id, postcad, donde, accion){
    idexistentesReCa(id, postcad, donde, accion);    
    
    document.getElementById("modales").style.transform='translateX(0%)';      
	       document.getElementById("modales").style.transition="1s"; 
	       document.getElementById("formularioDiv").style.width=""; 
        
}

function infoCentro(cod_centro, donde, accion, id){
    idexistentesReCa('','id='+id+'&cod_centro='+cod_centro ,donde,accion);
}

function dondeIrModal(donde){
    vigencia=false;
    id_programa=false;
    id_modalidad=false;
    formacion=false;
    inicio=false;
    cupos=false;
    departamento=false;
    municipio=false;
    anio_termina=false;
    curso=false;
    ambiente_requiere=false;
    gira_tecnica1=false;
    gira_tecnica2=false;
    programa_fic1=false;
    programa_fic2=false;
    cuersos=false;
    
    
    if(document.getElementById('vigencia').value=='' || parseInt(document.getElementById('vigencia').length)>4 || isNaN(parseInt(document.getElementById('vigencia').value))){
        document.getElementById('vigencia').focus();
        document.getElementById('vigencia').style.background='rgba(253, 235, 208)';
        document.getElementById('vigencia').value='';
        espacioObligatorio('VIGENCIA VALOR #');
        return ;
    }else{
        document.getElementById('vigencia').style.background='white';
        vigencia=true;
    }
    if(document.getElementById('id_programa').value=='' || parseInt(document.getElementById('id_programa').length)>8 || isNaN(parseInt(document.getElementById('id_programa').value))){
        document.getElementById('id_programa').focus();
        document.getElementById('id_programa').style.background='rgba(253, 235, 208)';
        document.getElementById('id_programa').value='';
        espacioObligatorio('PROGRAMA VALOR #');
        return ;
    }else{
        document.getElementById('id_programa').style.background='white';
        id_programa=true;
    }
    if(document.getElementById('id_modalidad').value==''){
        document.getElementById('id_modalidad').focus();
        document.getElementById('id_modalidad').style.background='rgba(253, 235, 208)';
        document.getElementById('id_modalidad').value='';
        espacioObligatorio(' MODALIDAD ');
        return ;
    }else{
        document.getElementById('id_modalidad').style.background='white';
        id_modalidad=true;
    }
    if(document.getElementById('formacion').value==''){
        document.getElementById('formacion').focus();
        document.getElementById('formacion').style.background='rgba(253, 235, 208)';
        document.getElementById('formacion').value='';
        espacioObligatorio(' FORMACION ');
        return ;
    }else{
        document.getElementById('formacion').style.background='white';
        formacion=true;
    }
    if(document.getElementById('inicio').value=='' || parseInt(document.getElementById('inicio').value)>12 || isNaN(parseInt(document.getElementById('inicio').value))){
        document.getElementById('inicio').focus();
        document.getElementById('inicio').style.background='rgba(253, 235, 208)';
        document.getElementById('inicio').value='';
        espacioObligatorio('INICIO VALOR #');
        return ;
    }else{
        document.getElementById('inicio').style.background='white';
        inicio=true;
    }
    if(document.getElementById('cupos').value=='' || parseInt(document.getElementById('cupos').value)>500 || isNaN(parseInt(document.getElementById('cupos').value))){
        document.getElementById('cupos').focus();
        document.getElementById('cupos').style.background='rgba(253, 235, 208)';
        document.getElementById('cupos').value='';
        espacioObligatorio('CUPOS VALOR #');
        return ;
    }else{
        document.getElementById('cupos').style.background='white';
        cupos=true;
    }
    if(document.getElementById('departamento').value=='' ){
        document.getElementById('departamento').focus();
        document.getElementById('departamento').style.background='rgba(253, 235, 208)';
        document.getElementById('departamento').value='';
        espacioObligatorio(' DEPARTAMENTO ');
        return ;
    }else{
        document.getElementById('departamento').style.background='white';
        departamento=true;
    }
    if(document.getElementById('municipio').value=='' ){
        document.getElementById('municipio').focus();
        document.getElementById('municipio').style.background='rgba(253, 235, 208)';
        document.getElementById('municipio').value='';
        espacioObligatorio(' MUNICIPIO ');
        return ;
    }else{
        document.getElementById('municipio').style.background='white';
        municipio=true;
    }
   if(document.getElementById('anio_termina').value=='' || parseInt(document.getElementById('vigencia').length)>4 || isNaN(parseInt(document.getElementById('vigencia').value))){
        document.getElementById('anio_termina').focus();
        document.getElementById('anio_termina').style.background='rgba(253, 235, 208)';
        document.getElementById('anio_termina').value='';
        espacioObligatorio('AÑO TERMINA');
        return ;
    }else{
        document.getElementById('anio_termina').style.background='white';
        anio_termina=true;
    }
    if(document.getElementById('curso').value=='' || parseInt(document.getElementById('curso').value)>500 || isNaN(parseInt(document.getElementById('curso').value))){
        document.getElementById('curso').focus();
        document.getElementById('curso').style.background='rgba(253, 235, 208)';
        document.getElementById('curso').value='';
        espacioObligatorio('CURSOS VALOR #');
        return ;
    }else{
        document.getElementById('curso').style.background='white';
        curso=true;
    }
    if(document.getElementById('ambiente_requiere').value=='' || parseInt(document.getElementById('ambiente_requiere').value)>500 || isNaN(parseInt(document.getElementById('ambiente_requiere').value))){
        document.getElementById('ambiente_requiere').focus();
        document.getElementById('ambiente_requiere').style.background='rgba(253, 235, 208)';
        document.getElementById('ambiente_requiere').value='';
        espacioObligatorio('REQUIERE AMBIENTE VALOR #');
        return ;
    }else{
        document.getElementById('ambiente_requiere').style.background='white';
        ambiente_requiere=true;
    }
    if(!document.getElementById('gira_tecnica1').checked && !document.getElementById('gira_tecnica2').checked){
        document.getElementById('gira_tecnica1').focus();
        document.getElementById('gira_tecnica1').style.background='rgba(253, 235, 208,0.7)';
        document.getElementById('gira_tecnica2').style.background='rgba(253, 235, 208,0.7)';
        espacioObligatorio('REQUIERE GIRA TECNICA');
        return ;
    }else{
        document.getElementById('gira_tecnica1').style.background='white';
        document.getElementById('gira_tecnica2').style.background='white';
        gira_tecnica1=true;
        gira_tecnica2=true;
    }
    if(!document.getElementById('programa_fic1').checked && !document.getElementById('programa_fic2').checked){
        document.getElementById('programa_fic1').focus();
        document.getElementById('programa_fic1').style.background='rgba(253, 235, 208,0.7)';
        document.getElementById('programa_fic2').style.background='rgba(253, 235, 208,0.7)';
        espacioObligatorio('ES PROGRAMA FIC');
        return ;
    }else{
        document.getElementById('programa_fic1').style.background='white';
        document.getElementById('programa_fic2').style.background='white';
       programa_fic1=true;
       programa_fic2=true;
    }
    
    valor=parseInt(document.getElementById('cursos1').value)+parseInt(document.getElementById('cursos2').value)+parseInt(document.getElementById('cursos3').value)+parseInt(document.getElementById('cursos4').value);
    
    if (valor===parseInt(document.getElementById('curso').value)) {
        cursos=true;
    }else{
        espacioObligatorio('LA SUMA DE NUMERO DE CURSOS ES DIFERENTE AL NUMERO DE CURSO');
        return ;
    }
    
    
    
    if( vigencia==true && id_programa==true && id_modalidad==true && formacion==true && inicio==true && cupos==true && departamento==true &&
    municipio==true && anio_termina==true && curso==true && ambiente_requiere==true && gira_tecnica1==true && gira_tecnica2==true && programa_fic1==true &&
    programa_fic2==true && cursos==true){
        dondeIrModales(donde);
    }
}

function dondeIrModales(donde){
         document.getElementById('modales').style.display='none';
         var dondeVamos=document.querySelector('#modalesV');
         dondeVamos.setAttribute('action', donde);
         document.getElementById('accionU').type='submit';
}

function validarDatosInf(info, id, user){
    var donde='';
    if(id==1){
       donde='View/CatalogoIndicativa/CatalogoIndicativaFormulario.php'; 
       validarDatos('','id=1&info='+info+'&user='+user+'&accion=MODIFICAR', 'modalVentana',donde);
       window.setTimeout(function(){
            infoCentro(document.getElementById('id_programa').value,'infoCentrosP',donde,2);
       },1000);
       window.setTimeout(function(){
            infoCentro(document.getElementById('departamento').value+'&municipio='+document.getElementById('pro').value,'municipio',donde,3);
       },1000);
    }else if (id==2) {
        donde='View/CatalogoIndicativa/CatalogoIndicativaFormulario.php'; 
        validarDatos('','id=5&info='+info+'&user='+user+'', 'modalVentana',donde);
    }

}

window.addEventListener('keydown', function(ev) {            
    if (ev.keyCode==27) {
               document.getElementById("modales").style.transform='translateX(-100%)';      
	       document.getElementById("modales").style.transition="1s"; 
	       document.getElementById("formularioDiv").style.width="";    
    }
});

function cerrarventana(){
               document.getElementById("modales").style.transform='translateX(-100%)';      
	       document.getElementById("modales").style.transition="0.5s"; 
	       document.getElementById("modalesD").style.width="";    
}

function validarCursos(valor){  
   
} 

function Eliminar(id_indicativa) {                    
          validarDatos('','id_indicativa='+id_indicativa+'&id=4', 'modalVentana','View/CatalogoIndicativa/CatalogoIndicativaFormulario.php');
}

function validar(id_indicativa) {                    
         validarDatos('','id_indicativa='+id_indicativa+'&id=6', 'modalVentana','View/CatalogoIndicativa/CatalogoIndicativaFormulario.php');
}

function Exportar(id, postcad, donde, accion) {                    
    idexistentesReCa(id, postcad, donde, accion);
       window.setTimeout(function(){ 
                    var data_type = 'data:application/vnd.ms-excel';
                    var tmpElemento = document.getElementById('botonE');
                    var tabla_div = document.getElementById('tablareporte');
                    var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
                    tmpElemento.href = data_type + ', ' + tabla_html;
                    //Asignamos el nombre a nuestro EXCEL
                    tmpElemento.download= 'Reporte '+postcad+'.xls';
                    // Simulamos el click al elemento creado para descargarlo
                   tmpElemento.click();
        }, 2000); 
    }


function validarExportar(user){
    where='';
    hoy = new Date().getFullYear();;
    cadena  = (document.getElementById('id_indicativa')!==null && document.getElementById('id_indicativa').checked) ? 'id_indicativa, ': ' ';
    cadena += (document.getElementById('cod_centro')!==null && document.getElementById('cod_centro').checked) ? 'cod_centro, ': '';
    cadena += (document.getElementById('vigencia')!==null && document.getElementById('vigencia').checked) ? 'vigencia, ': '';
    where   = (document.getElementById('vigenciaA')!==null && document.getElementById('vigenciaA').checked) ? "vigencia='"+hoy+"'": '';
    cadena += (document.getElementById('oferta')!==null && document.getElementById('oferta').checked) ? 'oferta, ': '';
    cadena += (document.getElementById('id_programa')!==null && document.getElementById('id_programa').checked) ? 'id_programa, ': '';
    cadena += (document.getElementById('inicio')!==null && document.getElementById('inicio').checked) ? 'inicio, ': '';
    cadena += (document.getElementById('cupos')!==null && document.getElementById('cupos').checked) ? 'cupos, ': '';
    cadena += (document.getElementById('municipio')!==null && document.getElementById('municipio').checked) ? 'municipio, ': '';
    cadena += (document.getElementById('anio_termina')!==null && document.getElementById('anio_termina').checked) ? 'anio_termina, ': '';
    cadena += (document.getElementById('curso')!==null && document.getElementById('curso').checked) ? 'curso, ': '';
    cadena += (document.getElementById('ambiente_requiere')!==null && document.getElementById('ambiente_requiere').checked) ? 'ambiente_requiere, ': '';
    cadena += (document.getElementById('gira_tecnica')!==null && document.getElementById('gira_tecnica').checked) ? 'gira_tecnica, ': '';
    cadena += (document.getElementById('programa_fic')!==null && document.getElementById('programa_fic').checked) ? 'programa_fic, ': '';
    cadena += (document.getElementById('id_modalidad')!==null && document.getElementById('id_modalidad').checked) ? 'id_modalidad, ': '';
    cadena += (document.getElementById('formacion')!==null && document.getElementById('formacion').checked) ? 'formacion, ': '';
    cadena += (document.getElementById('fecha')!==null && document.getElementById('fecha').checked) ? 'fecha, ': '';

     idexistentesReCa('','id=4&cadena='+cadena+'&nombre=INDICATIVA&where='+where+'&user='+user, 'tablareporte','View/Sede/SedeFormulario.php');
     window.setTimeout(function(){ 
                    var data_type = 'data:application/vnd.ms-excel';
                    var tmpElemento = document.getElementById('botonE');
                    var tabla_div = document.getElementById('tablareporte');
                    var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
                    tmpElemento.href = data_type + ', ' + tabla_html;
                    //Asignamos el nombre a nuestro EXCEL
                    tmpElemento.download= 'Reporte INDICATIVA.xls';
                    // Simulamos el click al elemento creado para descargarlo
                   tmpElemento.click();
        }, 1000); 
}

function reportes(user, centroGestion){
    document.getElementById('formDetalle').innerHTML="<form target='print_popup' method='post' action='index.php?CONTENIDO=View/Reporte/Reporte.php' onsubmit='"+window.open('about:blank','print_popup','width=1000,height=700,left=200,top=150,scrollbars=no,status=no,toolbar=no,directories=no,location=no,menubar=no')+"'>"
             +"<input type='text' value='"+centroGestion+"' id='centroGestion' name='centroGestion'/> "
             +"<input type='text' value='"+user+"' id='user' name='user'/> "
             +"<input type='submit' value='accion' id='accionForm' name='accionForm'/> "
         +"</form>";
    document.getElementById('accionForm').click();
}