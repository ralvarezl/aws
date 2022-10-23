<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="administracion_usuarios.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">

</head>

<body>
    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
                AWS Andres's Coffee
            </a>
            <a class="navbar-brand text-right" href="#" >
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
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>
                
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/cerrar_sesion.php"><i class="fa-solid fa-person-walking-arrow-right"></i> SALIR DEL SISTEMA</a>
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

    <!--INICIO DEL FORM REGISTRO USUARIOS-->
    <div class="container-fluid px-4">
        <div class="row g-3 my-5">
        <h3 class="text-center text-secundary">BIENVENIDO AL SISTEMA</h3>
            <div class="col-md-3">
                <div class="btn p-3 bg-danger shadow-sm d-flex justify-content-around align-items-center rounded">
                    <div>
                    <h3 class="fs-2">USUARIOS</h3>
                    <p class="fs-5">Administracion de Usuarios</p>
                    </div>
                    <i class="fa-solid fa-users fs-1 rounded-full p-3"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="btn p-3 bg-danger shadow-sm d-flex justify-content-around align-items-center rounded">
                    <div>
                    <h3 class="fs-2">PRODUCTOS</h3>
                    <p class="fs-5">Administracion de Productos</p>
                    </div>
                    <i class="fa-solid fa-mug-saucer fs-1 rounded-full p-3"></i>
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