<?php
    if(!empty($_GET["id_factura"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_factura=$_GET["id_factura"];
        
        //INACTIVAR LA FACTURA
        //Sacar LA FACTURA
        $sql=mysqli_query($conexion, "select numero_factura from tbl_factura where id_factura=$id_factura");
            $row=mysqli_fetch_array($sql);
            $numero_factura=$row[0];
        $sql=$conexion->query(" update tbl_factura set estado='INACTIVO' where id_factura=$id_factura ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar factura', 'Se inactivo la factura $numero_factura','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Factura inactivado correctamente");</script>';//factura inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la factura</div>';
        } 
    }

?>