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
                <i class="fa-solid fa-gears"></i> ADMINISTRACION DE PRODUCTO
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
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>

                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a>
                </li>

                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
                </li>
                
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PRODUCTO</a>
                </li>

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
            <button type="button" class="btn btn-dark" onclick="location.href='nuevo_producto.php'">Nuevo producto</button>
        </div>

        <?php 
        //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
        $busqueda_producto = strtoupper($_REQUEST['busqueda_producto']);
        ?>

        <!--BUSQUEDA-->
        <div class="ml-auto p-2">
            <form action="buscar_producto.php" method="get" class="form_search">
            <input type="text" name="busqueda_producto" id="busqueda_producto" placeholder="" value="<?php echo $busqueda_producto; ?>">
            <input type="submit" value="Buscar" class="btn btn-secondary">
            <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="administracion_producto.php"></a>
            <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_producto.php"></a>
            </form>
        </div>

        <?php
                include "../../../../modelo/conexion.php";
                include "../../../../controlador/administraciones/eliminar_producto.php";
                ?>
                    <table class="table table-dark table-striped" style="text-align:center;" >
                        <thead class="table-dark">
                        <br></br>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">TIPO</th>
                            <th scope="col">CANTIDAD</th>
                            <th scope="col">PRECIO</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../../../modelo/conexion.php";
                            $sql= $conexion->query("select id_producto, nombre, tipo, cantidad, precio from tbl_producto
                            where id_producto like '%$busqueda_producto%' or
                                    nombre like '%$busqueda_producto%' or
                                    tipo like '%$busqueda_producto%' or
                                    cantidad like '%$busqueda_producto%' or
                                    precio like '%$busqueda_producto%' 
                            order by id_producto");
                            while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['id_producto']; ?></td>
                                <td><?php echo $u['nombre']; ?></td>
                                <td><?php echo $u['tipo']; ?></td>
                                <td><?php echo $u['cantidad']; ?></td>
                                <td><?php echo $u['precio']; ?></td>
                                <td>
                                    <a href="actualizar_producto.php?id_producto=<?= $u['id_producto'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                    <a onclick="return eliminar()" href="administracion_producto.php?id_producto=<?= $u['id_producto'] ?>" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                                
                            </tr>
                            <?php }
                            //Capturo la variable busqueda para utilizarla en el reporte de buscar
                            $_SESSION['busqueda_producto'] = $busqueda_producto;
                            ?>
                        </tbody>
                    </table>

        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>


</body>
</html>