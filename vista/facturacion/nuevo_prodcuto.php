<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <link rel="stylesheet" href="factura.css">
    <title>Nuevo Producto</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO USUARIOS-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE PRODUCTO</h3>
            <?php
            include "../../modelo/conexion.php";
            include "../../controlador/facturacion/administracion_de_factura.php";
            ?>
            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombre</label>
            <input type="text" class="form-control" placeholder="Ingrese el nombre del producto" 
                name="nombre" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE TIPO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Tipo</label>
            <input type="text" class="form-control" placeholder="Ingrese el tipo" 
                name="tipo" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE CANTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Cantidad</label>
            <input type="number" class="form-control" placeholder="Ingrese la cantidad" name="cantidad">
            </div>
            <!--INGRESE PRECIO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Precio</label>
            <input type="number" class="form-control" placeholder="Ingrese la fecha de incio" name="precio">
            </div>

            <!--BOTON NUEVO USUARIO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrarproducto" value="ok">Registrar Producto</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='nueva_factura.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO PROMOCION-->
    </body>
</html>