<?php
require_once '../../../../modelo/conexion.php';
require_once 'fpdf/fpdf.php';
$pdf = new FPDF('P', 'mm', array(80, 200));
$pdf->AddPage();
$pdf->SetMargins(5, 0, 0);
$pdf->SetTitle("Ventas");
$pdf->SetFont('Arial', 'B', 12);
$id = $_GET['v'];
$idcliente = $_GET['cl'];

//preguntar el valor del nombre del negocio
$sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=11"); 
$row=mysqli_fetch_array($sql);
$nombre_negocio=$row[0]; //Guardamos el nombre del negocio

//preguntar el valor del logo del negocio
$sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=12"); 
$row=mysqli_fetch_array($sql);
$logo_negocio=$row[0]; //Guardamos el logo del negocio

//preguntar el valor del telefono del negocio
$sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=13"); 
$row=mysqli_fetch_array($sql);
$telefono_negocio=$row[0]; //Guardamos el telefono del negocio

//preguntar el valor del emanil del negocio
$sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=14"); 
$row=mysqli_fetch_array($sql);
$correo_negocio=$row[0]; //Guardamos el emanil del negocio

//preguntar el id_sucursal de la factura
$sql=mysqli_query($conexion, "select id_sucursal from tbl_factura where id_factura=$id"); 
$row=mysqli_fetch_array($sql);
$id_sucursal=$row[0]; //Guardamos el id_sucursal de la factura

//preguntar el nombre de la sucursal
$sql=mysqli_query($conexion, "select nombre from tbl_sucursal where id_sucursal=$id_sucursal"); 
$row=mysqli_fetch_array($sql);
$nombre_sucursal=$row[0]; //Guardamos el nombre de la sucursal

//preguntar el id_usuario de la factura
$sql=mysqli_query($conexion, "select id_usuario from tbl_factura where id_factura=$id"); 
$row=mysqli_fetch_array($sql);
$id_usuario=$row[0]; //Guardamos el id_usuario de la factura

//preguntar el nombre de la sucursal
$sql=mysqli_query($conexion, "select usuario from tbl_ms_usuario where id_usuario=$id_usuario"); 
$row=mysqli_fetch_array($sql);
$nombre=$row[0]; //Guardamos el nombre de la sucursal

//preguntar la fecha de la factura
$sql=mysqli_query($conexion, "select fecha from tbl_factura where id_factura=$id"); 
$row=mysqli_fetch_array($sql);
$fecha=$row[0]; //Guardamos la fecha de la factura

$clientes = mysqli_query($conexion, "SELECT id_cliente, nombres, identidad, genero, telefono FROM tbl_cliente WHERE id_cliente = $idcliente");
$datosC = mysqli_fetch_assoc($clientes);
$ventas = mysqli_query($conexion, "SELECT d.id_factura, d.id_producto, d.cantidad, d.precio, d.total, p.id_producto, p.nombre FROM tbl_producto p  INNER JOIN tbl_factura_detalle d  ON p.id_producto=d.id_producto WHERE d.id_factura=$id");
$ventas2 = mysqli_query($conexion, "SELECT d.id_factura, d.id_promocion, d.cantidad, d.precio, d.total, m.id_promocion, m.descripcion FROM tbl_factura_detalle d  INNER JOIN tbl_promocion m ON d.id_promocion =m.id_promocion WHERE d.id_factura=$id" );
$pdf->Cell(65, 5, utf8_decode($nombre_negocio), 0, 1, 'C');
$pdf->image("../../../../public/img/".$logo_negocio."", 53, 15, 22, 22, 'PNG');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, "Fecha: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($fecha), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, $telefono_negocio, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, "Vendedor: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($nombre), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, utf8_decode("Email: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($correo_negocio), 0, 1, 'L');


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, "Sucursal: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(15, 5, utf8_decode($nombre_sucursal), 0, 1, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(70, 5, "Datos del cliente", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 5, utf8_decode('Nombre'), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode('Teléfono'), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode('Identidad'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(30, 5, utf8_decode($datosC['nombres']), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode($datosC['telefono']), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode($datosC['identidad']), 0, 1, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(70, 5, "Detalle de Producto", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 5, utf8_decode('Descripción'), 0, 0, 'L');
$pdf->Cell(10, 5, 'Cant.', 0, 0, 'L');
$pdf->Cell(15, 5, 'Precio', 0, 0, 'L');
$pdf->Cell(15, 5, 'Total.', 0, 1, 'L');
$pdf->SetFont('Arial', '', 7);
$total = 0.00;
while ($row = mysqli_fetch_assoc($ventas)) {
    $pdf->Cell(30, 5, $row['nombre'], 0, 0, 'L');
    $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
    $pdf->Cell(15, 5, $row['precio'], 0, 0, 'L');
    $sub_total = $row['total'];
    $total = $total + $sub_total;
    $pdf->Cell(15, 5, number_format($sub_total, 2, '.', ','), 0, 1, 'L');
}
while ($row = mysqli_fetch_assoc($ventas2)) {
    $pdf->Cell(30, 5, $row['descripcion'], 0, 0, 'L');
    $pdf->Cell(10, 5, $row['cantidad'], 0, 0, 'L');
    $pdf->Cell(15, 5, $row['precio'], 0, 0, 'L');
    $sub_total = $row['total'];
    $total = $total + $sub_total;
    $pdf->Cell(15, 5, number_format($sub_total, 2, '.', ','), 0, 1, 'L');
}
$pdf->Ln();

//$sql1=mysqli_query($conexion, "SELECT id_factura from tbl_factura  where id_cliente = $idcliente ");
//$row1=mysqli_fetch_assoc($sql1);
//$id_factura=$row1['id_factura'];

$sql2=mysqli_query($conexion, "SELECT total_descuento from tbl_factura where id_factura = $id");
$row2=mysqli_fetch_assoc($sql2);
$total_descuento=$row2['total_descuento'];

$sql3=mysqli_query($conexion, "SELECT subtotal from tbl_factura where id_factura = $id");
$row3=mysqli_fetch_assoc($sql3);
$subtotal=$row3['subtotal'];

$sql3=mysqli_query($conexion, "SELECT ISV from tbl_factura where id_factura = $id");
$row3=mysqli_fetch_assoc($sql3);
$ISV=$row3['ISV'];

$total_final=$subtotal-$total_descuento+$ISV;

$sql3=mysqli_query($conexion, "SELECT pago from tbl_factura where id_factura = $id");
$row3=mysqli_fetch_assoc($sql3);
$pago=$row3['pago'];

$sql3=mysqli_query($conexion, "SELECT cambio from tbl_factura where id_factura = $id");
$row3=mysqli_fetch_assoc($sql3);
$cambio=$row3['cambio'];

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'Sub Total', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($subtotal, 2, '.', ','), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'ISV', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($ISV, 2, '.', ','), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'Descuento Total', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($total_descuento, 2, '.', ','), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'Total Pagar', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($total_final, 2, '.', ','), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'Pago recibido', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($pago, 2, '.', ','), 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(65, 5, 'Cambio', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, number_format($cambio, 2, '.', ','), 0, 1, 'R');

$pdf->Output("ventas.pdf", "I");

?>