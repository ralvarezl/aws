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
$sql=mysqli_query($conexion, "select permiso_insertar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=13");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_configuracion_cai.php"</script>';
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
    <link rel="stylesheet" href="actualizar_configuracion_cai.css">
    <title>Nuevo Configuracion Cai</title>
</head>
<body>

    <!--INICIO DEL FORM REGISTRO TIPO DE PEDIDO-->
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
        <img src="../../../../public/img/NUEVO.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">NUEVO CONFIGURACION CAI</h3>
            
            <?php
            include "../../../../modelo/conexion.php";
            include "../../../../controlador/administraciones/administracion_configuracion_cai.php";
            ?>

            <!--INGRESE NUMERO CAI-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">INGRESE NUMERO CAI</label>
            <input type="text" class="form-control" placeholder="Ingrese numero cai" 
                name="numero_cai">
            </div>
            
            <!--INGRESE SECUENCIA INICIAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA INICIAL</label>
            <input type="text" class="form-control" placeholder="Ingrese secuencia inicial" 
                name="secuencia_inicial" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

            <!--INGRESE SECUENCIA ACTUAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA ACTUAL</label>
            <input type="text" class="form-control" placeholder="Ingrese secuencia actual" 
                name="secuencia_actual" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

            <!--INGRESE SECUENCIA FINAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA FINAL</label>
            <input type="text" class="form-control" placeholder="Ingrese secuencia final" 
                name="secuencia_final" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

            <!--BOTON REGISTRAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btn_nuevo_configuracion_cai" name="btn_nuevo_configuracion_cai" value="ok">Registrar Configuracion Cai</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_configuracion_cai.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>