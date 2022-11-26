<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
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
    <link rel="stylesheet" href="actualizar_objeto.css">
    <title>Nuevo Objeto</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO OBJETO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO OBJETO</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_objeto.php";
            ?>
            <!--INGRESE OBJETO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Objeto</label>
            <input type="text" class="form-control" placeholder="" 
                name="objeto" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE DESCRIPCION-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Descripcion</label>
            <input type="text" class="form-control" placeholder="" 
                name="descripcion" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE TIPO OBJETO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Tipo Objeto</label>
            <input type="text" class="form-control" placeholder="" 
                name="tipo_objeto" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

            <!--INGRESE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <select class="form-select" aria-label="Default select example" name="estado">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
                        
            </div>
            
            <!--BOTON NUEVO OBJETO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrar_objeto" value="ok">Registrar Objeto</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_objeto.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO SUCURSAL-->
    </body>
</html>