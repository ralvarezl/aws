<?php
/********************************************************************/
//Eliminar Al Presionar Boton Eliminar
if (!empty($_GET["id_pregunta"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_pregunta=$_GET["id_pregunta"];

    //GUARDAR EL PREGUNTA
    $sql1=mysqli_query($conexion, "select pregunta from tbl_ms_preguntas where id_pregunta=$id_pregunta");
    $row=mysqli_fetch_array($sql1);
    $pregunta=$row[0];

    $sql=$conexion->query(" update tbl_ms_preguntas set estado='INACTIVO' where id_pregunta=$id_pregunta ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar pregunta', 'Se inactivo una pregunta ','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Pregunta inactivada correctamente");</script>';//objeto inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar la pregunta</div>';
        } 

}
?>