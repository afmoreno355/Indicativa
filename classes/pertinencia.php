<?php

/*Gildardo Restrepo
 * Tecnoparque Nodo Cali, 19 de agosto de 2020
 */

/**
 * Description of pertinencia
 *
 * @author Gildardo Restrepo
 */

class Pertinencia {   
    
    public static function pertinenciaQuery($cadenaSQL,$bd) {
        $conector=new ConectorBD();
        $conector->conectar($bd);
        $sentencia=$conector->conexion->prepare($cadenaSQL);
        if (!$sentencia->execute()){ //si hay error en el SQL devuelve falso
        //echo "Error al ejecutar en $bd: $cadenaSQL. ";
        
            $conector->desconectar();
            return(false);
        } else {
            $resultado=$sentencia->fetch();
            $sentencia->closeCursor();
            $conector->desconectar();
            return($resultado);
        }
    }
   
}
