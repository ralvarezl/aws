<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Permisos</title>
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
                <i class="fa-solid fa-users-gear"></i> ADMINISTRACION PERMISOS
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
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_cliente.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE CLIENTE</a>
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
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE PEDIDOS</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
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

    <!--Funcion para confirmar si desea eliminar-->
    <script>
        function eliminar(){
        var respuesta=confirm("Esta seguro que desea eliminar?");
        return respuesta
        }
    </script>

    <!--INICIO DE LA TABLE ESTADO-->
    <?php 
        //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
        $busqueda_permiso = strtoupper($_REQUEST['busqueda_permiso']);
    ?>
    <div class="container-fluid row">
        <div class="col-8 p-4 m-auto">
            <br><br>
            <?php
            include "../../../../modelo/conexion.php";
            //include "../../../../controlador/administraciones/eliminar_permiso.php";
            ?>  
            <div class="row p-2"> <!--Div que contiene nuevo estado y la busqueda-->
                <div class="ml-auto p-2">
                    <button type="button" class="btn btn-dark" onclick="location.href='nuevo_permiso.php'" >Nuevo Permiso</button>
                </div>
                    
                <!--BUSQUEDA, al apretar el boton buscar que me envie a buscar_permiso-->
                <div class="align-items-end">
                    <form action="buscar_permiso.php" method="get" class="form_search">
                        <input type="text" name="busqueda_permiso" id="busqueda_permiso" placeholder="" value="<?php echo $busqueda_permiso; ?>">
                        <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="administracion_permiso.php"></a>
                        <input type="submit" value="Buscar" class="btn btn-secondary">
                        <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_permiso.php"></a>
                    </form>
                </div>
            </div>

            <table class="table table-dark table-striped" style="text-align:center; white-space: nowrap; overflow: auto;">
                <thead class="table-dark">
                    <tr>
                        <th class="col-sm-1" scope="col">ROL</th>
                        <th scope="col-sm-1" scope="col">OBJETO</th>
                        <th scope="col">PERMISO PARA VISUALIZAR</th>
                        <th scope="col">PERMISO PARA INSERTAR</th>
                        <th scope="col">PERMISO PARA ACTUALIZAR</th>
                        <th scope="col">PERMISO PARA ELIMINAR</th>
                        <th scope="col"style="width:15px"></th>
                        <th scope="col"style="width:15px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Llamado a la base de datos
                    include "../../../../modelo/conexion.php";
                    $sql=$conexion->query("select id_rol, id_objeto, permiso_visualizar, permiso_insertar, permiso_actualizar, permiso_eliminar from tbl_ms_permisos
                    where id_rol like '%$busqueda_permiso%' or
                            id_objeto like '%$busqueda_permiso%' or
                            permiso_visualizar like '%$busqueda_permiso%' or
                            permiso_insertar like '%$busqueda_permiso%' or
                            permiso_actualizar like '%$busqueda_permiso%' or
                            permiso_eliminar like '%$busqueda_permiso%' 
                    order by id_rol");

                    while($u = $sql->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $u['id_rol']; ?></td>
                        <td><?php echo $u['id_objeto']; ?></td>
                        <td><?php echo $u['permiso_visualizar']; ?></td>
                        <td><?php echo $u['permiso_insertar']; ?></td>
                        <td><?php echo $u['permiso_actualizar']; ?></td>
                        <td><?php echo $u['permiso_eliminar']; ?></td>
                        <td>
                            <a href="actualizar_permiso.php?id_rol=<?= $u['id_rol'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                        <td>
                            <a onclick="return eliminar()" href="administracion_permiso.php?id_id_rol=<?= $u['id_rol'] ?>" class="btn btn-small btn-danger" name="btnborrar_permiso"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                    <?php }
                    $_SESSION['busqueda_permiso'] = $busqueda_permiso;
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