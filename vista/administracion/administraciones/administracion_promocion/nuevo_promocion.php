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
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../../../../public/style_actualizar_nuevo.css">
    <title>Nueva Promocion</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO USUARIOS-->
    <br></br><br></br>
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE PROMOCION</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_de_promocion.php";
            ?>
            <!--INGRESE DESCRIPCION-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Descripción</label>
            <input type="text" class="form-control" placeholder="Ingrese el nombre la promocion" 
                name="descripcion" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE PRECIO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Precio</label>
            <input type="number" class="form-control" placeholder="Ingrese el precio" name="precio">
            </div>
            <!--BOTON NUEVO USUARIO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrarpromocion" value="ok">Registrar Promocion</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_promocion.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO PROMOCION-->
    </body>
</html>