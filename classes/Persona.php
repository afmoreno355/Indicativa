<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 * @author Felipe Moreno
 */
class Persona {
    
    
    //put your code here
    private $id;
    private $nombre;
    private $apellido;
    private $tel;
    private $correo;
    private $celular;
    private $codCargo;
    private $idsede;
    private $idTipo;
    private $jefeACargo;
    private $password;
    private $imagen;
    
    function __construct($campo, $valor) {
        if ($campo!=null) {
            if (is_array($campo)) {
                $this->cargarObjetoDeVector($campo); 
            }else{
              $cadenaSQL="select * from persona where $campo=$valor";
              $resultado= ConectorBD::ejecutarQuery($cadenaSQL, 'eagle_admin');
              if(count($resultado)>0) $this->cargarObjetoDeVector($resultado[0]);
        }       
     }     
  }
    
    private function cargarObjetoDeVector($vector){
         
          $this->id=$vector[0];
          $this->nombre=$vector[1];
          $this->apellido=$vector[2];
          $this->tel=$vector[3];
          $this->correo=$vector[4];
          $this->celular=$vector[5];
          $this->codCargo=$vector[6];
          $this->idsede=$vector[7];
          $this->idTipo=$vector[8];
          $this->jefeACargo=$vector[9];
          $this->password=$vector[10];
          $this->imagen=$vector[11];
          
          
      }
      function getImagen() {
          return $this->imagen;
      }

      function setImagen($imagen) {
          $this->imagen = $imagen;
      }
          
    function getId() {
        return trim($this->id);        
    }

    function getNombre() {
            return $this->nombre;
    }

    function getApellido() {
          return $this->apellido;  
    }

    function getTel() {
           return $this->tel; 
    }

    function getCorreo() {
             return $this->correo;
    }

    function getCelular() {
           return $this->celular; 
    }

    function getCodCargo() {
            return $this->codCargo;
    }

    function getidsede() {
            return $this->idsede;
    }       

    function getIdTipo() {
            return $this->idTipo;
    }
    
    function IdTipo() {
        return $this->idTipo;       
    }

    function getJefeACargo() {
            return $this->jefeACargo;
    }

    function getPassword() {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setCodCargo($codCargo) {
        $this->codCargo = $codCargo;
    }

    function setidsede($idsede) {
        $this->idsede = $idsede;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    function setJefeACargo($jefeACargo) {
        $this->jefeACargo = $jefeACargo;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    
    public function __toString() {
        return trim($this->nombre)." ".trim($this->apellido);
    }

    public static function datos($filtro, $pagina, $limit){
         $cadenaSQL="select * from persona where identificacion<>'20000000' ".$filtro;
        if($limit!=null){
              $cadenaSQL.=" order by identificacion asc offset $pagina limit $limit ";
        }
    return ConectorBD::ejecutarQuery($cadenaSQL, 'eagle_admin');
    }
    

    public static function datosobjetos($filtro, $pagina, $limit){
        $datos= Persona::datos($filtro, $pagina, $limit);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $persona=new Persona($datos[$i],null);
            $lista[$i]=$persona;            
        }
    return $lista;
    }
    
     public static function listaopciones($filtro, $tipo, $predeterminado){ 
        $persona= Persona::datosobjetos($filtro, null);
        $lista="<datalist id='".$tipo."'>";        
        for ($i = 0; $i < count($persona); $i++) {
            $si=$persona[$i];
            if (trim($predeterminado)==trim($si->getid())) {
                $auxiliar= " selected='true' ";                
            }else{ 
                $auxiliar='';
            }
            $lista.="<option value='{$si->getId()}' $auxiliar >{$si->getNombre()}"." "."{$si->getApellido()}</option>";
        }
        $lista.="</datalist>";
        return $lista;
    }   
    
     public static function count($filtro) {
        return ConectorBD::ejecutarQuery("select count(*) from persona where identificacion<>'1085264553' ".$filtro, 'eagle_admin');        
     }
}
