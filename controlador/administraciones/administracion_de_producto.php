<?php

//Funcion para validar campos vacios
function campo_vacio($nombre,$tipo, $precio, &$validar){
    if (!empty($_POST["nombre"] and $_POST["tipo"] and $_POST["precio"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger'>Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

function limite_cantidad_precio($precio, &$validar){

    $Longitud2=strlen($precio);
    $conta=0;

    if($Longitud2<=4){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El precio no debe de exceder los 4 digitos</div>";
        return $validar;
    }

    if ($conta==1){
        return $validar;
    }
}

//Caracteres especiales 
function Valida_nombre($nombre,&$validar){
    //Validar tenga numeros

    if (preg_match('/[0-9]/',$nombre)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {
        //Validar tenga caracter especial
        if (!preg_match("/^[a-zA-Z\s]*$/",$nombre)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($nombre,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
                $validar=false;
                return $validar;
            }else{
                return $validar;
            }
        }
    }
}

//Caracteres especiales 
function Valida_tipo($tipo,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$tipo)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El tipo de producto no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {
        //Validar tenga caracter especial
        if (!preg_match("/^[a-zA-Z\s]*$/",$tipo)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>El tipo de producto no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($tipo,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
                $validar=false;
                return $validar;
            }else{
                return $validar;
            }
        }
    }
}



//VALIDAR QUE NO SE REPIT EL PRODUCTO
function Validar_producto($nombre,&$validar){
    include "../../../../modelo/conexion.php";

    $sql2=mysqli_query($conexion, "select nombre from tbl_producto where nombre='$nombre'");//consultar por el nombre
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El producto ya existe, ingrese uno nuevo</div>";
        return $validar;  
    }
}

//NUEVO PRODUCTO
function nuevo_producto($nombre,$tipo,$precio,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_producto (nombre,tipo,precio, estado) values ('$nombre','$tipo',$precio, 'ACTIVO')"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger'>Error al actualizar</div>";
    }
}

//MODIFICAR PRODUCTO
function modificar_producto($id_producto,$nombre,$tipo,$precio,&$validar){
    include "../../../../modelo/conexion.php";

    //Consultar por el prodcuto
    $sql=mysqli_query($conexion, "select nombre from tbl_producto where id_producto=$id_producto");
    $row=mysqli_fetch_array($sql);
    $nombre_base=$row[0];

    if($nombre==$nombre_base){
        //Actualiza si no se cambio el nombre pero si los demas campos
        $sql=$conexion->query("update tbl_producto SET TIPO='$tipo', PRECIO = '$precio' WHERE id_producto = $id_producto ");
    }else{
        //Si modifico nombre validar que no exista en la base de datos
        $sql=$conexion->query("select nombre from tbl_producto where nombre='$nombre'");
        if ($datos=$sql->fetch_object()) {
            echo"<div align='center' class='alert alert-danger'>El producto ya existe, ingrese uno nuevo</div>";  
            $validar=false;
            return $validar;
        }else{
            $sql=$conexion->query(" update tbl_producto SET NOMBRE='$nombre', TIPO='$tipo', PRECIO = '$precio' WHERE id_producto = $id_producto "); 
            if($sql==1){
                return $validar;
            }else{
                echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
            }
        }
    }
}

//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo pedido
if (!empty($_POST["btnregistrarproducto"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=false;
    $nombre=$_POST["nombre"];
    $tipo=$_POST["tipo"];    
    $precio=$_POST["precio"];

    campo_vacio($nombre,$tipo,$precio,$validar);
    if($validar==true){
        Valida_nombre($nombre,$validar);
        if($validar==true){
            Valida_tipo($tipo,$validar);
            if($validar==true){
                limite_cantidad_precio($precio, $validar);
                if ($validar==true) { 
                    Validar_producto($nombre,$validar);
                    if ($validar==true) {
                        nuevo_producto($nombre,$tipo,$precio,$validar);
                        if ($validar==true) {
                            //Guardar la bitacora 
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date('Y-m-d h:i:s');
                            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nuevo producto', 'Producto nuevo','$sesion_usuario')");
                            echo '<script language="javascript">alert("SE A GUARDADO EL PRODUCTO CON ÉXITOS");</script>';
                            header("location:administracion_producto.php");
                        }
                    }
                }
            }
        }
    }           
}

//Modificar pedido
if (!empty($_POST["btnactualizarproducto"])) {

    //include "../../modelo/conexion.php";
    $validar=true;
    $id_producto=$_POST["id_producto"];
    $nombre=$_POST["nombre"];
    $tipo=$_POST["tipo"];
    $precio=$_POST["precio"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($nombre,$tipo,$precio,$validar);
    if($validar==true){
        Valida_nombre($nombre,$validar);
        if($validar==true){
            Valida_tipo($tipo,$validar);
            if ($validar==true) {
                limite_cantidad_precio($precio, $validar);
                if ($validar==true) { 
                    modificar_producto($id_producto,$nombre,$tipo,$precio,$validar);
                    if ($validar==true) {
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo producto', 'Producto actualizado','$sesion_usuario')");
                        echo '<script language="javascript">alert("SE A MODIFICADO EL PRODUCTO CON ÉXITOS");</script>';
                        header("location:administracion_producto.php");
                    }
                    
                }
            }
        }
    }
        
}
?>