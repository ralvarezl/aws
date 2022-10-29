<?php

function campo_vacio1($nuevapassword,$confirmarpassword,&$validar){
    if (!empty($_POST["confirmar"] and $nuevapassword=$_POST["nueva"]) and $validar=true) {    //Campos en uso
        //header("location:recuperacion_msj_contra.php");
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}

function Generar_token (){
    $leng=10;
    $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_!?+-^.,=";
    $token = "" ;

    for ( $i=0; $i<$leng; $i++ ) {
        $token.= $cadena[rand(0,70)];
    }

    return $token;
}

function Comparar_Pass(&$validar){
    $nuevapassword=$_POST["nueva"];
    $confirmarpassword=$_POST["confirmar"];
    if($nuevapassword==$confirmarpassword){
        //header("location:recuperacion_msj_contra.php");
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Las Contraseñas no Coinciden</div>"; //Campos no coinciden
        return $validar;
    }
}

//--Contar la Cadena
function Contar_Cadena($nuevapassword,$confirmarpassword,&$validar){
    
    $Longitud=strlen($nuevapassword);
    $Longitud1=strlen($confirmarpassword);
    if($Longitud<=15 and $Longitud1<=15){
        //header("location:recuperacion_msj_contra.php");
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña solo permite menos de 15 caracteres</div>"; //Campos sin uso
        return $validar;
    }
}

//Validar contraseña robusta
function validar_clave_msj($confirmarpassword,&$validar){
    //validar tenga minusculas
    if (!preg_match('/[a-z]/',$confirmarpassword)){
        $validar=false;
        //header("location:recuperacion_msj_contra.php");
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra minúscula</div>";
        return $validar;
    } else {
        //Validar tenga mayusculas
        if (!preg_match('/[A-Z]/',$confirmarpassword)){
            $validar=false;
            //header("location:recuperacion_msj_contra.php");
            echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra mayuscula</div>";
        } else{
            //Validar tenga numeros
            if (!preg_match('/[0-9]/',$confirmarpassword)){
                $validar=false;
                //header("location:recuperacion_msj_contra.php");
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter numérico</div>"; 
            } else {
                //Validar tenga caracter especial
                if (!preg_match('/[^a-zA-Z\d]/',$confirmarpassword)){
                    $validar=false;
                    //header("location:recuperacion_msj_contra.php");
                    echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter especial</div>"; 
                }else {
                    return $validar;
                }
            }
        }
    }
}

//--ver si hay espacios
function Validar_Espacio_demsj($nuevapassword, $confirmarpassword, &$validar){
    if(strpos($confirmarpassword, " ")){
        $validar=false;
        //header("location:recuperacion_msj_contra.php");
        echo"<div class='alert alert-danger text-center'>Contraseña Con Espacios No Validos</div>";

        return $validar;
    }else{
        if (ctype_graph ($confirmarpassword)){        
            return $validar;    
        }
        else{        
            $validar=false;        
            echo"<div class='alert alert-danger text-center'>Contraseña Con Espacios No Validos</div>";        
            return $validar;    
        }
    }
}

function Validar_Parametro_msj($nuevapassword,$confirmarpassword, &$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=3");
    $row=mysqli_fetch_array($sql);
    $Max_pass=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=4");
    $row1=mysqli_fetch_array($sql1);
    $Min_pass=$row1[0];

    $Longitud1=strlen($nuevapassword);
    $Longitud2=strlen($confirmarpassword);
    $conta=0;

    if($Longitud1>=$Min_pass && $Longitud1<=$Max_pass){
        $conta=1;
    }
    if($Longitud2>=$Min_pass && $Longitud2<=$Max_pass){
        $conta=2;
    }

    if ($conta==2){
        //header("location:recuperacion_msj_contra.php");
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener mas de ".$Min_pass." caracteres y menor de ".$Max_pass."</div>";
        return $validar;
    }
}

if (!empty($_POST["btnautogenerar"])){

    $token = Generar_token();

    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];

    date_default_timezone_set("America/Tegucigalpa");
    $fecha_tiempo=date('Y-m-d h:i:s');
   

    //crear evento de la contraseña
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=10");
    $row=mysqli_fetch_array($sql);
    $valor=$row[0];
    $fecha_actual = strtotime ( '+'.$valor.' hour' , strtotime ($fecha_tiempo) ) ; 
    $fecha_actual = date ( 'Y-m-d H:i:s' , $fecha_actual); 
    $modificar=("update tbl_ms_usuario set password='$token' , estado='DEFAULT' where id_usuario='$id_usuario'");
    $resultado1 = mysqli_query($conexion,$modificar);

    $insertar=("insert into tbl_ms_token (TOKEN,FECHA_VENCIMIENTO,ID_USUARIO) VALUES( '$token','$fecha_actual','$id_usuario')");
    $resultado2 = mysqli_query($conexion,$insertar);

    //Borrar cualquier evento si existe
    $sql=$conexion->query("DROP EVENT IF EXISTS ".$id_usuario."A");
 
    //Crear el evento
     $sql_evento=$conexion->query("CREATE EVENT IF NOT EXISTS ".$id_usuario."A
     ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL $valor HOUR
     DO
     UPDATE tbl_ms_usuario  SET password = '' where id_usuario=$id_usuario and usuario='$usuario_msj'");
 

    //Llenar la bitacora
    date_default_timezone_set("America/Tegucigalpa");
    $fecha = date('Y-m-d h:i:s');
    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Recuperar contraseña', 'Usuario Autogenero la contraseña','$usuario_msj')");
    echo '<script language="javascript">alert("Tu Contraseña es: '.$token .'");;window.location.href="../../login.php"</script>';

}

if (!empty($_POST["btnaceptar"])){
    
    $validar=true;
    $nuevapassword=$_POST["nueva"];
    $confirmarpassword=$_POST["confirmar"];
    date_default_timezone_set("America/Tegucigalpa");
    $fecha_actual=date("Y-m-d");
    
    campo_vacio1($nuevapassword,$confirmarpassword,$validar);
    if($validar==true){
        Comparar_Pass($validar);
        if($validar==true){
            Contar_Cadena($nuevapassword,$confirmarpassword,$validar);
            if($validar==true){
                validar_clave_msj($confirmarpassword,$validar);
                if($validar==true){
                    Validar_Parametro_msj($nuevapassword,$confirmarpassword,$validar);
                    if($validar==true){
                        Validar_Espacio_demsj($nuevapassword, $confirmarpassword,$validar);
                        if($validar==true){
                            //Sacams el id del usuario
                            $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
                            $row=mysqli_fetch_array($sql);
                            $id_usuario=$row[0];//almacenamos el id
                            //Mandamos a actualizar contraseña
                            $modificar=("update tbl_ms_usuario set password='$confirmarpassword', estado='ACTIVO' where id_usuario='$id_usuario'");
                            $resultado = mysqli_query($conexion,$modificar);
                            //Llenar el historial de contraseña
                            $insertar=("insert into tbl_ms_historial_password (password,creado_por,fecha_creacion,id_usuario) VALUES( '$confirmarpassword','$usuario_msj','$fecha_actual',$id_usuario)");
                            $resultado = mysqli_query($conexion,$insertar);
                            //Guardar en bitacora 
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date('Y-m-d h:i:s');
                            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Cambio contraseña', 'Cambio la contraseña via pregunta secreta','$usuario_msj')");
                            session_destroy();
                            echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
                    }
                }
            }
        }
    }
}
}


if (!empty($_POST["btn_salir_msj_uno"])) {
    session_destroy();
    header("location:recuperacion.php"); 
}

?>