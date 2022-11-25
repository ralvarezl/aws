<?php
    if(!empty($_GET["id_configuracion_cai"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_configuracion_cai=$_GET["id_configuracion_cai"];
        
        //INACTIVAR CONF CAI
        //Sacar numero cai
        $sql=mysqli_query($conexion, "select numero_cai from tbl_configuracion_cai where id_configuracion_cai=$id_configuracion_cai");
            $row=mysqli_fetch_array($sql);
            $numero_cai=$row[0];//Enviar para saber el cliente a pasado a inactivo
        $sql=$conexion->query(" update tbl_configuracion_cai set estado='INACTIVO' where id_configuracion_cai=$id_configuracion_cai ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar Configuracion Cai', 'Se inactivo numero cai $numero_cai','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Configuracion cai inactivado correctamente");</script>';//Cliente inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar configuracion cai</div>';
        }
        
    }

?>