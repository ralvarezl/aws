<?php
    if(!empty($_GET["id_descuento"])) {
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

?>