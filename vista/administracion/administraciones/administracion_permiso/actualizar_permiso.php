<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_rol=$_GET["id_rol"];    //Guardamos el id estado desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_permisos where id_rol=$id_rol ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_permiso.css">
    <title>Actualizar Permiso</title>
</head>
<body>
    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <img src="../../../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR PERMISO</h3>
            <!--Imput que se oculta para almacenar el objeto para enviarlo a la BD-->
            <input type="hidden" name="id_rol" value="<?= $_GET["id_rol"] ?>"> 
            <?php
            //include "../../../../controlador/administraciones/administracion_objeto.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE ID_OBJETO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Objeto</label>
            <input type="text" class="form-control" placeholder="" 
                name="id_objeto" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->ID_OBJETO ?>">
            </div>

            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR SUCURSAL Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_permiso" value="ok">Actualizar Permiso</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_permiso.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>