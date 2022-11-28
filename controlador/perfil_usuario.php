<?php
//Funcion para validar campos vacios
function campo_vacio($nombres,$usuario,$password,$identidad,$telefono,&$validar){
    if (!empty($_POST["nombres"] and $_POST["usuario"] and $_POST["password"] and $_POST["identidad"] and $_POST["telefono"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para saber si cambio el usuario 
function usuario_modificado($usuario,$nombres,$identidad,$telefono,$password,$id_usuario,&$validar){
    include "../../modelo/conexion.php";
    date_default_timezone_set("America/Tegucigalpa");
    $mifecha = date('Y-m-d');
    //Consultar si cambio su usuario
    $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario' and id_usuario=$id_usuario");//consultar por el usuario
    //si es el mismo  
    if ($datos=$sql->fetch_object()) {
        //Consultar por el correo
        $sql=mysqli_query($conexion, "select identidad from tbl_ms_usuario where usuario='$usuario' and id_usuario=$id_usuario");
        $row=mysqli_fetch_array($sql);
        $identidad_base=$row[0];

        if($identidad==$identidad_base){
            //Actualiza si no se cambio el usuario ni identidad pero si los demas campos
            $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', password='$password', telefono='$telefono', modificado_por='$usuario' , fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
        }else{
            //Si modifico identidad validar que no exista en la base de datos
            $sql=$conexion->query("select identidad from tbl_ms_usuario where identidad='$identidad'");
            if ($datos=$sql->fetch_object()) {
                echo"<div align='center' class='alert alert-danger' >Identidad Existente</div>";  
                $validar=false;
                return $validar;
            }else{
               //Actualiza si no se cambio el usuario 
            $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', identidad='$identidad', password='$password', telefono='$telefono', modificado_por='$usuario' ,fecha_modificacion='$mifecha' where id_usuario = $id_usuario "); 
            }
    
        }
    }else{
        //Consultar si existe ya un usuario con ese nombre
        $sql=$conexion->query("select usuario from tbl_ms_usuario where usuario='$usuario'");//consultar por el usuario
        //si existe, llenar sin usuario   
        if ($datos=$sql->fetch_object()) {
            echo"<div align='center' class='alert alert-danger' >Usuario Existente</div>";     
            $validar=false;
            return $validar;            
        }else{
            //Consultar por el identidad
            $sql1=mysqli_query($conexion, "select identidad from tbl_ms_usuario where id_usuario=$id_usuario");
            $row1=mysqli_fetch_array($sql1);
            $identidad_base=$row1[0];
            if($identidad==$identidad_base){
                //Actualiza si  se cambio el usuario y no identidad pero si los demas campos
                $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', usuario='$usuario' ,password='$password', identidad='$identidad', telefono='$telefono',  modificado_por='$usuario' , fecha_modificacion='$mifecha' where id_usuario = $id_usuario ");
            }else{
                //Si modifico identidad validar que no exista en la base de datos
                $sql=$conexion->query("select identidad from tbl_ms_usuario where identidad='$identidad'");
                if ($datos=$sql->fetch_object()) {
                    echo"<div align='center' class='alert alert-danger' >Identidad Existente</div>";  
                    $validar=false;
                    return $validar;
                }else{
                   //Actualiza si no se cambio el usuario 
                $sql=$conexion->query(" update tbl_ms_usuario set nombres='$nombres', usuario='$usuario', password='$password',identidad='$identidad', telefono='$telefono', modificado_por='$usuario' , fecha_modificacion='$mifecha' where id_usuario = $id_usuario "); 
                }
        
            }
        }
        
    }
}

//Funcion para actualizar preguntas
function actualizar_respuesta($id_usuario,$pregunta,$respuesta,$usuario,&$validar){
    include "../../modelo/conexion.php";
    date_default_timezone_set("America/Tegucigalpa");
    $mifecha = date('Y-m-d');
    $sql=$conexion->query(" update tbl_ms_preguntas_usuario set respuesta='$respuesta' where id_usuario = $id_usuario and id_pregunta=$pregunta");
    if ($sql==1) {
        //Guardar en bitacora
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d h:i:s');
        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Editar datos de perfil', '$usuario modifico sus datos de perfil','$usuario')");
        echo '<script language="javascript">alert("Usuario actualizó datos correctamente");;window.location.href="perfil_usuario.php"</script>';
    } else {
        echo '<div class="alert alert-danger text-center">Error al actualizar datos del usuario</div>';//Error al ingresar usuario
    }

}
/////////////////////////////////////////***FIN FUNCIONES***/////////////////////////////////////////////////////


//AL presionar el boton actualizar
if (!empty($_POST["perfil"])) {
    $id_usuario=$_POST["id_usuario"];
    $usuario=$_POST["usuario"];
    $nombres=$_POST["nombres"];
    $password=$_POST["password"];
    $identidad=$_POST["identidad"];
    $telefono=$_POST["telefono"];
    $pregunta=$_POST["pregunta"];
    $respuesta=$_POST["respuesta"];
    
    campo_vacio($nombres,$usuario,$password,$identidad,$telefono,$validar);
    if($validar=true){
        usuario_modificado($usuario,$nombres,$identidad,$telefono,$password,$id_usuario,$validar);
        if($validar=true){
            actualizar_respuesta($id_usuario,$pregunta,$respuesta,$usuario,$validar);
            $_SESSION["usuario_login"]=$usuario;
        }
    }
    
    
}

?>