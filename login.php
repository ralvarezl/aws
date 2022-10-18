<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="public/style_login.css">
	<link rel="shortcut icon" href="public/img/Logo.png">
</head>
<body>
	<BR></BR>
    <form action="login.php" class="col-3 p-3 m-auto" method="post">
		<img src="public/img/AVATAR.png" class="img-fluid rounded mx-auto d-block"/>
		<h2 class="text-center text-secundary" >BIENVENIDO</h2>
		 <?php
                include "modelo/conexion.php";
                include "controlador/login.php";
				include "controlador/cambiarpassword.php";
                ?> 		
		<!--INGRESE USUARIO-->
		<div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text"
			class="form-control" name="usuario" autofocus
				title="ingrese su nombre de usuario" autocomplete="usuario" value="" onKeyUp="this.value=this.value.toUpperCase(); ">
		</div>
		<!--INGRESE CONTRASEÑA-->
		<div class="mb-3">
			<div class="i">
				<i class="fas fa-lock"></i>
			</div>
			<div class="div">
				<label for="formGroupExampleInput" class="form-label">Contraseña</label>
				<input type="password" id="input" class="form-control"
					name="password" title="ingrese su clave para ingresar" autocomplete="current-password">
			</div>
		</div>

		<div class="view">
			<div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
		</div>
		<!--MODULO RECUPERAR CONTRASEÑA-->
		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
		<a class="btn btn-link text-dark mb-2" href="vista/login/recuperacion.php">Olvidé mi contraseña</a>
		</div>
		<!--BOTONERIA-->
		<div class="d-grid">
            <button type="submit" class="btn btn-secondary mb-2" name="btningresar" value="ok">INICIAR SESION</button>
            <button type="button" class="btn btn-dark mb-2" onclick="location.href='vista/login/registrate.php'" >REGISTRATE</button>
        </div>

   </form>

</body>
</html>