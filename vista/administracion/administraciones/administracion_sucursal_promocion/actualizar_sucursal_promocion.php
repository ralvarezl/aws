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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=12");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin acceso");;window.location.href="administracion_sucursal_promocion.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_sucursal=$_GET["id_sucursal"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_sucursal where id_sucursal=$id_sucursal ");
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
    <title>Actualizar Sucursal</title>
</head>
<body>

<br></br><br></br>    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/actualizar_sucursal_promo.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR SUCURSAL PROMOCION</h3>
            <!--Imput que se oculta para almacenar la sucursal para enviarlo a la BD-->
            <input type="hidden" name="id_sucursal" value="<?= $_GET["id_sucursal"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_sucursal.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE NOMBRE SUCURSAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombre sucursal</label>
            <input type="text" class="form-control" placeholder="" 
                name="nombre_sucursal" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->ID_SUCURSAL ?>">
            </div>  

            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR SUCURSAL Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_sucursal" value="ok">Actualizar Sucursal</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_sucursal_promocion.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>