<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
//Llamo el archivo del fpdf
require('../../../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    require ('../../../../modelo/conexion.php');
    //preguntar el valor del nombre del negocio
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=11"); 
    $row=mysqli_fetch_array($sql);
    $nombre_negocio=$row[0]; //Guardamos el nombre del negocio

    //preguntar el valor del logo del negocio
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=12"); 
    $row=mysqli_fetch_array($sql);
    $logo_negocio=$row[0]; //Guardamos el logo del negocio

    // Logo
    $this->Image('../../../../public/img/'.$logo_negocio.'',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','',20);
    // Movernos a la derecha
    $this->Cell(65);
    // Título
    $this->Cell(130,10,utf8_decode(''.$nombre_negocio.''),0,0,'C');
    $this->Ln(10);
    $this->Cell(260,10,'Reporte Factura',0,0,'C');
    // Salto de línea
    $this->Ln(35);
}

// Pie de página
function Footer()
{
    //Guardo la fecha
    date_default_timezone_set("America/Tegucigalpa");
    $fecha = date('Y-m-d h:i');

    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    $this->Cell(-30,10,'Fecha: '.$fecha.'',0,0,'C');
}
}

//Llamo a la BD
require ('../../../../modelo/conexion.php');
$busqueda_factura=$_SESSION['busqueda_factura'];
$fecha_inicio=$_SESSION['fecha_inicio'];
$fecha_final=$_SESSION['fecha_final'];
$consulta = "select fecha, id_factura, subtotal, isv, total_descuento, total, pago, cambio, id_cliente, estado from tbl_factura
where fecha between '$fecha_inicio' and '$fecha_final' and
        id_factura like '%$busqueda_factura%' or
        subtotal like '%$busqueda_factura%' or
        isv like '%$busqueda_factura%' or
        total_descuento like '%$busqueda_factura%' or
        total like '%$busqueda_factura%' or
        pago like '%$busqueda_factura%' or
        cambio like '%$busqueda_factura%' or
        id_cliente like '%$busqueda_factura%' or
        estado like '%$busqueda_factura%' 
order by id_factura desc";
$resultado = $conexion->query($consulta);

//Genero el pdf en vertical y tamaño carta
$pdf = new PDF('L','mm','Letter');
//Agrega la numeracion al pie de pagina
$pdf->AliasNbPages();
//Agrego una pagina
$pdf->AddPage();
//Le doy tipografia a esa pagina
$pdf->SetFont('Arial','',8);
// Movernos a la derecha
$pdf->Cell(10);

//Imprimimos el header de la tabla
    $pdf->Cell(10, 10,utf8_decode('N°'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode('NUMERO FACTURA'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode('FECHA'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode('SUB TOTAL'), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode('ISV'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode('TOTAL DESCUENTO'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode('TOTAL'), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode('PAGO'), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode('CAMBIO'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, 'ESTADO', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
    $numero=0;
while ($row = $resultado->fetch_assoc()) {
    // Movernos a la derecha
    $pdf->Cell(10);
    $pdf->Cell(10, 10,$numero=$numero+1, 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['id_factura']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['fecha']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['subtotal']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['isv']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['total_descuento']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['total']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['pago']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['cambio']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['estado']), 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();

//Guardar la bitacora
$sesion_usuario=$_SESSION['usuario_login'];
date_default_timezone_set("America/Tegucigalpa");
$fecha = date('Y-m-d h:i:s');
$sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Reporte Factura', 'Genero reporte especifico de factura','$sesion_usuario')");

?>