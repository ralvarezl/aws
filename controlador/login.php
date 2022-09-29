<?php
//Validacion para el login
if (!empty($_POST["btningresar"])){
   
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {//validacion que no existan campos vacios
        $usuario=$_POST["usuario"];     //Guardar usuario
        //$password=$_POST["password"];   //NO SE NECESITA EN ESTE MOMENTO
        $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario'and estado='a'"); //VALIDAR ESTADO
        if ($datos=$sql->fetch_object()) {
             //VALIDAR A LOS USUARIOS ADMINISTRADORES
            if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
            $usuario=$_POST["usuario"];     //Guardar usuario
            $password=$_POST["password"];   //Guardar password
            //VALIDAR DATOS DEL USUARIO Y SI ES ADMNISTRADOR
            $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario' and password='$password' and id_rol=1");
                if ($datos=$sql->fetch_object()) {
                    header("location:vista/administracion.php");//Entra al sistema de administrador.
                    }
            }   
                //VALIDAR A LOS USUARIOS DE FACTURACIÓN
                if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
                    $usuario=$_POST["usuario"];     //Guardar usuario
                    $password=$_POST["password"];   //Guardar password
                    //VALIDAR DATOS DEL USUARIO Y SI ES UN USUARIO DE FACTURACION
                    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario' and password='$password' and id_rol=2");
                    if ($datos=$sql->fetch_object()) {
                        header("location:vista/facturacion.php");//Entra al sistema de facturacion.
                    } else {
                        echo"<div class='alert alert-danger'>Acceso denegado</div>";    //Usuario o password incorrecto
                    }//CONTRASEÑA INCORRECTA FACTURACION
                    
                } else {
                    echo"<div class='alert alert-danger'>Acceso denegado</div>";  
                }//CONTRASEÑA INCORRECTA ADMINISTRADOR
        } else {
            echo"<div class='alert alert-warning'>Usuario Inactivo</div>";//Usuario o password incorrecto
        }
    }else {
        echo"<div class='alert alert-warning'>Favor Rellenar Campos</div>";//Falta rellenar campos
    }
   


    
    
}

?>