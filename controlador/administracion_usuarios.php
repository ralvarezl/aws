<?php
//session_start();
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Crear Nuevo Usuario
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
        $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL 365 DAY)"); //preguntar el estado del usuario
        $row=mysqli_fetch_array($sql);
        $fecha_vencimiento=$row[0];
        //Envio de los datos a ingresar por la query
        $sql=$conexion->query("insert into tbl_ms_usuario (nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, id_rol, fecha_creacion, fecha_vencimiento) values ('$nombres', '$usuario', '$password', '$identidad', '$genero' , '$telefono', '$direccion', '$correo' , '$estado' , '$id_rol' , '$mifecha','$fecha_vencimiento')");
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
    if (!empty($_POST["nombres"]) and !empty($_POST["usuario"]) and !empty($_POST["password"]) and !empty($_POST["identidad"]) and !empty($_POST["genero"]) and !empty($_POST["telefono"]) and !empty($_POST["direccion"]) and !empty($_POST["correo"]) and !empty($_POST["estado"]) and !empty($_POST["id_rol"])) {
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
        //Zona horaria de honduras
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        //Envio de los datos a ingresar por la query
        $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', usuario='$usuario', password='$password', identidad='$identidad', genero='$genero', telefono='$telefono', direccion='$direccion', correo='$correo', estado='$estado', id_rol='$id_rol', fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        if ($sql==1) {
            header("location:administracion_usuarios.php");
            //echo '<div class="alert alert-success">Usuario actualizado correctamente</div>';//Usuario ingresado
        } else {
            echo '<div class="alert alert-danger">Error al actualizar el usuario</div>';//Error al ingresar usuario
        }

    } else {
        echo '<div class="alert alert-warning">Favor llenar todos los campos</div>';//Campos vacios
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Eliminar Usuario
if (!empty($_POST["btnborrar"])) {
    if (!empty($_GET["id_usuario"])) {
        $id_usuario=$_GET["id_usuario"];
        $sql=$conexion->query(" delete from tbl_ms_usuario where id_usuario=$id_usuario ");
        if ($sql==1) {
            echo '<div class="alert alert-danger">Usuario Eliminado Correctamente</div>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el usuario</div>';
        }
        
    }
}

?>