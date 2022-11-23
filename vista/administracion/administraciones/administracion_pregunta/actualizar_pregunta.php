<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_pregunta=$_GET["id_pregunta"];    //Guardamos el id pregunta desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_preguntas where id_pregunta=$id_pregunta ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_pregunta.css">
    <title>Actualizar Pregunta</title>
</head>
<body>
    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <img src="../../../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR PRGUNTA</h3>
            <!--Imput que se oculta para almacenar EL estado para enviarlo a la BD-->
            <input type="hidden" name="id_pregunta" value="<?= $_GET["id_pregunta"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_pregunta.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE PREGUNTA-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Pregunta</label>
            <input type="text" class="form-control" placeholder="" 
                name="pregunta" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->PREGUNTA ?>">
            </div>

            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR PREGUNTA Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_pregunta" value="ok">Actualizar Pregunta</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_pregunta.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>