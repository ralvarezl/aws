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

    <form action="cambiarpassword.php" method="post" class="signup-form">
		<img class="img" src="../../public/img/AVATAR.png" />
     	<h2>Cambiar Contraseña</h2>
		<?php
                include "../../modelo/conexion.php";
                include "../../controlador/cambiarpassword.php";
        ?> 		
		<div class="usuario">
            <label>Usuario</label>
            <input id="usuario" type="text"
                class="input" name="usuario"
                title="ingrese su usuario" autocomplete="usuario" value="" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            
            <label>Contraseña Anterior</label>
            <input id="contraseñaanterior" type="text"
                class="input" name="contraseñaanterior"
                title="ingrese su contraseña anterior" autocomplete="contraseñaanterior" value="" >

            <label>Nueva contraseña</label>
            <input id="nuevacontraseña" type="text"
                class="input" name="nuevacontraseña"
                title="ingrese su nueva contraseña" autocomplete="nuevacontraseña" value="" >

            <label>Confirmar contraseña</label>
            <input id="confirmarcontraseña" type="text"
                class="input" name="confirmarcontraseña"
                title="ingrese su confirmación de contraseña" autocomplete="confirmarcontraseña" value="" >

		</div>


		<input name="btnnuevacontraseña" id="btnnuevacontraseña" class="btn btn-secondary" title="click para ingresar" type="submit" value="Guardar Contraseña">
		
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script> 
    <!--<script src="../../js/Password.js"></script> -->
</body>
</html>