<?php
    session_start();
    include "../modelo/conexion.php";
    $usuario=$_SESSION['usuario_login'];
    date_default_timezone_set("America/Tegucigalpa");
    $fecha = date('Y-m-d h:i:s');
    //Guardar la bitacora
    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Salir', 'Salida del sistema','$usuario')");
    session_destroy();
    header("location:../index.php");
?>