<?php

//Validacion Creacion de un nuevo usuario
if (!empty($_POST["btnguardar"])){
    //VALIDAR QUE TODOS LOS CAMPOS ESTEN RELLENADOS
    if (!empty($_POST["nombres"]) and !empty($_POST["usuario"]) and !empty($_POST["password"]) and !empty($_POST["identidad"]) and !empty($_POST["telefono"]) and !empty($_POST["direccion"]) and !empty($_POST["correo"])) {
        $nombres=$_POST["nombres"];
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $identidad=$_POST["identidad"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];
        $correo=$_POST["correo"];
                
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        //MANDAR LA INFORMACIÓN DE LOS CAMPOS
        $sql=$conexion->query("INSERT INTO tbl_ms_usuario (nombres, usuario, password, identidad, telefono, direccion, correo, fecha_creacion) value ( '$nombres', '$usuario', '$password','$identidad', '$telefono', '$direccion', '$correo', '$mifecha')");

        echo"<div class='alert alert-warning'>Usuario Creado Exitosamente</div>";//CREACIÓN EXITOSA
              
        
    }else{
        echo"<div class='alert alert-warning'>Favor Rellenar Campos </div>";//TIENE CAMPOS VACIOS
    }
   
}

?>