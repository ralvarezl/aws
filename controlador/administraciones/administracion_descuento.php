<?php
//Funcion para validar campos vacios nuevo
function campo_vacio_nuevo($descripcion, $porcentaje_descuento, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["porcentaje_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar campos vacios actualizar
function campo_vacio_actualizar($descripcion, $porcentaje_descuento, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["porcentaje_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR DESCUENTO
function actualizar_descuento($id_descuento, $descripcion, $porcentaje_descuento, &$validar){
    include "../../../../modelo/conexion.php";

    //CONSULTAR LA DESCRIPCION
    $sql1=mysqli_query($conexion, "select descripcion from tbl_descuento where id_descuento=$id_descuento");
    $row=mysqli_fetch_array($sql1);
    $objeto_base=$row[0];

    if($descripcion==$objeto_base){
        $sql=$conexion->query(" update tbl_descuento SET descripcion='$descripcion', porcentaje_descuento='$porcentaje_descuento' WHERE id_descuento = $id_descuento ");   
        
    }else{
        //consultar por el objeto
        $sql=$conexion->query("select descripcion from tbl_descuento where descripcion='$descripcion'");
        if ($datos=$sql->fetch_object()) { //si existe
            echo"<div class='alert alert-danger text-center'>Este descuento ya existe</div>";
            $validar=false;
            return $validar;
        }else {
            $sql=$conexion->query(" update tbl_descuento SET descripcion='$descripcion', porcentaje_descuento='$porcentaje_descuento' WHERE id_descuento = $id_descuento ");   
            return $validar;
        }
    }

}

//NUEVO DESCUENTO
function nuevo_descuento($descripcion, $porcentaje_descuento, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_descuento (descripcion, porcentaje_descuento) values ('$descripcion','$porcentaje_descuento'); "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al registrar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($descripcion, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select descripcion from tbl_descuento where descripcion='$descripcion';");//consultar por el numero cai
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este descuento ya existe</div>"; //Usuario no existe
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function validar_descripcion($descripcion,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($descripcion);
    if($Longitud1<=60){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Numero cai muy extenso</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($descripcion, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga numeros
    if (preg_match('/[0-9]/',$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres numéricos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }
    
    if(!strpos($descripcion, "=") && !strpos($descripcion, '""') or !strpos($descripcion, '"')){
        $cont=5;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La descripción no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==5){
        return $validar;    
    }
}

//-----------------------FIN FUNCIONES-------------------------------------

//INGRESAR NUEVO DESCUENTO
if (!empty($_POST["btn_nuevo_descuento"])) {
    
    
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];

    $descripcion=$_POST["descripcion"];
    $porcentaje_descuento=$_POST["porcentaje_descuento"];

    campo_vacio_nuevo($descripcion, $porcentaje_descuento, $validar);
    if($validar==true){
        validar_existe($descripcion, $validar);
        if($validar==true){
            validar_descripcion($descripcion, $validar);
            if($validar==true){
                nuevo_descuento($descripcion, $porcentaje_descuento, $validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Descuento', 'Creo descuento $descripcion','$sesion_usuario')");
                    header("location:administracion_descuento.php");
                }
            }  
        }
    }
}

//ACTUALIZAR EL DESCUENTO
if (!empty($_POST["btn_actualizar_descuento"])) {
    
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];

    $id_descuento=$_POST["id_descuento"];
    $descripcion=$_POST["descripcion"];
    $porcentaje_descuento=$_POST["porcentaje_descuento"];
    
    campo_vacio_actualizar($descripcion, $porcentaje_descuento, $validar);
    if($validar==true){
        validar_descripcion($descripcion, $validar);
        if($validar==true){
            actualizar_descuento($id_descuento, $descripcion, $porcentaje_descuento, $validar);
            if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Descuento', 'Creo descuento $descripcion','$sesion_usuario')");
                header("location:administracion_descuento.php");
                }
            }  
        }
    }


?>