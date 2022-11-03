<?php


/*++++++++++++++++++++++++++++++++++++++++FUNCIONES DE RECUPERACION+++++++++++++++++++++++++++++++++++*/


//--validacion que no existan campos vacios
function Campo_vacio($usuario,&$validar){
    if (!empty($_POST["usuario"]) and $validar=true) {    //Campos en uso
        return $validar; 
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor ingrese su usuario</div>"; //Campos sin uso
        return $validar;
    }
}

//--Generar un Token
function Generar_token (){
    $leng=10;
    $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_!?+-^.,=";
    $token = "" ;

    for ( $i=0; $i<$leng; $i++ ) {
        $token.= $cadena[rand(0,70)];
    }

    return $token;
}

//--Contar la Cadena
function Contar_Cadena($usuario,&$validar){
    
    $Longitud=strlen($usuario);
    if($Longitud<=20){
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Nombre de usuario muy grande</div>"; //Campos sin uso
        return $validar;
    }
}

//--ver si hay espacios
function Validar_Espacio($usuario,&$validar){
    if (ctype_graph ($usuario)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario tiene espacio</div>";
        return $validar;
    }
}


function estado_inactivo_password($usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select estado from tbl_ms_usuario where usuario='$usuario'"); //preguntar el estado del usuario
    $row=mysqli_fetch_array($sql);
    $estado=$row[0]; //Guardamos el estado
    if ($estado=='INACTIVO' or $estado=='NUEVO') { //si es INACTIVO
        $validar=false;
        $estados= strtolower($estado);
        echo"<div class='alert alert-danger text-center'>Usuario $estados, no puede recuperar contraseña</div>";
        return $validar;
    }else {
        return $validar;
    }
}
//Funcion para validar que existe el usuario
function usuario_existe_login($usuario,&$validar){
    include "../../modelo/conexion.php";
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario no existe</div>"; //Usuario no existe
        return $validar;
    }
}
//No permitir al admin cambiar contraseña
function admin_no($usuario, &$validar){
    include "../../modelo/conexion.php";
    $sql_id=$conexion -> query("select id_usuario from tbl_ms_usuario where usuario='$usuario'");
    $row_id=mysqli_fetch_array($sql_id);
    $id=$row_id[0];
    if($id==1){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No permitido</div>"; 
        return $validar;
    }else{
        return $validar;
    }
}
//=================================BOTON DE RECUPERACION DE CONTRASEÑA POR EMAIL=========================

if (!empty($_POST["btnrecuperar"])){
    
    $errors = array();
    $validar=true;
    $usuario=$_POST["usuario"];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");
    
    Campo_vacio($usuario,$validar);
    if($validar==true){
        Validar_Espacio($usuario,$validar);
        if($validar==true){
            usuario_existe_login($usuario,$validar);
            if($validar==true){
                admin_no($usuario, $validar);
                if($validar==true){
                    Contar_Cadena($usuario,$validar);
                    if($validar==true){
                        estado_inactivo_password($usuario,$validar);
                        if($validar==true){
                            if ($datos=$sql -> fetch_object()){ 
                                    
                                require_once ("../../PHPMailer/clsMail.php");
                                
                                $mailSend = new clsMail();
                                
                                $sql=mysqli_query($conexion, "select correo from tbl_ms_usuario where usuario='$usuario'");
                                $row=mysqli_fetch_array($sql);
                                $correo=$row[0];
                                $token = Generar_token();
    
                                $titulo="Recuperacion de Contraseña";  
                                $asunto="Solicitud de restablecimiento de contraseña";
                                $bodyphp="<div class='form-container'><form>Estimado/a <b>". $usuario.".</b> <br/><br/> <b>Ha solicitado un reinicio de contraseña.</b><br/><br/><br/> Por los momentos su contraseña es: <b>".$token."</b><br/> Para restaurar la contraseña visit@ la pagina principal y cambia tu contraseña.<br/></br><br/><br/> <div align='center'><h1>Andress Coffiee</h1><h4>La Paz, La Paz, Honduras</h4></div></form></div>";
                                    
                                $enviado = $mailSend->metEnviar($titulo,$usuario,$correo,$asunto,$bodyphp);
                                            
                                if($enviado){
                                        
                                    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
                                    $row=mysqli_fetch_array($sql);
                                    $id_usuario=$row[0];
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha_tiempo=date('Y-m-d h:i:s');
                                        
                                        include "../../modelo/conexion.php";
                                        //Modificamos la contraseña y estado en la tabla TBL_MS_USUARIO
                                        $modificar=("update tbl_ms_usuario set password='$token', estado='DEFAULT' where id_usuario='$id_usuario'");
                                        $resultado = mysqli_query($conexion,$modificar);
    
                                    //crear evento de la contraseña
                                    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=10");
                                    $row=mysqli_fetch_array($sql);
                                    $valor=$row[0];
                                    $fecha_actual = strtotime ( '+'.$valor.' hour' , strtotime ($fecha_tiempo) ) ; 
                                    $fecha_actual = date ( 'Y-m-d H:i:s' , $fecha_actual);     
                                    $insertar=("insert into tbl_ms_token (TOKEN,FECHA_VENCIMIENTO,ID_USUARIO) VALUES( '$token','$fecha_actual','$id_usuario')");
                                    $resultado2 = mysqli_query($conexion,$insertar);
                                    
                                    //Borrar si ya existe uno anteriormente
                                    $sql=$conexion->query("DROP EVENT IF EXISTS ".$id_usuario."A");
     
                                    //crear el evento para el token
                                    $sql_evento=$conexion->query("CREATE EVENT IF NOT EXISTS ".$id_usuario."A
                                    ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL $valor HOUR
                                    DO
                                    UPDATE tbl_ms_usuario  SET password = '' where id_usuario=$id_usuario and usuario='$usuario'");
                                    
                                    //Llenar la bitacora
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha = date('Y-m-d h:i:s');
                                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Recuperar contraseña', 'Usuario entro a recuperar contraseña via correo','$usuario')");    
                                    echo '<script language="javascript">alert("CORREO ENVIADO");;window.location.href="../../login.php"</script>';
                                        
                                }else{
                                    $errors[] = "La direccion de correo electronico no existe o no tienes.";
                                }
                                
                            }else{
                                echo "<div class='alert alert-danger text-center'>No existe el usuario</div>";
                            }
                        }
                    }
                }
                
            }
        }
    }
}
    
//=================================BOTON DE RECUPERACION DE CONTRASEÑA POR MENSAJE=========================

if (!empty($_POST["btnrecuperar_mjs"])){
    session_start();
    $_SESSION['usuario_msj'] = $_REQUEST['usuario'];

    $usuario=$_POST["usuario"];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");
    $validar=true;
    Campo_vacio($usuario,$validar);
    if($validar==true){
        Validar_Espacio($usuario,$validar);
        if($validar==true){
            usuario_existe_login($usuario,$validar);
            if($validar==true){
                admin_no($usuario, $validar);
                if($validar==true){
                    Contar_Cadena($usuario,$validar);
                    if($validar==true){
                        estado_inactivo_password($usuario,$validar);
                        if($validar==true){
                            if ($datos=$sql->fetch_object()){
                                //Llenar la bitacora
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha = date('Y-m-d h:i:s');
                                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Recuperar contraseña', 'Usuario entro a recuperar contraseña via pregunta secreta','$usuario')");
                                header("location:recuperacion_msj.php");//Entra a recuperar contraseña.
                            }else{
                                echo "<div class='alert alert-danger text-center'>No existe el usuario</div>";
                            }
                        }
                    }
                }
                
            }
        }
    }
}

?>