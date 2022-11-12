<?php
    if(!empty($_GET["id_tipo_pedido"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_tipo_pedido=$_GET["id_tipo_pedido"];
        
        
        //GUARDAR EL TIPO DE PEDIDO
        $sql=mysqli_query($conexion, "select descripcion from tbl_tipo_pedido where id_tipo_pedido=$id_tipo_pedido");
        $row=mysqli_fetch_array($sql);
        $descripcion=$row[0];//Enviar para saber el usuario pasado a inactivo
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_tipo_pedido where id_tipo_pedido=$id_tipo_pedido ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar Tipo de Pedido', 'Tipo de pedido $descripcion eliminado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Se ha eliminiado el pedido");</script>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar el usuario</div>';
        }
        
    }

?>