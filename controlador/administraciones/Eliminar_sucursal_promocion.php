<?php
    if(!empty($_GET["id_sucursal"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_sucursal=$_GET["id_sucursal"];
        
        //INACTIVAR sucursal promocion
        $sql=$conexion->query(" update tbl_sucursal_promocion set estado='INACTIVO' where id_sucursal=$id_sucursal ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar sucursal promocion', 'Se inactivo una sucursal promocion','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Sucursal promocion inactivada correctamente");</script>';
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la sucursal promocion</div>';
        } 
        
    }

?>