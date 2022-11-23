<?php

//Funcion para validar campos vacios
function campo_vacio($id_pregunta,$pregunta, &$validar){
    if (!empty($_POST["pregunta"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR PREGUNTA
function actualizar_pregunta($id_pregunta,$pregunta, &$validar){
    include "../../../../modelo/conexion.php";
        
    $sql=$conexion->query(" update tbl_ms_preguntas SET pregunta='$pregunta' WHERE id_pregunta = $id_pregunta ");   
    if ($sql==1) {
        return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

//NUEVA PREGUNTA
function nueva_pregunta($pregunta, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_preguntas (pregunta) values ('$pregunta') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($pregunta, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select pregunta from tbl_ms_preguntas where pregunta='$pregunta'");//consultar por el genero
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Esta pregunta ya existe</div>";
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function valida_pregunta($pregunta,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(=.[@$!%}*{#+-.:,;'&])/",$pregunta)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($pregunta);
    if($Longitud1<=100){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Genero muy extenso</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($pregunta, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga numeros
    if (preg_match('/[0-9]/',$pregunta)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La pregunta no debe tener caracteres numéricos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }
    
    if(!strpos($pregunta, "=") && !strpos($pregunta, '""') or !strpos($pregunta, '"')){
        $cont=5;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La pregunta no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==5){
        return $validar;    
    }
}

//Ingresar nueva pregunta
if (!empty($_POST["btnregistrar_pregunta"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $pregunta=$_POST["pregunta"];
    if($pregunta==''){
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        $validar=false;
    }

    if ($validar==true) {
        validar_existe($pregunta, $validar);
        if($validar==true){
            valida_pregunta($pregunta,$validar);
            if($validar==true){
                nueva_pregunta($pregunta,$validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nueva Pregunta', 'Creo nueva pregunta $pregunta','$sesion_usuario')");
                    //Mensaje de confirmacion
                    echo '<script language="javascript">alert("Pregunta ingresada exitosamente");;window.location.href="administracion_pregunta.php"</script>';//genero ingresado
                }
            }  
        }
    }
}

//ACTUALIZAR PREGUNTA
if (!empty($_POST["btnactualizar_pregunta"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_pregunta=$_POST["id_pregunta"];
    $pregunta=$_POST["pregunta"];
    campo_vacio($id_pregunta,$pregunta, $validar);
        if ($validar==true) {
            validar_existe($pregunta, $validar);
            if($validar==true){
                valida_pregunta($pregunta,$validar);
                if($validar==true){
                    actualizar_pregunta($id_pregunta,$pregunta, $validar);
                    if($validar==true){
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nueva pregunta', 'Creo nueva pregunta','$sesion_usuario')");
                        //Mensaje de confirmacion
                        echo '<script language="javascript">alert("Pregunta actualizada exitosamente");;window.location.href="administracion_pregunta.php"</script>';//genero ingresado
                }
            }
                
        } 
    }
}
?>