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
                
                if ($datos=$query -> fetch_object()){ 
                echo "<div class='alert alert-success text-center'>Respuesta Correcta</div>";
                //ACTUALIZAR EL PARAMETRO
                $sql=mysqli_query($conexion, "select p.id_usuario from tbl_ms_usuario u join tbl_ms_parametros p on p.id_usuario=u.id_usuario where  usuario='$usuario_msj' and parametro='ADMIN_PREGUNTAS'");
        		$row=mysqli_fetch_array($sql);
        		$id_usuario1=$row[0];
                    $sql=$conexion->query(" update tbl_ms_parametros set valor=1 where id_usuario = $id_usuario1 and parametro='admin_preguntas'");
                    header("location:recuperacion_msj.php");
                        //header("location:vista/login/recuperacion.php");                     //Entra al sistema de recuperacion
                }else{
                    echo"<div class='alert alert-danger text-center'>Respuesta Incorecta</div>"; //Campos sin uso
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

        $modificar1=("update tbl_ms_parametros set valor='RESET' where id_usuario='$id_usuario' and parametro='ADMIN_RESET'");
        $resultado3 = mysqli_query($conexion,$modificar1);

        echo '<script language="javascript">alert("Tu Contraseña es: '.$token .'");;window.location.href="../../login.php"</script>';

    }

    if (!empty($_POST["btnaceptar"])){
    
        $validar=true;
        $nuevapassword=$_POST["nueva"];
        $confirmarpassword=$_POST["confirmar"];
        
            campo_vacio1($nuevapassword,$confirmarpassword,$validar);
            if($validar==true){
                Comparar_Pass($validar);
                if($validar==true){
                    Contar_Cadena($nuevapassword,$confirmarpassword,$validar);
                    if($validar==true){
                        validar_clave_msj($confirmarpassword,$validar);
                        if($validar==true){
                            
                                //Sacams el id del usuario
                                $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
                                $row=mysqli_fetch_array($sql);
                                $id_usuario=$row[0];//almacenamos el id
                                //Mandamos a actualizar contraseña
                                $modificar=("update tbl_ms_usuario set password='$confirmarpassword', estado='ACTIVO' where id_usuario='$id_usuario'");
                                $resultado = mysqli_query($conexion,$modificar);
                                //Actualizar el Parametro
                                $sql=mysqli_query($conexion, "select p.id_usuario from tbl_ms_usuario u join tbl_ms_parametros p on p.id_usuario=u.id_usuario where  usuario='$usuario_msj' and parametro='ADMIN_PREGUNTAS'");
                                $row=mysqli_fetch_array($sql);
                                $id_usuario_parametro=$row[0];
                                $sql=$conexion->query(" update tbl_ms_parametros set valor=0 where id_usuario = $id_usuario_parametro and parametro='admin_preguntas'");
                                
                                echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
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
    $sql=mysqli_query($conexion, "select p.id_usuario from tbl_ms_usuario u join tbl_ms_parametros p on p.id_usuario=u.id_usuario where  usuario='$usuario_msj' and parametro='ADMIN_PREGUNTAS'");
    $row=mysqli_fetch_array($sql);
    $id_usuario_parametro=$row[0];
    $sql=$conexion->query(" update tbl_ms_parametros set valor=0 where id_usuario = $id_usuario_parametro and parametro='admin_preguntas'");
    header("location:recuperacion.php");
    
}

?>