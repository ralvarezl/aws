<?php
/********************************************************************/
//Eliminar Al Presionar Boton Eliminar
if (!empty($_GET["id_rol"])) {
     //Verificar permiso del rol
     $usuario_rol=$_SESSION['usuario_login'];
     //Sacar el rol del usuario
     $sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
     $row=mysqli_fetch_array($sql);
     $id_rol=$row[0];
     //Sacar el permiso dependiendo del rol
     $sql=mysqli_query($conexion, "select permiso_eliminar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=15");
     $row=mysqli_fetch_array($sql);
     $permiso=$row[0];

     if($permiso <> 'PERMITIR'){
         echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_promocion.php"</script>';
     }else{
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_rol=$_GET["id_rol"];
    
        //GUARDAR EL ROL
        $sql1=mysqli_query($conexion, "select rol from tbl_ms_roles where id_rol=$id_rol");
        $row=mysqli_fetch_array($sql1);
        $rol=$row[0];
    
        $sql=$conexion->query(" update tbl_ms_roles set estado_rol='INACTIVO' where id_rol=$id_rol ");
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

}
?>