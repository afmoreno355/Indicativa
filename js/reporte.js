/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function dibujarChart(){  
    datos=new Array() ;
    cortar=document.getElementById('arreglo').value.split('¬');
    var parametros = [];
    var valores = [];

    for (var i = 0; i < cortar.length ; i++) {
        datos[i]=cortar[i].split('<|');
       if(parseInt(datos[i][1])===1){
           valor='ENERO';
       }else if(parseInt(datos[i][1])===2){
          valor='FEBRERO';
       }else if(parseInt(datos[i][1])===3){
          valor='MARZO';
       }else if(parseInt(datos[i][1])===4){
          valor='ABRIL';
       }else if(parseInt(datos[i][1])===5){
          valor='MAYO';
       }else if(parseInt(datos[i][1])===6){
          valor='JUNIO';
       }else if(parseInt(datos[i][1])===7){
          valor='JULIO';
       }else if(parseInt(datos[i][1])===8){
          valor='AGOSTO';
       }else if(parseInt(datos[i][1])===9){
          valor='SEPTIEMBRE';
       }else if(parseInt(datos[i][1])===10){
          valor='OCTUBRE';
       }else if(parseInt(datos[i][1])===11){
          valor='NOVIEMBRE';
       }else if(parseInt(datos[i][1])===12){
          valor='DICIEMBRE';
       }
       parametros.push(valor);     
       valores.push(parseInt(datos[i][0]));
    }
    var data = [{
      x: parametros,
      y: valores,
      type: "bar"
    }];
    Plotly.newPlot("piechart_3d",data);
    
  }
  
  function idexistentesGraficas(id, postcad, donde, accion) {
    var xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function (){
        if(this.readyState==4 && this.status==200){
               var respuesta=this.responseText;  
               document.getElementById(donde).innerHTML=respuesta; 
               window.setTimeout(function (){
                   dibujarChart();
               },500);
        }        
    };
    xhr.open('POST',accion, true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send(postcad);  
}