<?php
//Validacion para el registro
if (!empty($_POST["btnregistrate"])){
    //VALIDAR QUE TODOS LOS CAMPOS ESTEN RELLENADOS
    if (!empty($_POST["nombres"]) and !empty($_POST["identidad"]) and !empty($_POST["usuario"]) and !empty($_POST["password"]) and !empty($_POST["r_password"]) and !empty($_POST["correo"])) {
        $nombres=$_POST["nombres"];
        $identidad=$_POST["identidad"];
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $r_password=$_POST["r_password"];
        $correo=$_POST["correo"];
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        //VERIFICAR QUE LAS CONTRASEÑAS SEAN IGUALES
        if ($password === $r_password){
            //MANDAR LA INFORMACIÓN DE LOS CAMPOS
            $sql=$conexion->query("INSERT INTO tbl_ms_usuario (nombres, identidad, usuario, password, correo, fecha_creacion) value ( '$nombres', '$identidad', '$usuario', '$password','$correo','$mifecha')");

            echo"<div class='alert alert-warning'>Usuario Creado Exitosamente</div>";//CREACIÓN EXITOSA
        }else{
            echo"<div class='alert alert-warning'>Ambas Contraseñas Deben Ser Iguales</div>";//CONTRASEÑAS DISTINTAS
        }
       
        
    }else{
        echo"<div class='alert alert-warning'>Favor Rellenar Campos </div>";//TIENE CAMPOS VACIOS
    }
   
}

?>