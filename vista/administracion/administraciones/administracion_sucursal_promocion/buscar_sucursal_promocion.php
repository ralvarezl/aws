<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Sucursal Promocion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../../../public/style_inicio.css">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
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
                <i class="fa-solid fa-users-gear"></i> ADMINISTRACION DE SUCURSAL PROMOCION
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
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/inicio.php"><i class="fa-solid fa-house"></i> INICIO </a>
                </li>
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a>
                </li>

                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
                </li>
                
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../controlador/cerrar_sesion.php"><i class="fa-solid fa-person-walking-arrow-right"></i> SALIR DEL SISTEMA</a>

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

    <!--Funcion para confirmar si desea eliminar-->
    <script>
        function eliminar(){
        var respuesta=confirm("Esta seguro que desea eliminar?");
        return respuesta
        }
    </script>

    <!--INICIO DE LA TABLE SUCURSAL-->
    <?php 
    //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
    $busqueda_sucursal_promocion = strtoupper($_REQUEST['busqueda_sucursal_promocion']);
    ?>
    <div class="container-fluid row">
        <div class="col-8 p-4 m-auto">
            <br><br>
            <?php
            include "../../../../modelo/conexion.php";
            //include "../../../../controlador/administraciones/eliminar_sucursal_promocion.php";
            ?>  
            <div class="row p-2"> <!--Div que contiene nueva sucursal y la busqueda-->
                
                <!--BUSQUEDA, al apretar el boton buscar que me envie a buscar_sucursal-->
                <div class="align-items-end">
                    <form action="buscar_sucursal_promocion.php" method="get" class="form_search">
                        <input type="text" name="busqueda_sucursal_promocion" id="busqueda_sucursal_promocion" placeholder="" value="<?php echo $busqueda_sucursal_promocion; ?>">
                        <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="administracion_sucursal_promocion.php"></a>
                        <input type="submit" value="Buscar" class="btn btn-secondary">
                        <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_sucursal_promocion.php"></a>
                    </form>
                </div>
            </div>

            <table class="table table-dark table-striped" style="text-align:center; white-space: nowrap; overflow: auto;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">SUCURSAL</th>
                        <th scope="col">PROMOCION</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col"style="width:15px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Llamado a la base de datos
                    include "../../../../modelo/conexion.php";
                    $sql=$conexion->query("select id_sucursal, id_promocion, estado from tbl_sucursal_promocion
                    where id_sucursal like '%$busqueda_sucursal_promocion%' or
                            id_promocion like '%$busqueda_sucursal_promocion%' or
                            estado like '%$busqueda_sucursal_promocion%' 
                    order by id_sucursal");
                    while($u = $sql->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $u['id_sucursal']; ?></td>
                        <td><?php echo $u['id_promocion']; ?></td>
                        <td><?php echo $u['estado']; ?></td>
                        <td>
                            <a href="actualizar_sucursal.php?id_sucursal=<?= $u['id_sucursal'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                    </tr>
                    <?php }
                    $_SESSION['busqueda_sucursal_promocion'] = $busqueda_sucursal_promocion;
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>

    </body>
</html>