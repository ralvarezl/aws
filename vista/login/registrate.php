<!DOCTYPE html>
<html>
<head>
	<title>REGISTRATE</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../public/style.css">
	<link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>

    <form action="registrate.php" method="post">
		<img class="img" src="../../public/img/AVATAR.png" />
     	<h2>REGISTRO DE USUARIO</h2>
		 <?php
                include "../../modelo/conexion.php";       
                include "../../controlador/registrate.php";  
                ?> 		
		
		<div class="nombres">
			<label>Nombre y Apellido</label>
			<input id="nombres" type="text"
				class="input" name="nombres"
				title="ingrese sus nombres" autocomplete="nombres" value="" onKeyUp="this.value=this.value.toUpperCase();" >
		</div>

		<div class="identidad">
			<label>Identidad</label>
			<input id="identidad" type="text"
				class="input" name="identidad"
				title="ingrese su identidad" autocomplete="identidad" value="" onKeyUp="this.value=this.value.toUpperCase();">
		</div>
		
		<div class="usuario">
			<label>Ingrese Usuario</label>
			<input id="usuario" type="text"
				class="input" name="usuario"
				title="ingrese su nombre de usuario" autocomplete="usuario" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
		</div>

		<div class="input-div pass">
			<div class="i">
				<i class="fas fa-lock"></i>
			</div>
			<div class="div">
				<label>Ingrese Contraseña</label>
				<input type="password" id="input" class="input"
					name="password" title="ingrese su clave para ingresar" autocomplete="current-password">
			</div>
		</div>

		<div class="view">
			<div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
		</div>

        <div class="input-div pass">
			<div class="i">
				<i class="fas fa-lock"></i>
			</div>
			<div class="div">
				<label>Repita Contraseña</label>
				<input type="password" id="input" class="input"
					name="r_password" title="repita su clave para ingresar" autocomplete="current-password">
			</div>
		</div>

		<div class="view">
			<div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
		</div>

        <div class="correo">
			<label>Ingrese Correo Electronico</label>
			<input id="usuario" type="text"
				class="input" name="correo"
				title="ingrese su correo electronico" autocomplete="correo" value="">


		<input name="btnregistrate" class="btn btn-dark" title="click para ingresar" type="submit" value="REGISTRATE">
		<input onclick="location.href='../../login.php'" name="" class="btn btn-danger" title="click para ingresar" type="danger" value="SALIR">

   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
</body>
</html>