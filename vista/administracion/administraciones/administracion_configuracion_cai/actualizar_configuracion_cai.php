<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_configuracion_cai=$_GET["id_configuracion_cai"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_configuracion_cai where id_configuracion_cai=$id_configuracion_cai ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_configuracion_cai.css">
    <title>Actualizar Configuracion Cai</title>
</head>
<body>

        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <h3 class="text-center text-secundary">ACTUALIZAR CONFIGURACION CAI</h3>
            <!--Imput que se oculta para almacenar el id configuracion cai para enviarlo a la BD-->
            <input type="hidden" name="id_configuracion_cai" value="<?= $_GET["id_configuracion_cai"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_configuracion_cai.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE NUMERO CAI-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">INGRESE NUMERO CAI</label>
            <input type="text" class="form-control" placeholder="Ingrese numero cai" 
                name="numero_cai" value="<?= $datos->NUMERO_CAI ?>">
            </div>
            
            <!--INGRESE SECUENCIA INICIAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA INICIAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_inicial" value="<?= $datos->SECUENCIA_INICIAL ?>">
            </div>

            <!--INGRESE SECUENCIA ACTUAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA ACTUAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_actual" value="<?= $datos->SECUENCIA_ACTUAL ?>">
            </div>

            <!--INGRESE SECUENCIA FINAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA FINAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_final" value="<?= $datos->SECUENCIA_FINAL ?>">
            </div>

            <?php }
            ?>
            <!--BOTON ACTUALIZAR CONFIGURACION CAI Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btn_actualizar_configuracion_cai" name="btn_actualizar_configuracion_cai" value="ok">Actualizar Configuracion Cai</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_configuracion_cai.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>