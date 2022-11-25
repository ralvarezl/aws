<?php
/********************************************************************/
//Eliminar Al Presionar Boton Eliminar
if (!empty($_GET["id_rol"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_rol=$_GET["id_rol"];

    //GUARDAR EL ROL
    $sql1=mysqli_query($conexion, "select rol from tbl_ms_roles where id_rol=$id_rol");
    $row=mysqli_fetch_array($sql1);
    $rol=$row[0];

    $sql=$conexion->query(" update tbl_ms_roles set estado='INACTIVO' where id_rol=$id_rol ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar rol', 'Se inactivo el rol $rol','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Rol inactivado correctamente");</script>';//rol inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el rol</div>';
        } 

}
?>