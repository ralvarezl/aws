<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="administracion_usuarios.css">

</head>

<body>
    <h1 class="text-center p-3">USUARIOS</h1>
    <div class="container-fluid row">
        <form class="col-2 p-3" method="POST">
            <h3 class="text-center text-secundary">REGISTRO DE USUARIOS</h3>
            <?php
            include "../../modelo/conexion.php";
            include "../../controlador/administracion_usuarios.php";
            ?>
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Nombres</label>
            <input type="text" class="form-control" placeholder="Ingrese nombres" name="nombres">
            </div>

            <div class="mb-3">
			<label for="formGroupExampleInput" class="form-label">Usuario</label>
			<input id="usuario" type="text"
				class="form-control" name="usuario" title="ingrese usuario" autocomplete="usuario" placeholder="Ingrese usuario" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
		    </div>

            <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="Ingrese contraseña" name="password">
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Identidad</label>
            <input type="text" class="form-control" placeholder="Ingrese numero de identidad" name="identidad">
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Genero</label>
            <select class="form-select" aria-label="Default select example" name="genero">
            <option selected>Seleccione genero</option>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            </select>
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Telefono</label>
            <input type="text" class="form-control" placeholder="Ingrese telefono" name="telefono">
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Direccion</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion">
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Correo</label>
            <input type="text" class="form-control" placeholder="Ingrese correo electronico" name="correo">
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado">
            <option selected>Seleccione estado</option>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
            <option value="Bloqueado">Bloqueado</option>
            </select>
            </div>

            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="id_rol">
            <option selected>Seleccione rol</option>
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select id_rol, rol from tbl_ms_roles");
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['id_rol'].'">'.$datos['rol'].'</option>';
                }
            ?>
            </select>
            </div>
            <!--BOTON NUEVO USUARIO-->
            <button type="submit" class="btn btn-dark" name="btnregistrar" value="ok">Registrar Usuario</button>
        </form>
                <div class="col-8 p-4">
                    <table class="table">
                        <thead class="table-dark">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Llamado a la base de datos
                            include "../../modelo/conexion.php";
                            $sql= $conexion->query("select id_usuario, nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, rol from tbl_ms_usuario u join tbl_ms_roles r ON  r.ID_ROL=u.ID_ROL ");
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
                                    <a href="" class="btn btn-small btn-warning" name="btnactualizar"><i class="fa-solid fa-user-pen"></i></a>
                                    <a href="" class="btn btn-small btn-danger" name="btnborrar"><i class="fa-solid fa-trash-can"></i></a>
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