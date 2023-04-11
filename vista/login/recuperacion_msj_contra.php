<?php
session_start();
if(empty($_SESSION['usuario_msj'])){
    header("location:../../index.php");
}
$usuario_msj= $_SESSION['usuario_msj'];

?>
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
    <form action="recuperacion_msj_contra.php" method="post" class="col-4 p-3 m-auto" id="form">
	<img src="../../public/img/pregunta.png" class="img-fluid rounded mx-auto d-block"/>
		<h3 class="text-center text-secundary" >RECUPERAR CONTRASEÑA</h3>
         <?php
                include "../../modelo/conexion.php";
                include "../../controlador/recuperacion_msj_contra.php";
        ?> 	
		<div class="mb-3">
		<label>Contraseña nueva: </label>
                <input type="password" id="InputPassword" class="form-control"
				name="nueva" title="contrasena_nueva" >
				<input type="checkbox" onclick="myFuction()"> ver contraseña
		</div>
		<script type="text/javascript">
			function myFuction(){
				var x = document.getElementById("InputPassword");
				if (x.type==="password") {
					x.type="text";
				}else{
					x.type="password";
				}
            }
        </script>

		<div class="mb-3">
		<label>Confirmar contraseña: </label>
                <input type="password" id="InputPassword1" class="form-control"
				name="confirmar" title="confirmar_contrasena" >
				<input type="checkbox" onclick="myFuction1()"> ver contraseña
		</div>
		<script type="text/javascript">
			function myFuction1(){
				var x = document.getElementById("InputPassword1");
				if (x.type==="password") {
					x.type="text";
				}else{
					x.type="password";
				}
            }
        </script>
		
		<!--BOTONERIA-->
		<div class="d-grid">	
		<input name="btnaceptar" id="btnaceptar" class="btn btn-secondary mb-2" title="Click para aceptar" type="submit" value="Aceptar" >
        <input name="btnautogenerar" id="btnautogenerar" class="btn btn-secondary mb-2" title="Click para autogenerar" type="submit" value="Autogenerar">
		<input name="btn_salir_msj_uno" id="btn_salir_msj_uno" class="btn btn-danger mb-2" title="Click para salir" type="submit" value="Salir">
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script> 
</body>
</html>