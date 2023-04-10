<?php
//Funcion para validar campos vacios
function campo_vacio($descripcion,$precio, &$validar){
    if (!empty($_POST["descripcion"] and $_POST["precio"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger'>Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

function limite_descripcion_precio($descripcion, $precio, &$validar){

    $Longitud1=strlen($descripcion);
    $Longitud2=strlen($precio);
    $conta=0;

    if($Longitud1<=100){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción es muy extensa</div>";
        return $validar;
    }


    if($Longitud2<=4){
        $conta=2;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El precio no debe de exceder los 4 digitos</div>";
        return $validar;
    }
    
    if ($conta==2){
        return $validar;
    }
}

//Caracteres especiales 
function Valida_descripcion($descripcion,&$validar){
    //Validar tenga numeros

    if (preg_match('/[0-9]/',$descripcion)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {
        //Validar tenga caracter especial
        if (!preg_match("/^[a-zA-Z\s]*$/",$descripcion)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($descripcion,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
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
        echo"<div class='alert alert-danger text-center'>La promoción ya existe, ingrese una nueva</div>";
        return $validar;  
    }
}

//NUEVA PROMOCION
function nuevo_promocion($descripcion,$precio,$fecha_inicial,$fecha_final,&$validar){
    include "../../../../modelo/conexion.php";
     
    $sql=$conexion->query(" insert into tbl_promocion (descripcion,precio,fecha_inicial,fecha_final,estado) 
                                values ('$descripcion',$precio,'$fecha_inicial','$fecha_final','ACTIVO')"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger'>Error al actualizar</div>";
    }
}

//MODIFICAR PRODUCTO
function modificar_promocion($id_promocion,$descripcion,$precio,&$validar){
    include "../../../../modelo/conexion.php";

    //Consultar por el prodcuto
    $sql=mysqli_query($conexion, "select descripcion from tbl_promocion where id_promocion=$id_promocion");
    $row=mysqli_fetch_array($sql);
    $descripcion_base=$row[0];

    if($descripcion==$descripcion_base){
        //Actualiza si no se cambio el nombre pero si los demas campos
        $sql=$conexion->query("update tbl_promocion SET precio=$precio WHERE id_promocion = $id_promocion ");
    }else{
        //Si modifico nombre validar que no exista en la base de datos
        $sql=$conexion->query("select descripcion from tbl_promocion where descripcion='$descripcion'");
        if ($datos=$sql->fetch_object()) {
            echo"<div align='center' class='alert alert-danger'>La promoción ya existe, ingrese una nueva</div>";  
            $validar=false;
            return $validar;
        }else{
            $sql=$conexion->query(" update tbl_promocion SET descripcion='$descripcion', precio=$precio WHERE id_promocion = $id_promocion "); 
            if($sql==1){
                return $validar;
            }else{
                echo"<div align='center' class='alert alert-danger'>Error al actualizar</div>";
            }
        }
    }
}



//Ingresar nuevo pedido

//Funcion para validar campos vacios
function campo_vacio_nuevo($descripcion,$fecha_final,$precio,&$validar){
    if (!empty($_POST["descripcion"] and $_POST["fecha_final"] and $_POST["Precio"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger'>Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para llenar la tabla promocion producto
function Llenar_prom_prod($descripcion,$precio,&$validar){
    
    include "../../../../modelo/conexion.php";
    $id_user=2;

    $id_maximo = mysqli_query($conexion, "SELECT id_promocion from tbl_promocion where precio='$precio' and descripcion='$descripcion'");
    $resultId = mysqli_fetch_assoc($id_maximo);
    $ultimoId = $resultId['id_promocion'];

    $consulta = mysqli_query($conexion, "SELECT id, id_usuario, id_producto, cantidad, precio_venta, total FROM tbl_detalle_temp WHERE id_usuario = $id_user");
        while($row = mysqli_fetch_assoc($consulta)){
            $id_producto = $row['id_producto'];
            $precio = $row['precio_venta'];
            $cantidad = $row['cantidad'];

            $insertarDet = mysqli_query($conexion, "INSERT INTO tbl_promocion_producto(cantidad, precio, id_promocion, id_producto, estado) VALUES ($cantidad,'$precio',$ultimoId,$id_producto,'ACTIVO')");
        }

        if($insertarDet){
            $eliminar2 = mysqli_query($conexion, "DELETE FROM tbl_detalle_temp WHERE id_usuario = $id_user");
            return $validar=true;
        }else{
            $validar=false;
            echo"<div align='center' class='alert alert-danger'>No se han guardado todos los productos</div>"; //Campos vacios
            return $validar;

        }

}

//-----------------------FIN FUNCIONES-------------------------------------

if (!empty($_POST["btnregistrarpromocion"])) {

    include "../../../../modelo/conexion.php";
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["Precio"];
    $fecha_inicial=date('Y-m-d');
    $fecha_final=$_POST["fecha_final"];

    campo_vacio_nuevo($descripcion,$fecha_final,$precio,$validar);
    if($validar==true){
        Valida_descripcion($descripcion,$validar);
        if($validar==true){
            Validar_promocion($descripcion,$validar);
            if ($validar==true) {
                limite_descripcion_precio($descripcion, $precio, $validar);
                if ($validar==true) {
                    nuevo_promocion($descripcion,$precio,$fecha_inicial,$fecha_final,$validar);
                    if ($validar==true) {
                        Llenar_prom_prod($descripcion,$precio,$validar);
                        if ($validar==true) {
                            //Guardar la bitacora 
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date('Y-m-d h:i:s');
                            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nueva promocion', 'Promocion nueva','$sesion_usuario')");
                            echo '<script language="javascript">alert("SE A GUARDADO LA PROMOCION CON ÉXITOS");</script>';
                            header("location:../../administracion/administraciones/administracion_promocion/administracion_promocion.php");
                        }
                    }
                }    
            }
        }
    }
}           

//Modificar promocion
if (!empty($_POST["btnactualizar_promocion"])) {

    include "../../../../modelo/conexion.php";
    $validar=true;
    $id_promocion=$_POST["id_promocion"];
    $descripcion=$_POST["descripcion"];
    $precio=$_POST["precio"];

    campo_vacio($descripcion,$precio, $validar);
        if ($validar==true) {
            Valida_descripcion($descripcion,$validar);
            if ($validar==true) {
                limite_descripcion_precio($descripcion, $precio, $validar);
                if ($validar==true) {
                    modificar_promocion($id_promocion,$descripcion,$precio,$validar);
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
}
?>