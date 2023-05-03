<?php
//Campo vacio
function campo_vacio($importar, &$validar){
        if (!empty($_POST["importar"] and $validar=true)) { //Campos llenos
            return $validar;
        }else {
            $validar=false;
            echo"<div align='center' class='alert alert-danger' >Copie el nombre del respaldo</div>";
            header("location:restauracion.php");
            return $validar;
        }
    }
    
if (!empty($_POST["btnimportar"])) {
        
    $importar=$_POST["importar"];
    $sesion_usuario=$_SESSION['usuario_login'];
    campo_vacio($importar, $validar);
    if($validar=true){
        $conn =new mysqli('localhost', 'root', '1234' , 'sis_aws');
        
        $query = '';
        $sqlScript = file($importar);
        foreach ($sqlScript as $line)   {
                
                $startWith = substr(trim($line), 0 ,2);
                $endWith = substr(trim($line), -1 ,1);
                
                if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                        continue;
                }
                        
                $query = $query . $line;
                if ($endWith == ';') {
                        mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
                        $query= '';             
                }
        }
        //Guardar la bitacora 
        include "../modelo/conexion.php";
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Restaurar', 'Restauro el sistema','$sesion_usuario')");
        session_destroy();
        echo '<script language="javascript">alert("Restauración de la base exitosa ingrese de nuevo");;window.location.href="../index.php"</script>';//estado ingresado
    }
    
    
}

//boton de respaldo
if (!empty($_POST["btnrespaldo"])){
        header("location:respaldo.php");
}
?>