<!DOCTYPE html>
<html>
<head>
	<title>REGISTRATE</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style_default.css">
	<link rel="shortcut icon" href="../../public/img/Logo.png">
</head>
<body>
  
    <form action="registrate.php" class="col-4 p-3 m-auto" method="post">
		<!--<img class="img" src="../../public/img/AVATAR.png" />-->
        <h3 class="text-center text-secundary" >REGISTRO DE USUARIO</h3>
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
			<!--REPITA CONTRASEÑA-->
            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repita Contraseña</label>
            <input type="password" class="form-control" placeholder="Repita contraseña" name="r_password">
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


            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnregistrate" value="ok">REGISTRATE</button>
            <button type="button" class="btn btn-danger" onclick="location.href='../../login.php'" >SALIR</button>
            </div>


   </form> 

</body>
</html>