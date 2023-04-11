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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=21");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin acceso");;window.location.href="administracion_promocion.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_genero=$_GET["id_genero"];    //Guardamos el id genero desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_genero where id_genero=$id_genero ");
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
    <title>Actualizar Genero</title>
</head>
<body>

<br></br><br></br>    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/actualizar_genero.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR GÉNERO</h3>
            <!--Imput que se oculta para almacenar EL estado para enviarlo a la BD-->
            <input type="hidden" name="id_genero" value="<?= $_GET["id_genero"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_genero.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">GÉNERO</label>
            <input type="text" class="form-control" placeholder="" 
                name="genero" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->GENERO ?>">
            </div>

            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <select class="form-select" aria-label="Default select example" name="estado" >
              <!--SELECCIONA EL ESTADO YA ESTABLECIDO EN LA BACE-->
              <!--<option selected value="<?= $datos->ESTADO ?>"><?= $datos->ESTADO ?></option>-->
            <!--SELECCIONE DIFERENTE ESTADO DEL QUE TIENE-->
            <? 
                $actualizar=$datos->ESTADO;
                if($actualizar=='ACTIVO'){?>
                        <option value="ACTIVO">ACTIVO</option>
                    <? 
                }else{?>
                    <option value="INACTIVO">INACTIVO</option>
                    <? 
                }

            ?>
            </select>
            </div>

            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR SUCURSAL Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_genero" value="ok">Actualizar Genero</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_genero.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>