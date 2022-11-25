<?php
    if(!empty($_GET["id_rol"])) {
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

?>