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
        echo"<div class='alert alert-danger text-center'>Usuario / contraseña invalidos</div>"; //Usuario no existe
        return $validar;
    }
}
//Funcion para validar que la contraseña este bien
function contrasenia($usuario,$password,&$validar){
    include "modelo/conexion.php";
    //$sql=$conexion->query("select usuario from tbl_ms_usuario where password='$password'");//Validar sea la contraseña sea la del usuario

    $sql2=mysqli_query($conexion, "select password from tbl_ms_usuario where usuario='$usuario'");
    $row2=mysqli_fetch_array($sql2);
    $password_1=$row2[0];
    
    if ($password_1==$password) {
        return $validar;
    }else {
        $validar=false;
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
        echo"<div class='alert alert-danger text-center'>Acceso denegado, comuniquese con un administrador</div>"; //Usuario no activo, bloqueado o nuevo
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
    }else{
        return $validar;
    }
}

//Validar si usuario es nuevo
function estado_usuario_nuevo($usuario,$password,&$validar){
    include "modelo/conexion.php";

    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado

    if ($estado=='NUEVO'){ //si es activo 

        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];

        $sql_con=$conexion->query("select preguntas_contestadas from tbl_ms_usuario where usuario='$usuario' and id_usuario=$id_usuario"); //preguntar si el usuario tiene preguntas contestadas
        if ($datos=$sql->fetch_object()){
            //Modifiacmos cualquier estado a ACTIVO
            $modificar=("update tbl_ms_usuario set password='$password', estado='ACTIVO' where id_usuario='$id_usuario'");
            $resultado1 = mysqli_query($conexion,$modificar);
            return $validar;
        }else{
            $validar=false;
            header("location:vista/login/respuestas_usuario.php");//Entra a contestar preguntas
            return $validar;
        }
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
        
        //Sacar el id del usuario
        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];

        //Primer Ingreso
        $sql=mysqli_query($conexion, "select primer_ingreso from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $primer_ingreso=$row[0];
        //Si no tiene entonces actualizar su fecha
        if($primer_ingreso==''){
            $sql=$conexion->query(" update tbl_ms_usuario set primer_ingreso='$mifecha' where usuario='$usuario'");
        }


        header("location:vista/inicio/inicio.php");//Entra al sistema de administrador.
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

        //Primer Ingreso
        $sql=mysqli_query($conexion, "select primer_ingreso from tbl_ms_usuario where usuario='$usuario'");
        $row=mysqli_fetch_array($sql);
        $primer_ingreso=$row[0];
        //Si no tiene entonces actualizar su fecha
        if($primer_ingreso==''){
        $sql=$conexion->query(" update tbl_ms_usuario set primer_ingreso='$mifecha' where usuario='$usuario'");
        }

        header("location:vista/inicio/inicio.php");//Entra al sistema de facturacion.
        }else{
            $validar=false;
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
 
    //Comprobar numero de intentos
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
            //Sacar id del usuario
            $sql_user=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
            $row_user=mysqli_fetch_array($sql_user);
            $id_usuario=$row_user[0];
            //validar contraseña
            estado_usuario_bloquiado($usuario,$password,$validar);
            if($validar==true){    
                contrasenia($usuario,$password,$validar);
                if($validar==true){
                    //validar estado
                    //Si el usuario no es nuevo mandarlo al sistema
                    $intentos=0;
                    $_SESSION['usuario_login'] = $_REQUEST['usuario'];
                    estado_usuario_default($usuario,$password,$validar);
                    if($validar==true){
                        estado_usuario_nuevo($usuario,$password,$validar);
                        if($validar==true){
                            estado_usuario($usuario,$password,$validar);
                            if($validar==true){
                                //Validar el rol del usuario no sea default 
                                rol_usuario($usuario,$validar);
                                if($validar==true){
                                    //Dirigirlo dependiendo el tipo de usuario
                                    administrador($usuario,$password,$intentos,$validar);
                                    empleado($usuario,$password,$validar);
                                    //Guardar en bitacora 
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha = date('Y-m-d h:i:s');
                                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Login', 'Ingreso al sistema','$usuario')");
                                } 
                            }
                        } 
                    }     
                }else{ //Si la contraseña es incorrecta
                    if(isset($_SESSION["intentos"]) == true){
                        //Entonces que le sume uno
                        $_SESSION["intentos"]++;
                    }else{
                        // Si no existe que la cree
                        $_SESSION["intentos"] = 1;
                        
                    }
                    $intentos= $_SESSION["intentos"];
                    //Llama el valor de parametros de intentos
                    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='1'");
                    $row=mysqli_fetch_array($sql);
                    $valor=$row[0];
                    //Cuando los intentos llegan al valor limite del parametro se bloquea
                    if($intentos==$valor){
                    $modificar=("update tbl_ms_usuario set estado='BLOQUEADO' where id_usuario='$id_usuario'");
                    $resultado = mysqli_query($conexion,$modificar);
                    echo"<div class='alert alert-danger text-center'>Usuario Bloqueado, comuniquese con el administrador o haga cambio de contraseña</div>"; //Usuario bloqueado
                    }else{
                        //Intentos denegados
                        echo"<div class='alert alert-danger text-center'>Acceso denegado, intentos $intentos/$valor </div>";
                    }
           
                }
            }
        }
    }
}

//=================================BOTON SALIR=========================

if (!empty($_POST["btn_registrate"])){
    session_destroy();
}

?>