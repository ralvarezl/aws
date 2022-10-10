<?php
include "../../modelo/conexion.php";
$id_usuario=$_GET["id_usuario"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_usuario where id_usuario=$id_usuario ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_usuarios.css">
    <title>Actualizar Usuario</title>
</head>
<body>
    <form class="col-3 p-2 m-auto" method="POST">
            <img class="img" src="../../public/img/avatar_actualizar.png" />
            <h3 class="text-center text-secundary" >ACTUALIZAR USUARIO</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_usuario" value="<?= $_GET["id_usuario"] ?>"> 
            <?php
            include "../../controlador/administracion_usuarios.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombres</label>
            <input type="text" class="form-control" placeholder="Ingrese nombres" 
                name="nombres" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->NOMBRES ?>">
            </div>
            <!--INGRESE USUARIO-->
            <div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text" class="form-control" name="usuario" 
                title="ingrese usuario" autocomplete="usuario" placeholder="Ingrese usuario" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->USUARIO ?>">
		    </div>
            <!--INGRESE CONTRASEÑA-->
            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="Ingrese contraseña" name="password" value="<?= $datos->PASSWORD ?>">
            </div>
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="text" class="form-control" placeholder="Ingrese numero de identidad" name="identidad" value="<?= $datos->IDENTIDAD ?>">
            </div>
            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="text" class="form-control" placeholder="Ingrese telefono" name="telefono" value="<?= $datos->TELEFONO ?>">
            </div>
            <!--INGRESE DIRECCIÓN-->
            <label for="formGroupExampleInput" class="form-label">Dirección</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->DIRECCION ?>">
            </div>
            <!--INGRESE CORREO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Correo</label>
            <input type="text" class="form-control" placeholder="Ingrese correo electronico" name="correo" value="<?= $datos->CORREO ?>">
            </div>
                                    <!--CAMPOS COMBOBOX-->
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
            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado">
            <option selected>Seleccione estado</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select estado from tbl_ms_estado");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['estado'].'">'.$datos['estado'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE ROL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            <option selected>Seleccione rol</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'">'.$datos['rol'].'</option>';
                }
            ?>
            </select>
            </div>
                
            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar" value="ok">Actualizar Usuario</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_usuarios.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>