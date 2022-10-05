<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="public/style.css">
	<link rel="shortcut icon" href="public/img/Logo.png">
</head>
<body>

    <form action="login.php" method="post">
		<img class="img" src="public/img/AVATAR.png" />
     	<h2>BIENVENIDO</h2>
		 <?php
                include "modelo/conexion.php";
                include "controlador/login.php";
                ?> 		
		<div class="usuario">
			<label>Usuario</label>
			<input id="usuario" type="text"
				class="input" name="usuario"
				title="ingrese su nombre de usuario" autocomplete="usuario" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
		</div>

		<div class="input-div pass">
			<div class="i">
				<i class="fas fa-lock"></i>
			</div>
			<div class="div">
				<label>Contraseña</label>
				<input type="password" id="input" class="input"
					name="password" title="ingrese su clave para ingresar" autocomplete="current-password">
			</div>
		</div>

		<div class="view">
			<div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
		</div>

		<a class="btn btn-link" href="">Olvidé mi contraseña</a>

		<input name="btningresar" class="btn btn-secondary" title="click para ingresar" type="submit" value="INICIAR SESION">
		<input onclick="location.href='vista/login/registrate.php'" name="" class="btn btn-dark" title="click para registrar un nuevo usuario" type="dark" value="REGISTRATE">

   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</body>
</html>