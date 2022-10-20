<?php

//Funcion para validar campos vacios
function campo_vacio($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"] and $_POST["id_rol"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar campos vacios en actualizar
function campo_vacio_actualizar($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"] and $_POST["estado"] and $_POST["id_rol"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que el usuario no exista
function usuario_existe($usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Usuario existente</div>"; //Usuario no existe
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para insertar los registros
function usuario_crear($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,&$validar){
    include "../../modelo/conexion.php";
    date_default_timezone_set("America/Tegucigalpa");
                $mifecha = date('Y-m-d');
                $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL 365 DAY)"); //Fecha de Vencimiento
                $row=mysqli_fetch_array($sql);
                $fecha_vencimiento=$row[0];
                //Envio de los datos a ingresar por la query
                $sql=$conexion->query("insert into tbl_ms_usuario (nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, id_rol, fecha_creacion, fecha_vencimiento) values ('$nombres', '$usuario', '$password', '$identidad', '$genero' , '$telefono', '$direccion', '$correo' , 'DEFAULT' , '$id_rol' , '$mifecha','$fecha_vencimiento')");
                if ($sql==1) {
                    include "../../modelo/conexion.php";
                    
                    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
                    $row=mysqli_fetch_array($sql);
                    $id_usuario=$row[0];

                    $insertar1=("insert into tbl_ms_parametros (PARAMETRO,VALOR,ID_USUARIO) VALUES( 'ADMIN_RESET','ACTIVO','$id_usuario')");
                    $resultado1 = mysqli_query($conexion,$insertar1);

                    $insertar2=("insert into tbl_ms_parametros (PARAMETRO,VALOR,ID_USUARIO) VALUES( 'ADMIN_INTENTOS','0','$id_usuario')");
                    $resultado2 = mysqli_query($conexion,$insertar2);

                    $insertar3=("insert into tbl_ms_parametros (PARAMETRO,VALOR,ID_USUARIO) VALUES( 'ADMIN_PREGUNTAS','0','$id_usuario')");
                    $resultado3 = mysqli_query($conexion,$insertar3);

                    return $validar;
                } else {
                    $validar=false;
                    return $validar;
                }
}

//Funcion para saber si cambio el usuario 
function usuario_modificado($usuario,$nombres,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$id_usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario' and id_usuario=$id_usuario");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        include "../../modelo/conexion.php";
        //Actualiza si no se cambio el usuario pero si los demas campos
        $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', password='$password', identidad='$identidad', genero='$genero', telefono='$telefono', direccion='$direccion', correo='$correo', estado='$estado', id_rol='$id_rol', fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        if ($sql==1) {
            header("location:administracion_usuarios.php");
            //echo '<div class="alert alert-success">Usuario actualizado correctamente</div>';//Usuario ingresado
        } else {
            echo '<div class="alert alert-danger text-center">Error al actualizar el usuario</div>';//Error al ingresar usuario
        }
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para actualizar con usuario
function actualizar_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$id_usuario,&$validar){
    
    date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        include "../../modelo/conexion.php";
        //Envio de los datos a ingresar por la query
        $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', usuario='$usuario',password='$password', identidad='$identidad', genero='$genero', telefono='$telefono', direccion='$direccion', correo='$correo', estado='$estado', id_rol='$id_rol', fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        if ($sql==1) {
            header("location:administracion_usuarios.php");
            //echo '<div class="alert alert-success">Usuario actualizado correctamente</div>';//Usuario ingresado
        } else {
            echo '<div class="alert alert-danger text-center">Error al actualizar el usuario</div>';//Error al ingresar usuario
        }
}
//Funcion para enviar el correo.
function Enviar_Correo($id_rol,$nombres,$usuario,$password,$correo,&$validar){
    require_once ("../../PHPMailer/clsMail.php");
    include "../../modelo/conexion.php";

    $mailSend = new clsMail();
 
    $sql=mysqli_query($conexion, "select rol from tbl_ms_roles where id_rol='$id_rol'");
    $row=mysqli_fetch_array($sql);
    $rol=$row[0];
    
    $titulo="Usuario Nuevo";  
    $asunto="Usuario y contraseña - Sistema de Usuarios";
    $bodyphp="Estimad@ ". $nombres.": <br/><br/> Se le a registrado en el sistema Andre's Coffee <br/><br/>Su USUARIO es: ".$usuario." y su contraseña temporal es: ".$password."<br/><br/> Favor ingrese al sistema para hacer el cambio de su contraseña y configurar su usuario.";
    
    $enviado = $mailSend->metEnviar($titulo,$usuario,$correo,$asunto,$bodyphp);
             
    if($enviado){
        return $validar;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La direccion de correo electronico no existe o no tienes.</div>';
        return $validar;
    }
}

/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////

//Crear Nuevo Usuario Al Presionar Boton
if (!empty($_POST["btnregistrar"])) {
    $validar=true;
    $nombres=$_POST["nombres"];
    $usuario=$_POST["usuario"];
    $password=$_POST["password"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];
    $direccion=$_POST["direccion"];
    $correo=$_POST["correo"];
    $id_rol=$_POST["id_rol"];
    //Validar que no hayan campos vacios
    campo_vacio($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,$validar);
        if($validar==true){
            usuario_existe($usuario,$validar);
            if($validar==true){Enviar_Correo($id_rol,$nombres,$usuario,$password,$correo,$validar);
                if($validar==true){
                    usuario_crear($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,$validar);
                    if($validar==true){
                        echo '<div class="alert alert-success text-center">Usuario registrado correctamente</div>';//Usuario ingresado 
                    }else{
                        echo '<div class="alert alert-danger text-center">Error al registrar usuario</div>';//Error al ingresar usuario
                    }
                }
            }
        }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//AL presionar el boton actualizar
if (!empty($_POST["btnactualizar"])) {
        $validar=true;
        $id_usuario=$_POST["id_usuario"];
        $nombres=$_POST["nombres"];
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $identidad=$_POST["identidad"];
        $genero=$_POST["genero"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];
        $correo=$_POST["correo"];
        $estado=$_POST["estado"];
        $id_rol=$_POST["id_rol"];

        //Validar que no hayan campos vacios
        campo_vacio_actualizar($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$validar);
        if($validar==true){
            usuario_modificado($usuario,$nombres,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$id_usuario,$validar);
            if($validar==true){
                usuario_existe($usuario,$validar);
                if($validar==true){
                    actualizar_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$id_usuario,$validar);
                }
            }
        }
}


if (!empty($_POST["btn_salir_administracion_usuarios"])) {
    session_destroy();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////

?>