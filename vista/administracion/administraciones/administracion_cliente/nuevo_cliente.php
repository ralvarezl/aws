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
    <link rel="stylesheet" href="../../actualizar_usuarios.css">
    <title>Nuevo Producto</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO USUARIOS-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE CLIENTE</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_de_cliente.php";
            ?>
            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombres</label>
            <input type="text" class="form-control" placeholder="Ingrese sus nombres" 
                name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE APELLIDO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Apellidos</label>
            <input type="text" class="form-control" placeholder="Ingrese sus apellidos" 
                name="apellidos" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="number" class="form-control" placeholder="Ingrese numero de identidad" name="identidad">
            </div>

            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select genero from tbl_ms_genero");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['genero'].'">'.$datos['genero'].'</option>';
                }
            ?>
            </select>
            </div>

            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="number" class="form-control" placeholder="Ingrese telefono" name="telefono">
            </div>

            <!--BOTON NUEVO CLIENTE-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrarcliente" value="ok">Registrar Cliente</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_cliente.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO CLIENTE-->
    </body>
</html>