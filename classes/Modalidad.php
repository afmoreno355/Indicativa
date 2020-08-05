<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modalidad
 *
 * @author FELIP
 */
class Modalidad {
    private $id_metod;
    private $metodologia;
    
    function __construct($campo, $valor) {
        if ($campo!=null) {
            if (is_array($campo)) {
                $this->cargarObjetoDeVector($campo); 
            }else{
                $cadenaSQL="select * from  modalidad where $campo=$valor";
                $resultado= ConectorBD::ejecutarQuery($cadenaSQL, 'registro');
                if(count($resultado)>0) $this->cargarObjetoDeVector($resultado[0]);
            }       
        }     
    }    
    
    private function cargarObjetoDeVector($vector){
          $this->id_metod=$vector[0];
          $this->metodologia=$vector[1];
    }
    
    function getId_metod() {
        return $this->id_metod;
    }

    function getMetodologia() {
        return $this->metodologia;
    }

    function setId_metod($id_metod){
        $this->id_metod = $id_metod;
    }

    function setMetodologia($metodologia) {
        $this->metodologia = $metodologia;
    }
    
    function __toString() {
        return $this->metodologia;
    }

    public static function datos($filtro, $pagina, $limit){
        $cadenaSQL="select * from modalidad ";
        if ($filtro!=null) {
            $cadenaSQL.=" where ".$filtro;
        }
        $cadenaSQL.=" order by id_metod asc offset $pagina limit $limit ";
        return ConectorBD::ejecutarQuery($cadenaSQL, 'registro');          
    }
    
    public static function datosobjetos($filtro, $pagina, $limit){
            $datos= Modalidad::datos($filtro, $pagina, $limit);
            $lista=array();
            for ($i = 0; $i < count($datos); $i++) {
                $modalidad =new Modalidad($datos[$i], null);
                $lista[$i]=$modalidad;
            }
            return $lista;
    }

    public static function lista($id) {
        $lista="<option value=''>MODALIDAD</option>";
        $datos= Modalidad::datosobjetos(null, 0, 100);
        for ($i = 0; $i < count($datos); $i++) {
            $obj=$datos[$i];
            if($obj->getId_metod()==$id){
                $seleccion='selected';
            }else{
                $seleccion='';
            }
            $lista.="<option value='{$obj->getId_metod()}' $seleccion>{$obj->getMetodologia()}</option>";
        }
        return $lista;
    }

}
