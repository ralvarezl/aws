<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../index.php");
}
//Verificar permiso del rol
include "../../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=6");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_cliente.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../../../../public/style_actualizar_nuevo.css">
    <title>Nuevo Producto</title>
</head>
<body>
<br></br>
    <!--INICIO DEL FORM REGISTRO USUARIOS-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE CLIENTE</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_de_cliente.php";
            ?>
            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">NOMBRE COMPLETO</label>
            <input type="text" class="form-control" placeholder="Ingrese el nombre completo" 
                name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
    
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">IDENTIDAD</label>
            <input type="number" min="0" class="form-control" placeholder="Ingrese el número de identidad" name="identidad">
            </div>

            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">GÉNERO</label>
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
            <label for="formGroupExampleInput" class="form-label">TELÉFONO</label>
            <input type="number" min="0" class="form-control" placeholder="Ingrese el número de teléfono" name="telefono">
            </div>

            <!--INGRESE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <input type="text" readonly="readonly" class="form-control" value="ACTIVO" name="estado">
            </div>

            <!--BOTON NUEVO CLIENTE-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrarcliente" value="ok">Registrar Cliente</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_cliente.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO CLIENTE-->
    </body>
</html>