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
        <link rel="stylesheet" type="text/css" href="../../../public/style_factura.css">
        <link rel="shortcut icon" href="../../../public/img/Logo.png">
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>

    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../../controlador/bitacora_pantalla/inicio.php">
                <img src="../../../public/img/aws_navbar.png"/>
                Andrés Coffee
            </a>
            <a class="navbar-brand" href="#" >
                <i class="fas fa-file-invoice"></i> FACTURACION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h1 class="fas fa-user-circle"></h1>
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                <!--MOSTRAR EL USUARIO LOGUEADO-->
                <?=
                "BIENVENIDO ".$_SESSION['usuario_login'];
                ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../controlador/bitacora_pantalla/inicio.php"><i class="fa-solid fa-house"></i> INICIO </a>
                </li>

                <!--FACTURA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../controlador/bitacora_pantalla/factura.php"><i class="fas fa-file-invoice"></i> NUEVA FACTURA </a>
                </li>
            

                <!--ADMINISTRADOR DE FACTURA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ADMINISTRADOR DE FACTURA
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                    
                    <!--ADMINISTRADOR CIENTE-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_cliente.php"><i class="fas fa-user-cog"></i> ADMINISTRADOR DE CLIENTE</a></li>
                    <!--ADMINISTRADOR PRODUCTO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_producto.php"><i class="fas fa-mug-hot"></i> ADMINISTRADOR DE PRODUCTOS</a></li>
                    <!--ADMINISTRADOR PROMOCION-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_promocion.php"><i class="fas fa-tags"></i> ADMINISTRADOR DE PROMOCION</a></li>
                    <!--ADMINISTRADOR DESCUENTO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_descuento.php"><i class="fas fa-user-tag"></i> ADMINISTRADOR DE DESCUENTO</a></li>
                    <!--ADMINISTRADOR TIPO PEDIDO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fas fa-poll-h"></i> ADMINISTRADOR DE TIPO PEDIDO</a></li>
                    <!--ADMINISTRADOR DE SUCURSAL-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_sucursal.php"><i class="fas fa-store-alt"></i> ADMINISTRADOR DE SUCURSAL</a></li>
                    <!--ADMINISTRADOR DE FACTURA-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_factura.php"><i class="fas fa-file-alt"></i> ADMINISTRADOR DE FACTURA</a></li>
                    <!--ADMINISTRADOR DE FACTURA DETALLE-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_factura_detalle.php"><i class="fas fa-receipt"></i> ADMINISTRADOR DE FACTURA DETALLE</a></li>
                    <!--ADMINISTRADOR DE FACTURA DESCUENTO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_factura_descuento.php"><i class="fas fa-user-tag"></i>  ADMIN. FACTURA DESCUENTO</a></li>
                    <!--ADMINISTRADOR DE FACTURA PROMOCION-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_factura_promocion.php"><i class="fas fa-tag"></i> ADMIN. FACTURA PROMOCION</a></li>
                    <!--ADMINISTRADOR DE CONFIGURACION CAI-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_configuracion_cai.php"><i class="fas fa-file-alt"></i> ADMIN. CONFIGURACION CAI</a></li>
                </li>
                </ul>

                <!--ADMINISTRADOR DE SEGURIDAD-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ADMINISTRADOR DE SEGURIDAD
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                   
                    <!--ADMINISTRADOR DE USUARIO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a></li>
                    <!--ADMINISTRADOR DE ESTADO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_estado.php"><i class="fas fa-toggle-on"></i> ADMINISTRADOR DE ESTADO</a></li>
                    <!--ADMINISTRADOR DE GENERO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_genero.php"><i class="fas fa-venus-mars"></i> ADMINISTRADOR DE GENERO</a></li>
                    <!--ADMINISTRADOR DE PARAMETROS-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a></li>
                    <!--ADMINISTRADOR DE OBJETO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_objeto.php"><i class="fas fa-lightbulb"></i> ADMINISTRADOR DE OBJETO</a></li>
                    <!--ADMINISTRADOR DE PERMISO-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_permiso.php"><i class="fas fa-vote-yea"></i> ADMINISTRADOR DE PERMISOS</a></li>
                    <!--ADMINISTRADOR DE PREGUNTAS-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_pregunta.php"><i class="fas fa-question-circle"></i> ADMINISTRADOR DE PREGUNTAS</a></li>
                    <!--ADMINISTRADOR DE ROLES-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/admin_rol.php"><i class="fas fa-user-tie"></i> ADMINISTRADOR DE ROLES</a></li>
                    <!--ADMINISTRADOR DE BITACORA-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a></li>
                    <!--BACKUP-->
                    <li><a class="dropdown-item" href="../../../controlador/bitacora_pantalla/restauracion.php"><i class="fa-solid fa-cloud-arrow-down"></i> BACKUP</a></li>
                </li>
                </ul>
            </div>
            <!--SALIR DEL SITEMA-->
            <li class="btn btn-dark p-2">
                <a class="nav-link" href="../../../controlador/cerrar_sesion.php"><i class="fas fa-sign-out-alt"></i> SALIR DEL SISTEMA</a>
            </li>
            </div>
        </div>
        </nav>
        <!--FIN DEL NAVBAR-->

        <?php
            include "../../../modelo/conexion.php";
            include "ajax.php";
        ?>

        <div class="col-10 p-3 m-auto">
        <br><br>
        <div class="row p-2"> <!--Div que contiene nuevo usuario y la busqueda-->
            <form class="form-horizontal" role="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-12 p-3 m-auto">
                            <h4 class="text-center">Buscar Productos</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="producto">Nombre o Tipo de Producto</label>
                                            <input id="producto" class="form-control" type="text" name="producto" placeholder="Ingresa el nombre o tipo" onKeyUp="this.value=this.value.toUpperCase();">
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="sub_total">Sub Total</label>
                                            <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Sub Total" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 p-3 m-auto">
                            <h4 class="text-center">Buscar Promoción</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="promocion">Nombre de Promoción</label>
                                            <input id="promocion" class="form-control" type="text" name="promocion" placeholder="Ingresa el nombre" onKeyUp="this.value=this.value.toUpperCase();">
                                            <input id="id_prom" type="hidden" name="id_prom">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="cantidad_prom">Cantidad</label>
                                            <input id="cantidad_prom" class="form-control" type="number" name="cantidad_prom" placeholder="Cantidad" onkeyup="calcularPrecioProm(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="precio_prom">Precio</label>
                                            <input id="precio_prom" class="form-control" type="text" name="precio_prom" placeholder="Precio" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="sub_total_prom">Sub Total</label>
                                            <input id="sub_total_prom" class="form-control" type="text" name="sub_total_prom" placeholder="Sub Total" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 p-3 m-auto">
                            <h4 class="text-center">Detalles Descuentos y Tipo Pedido</h4>
                            <div class="col-10 p-3 m-auto">
                                <div class="card-body">
                                    <div class="row">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <input type="hidden" id="id_desc" value="1" name="id_desc" required>
                                                    <label for="descuento">Aplicar Descuento</label>
                                                    <input type="text" name="descuento" id="descuento" class="form-control" placeholder="Ingresa el nombre del descuento" onKeyUp="this.value=this.value.toUpperCase();" onchange="calcular()">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="descu" class="col-md-1 control-label">Descuento: </label>
                                                    <input id="descu" class="form-control" type="text" name="descu" readonly="readonly" >
                                                </div>
                                            </div>  
                                            <!--SELECCIONE TIPO DE PEDIDO-->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipo" class="col-md-7 control-label">Tipo pedido</label>
                                                    <select class="form-select" aria-label="Default select example" name="descripcion" id="descripcion">
                                                    <?php 
                                                    $sql=$conexion->query("select descripcion from tbl_tipo_pedido where estado = 'ACTIVO'");
                                                        //Mostrar los roles creados en la base de datos
                                                        while($datos=mysqli_fetch_array($sql)){
                                                            echo '<option value="'.$datos['descripcion'].'">'.$datos['descripcion'].'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-12 p-3 m-auto">
                        <br>
                        <h4 class="text-center">Detalles de Factura</h4>
                        <div class="col-10 p-3 m-auto">
                            <div class="card-body">
                                <div class="row">
                                 

                                    <!--SELECCIONE LA SUCURSAL-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo" class="col-md-7 control-label">Sucursal:</label>
                                            <select class="form-select" aria-label="Default select example" name="sucursal" id="sucursal">
                                            <?php 
                                            $sql=$conexion->query("select nombre from tbl_sucursal where estado = 'ACTIVO'");
                                                //Mostrar los roles creados en la base de datos
                                                while($datos=mysqli_fetch_array($sql)){
                                                    echo '<option value="'.$datos['nombre'].'">'.$datos['nombre'].'</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Pago" class="col-md-7 control-label">Pago</label>
                                            <select class="form-select" aria-label="Default select example" name="pago" id="pago">
                                                    <?php 
                                                    $sql=$conexion->query("select tipo from tbl_tipo_pago where estado = 'ACTIVO'");
                                                        //Mostrar los roles creados en la base de datos
                                                        while($datos=mysqli_fetch_array($sql)){
                                                            echo '<option value="'.$datos['tipo'].'">'.$datos['tipo'].'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fecha" class="col-md-1 control-label">Fecha</label>
                                            <input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="empresa" class="col-md-1 control-label">Vendedor: </label>
                                            <input type="text" readonly="readonly" class="form-control" id="vendedor"
                                                    name="vendedor" value="<?=$_SESSION['usuario_login'];?>" readonly disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-13 p-2 m-auto">
                        <div class="table-responsive">
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
                                    
                                    <tr class="font-weight-bold">
                                        <td>SUBTOTAL:</td>
                                        <td></td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>ISV:</td>
                                        <td></td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>DESCUENTO:</td>
                                        <td></td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>TOTAL A PAGAR:</td>
                                        <td></td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>PAGO RECIBIDO:</td>
                                        <td>
                                            <div class="col-md-3">
                                                <input id="Pago" class="form-control" type="number" name="Pago" placeholder="Pago" required onkeyup="calcular()">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>CAMBIO:</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>


                    <div class="col-13 p-3 m-auto">
                            <h4 class="text-center">Datos del Cliente</h4>
                        <div class="col-12 p-3 m-auto">
                            <div class="card-body">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                                                <label>Identidad</label>
                                                <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" placeholder="Ingrese nombre del cliente" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" name="idt_cliente" id="idt_cliente" class="form-control" disabled required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <input type="number" name="tel_cliente" id="tel_cliente" class="form-control" disabled required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Crea nuevo Cliente</label> 
                                                <button type="button" class="btn btn-secondary" id="btn_cliente" onclick="location.href='nuevo_cliente.php'"><i class="fas fa-user-circle"></i> Nuevo Cliente</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary" id="btn_generar" name="btn_generar"><i class="fas fa-save"></i> Generar Venta</a>
                    </div>

                </div>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/646c794df3.js"></script>
    <?php include_once "includes/footer.php"; ?>
