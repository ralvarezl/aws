<?php
//Funcion para validar campos vacios
function campo_vacio($id_parametro, $valor, &$validar){
    if (!empty($_POST["id_parametro"] and $_POST["valor"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

if (!empty($_POST["btnactualizarparametro"])) {

    //include "../../modelo/conexion.php";
    $validar=true;
    $id_parametro=$_POST["id_parametro"];
    $valor=$_POST["valor"];
    campo_vacio($id_parametro, $valor, $validar);
        if ($validar==true) {
            $sql=$conexion->query(" update tbl_ms_parametros set valor='$valor' where id_parametro = $id_parametro ");   
            header("location:../../vista/administracion/administracion_parametros.php");
        }
        
}
?>