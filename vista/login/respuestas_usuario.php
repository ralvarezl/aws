<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../public/style_login.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <title>Respuestas usuario</title>
</head>
<body>
    <br></br>
    <form action="respuestas_usuario.php" class="col-3 p-3 m-auto" method="post">
        <h3 class="text-center text-secundary" >Login Inicial</h3>
        <!--<?php
                include "../../modelo/conexion.php";
                include "../../controlador/cambiarpassword.php";
        ?> 	-->
        <!--MUESTRO USUARIO debe mostrar usuario que hizo el registro-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">USUARIO</label>
            <input type="text" class="form-control" name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        <!--PRIMERA PREGUNTA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">¿COMO SE LLAMA TU MASCOTA?</label>
            <input type="text" class="form-control" name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        <!--SEGUNDA PREGUNTA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">¿CUAL ES TU COLOR FAVORITO?</label>
            <input type="text" class="form-control" name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        <!--TERCERA PREGUNTA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">¿PRIMER NOMBRE DE TU ABUELO?</label>
            <input type="text" class="form-control" name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        <!--BOTONERIA-->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="logininicial" value="ok">GUARDAR</button>
            <button type="button" class="btn btn-danger" onclick="location.href='../../login.php'" >SALIR</button>
        </div>
    </form>
    
</body>
</html>