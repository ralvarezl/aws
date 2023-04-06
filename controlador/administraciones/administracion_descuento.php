<?php
//Funcion para validar campos vacios nuevo
function campo_vacio_nuevo($descripcion, $porcentaje_descuento, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["porcentaje_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar campos vacios actualizar
function campo_vacio_actualizar($descripcion, $porcentaje_descuento, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["porcentaje_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR DESCUENTO
function actualizar_descuento($id_descuento, $descripcion, $porcentaje_descuento,$estado, &$validar){
    include "../../../../modelo/conexion.php";

    //CONSULTAR LA DESCRIPCION
    $sql1=mysqli_query($conexion, "select descripcion from tbl_descuento where id_descuento=$id_descuento");
    $row=mysqli_fetch_array($sql1);
    $objeto_base=$row[0];

    if($descripcion==$objeto_base){
        $sql=$conexion->query(" update tbl_descuento SET descripcion='$descripcion', porcentaje_descuento='$porcentaje_descuento', estado='$estado' WHERE id_descuento = $id_descuento ");   
        
    }else{
        //consultar por el objeto
        $sql=$conexion->query("select descripcion from tbl_descuento where descripcion='$descripcion'");
        if ($datos=$sql->fetch_object()) { //si existe
            echo"<div class='alert alert-danger text-center'>El descuento ya existe, ingrese uno nuevo</div>";
            $validar=false;
            return $validar;
        }else {
            $sql=$conexion->query(" update tbl_descuento SET descripcion='$descripcion', porcentaje_descuento='$porcentaje_descuento',estado='$estado' WHERE id_descuento = $id_descuento ");   
            return $validar;
        }
    }

}

//NUEVO DESCUENTO
function nuevo_descuento($descripcion, $porcentaje_descuento, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_descuento (descripcion, porcentaje_descuento, estado) values ('$descripcion','$porcentaje_descuento', 'ACTIVO'); "); 
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
        echo"<div class='alert alert-danger text-center'>El descuento ya existe, ingrese uno nuevo</div>"; //Usuario no existe
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function validar_descripcion($descripcion,&$validar){
    if (preg_match('/[0-9]/',$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {

        if (!preg_match("/^[a-zA-Z\s]*$/",$descripcion)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($descripcion,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
                $validar=false;
                return $validar;
            }else{
                return $validar;
            }
        }
    }    
}

function limite_descripcion_porcentaje($descripcion, $porcentaje_descuento, &$validar){

    $Longitud1=strlen($descripcion);
    $Longitud2=strlen($porcentaje_descuento);
    $conta=0;

    if($Longitud1<=50){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción es muy extensa</div>";
        return $validar;
    }

    if($Longitud2<=4){
        $conta=2;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El porcentaje no debe de exceder los 4 digitos</div>";
        return $validar;
    }

    if ($conta==2){
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
                limite_descripcion_porcentaje($descripcion, $porcentaje_descuento, $validar);
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
}

//ACTUALIZAR EL DESCUENTO
if (!empty($_POST["btn_actualizar_descuento"])) {
    
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];

    $id_descuento=$_POST["id_descuento"];
    $descripcion=$_POST["descripcion"];
    $porcentaje_descuento=$_POST["porcentaje_descuento"];
    $estado=$_POST["estado"];
    
    campo_vacio_actualizar($descripcion, $porcentaje_descuento, $validar);
    if($validar==true){
        validar_descripcion($descripcion, $validar);
        if($validar==true){
            limite_descripcion_porcentaje($descripcion, $porcentaje_descuento, $validar);
            if($validar==true){
                actualizar_descuento($id_descuento, $descripcion, $porcentaje_descuento,$estado, $validar);
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


?>