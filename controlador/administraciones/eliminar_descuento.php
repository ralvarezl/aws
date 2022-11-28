<?php
    if(!empty($_GET["id_descuento"])) {
        //Verificar permiso del rol
        $usuario_rol=$_SESSION['usuario_login'];
        //Sacar el rol del usuario
        $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
        $row=mysqli_fetch_array($sql);
        $id_rol=$row[0];
        //Sacar el permiso dependiendo del rol
        $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=9");
        $row=mysqli_fetch_array($sql);
        $permiso=$row[0];

        if($permiso <> 'PERMITIR'){
            echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_descuento.php"</script>';
        }else{
            $sesion_usuario=$_SESSION['usuario_login'];
            $id_descuento=$_GET["id_descuento"];
            
            //INACTIVAR EL DESCUENTO
            //Sacar el Descuento
            $sql=mysqli_query($conexion, "select descripcion from tbl_descuento where id_descuento=$id_descuento");
                $row=mysqli_fetch_array($sql);
                $descuento=$row[0];
                //Enviar para saber el descuento a pasado a inactivo
            $sql=$conexion->query(" update tbl_descuento set estado='INACTIVO' where id_descuento=$id_descuento ");
            if ($sql==1) {
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar descuento', 'Se inactivo descuento $descuento','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Descuento inactivado correctamente");</script>';//descuento inactivado
            } else {
                echo '<div class="alert alert-danger text-center">Error al inactivar el descuento</div>';
            }
        }
              
    }

?>