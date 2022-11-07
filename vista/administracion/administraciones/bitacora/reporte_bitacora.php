<?php
//Llamo el archivo del fpdf
require('../../../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../../../public/img/Logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',20);
    // Movernos a la derecha
    $this->Cell(90);
    // Título
    $this->Cell(80,10,'Reporte Bitacora',0,0,'C');
    // Salto de línea
    $this->Ln(35);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Llamo a la BD
require ('../../../../modelo/conexion.php');
$consulta = "select fecha_bitacora, accion, descripcion, creado_por from tbl_ms_bitacora order by id_bitacora desc";
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
$pdf->Cell(20);

//Imprimimos el header de la tabla
    $pdf->Cell(55, 10, 'FECHA', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'ACCION', 1, 0, 'C', 0);
    $pdf->Cell(65, 10, 'DESCRIPCION', 1, 0, 'C', 0);
    $pdf->Cell(55, 10, 'HECHO POR', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
while ($row = $resultado->fetch_assoc()) {
    // Movernos a la derecha
    $pdf->Cell(20);
    $pdf->Cell(55, 10, $row['fecha_bitacora'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $row['accion'], 1, 0, 'C', 0);
    $pdf->Cell(65, 10, $row['descripcion'], 1, 0, 'C', 0);
    $pdf->Cell(55, 10, $row['creado_por'], 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();
?>