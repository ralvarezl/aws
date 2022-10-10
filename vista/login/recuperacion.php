<!DOCTYPE html>
<html>
<head>
	<title>Recuperacion de Contraseña</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="styleRecuperar.css">
	<link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>

    <form class="col-3 p-2 m-auto" action="recuperacion.php" method="post">
		<img class="img" src="../../public/img/recuperar.png" />
		<h3 class="text-center text-secundary" >RECUPERAR CONTRASEÑA</h3>
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
		
		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
		<button type="button" class="btn btn-outline-danger" onclick="location.href='../../login.php'" >Cancelar</button>
		</div>
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
</body>
</html>