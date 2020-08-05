<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__FILE__)."/../../Librerias/src/Exception.php";
require_once dirname(__FILE__)."/../../Librerias/src/PHPMailer.php";
require_once dirname(__FILE__)."/../../Librerias/src/SMTP.php";
require_once dirname(__FILE__)."/../../classes/Meta.php";
require_once dirname(__FILE__).'/../../classes/ConectorBD.php';

foreach ($_POST as $key => $value) ${$key}=  $value;

date_default_timezone_set('America/Bogota');
$dateIndicativa= date('Y', time());

switch ($accionU){
    case 'ADICIONAR':
            $indicativa= new Indicativa(null,null);
            $indicativa->setCod_centro($cod_centro);
            $indicativa->setVigencia($vigencia) ;
            if($inicio>=1 && $inicio<=3){
                $oferta=1;
            }elseif($inicio>=4 && $inicio<=6){
                $oferta=2;
            }elseif($inicio>=7 && $inicio<=9){
                $oferta=3;
            }elseif($inicio>=10 && $inicio<=12){
                $oferta=4;
            }
            $indicativa->setOferta($oferta);
            $indicativa->setId_programa($id_programa);
            $indicativa->setInicio($inicio);
            $indicativa->setCupos($cupos);
            $indicativa->setMunicipio($municipio);
            $indicativa->setAnio_termina($anio_termina);
            $indicativa->setCurso($curso);
            $indicativa->setAmbiente_requiere($ambiente_requiere);
            $indicativa->setGira_tecnica($gira_tecnica);
            $indicativa->setPrograma_fic($programa_fic);
            $indicativa->setId_modalidad($id_modalidad);
            $indicativa->setFormacion($formacion);
            $indicativa->setIdentificacion($_SESSION['user']);
            $indicativa->setFecha(date("Y-m-d H:i:s",time()));
            $indicativa->Adicionar();
            $jornadasId=ConectorBD::ejecutarQuery("select id_indicativa from indicativa where cod_centro = '{$indicativa->getCod_centro()}' and "
                                                . "vigencia = '{$indicativa->getVigencia()}' and oferta = {$indicativa->getOferta()} and id_programa = '{$indicativa->getId_programa()}' "
                                                . "and inicio = {$indicativa->getInicio()} and cupos = {$indicativa->getCupos()} and municipio = {$indicativa->getMunicipio()} and anio_termina  = '{$indicativa->getAnio_termina()}' and "
                                                . "curso = {$indicativa->getCurso()} and ambiente_requiere = {$indicativa->getAmbiente_requiere()} and gira_tecnica = '{$indicativa->getGira_tecnica()}' and programa_fic = '{$indicativa->getPrograma_fic()}' and "
                                                . "id_modalidad = {$indicativa->getId_modalidad()} and formacion = '{$indicativa->getFormacion()}' and identificacion = '{$indicativa->getIdentificacion()}' and "
                                                . "fecha = '{$indicativa->getFecha()}'  order by id_indicativa desc limit 1", null);
            ConectorBD::ejecutarQuery("insert into jornada(madrugada, diurna, nocturna, mixta, id_indicativa) values({$cursos[1]},{$cursos[2]},{$cursos[3]},{$cursos[4]}, {$jornadasId[0][0]})", null);
            $_SESSION['aviso']="EL FORMULARIO FUE CREADO CON EXITO"; 
    header("location: index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php");
    break;    
    case 'MODIFICAR':
            $indicativa= new Indicativa(null,null);
            $indicativa->setId_indicativa($id_indicativa);
            $indicativa->setCod_centro($cod_centro);
            $indicativa->setVigencia($vigencia) ;
            if($inicio>=1 && $inicio<=3){
                $oferta=1;
            }elseif($inicio>=4 && $inicio<=6){
                $oferta=2;
            }elseif($inicio>=7 && $inicio<=9){
                $oferta=3;
            }elseif($inicio>=10 && $inicio<=12){
                $oferta=4;
            }
            $indicativa->setOferta($oferta);
            $indicativa->setId_programa($id_programa);
            $indicativa->setInicio($inicio);
            $indicativa->setCupos($cupos);
            $indicativa->setMunicipio($municipio);
            $indicativa->setAnio_termina($anio_termina);
            $indicativa->setCurso($curso);
            $indicativa->setAmbiente_requiere($ambiente_requiere);
            $indicativa->setGira_tecnica($gira_tecnica);
            $indicativa->setPrograma_fic($programa_fic);
            $indicativa->setId_modalidad($id_modalidad);
            $indicativa->setFormacion($formacion);
            $indicativa->setIdentificacion($_SESSION['user']);
            $indicativa->Modificar();
            ConectorBD::ejecutarQuery("update jornada set madrugada={$cursos[1]}, diurna={$cursos[2]}, nocturna={$cursos[3]}, mixta={$cursos[4]} where id_indicativa={$indicativa->getId_indicativa()}", null);
            $_SESSION['aviso']="EL FORMULARIO FUE MODIFICADO CON EXITO"; 
    header("location: index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php");
    break;  
    case 'BORRAR':
            ConectorBD::ejecutarQuery("delete from jornada where id_indicativa = $id_indicativa ", null);
            $indicativa= new Indicativa(null,null);
            $indicativa->setId_indicativa($id_indicativa);
            $indicativa->Eliminar();
            $_SESSION['aviso']="EL FORMULARIO FUE ELIMINADO CON EXITO"; 
    header("location: index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php");
    break;  
    case 'INDICATIVA':       
    
    session_start();
        
        $metas= new Meta(null, null);
        $metas->setAnio(($dateIndicativa+1));
        $metas->setNombre_tipo($nombre);
        $metas->setAprediz_activo($activos);
        $metas->setMeta_concertada($meta);
        $metas->setMeta_nacional(0);
        $metas->setSede($_SESSION['sede']);
        $metas->grabar();
        print_r("LA META REFERENTE A $nombre FUE AGREGADO       ");
    break;  
    case 'ENVIAR':
            $indicativa= new Indicativa(null,null);
            $indicativa->setId_indicativa($id_indicativa);
            if(ConectorBD::ejecutarQuery("select validar from indicativa where id_indicativa=$id_indicativa;", null)[0][0]==''){$enviarTex='F';} 
            elseif (ConectorBD::ejecutarQuery("select validar from indicativa where id_indicativa=$id_indicativa;", null)[0][0]=='F') {$enviarTex='E';};
            $indicativa->Enviar($enviarTex);
            $_SESSION['aviso']="EL FORMULARIO FUE ENVIADO CON EXITO"; 
            
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = "felipemorenor132@gmail.com";                 // SMTP username
            $mail->Password = 'juanfelipe1324';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('felipemorenor132@gmail.com', 'Felipe Moreno Riascos');
            ($enviarTex=='F')? $envioQ="select correoinstitucional from persona where (idtipo='IR' or idtipo='SA') and idsede = '{$_SESSION['sede']}' ":$envioQ="select correoinstitucional from persona where idtipo='AI' or idtipo='SA'";
            $personaMail= ConectorBD::ejecutarQuery( $envioQ , 'eagle_admin');
            for ($i = 0; $i < count($personaMail); $i++) {
                    $mail->addAddress("{$personaMail[$i][0]}", "Administradores de Modulo Indicativa");     // Add a recipient
            }

            /*Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content*/
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Asunto: Nueva Solicitud ';
            $mail->Body    = "<div style='background:gray; width:100%; height:auto; margin-top:50px; text-align:center; align-content:center; justify-content:center '><a href='http://direcciondeformacion.senaedu.edu.co/indicativa/index.php?CONTENIDO=View/Sede/Sede.php' style='cursor: pointer'><img src='http://direcciondeformacion.senaedu.edu.co/indicativa/img/logo/sena.png' width='80px' height='80px'/></a><p style='background:white; heiht: 20px; width:90%; margin-left:5%'>Tiene Solicitud Nueva en la Plataforma de Indicativa del Centro {$_SESSION['sede']}</p><div>";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
        echo 'El Mensaje Fue Enviado al Correo ';
        $_SESSION['aviso'].="<br>UN CORREO FUE ENVIADO AL ADMINISTRADOR DEL SISTEMA"; 
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } 
    header("location: index.php?CONTENIDO=View/CatalogoIndicativa/CatalogoIndicativa.php");
    break;    
}
