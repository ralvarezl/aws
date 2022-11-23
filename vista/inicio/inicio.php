<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administraciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/21445fda3d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../public/style_inicio.css">
    <link rel="stylesheet" href="administracion_usuarios.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">

</head>

<body>
    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
            <img src="../../public/img/aws_navbar.png"/>
                Andrés Coffee
            </a>
            <a class="navbar-brand" href="#" >
                <i class="fa-solid fa-house"></i> INICIO
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-house"></i> INICIO </a>
                </li>
                <!--ADMINISTRADOR CIENTE-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_cliente.php"><i class="fas fa-user-cog"></i> ADMINISTRADOR DE CLIENTE</a>
                </li>
                <!--ADMINISTRADOR PRODUCTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_producto.php"><i class="fas fa-mug-hot"></i> ADMINISTRADOR DE PRODUCTOS</a>
                </li>
                <!--ADMINISTRADOR PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_promocion.php"><i class="fas fa-tags"></i> ADMINISTRADOR DE PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DESCUENTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_descuento.php"><i class="fas fa-user-tag"></i> ADMINISTRADOR DE DESCUENTO</a>
                </li>
                <!--ADMINISTRADOR TIPO PEDIDO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fas fa-poll-h"></i> ADMINISTRADOR DE TIPO PEDIDO</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_sucursal.php"><i class="fas fa-store-alt"></i> ADMINISTRADOR DE SUCURSAL</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_sucursal_promocion.php"><i class="fas fa-store"></i>  ADMINISTRADOR DE SUCURSAL Y PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DE CONFIGURACION CAI-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_configuracion_cai.php"><i class="fas fa-file-alt"></i> ADMINISTRADOR DE CONFIGURACION CAI</a>
                </li>
                <!--ADMINISTRADOR DE USUARIO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>
                <!--ADMINISTRADOR DE PARAMETROS-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a>
                </li>
                <!--ADMINISTRADOR DE BITACORA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
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
           <!--SALIR DEL SITEMA-->
           <li class="btn btn-dark p-2">
                <a class="nav-link" href="../../../../controlador/cerrar_sesion.php"><i class="fas fa-sign-out-alt"></i> SALIR DEL SISTEMA</a>
            </li>
            </div>
        </div>
        </nav>
        
        <!--FIN DEL NAVBAR-->

    <!--INICIO-->
    <div class="container-fluid px-4">
        <div class="row g-3 my-5">
        <h3 class="text-center text-secundary">
            <br>
            <?=
            "BIENVENIDO AL SISTEMA ".$_SESSION['usuario_login'];
            ?></h3>
            <div class="col-md-3">
                <div class="btn p-3  bg-light text-dark shadow-sm d-flex justify-content-around align-items-center rounded" onclick="location.href='../../controlador/bitacora_pantalla/admin_usuario.php'">
                    <div>
                    <h3 class="fs-2">USUARIOS</h3>
                    <p class="fs-5">Administración de Usuarios</p>
                    </div>
                    <i class="fa-solid fa-users-gear fs-1 rounded-full p-3"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="btn p-3  bg-light text-dark shadow-sm d-flex justify-content-around align-items-center rounded" onclick="location.href='../../controlador/bitacora_pantalla/admin_parametros.php'">
                    <div>
                    <h3 class="fs-2">PARAMETROS</h3>
                    <p class="fs-5">Administración de Parametros</p>
                    </div>
                    <i class="fa-solid fa-gears fs-1 rounded-full p-3"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="btn p-3  bg-light text-dark shadow-sm d-flex justify-content-around align-items-center rounded" onclick="location.href='../../controlador/bitacora_pantalla/bitacora.php'">
                    <div>
                    <h3 class="fs-2">BITACORA</h3>
                    <p class="fs-5">Visualización de la Bitacora</p>
                    </div>
                    <i class="fa-solid fa-list-check fs-1 rounded-full p-3"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="btn p-3  bg-light text-dark shadow-sm d-flex justify-content-around align-items-center rounded" onclick="location.href='../../controlador/bitacora_pantalla/factura.php'">
                    <div>
                    <h3 class="fs-2">FACTURA</h3>
                    <p class="fs-5">Visualización de la factura</p>
                    </div>
                    <i class="fa-solid fa-list-check fs-1 rounded-full p-3"></i>
                </div>
            </div>

        </div>                   
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>

    
</body>

</html>