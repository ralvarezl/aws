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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=13");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin acceso");;window.location.href="administracion_configuracion_cai.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_configuracion_cai=$_GET["id_configuracion_cai"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_configuracion_cai where id_configuracion_cai=$id_configuracion_cai ");
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
    <title>Actualizar Configuracion Cai</title>
</head>
<body>
<br></br>
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
           <img src="../../../../public/img/actualizar_pedido.jpg" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR CONFIGURACIÓN CAI</h3>
            <!--Imput que se oculta para almacenar el id configuracion cai para enviarlo a la BD-->
            <input type="hidden" name="id_configuracion_cai" value="<?= $_GET["id_configuracion_cai"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_configuracion_cai.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE NUMERO CAI-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">INGRESE NÚMERO CAI</label>
            <input type="text" class="form-control" placeholder="Ingrese numero cai" 
                name="numero_cai" value="<?= $datos->NUMERO_CAI ?>">
            </div>
            
            <!--INGRESE SECUENCIA INICIAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA INICIAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_inicial" value="<?= $datos->SECUENCIA_INICIAL ?>">
            </div>

            <!--INGRESE SECUENCIA ACTUAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA ACTUAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_actual" value="<?= $datos->SECUENCIA_ACTUAL ?>">
            </div>

            <!--INGRESE SECUENCIA FINAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SECUENCIA FINAL</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" 
                name="secuencia_final" value="<?= $datos->SECUENCIA_FINAL ?>">
            </div>

            <?php }
            ?>
            <!--BOTON ACTUALIZAR CONFIGURACION CAI Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btn_actualizar_configuracion_cai" name="btn_actualizar_configuracion_cai" value="ok">Actualizar Configuracion Cai</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_configuracion_cai.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>