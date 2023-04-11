<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../index.php");
}
//Llamo el archivo del fpdf
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    require ('../../modelo/conexion.php');
    //preguntar el valor del nombre del negocio
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=11"); 
    $row=mysqli_fetch_array($sql);
    $nombre_negocio=$row[0]; //Guardamos el nombre del negocio

    //preguntar el valor del logo del negocio
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=12"); 
    $row=mysqli_fetch_array($sql);
    $logo_negocio=$row[0]; //Guardamos el logo del negocio

    // Logo
    $this->Image('../../public/img/'.$logo_negocio.'',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','',20);
    // Movernos a la derecha
    $this->Cell(110);
    // Título
    $this->Cell(80,10,utf8_decode(''.$nombre_negocio.''),0,0,'C');
    $this->Ln(10);
    $this->Cell(300,10,'Reporte Usuarios',0,0,'C');
    ///Direccion y Telefono
    $this->Ln(0);
    $this->SetFont('Arial','',10);
    $this->Cell(500,5,'Telefono: 9867-2309',0,0,'C');
    $this->Ln(5);
    $this->Cell(508,5,'Direccion: La paz, La paz',0,0,'C');
    $this->Ln(5);
    $this->Cell(498,5,'Barrio San Antonio',0,0,'C');
   
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
require ('../../modelo/conexion.php');
$busqueda=$_SESSION['busqueda'];

$consulta = "select id_usuario, nombres, usuario, identidad, genero, telefono, direccion, correo, u.estado, rol,fecha_vencimiento 
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
        u.estado like '%$busqueda%' or
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
    $pdf->Cell(5, 10,utf8_decode( 'N°'), 1, 0, 'C', 0);
    $pdf->Cell(55, 10, 'NOMBRES', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'USUARIO', 1, 0, 'C', 0);
    $pdf->Cell(25, 10, 'IDENTIDAD', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, utf8_decode('GÉNERO'), 1, 0, 'C', 0);
    $pdf->Cell(17, 10, utf8_decode('TELÉFONO'), 1, 0, 'C', 0);
    $pdf->Cell(35, 10, utf8_decode('DIRECCIÓN'), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, 'CORREO', 1, 0, 'C', 0);
    $pdf->Cell(15, 10, 'ESTADO', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, 'ROL', 1, 0, 'C', 0);
    $pdf->Cell(22, 10, 'VENCIMIENTO', 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
    $numero=0;
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(5, 10,$numero=$numero+1, 1, 0, 'C', 0);
    $pdf->Cell(55, 10,utf8_decode( $row['nombres']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['usuario']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['identidad']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['genero']), 1, 0, 'C', 0);
    $pdf->Cell(17, 10,utf8_decode( $row['telefono']), 1, 0, 'C', 0);
    $pdf->Cell(35, 10,utf8_decode( $row['direccion']), 1, 0, 'C', 0);
    $pdf->Cell(40, 10,utf8_decode( $row['correo']), 1, 0, 'C', 0);
    $pdf->Cell(15, 10,utf8_decode( $row['estado']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['rol']), 1, 0, 'C', 0);
    $pdf->Cell(22, 10,utf8_decode( $row['fecha_vencimiento']), 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();
?>