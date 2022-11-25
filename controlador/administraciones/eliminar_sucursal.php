<?php
/********************************************************************/
//Eliminar Sucursal Al Presionar Boton Eliminar
if (!empty($_GET["id_sucursal"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_sucursal=$_GET["id_sucursal"];

    //GUARDAR LA SUCURSAL
    $sql1=mysqli_query($conexion, "select nombre from tbl_sucursal where id_sucursal=$id_sucursal");
    $row=mysqli_fetch_array($sql1);
    $nombre_sucursal=$row[0];

    $sql=$conexion->query(" update tbl_sucursal set estado='INACTIVO' where id_sucursal=$id_sucursal ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar sucursal', 'Se inactivo la sucursal $nombre_sucursal','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Sucursal inactivada correctamente");</script>';//sucursal inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la sucursal</div>';
        } 

}
?>