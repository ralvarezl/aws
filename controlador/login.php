<?php
//Funcion para validar campos vacios
function campo_vacio_login($usuario,$password,&$validar){
    if (!empty($_POST["usuario"] and $_POST["password"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que existe el usuario
function usuario_existe_login($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario no existe</div>"; //Usuario no existe
        return $validar;
    }
}
//Funcion para validar que la contraseña este bien
function contrasenia($password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where password='$password'");//Validar sea la contraseña sea la del usuario
    if ($datos=$sql->fetch_object()) {
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Acceso Denegado</div>"; //Contraseña erronea
        return $validar;
    }
}

//Funcion para validar el estado activo
function estado_usuario($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado
    if ($estado=='ACTIVO') { //si es activo 
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>USUARIO $estado</div>"; //Usuario no activo, bloqueado o nuevo
        return $validar;
    }
}

//Validar si usuario es defautl
function estado_usuario_default($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado
    if ($estado=='DEFAULT') { //si es activo 
        $validar=false;
        header("location:vista/login/cambiarpassword.php");//Entra a contestar preguntas
        return $validar;
    }else {
        return $validar;
    }
}

//Validar si usuario es nuevo
function estado_usuario_nuevo($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado
    if ($estado=='NUEVO') { //si es activo 
        $validar=false;
        header("location:vista/login/respuestas_usuario.php");//Entra a contestar preguntas
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para saber si es admnistrador
function administrador($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario' and password='$password' and id_rol=1"); //Consultar el rol del usuario
    if ($datos=$sql->fetch_object()) {
        header("location:vista/administracion/administracion_usuarios.php");//Entra al sistema de administrador.
        }else{
            $validar=false;
            return $validar; 
        }
}
//Funcion para saber si es empleado
function empleado($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario' and password='$password' and estado='ACIVO' and id_rol=2");
    if ($datos=$sql->fetch_object()) {
        header("location:vista/facturacion.php");//Entra al sistema de facturacion.
        }else{
            $validar=false;
            return $validar; 
        }
}

//Funcion para saber si el usuario esta en RESET
function usuario_resert($usuario, $password, &$validar){
    include "modelo/conexion.php";
        
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $id_usuario1=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_usuario='$id_usuario1' and parametro='Admin_Reset'");
    $row1=mysqli_fetch_array($sql1);
    $valor=$row1[0];
        
    if($valor=="RESET"){
        $validar=false;
        header("location:vista/login/cambiarpassword.php");
        return $validar; 
    }else{
        return $validar; 
    }
}

//Al presionar el boton
if (!empty($_POST["btningresar"])){
    $validar=true;
    $usuario=$_POST["usuario"];
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario'");
    $password=$_POST["password"];
   //validar campos vacios
    campo_vacio_login($usuario,$password,$validar);
        if($validar==true){
            //validar si existe usuario
            usuario_existe_login($usuario,$password,$validar);
            if($validar==true){
                //validar contraseña
                contrasenia($password,$validar);
                if($validar==true){
                    //validar estado
                    estado_usuario_default($usuario,$password,$validar);
                    if($validar==true){
                        estado_usuario_nuevo($usuario,$password,$validar);
                        if($validar==true){
                            estado_usuario($usuario,$password,$validar);
                                if($validar==true){
                                    //Dirigirlo dependiendo el tipo de usuario
                                    usuario_resert($usuario,$password,$validar);
                                        if($validar==true){
                                            //Si el usuario no es nuevo mandarlo al sistema
                                            administrador($usuario,$password,$validar);
                                            empleado($usuario,$password,$validar);
                                        }
                                }
                        }
                    }

                }
            }
        }
    
    
    
    
    
    
    
    
}
?>