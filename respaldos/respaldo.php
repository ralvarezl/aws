<?php
    //==================================Respaldo==========================
// Funcion respaldar_db
function respaldar_db($host, $user, $pass, $dbname, $tables = '*') {
    date_default_timezone_set("America/Tegucigalpa");
    $fecha = date('Y-m-d');
    $link = mysqli_connect($host,$user,$pass, $dbname);

    // Revisar la coneccion
    if (mysqli_connect_errno())
    {
        echo "Fallo la conexion a MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    // Obtener todas las tablas
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES'); // Obtener el nombre de todas las tablas
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return = '';
    
    // Recorrido en todas las tablas
    foreach($tables as $table)
    {
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        $return.= 'DROP TABLE IF EXISTS '.$table.';'; // Este es un texto que se agrega al archivo
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table)); // Se obtiene el codigo SQL para crear las tablas
        $return.= "\n\n".$row2[1].";\n\n";
        $counter = 1;

        // Obtener campos
        for ($i = 0; $i < $num_fields; $i++) 
        {   // Obtener filas
            while($row = mysqli_fetch_row($result))
            {   
                if($counter == 1){
                    $return.= 'INSERT INTO '.$table.' VALUES('; // Se crea el codigo SQL para insertar los datos a las tablas
                } else{
                    $return.= '(';
                }

                // En Campos
                for($j=0; $j<$num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields+1)) { $return.= ','; }
                }

                if($num_rows == $counter){
                    $return.= ");\n";
                } else{
                    $return.= "),\n";
                }
                ++$counter;
            }
        }
        $return.="\n\n\n";
    }

    // Guardar el archivo
    $fileName = 'sis_aws-'.$fecha.'.sql'; // El resultado del respaldo queda en un archivo con extension .sql
    $handle = fopen('C:\\xampp\\htdocs\\aws\\respaldos\\'.$fileName.'','w+');
    fwrite($handle,$return);
    if(fclose($handle)){
        echo '<script language="javascript">alert("Copia guardada exitosamente vuelva a iniciar sesion");;window.location.href="../login.php"</script>';//Objeto eliminado
        exit; 
    }
}


//if(!empty($_POST["backupSQL"])){
// Datos de Acceso a la base de datos
$dbhost = 'localhost'; // Host de la base de datos
$dbuser = 'root'; // Usuario de la base de datos
$dbpass = '1234'; // Password de la base de datos
$dbname = 'sis_aws'; // Nombre de la base de datos
$tables = '*'; // Tablas separadas por comma y * si son todas las tablas
// Llamar la funcion
respaldar_db($dbhost, $dbuser, $dbpass, $dbname, $tables);

session_destroy();

//}
?>