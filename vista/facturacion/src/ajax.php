<?php
require_once "../../../modelo/conexion.php";

//BUSCA EL NOMBRE
if (isset($_GET['q'])) {
    $datos = array();
    $nombres = $_GET['q'];
    
    $cliente = mysqli_query($conexion, "SELECT id_cliente, nombres, telefono, identidad, estado FROM tbl_cliente WHERE nombres LIKE '%".$nombres."%' AND estado='ACTIVO'");
    while ($row = mysqli_fetch_assoc($cliente)) {
        $data['id'] = $row['id_cliente'];
        $data['label'] = $row['nombres'];
        $data['identidad'] = $row['identidad'];
        $data['telefono'] = $row['telefono'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
//BUSCA EL PRODUCTO
}else if (isset($_GET['pro'])) {
    $datos = array();
    $nombre = $_GET['pro'];
    $producto = mysqli_query($conexion, "SELECT id_producto, nombre, tipo, precio FROM tbl_producto WHERE estado='ACTIVO' AND nombre LIKE '%" . $nombre . "%' OR tipo LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($producto)) {
        $data['id'] = $row['id_producto'];
        $data['label'] = $row['tipo'] . ' - ' .$row['nombre'];
        $data['value'] = $row['nombre'];
        $data['precio'] = $row['precio'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
//BUSCA LA PROMOCION
}else if (isset($_GET['prom'])) {
    $datos = array();
    $nombre = $_GET['prom'];
    $producto = mysqli_query($conexion, "SELECT id_promocion, descripcion, precio FROM tbl_promocion WHERE descripcion LIKE '%" . $nombre . "%' AND estado='ACTIVO' ");
    while ($row = mysqli_fetch_assoc($producto)) {
        $data['id'] = $row['id_promocion'];
        $data['label'] = $row['descripcion'];
        $data['value'] = $row['descripcion'];
        $data['precio'] = $row['precio'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();

//BUSCA EL DESCUNETO
}else if (isset($_GET['des'])) {
    $datos = array();
    $nombre = $_GET['des'];
    $producto = mysqli_query($conexion, "SELECT id_descuento, descripcion, porcentaje_descuento FROM tbl_descuento WHERE estado='ACTIVO' AND descripcion LIKE '%" . $nombre . "%' OR porcentaje_descuento LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($producto)) {
        $data['id'] = $row['id_descuento'];
        $data['label'] = $row['porcentaje_descuento'] . '%  - ' .$row['descripcion'];
        $data['value'] = $row['descripcion'];
        $data['precio'] = $row['porcentaje_descuento'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
//Busca los detalles del producto que pedio el cliente para mostrar en pantalla
}else if (isset($_GET['detalle'])) {

    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.id, d.id_usuario, d.id_producto, d.cantidad, d.precio_venta, d.total, p.id_producto, p.nombre FROM tbl_detalle_temp d INNER JOIN tbl_producto p ON d.id_producto = p.id_producto");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['nombre'] = $row['nombre'];
        $data['cantidad'] = $row['cantidad'];
        $data['precio_venta'] = $row['precio_venta'];
        $data['sub_total'] = $row['total'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
//elimina el producto del pedido del cliente 
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM tbl_detalle_temp WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
//Busca los detalles del promociones que pedio el cliente para mostrar en pantalla
}else if (isset($_GET['detalleProm'])) {

    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.id, d.id_usuario, d.id_promocion, d.cantidad, d.precio_venta, d.total, p.id_promocion, p.descripcion FROM tbl_detalle_prom_temp d INNER JOIN tbl_promocion p ON d.id_promocion = p.id_promocion");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['nombre'] = $row['descripcion'];
        $data['cantidad'] = $row['cantidad'];
        $data['precio_venta'] = $row['precio_venta'];
        $data['sub_total'] = $row['total'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
//elimina la promocion del pedido del cliente 
} else if (isset($_GET['delete_detalle_prom'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM tbl_detalle_prom_temp WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
}else if (isset($_GET['procesarVenta'])) {

            $id_cliente = $_GET['id'];
            $id_user1 = $_GET['id_user'];
            $id_user = 2;
            $id_desc=$_GET["desc"];
            $descrip=$_GET["descrip"];
            $nombre=$_GET["sucur"];
            $Pago=$_GET["pago"];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('Y-m-d h:i:s');


        $id_maximo = mysqli_query($conexion, "SELECT ID_USUARIO from tbl_ms_usuario where usuario='$id_user1'");
        $resultId = mysqli_fetch_assoc($id_maximo);
        $Id_usuario = $resultId['ID_USUARIO'];


        $consulta1 = mysqli_query($conexion, "SELECT total, SUM(total) AS total_pagar FROM tbl_detalle_temp WHERE id_usuario = $id_user");
        $result1 = mysqli_fetch_assoc($consulta1);
        $total1 = $result1['total_pagar'];

        $consulta2 = mysqli_query($conexion, "SELECT total, SUM(total) AS total_pagar FROM tbl_detalle_prom_temp WHERE id_usuario = $id_user");
        $result2 = mysqli_fetch_assoc($consulta2);
        $total2 = $result2['total_pagar'];

            $subtotal=$total1+$total2;

        $sql=mysqli_query($conexion, "select porcentaje_descuento from tbl_descuento where id_descuento=$id_desc");
        $row=mysqli_fetch_array($sql);
        $porcentaje_descuento=$row[0];

        //preguntar el valor del ISV
        $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=15"); 
        $row=mysqli_fetch_array($sql);
        $ISV_P=$row[0]; //Guardamos el isv

        $ISV_C=$ISV_P/100;
            $ISV=$subtotal*$ISV_C;

            $porcentaje_descu=$porcentaje_descuento/100;
            $total_descuento=($subtotal*$porcentaje_descu);
            $total=$subtotal-$total_descuento+$ISV;

            $porcentaje_descu=$porcentaje_descuento/100;
            $total_descuento=($subtotal*$porcentaje_descu);
            $total=$subtotal-$total_descuento+$ISV;

 

        if($Pago>$total){
        
                $Cambio=$Pago-$total;

 

            $sql1=mysqli_query($conexion, "select id_tipo_pedido from tbl_tipo_pedido where descripcion='$descrip'");
            $row1=mysqli_fetch_array($sql1);
                $id_tipo_pedido=$row1[0];

 

            $sql2=mysqli_query($conexion, "select id_sucursal from tbl_sucursal where nombre='$nombre'");
            $row2=mysqli_fetch_array($sql2);
                $id_sucursal=$row2[0];

 


            $insertar = mysqli_query($conexion, "insert into tbl_factura (fecha,subtotal,isv, total_descuento, total,pago,cambio, id_tipo_pedido, id_cliente, id_sucursal,id_usuario,estado) 
                                values ('$fecha','$subtotal','$ISV','$total_descuento','$total','$Pago','$Cambio',$id_tipo_pedido,$id_cliente,$id_sucursal,$Id_usuario,'ACTIVO')"); 

 

            
            if ($insertar) {

 


                $id_maximo = mysqli_query($conexion, "SELECT id_factura from tbl_factura where subtotal='$subtotal'");
                $resultId = mysqli_fetch_assoc($id_maximo);
                $ultimoId = $resultId['id_factura'];

 

                $consulta = mysqli_query($conexion, "SELECT id, id_usuario, id_producto, cantidad, precio_venta, total FROM tbl_detalle_temp WHERE id_usuario = $id_user");
                while($row = mysqli_fetch_assoc($consulta)){
                    $id_producto = $row['id_producto'];
                    $precio = $row['precio_venta'];
                    $cantidad = $row['cantidad'];
                    $total= $row['total'];
                    $insertarDet = mysqli_query($conexion, "INSERT INTO tbl_factura_detalle(precio, cantidad, total,estado,id_factura,id_producto) VALUES ('$precio',$cantidad, '$total','ACTIVO', $ultimoId,$id_producto)");
                }

 

                $consulta2 = mysqli_query($conexion, "SELECT id, id_usuario, id_promocion, cantidad, precio_venta, total FROM tbl_detalle_prom_temp WHERE id_usuario = $id_user");
                while($row = mysqli_fetch_assoc($consulta2)){
                    $id_promocion = $row['id_promocion'];
                    $precio = $row['precio_venta'];
                    $cantidad = $row['cantidad'];
                    $total= $row['total'];
                    $insertarDet = mysqli_query($conexion, "INSERT INTO tbl_factura_detalle(precio, cantidad, total,estado,id_factura,id_promocion ) VALUES ('$precio',$cantidad, '$total','ACTIVO', $ultimoId,$id_promocion)");
                    $insertarprom = mysqli_query($conexion, "INSERT INTO tbl_factura_promocion(cantidad,total_promocion,id_promocion,id_factura,estado) VALUES ($cantidad,'$total',$id_promocion,$ultimoId,'ACTIVO')");
                }
                $sql2=mysqli_query($conexion, "SELECT total_descuento from tbl_factura where id_factura =$ultimoId");
                $row2=mysqli_fetch_assoc($sql2);
                $total_descuento=$row2['total_descuento']; 

 

                if($total_descuento>1){
                    $insertarDet = mysqli_query($conexion, "INSERT INTO tbl_factura_descuento(total_descuento,id_descuento, id_factura,estado ) VALUES ('$total_descuento',$id_desc,$ultimoId,'ACTIVO')");
                }

 

                if($insertarDet){
                    $eliminar1 = mysqli_query($conexion, "DELETE FROM tbl_detalle_prom_temp WHERE id_usuario = $id_user");
                    $eliminar2 = mysqli_query($conexion, "DELETE FROM tbl_detalle_temp WHERE id_usuario = $id_user");
                    $msg = array('id_cliente' => $id_cliente, 'id_venta' => $ultimoId);
                }

 

        }else{
            $msg = array('mensaje' => 'error');
        }
    }
        echo json_encode($msg);
        die();
    
}

//REGISTRA LA TRANSACCION DE LOS PRODUCTOS 
if (isset($_POST['regDetalle'])) {
    $id = $_POST['id'];
    $cant = $_POST['cant'];
    $precio = $_POST['precio'];
    $id_user = 2;
    $total = $precio * $cant;
    $verificar = mysqli_query($conexion, "SELECT id, id_usuario, id_producto, cantidad, precio_venta, total FROM tbl_detalle_temp WHERE id_producto = $id");
    $result = mysqli_num_rows($verificar);
    $datos = mysqli_fetch_assoc($verificar);
    if ($result > 0) {
        $cantidad = $datos['cantidad'] + $cant;
        $total_precio = ($cantidad * $precio);
        $query = mysqli_query($conexion, "UPDATE tbl_detalle_temp SET cantidad = $cantidad, total = '$total_precio' WHERE id_producto = $id");
        if ($query) {
            $msg = "actualizado";
        } else {
            $msg = "Error al ingresar";
        }
    }else{
        $query = mysqli_query($conexion, "INSERT INTO tbl_detalle_temp(id_usuario, id_producto, cantidad ,precio_venta, total) VALUES ($id_user, $id, $cant,'$precio', '$total')");
        if ($query) {
            $msg = "registrado";
        }else{
            $msg = "Error al ingresar";
        }
    }
    echo json_encode($msg);
    die(); 
}

//REGISTRA LA TRANSACCION DE LAS PROMOCION
if (isset($_POST['regDetalleProm'])) {
    $id = $_POST['id'];
    $cant = $_POST['cant'];
    $precio = $_POST['precio'];
    $id_user = 2;
    $total = $precio * $cant;
    $verificar = mysqli_query($conexion, "SELECT id, id_usuario, id_promocion, cantidad, precio_venta, total FROM tbl_detalle_prom_temp WHERE id_promocion = $id");
    $result = mysqli_num_rows($verificar);
    $datos = mysqli_fetch_assoc($verificar);
    if ($result > 0) {
        $cantidad = $datos['cantidad'] + $cant;
        $total_precio = ($cantidad * $precio);
        $query = mysqli_query($conexion, "UPDATE tbl_detalle_prom_temp SET cantidad = $cantidad, total = '$total_precio' WHERE id_promocion = $id");
        if ($query) {
            $msg = "actualizado";
        } else {
            $msg = "Error al ingresar";
        }
    }else{
        $query = mysqli_query($conexion, "INSERT INTO tbl_detalle_prom_temp(id_usuario, id_promocion, cantidad ,precio_venta, total) VALUES ($id_user, $id, $cant,'$precio', '$total')");
        if ($query) {
            $msg = "registrado";
        }else{
            $msg = "Error al ingresar";
        }
    }
    echo json_encode($msg);
    die(); 
}