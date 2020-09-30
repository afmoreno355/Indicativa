<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Indicativa
 *
 * @author FELIPE
 */
class Indicativa {
   private $id_indicativa;
   private $cod_centro;
   private $vigencia ;
   private $oferta;
   private $id_programa;
   private $inicio;
   private $cupos;
   private $municipio;
   private $anio_termina;
   private $curso;
   private $ambiente_requiere;
   private $gira_tecnica;
   private $programa_fic;
   private $id_modalidad;
   private $formacion;
   private $identificacion;
   private $fecha;
   private $validar;
   
   function __construct($campo, $valor) {
        if ($campo!=null) {
            if (is_array($campo)) {
                $this->cargarObjetoDeVector($campo); 
            }else{
                $cadenaSQL="select * from indicativa where $campo=$valor";
                $resultado= ConectorBD::ejecutarQuery($cadenaSQL, null);
                if(count($resultado)>0) $this->cargarObjetoDeVector($resultado[0]);
            }       
        }     
    }    
    
    private function cargarObjetoDeVector($vector){
         
          $this->id_indicativa=$vector[0];
          $this->cod_centro=$vector[1];
          $this->vigencia=$vector[2];
          $this->oferta=$vector[3];
          $this->id_programa=$vector[4];
          $this->inicio=$vector[5];
          $this->cupos=$vector[6];
          $this->municipio=$vector[7];
          $this->anio_termina=$vector[8];
          $this->curso=$vector[9];
          $this->ambiente_requiere=$vector[10];
          $this->gira_tecnica=$vector[11];
          $this->programa_fic=$vector[12];
          $this->id_modalidad=$vector[13];
          $this->formacion=$vector[14];
          $this->identificacion=$vector[15];
          $this->fecha=$vector[16];
          $this->validar=$vector[17];
    }
    
    function getValidar() {
        return $this->validar;
    }

