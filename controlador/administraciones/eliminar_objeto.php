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

    $sql=$conexion->query(" delete from tbl_ms_objetos where id_objeto=$id_objeto ");
    if ($sql==1) {
        //Guardar la bitacora 
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Elimino Objeto', 'Elimino el objeto $objeto','$sesion_usuario')");
        //Mensaje de confirmacion
        echo '<script language="javascript">alert("Objeto eliminado correctamente");;window.location.href="administracion_objeto.php"</script>';//Objeto eliminado
    }else {
        echo"<div align='center' class='alert alert-danger' >Error al eliminar el objeto</div>";
    }

}
?>