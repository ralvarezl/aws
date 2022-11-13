<?php
    if(!empty($_GET["id_descuento"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_descuento=$_GET["id_descuento"];
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_descuento where id_descuento=$id_descuento ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar Descuento', 'Descuento eliminado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Se ha eliminiado el descuento");</script>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar el descuento</div>';
        }
        
    }

?>