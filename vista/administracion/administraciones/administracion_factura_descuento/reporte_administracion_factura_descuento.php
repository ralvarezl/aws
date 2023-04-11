<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../index.php");
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
    $this->Cell(80,10,utf8_decode(''.$nombre_negocio.''),0,0,'C');
    $this->Ln(10);
    $this->Cell(210,10,'Reporte Factura Descuento',0,0,'C');
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
$consulta = "select total_descuento from tbl_factura_descuento";
$resultado = $conexion->query($consulta);

//Genero el pdf en vertical y tamaño carta
$pdf = new PDF('P','mm','Letter');
//Agrega la numeracion al pie de pagina
$pdf->AliasNbPages();
//Agrego una pagina
$pdf->AddPage();
//Le doy tipografia a esa pagina
$pdf->SetFont('Arial','',8);
// Movernos a la derecha
$pdf->Cell(65);

//Imprimimos el header de la tabla
    $pdf->Cell(10, 10,utf8_decode( 'N°'), 1, 0, 'C', 0);
    $pdf->Cell(55, 10, 'Descuento Total', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
    $numero=0;
while ($row = $resultado->fetch_assoc()) {
    // Movernos a la derecha
    $pdf->Cell(65);
    $pdf->Cell(10, 10,$numero=$numero+1, 1, 0, 'C', 0);
    $pdf->Cell(55, 10,utf8_decode( $row['total_descuento']), 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();
?>