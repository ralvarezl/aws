<?php
session_start();

//Llamo el archivo del fpdf
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../../public/img/Logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',20);
    // Movernos a la derecha
    $this->Cell(110);
    // Título
    $this->Cell(80,10,'Reporte Usuarios',0,0,'C');
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
require ('../../modelo/conexion.php');
$busqueda=$_SESSION['busqueda'];

$consulta = "select id_usuario, nombres, usuario, identidad, genero, telefono, direccion, correo, estado, rol,fecha_vencimiento 
from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL 
where usuario <> 'ADMIN'
    and (id_usuario like '%$busqueda%' or 
        nombres like '%$busqueda%' or
        usuario like '%$busqueda%' or 
        identidad like '%$busqueda%' or 
        genero like '%$busqueda%' or 
        telefono like '%$busqueda%' or 
        direccion like '%$busqueda%' or 
        correo like '%$busqueda%' or 
        estado like '%$busqueda%' or
        r.rol like '%$busqueda%' or
        fecha_vencimiento like '%$busqueda%')
order by id_usuario asc";
$resultado = $conexion->query($consulta);

//Genero el pdf en vertical
$pdf = new PDF('L','mm','A4');
//Agrega la numeracion al pie de pagina
$pdf->AliasNbPages();
//Agrego una pagina
$pdf->AddPage();
//Le doy tipografia a esa pagina
$pdf->SetFont('Arial','',8);

//Imprimimos el header de la tabla
    $pdf->Cell(5, 10, 'ID', 1, 0, 'C', 0);
    $pdf->Cell(55, 10, 'NOMBRES', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'USUARIO', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'IDENTIDAD', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, 'GENERO', 1, 0, 'C', 0);
    $pdf->Cell(17, 10, 'TELEFONO', 1, 0, 'C', 0);
    $pdf->Cell(35, 10, 'DIRECCION', 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'CORREO', 1, 0, 'C', 0);
    $pdf->Cell(15, 10, 'ESTADO', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, 'ROL', 1, 0, 'C', 0);
    $pdf->Cell(22, 10, 'VENCIMIENTO', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(5, 10, $row['id_usuario'], 1, 0, 'C', 0);
    $pdf->Cell(55, 10, $row['nombres'], 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['usuario'], 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['identidad'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['genero'], 1, 0, 'C', 0);
    $pdf->Cell(17, 10, $row['telefono'], 1, 0, 'C', 0);
    $pdf->Cell(35, 10, $row['direccion'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $row['correo'], 1, 0, 'C', 0);
    $pdf->Cell(15, 10, $row['estado'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['rol'], 1, 0, 'C', 0);
    $pdf->Cell(22, 10, $row['fecha_vencimiento'], 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();
?>