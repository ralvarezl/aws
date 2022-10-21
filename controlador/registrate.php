<?php
//Funcion para validar campos vacios
function campo_vacio_registrate($nombres,$usuario,$password,$r_password,$identidad,$genero,$telefono,$direccion,$correo,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["r_password"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que el usuario no exista
function usuario_existe_registrate($usuario,&$validar){
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

//Funcion Validar contraseña sea correta
function contrasenia($password,$r_password,&$validar){
    if($password===$r_password){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-warning text-center'>Ambas Contraseñas Deben Ser Iguales</div>";//CONTRASEÑAS DISTINTAS
        return $validar;
    }

}

//Validar contraseña robusta
function validar_password($password,&$validar){
    //validar tenga minusculas
    if (!preg_match('/[a-z]/',$password)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra minúscula</div>";
        //return $validar;
    } else {
        //Validar tenga mayusculas
        if (!preg_match('/[A-Z]/',$password)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra mayuscula</div>";
        } else{
            //Validar tenga numeros
            if (!preg_match('/[0-9]/',$password)){
                $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter numérico</div>"; 
            } else {
                //Validar tenga caracter especial
                if (!preg_match('/[^a-zA-Z\d]/',$password)){
                    $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter especial</div>"; 
                }else {
                    return $validar;
                }
            }
        }
    }
}

//Funcion para crear Usuario
function crear_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,&$validar){
    include "../../modelo/conexion.php";
    date_default_timezone_set("America/Tegucigalpa");
    $mifecha = date('Y-m-d');

    $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL 365 DAY)"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $fecha_vencimiento=$row[0];

    $sql=$conexion->query("INSERT INTO tbl_ms_usuario (nombres, identidad, usuario, password, genero, telefono, direccion, correo, creado_por, fecha_creacion, estado,id_rol,fecha_vencimiento) value ( '$nombres', '$identidad', '$usuario', '$password','$genero','$telefono','$direccion','$correo','$usuario','$mifecha','NUEVO', 3,'$fecha_vencimiento')");

    if ($sql==1) {
        header("location:respuestas_usuario.php");//Entra a contestar preguntas
        return $validar;
    } else {
        $validar=false;
        return $validar;
    }
}
/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////

//Validacion para el registro
if (!empty($_POST["btnregistrate"])){  
        session_start();
        $_SESSION['usuario_login'] = $_REQUEST['usuario'];

        $nombres=$_POST["nombres"];
        $identidad=$_POST["identidad"];
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $r_password=$_POST["r_password"];
        $correo=$_POST["correo"];
        $genero=$_POST["genero"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];
        $correo=$_POST["correo"];
        //Validar no hayan espacios vacios
        campo_vacio_registrate($nombres,$usuario,$password,$r_password,$identidad,$genero,$telefono,$direccion,$correo,$validar);
            if($validar==true){
                usuario_existe_registrate($usuario,$validar);
                if($validar==true){
                    contrasenia($password,$r_password,$validar);
                    if($validar==true){
                        validar_password($password,$validar);
                        if($validar==true){
                            crear_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$validar);
                        }
                    }
                }
            } 
}

?>