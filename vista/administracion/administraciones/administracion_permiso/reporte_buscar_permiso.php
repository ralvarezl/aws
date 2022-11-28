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
    $this->Cell(35);
    // Título
    $this->Cell(130,10,utf8_decode(''.$nombre_negocio.''),0,0,'C');
    $this->Ln(10);
    $this->Cell(200,10,'Reporte Permisos',0,0,'C');
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
$busqueda_permiso=$_SESSION['busqueda_permiso'];
$consulta = "select p.id_rol, p.id_objeto, rol, objeto, permiso_visualizar, permiso_insertar, permiso_actualizar, permiso_eliminar from tbl_ms_permisos p inner join tbl_ms_roles r on r.id_rol=p.id_rol inner join tbl_ms_objetos o on o.id_objeto=p.id_objeto 
    where   rol like '%$busqueda_permiso%' and r.id_rol<>4 or
        objeto like '%$busqueda_permiso%' and r.id_rol<>4 or
        permiso_visualizar like '%$busqueda_permiso%' and r.id_rol<>4 or
        permiso_insertar like '%$busqueda_permiso%' and r.id_rol<>4 or
        permiso_actualizar like '%$busqueda_permiso%' and r.id_rol<>4 or
        permiso_eliminar like '%$busqueda_permiso%' and r.id_rol<>4 and
        p.id_rol<>'4'
order by id_rol";
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
$pdf->Cell(5);

//Imprimimos el header de la tabla
    $pdf->Cell(5, 10,utf8_decode( 'N°'), 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode('ROL'), 1, 0, 'C', 0);
    $pdf->Cell(60, 10,utf8_decode('OBJETO'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode('VISUALIZAR'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode('INSERTAR'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode('ACTUALIZAR'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode('ELIMINAR'), 1, 1, 'C', 0);

//Hacemos el recorrido del resultado que se trae de la BD
$numero=0;
while ($row = $resultado->fetch_assoc()) {
    // Movernos a la derecha
    $pdf->Cell(5);
    $pdf->Cell(5, 10,$numero=$numero+1, 1, 0, 'C', 0);
    $pdf->Cell(20, 10,utf8_decode( $row['rol']), 1, 0, 'C', 0);
    $pdf->Cell(60, 10,utf8_decode( $row['objeto']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['permiso_visualizar']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['permiso_insertar']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['permiso_actualizar']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10,utf8_decode( $row['permiso_eliminar']), 1, 1, 'C', 0); //En la ultima celda le digo que haga un salto de linea
}

//Genero la salida
$pdf->Output();

//Guardar la bitacora
$sesion_usuario=$_SESSION['usuario_login'];
date_default_timezone_set("America/Tegucigalpa");
$fecha = date('Y-m-d h:i:s');
$sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Reporte Permisos', 'Genero reporte especifico de permisos','$sesion_usuario')");

?>