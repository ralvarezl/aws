<?php
//Funcion para validar campos vacios
function campo_vacio($nombres,$apellidos,$identidad,$genero,$telefono,&$validar){
    if (!empty($_POST["nombres"] and $_POST["apellidos"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//NUEVO CLIENTE
function nuevo_cliente($nombres,$apellidos,$identidad,$genero,$telefono,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_cliente (nombres,apellidos,identidad,genero,telefono) values ('$nombres','$apellidos',$identidad,'$genero',$telefono)"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//MODIFICAR CLIENTE
function modificar_cliente($id_cliente,$nombres,$apellidos,$identidad,$genero,$telefono,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" update tbl_cliente SET nombres='$nombres', apellidos='$apellidos', identidad= $identidad, genero = '$genero', telefono= $telefono WHERE id_cliente = $id_cliente "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo pedido
if (!empty($_POST["btnregistrarcliente"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $nombres=$_POST["nombre"];
    $apellidos=$_POST["apellidos"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];

    campo_vacio($nombres,$apellidos,$identidad,$genero,$telefono,$validar);
    if($validar==true){
        nuevo_cliente($nombres,$apellidos,$identidad,$genero,$telefono,$validar);
        if ($validar==true) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nuevo cliente', 'Cliente nuevo','$sesion_usuario')");
            echo '<script language="javascript">alert("SE A GUARDADO EL CLIENTE CON ÉXITOS");</script>';
            header("location:administracion_cliente.php");
        }
    }           
}

//Modificar pedido
if (!empty($_POST["btnactualizarcliente"])) {

    //include "../../modelo/conexion.php";
    $validar=true;
    $id_cliente=$_POST["id_cliente"];
    $nombres=$_POST["nombres"];
    $apellidos=$_POST["apellidos"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];

    campo_vacio($nombres,$apellidos,$identidad,$genero,$telefono,$validar);
    if($validar==true){
        modificar_cliente($id_cliente,$nombres,$apellidos,$identidad,$genero,$telefono,$validar);
        if ($validar==true) {
            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo cliente', 'Cliente actualizado','$sesion_usuario')");
            echo '<script language="javascript">alert("SE A MODIFICADO EL CLIENTE CON ÉXITOS");</script>';
            header("location:administracion_cliente.php");
        }
    }
}

?>