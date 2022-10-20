<?php
/*++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++*/


//--validacion que no existan campos vacios
function Campo_vacio_msj($usuario,$respuesta_pregunta,&$validar){

    if (!empty($_POST["usuario"] and $_POST["respuesta_pregunta"] and $validar=true)) {    //Campos en uso
        return $validar; 
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellene Los Campos</div>"; //Campos sin uso
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
        echo"<div class='alert alert-danger text-center'>Usuario Tiene Espacio</div>";
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

    //Cambiar el estado a ACTIVO
    $modificar1=("update tbl_ms_usuario set estado='ACTIVO' where id_usuario='$id_usuario'");
    $resultado4 = mysqli_query($conexion,$modificar1);

    echo '<script language="javascript">alert("PREGUNTAS GUARDADAS CON EXITO");;window.location.href="../../login.php"</script>';


    return $validar;


}



//=================================BOTON DE GUARDAR PREGUNTAS=========================

if (!empty($_POST["btnguardar"])){

    session_destroy();
    include "../../modelo/conexion.php";
    
    $usuario=$_POST["usuario"];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");
    //Respuesta del input
    $respuesta_pregunta=$_POST["respuesta_pregunta"];
    //Selección del combobox
    $select_pregunta=$_POST["select_pregunta"];
    $validar=true;
    Campo_vacio_msj($usuario,$respuesta_pregunta,$validar);
    if($validar==true){
        usuario_existe_mjs($usuario,$validar);
        if($validar==true){
            Validar_Espacio_mjs($usuario,$validar);
            if($validar==true){
                Guardar_pregunta_msj($usuario,$select_pregunta,$respuesta_pregunta,$validar);
            }
        }
    }
}

?>