<?php
    if(!empty($_GET["id_cliente"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_cliente=$_GET["id_cliente"];
        
        //INACTIVAR EL CLIENTE
        //Sacar el Cliente
        $sql=mysqli_query($conexion, "select nombres from tbl_cliente where id_cliente=$id_cliente");
            $row=mysqli_fetch_array($sql);
            $cliente=$row[0];//Enviar para saber el cliente a pasado a inactivo
        $sql=$conexion->query(" update tbl_cliente set estado='INACTIVO' where id_cliente=$id_cliente ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar cliente', 'Se inactivo $cliente','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Cliente inactivado correctamente");</script>';//Cliente inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el cliente</div>';
        } 
    }

?>