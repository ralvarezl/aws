<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="administracion_usuarios.css">

</head>

<body>
    
    <form action="administracion_usuarios.php" method="post">
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
                    <a href="#"><i class="fas fa-home"></i><span>ADMINISTRACION DE USUARIOS</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                    <a href="#"><i class="fas fa-home"></i><span>Inicio</span></a>
                </nav>
            </div>
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="columna col-lg-6">
                        <?php
                        //Llamado a la base de datos
                        include "../../modelo/conexion.php";
                        //Consulta la tabla:
                        $sql= $conexion->query("select id_usuario, nombres, usuario,password, identidad, telefono, estado, rol, correo from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL ");
                        ?>
                        <table class = "table table-dark table-striped">
                            <h1>USUARIOS</h1>
                            <tr>
                                <td>ID</td>
                                <td>NOMBRES</td>
                                <td>USUARIO</td>
                                <td>CONTRASEÑA</td>
                                <td>IDENTIDAD</td>
                                <td>TELEFONO</td>
                                <td>ESTADO</td>
                                <td>ROL</td>
                                <td>CORREO</td>
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
                        <!--BOTON PROVISIONAL SALIDA-->
                        <input onclick="location.href='../../login.php'" name="" class="btn btn-danger" title="click para registrar un nuevo usuario" type="dark" value="Salir">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                         Agregar Usuario
                        </button>

                        <!-- Modal Registro Usuario -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registro Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            <!--DATOS DEL MODAL-->
                            <?php
                            //Llamado a la base de datos
                            include "../../modelo/conexion.php";
                            include "../../controlador/administracion_usuarios.php";  
                            ?>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Nombres</label>
                                <input id="nombres" type="text" class="form-control" placeholder="Ingrese nombres">
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Usuario</label>
                                <input id="usuario" type="text" class="form-control" placeholder="Ingrese usuario" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control" placeholder="Ingrese contraseña">
                            </div>

                            
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Identidad</label>
                                <input id="identidad" type="text" class="form-control" placeholder="Ingrese identidad">
                            </div>
                            
                            <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Genero</label>
                            <select id="genero" class="form-select" aria-label="Default select example">
                            <option selected>Seleccione un genero</option>
                            <option value="1">Hombre</option>
                            <option value="2">Mujer</option>
                            </select>
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Telefono</label>
                                <input id="telefono" type="text" class="form-control" placeholder="Ingrese telefono">
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Direccion</label>
                                <input id="direccion" type="text" class="form-control" placeholder="Ingrese direccion">
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Correo</label>
                                <input id="correo" type="text" class="form-control" placeholder="Ingrese correo electronico">
                            </div>

                            <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Estado</label>
                            <select id="estado" class="form-select" aria-label="Default select example">
                            <option selected>Seleccione un estado</option>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            </select>
                            </div>

                            <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Rol</label>
                            <select id="rol" class="form-select" aria-label="Default select example">
                            <option selected>Seleccione un rol</option>
                            <option value="1">Administrador</option>
                            <option value="2">Empleado</option>
                            </select>
                            </div>

                            
                            <!--FIN DATOS DEL MODAL--> 
                     
                            </div>                          
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                                <input name="btnguardar" class="btn btn-dark" title="click para guardar" type="submit" value="Guardar">
                            </div>
                            </div>
                        </div>
                        </div>
                            
                    </div>

                </div>

            </main>
        </div>
    </div>
</form>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>

    
</body>

</html>