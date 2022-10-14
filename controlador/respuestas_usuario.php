<?php
/*++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++*/


//--validacion que no existan campos vacios
function Campo_vacio_msj($usuario,$Pgt_1,$Pgt_2,$Pgt_3,&$validar){

    if (!empty($_POST["usuario"]and $_POST["Pgt_1"] and $_POST["Pgt_2"] and $_POST["Pgt_3"]) and $validar=true) {    //Campos en uso
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

function Guardar_pregunta_msj($usuario,$Pgt_1,$Pgt_2,$Pgt_3,&$validar){

    include "../../modelo/conexion.php";

    //Buscar Id del usuario
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];
    //Buscar el ID de la primera pregunta
    $sql=mysqli_query($conexion, "select id_pregunta from tbl_ms_preguntas where pregunta='¿COMO SE LLAMA TU MASCOTA?'");
    $row=mysqli_fetch_array($sql);
    $id_pregunta1=$row[0];
    //Buscar el ID de la segunda pregunta
    $sql=mysqli_query($conexion, "select id_pregunta from tbl_ms_preguntas where pregunta='¿CUAL ES TU COLOR FAVORITO?'");
    $row=mysqli_fetch_array($sql);
    $id_pregunta2=$row[0];
    //Buscar el ID de la tercera pregunta
    $sql=mysqli_query($conexion, "select id_pregunta from tbl_ms_preguntas where pregunta='¿PRIMER NOMBRE DE TU ABUELO?'");
    $row=mysqli_fetch_array($sql);
    $id_pregunta3=$row[0];


    //Guarda la primera pregunta
    $insertar1=("insert into tbl_ms_preguntas_usuario (ID_PREGUNTA,RESPUESTA,ID_USUARIO) VALUES( '$id_pregunta1','$Pgt_1','$id_usuario')");
    $resultado1 = mysqli_query($conexion,$insertar1);
    //Guarda la segunda pregunta
    $insertar2=("insert into tbl_ms_preguntas_usuario (ID_PREGUNTA,RESPUESTA,ID_USUARIO) VALUES( '$id_pregunta2','$Pgt_2','$id_usuario')");
    $resultado2 = mysqli_query($conexion,$insertar2);
    //Guarda la tercera pregunta
    $insertar3=("insert into tbl_ms_preguntas_usuario (ID_PREGUNTA,RESPUESTA,ID_USUARIO) VALUES( '$id_pregunta3','$Pgt_3','$id_usuario')");
    $resultado3 = mysqli_query($conexion,$insertar3);
    //Cambiar el estado a ACTIVO
    $modificar1=("update tbl_ms_usuario set estado='ACTIVO' where id_usuario='$id_usuario'");
    $resultado4 = mysqli_query($conexion,$modificar1);

    echo '<script language="javascript">alert("PREGUNTAS GUARDADAS CON EXITO");;window.location.href="../../login.php"</script>';

    return $validar;


}



//=================================BOTON DE GUARDAR PREGUNTAS=========================

if (!empty($_POST["btnguardar"])){

    include "../../modelo/conexion.php";

    $usuario=$_POST["usuario"];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");

    $Pgt_1=$_POST["Pgt_1"];
    $Pgt_2=$_POST["Pgt_2"];
    $Pgt_3=$_POST["Pgt_3"];
    
    $validar=true;
    Campo_vacio_msj($usuario,$Pgt_1,$Pgt_2,$Pgt_3,$validar);
    if($validar==true){
        usuario_existe_mjs($usuario,$validar);
        if($validar==true){
            Validar_Espacio_mjs($usuario,$validar);
            if($validar==true){
                Guardar_pregunta_msj($usuario,$Pgt_1,$Pgt_2,$Pgt_3,$validar);
            }
        }
    }
}

?>