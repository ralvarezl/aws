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
    $this->Cell(130,10,utf8_decode(''.$nombre_negocio.''),0,0,'C');
    $this->Ln(10);
    $this->Cell(260,10,'Reporte Objetos',0,0,'C');
    //Direccion y Telefono
    $this->Ln(0);
    $this->SetFont('Arial','',10);
    $this->Cell(460,5,'Telefono: 9867-2309',0,0,'C');
    $this->Ln(5);
    $this->Cell(468,5,'Direccion: La paz, La paz',0,0,'C');
    $this->Ln(5);
    $this->Cell(458,5,'Barrio San Antonio',0,0,'C');
   
    // Salto de línea
    $this->Ln(20);
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
$consulta = "select id_objeto, objeto, descripcion, tipo_objeto, estado from tbl_ms_objetos order by id_objeto asc";
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
    $pdf->Cell(85, 10,utf8_decode('OBJETO'), 1, 0, 'C', 0);
    $pdf->Cell(85, 10,utf8_decode('DESCRIPCION'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode('TIPO OBJETO'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, 'ESTADO', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
    $numero=0;
while ($row = $resultado->fetch_assoc()) {
    // Movernos a la derecha
    $pdf->Cell(10);
    $pdf->Cell(10, 10,$numero=$numero+1, 1, 0, 'C', 0);
    $pdf->Cell(85, 10,utf8_decode( $row['objeto']), 1, 0, 'C', 0);
    $pdf->Cell(85, 10,utf8_decode( $row['descripcion']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['tipo_objeto']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10,utf8_decode( $row['estado']), 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();

//Guardar la bitacora
$sesion_usuario=$_SESSION['usuario_login'];
date_default_timezone_set("America/Tegucigalpa");
$fecha = date('Y-m-d h:i:s');
$sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Reporte Objeto', 'Genero reporte de objeto','$sesion_usuario')");

?>