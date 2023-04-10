<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../login.php");
}
//Verificar permiso del rol
include "../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_visualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=2");
$row=mysqli_fetch_array($sql);
if(is_null($row)){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="../../inicio/inicio.php"</script>';
}else{
    $permiso=$row[0];
}

if($permiso <> 'PERMITIR'){
    echo '<script language="javascript">alert("Usuario sin permiso");;window.location.href="../../inicio/inicio.php"</script>';
}
?>
<?php
require("../../../modelo/conexion.php");
include "ajax.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />   
    <title>Administración Factura</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../../../public/style_actualizar_nuevo.css">
        <link rel="shortcut icon" href="../../../public/img/Logo.png">
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>

<br><br>

<form class="col-7 p-2 m-auto" method="POST" autocomplete="off">
        <img src="../../../public/img/nuevo_promocion.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">REGISTRO DE PROMOCIÓN</h3>
            <?php
            include "../../../modelo/conexion.php";
            include "../../../controlador/administraciones/administracion_de_promocion.php";
            ?><br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-12 p-3 m-auto">
                            <h4 class="text-center">Seleccione productos para la promoción</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="producto">Nombre o Tipo de Producto</label>
                                            <input id="producto" class="form-control" type="text" name="producto" placeholder="Ingresa el nombre o tipo">
                                            <input id="id" type="hidden" name="id">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label>
                                            <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" onkeyup="calcularPrecio(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="precio">Precio</label>
                                            <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <div class="col-13 p-2 m-auto">
                        <div class="table-responsive">
                        <h4 class="text-center">Detalles de los productos</h4>
                            <table class="table table-hover" id="tblDetalle">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Precio Total</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle_venta">

                                </tbody>
                                <tbody id="detalle_venta_prom">

                                </tbody>

                                <tfoot>
                        
                                </tfoot>
                            </table>
                        </div>
                    </div>
        </form>
        <form class="col-17 p-2 m-auto" method="POST" autocomplete="off">
        <div class="col-13 p-3 m-auto"> 
                            <br>
                            <h4 class="text-center">Detalles de la Promoción</h4>
                        <div class="col-12 p-2 m-auto">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput" class="col-md-7 control-label">Descripción</label>
                                                <input type="text" class="form-control" placeholder="Ingrese el nombre la promocion" 
                                                    name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput" class="col-md-7 control-label">Fecha Inicial</label>
                                                <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" value="<?php echo date("d/m/Y");?>" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput" class="col-md-7 control-label">Fecha Final</label>
                                                <input type="date" class="form-control" id="fecha_final" name="fecha_final" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    </div><br>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput" class="col-md-15 control-label">Precio total de la promoción</label>
                                                <input type="text" class="form-control" placeholder="Ingrese el nombre la promocion" 
                                                    name="Precio" id="Precio" onKeyUp="this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                            </div>
                        </div>

            <!--BOTON NUEVO USUARIO-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-outline-dark" name="btnregistrarpromocion" value="ok">Registrar Promocion</button>
                    <button type="button" class="btn btn-outline-danger" onclick="location.href='../../administracion/administraciones/administracion_promocion/administracion_promocion.php'" >Cancelar</button>
                    </div>


                </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/646c794df3.js"></script>
    <?php include_once "includes/footer.php"; ?>
