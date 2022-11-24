<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_producto=$_GET["id_producto"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_producto where id_producto=$id_producto");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="../../actualizar_usuarios.css">
    <title>Actualizar Producto</title>
</head>
<body>

        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <h3 class="text-center text-secundary">ACTUALIZAR PRODUCTO</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_producto" value="<?= $_GET["id_producto"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_de_producto.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>

            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">NOMBRE</label>
            <input type="text" class="form-control" placeholder="Ingrese el nombre" onKeyUp="this.value=this.value.toUpperCase(); "
                name="nombre" value="<?= $datos->NOMBRE ?>">
            </div>

            <!--INGRESE TIPO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">TIPO</label>
            <input type="text" class="form-control" placeholder="Ingrese el tipo" onKeyUp="this.value=this.value.toUpperCase(); "
                name="tipo" value="<?= $datos->TIPO ?>">
            </div>

            <!--INGRESE CANTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">CANTIDAD</label>
            <input type="number" class="form-control" placeholder="Ingrese la cantidad" 
                name="cantidad" value="<?= $datos->CANTIDAD ?>">
            </div>

            <!--INGRESE PRECIO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">PRECIO</label>
            <input type="number" class="form-control" placeholder="Ingrese el precio" 
                name="precio" value="<?= $datos->PRECIO ?>">
            </div>
            <?php }
            ?>
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizar_producto" name="btnactualizarproducto" value="ok">Actualizar Producto</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_producto.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>