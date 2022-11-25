<?php
    if(!empty($_GET["id_factura_descuento"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_factura_descuento=$_GET["id_factura_descuento"];
        
        //INACTIVAR EL FACTURA DESCUENTO
        $sql=$conexion->query(" update tbl_factura_descuento set estado='INACTIVO' where id_factura_descuento=$id_factura_descuento ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar factura descuento', 'Se inactivo una factura descuento','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Factura descuento inactivada correctamente");</script>';
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la factura descuento</div>';
        } 
        
    }

?>