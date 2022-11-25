<?php
    if(!empty($_GET["id_factura"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_factura=$_GET["id_factura"];
        
        //INACTIVAR LA FACTURA DETALLE
        //Sacar LA FACTURA
        
        $sql=$conexion->query(" update tbl_factura_detalle set estado='INACTIVO' where id_factura=$id_factura ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar factura detalle', 'Se inactivo una factura detalle','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Factura detalle inactivada correctamente");</script>';//factura inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la factura detalle</div>';
        } 
    }

?>