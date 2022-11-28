<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}
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
    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <img src="../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR DATOS</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_usuario" value="<?= $_GET["id_usuario"] ?>"> 
            <?php
            include "../../controlador/perfil_usuario.php";
            
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
            <!--INGRESE password-->
            <div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Contraseña</label>
			<input id="usuario" type="text" class="form-control" name="password" 
                 placeholder="" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->PASSWORD ?>">
		    </div>
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="number" class="form-control" placeholder="Ingrese numero de identidad" name="identidad" value="<?= $datos->IDENTIDAD ?>">
            </div>
            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="number" class="form-control" placeholder="Ingrese telefono" name="telefono" value="<?= $datos->TELEFONO ?>">
            </div>
            <?php }
            ?>
            <!--SELECCIONE PREGUNTAS-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Preguntas</label>
            <select class="form-select" aria-label="Default select example" name="pregunta">
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("SELECT pu.id_pregunta,PREGUNTA, RESPUESTA FROM TBL_MS_PREGUNTAS_USUARIO PU
            INNER JOIN tbl_ms_preguntas P ON P.ID_PREGUNTA=PU.ID_PREGUNTA
            WHERE ID_USUARIO=$id_usuario");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_pregunta'].'">'.$datos['PREGUNTA'].'R='.$datos['RESPUESTA'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--INGRESE RESPUESTA-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Respuesta</label>
            <input type="text" class="form-control" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese respuesta" name="respuesta" value="">
            </div>
           
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="perfil" value="ok">Actualizar Datos</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='perfil_usuario.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>