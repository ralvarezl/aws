<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cambio de contraseña</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style_default.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>
    <br></br>
    <form action="cambiarpassword.php" class="col-4 p-3 m-auto" method="post">
		<!--<img class="img" src="../../public/img/AVATAR.png" />-->
        <h3 class="text-center text-secundary" >CAMBIO DE CONTRASEÑA</h3>
		<?php
                include "../../modelo/conexion.php";
                include "../../controlador/cambiarpassword.php";
        ?> 		
        <!--INGRESE USUARIO-->
		<div class="mb-3">
            <input  id="usuario" type="hidden"
            class="form-control" name="usuario"
             value="<?= $_SESSION['usuario_login'] ?>">
        </div>
        <!--INGRESE CONTRASEÑA ANTERIOR-->
        <div class="mb-3">
            <label for="" class="form-label">Ingrese Token de Recuperación</label>
            <input id="InputPassword" type="password"
            class="form-control" name="contraseñaanterior"
            title="ingrese su contraseña anterior" autocomplete="contraseñaanterior" value="" >
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
        <!--INGRESE NUEVA CONTRASEÑA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nueva contraseña</label>
            <input id="InputPassword1" type="password"
            class="form-control" name="nuevacontraseña"
            title="ingrese su nueva contraseña" autocomplete="nuevacontraseña" value="" >
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
        <!--INGRESE CONFIRMAR CONTRASEÑA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Confirmar contraseña</label>
            <input id="InputPassword2" type="password"
            class="form-control" name="confirmarcontraseña"
            title="ingrese su confirmación de contraseña" autocomplete="confirmarcontraseña" value="" >
            <input type="checkbox" onclick="myFuction2()"> ver contraseña
		</div>
            <script type="text/javascript">
			function myFuction2(){
				var x = document.getElementById("InputPassword2");
				if (x.type==="password") {
					x.type="text";
				}else{
					x.type="password";
				}
            }
            </script>
	
        <!--BOTONERIA-->
		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-secondary" name="btnnuevacontraseña" id="btnnuevacontraseña" value="ok">Guardar Contraseña</button>
        <button type="button" class="btn btn-danger" name="btn_salir_cambiar_password" onclick="location.href='../../index.php'" >Salir</button>
        </div>
   </form>
	

</body>
</html>