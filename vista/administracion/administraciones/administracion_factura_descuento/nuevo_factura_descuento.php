<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
//Verificar permiso del rol
include "../../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=17");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_descuento.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../../../../public/style_actualizar_nuevo.css">
    <title>Nueva Factura Descuento</title>
</head>
<body>
   <br><br><br><br><br><br>  
    <!--INICIO DEL FORM REGISTRO TIPO DE PEDIDO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
        <img src="../../../../public/img/nuevo_factura_des.jpg" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">NUEVA FACTURA DESCUENTO</h3>
            
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_actualizar_factura_descuento.php";
            ?>

            <!--INGRESE TOTAL DESCUENTO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">INGRESE TOTAL DESCUENTO</label>
            <input type="decimal" class="form-control" placeholder="Ingrese total descuento" 
                name="total_descuento" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            
            <!--BOTON REGISTRAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btn_nuevo_factura_descuento" name="btn_nuevo_factura_descuento" value="ok">Registrar Descuento</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_factura_descuento.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>