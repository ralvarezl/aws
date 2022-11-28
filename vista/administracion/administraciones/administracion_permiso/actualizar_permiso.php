<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
//Verificar permiso del rol
include "../../../../modelo/conexion.php";
$usuario_rol=$_SESSION['usuario_login'];
//Sacar el rol del usuario
$sql=mysqli_query($conexion, "select id_rol from tbl_ms_usuario where usuario='$usuario_rol'");
$row=mysqli_fetch_array($sql);
$id_rol=$row[0];
//Sacar el permiso dependiendo del rol
$sql=mysqli_query($conexion, "select permiso_actualizar from tbl_ms_permisos where id_rol='$id_rol' and id_objeto=16");
$row=mysqli_fetch_array($sql);
$permiso=$row[0];

if($permiso <> 'PERMITIR'){
    
    echo '<script language="javascript">alert("Sin acceso");;window.location.href="administracion_objeto.php"</script>';
}
//include "../../../../modelo/conexion.php";
$id_rol=$_GET["id_rol"];    //Guardamos el id estado desde el boton editar
$id_objeto=$_GET["id_objeto"]; 
$sql=$conexion->query(" select p.id_rol,rol, objeto, permiso_visualizar, permiso_insertar, permiso_actualizar, permiso_eliminar from tbl_ms_permisos p inner join tbl_ms_roles r on r.id_rol=p.id_rol inner join tbl_ms_objetos o on o.id_objeto=p.id_objeto where p.id_rol=$id_rol and p.id_objeto=$id_objeto ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../../public/img/Logo.png">
    <link rel="stylesheet" href="actualizar_permiso.css">
    <title>Actualizar Permiso</title>
</head>
<body>
    
<form class="col-3 p-2 m-auto" method="POST" autocomplete="off">
            <br></br>
            <img src="../../../../public/img/avatar_actualizar.png" class="img-fluid rounded mx-auto d-block"/>
            <h3 class="text-center text-secundary">ACTUALIZAR PERMISO </h3>
            <!--Imput que se oculta para almacenar el objeto para enviarlo a la BD-->
            <input type="hidden" name="id_rol" value="<?= $_GET["id_rol"] ?>">
            <!--Imput que se oculta para almacenar el objeto para enviarlo a la BD-->
            <input type="hidden" name="id_objeto" value="<?= $_GET["id_objeto"] ?>">  
            <?php
            include "../../../../controlador/administraciones/administracion_permiso.php";
            
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>
            <!--INGRESE ID_OBJETO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ROL</label>
            <input type="text" class="form-control" placeholder="" readonly="readonly"
                name="" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->rol ?>">
            </div>
            <!--INGRESE ID_OBJETO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">OBJETO</label>
            <input type="text" class="form-control" placeholder="" readonly="readonly"
                name="" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $datos->objeto ?>">
            </div>
            <!--SELECCIONE VISUALIZAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">VISUALIZAR <?= $datos->objeto ?></label>
            <select class="form-select" aria-label="Default select example" name="permiso_visualizar" >
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->permiso_visualizar ?>"><?= $datos->permiso_visualizar ?></option>
            <!--SELECCIONE DIFERENTE PERMISO DEL QUE TIENE-->
            <?  
                $visualizar=$datos->permiso_visualizar;
                if($visualizar=='PERMITIR'){?>
                        <option value="NO PERMITIR">NO PERMITIR</option>
                    <? 
                }else{?>
                    <option value="PERMITIR">PERMITIR</option>
                    <? 
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE INSERTAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">NUEVO <?= $datos->objeto ?></label>
            <select class="form-select" aria-label="Default select example" name="permiso_insertar" >
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->permiso_insertar ?>"><?= $datos->permiso_insertar ?></option>
            <!--SELECCIONE DIFERENTE PERMISO DEL QUE TIENE-->
            <?  
                $insertar=$datos->permiso_insertar;
                if($insertar=='PERMITIR'){?>
                        <option value="NO PERMITIR">NO PERMITIR</option>
                    <? 
                }else{?>
                    <option value="PERMITIR">PERMITIR</option>
                    <? 
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE ACTUALIAZR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ACTUALIZAR <?= $datos->objeto ?></label>
            <select class="form-select" aria-label="Default select example" name="permiso_actualizar" >
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->permiso_actualizar ?>"><?= $datos->permiso_actualizar ?></option>
            <!--SELECCIONE DIFERENTE PERMISO DEL QUE TIENE-->
            <?  
                $actualizar=$datos->permiso_actualizar;
                if($actualizar=='PERMITIR'){?>
                        <option value="NO PERMITIR">NO PERMITIR</option>
                    <? 
                }else{?>
                    <option value="PERMITIR">PERMITIR</option>
                    <? 
                }
            ?>
            </select>
            </div>
            <!--SELECCIONE ELIMINAR-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">ELIMINAR <?= $datos->objeto ?></label>
            <select class="form-select" aria-label="Default select example" name="permiso_eliminar" >
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <option selected value="<?= $datos->permiso_eliminar ?>"><?= $datos->permiso_eliminar ?></option>
            <!--SELECCIONE DIFERENTE PERMISO DEL QUE TIENE-->
            <?  
                $eliminar=$datos->permiso_eliminar;
                if($eliminar=='PERMITIR'){?>
                        <option value="NO PERMITIR">NO PERMITIR</option>
                    <? 
                }else{?>
                    <option value="PERMITIR">PERMITIR</option>
                    <? 
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            
            <!--BOTON ACTUALIZAR SUCURSAL Y CANCELAR-->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnactualizar_permiso" value="ok">Actualizar Permiso</button>
            <button type="button" class="btn btn-outline-danger" onclick="location.href='administracion_permiso.php'" >Cancelar</button>
            </div>
            
    </form>
</body>
</html>