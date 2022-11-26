<?php
//Funcion para validar campos vacios
function campo_vacio($id_tipo_pedido,$descripcion, &$validar){
    if (!empty($_POST["id_tipo_pedido"] and $_POST["descripcion"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR TIPO DE PEDIDO
function actualizar_tipo_pedido($id_tipo_pedido,$descripcion,$estado,&$validar){
    include "../../../../modelo/conexion.php";

    //Consultar por la descripcion
    $sql=mysqli_query($conexion, "select descripcion from tbl_tipo_pedido where id_tipo_pedido=$id_tipo_pedido");
    $row=mysqli_fetch_array($sql);
    $nombre_base=$row[0];

    if($descripcion==$nombre_base){
        //Actualiza si no se cambio la descripcion pero si los demas campos
        $sql=$conexion->query("update tbl_tipo_pedido SET ESTADO='$estado' WHERE id_tipo_pedido = $id_tipo_pedido ");
    }else{
        //Si modifico la descripcion validar que no exista en la base de datos
        $sql=$conexion->query("select descripcion from tbl_tipo_pedido where descripcion='$descripcion'");
        if ($datos=$sql->fetch_object()) {
            echo"<div align='center' class='alert alert-danger'>El tipo pedido ya existe, ingrese uno nuevo</div>";  
            $validar=false;
            return $validar;
        }else{
            $sql=$conexion->query(" update tbl_tipo_pedido SET descripcion='$descripcion', estado='$estado' WHERE id_tipo_pedido = $id_tipo_pedido "); 
            if($sql==1){
                return $validar;
            }else{
                echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
            }
        }
    }
}

//NUEVO TIPO DE PEDIDO
function nuevo_tipo_pedido($descripcion, $estado, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_tipo_pedido (descripcion, estado) values ('$descripcion','$estado') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($descripcion, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select descripcion from tbl_tipo_pedido where descripcion='$descripcion'");//consultar por el tipo de pedido
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este tipo de pedido ya existe</div>"; //Usuario no existe
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function valida_descripcion($descripcion,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($descripcion);
    if($Longitud1<=60){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Descripción muy extensa</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($descripcion, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga numeros
    if (preg_match('/[0-9]/',$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres numéricos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }
    
    if(!strpos($descripcion, "=") && !strpos($descripcion, '""') or !strpos($descripcion, '"')){
        $cont=5;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La descripción no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==5){
        return $validar;    
    }
}

//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo pedido
if (!empty($_POST["btntipopedido"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $descripcion=$_POST["descripcion"];
    $estado=$_POST["estado"];
    if($descripcion==''){
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        $validar=false;
    }

    if ($validar==true) {
        validar_existe($descripcion, $validar);
        if($validar==true){
            valida_descripcion($descripcion,$validar);
            if($validar==true){
                nuevo_tipo_pedido($descripcion,$estado,$validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Tipo de Pedido', 'Creo tipo de pedido $descripcion','$sesion_usuario')");
                    header("location:administracion_tipo_pedido.php");
                }
            }  
        }
    }
}

//ACTUALIZAR EL TIPO DE PEDIDO
if (!empty($_POST["btnactualizartipopedido"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_tipo_pedido=$_POST["id_tipo_pedido"];
    $descripcion=$_POST["descripcion"];
    $estado=$_POST["estado"];
    campo_vacio($id_tipo_pedido,$descripcion, $validar);
        if ($validar==true) {
            valida_descripcion($descripcion,$validar);
            if($validar==true){
                actualizar_tipo_pedido($id_tipo_pedido,$descripcion,$estado, $validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar Tipo de Pedido', 'Actualizo tipo de pedido','$sesion_usuario')");
                    header("location:administracion_tipo_pedido.php");
                    }
                }
                
            } 
        }

?>