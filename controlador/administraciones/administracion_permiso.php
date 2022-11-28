<?php

//Funcion para validar campos vacios
function campo_vacio($id_rol,$id_objeto,$permiso_visualizar, $permiso_registrar, $permiso_actualizar, $permiso_eliminar, &$validar){
    if (!empty($_POST["id_rol"] and $_POST["id_objeto"] and $_POST["visualizar"] and $_POST["registrar"] and $_POST["actualizar"] and $_POST["eliminar"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}


//VALIDAR QUE NO SE REPIT EL PRODUCTO
function validar_permiso($id_rol, $id_objeto, &$validar){
    include "../../../../modelo/conexion.php";

    $sql2=mysqli_query($conexion, "select id_rol,id_objeto from tbl_ms_permisos where id_rol=$id_rol and id_objeto=$id_objeto");//consultar por el nombre
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Permiso ya existente</div>";
        return $validar;  
    }
}

//NUEVO PRODUCTO
function nuevo_permiso($id_rol,$id_objeto,$permiso_visualizar,$permiso_registrar,$permiso_actualizar,$permiso_eliminar,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_permisos (id_rol,id_objeto,permiso_visualizar,permiso_insertar,permiso_actualizar,permiso_eliminar) values ($id_rol,$id_objeto,'$permiso_visualizar','$permiso_registrar','$permiso_actualizar','$permiso_eliminar')"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al registrar permiso</div>";
    }
}

//MODIFICAR PRODUCTO
function actualizar_permiso($id_rol,$id_objeto,$permiso_visualizar,$permiso_registrar,$permiso_actualizar,$permiso_eliminar,&$validar){
    include "../../../../modelo/conexion.php";
        //Actualiza
        $sql=$conexion->query("update tbl_ms_permisos SET permiso_visualizar='$permiso_visualizar',permiso_insertar= '$permiso_registrar', permiso_actualizar= '$permiso_actualizar', permiso_eliminar='$permiso_eliminar'  WHERE id_rol = $id_rol and id_objeto=$id_objeto");
        if($sql==1){
            return $validar;
        }else{
            echo"<div align='center' class='alert alert-danger' >Error al actualizar permiso</div>";
        }
}

//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo pedido
if (!empty($_POST["btnregistrarpermiso"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $id_rol=$_POST["id_rol"];
    $id_objeto=$_POST["id_objeto"];
    $permiso_visualizar=$_POST["visualizar"];
    $permiso_registrar=$_POST["registrar"];
    $permiso_actualizar=$_POST["actualizar"];
    $permiso_eliminar=$_POST["eliminar"];
    
    campo_vacio($id_rol,$id_objeto,$permiso_visualizar, $permiso_registrar, $permiso_actualizar, $permiso_eliminar, $validar);
    if($validar==true){
        validar_permiso($id_rol, $id_objeto,$validar);
        if($validar==true){
            nuevo_permiso($id_rol,$id_objeto,$permiso_visualizar,$permiso_registrar,$permiso_actualizar,$permiso_eliminar,$validar);
            if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nuevo permiso', 'Permiso nuevo','$sesion_usuario')");
                echo '<script language="javascript">alert("¡Permiso creado exitosamente!");;window.location.href="administracion_permiso.php"</script>';
            }  
        } 
    }                  
}

//Modificar pedido
if (!empty($_POST["btnactualizar_permiso"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $id_rol=$_POST["id_rol"];
    $id_objeto=$_POST["id_objeto"];
    $permiso_visualizar=$_POST["permiso_visualizar"];
    $permiso_registrar=$_POST["permiso_insertar"];
    $permiso_actualizar=$_POST["permiso_actualizar"];
    $permiso_eliminar=$_POST["permiso_eliminar"];
    
            actualizar_permiso($id_rol,$id_objeto,$permiso_visualizar,$permiso_registrar,$permiso_actualizar,$permiso_eliminar,$validar);
            if($validar==true){
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo un permiso', 'Permiso actualizado','$sesion_usuario')");
                echo '<script language="javascript">alert("¡Permiso actualizado exitosamente!");;window.location.href="administracion_permiso.php"</script>';
            }  
        }  
?>