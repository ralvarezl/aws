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
        echo"<div class='alert alert-danger text-center'>Nombre De Usuario Muy Grande</div>"; //Campos sin uso
        return $validar;
    }
}

//--ver si hay espacios
function Validar_Espacio($usuario,&$validar){
    if (ctype_graph ($usuario)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Usuario Tiene Espacio</div>";
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
        Contar_Cadena($usuario,$validar);
        if($validar==true){
            Validar_Espacio($usuario,$validar);
                if($validar==true){
                    if ($datos=$sql -> fetch_object()){ 
                         
                        require_once ("../../PHPMailer/clsMail.php");
                     
                        $mailSend = new clsMail();
                     
                        $sql=mysqli_query($conexion, "select correo from tbl_ms_usuario where usuario='$usuario'");
                        $row=mysqli_fetch_array($sql);
                        $correo=$row[0];
                        $token = Generar_token();
                        
                        $titulo="Recuperacion de Contraseña";  
                        $asunto="Recuperar Password - Sistema de Usuarios";
                        $bodyphp="Estimad@ ". $usuario.": <br/><br/> Se ha solicitado un reinicio de contraseña.<br/><br/>Por los momentos su PASSWORD es: ".$token."<br/> Para restaurar la contraseña visit@ la pagina principal y cambia tu contraseña";
                        
                        $enviado = $mailSend->metEnviar($titulo,$usuario,$correo,$asunto,$bodyphp);
                                 
                        if($enviado){
                            
                            $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario'");
                            $row=mysqli_fetch_array($sql);
                            $id_usuario=$row[0];
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha_actual=date("Y-m-d");
                            
                            $modificar=("update tbl_ms_usuario set password='$token' where id_usuario='$id_usuario'");
                            $resultado1 = mysqli_query($conexion,$modificar);
                            
                            $insertar=("insert into tbl_token (TOKEN,FECHA_VENCIMIENTO,ID_USUARIO) VALUES( '$token','$fecha_actual','$id_usuario')");
                            $resultado2 = mysqli_query($conexion,$insertar);
                            
                            $modificar1=("update tbl_ms_parametros set valor='RESET' where id_usuario='$id_usuario' and parametro='Admin_Reset'");
                            $resultado3 = mysqli_query($conexion,$modificar1);
                            
                            echo '<script language="javascript">alert("CORREO ENVIADO");;window.location.href="../../login.php"</script>';
                            
                        }else{
                            $errors[] = "La direccion de correo electronico no existe o no tienes.";
                        }
                     
                    }else{
                        echo "<div class='alert alert-danger text-center'>No Existe El Usuario</div>";
                    }
                }
        }
    }
}
    
//=================================BOTON DE RECUPERACION DE CONTRASEÑA POR MENSAJE=========================

if (!empty($_POST["btnrecuperar_mjs"])){
    $usuario=$_POST["usuario"];      
    $sql=$conexion -> query("select * from tbl_ms_usuario where usuario='$usuario'");

    
    $validar=true;
    Campo_vacio($usuario,$validar);
    if($validar==true){
        Contar_Cadena($usuario,$validar);
        if($validar==true){
            Validar_Espacio($usuario,$validar);
            if($validar==true){
                if ($datos=$sql->fetch_object()){
                    header("location:recuperacion_msj.php");//Entra al sistema de administrador.
                }else{
                    echo "<div class='alert alert-danger text-center'>No Existe El Usuario</div>";
                }
            }
        }
    }
}

?>