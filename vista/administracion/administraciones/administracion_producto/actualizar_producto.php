<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
include "../../../../modelo/conexion.php";
$id_producto=$_GET["id_producto"];    //Guardamos el id usuario desde el boton editar
$sql=$conexion->query(" select * from tbl_producto where id_producto=$id_producto");
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
    <title>Actualizar Producto</title>
</head>
<body>
        <br></br><br></br>
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/actualizar_producto.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR PRODUCTO</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_producto" value="<?= $_GET["id_producto"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_de_producto.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>

            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">NOMBRE</label>
            <input type="text" class="form-control" placeholder="Ingrese el nombre" onKeyUp="this.value=this.value.toUpperCase(); "
                name="nombre" value="<?= $datos->NOMBRE ?>">
            </div>

            <!--SELECCIONE TIPO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">TIPO</label>
            <select class="form-select" aria-label="Default select example" name="tipo" >

              <!--SELECCIONA EL TIPO YA ESTABLECIDO EN LA BACE-->
              <option selected value="<?= $datos->TIPO ?>"><?= $datos->TIPO ?></option>

            <!--SELECCIONE DIFERENTE TIPO DEL QUE TIENE-->
            <?
                $actualizar=$datos->TIPO;
                if($actualizar=='CALIENTE'){?>
                        <option value="HELADO">HELADO</option>
                    <?
                }else{?>
                    <option value="CALIENTE">CALIENTE</option>
                    <?
                }
                }else{?>
                    <option value="POSTRE">POSTRE</option>
                    <?
                }
                ?>
            </select>
            </div>

            <!--INGRESE CANTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">CANTIDAD</label>
            <input type="number" class="form-control" placeholder="Ingrese la cantidad" 
                name="cantidad" value="<?= $datos->CANTIDAD ?>">
            </div>

            <!--INGRESE PRECIO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">PRECIO</label>
            <input type="decimal" class="form-control" placeholder="Ingrese el precio" 
                name="precio" value="<?= $datos->PRECIO ?>">
            </div>
            <?php }
            ?>
            <!--BOTON ACTUALIZAR USUARIO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizar_producto" name="btnactualizarproducto" value="ok">Actualizar Producto</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_producto.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>