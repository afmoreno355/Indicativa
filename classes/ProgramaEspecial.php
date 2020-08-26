<?php

class ProgramaEspecial {

    private $id; 
    private $codigo; 
    private $nombre;

    public function __construct() {
        // allocate your stuff
    }

    public static function conID( $id ) {
        $instance = new self();
        $instance->cargarPorID( $id );
        return $instance;
    }

    public static function conFila( array $row ) {
        $instance = new self();
        $instance->llenar( $row );
        return $instance;
    }

    protected function cargarPorID( $id ) {
        // do query
        $cadenaSQL="select * from programa_especial where id = $id LIMIT 1";
        $resultado= ConectorBD::ejecutarQuery($cadenaSQL, 'eagle_admin');
        if(count($resultado)>0) $this->llenar( $resultado[0] );
    }

    protected function llenar( array $fila ) {
        // fill all properties from array
        $this->id = $fila[0]; 
        $this->codigo = $fila[1]; 
        $this->nombre = $fila[2]; 
    }

    public static function obtenerLista(){
        $cadenaSQL="select * from programa_especial";
        $datos = ConectorBD::ejecutarQuery($cadenaSQL, 'eagle_admin');
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]= self::conFila($datos[$i]);
        }
        return $lista;
    }

    function GetId() {
        return $this->id;
    }

    function GetNombre() {
        return $this->nombre;
    }

}

?>