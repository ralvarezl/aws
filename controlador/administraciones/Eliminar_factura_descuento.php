<?php
    if(!empty($_GET["id_factura_descuento"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_factura_descuento=$_GET["id_factura_descuento"];
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_factura_descuento where id_factura_descuento=$id_factura_descuento");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar Factura Descuento', 'Factura Descuento eliminado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Se ha eliminiado la factura descuento");</script>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar la factura descuento</div>';
        }
        
    }

?>