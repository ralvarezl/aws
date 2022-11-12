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
    <link rel="stylesheet" href="../../actualizar_usuarios.css">
    <title>Nuevo Tipo de Pedido</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO TIPO DE PEDIDO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">NUEVO TIPO DE PEDIDO</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_tipo_pedido.php";
            ?>
            <!--INGRESE DESCRIPCIÓN-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">TIPO DE PEDIDO</label>
            <input type="text" class="form-control" placeholder="Ingrese el tipo de pedido" 
                name="descripcion" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
          
            

            <!--BOTON TIPO DE PEDIDO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btntipopedido" value="ok">Ingresar Tipo de Pedidio</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_tipo_pedido.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM TIPO DE PEDIDO-->
    </body>
</html>