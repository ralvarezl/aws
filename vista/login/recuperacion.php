<!DOCTYPE html>
<html>
<head>
	<title>Recuperacion de Contraseña</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../public/style.css">
</head>
<body>

    <form action="recuperacion.php" method="post" class="signup-form">
		<img class="img" src="../../public/img/AVATAR.png" />
     	<h2>Recuperar Contraseña</h2>
		<?php
                include "../../modelo/conexion.php";
                include "../../controlador/recuperacion.php";

        ?> 		
		<div class="usuario">
			<label>Usuario</label>
			<input id="usuario" type="text"
				class="input" name="usuario"
				title="ingrese su nombre de usuario" autocomplete="usuario" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
		</div>


		<input name="btnrecuperar" id="btnrecuperar" class="btn btn-secondary" title="click para ingresar" type="submit" value="ENVIAR CONTRASEÑA POR CORREO">
		<input name="btnrecuperar_mjs" id="btnrecuperar_mjs" class="btn btn-secondary" title="click para ingresar" type="submit" value="RECUPERAR POR PREGUNTA SECRETA">
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
</body>
</html>