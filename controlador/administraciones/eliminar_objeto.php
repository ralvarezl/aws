<?php
/********************************************************************/
//Eliminar Objeto Al Presionar Boton Eliminar
if (!empty($_GET["id_objeto"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_objeto=$_GET["id_objeto"];

    //GUARDAR EL OBJETO
    $sql1=mysqli_query($conexion, "select objeto from tbl_ms_objetos where id_objeto=$id_objeto");
    $row=mysqli_fetch_array($sql1);
    $objeto=$row[0];

    $sql=$conexion->query(" update tbl_ms_objetos set estado='INACTIVO' where id_objeto=$id_objeto ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar objeto', 'Se inactivo el objeto $objeto','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Objeto inactivado correctamente");</script>';//objeto inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el objeto</div>';
        } 

}
?>