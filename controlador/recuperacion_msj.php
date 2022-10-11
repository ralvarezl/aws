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

function campo_vacio1($nuevapassword,$confirmarpassword,$respuestas,&$validar){
    if (!empty($_POST["respuesta"]and $_POST["confirmar"] and $nuevapassword=$_POST["nueva"]) and $validar=true) {    //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}

function Comparar_respuesta($id_pregunta, $respuesta, &$validar){
    
    include "../../modelo/conexion.php";

    $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
    if ($datos=$query -> fetch_object()){
        $sql=mysqli_query($conexion, "select id_pregunta from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
        $row=mysqli_fetch_array($sql);
        $id_pregunta_usuario=$row[0];
        
        if($id_pregunta_usuario==$id_pregunta and $validar=true){
            return $validar;
        }else {
            $validar=false;
            echo"<div class='alert alert-danger text-center'>Respuestas Incorectas</div>"; //Campos sin uso
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
            Comparar_respuesta($id_pregunta, $respuesta, $validar);
            if($validar==true){
                if ($datos=$query -> fetch_object()){ 
                    echo "<div class='alert alert-danger'>Respuesta Correcta</div>";
                        //header("location:vista/login/recuperacion.php");                     //Entra al sistema de recuperacion
                }else{
                    echo"<div class='alert alert-danger text-center'>Respuesta Incorecta</div>"; //Campos sin uso
                }   
            }  
        }
    }

    if (!empty($_POST["btnautogenerar"])){

        $validar=true;
        $respuesta=$_POST["respuesta"];
        $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
        $id_pregunta=$_POST["id_pregunta"];

        campo_vacio_respuesta($respuesta,$validar);
        if($validar==true){
            Comparar_respuesta($id_pregunta, $respuesta, $validar);
            if($validar==true){
                if ($datos=$query -> fetch_object()){

                    $token = Generar_token();
                    $respuesta=$_POST["respuesta"];
                    $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
                    $id_pregunta=$_POST["id_pregunta"];

                    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_preguntas_usuario where respuesta='$respuesta' and id_pregunta='$id_pregunta'");
                    $row=mysqli_fetch_array($sql);
                    $id_usuario=$row[0];

                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha_actual=date("Y-m-d");

                    $modificar=("update tbl_ms_usuario set password='$token' where id_usuario='$id_usuario'");
                    $resultado1 = mysqli_query($conexion,$modificar);

                    $insertar=("insert into tbl_token (TOKEN,FECHA_VENCIMIENTO,ID_USUARIO) VALUES( '$token','$fecha_actual','$id_usuario')");
                    $resultado2 = mysqli_query($conexion,$insertar);

                    $modificar1=("update tbl_ms_parametros set valor='R' where id_usuario='$id_usuario' and parametro='Admin_Reset'");
                    $resultado3 = mysqli_query($conexion,$modificar1);

                    echo '<script language="javascript">alert("Tu Contraseña es: '.$token .'");;window.location.href="../../login.php"</script>';

            }else{
                echo"<div class='alert alert-danger text-center'>Respuesta Incorecta</div>"; //Campos sin uso
            }
        }    
    }
}


    if (!empty($_POST["btnaceptar"])){
    
        $validar=true;
        $respuesta=$_POST["respuesta"];
        $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
        $id_pregunta=$_POST["id_pregunta"];
        $nuevapassword=$_POST["nueva"];
        $confirmarpassword=$_POST["confirmar"];
        
        Comparar_respuesta($id_pregunta, $respuesta, $validar);
        if($validar==true){
            campo_vacio1($nuevapassword,$confirmarpassword,$respuesta,$validar);
            if($validar==true){
                Comparar_Pass($validar);
                if($validar==true){
                    Contar_Cadena($nuevapassword,$confirmarpassword,$validar);
                    if($validar==true){
                        if ($datos=$query -> fetch_object()){
                            
                            $confirmarpassword=$_POST["confirmar"];
                            $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
                            $id_pregunta=$_POST["id_pregunta"];

                            $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_preguntas_usuario where respuesta='$respuesta' and id_pregunta='$id_pregunta'");
                            $row=mysqli_fetch_array($sql);
                            $id_usuario=$row[0];

                            $modificar=("update tbl_ms_usuario set password='$confirmarpassword' where id_usuario='$id_usuario'");
                            $resultado1 = mysqli_query($conexion,$modificar);

                            echo '<script language="javascript">alert("CONTRASEÑA GUARDADA CON EXITO");;window.location.href="../../login.php"</script>';
                    }else{
                        echo"<div class='alert alert-danger text-center'>Respuesta Incorecta</div>"; //Campos sin uso
                    }
                }
            }
        }    
    }
}

?>