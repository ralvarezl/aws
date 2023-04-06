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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=3");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    
    echo '<script language="javascript">alert("Sin acceso");;window.location.href="administracion_parametro.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_parametro=$_GET["id_parametro"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_ms_parametros where id_parametro=$id_parametro ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <link rel="stylesheet" type="text/css" href="../../../../public/style_actualizar_nuevo.css">
    <title>Actualizar Usuario</title>
</head>
<body>
        <br></br><br></br> 
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/actualizar_parametros.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR PARAMETRO</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_parametro" value="<?= $_GET["id_parametro"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_actualizar_parametros.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>

            <!--INGRESE PARAMETRO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">PARAMETRO</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" onKeyUp="this.value=this.value.toUpperCase();"
                name="parametro" value="<?= $datos->PARAMETRO ?>">
            </div>

            <!--INGRESE VALOR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">VALOR</label>
            <input type="text" class="form-control" placeholder="Ingrese valor" onKeyUp="this.value=this.value.toUpperCase();"
                name="valor" value="<?= $datos->VALOR ?>">
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
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizar_parametro" name="btnactualizarparametro" value="ok">Actualizar Parametro</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_parametros.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>