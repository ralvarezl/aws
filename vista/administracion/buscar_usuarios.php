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
    <title>Administracion Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../public/style_inicio.css">
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
                <i class="fa-solid fa-users-gear"></i> ADMINISTRACION DE USUARIOS
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

    
    <div class="container-fluid row">
                <?php 
                //Declaramos la variable busqueda para capturar que es lo que quiere buscar el usuario
                $busqueda = strtoupper($_REQUEST['busqueda']);
                if (empty($busqueda)) {
                    //Si busqueda viene vacia que me regrese administracion usuarios
                    header("location: administracion_usuarios.php");
                }
                ?>

                <!--INICIO DE LA TABLE USUARIOS-->
                <div class="col-10 p-4">
                    <br><br>

                <div class="row p-2"> <!--Div que contiene nuevo usuario y la busqueda-->
                <div class="ml-auto p-2">
                <button type="button" class="btn btn-dark" onclick="location.href='nuevo_usuario.php'" >Nuevo Usuario</button>
                </div>
                <?php
                include "../../modelo/conexion.php";
                include "../../controlador/eliminar_usuario.php";
                //echo "Nombre de usuario recuperado de la variable de sesión:" . $_SESSION['usuario_login'];
                ?>
                    <!--BUSQUEDA-->
                    <div class="align-items-end">
                    <form action="buscar_usuarios.php" method="get" class="form_search">
                        <input type="text" name="busqueda" id="busqueda" placeholder="" value="<?php echo $busqueda; ?>">
                        <input type="submit" value="Buscar" class="btn btn-secondary">
                        <a class="fa-sharp fa-solid fa-rotate-right btn btn-lg btn-secondary" href="administracion_usuarios.php"></a>
                        <a class="fa-solid fa-file-pdf btn btn-lg btn-danger" href="reporte_buscar_usuarios.php"></a>
                    </form>
                    </div>
                </div>

                    <table class="table table-dark table-striped" style="text-align:center;" >
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRES</th>
                            <th scope="col">USUARIO</th>
                            <th scope="col">IDENTIDAD</th>
                            <th scope="col">GENERO</th>
                            <th scope="col">TELEFONO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">ROL</th>
                            <th scope="col">VENCIMIENTO</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../modelo/conexion.php";
                            
                                $sql=$conexion->query("select id_usuario, nombres, usuario, identidad, genero, telefono, direccion, correo, estado, rol,fecha_vencimiento 
                                from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL 
                                where usuario <> 'ADMIN'
                                    and (id_usuario like '%$busqueda%' or 
                                        nombres like '%$busqueda%' or
                                        usuario like '%$busqueda%' or 
                                        identidad like '%$busqueda%' or 
                                        genero like '%$busqueda%' or 
                                        telefono like '%$busqueda%' or 
                                        direccion like '%$busqueda%' or 
                                        correo like '%$busqueda%' or 
                                        estado like '%$busqueda%' or
                                        r.rol like '%$busqueda%' or
                                        fecha_vencimiento like '%$busqueda%')
                                order by id_usuario asc");                                
                                while($u = $sql->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo $u['id_usuario']; ?></td>
                                        <td><?php echo $u['nombres']; ?></td>
                                        <td><?php echo $u['usuario']; ?></td>
                                        <td><?php echo $u['identidad']; ?></td>
                                        <td><?php echo $u['genero']; ?></td>
                                        <td><?php echo $u['telefono']; ?></td>
                                        <td><?php echo $u['direccion']; ?></td>
                                        <td><?php echo $u['correo']; ?></td>
                                        <td><?php echo $u['estado']; ?></td>
                                        <td><?php echo $u['rol']; ?></td>
                                        <td><?php echo $u['fecha_vencimiento']; ?></td>
                                        <td>
                                            <a href="actualizar_usuarios.php?id_usuario=<?= $u['id_usuario'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                        </td>
                                        <td>
                                            <a href="administracion_usuarios.php?id_usuario=<?= $u['id_usuario'] ?>" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>                                    
                                    <?php }
                                    //Capturo la variable busqueda para utilizarla en el reporte de buscar
                                    $_SESSION['busqueda'] = $busqueda;
                                    ?>
                        </tbody>
                    </table>
                    <!--FIN DE LA TABLE USUARIOS-->

                    <!--BOTON PROVISIONAL SALIDA
                    <input onclick="location.href='../../login.php'" name="btn_salir_administracion_usuarios" class="btn btn-danger" title="click para registrar un nuevo usuario" type="dark" value="Salir">-->
                </div>
                    
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>

    
</body>

</html>