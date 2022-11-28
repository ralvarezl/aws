<?php
    if(!empty($_GET["id_rol"])) {
        $id_objeto=$_GET["id_objeto"];
        //Verificar permiso del rol
        $usuario_rol=$_SESSION['usuario_login'];
        //Sacar el rol del usuario
        $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
        $row=mysqli_fetch_array($sql);
        $id_rol_base=$row[0];
        //Sacar el permiso dependiendo del rol
        $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol_base' and id_objeto=16");
        $row=mysqli_fetch_array($sql);
        $permiso=$row[0];
        
        if($permiso <> 'PERMITIR'){
            echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_permiso.php"</script>';
        }else{
            $sesion_usuario=$_SESSION['usuario_login'];
            $id_rol=$_GET["id_rol"];
            
            //INACTIVAR LA FACTURA DETALLE
            //Sacar LA FACTURA
            
            $sql=$conexion->query(" update tbl_ms_permisos set estado='INACTIVO' where id_rol=$id_rol ");
            if ($sql==1) {
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar permiso', 'Se inactivo un permiso','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Permiso inactivado correctamente");</script>';//factura inactivado
            } else {
                echo '<div class="alert alert-danger text-center">Error al inactivar permiso</div>';
            } 
        }
       
    }

?>