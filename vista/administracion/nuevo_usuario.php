<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}

//Verificar permiso del rol
include "../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=5");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_usuarios.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../../public/style_actualizar_nuevo.css">
    <title>Nuevo Usuario</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO USUARIOS-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE USUARIOS</h3>
            <?php
            include "../../modelo/conexion.php";
            include "../../controlador/administracion_usuarios.php";
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
            <input type="password" class="form-control" placeholder="Ingrese contraseña" id="InputPassword" name="password">
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
            <!--REPITA CONTRASEÑA-->
            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Repita Contraseña</label>
            <input type="password" id="InputPassword1" class="form-control" placeholder="Repita contraseña" name="r_password">
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
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="number" class="form-control" placeholder="Ingrese numero de identidad" name="identidad">
            </div>
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
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
            <input type="number" class="form-control" placeholder="Ingrese telefono" name="telefono">
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
            <!--INGRESE ESTADO(BLOQUEADO)-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Estado</label>
            <input type="text" readonly="readonly" class="form-control" value="NUEVO" name="estado">
            </div>
            <!--SELECCIONE ROL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'">'.$datos['rol'].'</option>';
                }

                $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='5'");
                $row=mysqli_fetch_array($sql);
                $valor_parm=$row[0];
                
                $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL $valor_parm DAY)"); 
                $row=mysqli_fetch_array($sql);
                $fecha_vencimiento=$row[0];
            ?>
            </select>
            </div>
            <!--INGRESE FECHA VENCIMIENTO(BLOQUEADO)-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Fecha de Vencimiento</label>
            <input type="text" readonly="readonly" class="form-control" value="<?= $fecha_vencimiento?>" name="fecha_vencimiento">
            </div>

            <!--BOTON NUEVO USUARIO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrar" value="ok">Registrar Cliente</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_usuarios.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO USUARIOS-->
    </body>
</html>