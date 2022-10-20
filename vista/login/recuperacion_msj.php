<?php

session_start();
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
				$sql=mysqli_query($conexion, "select   p.valor 
				from tbl_ms_usuario u 
				join tbl_ms_parametros p on p.id_usuario=u.id_usuario
				where  usuario='$usuario_msj' and parametro='ADMIN_PREGUNTAS'");
        		$row=mysqli_fetch_array($sql);
        		$valor=$row[0];
				
					if($valor==0){//if
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
		<button type="button" name="btn_salir_msj" class="btn btn-danger mb-2" onclick="location.href='recuperacion.php'" >Salir</button>
		</div>
		<?php
			}
			else{
				if($valor==1){//if
			
					?> 
		<div class="mb-3">
		<label>Contraseña nueva: </label>
                <input type="password" id="nueva" class="form-control"
				name="nueva" title="contrasena_nueva" >
		</div>
		<div class="mb-3">
		<label>Confirmar contraseña: </label>
                <input type="password" id="confirmar" class="form-control"
				name="confirmar" title="confirmar_contrasena" >
		</div>
		
		<!--BOTONERIA-->
		<div class="d-grid">	
		<input name="btnaceptar" id="btnaceptar" class="btn btn-secondary mb-2" title="Click para aceptar" type="submit" value="Aceptar" >
        <input name="btnautogenerar" id="btnautogenerar" class="btn btn-secondary mb-2" title="Click para autogenrar" type="submit" value="Autogenerar">
		<input name="btn_salir_msj_uno" id="btn_salir_msj_uno" class="btn btn-danger mb-2" title="Click para salir" type="submit" value="Salir">
		<?php
				}//If

			}//else
		?> 
   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script> 
</body>
</html>