<?php

//++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++/

//--validacion que no existan campos vacios
function Campo_vacio($usuario,$nuevacontraseña,$confirmarcontraseña,&$validar){
    if (!empty($_POST["usuario"] and $_POST["nuevacontraseña"] and $_POST["confirmarcontraseña"]) and $validar=true){ //Campos en uso
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


function validar_clave($clave,&$error_clave){

    if (!preg_match('[a-z]',$clave)){
        $error_clave = "La clave debe tener al menos una letra minúscula";
        return false;
    } elseif (!preg_match('[A-Z]',$clave)){
        $error_clave = "La clave debe tener al menos una letra mayúscula";
        return false;
    } elseif (!preg_match('[0-9]',$clave)){
        $error_clave = "La clave debe tener al menos un caracter numérico";
        return false;
    } elseif (!preg_match('[!#$%&_=]',$clave)){
        $error_clave = "La clave debe tener al menos un caracter especial";
        return false;
    }
    $error_clave = "";
    return true;
 }


//--confirmar el password
function Comparar_Pass(&$validar){
    $nuevapassword=$_POST["nuevacontraseña"];
    $confirmarpassword=$_POST["confirmarcontraseña"];

    if($nuevapassword==$confirmarpassword){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La Contraseñas no Coinciden</div>"; //Campos no coinciden
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

//--guardar contraseña
function Guardar_Pass ($usuario){
    
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];
    $password=$_POST["confirmarcontraseña"];

    $modificar=("update tbl_ms_usuario set password='$password', estado='NUEVO' where id_usuario='$id_usuario'");
    $resultado = mysqli_query($conexion,$modificar);
    
    $modificar1=("update tbl_ms_parametros set valor='ACTIVO' where id_usuario='$id_usuario' and parametro='Admin_Reset'");
    $resultado3 = mysqli_query($conexion,$modificar1);

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
    
    $errors = array();
    $validar=true;
    $usuario=$_POST["usuario"];
    $sql=$conexion->query("select * from tbl_ms_usuario where usuario='$usuario'");
    $nuevacontraseña=$_POST["nuevacontraseña"];
    $confirmarcontraseña=$_POST["confirmarcontraseña"];
    $password_usu=$_POST["contraseñaanterior"];
    
    Campo_vacio($usuario,$nuevacontraseña,$confirmarcontraseña,$validar);
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
                            if ($datos=$sql -> fetch_object()){                 
                                Guardar_Pass($usuario);
                                echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
                            }
                        }
                    }
                }
            }
        }
    }
}
?>