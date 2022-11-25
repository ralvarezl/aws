<?php
    if(!empty($_GET["id_promocion"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_promocion=$_GET["id_promocion"];
        
        //INACTIVAR PROMOCION
        //Sacar la promocion
        $sql=mysqli_query($conexion, "select descripcion from tbl_promocion where id_promocion=$id_promocion");
            $row=mysqli_fetch_array($sql);
            $promocion=$row[0];//Enviar para saber la promocion a pasado a inactivo
        $sql=$conexion->query(" update tbl_promocion set estado='INACTIVO' where id_promocion=$id_promocion ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar promocion', 'Se inactivo la promocion $promocion','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Promocion inactivado correctamente");</script>';//Cliente inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la promocion</div>';
        } 
        
    }

?>