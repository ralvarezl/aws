<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}
if(empty($_SESSION['usuario_login']) and empty($_SESSION['usuario_msj'])){
    header("location:../../login.php");
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
            <label for="formGroupExampleInput" class="form-label">Usuario</label>
            <input id="usuario" type="text" 
            class="form-control" name="usuario"
                title="ingrese su usuario" autocomplete="usuario" value="<?= $_SESSION['usuario_login'] ?>">
        </div>
        <!--INGRESE CONTRASEÑA ANTERIOR-->
        <div class="mb-3">
            <label for="" class="form-label">Contraseña Anterior</label>
            <input id="contraseñaanterior" type="password"
            class="form-control" name="contraseñaanterior"
                title="ingrese su contraseña anterior" autocomplete="contraseñaanterior" value="" >
        </div>
        <!--INGRESE NUEVA CONTRASEÑA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nueva contraseña</label>
            <input id="nuevacontraseña" type="password"
            class="form-control" name="nuevacontraseña"
                title="ingrese su nueva contraseña" autocomplete="nuevacontraseña" value="" >
        </div>
        <!--INGRESE CONFIRMAR CONTRASEÑA-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Confirmar contraseña</label>
            <input id="confirmarcontraseña" type="password"
            class="form-control" name="confirmarcontraseña"
                title="ingrese su confirmación de contraseña" autocomplete="confirmarcontraseña" value="" >

		</div>


	
        <!--BOTONERIA-->
		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-secondary" name="btnnuevacontraseña" id="btnnuevacontraseña" value="ok">Guardar Contraseña</button>
        <button type="button" class="btn btn-danger" name="btn_salir_cambiar_password" onclick="location.href='../../login.php'" >Salir</button>
        </div>
   </form>
	

</body>
</html>