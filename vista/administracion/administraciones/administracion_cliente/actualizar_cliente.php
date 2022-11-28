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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=6");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin acceso");;window.location.href="administracion_cliente.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_cliente=$_GET["id_cliente"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_cliente where id_cliente=$id_cliente");
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
    <title>Actualizar Cliente</title>
</head>
<body>
        <br></br><br></br>
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR CLIENTE</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_cliente" value="<?= $_GET["id_cliente"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_de_cliente.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>

            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">NOMBRES</label>
            <input type="text" class="form-control" placeholder="Ingrese sus nombres" onKeyUp="this.value=this.value.toUpperCase(); "
                name="nombres" value="<?= $datos->NOMBRES ?>">
            </div>

            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="number" class="form-control" placeholder="Ingrese número de identidad" 
                name="identidad" value="<?= $datos->IDENTIDAD ?>">
            </div>

            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="number" class="form-control" placeholder="Ingrese número de telefono" 
                name="telefono" value="<?= $datos->TELEFONO ?>">
            </div>

            <!--CAMPOS COMBOBOX-->
            <!--GENERO-->                        
            <?php
            include "../../../../modelo/conexion.php";
            $id_cliente=$_GET["id_cliente"];    //Guardamos el id cliente desde el boton editar
            $sql=$conexion->query(" select * from tbl_cliente where id_cliente=$id_cliente ");
            ?>
             <?php
            include_once "../../../../controlador/administraciones/administracion_de_cliente.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">GENERO</label>
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
             }
            ?>
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizarcliente" name="btnactualizarcliente" value="ok">Actualizar Cliente</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_cliente.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>