<?php
/********************************************************************/
//Eliminar Genero Al Presionar Boton Eliminar
if (!empty($_GET["id_genero"])) {
     //Verificar permiso del rol
     $usuario_rol=$_SESSION['usuario_login'];
     //Sacar el rol del usuario
     $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
     $row=mysqli_fetch_array($sql);
     $id_rol=$row[0];
     //Sacar el permiso dependiendo del rol
     $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=21");
     $row=mysqli_fetch_array($sql);
     $permiso=$row[0];
 
     if($permiso <> 'PERMITIR'){
         echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_descuento.php"</script>';
     }else{
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_genero=$_GET["id_genero"];
    
        //GUARDAR EL GENERO
        $sql1=mysqli_query($conexion, "select genero from tbl_ms_genero where id_genero=$id_genero");
        $row=mysqli_fetch_array($sql1);
        $genero=$row[0];
    
        $sql=$conexion->query(" update tbl_ms_genero set estado='INACTIVO' where id_genero=$id_genero ");
            if ($sql==1) {
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Borrar genero', 'Se inactivo el genero $genero','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Genero inactivado correctamente");</script>';//genero inactivado
            } else {
                echo '<div class="alert alert-danger text-center">Error al inactivar el genero</div>';
            } 
     }

}
?>