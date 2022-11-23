<?php
/********************************************************************/
//Eliminar Estado Al Presionar Boton Eliminar
if (!empty($_GET["id_estado"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_estado=$_GET["id_estado"];

    //GUARDAR EL ESTADO
    $sql1=mysqli_query($conexion, "select estado from tbl_ms_estado where id_estado=$id_estado");
    $row=mysqli_fetch_array($sql1);
    $estado=$row[0];

    $sql=$conexion->query(" delete from tbl_ms_estado where id_estado=$id_estado ");
    if ($sql==1) {
        //Guardar la bitacora 
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Elimino Estado', 'Elimino el estado $estado','$sesion_usuario')");
        //Mensaje de confirmacion
        echo '<script language="javascript">alert("Estado eliminado correctamente");;window.location.href="administracion_estado.php"</script>';//Estado eliminado
    }else {
        echo"<div align='center' class='alert alert-danger' >Error al eliminar el estado</div>";
    }

}
?>