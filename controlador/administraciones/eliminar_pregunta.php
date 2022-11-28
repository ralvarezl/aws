<?php
/********************************************************************/
//Eliminar Al Presionar Boton Eliminar
if (!empty($_GET["id_pregunta"])) {
    //Verificar permiso del rol
    $usuario_rol=$_SESSION['usuario_login'];
    //Sacar el rol del usuario
    $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
    $row=mysqli_fetch_array($sql);
    $id_rol=$row[0];
    //Sacar el permiso dependiendo del rol
    $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=19");
    $row=mysqli_fetch_array($sql);
    $permiso=$row[0];

    if($permiso <> 'PERMITIR'){
        echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_producto.php"</script>';
    }else{
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
   
}
?>