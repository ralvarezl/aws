<?php


//++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++/

//--validacion que no existan campos vacios
function Campo_vacio($password_usu,$nuevacontraseña,$confirmarcontraseña,&$validar){
    if (!empty($_POST["contraseñaanterior"] and $_POST["nuevacontraseña"] and $_POST["confirmarcontraseña"]) and $validar=true){ //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor rellenar campos</div>"; //Campos sin uso
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
function Contraseña_Anterior($usuario,$confirmarcontraseña,&$validar){
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select password from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $password_vieja=$row[0];

    if($confirmarcontraseña==$password_vieja){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña ya utilizada</div>"; //Campos sin uso
        return $validar;
    }else{
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
        echo"<div class='alert alert-danger text-center'>Las contraseñas no coinciden</div>"; //Campos no coinciden
        return $validar;
    }
}

//--Contar la Cadena
function Contar_Cadena($nuevacontraseña,$confirmarcontraseña,&$validar){
    
    $Longitud1=strlen($nuevacontraseña);
    $Longitud2=strlen($confirmarcontraseña);
    if($Longitud1<=15 && $Longitud2<=15){
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña muy grande</div>"; //Campos sin uso
        return $validar;
    }
}

//--ver si hay espacios
function Validar_Espacio($nuevacontraseña, $confirmarcontraseña, &$validar){
    if (strpos($confirmarcontraseña, " ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña con espacios no validos</div>";
        return $validar;
    }else{
        if (ctype_graph ($confirmarcontraseña)){        
            return $validar;    
        }
        else{        
            $validar=false;        
            echo"<div class='alert alert-danger text-center'>Contraseña con espacios no validos</div>";        
            return $validar;    
        }
    }
}

function Validar_Parametro($nuevacontraseña,$confirmarcontraseña, &$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=3");
    $row=mysqli_fetch_array($sql);
    $Max_pass=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=4");
    $row1=mysqli_fetch_array($sql1);
    $Min_pass=$row1[0];

    $Longitud1=strlen($nuevacontraseña);
    $Longitud2=strlen($confirmarcontraseña);
    $conta=0;

    if($Longitud1>=$Min_pass && $Longitud1<=$Max_pass){
        $conta=1;
    }
    if($Longitud2>=$Min_pass && $Longitud2<=$Max_pass){
        $conta=2;
    }

    if ($conta==2){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener mas de ".$Min_pass." caracteres y menor de ".$Max_pass."</div>";
        return $validar;
    }
}

//--validar la contraseña anterior del token
function Contraseña_Token($usuario,$password_usu,&$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select password from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $password_vieja=$row[0];

    if($password_usu==$password_vieja){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña Anterior no coincide</div>"; //Campos sin uso
        return $validar;
    }

}

//=================================BOTON DE GUARDAR CONTRASEÑA=========================


if (!empty($_POST["btnnuevacontraseña"])){

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
            Contraseña_Token($usuario,$password_usu,$validar);
            if($validar==true){
                Contraseña_Anterior($usuario,$confirmarcontraseña,$validar);
                if($validar==true){
                    Contar_Cadena($nuevacontraseña,$confirmarcontraseña,$validar);         
                    if($validar==true){
                        Comparar_Pass($validar);
                        if($validar==true){
                            Validar_Espacio($nuevacontraseña, $confirmarcontraseña, $validar);
                            if($validar==true){
                                validar_clave($nuevacontraseña,$validar);
                                if($validar==true){
                                    Validar_Parametro($nuevacontraseña,$confirmarcontraseña, $validar);
                                    if($validar==true){
                                        if ($datos=$sql -> fetch_object()){ 
                        
                                            $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
                                            $row=mysqli_fetch_array($sql);
                                            $estado=$row[0]; //Guardamos el estado
            
                                            $sql1=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'"); //preguntar el ID del usuario
                                            $row1=mysqli_fetch_array($sql1);
                                            $id_usuario=$row1[0]; //Guardamos el ID_USUARIO
            
                                            $password=$_POST["confirmarcontraseña"];//Guardamos la contraseña de lavor confirmar
            
                                            //Modifiacmos cualquier estado a ACTIVO
                                            $modificar=("update tbl_ms_usuario set password='$password', estado='ACTIVO' where id_usuario='$id_usuario'");
                                            $resultado1 = mysqli_query($conexion,$modificar);

                                            //Llenar el historial de contraseña
                                            $insertar=("insert into tbl_ms_historial_password (password,creado_por,fecha_creacion,id_usuario) VALUES( '$password','$usuario','$fecha_actual',$id_usuario)");
                                            $resultado = mysqli_query($conexion,$insertar);

                                            //Borrar el evento  
                                            $sql=$conexion->query("DROP EVENT IF EXISTS ".$id_usuario."A");

                                            //Llenar la bitacora
                                            date_default_timezone_set("America/Tegucigalpa");
                                            $fecha = date('Y-m-d h:i:s');
                                            $sql=$conexion->query("insert into tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Cambiar contraseña', 'Cambia contraseña','$usuario')");
                                        
                                            session_destroy();
                                            //Mensaje de confirmacion de cambio de contraseña.
                                            echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../index.php"</script>';
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

//=================================BOTON SALIR=========================

if (!empty($_POST["btn_salir_cambiar_password"])){
    session_destroy();
}
?>