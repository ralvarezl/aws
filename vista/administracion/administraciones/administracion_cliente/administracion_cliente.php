<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Parametros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../../../public/style_inicio.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">

</head>

<body>
    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
            <img src="../../../../public/img/aws_navbar.png"/>
                Andrés Coffee
            </a>
            <a class="navbar-brand" href="#" >
                <i class="fa-solid fa-gears"></i> ADMINISTRACION DE CLIENTE
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
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/inicio.php"><i class="fa-solid fa-house"></i> INICIO </a>
                </li>
                <!--ADMINISTRADOR CIENTE-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE CLIENTE</a>
                </li>
                <!--ADMINISTRADOR PRODUCTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_producto.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PRODUCTOS</a>
                </li>
                <!--ADMINISTRADOR PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_promocion.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DESCUENTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_descuento.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE DESCUENTO</a>
                </li>
                <!--ADMINISTRADOR TIPO PEDIDO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE TIPO PEDIDO</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_sucursal.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE SUCURSAL</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_sucursal_promocion.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE SUCURSAL Y PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DE CONFIGURACION CAI-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_configuracion_cai.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE CONFIGURACION CAI</a>
                </li>
                <!--ADMINISTRADOR DE USUARIO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>
                <!--ADMINISTRADOR DE PARAMETROS-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a>
                </li>
                <!--ADMINISTRADOR DE BITACORA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
                </li>
                <!--SALIR DEL SITEMA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/cerrar_sesion.php"><i class="fa-solid fa-person-walking-arrow-right"></i> SALIR DEL SISTEMA</a>
                </li>

                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </nav>
        <!--FIN DEL NAVBAR-->

        <script>
        function eliminar(){
            var respuesta=confirm("Esta seguro que desea eliminar?");
            return respuesta
        }
        </script>

        <div class="col-9 p-3 m-auto">
        <br><br>

        <div class="row p-2"> <!--Div que contiene nuevo usuario y la busqueda-->
        <div class="ml-auto p-2">
            <button type="button" class="btn btn-dark" onclick="location.href='nuevo_cliente.php'">Nuevo cliente</button>
        </div>
        <!--BUSQUEDA, al apretar el boton buscar que me envie a buscar_usuarios-->
        <div class="ml-auto p-2">
            <form action="buscar_cliente.php" method="get" class="form_search">
            <input type="text" name="busqueda_cliente" id="busqueda_cliente" placeholder="">
            <input type="submit" value="Buscar" class="btn btn-secondary">
            <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_administracion_cliente.php"></a>
            </form>
        </div>

        <?php
                include "../../../../modelo/conexion.php";
                include "../../../../controlador/administraciones/eliminar_cliente.php";
                ?>
                    <table class="table table-dark table-striped" style="text-align:center;" >
                        <thead class="table-dark">
                        <br></br>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRES</th>
                            <th scope="col">APELLIDOS</th>
                            <th scope="col">IDENTIDAD</th>
                            <th scope="col">GENERO</th>
                            <th scope="col">TELEFONO</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../../../modelo/conexion.php";
                            $sql= $conexion->query("select id_cliente, nombres, apellidos, identidad, genero, telefono from tbl_cliente");
                            while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['id_cliente']; ?></td>
                                <td><?php echo $u['nombres']; ?></td>
                                <td><?php echo $u['apellidos']; ?></td>
                                <td><?php echo $u['identidad']; ?></td>
                                <td><?php echo $u['genero']; ?></td>
                                <td><?php echo $u['telefono']; ?></td>
                                <td>
                                    <a href="actualizar_cliente.php?id_cliente=<?= $u['id_cliente'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                    <a onclick="return eliminar()" href="administracion_cliente.php?id_cliente=<?= $u['id_cliente'] ?>" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                                
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>

        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>