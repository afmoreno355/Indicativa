/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
menu=0;

function BuscarElementos(){
        addcadena='';
        datos=window.location.toString().split('=');
        bucarPalabraClave=document.getElementById('bucarPalabraClave').value;
        url=datos[1].split('.');    
        if (document.getElementById('user')!=null) {
            addcadena="&user="+document.getElementById('user').value;
        }
        if (document.getElementById('bd')!=null) {
            addcadena+="&bd="+document.getElementById('bd').value;
        }
        if (document.getElementById('centroGestion')!=null) {
            addcadena+="&centroGestion="+document.getElementById('centroGestion').value;
        }
        if (document.getElementById('arreglo')!=null) {
            addcadena+="&arreglo="+document.getElementById('arreglo').value;
        }
        if (parseInt(document.getElementById('pag').innerHTML)!=1) {
            document.getElementById('pag').innerHTML=1;
        }

    idexistentesReCa('','bucarPalabraClave='+bucarPalabraClave.trim()+'&pagina=0&limit=5'+addcadena, 'tableIntT', url[0]+'Tabla.php');
    window.setTimeout(function(){             
                    dibujarChart();    
            }, 500);    
}

function espacioObligatorio(ID){
    document.getElementById('aviso').innerHTML="***ESPACIO SIN MARCAR "+ID+"***";
}

function menudes(){
    if(menu===0){
        document.getElementById('divmenu').style.height='335px';
        document.getElementById('divmenu').style.transition='1s';
        document.getElementById('nav').style.transform='translateY(0%)';
        document.getElementById('nav').style.transition='1s'; 
        menu=1;
    }else if (menu===1) {
	document.getElementById('divmenu').style.height='40px';
        document.getElementById('divmenu').style.transition='1s';
        document.getElementById('nav').style.transform='translateY(-110%)';
        document.getElementById('nav').style.transition='1s'; 
        menu=0;
    }    
}
window.addEventListener('resize', function (ev){
    if (window.innerWidth>=900) {
        document.getElementById('nav').style.transform='translateY(0%)';
        document.getElementById('divmenu').style.height='40px';
    }else if (window.innerWidth<900) {
	document.getElementById('nav').style.transform='translateY(-110%)';
        document.getElementById('divmenu').style.height='40px';
    }
    menu=0;
});

window.addEventListener('resize', function (ev){
    if(window.innerWidth>=900){
      window.setTimeout(function(){
          //location.reload(); 
      },200);
    }    
});

function  Adelante(donde, numeroPaginas, filtro, dondeT, accion){
    pagNumero=parseInt(document.getElementById('pag').innerHTML);
    pagNumero=pagNumero+1;
    if (pagNumero<=numeroPaginas) {
      document.getElementById('pag').innerHTML=pagNumero;
      var pagina=(pagNumero*5)-5;
        idexistentesReCa('',filtro+"&pagina="+pagina, dondeT, accion);  
    }   
}

function  Atras(donde, filtro, dondeT, accion){
    pagNumero=parseInt(document.getElementById('pag').innerHTML);
    if(pagNumero<1 ){
        document.getElementById('pag').innerHTML=1;
    }else if (pagNumero>1) {
	pagNumero=pagNumero-1;
        document.getElementById('pag').innerHTML=pagNumero;
        var pagina=(pagNumero*5)-5;
        idexistentesReCa('',filtro+"&pagina="+pagina, dondeT, accion); 
    }
}

function aviso(aviso){
    if(aviso!=''){
        validarDatos('','id=2&aviso='+aviso,'modalVentana','View/Avisos/Avisos.php')
    }else{
        return ;
    }
}