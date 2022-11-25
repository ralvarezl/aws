<?php
/********************************************************************/
//Eliminar Objeto Al Presionar Boton Eliminar
if (!empty($_GET["id_parametro"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_parametro=$_GET["id_parametro"];

    //GUARDAR EL PARAMETRO
    $sql1=mysqli_query($conexion, "select parametro from tbl_ms_parametros where id_parametro=$id_parametro");
    $row=mysqli_fetch_array($sql1);
    $parametro=$row[0];

    $sql=$conexion->query(" update tbl_ms_parametros set estado='INACTIVO' where id_parametro=$id_parametro ");
        if ($sql==1) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar parametro', 'Se inactivo el parametro $parametro','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Parametro inactivado correctamente");</script>';//objeto inactivado
        } else {
            echo '<div class="alert alert-danger text-center">Error al inactivar el parametro</div>';
        } 

}
?>