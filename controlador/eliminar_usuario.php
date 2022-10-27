<?php
    if(!empty($_GET["id_usuario"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_usuario=$_GET["id_usuario"];
        $sql=$conexion->query(" update tbl_ms_usuario set estado='INACTIVO' where id_usuario=$id_usuario  ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar usuario', 'Administrador borro un usuario del sistema','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<div class="alert alert-danger text-center">Usuario Eliminado Correctamente</div>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar el usuario</div>';
        }
        
    }

?>