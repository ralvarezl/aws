<?php
//Funcion para validar campos vacios
function campo_vacio($descripcion,$precio,$fecha_inicial,$fecha_final, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["precio"] and $_POST["fecha_inicial"] and $_POST["fecha_final"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Caracteres especiales 
function Valida_descripcion($descripcion,&$validar){
    //Validar tenga numeros

    if (preg_match('/[0-9]/',$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {
        //Validar tenga caracter especial
        if (!preg_match("/^[a-zA-Z\s]*$/",$descripcion)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La nombre no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($descripcion,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permiten mas de un espacios</div>";
                $validar=false;
                return $validar;
            }else{
                return $validar;
            }
        }
    }
}

//VALIDAR QUE NO SE REPIT LA PROMOCION
function Validar_promocion($descripcion,&$validar){
    include "../../../../modelo/conexion.php";

    $sql2=mysqli_query($conexion, "select descripcion from tbl_promocion where descripcion='$descripcion'");//consultar por el nombre
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Promocion ya existente</div>";
        return $validar;  
    }
}

//NUEVA PROMOCION
function nuevo_promocion($descripcion,$precio,$fecha_inicial,$fecha_final,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_promocion (descripcion,precio,fecha_inicial,fecha_final) values ('$descripcion',$precio,'$fecha_inicial','$fecha_final')"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//MODIFICAR PRODUCTO
function modificar_producto($id_promocion,$descripcion,$precio,$fecha_inicial,$fecha_final,&$validar){
    include "../../../../modelo/conexion.php";

    //Consultar por el prodcuto
    $sql=mysqli_query($conexion, "select descripcion from tbl_promocion where id_promocion=$id_promocion");
    $row=mysqli_fetch_array($sql);
    $descripcion_base=$row[0];

    if($descripcion==$descripcion_base){
        //Actualiza si no se cambio el nombre pero si los demas campos
        $sql=$conexion->query("update tbl_promocion SET precio='$precio', fecha_inicial= '$fecha_inicial', fecha_final = '$fecha_final' WHERE id_promocion = $id_promocion ");
    }else{
        //Si modifico nombre validar que no exista en la base de datos
        $sql=$conexion->query("select descripcion from tbl_promocion where descripcion='$descripcion'");
        if ($datos=$sql->fetch_object()) {
            echo"<div align='center' class='alert alert-danger'>Promocion existente</div>";  
            $validar=false;
            return $validar;
        }else{
            $sql=$conexion->query(" update tbl_promocion SET descripcion='$descripcion', precio='$precio', fecha_inicial= '$fecha_inicial', fecha_final = '$fecha_final' WHERE id_promocion = $id_promocion "); 
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
if (!empty($_POST["btnregistrarpromocion"])) {

    include "../../../../modelo/conexion.php";
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["precio"];
    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final=$_POST["fecha_final"];

    campo_vacio($descripcion,$precio,$fecha_inicial,$fecha_final, $validar);
    if($validar==true){
        Valida_descripcion($descripcion,$validar);
        if($validar==true){
            Validar_promocion($descripcion,$validar);
            if ($validar==true) {
                nuevo_promocion($descripcion,$precio,$fecha_inicial,$fecha_final,$validar);
                //Guardar la bitacora 
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d h:i:s');
                $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nueva promocion', 'Promocion nueva','$sesion_usuario')");
                echo '<script language="javascript">alert("SE A GUARDADO LA PROMOCION CON ÉXITOS");</script>';
                header("location:administracion_promocion.php");
            }
        }
    }
}           

//Modificar promocion
if (!empty($_POST["btnactualizar_promocion"])) {

    //include "../../modelo/conexion.php";
    $validar=true;
    $id_promocion=$_POST["id_promocion"];
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["precio"];
    $fecha_inicial=$_POST["fecha_inicial"];
    $fecha_final=$_POST["fecha_final"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($descripcion,$precio,$fecha_inicial,$fecha_final, $validar);
        if ($validar==true) {
            Valida_descripcion($descripcion,$validar);
            if ($validar==true) {
                modificar_producto($id_promocion,$descripcion,$precio,$fecha_inicial,$fecha_final,$validar);
                if ($validar==true) {
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo promocion', 'Promocion actualizado','$sesion_usuario')");
                        echo '<script language="javascript">alert("SE A MODIFICADO LA PROMOCION CON ÉXITOS");</script>';
                        header("location:administracion_promocion.php");
                }
            }
        }
}
?>