    function setValidar($validar){
        $this->validar = $validar;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function getFormacion() {
        return $this->formacion;
    }

    function setFormacion($formacion) {
        $this->formacion = $formacion;
    }

    function getId_modalidad() {
        return $this->id_modalidad;
    }
    
    function Id_modalidad() {
        return ConectorBD::ejecutarQuery("select metodologia from modalidad where id_metod=$this->id_modalidad", 'registro')[0][0];
    }

    function setId_modalidad($id_modalidad){
        $this->id_modalidad = $id_modalidad;
    }

    function getId_indicativa() {
        return $this->id_indicativa;
    }

    function getCod_centro() {
        return $this->cod_centro;
    }

    function getVigencia() {
        return $this->vigencia;
    }

    function getOferta() {
        return $this->oferta;
    }

    function getId_programa() {
        return $this->id_programa;
    }
    
    function Id_programa() {
        return ConectorBD::ejecutarQuery("select nombre_programa from programas where id_programa='$this->id_programa'", 'eagle_admin')[0][0];
    }

    function getInicio() {
        return $this->inicio;
    }

    function getCupos() {
        return $this->cupos;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function getAnio_termina() {
        return $this->anio_termina;
    }

    function getCurso() {
        return $this->curso;
    }

    function getAmbiente_requiere() {
        return $this->ambiente_requiere;
    }

    function getGira_tecnica() {
        return $this->gira_tecnica;
    }

    function getPrograma_fic() {
        return $this->programa_fic;
    }

    function setId_indicativa($id_indicativa){
        $this->id_indicativa = $id_indicativa;
    }

    function setCod_centro($cod_centro){
        $this->cod_centro = $cod_centro;
    }

    function setVigencia($vigencia){
        $this->vigencia = $vigencia;
    }

    function setOferta($oferta){
        $this->oferta = $oferta;
    }

    function setId_programa($id_programa){
        $this->id_programa = $id_programa;
    }

    function setInicio($inicio){
        $this->inicio = $inicio;
    }

    function setCupos($cupos){
        $this->cupos = $cupos;
    }

    function setMunicipio($municipio){
        $this->municipio = $municipio;
    }

    function setAnio_termina($anio_termina){
        $this->anio_termina = $anio_termina;
    }

    function setCurso($curso){
        $this->curso = $curso;
    }

    function setAmbiente_requiere($ambiente_requiere){
        $this->ambiente_requiere = $ambiente_requiere;
    }

    function setGira_tecnica($gira_tecnica){
        $this->gira_tecnica = $gira_tecnica;
    }

    function setPrograma_fic($programa_fic){
        $this->programa_fic = $programa_fic;
    }

    public static function datos($filtro, $pagina, $limit){
        $cadenaSQL="select * from indicativa ";
        if ($filtro!='') {
            $cadenaSQL.=" where ".$filtro;
        }
        $cadenaSQL.=" order by validar, id_indicativa desc offset $pagina limit $limit ";
        return ConectorBD::ejecutarQuery($cadenaSQL, null);          
    }
    
    public static function datosobjetos($filtro, $pagina, $limit){
            $datos= Indicativa::datos($filtro, $pagina, $limit);
            $lista=array();
            for ($i = 0; $i < count($datos); $i++) {
                $indicativa=new Indicativa($datos[$i], null);
                $lista[$i]=$indicativa;
            }
            return $lista;
    }
    
    public static function count($filtro) {
        $cadena='select count(*) from indicativa'; 
        if($filtro!=''){
            $cadena.=" where $filtro";
        }
    return ConectorBD::ejecutarQuery($cadena, null); 
    }  
    
    public static function listacentros(){
    $lista='';
        $si= ConectorBD::ejecutarQuery("select codigosede,nombresede,bd,imagen,nom_departamento from  sede, departamento where departamento.id=sede.departamento", 'eagle_admin');
        for ($i = 0; $i < count($si); $i++) {
            $lista.="<option value='{$si[$i][0]}'> {$si[$i][4]} {$si[$i][0]} {$si[$i][1]}</option>";
        }
    return $lista;   
    }
    
    public static function listadepartamentos($municipio){
    $departamento= ConectorBD::ejecutarQuery("select departamento.id from municipio, departamento where municipio.id_departamento=departamento.id and municipio.id=$municipio;", "eagle_admin")[0][0];    
    $lista="<option value=''>DEPARTAMENTOS </option>";
        $si= ConectorBD::ejecutarQuery("select * from departamento", 'eagle_admin');
        for ($i = 0; $i < count($si); $i++) {
             $selected='';
            if($departamento==$si[$i][0]){
                  $selected='selected';
            }
            $lista.="<option value='{$si[$i][0]}' $selected> {$si[$i][1]}</option>";
        }
    return $lista;   
    }
    
    public static function listaprogramas($centro){
        $lista='';
        $tecnologos= ConectorBD::ejecutarQuery("select id_programa,nombre_programa,nivel_formacion,duracion, denominacion_programa, metodologia from lugar_desarrollo, resoluciones,modalidad, dblink('dbname=eagle_admin port=5432 user=felipe password=123' , 'select id_programa,nombre_programa,nivel_formacion,duracion from programas') as t2  (id_programa text,nombre_programa text,nivel_formacion text,duracion text ) where modalidad=id_metod and id_programa=denominacion_programa and resoluciones.id_resolucion=lugar_desarrollo.id_resolucion and lugar_desarrollo.id_sede='$centro' and lugar_desarrollo.resuelve='OTORGAMIENTO' and fecha_resolucion::date+'7 year'::interval >= 'now()'  group by id_programa,nombre_programa,nivel_formacion,duracion, denominacion_programa, metodologia;",'registro');
        for ($j = 0; $j < count($tecnologos); $j++) {
            $lista.="<option value='{$tecnologos[$j][0]}'>{$tecnologos[$j][5]} {$tecnologos[$j][1]} {$tecnologos[$j][2]}</option>";
        }
        $si= ConectorBD::ejecutarQuery("select id_programa,nombre_programa,nivel_formacion,duracion from  programas where nivel_formacion<>'TECNOLOGIA' and nivel_formacion<>'ESPECIALIZACION TECNOLOGICA'", 'eagle_admin');
        for ($i = 0; $i < count($si); $i++) {
            $lista.="<option value='{$si[$i][0]}'> {$si[$i][1]} {$si[$i][2]}</option>";
        }
    return $lista;   
    }
    
    public static function listames($mes, $virtual){
        
     $lista="<option value=''> MES INICIO </option>";
     if($virtual!=3){
            $lista.="<optgroup label='PRIMER TRIMESTRE'>";
            $lista.=($mes==1) ? "<option value='1' selected > ENERO </option>" : "<option value='1'> ENERO </option>";
            $lista.=($mes==2) ? "<option value='2' selected > FEBRERO </option>" : "<option value='2'> FEBRERO </option>";
            $lista.=($mes==3) ? "<option value='3' selected > MARZO </option>" : "<option value='3'> MARZO </option>";
            $lista.="/<optgroup>";
     }
     $lista.="<optgroup label='SEGUNDO TRIMESTRE'>";
     $lista.=($mes==4) ? "<option value='4' selected > ABRIL </option>" : "<option value='4'> ABRIL </option>";
     $lista.=($mes==5) ? "<option value='5' selected > MAYO </option>" : "<option value='5'> MAYO </option>";
     $lista.=($mes==6) ? "<option value='6' selected > JUNIO </option>" : "<option value='6'> JUNIO </option>";
     $lista.="/<optgroup>";
     $lista.="<optgroup label='TERCER TRIMESTRE'>";
     $lista.=($mes==7) ? "<option value='7' selected > JULIO </option>" : "<option value='7'> JULIO </option>";
     $lista.=($mes==8) ? "<option value='8' selected > AGOSTO </option>" : "<option value='8'> AGOSTO </option>";
     $lista.=($mes==9) ? "<option value='9' selected > SEPTIEMBRE </option>" : "<option value='9'> SEPTIEMBRE </option>";
     $lista.="/<optgroup>";
     $lista.="<optgroup label='CUARTO TRIMESTRE'>";
     $lista.=($mes==10) ? "<option value='10' selected > OCTUBRE </option>" : "<option value='10'> OCTUBRE </option>";
     $lista.=($mes==11) ? "<option value='11' selected > NOVIEMBRE </option>" : "<option value='11'> NOVIEMBRE </option>";
     $lista.=($mes==12) ? "<option value='12' selected > DICIEMBRE </option>" : "<option value='12'> DICIEMBRE </option>";
     $lista.="/<optgroup>";
    
        
    return $lista;   
    }
    
    public function Adicionar() {
        $sql="insert into indicativa(cod_centro,  vigencia,  oferta,  id_programa, inicio, cupos, municipio, anio_termina,
              curso, ambiente_requiere, gira_tecnica, programa_fic, id_modalidad, formacion, identificacion, fecha, validar) values(
                '$this->cod_centro',
                '$this->vigencia',
                 $this->oferta,
                '$this->id_programa',
                 $this->inicio,
                 $this->cupos,
                 $this->municipio,
                '$this->anio_termina',
                '$this->curso',
                '$this->ambiente_requiere',
                '$this->gira_tecnica',
                '$this->programa_fic',
                 $this->id_modalidad,
                '$this->formacion', 
                '$this->identificacion', 
                '$this->fecha',
                ''
             )";
    ConectorBD::ejecutarQuery($sql, null);
    }
    
    public function Modificar() {
        $sql="update indicativa set
                cod_centro='$this->cod_centro',
                vigencia='$this->vigencia',
                oferta=$this->oferta,
                id_programa='$this->id_programa',
                inicio=$this->inicio,
                cupos=$this->cupos,
                municipio=$this->municipio,
                anio_termina='$this->anio_termina',
                curso='$this->curso',
                ambiente_requiere='$this->ambiente_requiere',
                gira_tecnica='$this->gira_tecnica',
                programa_fic='$this->programa_fic',
                id_modalidad=$this->id_modalidad,
                formacion='$this->formacion', 
                identificacion='$this->identificacion', 
                validar=''
                where id_indicativa=$this->id_indicativa";
    ConectorBD::ejecutarQuery($sql, null);
    }
    
    public function Eliminar() {
        $sql="delete from indicativa where id_indicativa=$this->id_indicativa";
    ConectorBD::ejecutarQuery($sql, null);
    }
    
    public function Enviar($id) {
        $sql="update indicativa set validar ='". trim($id)."' where id_indicativa=$this->id_indicativa";
    ConectorBD::ejecutarQuery($sql, null);
    }
    
    public static function encryptIt($q) {
        $qEncoded  = base64_encode($q);
        return( $qEncoded );
    }
    
    public static function decryptIt($q) {
        $qDecoded = base64_decode($q);
        $nuevoArray=[];
        $cortarCadena= explode('&', $qDecoded);
        for ($i = 0; $i < count($cortarCadena); $i++) {
            list($nombre, $valor)= explode("=", $cortarCadena[$i]);
            $nuevoArray += [$nombre => $valor];        
        }
        return $nuevoArray;
    }
}
