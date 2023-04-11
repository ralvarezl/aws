<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../index.php");
}
//Verificar permiso del rol
include "../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el id del usuario
$sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_usuario_base=$row[0];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_visualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=25");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="../vista/inicio/inicio.php"</script>';
}
//include "../../modelo/conexion.php";
$id_usuario=$id_usuario_base;    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_usuario where id_usuario=$id_usuario ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../public/style_actualizar_nuevo.css">
    <title>Recuperar y Restaurar</title>
</head>
<body>
<br></br>  
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <?php
            include "restaurar.php";
            //include "respaldo.php";
            ?>
            
            <img src="../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">RECUPERAR Y RESTAURAR</h3>
            <script type="text/javascript">
            function onLoadImage(files){
                console.log(files)
                if (files && files[0]) {
                    document
                    .getElementById('imgName')
                    .innerHTML = files[0].name
                }
                }
            </script>
            
            <!--<input type="file" name="" >-->
            <label for="img">Cargar Respaldo</label>
            <input id="img" type="file" onChange="onLoadImage(event.target.files)" style="display: none;"/>
            <span id="imgName"></span>
            <input name="importar" type="text" placeholder="Nombre del respaldo"/>
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <br></br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnrespaldo" value="ok">Respaldo</button>
            <button type="submit" class="btn btn-dark" name="btnimportar" value="ok">Restaurar</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='../vista/inicio/inicio.php'" >Cancelar</button>
            </div>
          
    </form>
</body>
</html>

