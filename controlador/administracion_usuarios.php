<?php

//Funcion para validar campos vacios
function campo_vacio($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"] and $_POST["id_rol"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar campos vacios en actualizar
function campo_vacio_actualizar($nombres,$usuario,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $_POST["direccion"] and $_POST["correo"] and $_POST["estado"] and $_POST["id_rol"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que el usuario no exista
function usuario_existe($usuario,&$validar){
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

//Funcion para insertar los registros 
function usuario_crear($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$sesion_usuario,$id_rol,&$validar){
    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='5'");
    $row=mysqli_fetch_array($sql);
    $valor_parm=$row[0];
    date_default_timezone_set("America/Tegucigalpa");
                $mifecha = date('Y-m-d');
                $sql=mysqli_query($conexion, "SELECT DATE_ADD(NOW(), INTERVAL $valor_parm DAY)"); //Fecha de Vencimiento
                $row=mysqli_fetch_array($sql);
                $fecha_vencimiento=$row[0];
                //Envio de los datos a ingresar por la query
                $sql=$conexion->query("insert into tbl_ms_usuario (nombres, usuario, password, identidad, genero, telefono, direccion, correo, estado, creado_por, id_rol, fecha_creacion, fecha_vencimiento) values ('$nombres', '$usuario', '$password', '$identidad', '$genero' , '$telefono', '$direccion', '$correo' , 'NUEVO' , '$sesion_usuario' , '$id_rol' , '$mifecha','$fecha_vencimiento')");
                if ($sql==1) {
                        //Crear el evento FECHA DE VENCIMIENTO
                        $sql_evento=$conexion->query("CREATE EVENT IF NOT EXISTS $usuario
                        ON SCHEDULE AT DATE_ADD(NOW(), INTERVAL $valor_parm DAY)
                        DO
                        UPDATE tbl_ms_usuario  SET estado = 'BLOQUEADO' where  usuario='$usuario'");
                    return $validar;
                } else {
                    $validar=false;
                    return $validar;
                }
}

//Funcion para saber si cambio el usuario 
function usuario_modificado($usuario,$nombres,$identidad,$genero,$telefono,$direccion,$correo,$estado,$sesion_usuario,$id_rol,$id_usuario,&$validar){
    include "../../modelo/conexion.php";
    
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario' and id_usuario=$id_usuario");//consultar por el usuario
    if ($datos=$sql->fetch_object()) { //si existe
        date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        include "../../modelo/conexion.php";
        //Actualiza si no se cambio el usuario ni correo pero si los demas campos
        $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', identidad='$identidad', genero='$genero', telefono='$telefono', direccion='$direccion', estado='$estado', modificado_por='$sesion_usuario' , id_rol='$id_rol', fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        if ($sql==1) {
            //Guardar en bitacora
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar', 'Administrador modifico datos de usuario','$sesion_usuario')");
            header("location:administracion_usuarios.php");
            //echo '<div class="alert alert-success">Usuario actualizado correctamente</div>';//Usuario ingresado
        } else {
            echo '<div class="alert alert-danger text-center">Error al actualizar el usuario</div>';//Error al ingresar usuario
        }
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para actualizar con usuario
function actualizar_usuario($nombres,$usuario,$identidad,$genero,$telefono,$direccion,$correo,$estado,$sesion_usuario,$id_rol,$id_usuario,&$validar){
    
    date_default_timezone_set("America/Tegucigalpa");
        $mifecha = date('Y-m-d');
        include "../../modelo/conexion.php";

        $sql2=mysqli_query($conexion, "select correo from tbl_ms_usuario where correo='$correo'");//consultar por correos
        $row2=mysqli_fetch_array($sql2);
    
        if(is_null($row2)){
            //Envio de los datos a ingresar por la query
            $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', usuario='$usuario', identidad='$identidad', genero='$genero', telefono='$telefono', direccion='$direccion', correo='$correo', estado='$estado', modificado_por='$sesion_usuario' , id_rol='$id_rol', fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        
            if ($sql==1) {
                //Guardar en bitacora
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar', 'Administrador modifico datos de usuario','$sesion_usuario')");
                //header("location:administracion_usuarios.php");
                //echo '<div class="alert alert-success">Usuario actualizado correctamente</div>';//Usuario ingresado
                return $validar;
            } else {
                $validar=false;
                echo '<div class="alert alert-danger text-center">Error al actualizar el usuario</div>';//Error al ingresar usuario
                return $validar;
            }
        }else{
            $validar=false;
            echo '<div class="alert alert-danger text-center">Correo ya existente</div>';//Error al cambiar correo
            return $validar;
        }
}
//Funcion para enviar el correo.
function Enviar_Correo($nombres,$usuario,$password,$correo,&$validar){
    require_once ("../../PHPMailer/clsMail.php");
    include "../../modelo/conexion.php";

    $mailSend = new clsMail();
    
    $titulo="Usuario Nuevo";  
    $asunto="Usuario y contraseña - Sistema de Usuarios";
    $bodyphp="<div class='form-container'><form>Estimado/a <b>". $usuario.".</b> <br/><br/> <b>Se le a registrado en el sistema Andre's Coffee.</b><br/><br/><br/>Su usuario es: ".$usuario." y su contraseña temporal es: ".$password."</b><br/>Favor ingrese al sistema para hacer el cambio de su contraseña y configurar su usuario.<br/></br><br/><br/> <div align='center'><h1>Andress Coffiee</h1><h4>La Paz, La Paz, Honduras</h4></div></form></div>";
    
    $enviado = $mailSend->metEnviar($titulo,$usuario,$correo,$asunto,$bodyphp);
             
    if($enviado){
        return $validar;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La direccion de correo electronico no existe o no tienes.</div>';
        return $validar;
    }
}

//--ver si hay espacios registro usuario
function Validar_Espacio_admin($usuario, $password, $correo, &$validar){
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
    if(strpos($password, " ")){
        echo"<div class='alert alert-danger text-center'>No se permiten espacios en la contraseña</div>";
    }else{
        if (ctype_graph ($password)){        
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

//--ver si hay espacios actualizar usuario
function Validar_Espacio_admin_actualizar($usuario, $correo, &$validar){
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

    if($Cont==2){
        return $validar;
    }else{
        $validar=false;
        return $validar;
    }
}
//Ancho y largo de contraseña
function Validar_Parametro_adm($password, &$validar){

    include "../../modelo/conexion.php";
    $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=3");
    $row=mysqli_fetch_array($sql);
    $Max_pass=$row[0];

    $sql1=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro=4");
    $row1=mysqli_fetch_array($sql1);
    $Min_pass=$row1[0];

    $Longitud1=strlen($password);
    $conta=0;

    if($Longitud1>=$Min_pass && $Longitud1<=$Max_pass){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La contraseña debe tener mas de ".$Min_pass." caracteres y menor de ".$Max_pass."</div>";
        return $validar;
    }
}
//Caracteres especiales 
function Valida_nombre($nombres,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$nombres)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
    } else {
        //Validar tenga caracter especial
        if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$nombres) && preg_match('/[!"#$"%&()""_=?\+[]}{-@¡¿]/',$nombres)){
            $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres especiales</div>"; 
        }else {
            if(strpos($nombres,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permiten mas de un espacios</div>";
                $validar=false;
                return $validar;
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
}
//validar extension de identidad y telefono
function Validar_id_tel_admin($identidad,$telefono, &$validar){

    $Longitud1=strlen($identidad);
    $Longitud2=strlen($telefono);
    $conta=0;

    if($Longitud1>=13 && $Longitud1<=13){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La identidad debe tener 13 caracteres numericos</div>";
        return $validar;
    }
    if($Longitud2>=8 && $Longitud2<=8){
        $conta=2;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El telefono debe tener 8 caracteres numericos</div>";
        return $validar;
    }

    if ($conta==2){
        return $validar;
    }
}
//Correo no se repita
function Validar_correo($correo,&$validar){
    include "../../modelo/conexion.php";

    $sql2=mysqli_query($conexion, "select correo from tbl_ms_usuario where correo='$correo'");//consultar por correos
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Correo ya existente</div>";
        return $validar;  
    }
}
//Funcion Validar contraseña sea correta
function contrasenia($password,$r_password,&$validar){
    if($password===$r_password){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-warning text-center'>Ambas contraseñas deben ser iguales</div>";//CONTRASEÑAS DISTINTAS
        return $validar;
    }

}
/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////

//Crear Nuevo Usuario Al Presionar Boton
if (!empty($_POST["btnregistrar"])) {
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];
    $nombres=$_POST["nombres"];
    $usuario=$_POST["usuario"];
    $password=$_POST["password"];
    $r_password=$_POST["r_password"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];
    $direccion=$_POST["direccion"];
    $correo=$_POST["correo"];
    $id_rol=$_POST["id_rol"];
    //Validar que no hayan campos vacios
    campo_vacio($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$id_rol,$validar);
        if($validar==true){
            usuario_existe($usuario,$validar);
            if($validar==true){
                Valida_nombre($nombres,$validar);
                if($validar==true){
                    Validar_Espacio_admin($usuario, $password, $correo, $validar);
                    if($validar==true){
                        Validar_Parametro_adm($password,$validar);
                        if($validar==true){
                            Validar_id_tel_admin($identidad,$telefono, $validar);
                            if($validar==true){
                                Validar_correo($correo,$validar);
                                if($validar==true){
                                    contrasenia($password,$r_password,$validar);
                                        if($validar==true){
                                            Enviar_Correo($nombres,$usuario,$password,$correo,$validar);
                                            if($validar==true){
                                                usuario_crear($nombres,$usuario,$password,$identidad,$genero,$telefono,$direccion,$correo,$sesion_usuario,$id_rol,$validar);
                                                if($validar==true){
                                                    //Guardar en bitacora 
                                                    date_default_timezone_set("America/Tegucigalpa");
                                                    $fecha = date('Y-m-d h:i:s');
                                                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Crear usuario', 'Administrador creo un usuario nuevo','$sesion_usuario')");
                                                    //Mensaje de confirmacion
                                                    echo '<script language="javascript">alert("Usuario registrado exitosamente");;window.location.href="administracion_usuarios.php"</script>';//Usuario ingresado 
                                                }else{
                                                    echo '<div class="alert alert-danger text-center">Error al registrar usuario</div>';//Error al ingresar usuario
                                                }
                                            }
                                        }
                                }  
                            }
                        }
                    }
                }
            }
        }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//AL presionar el boton actualizar
if (!empty($_POST["btnactualizar"])) {
        $validar=true;
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_usuario=$_POST["id_usuario"];
        $nombres=$_POST["nombres"];
        $usuario=$_POST["usuario"];
        $identidad=$_POST["identidad"];
        $genero=$_POST["genero"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];
        $correo=$_POST["correo"];
        $estado=$_POST["estado"];
        $id_rol=$_POST["id_rol"];

        //Validar que no hayan campos vacios
        campo_vacio_actualizar($nombres,$usuario,$identidad,$genero,$telefono,$direccion,$correo,$estado,$id_rol,$validar);
        if($validar==true){
            Validar_Espacio_admin_actualizar($usuario, $correo, $validar);
            if($validar==true){
                usuario_modificado($usuario,$nombres,$identidad,$genero,$telefono,$direccion,$correo,$estado,$sesion_usuario,$id_rol,$id_usuario,$validar);
                if($validar==true){
                    usuario_existe($usuario,$validar);
                    if($validar==true){
                        Validar_correo($correo,$validar);
                        if($validar==true){
                            actualizar_usuario($nombres,$usuario,$identidad,$genero,$telefono,$direccion,$correo,$estado,$sesion_usuario,$id_rol,$id_usuario,$validar);
                            if($validar==true){
                                echo '<script language="javascript">alert("Usuario actualizado correctamente");;window.location.href="administracion_usuarios.php"</script>';
                            }
                        }
                    }
                }
            }
        }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////

?>