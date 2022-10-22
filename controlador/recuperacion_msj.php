<?php
//|||||||||||||||||||||||||||||||| Funciones de Recupercion por msj ||||||||||||||||||||||||||||||||||||

//--validacion que no existan campos vacios de respuesta
function campo_vacio_respuesta($respuestas,&$validar){
    if (!empty($_POST["respuesta"]) and $validar=true) {    //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}

function campo_vacio1($nuevapassword,$confirmarpassword,&$validar){
    if (!empty($_POST["confirmar"] and $nuevapassword=$_POST["nueva"]) and $validar=true) {    //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}


function Comparar_respuesta($usuario_msj,$id_pregunta, $respuesta, &$validar){
    
    include "../../modelo/conexion.php";
    //Obtenemos el id del usuario
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];

    $sql2=mysqli_query($conexion, "select respuesta from tbl_ms_preguntas_usuario where id_pregunta=$id_pregunta and id_usuario=$id_usuario and respuesta='$respuesta'");
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Respuesta Incorecta</div>";
        return $validar;
    }else{
        //Obtenemos la respuesta del usuario y su pregunta
        $sql1=mysqli_query($conexion, "select respuesta from tbl_ms_preguntas_usuario where id_pregunta=$id_pregunta and id_usuario=$id_usuario");
        $row1=mysqli_fetch_array($sql1);
        $respuesta_usuario=$row1[0];
        
        if($respuesta_usuario==$respuesta){
            echo "<div class='alert alert-success text-center'>Respuesta Correcta</div>";
            return $validar;
        }  
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
    if($Longitud<=20 and $Longitud1){
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Contraseña solo permite 20 caracteres</div>"; //Campos sin uso
        return $validar;
    }
}

//Validar contraseña robusta
function validar_clave_msj($confirmarpassword,&$validar){
    //validar tenga minusculas
    if (!preg_match('/[a-z]/',$confirmarpassword)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra minúscula</div>";
        return $validar;
    } else {
        //Validar tenga mayusculas
        if (!preg_match('/[A-Z]/',$confirmarpassword)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra mayuscula</div>";
        } else{
            //Validar tenga numeros
            if (!preg_match('/[0-9]/',$confirmarpassword)){
                $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter numérico</div>"; 
            } else {
                //Validar tenga caracter especial
                if (!preg_match('/[^a-zA-Z\d]/',$confirmarpassword)){
                    $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter especial</div>"; 
                }else {
                    return $validar;
                }
            }
        }
    }
}

//--ver si hay espacios
function Validar_Espacio_msj($nuevacontraseña, $confirmarcontraseña, &$validar){
    if (ctype_graph ($nuevacontraseña and $confirmarcontraseña)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Campo Con Espacios No Validos</div>";
        return $validar;
    }else{
        return $validar;
    }
}

function Validar_Parametro_msj($nuevapassword,$confirmarpassword, &$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=4");
    $row=mysqli_fetch_array($sql);
    $Max_pass=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=5");
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
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener mas de 5 caracteres y menor de 10</div>";
        return $validar;
    }
}

///////////////////////////////////////////----EJECUCIÓN DE COMBOBOX----///////////////////////////////////////////


$consulta = "select * from tbl_ms_preguntas";
$ejecutar = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));


    if (!empty($_POST["btnsiguiente"])){
        
        $validar=true;
        $respuesta=$_POST["respuesta"];
        $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
        $id_pregunta=$_POST["id_pregunta"];
        
        campo_vacio_respuesta($respuesta,$validar);
        if($validar==true){
            Comparar_respuesta($usuario_msj,$id_pregunta, $respuesta, $validar);
            if($validar==true){
                //Validar con el parametro
                if(isset($_SESSION["respuestas_r"]) == true){
                    //Entonces que le sume uno
                    $_SESSION["respuestas_r"]++;
                    $respuestas_r= $_SESSION["respuestas_r"];
                    //Sacar el valor del parametro de preguntas
                    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='3'");
                    $row=mysqli_fetch_array($sql);
                    $valor=$row[0];
                    //Si respuestas son iguales al valor del parametro
                    if($respuestas_r==$valor){
                        header("location:recuperacion_msj_contra.php");
                    }
                }else{
                    // Si no existe que la cree
                    $_SESSION["respuestas_r"] = 1;
                } 
            }
        }
    }

    if (!empty($_POST["btnautogenerar"])){

        $token = Generar_token();

        $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
        $row=mysqli_fetch_array($sql);
        $id_usuario=$row[0];

        date_default_timezone_set("America/Tegucigalpa");
        $fecha_actual=date("Y-m-d");

        $modificar=("update tbl_ms_usuario set password='$token' , estado='ACTIVO' where id_usuario='$id_usuario'");
        $resultado1 = mysqli_query($conexion,$modificar);

        $insertar=("insert into tbl_ms_token (TOKEN,FECHA_VENCIMIENTO,ID_USUARIO) VALUES( '$token','$fecha_actual','$id_usuario')");
        $resultado2 = mysqli_query($conexion,$insertar);

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
                                Validar_Espacio_msj($nuevapassword, $confirmarpassword,$validar);
                                if($validar==true){
                                    Validar_Parametro_msj($nuevapassword,$confirmarpassword,$validar);
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
                                    session_destroy();
                                    echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            

if (!empty($_POST["btn_salir_msj"])) {
    session_destroy();
}

if (!empty($_POST["btn_salir_msj_uno"])) {
    session_destroy();

    header("location:recuperacion.php");
    
}

?>