<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConectorBD
 *
 * @author Galo
 */
class ConectorBD {
    private $controlador;
    private $servidor;
    private $puerto;
    private $bd;
    private $usuario;
    private $clave;
    public $conexion;
    
    function __construct() {
        $archivo = dirname(__FILE__) . "/../configuracion.ini";
        if (!file_exists($archivo)) {
            echo "ERROR!: No se encontró el archivo $archivo";
            die();
        }
        $parametros = parse_ini_file($archivo, true);
        if (!$parametros){ //si el archivo no contiene la estructura de un .ini: secciones en corchetes, llave = vr
            echo "ERROR!: No se pudo leer el archivo $archivo";
            die();
        }
        $this->controlador = $parametros['bd']['controlador'];
        $this->servidor = $parametros['bd']['servidor'];
        $this->puerto = $parametros['bd']['puerto'];
        $this->bd = $parametros['bd']['bd'];
        $this->usuario = $parametros['bd']['usuario'];
        $this->clave = $parametros['bd']['clave'];        
    }
    
    public function conectar($bd){
        try {
            if ($bd == null) $bd = $this->bd;            
            $this->conexion=new PDO("$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$bd",$this->usuario, $this->clave,array());
        } catch (Exception $exc) {
            //$this->conexion=null;
            echo "ERROR!: No se pudo conectar con la base de datos. Mensaje: " . $exc->getTraceAsString();
            die();
        }
    }
    
    public function desconectar(){
        $this->conexion=null;
    }
    
    public static function ejecutarQuery($cadenaSQL,$bd) {
        $conector=new ConectorBD();
        $conector->conectar($bd);
        $sentencia=$conector->conexion->prepare($cadenaSQL);
        if (!$sentencia->execute()){ //si hay error en el SQL devuelve falso
   echo "Error al ejecutar en $bd: $cadenaSQL. ";
            $conector->desconectar();
            return(false);
        } else {
            $resultado=$sentencia->fetchAll();
            $sentencia->closeCursor();
            $conector->desconectar();
            return($resultado);
        }
    }
    
    public static function ejecutarQueryMultiple($cadenaSQLMultiple,$bd){
        $conector=new ConectorBD();
        $conector->conectar($bd);
        $cadenaSQL= explode(';', $cadenaSQLMultiple);
        for ($i = 0; $i < count($cadenaSQL)-1; $i++) {
            $sentencia=$conector->conexion->prepare($cadenaSQL[$i]);
            if (!$sentencia->execute()) echo "Error al ejecutar en $bd: {$cadenaSQL[$i]}. <br/>";
        }                
        $conector->desconectar();
    }
}
