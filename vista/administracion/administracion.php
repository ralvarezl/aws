<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="administracion.css">

</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light">Logo</h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="#" class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle user"></i></a>

                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="../../login.php"><i class="fas fa-sign-out-alt m-1"></i>Salir
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                </nav>
            </div>
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="columna col-lg-6">
                        CONTENIDO
                        <?php
                        //Llamado a la base de datos
                        include "../../modelo/conexion.php";
                        //Consulta la tabla:
                        $sql= $conexion->query("select id_usuario, nombres, usuario,password, identidad, telefono, estado, rol, correo from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL ");
                        ?>
                        <table >
                            <tr>
                                <td>Id</td>
                                <td>Nombre</td>
                                <td>Usuario</td>
                                <td>Contraseña</td>
                                <td>Identidad</td>
                                <td>Telefono</td>
                                <td>Estado</td>
                                <td>Rol</td>
                                <td>Correo</td>
                        </tr>
                        <?php while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['id_usuario']; ?></td>
                                <td><?php echo $u['nombres']; ?></td>
                                <td><?php echo $u['usuario']; ?></td>
                                <td><?php echo $u['password']; ?></td>
                                <td><?php echo $u['identidad']; ?></td>
                                <td><?php echo $u['telefono']; ?></td>
                                <td><?php echo $u['estado']; ?></td>
                                <td><?php echo $u['rol']; ?></td>
                                <td><?php echo $u['correo']; ?></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>

                </div>

            </main>
        </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>
</body>

</html>