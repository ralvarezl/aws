<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_factura_descuento=$_GET["id_factura_descuento"];    //Guardamos el id factura descuento desde el boton editar
$sql=$conexion->query("select * from tbl_factura_descuento where id_factura_descuento=$id_factura_descuento");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <link rel="stylesheet" href="../../actualizar_usuarios.css">
    <title>Actualizar Factura Descuento</title>
</head>
<body>

        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <h3 class="text-center text-secundary">ACTUALIZAR FACTURA DESCUENTO</h3>
            <!--Imput que se oculta para almacenar la factura descuento para enviarlo a la BD-->
            <input type="hidden" name="id_factura_descuento" value="<?= $_GET["id_factura_descuento"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_actualizar_factura_descuento.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE VALOR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">TOTAL DESCUENTO</label>
            <input type="decimal" class="form-control" placeholder="Ingrese valor" 
                name="total_descuento" value="<?= $datos->TOTAL_DESCUENTO?>">
            </div>
            <?php }
            ?>
            <!--BOTON ACTUALIZAR LA FACTURA DESCUENTO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizar_factura_descuento" name="btnactualizarfacturadescuento" value="ok">Actualizar factura</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_factura_descuento.php'">Cancelar</button>
            </div>
            
    </form>
</body>
</html>