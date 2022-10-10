<!DOCTYPE html>	
<html>
<head>
	<title>Recuperacion de Contraseña</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../public/style.css">
	<link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>

    <form action="recuperacion_msj.php" method="post" class="signup-form" id="form">
		<img class="img" src="../../public/img/AVATAR.png" />
     	<h2>Recuperar Contraseña</h2>

         <?php
                include "../../modelo/conexion.php";
                include "../../controlador/recuperacion_msj.php";
        ?> 	

        <div class="seleccione_pregunta">
			<label>Seleccione la pregunta: 
			<select name = "id_pregunta" id = "id_pregunta">

				<option value = "0" >Seleccione la pregunta:</option>
			
			<?php foreach($ejecutar as $opciones): ?> 	
			
				<option value = "<?php echo $opciones['ID_PREGUNTA'] ?>" id="pregunta" name="pregunta"><?php echo $opciones['PREGUNTA'] ?> </option>
			
			<?php endforeach ?>


			</select></label>
		</div>

		<div class="respuesta">
		<label>Respuesta: </label>
            <input id="respuesta" type="text"  class="input"
				name="respuesta" title="respuesta" value="" >

			<label>Contraseña nueva: </label>
                <input type="text" id="nueva" class="input"
				name="nueva" title="contrasena_nueva" >

			<label>Confirmar contraseña: </label>
                <input type="respuesta" id="confirmar" class="input"
				name="confirmar" title="confirmar_contrasena" >
		</div>
		<input name="btnaceptar" id="btnaceptar" class="btn btn-secondary" title="click para aceptar" type="submit" value="Aceptar" >
		<input name="btnsiguiente" id="btnsiguiente" class="btn btn-secondary" title="click para siguiente" type="submit" value="Siguiente" >
        <input name="btnautogenerar" id="btnautogenerar" class="btn btn-secondary" title="click para autogenrar" type="submit" value="autogenerar">
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script> 
</body>
</html>