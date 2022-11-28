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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=10");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_tipo_pedido.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_tipo_pedido=$_GET["id_tipo_pedido"];    //Guardamos el id TIPO DE USAURIO desde el boton editar
$sql=$conexion->query(" select * from tbl_tipo_pedido where id_tipo_pedido=$id_tipo_pedido ");
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
    <title>Actualizar Tipo de Pedido</title>
</head>
<body>
        <br></br><br></br><br></br>
        <form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <img src="../../../../public/img/actualizar_pedido.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR TIPO DE PEDIDO</h3>
            <!--Imput que se oculta para almacenar el usuario para enviarlo a la BD-->
            <input type="hidden" name="id_tipo_pedido" value="<?= $_GET["id_tipo_pedido"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_tipo_pedido.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE DESCRIPCION-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">DESCRIPCION</label>
            <input type="text" class="form-control" placeholder="Describa el tipo de pedido" 
                name="descripcion" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->DESCRIPCION ?>">
            </div>
            
            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <select class="form-select" aria-label="Default select example" name="estado" >
              <!--SELECCIONA EL ESTADO YA ESTABLECIDO EN LA BACE-->
              <option selected value="<?= $datos->ESTADO ?>"><?= $datos->ESTADO ?></option>
            <!--SELECCIONE DIFERENTE ESTADO DEL QUE TIENE-->
            <? 
                $actualizar=$datos->ESTADO;
                if($actualizar=='ACTIVO'){?>
                        <option value="INACTIVO">INACTIVO</option>
                    <? 
                }else{?>
                    <option value="ACTIVO">ACTIVO</option>
                    <? 
                }

            ?>
            </select>
            </div>
            <?php }
            ?>

            

            <!--BOTON ACTUALIZAR TIPO DE PEDIDO Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" id="btnactualizartipopedido" name="btnactualizartipopedido" value="ok">Actualizar Parametro</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_tipo_pedido.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>