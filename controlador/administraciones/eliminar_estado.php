<?php
/********************************************************************/
//Eliminar Estado Al Presionar Boton Eliminar
if (!empty($_GET["id_estado"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_estado=$_GET["id_estado"];

    //INACTIVAR EL ESTAO
        //Sacar el estado
        $sql=mysqli_query($conexion, "select estado from tbl_ms_estado where id_estado=$id_estado");
            $row=mysqli_fetch_array($sql);
            $estado=$row[0];//Enviar para saber el estado a pasado a inactivo
        $sql=$conexion->query(" update tbl_ms_estado set estado1='INACTIVO' where id_estado=$id_estado ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar estado', 'Se inactivo el estado $estado','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Estado inactivado correctamente");</script>';//Cliente inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el estado</div>';
        } 

}
?>