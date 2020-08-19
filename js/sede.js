/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function centroGestion(centroGestiones){
    document.getElementById('formDetalle').innerHTML="<form target='print_popup' method='post' action='index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php' onsubmit='"+window.open('about:blank','print_popup','width=1000,height=700,left=200,top=150,scrollbars=no,status=no,toolbar=no,directories=no,location=no,menubar=no')+"'>"
             +"<input type='hidden' value='"+centroGestiones+"' id='centroGestion' name='centroGestion' required/>" 
             +"<input type='submit' value='accion' id='accionForm' name='accionForm'/> "
         +"</form>";
    document.getElementById('accionForm').click();
}

window.setTimeout(function(){
//location.reload();    
},20000);

window.addEventListener('load', function (){
  window.setInterval(function(){
      lista='';
      centros='';
        for (var i = 0; i < 5; i++) {
            lista+=document.getElementsByClassName('codigoSede')[i].innerHTML+'|>'+document.getElementsByClassName('numeroSolicitud')[i].innerHTML+'¬';
        }       
        idexistentes('','id=1&cadena='+lista,'','View/Sede/SedeFormulario');
        
        window.setTimeout(function (){
           datos= new Array();
           notificacion=prueba.split('¬');
            for (var i = 0; i < notificacion.length-1; i++) {
               datos[i]=notificacion[i].split('|>');
               if(parseInt(datos[i][1])===parseInt(document.getElementsByClassName('numeroSolicitud')[i].innerHTML)) {
                   '';
               }else{  
                   document.getElementsByClassName('numeroSolicitud')[i].innerHTML=datos[i][1];
                   centros="Nuevo Ingreso a Plataforma!!";
               }
            }
            if (centros!="") {
                if (!Notification) {
                    alert("El Navegador no Soporta Notificaciones")
                }else if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }
                var aviso = new Notification("Nuevo Envio en Bandeja",{
                        icon : "http://direcciondeformacion.senaedu.edu.co/materiales/img/logo/sena.png",
                        body : centros 
                    });
            }
            
        },2000);
        
  },5000);
})

function idexistentes(id, postcad, donde, accion) {
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function (){
        if(this.readyState==4 && this.status==200){
               var respuesta=this.responseText;  
               prueba= respuesta; 
        }        
    };
    xhr.open('POST',accion, true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send(postcad);  
}

function pe04(donde){
    Excel=false;
    
    if (document.getElementById('Excel').value=='') {
        espacioObligatorio(' ARCHIVO');
        document.getElementById('Excel').focus();
        return ;
    }else{
        datosimage=document.getElementById('Excel').value.split(".");
        for (var i = 0; i < datosimage.length; i++) {
            if (datosimage[i]=='xlsx' || datosimage[i]=='xlsm' || datosimage[i]=='xlsb' || datosimage[i]=='xltx' || datosimage[i]=='xls' || datosimage[i]=='csv' ) {
                Excel=true;
            }
        }
    }  
  
    if (Excel==true) {
        dondeIrModales(donde);
    }else{        
        document.getElementById('aviso').style.background="rgba(214, 234, 248,0.5)";
        document.getElementById('aviso').innerHTML="EXTENCION INCORRECTA";
        return ;
    }
}