<?php

//Funcion para validar campos vacios
function campo_vacio( $rol, $descripcion, &$validar){
    if (!empty($_POST["rol"] and $_POST["descripcion"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR 
function actualizar_rol($id_rol, $rol, $descripcion, &$validar){
    include "../../../../modelo/conexion.php";
        
    $sql=$conexion->query(" update tbl_ms_roles SET rol='$rol', descripcion='$descripcion' WHERE id_rol=$id_rol");
    if ($sql==1) {
        return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

//NUEVO OBJETO
function nuevo_rol($rol, $descripcion, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_roles (rol, descripcion) values ('$rol', '$descripcion') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($rol,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select rol from tbl_ms_roles where rol='$rol'");//consultar por el objeto
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este rol ya existe</div>";
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//-----------------------PRESIONAR BOTONES-------------------------------------

//Ingresar nuevo rol
if (!empty($_POST["btnregistrar_rol"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $rol=$_POST["rol"];
    $descripcion=$_POST["descripcion"];

    campo_vacio($rol, $descripcion, $validar);
    if ($validar==true) {
        if ($validar==true) {
        validar_existe($rol, $validar);
        if($validar==true){
            nuevo_rol($rol, $descripcion, $validar);
            if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Rol', 'Creo nuevo rol $rol','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Rol ingresado exitosamente");;window.location.href="administracion_rol.php"</script>';//rol ingresado
            }
            }  
        }
    }
}

//ACTUALIZAR ESTADO
if (!empty($_POST["btnactualizar_rol"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_rol=$_POST["id_rol"];
    $rol=$_POST["rol"];
    $descripcion=$_POST["descripcion"];
    
    campo_vacio($id_rol, $rol, $descripcion, $validar);
        if ($validar==true) {
            validar_existe($rol, $validar);
            if($validar==true){
                actualizar_rol($id_rol, $rol, $descripcion, $validar);
                if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar Rol', 'Actualizo rol $rol','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Rol actualizado exitosamente");;window.location.href="administracion_rol.php"</script>';//objeto ingresado
                }
            }
                
        } 
    }



?>