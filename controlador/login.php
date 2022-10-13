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
function contrasenia($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where password='$password'");//Validar sea la contraseña sea la del usuario
    if ($datos=$sql->fetch_object()) {
        return $validar;
    }else {
        $validar=false;

        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];

        $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
        $row=mysqli_fetch_array($sql);
        $valor=$row[0];
        
        if($valor<1){
            echo"<div class='alert alert-danger text-center'>Acceso Denegado, restan 2 intentos</div>"; //Contraseña erronea
            $contador=$valor;
            $contador=($contador+1);

            $modificar=("update tbl_ms_parametros set valor='$contador' where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
            $resultado = mysqli_query($conexion,$modificar);
            
        }elseif($valor==1){
            echo"<div class='alert alert-danger text-center'>Te queda un intento antes que tu usuario sea bloqueado</div>"; //Usuario bloqueado
            $contador=$valor;
            $contador=($contador+1);

            $modificar=("update tbl_ms_parametros set valor='$contador' where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
            $resultado = mysqli_query($conexion,$modificar);
        }elseif($valor==2){
            echo"<div class='alert alert-danger text-center'>Usuario Bloqueado, comuniquese con el administrador o haga cambio de contraseña</div>"; //Usuario bloqueado

            $contador=$valor;
            $contador=($contador+1);

            $modificar=("update tbl_ms_parametros set valor='$contador' where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
            $resultado = mysqli_query($conexion,$modificar);

            $modificar1=("update tbl_ms_usuario set estado='BLOQUEADO' where id_usuario='$id_usuario'");
            $resultado1 = mysqli_query($conexion,$modificar1);
        }elseif($valor>2){
            echo"<div class='alert alert-danger text-center'>Usuario Bloqueado, comuniquese con el administrador o haga cambio de contraseña</div>"; //Usuario bloqueado
            //echo "$valor";
        }
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

//Funcion para validar el rol default
function rol_usuario($usuario,&$validar){
    include "modelo/conexion.php";
    $sql=mysqli_query($conexion, "select r.rol  from tbl_ms_usuario u join tbl_ms_roles r on r.id_rol=u.id_rol where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $rol=$row[0]; //Guardamos el estado
    if ($rol=='SIN ASIGNAR') { //si es activo 
        $validar=false;
        echo"<div class='alert alert-danger text-center'>ROL $rol, COMUNIQUESE CON UN ADMINISTRADOR</div>"; //Usuario no activo, bloqueado o nuevo
        return $validar;
    }else {
        
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
        include "modelo/conexion.php";
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        $sql=$conexion->query(" update tbl_ms_usuario set fecha_ultima_conexion='$mifecha' where usuario='$usuario'");
            
        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];

        //Modificamos el parametro adminintentos en la tabla TBL_MS_PARAMETRO
        $modificar2=("update tbl_ms_parametros set valor='0' where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
        $resultado2 = mysqli_query($conexion,$modificar2);

        header("location:vista/administracion/administracion_usuarios.php");//Entra al sistema de administrador.
        }else{
            $validar=false;
            return $validar; 
        }
}
//Funcion para saber si es empleado
function empleado($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario' and password='$password' and id_rol=2");
    if ($datos=$sql->fetch_object()) {
        include "modelo/conexion.php";
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        $sql=$conexion->query(" update tbl_ms_usuario set fecha_ultima_conexion='$mifecha' where usuario='$usuario'");

        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];
        
        //Modificamos el parametro adminintentos en la tabla TBL_MS_PARAMETRO
        $modificar2=("update tbl_ms_parametros set valor='0' where id_usuario='$id_usuario' and parametro='ADMIN_INTENTOS'");
        $resultado2 = mysqli_query($conexion,$modificar2);

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
//validar que el estado este bloqueado
function estado_usuario_bloquiado($usuario,$password,&$validar){
    include "modelo/conexion.php";
    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado
    if ($estado=='BLOQUEADO') { //si es activo 
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario Bloqueado, comuniquese con el administrador o haga cambio de contraseña</div>"; //Usuario bloqueado
        return $validar;
    }else {
        return $validar;
    }
}

/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////


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
                contrasenia($usuario,$password,$validar);
                if($validar==true){
                    //validar estado
                    estado_usuario_default($usuario,$password,$validar);
                    if($validar==true){
                        estado_usuario_nuevo($usuario,$password,$validar);
                        if($validar==true){
                            estado_usuario_bloquiado($usuario,$password,$validar);
                            if($validar==true){
                                estado_usuario($usuario,$password,$validar);
                                if($validar==true){
                                    //Validar el rol del usuario no sea default 
                                    rol_usuario($usuario,$validar);
                                    if($validar==true){
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
            }
        }
    
    
    
    
    
    
    
    
}
?>