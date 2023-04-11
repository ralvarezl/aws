<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../index.php");
}
//Verificar permiso del rol
include "../../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=16");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    
    echo '<script language="javascript">alert("Sin acceso");;window.location.href="administracion_objeto.php"</script>';
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
    <title>Nuevo Permiso</title>
</head>
<body>
    <br><br>
    <!--INICIO DEL FORM REGISTRO PERMISO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/nuevo_permisos.jpg" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO PERMISO</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_permiso.php";
            ?>
            <!--SELECCIONE ROL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ROL</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            
            <?php 
            include "../../../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles where id_rol<>4");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'">'.$datos['rol'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE PANTALLA-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">PANTALLA</label>
            <select class="form-select" aria-label="Default select example" name="id_objeto">
            <option>SELECCIONE PANTALLA</option>
            <?php 
            include "../../../../modelo/conexion.php";
            $sql=$conexion->query("select id_objeto, objeto from tbl_ms_objetos");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_objeto'].'">'.$datos['objeto'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE PERMISO VISUALIZAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">VISUALIZAR</label>
            <select class="form-select" aria-label="Default select example" name="visualizar">
            <option value="PERMITIR">PERMITIR</option>
            <option value="NO PERMITIR">NO PERMITIR</option>
            </select>
            </div>
            <!--SELECCIONE PERMISO INSERTAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">REGISTRAR</label>
            <select class="form-select" aria-label="Default select example" name="registrar">
            <option value="PERMITIR">PERMITIR</option>
            <option value="NO PERMITIR">NO PERMITIR</option>
            </select>
            </div>
            <!--SELECCIONE PERMISO ACTUALIZAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ACTUALIZAR</label>
            <select class="form-select" aria-label="Default select example" name="actualizar">

            <option value="PERMITIR">PERMITIR</option>
            <option value="NO PERMITIR">NO PERMITIR</option>
            </select>
            </div>
            <!--SELECCIONE PERMISO ELIMINAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ELIMINAR</label>
            <select class="form-select" aria-label="Default select example" name="eliminar">
            <option value="PERMITIR">PERMITIR</option>
            <option value="NO PERMITIR">NO PERMITIR</option>
            </select>
            </div>
            
            <!--BOTON NUEVO OBJETO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrarpermiso" value="ok">Registrar Permiso</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_permiso.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO SUCURSAL-->
    </body>
</html>