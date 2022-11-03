<?php
/*++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++*/


//--validacion que no existan campos vacios
function Campo_vacio_msj($usuario,$respuesta_pregunta,&$validar){

    if (!empty($_POST["respuesta_pregunta"] and $validar=true)) {    //Campos en uso
        return $validar; 
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor rellene los campos</div>"; //Campos sin uso
        return $validar;
    }
}

//Funcion para validar que existe el usuario
function usuario_existe_mjs($usuario,&$validar){
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

//--ver si hay espacios
function Validar_Espacio_mjs($usuario,&$validar){
    if (ctype_graph ($usuario)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario tiene espacio</div>";
        return $validar;
    }

}

function Guardar_pregunta_msj($usuario,$select_pregunta,$respuesta_pregunta,&$validar){

    include "../../modelo/conexion.php";
    date_default_timezone_set("America/Tegucigalpa");
    $mifecha = date('Y-m-d');
    //Buscar Id del usuario
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];
    
    //Guarda la pregunta
    $insertar=("insert into tbl_ms_preguntas_usuario (ID_PREGUNTA,RESPUESTA,CREADO_POR,FECHA_CREACION,ID_USUARIO) VALUES( '$select_pregunta','$respuesta_pregunta','$usuario','$mifecha','$id_usuario')");
    $resultado = mysqli_query($conexion,$insertar);

    echo '<div class="alert alert-success text-center">Pregunta registrada correctamente</div>';
    return $validar;
}

function Validar_pregunta($select_pregunta,$usuario,&$validar){
    include "../../modelo/conexion.php";

    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];

    $sql1=mysqli_query($conexion, "select id_pregunta from tbl_ms_preguntas_usuario where id_pregunta='$select_pregunta' and id_usuario='$id_usuario'");
    $row1=mysqli_fetch_array($sql1); 
    $id_pregunta=$row[0];

    $sql=$conexion->query("select id_pregunta from tbl_ms_preguntas_usuario where id_pregunta='$select_pregunta' and id_usuario='$id_usuario'");
    if ($datos=$sql->fetch_object()){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Pregunta ya contestada, seleccione otra pregunta</div>";
        return $validar;
    }else {
        return $validar;
    }
}



//=================================BOTON DE GUARDAR PREGUNTAS=========================

if (!empty($_POST["btnguardar"])){
   
    //session_destroy();
    include "../../modelo/conexion.php";
    $validar=true;
    $usuario=$_SESSION['usuario_login'];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");
    //Respuesta del input
    $respuesta_pregunta=$_POST["respuesta_pregunta"];
    //Selección del combobox
    $select_pregunta=$_POST["select_pregunta"];
    //Sacar ID del usuario
    $sql2=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'"); //preguntar el ID del usuario
    $row2=mysqli_fetch_array($sql2);
    $id_usuario=$row2[0]; //Guardamos el ID_USUARIO

    $sql=$conexion->query("select * from tbl_ms_preguntas_usuario where id_usuario='$id_usuario'"); //preguntar si el usuario tiene preguntas contestadas
    if ($datos=$sql->fetch_object()){
        //Sacar cuantas preguntas ya ha contestado el usuario
        $sql_pre=mysqli_query($conexion, "select  count($id_usuario)
        from tbl_ms_preguntas_usuario where id_usuario=$id_usuario
        having count($id_usuario)>0"); //preguntar el ID del usuario
        $row_pre=mysqli_fetch_array($sql_pre);
        $contestadas=$row_pre[0];
    }else{
        //si el usuario no tiene contestadas
        $contestadas=1;
    }
  
    //Llamado de las funciones
    Campo_vacio_msj($usuario,$respuesta_pregunta,$validar);
    if($validar==true){
        usuario_existe_mjs($usuario,$validar);
        if($validar==true){
            Validar_Espacio_mjs($usuario,$validar);
            if($validar==true){
                Validar_pregunta($select_pregunta,$usuario,$validar);
                if($validar==true){
                    Guardar_pregunta_msj($usuario,$select_pregunta,$respuesta_pregunta,$validar);
                    if(isset($_SESSION["respuestas"]) == true){
                        //Entonces que le sume uno
                        $_SESSION["respuestas"]++;
                        $intentos= $_SESSION["respuestas"];
                        //Sacar el valor del parametro de preguntas
                        $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='2'");
                        $row=mysqli_fetch_array($sql);
                        $valor=$row[0];
                        if($intentos==$valor){
                            //Actualizar el valor de respuestas contestadas
                            $sql2=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'"); //preguntar el ID del usuario
                            $row2=mysqli_fetch_array($sql2);
                            $id_usuario=$row2[0]; //Guardamos el ID_USUARIO
                            //Llenar datos de preguntas contestadas en el usuario y pasar a activo el usuario
                            //VER QUIEN CREO EL USUARIO
                            $sql=mysqli_query($conexion, "select creado_por from tbl_ms_usuario where usuario='$usuario' and creado_por='$usuario'"); //preguntar el ID del usuario
                            $row=mysqli_fetch_array($sql);
                            $creado_por=$row[0]; //Guardamos las preguntas contestas
                            if($creado_por==$usuario){
                                $modificar=("update tbl_ms_usuario set preguntas_contestadas=$intentos, estado='ACTIVO' where id_usuario='$id_usuario'");
                                $resultado = mysqli_query($conexion,$modificar);
                                //Si respuestas son iguales al valor del parametro
                                //Llenar la bitacora
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha = date('Y-m-d h:i:s');
                                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Contestar Preguntas', 'Usuario respondio preguntas de seguridad','$usuario')");
                                echo '<script language="javascript">alert("RESPONDIO LAS PREGUNTAS");</script>';
                                session_destroy();
                                header("location:../../login.php");//Entra al cambiar password
                            }else{
                                $modificar=("update tbl_ms_usuario set preguntas_contestadas=$intentos, estado='DEFAULT' where id_usuario='$id_usuario'");
                                $resultado = mysqli_query($conexion,$modificar);
                                //Si respuestas son iguales al valor del parametro
                                //Llenar la bitacora
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha = date('Y-m-d h:i:s');
                                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Contestar Preguntas', 'Usuario respondio preguntas de seguridad','$usuario')");
                                echo '<script language="javascript">alert("RESPONDIO LAS PREGUNTAS");</script>';
                                header("location:cambiarpassword.php");//Entra al cambiar password  
                            }
                        }
                    }else{
                        // Si no existe que la cree
                        $_SESSION["respuestas"]=$contestadas;
                    }
                }
                
            }
        }
    }
}

?>