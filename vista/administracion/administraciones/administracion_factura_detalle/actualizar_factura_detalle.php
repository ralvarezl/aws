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
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=23");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="administracion_descuento.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_factura_detalle=$_GET["id_factura_detalle"];    //Guardamos el id estado desde el boton editar
$sql=$conexion->query(" select id_factura_detalle,nombre,d.precio, d.cantidad, total, descripcion, d.estado
from tbl_factura_detalle d
inner join tbl_producto p on p.id_producto=d.id_producto
inner join tbl_promocion pro on pro.id_promocion=d.id_promocion
where id_factura_detalle=$id_factura_detalle ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_factura_detalle.css">
    <title>Actualizar Factura Detalle</title>
</head>
<body>
    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <img src="../../../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR FACTURA DETALLE</h3>
            <!--Imput que se oculta para almacenar la factura detalle para enviarlo a la BD-->
            <input type="hidden" name="id_factura_detalle" value="<?= $_GET["id_factura_detalle"] ?>"> 
            <?php
            include "../../../../controlador/administraciones/administracion_factura_detalle.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            
            <!--INGRESE PRECIO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Precio</label>
            <input type="number" class="form-control" placeholder="" 
                name="precio" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->precio ?>">
            </div>
            <!--INGRESE CANTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Cantidad</label>
            <input type="number" class="form-control" placeholder="" 
                name="cantidad" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->cantidad ?>">
            </div>
            <!--INGRESE TOTAL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Total</label>
            <input type="number" class="form-control" placeholder="" 
                name="total" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->total ?>">

            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ESTADO</label>
            <select class="form-select" aria-label="Default select example" name="estado" >
              <!--SELECCIONA EL ESTADO YA ESTABLECIDO EN LA BACE-->
              <option selected value="<?= $datos->ESTADO ?>"><?= $datos->estado ?></option>
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
            
            <!--CAMPOS COMBOBOX-->  
            <!--PRODUCTO-->                        
            <?php
            include_once "../../../../modelo/conexion.php";
            $sql=$conexion->query(" select p.id_producto, nombre
            from tbl_factura_detalle fd join tbl_producto p on p.id_producto=fd.id_producto where id_factura_detalle=$id_factura_detalle");
            ?>
             <?php
            include_once "../../../../controlador/administraciones/administracion_factura_detalle.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE PRODUCTO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Producto</label>
            <select class="form-select" aria-label="Default select example" name="producto">
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->id_producto ?>"><?= $datos->nombre ?></option>
            <?php 
            include_once "../../../../modelo/conexion.php";
            $sql=$conexion->query("select * from tbl_producto where nombre<>'$datos->nombre'" );
                //Mostrar los productos creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['ID_PRODUCTO'].'" >'.$datos['NOMBRE'].'</option>';
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            
            <!--PROMOCION-->                        
            <?php
            include_once "../../../../modelo/conexion.php";
            $sql=$conexion->query(" select fd.id_promocion,descripcion
            from tbl_factura_detalle fd
            join tbl_promocion p on p.id_promocion=fd.id_promocion where id_factura_detalle=$id_factura_detalle");
            ?>
             <?php
            include_once "../../../../controlador/administraciones/administracion_factura_detalle.php";
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE PROMOCION-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Promocion</label>
            <select class="form-select" aria-label="Default select example" name="promocion">
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->id_promocion ?>"><?= $datos->descripcion ?></option>
            <?php 
            include_once "../../../../modelo/conexion.php";
            $sql=$conexion->query("select * from tbl_promocio where descripcion<>'$datos->descripcion'" );
                //Mostrar los promociones creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['ID_PROMOCION'].'" >'.$datos['DESCRIPCION'].'</option>';
                }
            ?>
            </select>
            </div>
            
            <?php }
            ?>

            

            <!--BOTON ACTUALIZAR FACTURA DETALLE Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_factura_detalle" value="ok">Actualizar Factura Detalle</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_factura_detalle.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>