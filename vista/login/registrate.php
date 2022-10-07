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
		
			<!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombres</label>
            <input type="text" class="form-control" placeholder="Ingrese nombres" 
                name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE USUARIO-->
            <div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text" class="form-control" name="usuario" 
                title="ingrese usuario" autocomplete="usuario" placeholder="Ingrese usuario" onKeyUp="this.value=this.value.toUpperCase();">
		    </div>
            <!--INGRESE CONTRASEÑA-->
            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="Ingrese contraseña" name="password">
            </div>
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="number" class="form-control" placeholder="Ingrese numero de identidad" name="identidad">
            </div>
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
            <option selected>Seleccione genero</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select genero from tbl_ms_genero");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['genero'].'">'.$datos['genero'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="text" class="form-control" placeholder="Ingrese telefono" name="telefono">
            </div>
            <!--INGRESE DIRECCIÓN-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Dirección</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE CORREO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Correo</label>
            <input type="text" class="form-control" placeholder="Ingrese correo electronico" name="correo">
            </div>


		<input name="btnregistrate" class="btn btn-dark" title="click para ingresar" type="submit" value="REGISTRATE">
		<input onclick="location.href='../../login.php'" name="" class="btn btn-danger" title="click para ingresar" type="danger" value="SALIR">

   </form>
	
	<script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>  
</body>
</html>