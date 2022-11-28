<?php
    if(!empty($_GET["id_tipo_pedido"])) {
        //Verificar permiso del rol
        $usuario_rol=$_SESSION['usuario_login'];
        //Sacar el rol del usuario
        $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
        $row=mysqli_fetch_array($sql);
        $id_rol=$row[0];
        //Sacar el permiso dependiendo del rol
        $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=10");
        $row=mysqli_fetch_array($sql);
        $permiso=$row[0];

        if($permiso <> 'PERMITIR'){
            echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_tipo_pedido.php"</script>';
        }else{
            $sesion_usuario=$_SESSION['usuario_login'];
            $id_tipo_pedido=$_GET["id_tipo_pedido"];
            
            
            //GUARDAR EL TIPO DE PEDIDO
            $sql=mysqli_query($conexion, "select descripcion from tbl_tipo_pedido where id_tipo_pedido=$id_tipo_pedido");
            $row=mysqli_fetch_array($sql);
            $descripcion=$row[0];//Enviar para saber el usuario pasado a inactivo
            
            $sql=$conexion->query(" update tbl_tipo_pedido set estado='INACTIVO' where id_tipo_pedido=$id_tipo_pedido ");
            if ($sql==1) {
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar tipo pedido', 'Se inactivo el tipo pedido $descripcion','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Tipo pedido inactivado correctamente");</script>';
            } else {
                echo '<div class="alert alert-danger text-center">Error al inactivar el tipo pedido</div>';
           } 
        }
        
    }

?>