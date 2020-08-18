<?php

class Programa {

    public static function obtenerNivelesFormacion(){
        $lista= ConectorBD::ejecutarQuery("select trim(from nivel_formacion) nivel from programas group by 1 order by 1;", 'eagle_admin');
        return $lista;
    }

}