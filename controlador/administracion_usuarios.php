<?php
session_start();
//Validacion Creacion de un nuevo usuario*****************************************************
if (!empty($_POST["btnregistrar"])) {
    //Validar que no hayan campos vacios
    if (!empty($_POST["nombres"]) and !empty($_POST["usuario"]) and !empty($_POST["password"]) and !empty($_POST["identidad"]) and !empty($_POST["genero"]) and !empty($_POST["telefono"]) and !empty($_POST["direccion"]) and !empty($_POST["correo"]) and !empty($_POST["estado"]) and !empty($_POST["id_rol"])) {
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
        //Zona horaria de honduras
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        //Envio de los datos a ingresar por la query
        $sql=$conexion->query("insert into tbl_ms_usuario (nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, id_rol, fecha_creacion) values ('$nombres', '$usuario', '$password', '$identidad', '$genero' , '$telefono', '$direccion', '$correo' , '$estado' , '$id_rol' , '$mifecha')");
        if ($sql==1) {
            echo '<div class="alert alert-success">Usuario registrado correctamente</div>';//Usuario ingresado
        } else {
            echo '<div class="alert alert-danger">Error al registrar usuario</div>';//Error al ingresar usuario
            
        }
        
    } else {
        echo '<div class="alert alert-warning">Favor llenar todos los campos</div>';//Campos vacios
    }
    
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Actualizar Datos de Usuario
if (!empty($_POST["btnactualizar"])) {


}

?>