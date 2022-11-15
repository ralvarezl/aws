<?php
    if(!empty($_GET["id_cliente"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_cliente=$_GET["id_cliente"];
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_cliente where id_cliente=$id_cliente");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar cliente', 'cliente eliminado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Se ha eliminiado el cliente");</script>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar al cliente</div>';
        }
        
    }

?>