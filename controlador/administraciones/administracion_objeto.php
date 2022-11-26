<?php

//Funcion para validar campos vacios
function campo_vacio( $objeto, $descripcion, $tipo_objeto, &$validar){
    if (!empty($_POST["objeto"] and $_POST["descripcion"] and $_POST["tipo_objeto"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR OBJETO
function actualizar_objeto($id_objeto, $objeto, $descripcion, $tipo_objeto, $estado, &$validar){
    include "../../../../modelo/conexion.php";
    
    //CONSULTAR EL OBJETO
    $sql1=mysqli_query($conexion, "select objeto from tbl_ms_objetos where id_objeto=$id_objeto");
    $row=mysqli_fetch_array($sql1);
    $objeto_base=$row[0];

    if($objeto==$objeto_base){
        $sql=$conexion->query(" update tbl_ms_objetos SET descripcion='$descripcion', tipo_objeto='$tipo_objeto' , estado='$estado' WHERE id_objeto = $id_objeto ");   
        
    }else{
        //consultar por el objeto
        $sql=$conexion->query("select objeto from tbl_ms_objetos where objeto='$objeto'");
        if ($datos=$sql->fetch_object()) { //si existe
            echo"<div class='alert alert-danger text-center'>Este objeto ya existe</div>";
            $validar=false;
            return $validar;
        }else {
            $sql=$conexion->query(" update tbl_ms_objetos SET objeto='$objeto', descripcion='$descripcion', tipo_objeto='$tipo_objeto', estado='$estado' WHERE id_objeto = $id_objeto ");   
            return $validar;
        }
    }
}

//NUEVO OBJETO
function nuevo_objeto($objeto, $descripcion, $tipo_objeto, $estado, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_objetos (objeto, descripcion, tipo_objeto, estado) values ('$objeto', '$descripcion', '$tipo_objeto', '$estado') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($objeto, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select objeto from tbl_ms_objetos where objeto='$objeto'");//consultar por el objeto
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este objeto ya existe</div>";
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//-----------------------PRESIONAR BOTONES-------------------------------------

//Ingresar nuevo objeto
if (!empty($_POST["btnregistrar_objeto"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $objeto=$_POST["objeto"];
    $descripcion=$_POST["descripcion"];
    $tipo_objeto=$_POST["tipo_objeto"];
    $estado=$_POST["estado"];


    campo_vacio($objeto, $descripcion, $tipo_objeto, $validar);
    if ($validar==true) {
    if ($validar==true) {
        validar_existe($objeto, $validar);
        if($validar==true){
            nuevo_objeto($objeto, $descripcion, $tipo_objeto, $estado, $validar);
            if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Objeto', 'Creo nuevo objeto $objeto','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Objeto ingresado exitosamente");;window.location.href="administracion_objeto.php"</script>';//objeto ingresado
            }
            }  
        }
    }
}

//ACTUALIZAR ESTADO
if (!empty($_POST["btnactualizar_objeto"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_objeto=$_POST["id_objeto"];
    $objeto=$_POST["objeto"];
    $descripcion=$_POST["descripcion"];
    $tipo_objeto=$_POST["tipo_objeto"];
    $estado=$_POST["estado"];
    campo_vacio($objeto, $descripcion, $tipo_objeto, $validar);
        if ($validar==true) {
                actualizar_objeto($id_objeto, $objeto, $descripcion, $tipo_objeto, $estado, $validar);
                if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar Objeto', 'Actualizo objeto $objeto','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Objeto actualizado exitosamente");;window.location.href="administracion_objeto.php"</script>';//objeto ingresado
                }
        }
    }
?>