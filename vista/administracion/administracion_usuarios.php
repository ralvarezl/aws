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
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
                <img src="../../public/img/Ac.png">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="fas fa-user-circle" style='font-size:36px' id="offcanvasDarkNavbarLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 ">

                <li class="nav-item p-3">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-gear"></i>  ADMINISTRADOR DE USUARIOS</a>
                </li>
                <li class="nav-item p-3">
                    <a class="nav-link" href="#">ADMINISTRADOR </a>
                </li>
                <li class="nav-item p-3">
                    <a class="nav-link" href="#">ADMINISTRADOR </a>
                </li>

                <li class="nav-item dropdown p-3">
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


    <h1 class="text-center p-3">USUARIOS</h1>
    <div class="container-fluid row">
        <form class="col-2 p-3" method="POST">
            <br></br>
            <h3 class="text-center text-secundary">REGISTRO DE USUARIOS</h3>
            <?php
            include "../../modelo/conexion.php";
            include "../../controlador/administracion_usuarios.php";
            ?>
            <!--INGRESE NOMBRE-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombres</label>
            <input type="text" class="form-control" placeholder="Ingrese nombres" 
                name="nombres" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE USUARIO-->
            <div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text" class="form-control" name="usuario" 
                title="ingrese usuario" autocomplete="usuario" placeholder="Ingrese usuario" onKeyUp="this.value=this.value.toUpperCase();">
		    </div>
            <!--INGRESE CONTRASEÑA-->
            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="Ingrese contraseña" name="password">
            </div>
            <!--INGRESE IDENTIDAD-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="text" class="form-control" placeholder="Ingrese numero de identidad" name="identidad">
            </div>
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
            <option selected>Seleccione genero</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select genero from tbl_ms_genero");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['genero'].'">'.$datos['genero'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--INGRESE TELEFONO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="text" class="form-control" placeholder="Ingrese telefono" name="telefono">
            </div>
            <!--INGRESE DIRECCIÓN-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Dirección</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion" onKeyUp="this.value=this.value.toUpperCase();">
            </div>
            <!--INGRESE CORREO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Correo</label>
            <input type="text" class="form-control" placeholder="Ingrese correo electronico" name="correo">
            </div>
            <!--SELECCIONE ESTADO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado">
            <option selected>Seleccione estado</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select estado from tbl_ms_estado");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['estado'].'">'.$datos['estado'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE ROL-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            <option selected>Seleccione rol</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles");
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'">'.$datos['rol'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--BOTON NUEVO USUARIO-->
            <button type="submit" class="btn btn-dark" name="btnregistrar" value="ok">Registrar Usuario</button>
        </form>
                <div class="col-9 p-4">
                <?php
                include "../../modelo/conexion.php";
                include "../../controlador/eliminar_usuario.php";
                ?>
                    <table class="table" style="text-align:center;" >
                        <thead class="table-dark">
                        <br></br>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRES</th>
                            <th scope="col">USUARIO</th>
                            <th scope="col">CONTRASEÑA</th>
                            <th scope="col">IDENTIDAD</th>
                            <th scope="col">GENERO</th>
                            <th scope="col">TELEFONO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">ROL</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../modelo/conexion.php";
                            $sql= $conexion->query("select id_usuario, nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, rol from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL order by id_usuario asc");
                            while($u = $sql->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $u['id_usuario']; ?></td>
                                <td><?php echo $u['nombres']; ?></td>
                                <td><?php echo $u['usuario']; ?></td>
                                <td><?php echo $u['password']; ?></td>
                                <td><?php echo $u['identidad']; ?></td>
                                <td><?php echo $u['genero']; ?></td>
                                <td><?php echo $u['telefono']; ?></td>
                                <td><?php echo $u['direccion']; ?></td>
                                <td><?php echo $u['correo']; ?></td>
                                <td><?php echo $u['estado']; ?></td>
                                <td><?php echo $u['rol']; ?></td>
                                <td>
                                    <a href="actualizar_usuarios.php?id_usuario=<?= $u['id_usuario'] ?>" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                </td>
                                <td>
                                    <a href="administracion_usuarios.php?id_usuario=<?= $u['id_usuario'] ?>" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                    <!--BOTON PROVISIONAL SALIDA-->
                    <input onclick="location.href='../../login.php'" name="" class="btn btn-danger" title="click para registrar un nuevo usuario" type="dark" value="Salir">
                </div>
                    
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646c794df3.js"></script>

    
</body>

</html>