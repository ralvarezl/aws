<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../../../public/style_seguridad.css">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">

</head>

<body>
    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../../../controlador/bitacora_pantalla/inicio.php" >
                <img src="../../../../public/img/aws_navbar.png"/>
                Andrés Coffee
            </a>
            <a class="navbar-brand" href="#" >
                <i class="fa-solid fa-list-check"></i> BITÁCORA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <!--Perfil de usuario-->
                <a class="navbar-brand" href="../../../../controlador/bitacora_pantalla/perfil_usuario.php" >
                <h1 class="fas fa-user-circle" ></h1>
                </a>
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

                
                <!--FACTURA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/factura.php"><i class="fas fa-file-invoice"></i> NUEVA FACTURA </a>
                </li>
            

                <!--ADMINISTRADOR DE FACTURA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ADMINISTRADOR DE FACTURA
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                    
                    <!--ADMINISTRADOR CIENTE-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_cliente.php"><i class="fas fa-user-cog"></i> ADMINISTRADOR DE CLIENTE</a></li>
                    <!--ADMINISTRADOR PRODUCTO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_producto.php"><i class="fas fa-mug-hot"></i> ADMINISTRADOR DE PRODUCTOS</a></li>
                    <!--ADMINISTRADOR PROMOCION-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_promocion.php"><i class="fas fa-tags"></i> ADMINISTRADOR DE PROMOCION</a></li>
                    <!--ADMINISTRADOR DESCUENTO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_descuento.php"><i class="fas fa-user-tag"></i> ADMINISTRADOR DE DESCUENTO</a></li>
                    <!--ADMINISTRADOR TIPO PEDIDO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fas fa-poll-h"></i> ADMINISTRADOR DE TIPO PEDIDO</a></li>
                    <!--ADMINISTRADOR DE SUCURSAL-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_sucursal.php"><i class="fas fa-store-alt"></i> ADMINISTRADOR DE SUCURSAL</a></li>
                    <!--ADMINISTRADOR DE FACTURA-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_factura.php"><i class="fas fa-file-alt"></i> ADMINISTRADOR DE FACTURA</a></li>
                    <!--ADMINISTRADOR DE FACTURA DETALLE-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_factura_detalle.php"><i class="fas fa-receipt"></i> ADMINISTRADOR DE FACTURA DETALLE</a></li>
                    <!--ADMINISTRADOR DE FACTURA DESCUENTO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_factura_descuento.php"><i class="fas fa-user-tag"></i>  ADMIN. FACTURA DESCUENTO</a></li>
                    <!--ADMINISTRADOR DE FACTURA PROMOCION-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_factura_promocion.php"><i class="fas fa-tag"></i> ADMIN. FACTURA PROMOCION</a></li>
                    <!--ADMINISTRADOR DE CONFIGURACION CAI-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_configuracion_cai.php"><i class="fas fa-file-alt"></i> ADMIN. CONFIGURACION CAI</a></li>
                </li>
                </ul>

                

                <!--ADMINISTRADOR DE SEGURIDAD-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ADMINISTRADOR DE SEGURIDAD
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                   
                    <!--ADMINISTRADOR DE USUARIO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a></li>
                    <!--ADMINISTRADOR DE ESTADO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_estado.php"><i class="fas fa-toggle-on"></i> ADMINISTRADOR DE ESTADO</a></li>
                    <!--ADMINISTRADOR DE GENERO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_genero.php"><i class="fas fa-venus-mars"></i> ADMINISTRADOR DE GENERO</a></li>
                    <!--ADMINISTRADOR DE PARAMETROS-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a></li>
                    <!--ADMINISTRADOR DE OBJETO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_objeto.php"><i class="fas fa-lightbulb"></i> ADMINISTRADOR DE OBJETO</a></li>
                    <!--ADMINISTRADOR DE PERMISO-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_permiso.php"><i class="fas fa-vote-yea"></i> ADMINISTRADOR DE PERMISOS</a></li>
                    <!--ADMINISTRADOR DE PREGUNTAS-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_pregunta.php"><i class="fas fa-question-circle"></i> ADMINISTRADOR DE PREGUNTAS</a></li>
                    <!--ADMINISTRADOR DE ROLES-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/admin_rol.php"><i class="fas fa-user-tie"></i> ADMINISTRADOR DE ROLES</a></li>
                    <!--ADMINISTRADOR DE BITACORA-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a></li>
                    <!--BACKUP-->
                    <li><a class="dropdown-item" href="../../../../controlador/bitacora_pantalla/restauracion.php"><i class="fa-solid fa-cloud-arrow-down"></i> BACKUP</a></li>
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

        <!--INICIO DE LA TABLE-->
        <?php 
            //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
            $fecha_inicio = strtoupper($_REQUEST['fecha_inicio']);
            $fecha_final = strtoupper($_REQUEST['fecha_final']);
            $busqueda_bitacora = strtoupper($_REQUEST['busqueda_bitacora']);
        ?>  
        <div class="col-9 p-4 m-auto">
        <br><br>
            <div class="row p-2">
                <div class="align-items-end">
                    <form action="buscar_bitacora.php" method="get" class="form_search">
                        <input type="text" name="busqueda_bitacora" id="busqueda_bitacora" placeholder="Buscar" value="<?php echo $busqueda_bitacora; ?>">
                        <label for="formGroupExampleInput" class="form-label">Fecha inicio</label>
                        <input type="datetime" name="fecha_inicio" id="fecha_inicio" class="form-label" placeholder="Fecha Inicio" value="<?php echo $fecha_inicio; ?>">
                        <label for="formGroupExampleInput" class="form-label">Fecha final</label>
                        <input type="datetime" name="fecha_final" id="fecha_final" class="form-label" placeholder="Fecha Final" value="<?php echo $fecha_final; ?>">
                        <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="bitacora.php"></a>
                        <input type="submit" value="Buscar" class="btn btn-secondary">
                        <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_bitacora.php"></a>
                    </form>
                </div>
            </div>
        <?php
                include "../../../../modelo/conexion.php";
                
                ?>
                    <table class="table table-dark table-striped" style="text-align:center;" >
                        <thead class="table-dark">
                        
                            <tr>
                            <th scope="col">FECHA ACCIÓN</th>
                            <th scope="col">ACCIÓN</th>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">REALIZADO POR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../../../modelo/conexion.php";
                            $sql= $conexion->query("select fecha_bitacora, accion, descripcion, creado_por from tbl_ms_bitacora where fecha_bitacora between '$fecha_inicio' and '$fecha_final' and
                                accion like '%$busqueda_bitacora%' or
                                descripcion like '%$busqueda_bitacora%' or
                                creado_por like '%$busqueda_bitacora%'
                            order by id_bitacora desc");
                            while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['fecha_bitacora']; ?></td>
                                <td><?php echo $u['accion']; ?></td>
                                <td><?php echo $u['descripcion']; ?></td>
                                <td><?php echo $u['creado_por']; ?></td>
                            </tr>
                            <?php }
                            $_SESSION['fecha_inicio'] = $fecha_inicio;
                            $_SESSION['fecha_final'] = $fecha_final;
                            $_SESSION['busqueda_bitacora'] = $busqueda_bitacora;
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