<?php

class Complementaria {

    private $id; 
    private $cod_centro; 
    private $vigencia; 
    private $id_programa; 
    private $especialidad; 
    private $id_modalidad; 
    private $fecha_inicio; 
    private $oferta; 
    private $grupos; 
    private $mes_inicio; 
    private $mes_fin;
    private $programa_fic;
    private $validar;

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
        $cadenaSQL="select * from complementaria where id = $id LIMIT 1";
        $resultado= ConectorBD::ejecutarQuery($cadenaSQL, null);
        if(count($resultado)>0) $this->llenar( $resultado[0] );
    }

    protected function llenar( array $fila ) {
        // fill all properties from array
        $this->id = $fila[0]; 
        $this->cod_centro = $fila[1]; 
        $this->vigencia = $fila[2]; 
        $this->id_programa = $fila[3]; 
        $this->especialidad = $fila[4]; 
        $this->id_modalidad = $fila[5]; 
        $this->fecha_inicio = $fila[6]; 
        $this->oferta = $fila[7]; 
        $this->grupos = $fila[8]; 
        $this->mes_inicio = $fila[9]; 
        $this->mes_fin = $fila[10];
        $this->programa_fic = $fila[11];
        $this->validar = $fila[12];
    }

    public static function obtenerLista($filtro, $pagina, $limit){
        $cadenaSQL="select * from complementaria";
        if ($filtro!='') {
            $cadenaSQL.=" where ".$filtro;
        }
        $cadenaSQL.=" order by id desc offset $pagina limit $limit ";
        $datos = ConectorBD::ejecutarQuery($cadenaSQL, null);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]= self::conFila($datos[$i]);
        }
        return $lista;
    }

    public static function contar($filtro) {
        $cadena='select count(*) from complementaria'; 
        if($filtro!=''){
            $cadena.=" where $filtro";
        }
        return ConectorBD::ejecutarQuery($cadena, null); 
    }

    public static function getNombreMesInicio($mes){
        switch ($mes) {
            case 1:
               $valor='ENERO';
               break;
            case 2:
               $valor='FEBRERO';
               break;
            case 3: 
               $valor='MARZO';
               break;
            case 4: 
                $valor='ABRIL';
                break;
            case 5: 
                $valor='MAYO';
                break;
            case 6: 
                $valor='JUNIO';
                break;
            case 7: 
                $valor='JULIO';
                break;
            case 8: 
                $valor='AGOSTO';
                break;
            case 9: 
                $valor='SEPTIEMBRE';
                break;
            case 10: 
                $valor='OCTUBRE';
                break;
            case 11: 
                $valor='NOVIEMBRE';
                break;
            case 12: 
                $valor='DICIEMBRE';
                break;
        }
        return $valor;
    }
    
    /* Propiedades */
    function GetId() {
        return $this->id;
    }

    function GetNombrePrograma() {
        return ConectorBD::ejecutarQuery("select nombre_programa from programas where id_programa='$this->id_programa'", 'eagle_admin')[0][0];
    }

    function GetIdPrograma() {
        return $this->id_programa;
    }

    function GetCodigoCentro() {
        return $this->cod_centro;
    }

    function GetOferta() {
        return $this->oferta;
    }

    function GetGrupos() {
        return $this->grupos;
    }

    function GetMesInicio() {
        return $this->mes_inicio;
    }

    function GetMesFin() {
        return $this->mes_fin;
    }

    function GetProgramaFic() {
        return $this->programa_fic;
    }

    function GetValidar() {
        return $this->validar;
    }

}

?>