<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meta
 *
 * @author FELIP
 */
class Meta {
    //put your code here
    private $id;        
    private $anio;         
    private $nombre_tipo;    
    private $aprediz_activo; 
    private $meta_concertada; 
    private $meta_nacional;
    private $sede;
    
    function __construct($campo, $valor) {
        if ($campo!=null){
            if (is_array($campo)) {
                $this->objeto($campo);
            }else{
                $cadenaSQL="select * from meta where $campo = $valor";
                $respuesta= ConectorBD::ejecutarQuery($cadenaSQL, null);
                if ($respuesta>0 || $valor!=null) $this->objeto ($respuesta[0]);
            }
        }
    }

    private function objeto($vector){
        $this->id=$vector[0];
        $this->anio=$vector[1];
        $this->nombre_tipo=$vector[2];
        $this->aprediz_activo=$vector[3];
        $this->meta_concertada=$vector[4];
        $this->meta_nacional=$vector[5];
        $this->sede=$vector[6];
    }
    function getSede() {
        return $this->sede;
    }

    function setSede($sede){
        $this->sede = $sede;
    }

    function getId() {
        return $this->id;
    }

    function getAnio() {
        return $this->anio;
    }

    function getNombre_tipo() {
        return $this->nombre_tipo;
    }

    function getAprediz_activo() {
        return $this->aprediz_activo;
    }

    function getMeta_concertada() {
        return $this->meta_concertada;
    }

    function getMeta_nacional() {
        return $this->meta_nacional;
    }

    function setId($id){
        $this->id = $id;
    }

    function setAnio($anio){
        $this->anio = $anio;
    }

    function setNombre_tipo($nombre_tipo){
        $this->nombre_tipo = $nombre_tipo;
    }

    function setAprediz_activo($aprediz_activo){
        $this->aprediz_activo = $aprediz_activo;
    }

    function setMeta_concertada($meta_concertada){
        $this->meta_concertada = $meta_concertada;
    }

    function setMeta_nacional($meta_nacional){
        $this->meta_nacional = $meta_nacional;
    }
    
     public static function datos($filtro, $pagina ){
        $cadenaSQL="select * from meta ";
        if($filtro!=null){
              $cadenaSQL.=" where $filtro ";
        }
        return ConectorBD::ejecutarQuery($cadenaSQL, null);          
    }
    
    public static function datosobjetos($filtro, $pagina){
        $datos= Meta::datos($filtro, $pagina);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $meta=new Meta($datos[$i], null);
            $lista[$i]=$meta;
        }
        return $lista;
    }
    public function grabar() {
        $sql="insert into meta(anio,nombre_tipo,aprediz_activo,meta_concertada,meta_nacional, sede) values('$this->anio', '$this->nombre_tipo', $this->aprediz_activo, $this->meta_concertada, $this->meta_nacional, '$this->sede')";
        ConectorBD::ejecutarQuery($sql, null);
    }
}
