<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
//Verificar permiso del rol
include "../../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=3");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_descuento.php"</script>';
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
    <link rel="stylesheet" href="../../actualizar_usuarios.css">
    <title>Nueva Sucursal</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO PARAMETRO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE PARAMETRO</h3>
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_actualizar_parametros.php";
            ?>
            <!--INGRESE PARAMETRO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Parametro</label>
            <input type="text" class="form-control" placeholder="" 
                name="parametro" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE VALOR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Valor</label>
            <input type="text" class="form-control" placeholder="" 
                name="valor" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

            <!--INGRESE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <select class="form-select" aria-label="Default select example" name="estado">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
                        
            </div>

            <!--BOTON NUEVO PARAMETRO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-outline-dark" name="btnregistrar_parametro" value="ok">Registrar Parametro</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_parametros.php'" >Cancelar</button>
            </div>
        </form>
        <!--FIN DEL FORM REGISTRO-->
    </body>
</html>