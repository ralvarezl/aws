<!DOCTYPE html>
<html>
<head>
	<title>Recuperacion de Contraseña</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style_default.css">
	<link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>
	<br></br>
    <form action="recuperacion.php" class="col-3 p-2 m-auto" method="post">
		<!--<img class="img" src="../../public/img/recuperar.png" />-->
		<h3 class="text-center text-secundary" >RECUPERAR CONTRASEÑA</h3>
		<?php
                include "../../modelo/conexion.php";
                include "../../controlador/recuperacion.php";

        ?> 		
		<!--INGRESE USUARIO-->
		<div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text"
			class="form-control" name="usuario"
				title="ingrese su nombre de usuario" autocomplete="usuario" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
		</div>

		<!--BOTONERIA-->
		<div class="d-grid">
            <button type="submit" class="btn btn-secondary mb-2" name="btnrecuperar" id="btnrecuperar" value="ok">Recuperar via correo</button>

			<button type="submit" class="btn btn-secondary mb-2" name="btnrecuperar_mjs" id="btnrecuperar_mjs" value="ok">Recuperar via pregunta secreta</button>

            <button type="button" class="btn btn-danger mb-2" onclick="location.href='../../login.php'" >Cancelar</button>
		</div>
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
</body>
</html>