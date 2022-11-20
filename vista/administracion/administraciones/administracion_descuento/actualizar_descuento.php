<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_descuento=$_GET["id_descuento"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_descuento where id_descuento=$id_descuento ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_descuento.css">
    <title>Actualizar Descuento</title>
</head>
<body>

        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <h3 class="text-center text-secundary">ACTUALIZAR DESCUENTO</h3>
            <!--Imput que se oculta para almacenar el id descuento para enviarlo a la BD-->
            <input type="hidden" name="id_descuento" value="<?= $_GET["id_descuento"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_descuento.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE DESCRIPCION-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">INGRESE DESCRIPCION</label>
            <input type="text" class="form-control" placeholder="Ingrese descripcion" 
                name="descripcion" value="<?= $datos->DESCRIPCION ?>">
            </div>
            
            <!--INGRESE PORCENTAJE DESCUENTO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">PORCENTAJE DESCUENTO</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="porcentaje_descuento" value="<?= $datos->PORCENTAJE_DESCUENTO ?>">
            </div>

            <?php }
            ?>
            <!--BOTON ACTUALIZAR DESCUENTO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btn_actualizar_descuento" name="btn_actualizar_descuento" value="ok">Actualizar Descuento</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_descuento.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>