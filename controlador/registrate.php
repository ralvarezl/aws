<?php
//Funcion para validar campos vacios
function campo_vacio_registrate($nombres,$usuario,$password,$r_password,$identidad,$genero,$telefono,$direccion,$correo,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["r_password"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor Rellenar Campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que el usuario no exista
function usuario_existe_registrate($usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Usuario existente</div>"; //Usuario no existe
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion Validar contraseña sea correta
function contrasenia($password,$r_password,&$validar){
    if($password===$r_password){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-warning text-center'>Ambas Contraseñas Deben Ser Iguales</div>";//CONTRASEÑAS DISTINTAS
        return $validar;
    }

}

//Validar contraseña robusta
function validar_password($password,&$validar){
    //validar tenga minusculas
    if (!preg_match('/[a-z]/',$password)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra minúscula</div>";
        //return $validar;
    } else {
        //Validar tenga mayusculas
        if (!preg_match('/[A-Z]/',$password)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos una letra mayuscula</div>";
        } else{
            //Validar tenga numeros
            if (!preg_match('/[0-9]/',$password)){
                $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter numérico</div>"; 
            } else {
                //Validar tenga caracter especial
                if (!preg_match('/[^a-zA-Z\d]/',$password)){
                    $validar=false;
                echo"<div class='alert alert-danger text-center'>La contraseña debe tener al menos un caracter especial</div>"; 
                }else {
                    return $validar;
                }
            }
        }
    }
}

//Funcion para crear Usuario
function crear_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,&$validar){
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='5'");
    $row=mysqli_fetch_array($sql);
    $valor_parm=$row[0];
    date_default_timezone_set("America/Tegucigalpa");
    $mifecha = date('Y-m-d');

    $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL $valor_parm DAY)"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $fecha_vencimiento=$row[0];

    $sql=$conexion->query("INSERT INTO tbl_ms_usuario (nombres, identidad, usuario, password, genero, telefono, direccion, correo, creado_por, fecha_creacion, estado,id_rol,fecha_vencimiento) value ( '$nombres', '$identidad', '$usuario', '$password','$genero','$telefono','$direccion','$correo','$usuario','$mifecha','NUEVO', 3,'$fecha_vencimiento')");

    if ($sql==1) {
        //Llenar la bitacora
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Autoregistro', 'Usuario se autoregistro','$usuario')");   
        header("location:respuestas_usuario.php");//Entra a contestar preguntas
        return $validar;
    } else {
        $validar=false;
        return $validar;
    }
}

//Validar maximo y minimo de contraseña
function Validar_Parametro_resgistrate($password,$r_password, &$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=3");
    $row=mysqli_fetch_array($sql);
    $Max_pass=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=4");
    $row1=mysqli_fetch_array($sql1);
    $Min_pass=$row1[0];

    $Longitud1=strlen($password);
    $Longitud2=strlen($r_password);
    $conta=0;

    if($Longitud1>=$Min_pass && $Longitud1<=$Max_pass){
        $conta=1;
    }
    if($Longitud2>=$Min_pass && $Longitud2<=$Max_pass){
        $conta=2;
    }

    if ($conta==2){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener mas de 5 caracteres y menor de 10</div>";
        return $validar;
    }
}

//--ver si hay espacios
function Validar_Espacio_registrate($usuario, $password, $r_password, $correo,&$validar){
    //Validar que el Usuario tenga espacio

    $Cont=0;

    if(strpos($usuario, " ")){
        echo"<div class='alert alert-danger text-center'>No se permiten espacios en el usuario</div>";
    }else{
        if (ctype_graph ($usuario)){        
            $Cont=$Cont+1;    
        }
        else{        
            echo"<div class='alert alert-danger text-center'>No se permiten espacios en el usuario</div>";            
        }
    }
    //Validar que la contraseña no tenga espacio
    if(strpos($password, " ") and strpos($r_password, " ")){
        echo"<div class='alert alert-danger text-center'>No se permiten espacios en la contraseña</div>";
    }else{
        if (ctype_graph ($password) and ctype_graph ($r_password)){        
            $Cont=$Cont+1;    
        }
        else{               
            echo"<div class='alert alert-danger text-center'>No se permiten espacios en la contraseña</div>";         
        }
    }

    if(strpos($correo, " ")){
        echo"<div class='alert alert-danger text-center'>No se permiten espacios en el correo</div>";
    }else{
        if (ctype_graph ($correo)){        
            $Cont=$Cont+1;    
        }
        else{              
            echo"<div class='alert alert-danger text-center'>No se permiten espacios en el correo</div>";        
        }
    }

    if($Cont==3){
        return $validar;
    }else{
        $validar=false;
        return $validar;
    }
}

//Enviar correo al registrarse
function Enviar_Correo($nombres,$usuario,$password,$correo,&$validar){
    require_once ("../../PHPMailer/clsMail.php");

    $mailSend = new clsMail();

    
    $titulo="Usuario Nuevo";  
    $asunto="Usuario y contraseña - Sistema de Usuarios";
    $bodyphp="Estimad@ ". $nombres.": <br/><br/> Se le ha registrado en el sistema Andre's Coffee <br/><br/>Su USUARIO es: ".$usuario." y su contraseña es: ".$password."<br/><br/> Favor abóquese con un administardor para poder ingresar al sistemas o marque al telefono (+504)8989-8366.";
    
    $enviado = $mailSend->metEnviar($titulo,$usuario,$correo,$asunto,$bodyphp);
             
    if($enviado){
        return $validar;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La direccion de correo electronico no existe o no tienes.</div>';
        return $validar;
    }
}

//Validar nombres aun no funciona
function Valida_nombre($nombres,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$nombres)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
    } else {
        //Validar tenga caracter especial
        if (preg_match('/[!"#$%&()_=?\+[]}{-@¡¿]/',$nombres)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres especiales</div>"; 
        }else {
            $Longitud1=strlen($nombres);
            if($Longitud1<=60){
                return $validar;
            }else {
                $validar=false;
                echo"<div class='alert alert-danger text-center'>Nombre muy extenso</div>"; //Campos sin uso
                return $validar;
            }
        }
    }
}
/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////

//Validacion para el registro
if (!empty($_POST["btnregistrate"])){  
        session_start();
        $_SESSION['usuario_login'] = $_REQUEST['usuario'];

        $nombres=$_POST["nombres"];
        $identidad=$_POST["identidad"];
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $r_password=$_POST["r_password"];
        $correo=$_POST["correo"];
        $genero=$_POST["genero"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];
        //Validar no hayan espacios vacios
        campo_vacio_registrate($nombres,$usuario,$password,$r_password,$identidad,$genero,$telefono,$direccion,$correo,$validar);
            if($validar==true){
                usuario_existe_registrate($usuario,$validar);
                if($validar==true){
                    Valida_nombre($nombres,$validar);
                    if($validar==true){
                        contrasenia($password,$r_password,$validar);
                        if($validar==true){
                            validar_password($password,$validar);
                            if($validar==true){
                                Validar_Parametro_resgistrate($password,$r_password,$validar);
                                if($validar==true){
                                    Validar_Espacio_registrate($usuario, $password, $r_password, $correo,$validar);
                                    if($validar==true){
                                            Enviar_Correo($nombres,$usuario,$password,$correo,$validar);
                                            if($validar==true){
                                                crear_usuario($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$validar);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } 
?>