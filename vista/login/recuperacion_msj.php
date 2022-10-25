<?php
session_start();
if(empty($_SESSION['usuario_msj'])){
    header("location:../../login.php");
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
    <form action="recuperacion_msj.php" method="post" class="col-4 p-3 m-auto" id="form">
	<img src="../../public/img/pregunta.png" class="img-fluid rounded mx-auto d-block"/>
		<h3 class="text-center text-secundary" >RECUPERAR CONTRASEÑA</h3>
         <?php
                include "../../modelo/conexion.php";
                include "../../controlador/recuperacion_msj.php";
        ?> 	

			<div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Seleccione la pregunta:</label>
			<select class="form-select" aria-label="Default select example" name = "id_pregunta" id = "id_pregunta">

				<!--<option value = "" ></option>-->
			
			<?php foreach($ejecutar as $opciones): ?> 	
			
				<option value = "<?php echo $opciones['ID_PREGUNTA'] ?>"><?php echo $opciones['PREGUNTA'] ?> </option>
			
			<?php endforeach ?>


			</select></label>
		</div>

		<div class="mb-3">
		<label class="form-label">Respuesta:</label>
            <input id="respuesta" type="text"  class="form-control"
				name="respuesta" title="respuesta" value="" onKeyUp="this.value=this.value.toUpperCase();">
		</div>

		<!--BOTONERIA-->
		<div class="d-grid">
		<input name="btnsiguiente" id="btnsiguiente" class="btn btn-secondary mb-2" title="click para siguiente" type="submit" value="Siguiente" >
		<input name="btn_salir_msj" id="btn_salir_msj" class="btn btn-danger mb-2" title="click para siguiente" type="submit" value="Salir" >
		</div>
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script> 
</body>
</html>