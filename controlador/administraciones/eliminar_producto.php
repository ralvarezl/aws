<?php
    if(!empty($_GET["id_producto"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_producto=$_GET["id_producto"];
        
        //INACTIVAR EL PRODUCTO
        //Sacar el producto
        $sql=mysqli_query($conexion, "select nombre from tbl_producto where id_producto=$id_producto");
            $row=mysqli_fetch_array($sql);
            $producto=$row[0];//Enviar para saber el producto a pasado a inactivo
        $sql=$conexion->query(" update tbl_producto set estado='INACTIVO' where id_producto=$id_producto ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar producto', 'Se inactivo el producto $producto','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Producto inactivado correctamente");</script>';//producto inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el producto</div>';
        } 
        
    }

?>