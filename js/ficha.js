/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function idexistentesF(id, postcad, donde, accion) {
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

function  AdelanteC(donde, numeroPaginas, filtro, dondeT, accion){
    pagNumero=parseInt(document.getElementById('pag').innerHTML);
    pagNumero=pagNumero+1;
    if (pagNumero<=numeroPaginas) {
      document.getElementById('pag').innerHTML=pagNumero;
      var pagina=(pagNumero*20)-20;
        idexistentesF('',filtro+"&pagina="+pagina, dondeT, accion);  
    }   
}

function  AtrasC(donde, filtro, dondeT, accion){
    pagNumero=parseInt(document.getElementById('pag').innerHTML);
    if(pagNumero<1 ){
        document.getElementById('pag').innerHTML=1;
    }else if (pagNumero>1) {
	pagNumero=pagNumero-1;
        document.getElementById('pag').innerHTML=pagNumero;
        var pagina=(pagNumero*20)-20;
        idexistentesF('',filtro+"&pagina="+pagina, dondeT, accion); 
    }
}