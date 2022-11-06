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
            <h3 class="text-center text-secundary">ACTUALIZAR USUARIO</h3>
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
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="text" class="form-control" placeholder="Ingrese numero de identidad" name="identidad" value="<?= $datos->IDENTIDAD ?>">
            </div>
            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="number" class="form-control" placeholder="Ingrese telefono" name="telefono" value="<?= $datos->TELEFONO ?>">
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
            <?php }
            ?>
                                    <!--CAMPOS COMBOBOX-->
            <!--GENERO-->                        
            <?php
            include "../../modelo/conexion.php";
            $id_usuario=$_GET["id_usuario"];    //Guardamos el id usuario desde el boton editar
            $sql=$conexion->query(" select * from tbl_ms_usuario where id_usuario=$id_usuario ");
            ?>
             <?php
            include_once "../../controlador/administracion_usuarios.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->GENERO ?>"><?= $datos->GENERO ?></option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select genero from tbl_ms_genero where genero<>'$datos->GENERO'" );
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['genero'].'" >'.$datos['genero'].'</option>';
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            <!--ESTADO-->
            <!--SELECCIONE ESTADO-->
            <?php
            include "../../modelo/conexion.php";
            $id_usuario=$_GET["id_usuario"];    //Guardamos el id usuario desde el boton editar
            $sql=$conexion->query(" select * from tbl_ms_usuario where id_usuario=$id_usuario ");
            ?>
             <?php
            include_once "../../controlador/administracion_usuarios.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado">
            <!--SELECCIONA EL ESTADO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->ESTADO ?>"><?= $datos->ESTADO ?></option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select estado from tbl_ms_estado where estado<>'$datos->ESTADO'" );
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['estado'].'" >'.$datos['estado'].'</option>';
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            <!--ROL-->
            <!--SELECCIONE ROL-->
            <?php
            include "../../modelo/conexion.php";
            $id_usuario=$_GET["id_usuario"];    //Guardamos el id usuario desde el boton editar
            $sql=$conexion->query(" select u.id_rol ,r.rol  from tbl_ms_usuario u join tbl_ms_roles r on r.id_rol=u.id_rol where id_usuario=$id_usuario ");
            ?>
             <?php
            include_once "../../controlador/administracion_usuarios.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE ROL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            <!--SELECCIONA EL ROL YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->id_rol ?>"><?= $datos->rol ?></option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles where id_rol<>'$datos->id_rol'" );
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'" >'.$datos['rol'].'</option>';
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            <!--INGRESE FECHA VENCIMIENTO(BLOQUEADO)-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Fecha de Vencimiento</label>
            <input type="text" readonly="readonly" class="form-control" value="fecha" name="correo">
            </div>
            
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar" value="ok">Actualizar Usuario</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_usuarios.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>