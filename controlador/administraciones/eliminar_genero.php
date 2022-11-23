<?php
/********************************************************************/
//Eliminar Genero Al Presionar Boton Eliminar
if (!empty($_GET["id_genero"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_genero=$_GET["id_genero"];

    //GUARDAR EL GENERO
    $sql1=mysqli_query($conexion, "select genero from tbl_ms_genero where id_genero=$id_genero");
    $row=mysqli_fetch_array($sql1);
    $genero=$row[0];

    $sql=$conexion->query(" delete from tbl_ms_genero where id_genero=$id_genero ");
    if ($sql==1) {
        //Guardar la bitacora 
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Elimino Genero', 'Elimino el genero $genero','$sesion_usuario')");
        //Mensaje de confirmacion
        echo '<script language="javascript">alert("Genero eliminado correctamente");;window.location.href="administracion_genero.php"</script>';//Genero eliminado
    }else {
        echo"<div align='center' class='alert alert-danger' >Error al eliminar el genero</div>";
    }

}
?>