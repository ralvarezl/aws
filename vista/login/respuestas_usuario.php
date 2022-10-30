<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../../public/style_login.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">
    <title>Respuestas usuario</title>
</head>
<body>
    <br></br>
    <form action="respuestas_usuario.php" class="col-3 p-3 m-auto" method="post" autocomplete="off">
        <h3 class="text-center text-secundary" >Login Inicial</h3>
        <?php
                include "../../modelo/conexion.php";
                include "../../controlador/respuestas_usuario.php";
                $sql=$conexion->query(" select * from tbl_ms_preguntas");
        ?> 
        <!--MUESTRO USUARIO debe mostrar usuario que hizo el registro-->
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">USUARIO</label>
            <input type="text" class="form-control" name="usuario" onKeyUp="this.value=this.value.toUpperCase();" value="<?= $_SESSION['usuario_login'] ?>">
        </div>

        <!--COMBOBOX PREGUNTAS-->
        <?php
            //WHILE PARA MOSTRAR LOS DATOS EN LOS CAMPOS
            while ($datos=$sql->fetch_object()) {?>                       
            <!--SELECCIONE GENERO-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">SELECCIONE PREGUNTA:</label>
            <select class="form-select" aria-label="Default select example" name="select_pregunta">
            <!--<option>Seleccione pregunta</option>-->
              <!--SELECCIONA EL GENERO YA ESTABLECIDO EN LA BACE-->
            <?php 
            include "../../modelo/conexion.php";
            $sql=$conexion->query("select * from tbl_ms_preguntas" );
                //Mostrar los roles creados en la base de datos
                while($datos=mysqli_fetch_array($sql)){
                    echo '<option value="'.$datos['ID_PREGUNTA'].'" >'.$datos['PREGUNTA'].'</option>';
                }
            ?>
            </select>
            </div>
            <?php }
            ?>
            <!--PRIMERA PREGUNTA-->
            <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">RESPUESTA:</label>
            <input type="text" class="form-control" name="respuesta_pregunta" onKeyUp="this.value=this.value.toUpperCase();">
            </div>

        <!--BOTONERIA-->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-dark" name="btnguardar" id="btnguardar" value="ok">GUARDAR</button>
            <button type="button" class="btn btn-danger" onclick="location.href='../../login.php'" >SALIR</button>
        </div>
    </form>
    
</body>
</html>