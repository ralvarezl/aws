<?php

//++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++/

//--validacion que no existan campos vacios
function Campo_vacio($password_usu,$nuevacontraseña,$confirmarcontraseña,&$validar){
    if (!empty($_POST["contraseñaanterior"] and $_POST["nuevacontraseña"] and $_POST["confirmarcontraseña"]) and $validar=true){ //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}

//Funcion para validar que existe el usuario
function usuario_existe_cambiar($usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario no existe</div>"; //Usuario no existe
        return $validar;
    }
}

//--validar la contraseña anterior
function Contraseña_Anterior($usuario,$password_usu,&$validar){
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select password from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $password_vieja=$row[0];

    if($password_usu==$password_vieja){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La Contraseña Anterio No Es Valida</div>"; //Campos sin uso
        return $validar;
    }

}

//Validar contraseña robusta
function validar_clave($nuevacontraseña,&$validar){
    //validar tenga minusculas
    if (!preg_match('/[a-z]/',$nuevacontraseña)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra minúscula</div>";
        return $validar;
    } else {
        //Validar tenga mayusculas
        if (!preg_match('/[A-Z]/',$nuevacontraseña)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra mayuscula</div>";
        } else{
            //Validar tenga numeros
            if (!preg_match('/[0-9]/',$nuevacontraseña)){
                $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter numérico</div>"; 
            } else {
                //Validar tenga caracter especial
                if (!preg_match('/[^a-zA-Z\d]/',$nuevacontraseña)){
                    $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter especial</div>"; 
                }else {
                    return $validar;
                }
            }
        }
    }
}

//--confirmar el password
function Comparar_Pass(&$validar){
    $nuevapassword=$_POST["nuevacontraseña"];
    $confirmarpassword=$_POST["confirmarcontraseña"];

    if($nuevapassword==$confirmarpassword){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Las Contraseñas No Coinciden</div>"; //Campos no coinciden
        return $validar;
    }
}

//--Contar la Cadena
function Contar_Cadena($nuevacontraseña,$confirmarcontraseña,&$validar){
    
    $Longitud1=strlen($nuevacontraseña);
    $Longitud2=strlen($confirmarcontraseña);
    if($Longitud1<=20 && $Longitud2<=20){
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña Muy Grande</div>"; //Campos sin uso
        return $validar;
    }
}

//--ver si hay espacios
function Validar_Espacio(/*$usuario, $password_usu,*/ $nuevacontraseña, $confirmarcontraseña, &$validar){
    if (ctype_graph (/*$usuario and $password_usu and*/ $nuevacontraseña and $confirmarcontraseña)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Campo Con Espacios No Validos</div>";
        return $validar;
    }else{
        return $validar;
    }
}

//=================================BOTON DE GUARDAR CONTRASEÑA=========================


if (!empty($_POST["btnnuevacontraseña"])){
    session_destroy();
    date_default_timezone_set("America/Tegucigalpa");
    $fecha_actual=date("Y-m-d");
    $errors = array();
    $validar=true;
    $usuario=$_POST["usuario"];
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario'");
    $nuevacontraseña=$_POST["nuevacontraseña"];
    $clave=$nuevacontraseña;
    $confirmarcontraseña=$_POST["confirmarcontraseña"];
    $password_usu=$_POST["contraseñaanterior"];
    $error_clave = "";
    Campo_vacio($password_usu,$nuevacontraseña,$confirmarcontraseña,$validar);
    if($validar==true){
        usuario_existe_cambiar($usuario,$validar);
        if($validar==true){
            Contraseña_Anterior($usuario,$password_usu,$validar);
            if($validar==true){
                Contar_Cadena($nuevacontraseña,$confirmarcontraseña,$validar);         
                if($validar==true){
                    Comparar_Pass($validar);
                    if($validar==true){
                        Validar_Espacio(/*$usuario, $password_usu,*/ $nuevacontraseña, $confirmarcontraseña, $validar);
                        if($validar==true){
                            validar_clave($nuevacontraseña,$validar);
                            if($validar==true){
                                if ($datos=$sql -> fetch_object()){ 
                                
                                    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
                                    $row=mysqli_fetch_array($sql);
                                    $estado=$row[0]; //Guardamos el estado
    
                                    $sql1=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'"); //preguntar el ID del usuario
                                    $row1=mysqli_fetch_array($sql1);
                                    $id_usuario=$row1[0]; //Guardamos el ID_USUARIO
    
                                    $password=$_POST["confirmarcontraseña"];//Guardamos la contraseña de lavor confirmar
    
                                    if ($estado=='DEFAULT') { //Validamos el estado del usuario si es DEFAULT
                                        //Modifiacmos el estado de DEFAULT a NUEVO
                                        $modificar=("update tbl_ms_usuario set password='$password', estado='NUEVO' where id_usuario='$id_usuario'");
                                        $resultado = mysqli_query($conexion,$modificar);
                                        //Llenar el historial de contraseña
                                        $insertar=("insert into tbl_ms_historial_password (password,creado_por,fecha_creacion,id_usuario) VALUES( '$password','$usuario','$fecha_actual',$id_usuario)");
                                        $resultado = mysqli_query($conexion,$insertar);
                                    
                                    }else{
                                        //Modifiacmos cualquier estado a ACTIVO
                                        $modificar=("update tbl_ms_usuario set password='$password', estado='ACTIVO' where id_usuario='$id_usuario'");
                                        $resultado1 = mysqli_query($conexion,$modificar);

                                        //Llenar el historial de contraseña
                                        $insertar=("insert into tbl_ms_historial_password (password,creado_por,fecha_creacion,id_usuario) VALUES( '$password','$usuario','$fecha_actual',$id_usuario)");
                                        $resultado = mysqli_query($conexion,$insertar);
                                    }
                                    //Mensaje de confirmacion de cambio de contraseña.
                                    echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

//=================================BOTON SALIR=========================

if (!empty($_POST["btn_salir_cambiar_password"])){
    session_destroy();
}
?>