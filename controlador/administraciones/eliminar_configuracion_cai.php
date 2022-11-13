<?php
    if(!empty($_GET["id_configuracion_cai"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_configuracion_cai=$_GET["id_configuracion_cai"];
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_configuracion_cai where id_configuracion_cai=$id_configuracion_cai ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar Configuracion Cai', 'Configuracion cai eliminado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Se ha eliminiado configuracion cai");</script>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar configuracion cai</div>';
        }
        
    }

?>