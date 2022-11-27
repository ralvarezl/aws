<?php

//Funcion para validar campos vacios
function campo_vacio($producto,$precio,$cantidad,$total,$promocion,$estado,&$validar){
    if (!empty($_POST["producto"] and $_POST["precio"] and $_POST["cantidad"] and $_POST["total"] and $_POST["promocion"] and $_POST["estado"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger'>Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR OBJETO
function actualizar_factura_detalle($id_factura_detalle, $producto,$precio,$cantidad,$total,$promocion,$estado,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("update tbl_factura_detalle SET producto='$producto', precio= $precio, cantidad = '$cantidad', total= $total, promocion= '$promocion', estado= '$estado' WHERE id_factura_detalle = $id_factura_detalle "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger'>Error al actualizar la factura</div>";
    }
}

//Modificar factura detalle
if (!empty($_POST["btnactualizar_factura_detalle"])) {
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_factura_detalle=$_POST["id_factura_detalle"];
    $producto1=$_POST["producto"];
    $precio=$_POST["precio"];
    $cantidad=$_POST["cantidad"];
    $total=$_POST["total"];
    $promocion=$_POST["promocion"];
    $estado=$_POST["estado"];

    $sql=mysqli_query($conexion, "select id_producto from tbl_producto where nombre='$producto1'");
    $row=mysqli_fetch_array($sql);
    $producto=$row[0];

    campo_vacio($producto,$precio,$cantidad,$total,$promocion,$estado,$validar);
    if($validar==true){
        actualizar_factura_detalle($id_factura_detalle, $producto,$precio,$cantidad,$total,$promocion,$estado,$validar);
        if($validar==true){
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo factura detalle', 'Factura actualizada','$sesion_usuario')");
            //Mensaje de confirmacion
            echo '<script language="javascript">alert("Factura actualizada exitosamente");;window.location.href="administracion_factura_detalle.php"</script>';
        }
    }
}
?>