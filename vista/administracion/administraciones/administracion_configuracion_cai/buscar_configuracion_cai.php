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
    <title>Administracion Configuracion Cai</title>
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
                <i class="fa-solid fa-gears"></i> ADMINISTRACION DE CONFIGURACION CAI
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
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
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

        <!--Funcion de eliminar-->
        <script>
            function eliminar(){
                var respuesta=confirm("¿Deseas eliminar la configuracion cai?")
            return respuesta;
            }
        </script>
            
    <div class="col-9 p-3 m-auto">
    <?php 

        //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
        $busqueda_configuracion_cai = strtoupper($_REQUEST['busqueda_configuracion_cai']);
        
        ?>    

        <!--PORQUE CARAJOS TENGO DOS BOTONES?-->
        <div class="ml-auto p-2">
                <button type="button" class="btn btn-dark" onclick="location.href='nuevo_configuracion_cai.php'" >Nuevo Configuracion Cai</button>
        </div>

        <div class="ml-auto p-2">
            <button type="button" class="btn btn-dark" onclick="location.href='nuevo_configuracion_cai.php'" >Nuevo Configuracion Cai</button>
        </div>

        <!--BUSQUEDA-->
        <div class="ml-auto p-2">
            <form action="buscar_configuracion_cai.php" method="get" class="form_search">
            <input type="text" name="busqueda_configuracion_cai" id="busqueda_configuracion_cai" placeholder="" value="<?php echo $busqueda_configuracion_cai; ?>">
            <input type="submit" value="Buscar" class="btn btn-secondary">
            <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="administracion_configuracion_cai.php"></a>
            <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_configuracion_cai.php"></a>
            </form>
        </div>

        <?php
                include "../../../../modelo/conexion.php";
                
                ?>
                    <table class="table table-dark table-striped" style="text-align:center;" >
                        <thead class="table-dark">
                        
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NUMERO CAI</th>
                            <th scope="col">SECUENCIA INICIAL</th>
                            <th scope="col">SECUENCIA ACTUAL</th>
                            <th scope="col">SECUENCIA FINAL</th>
                            <th scope="col">VENCIMIENTO</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../../../modelo/conexion.php";
                            include "../../../../controlador/administraciones/eliminar_configuracion_cai.php";
                            
                            $sql= $conexion->query("select id_configuracion_cai, numero_cai, secuencia_inicial, secuencia_actual, 
                            secuencia_final, fecha_vencimiento from tbl_configuracion_cai where
                                id_configuracion_cai like '%$busqueda_configuracion_cai%' or
                                numero_cai like '%$busqueda_configuracion_cai%' or
                                secuencia_inicial like '%$busqueda_configuracion_cai%' or
                                secuencia_actual like '%$busqueda_configuracion_cai%' or
                                secuencia_final like '%$busqueda_configuracion_cai%' or
                                fecha_vencimiento like '%$busqueda_configuracion_cai%'
                            order by id_configuracion_cai");
                            while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['id_configuracion_cai']; ?></td>
                                <td><?php echo $u['numero_cai']; ?></td>
                                <td><?php echo $u['secuencia_inicial']; ?></td>
                                <td><?php echo $u['secuencia_actual']; ?></td>
                                <td><?php echo $u['secuencia_final']; ?></td>
                                <td><?php echo $u['fecha_vencimiento']; ?></td>
                                <td>
                                    <a href="actualizar_configuracion_cai.php?id_configuracion_cai=<?= $u['id_configuracion_cai'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                </td>

                                <td>
                                    <a onclick="return eliminar()" href="administracion_configuracion_cai.php?id_configuracion_cai=<?= $u['id_configuracion_cai'] ?>" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                                
                            </tr>
                            <?php }
                            //Capturo la variable busqueda para utilizarla en el reporte de buscar
                            $_SESSION['busqueda_configuracion_cai'] = $busqueda_configuracion_cai;
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