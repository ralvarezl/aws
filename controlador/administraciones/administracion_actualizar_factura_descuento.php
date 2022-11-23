<?php
//FUNCION VALIDAR CAMPOS VACIOS
function campo_vacio($id_factura_descuento, $total_descuento, &$validar){
    if (!empty($_POST["id_factura_descuento"] and $_POST["total_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//FUNCION VALIDAR CAMPOS VACIOS DE ACTUALIZAR
function campo_vacio_actualizar($total_descuento, &$validar){
    if (!empty($_POST["$total_descuento"] and $_POST["$total_descuento"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR FACTURA DESCUENTO
function actualizar_factura_descuento($id_factura_descuento,$total_descuento, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" update tbl_factura_descuento set total_descuento= '$total_descuento'  where id_factura_descuento = '$id_factura_descuento';");   
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//NUEVA FACTURA DESCUENTO
function nuevo_factura_descuento($total_descuento, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_factura_descuento (total_descuento) values ('$total_descuento');");
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al registrar</div>";
    }
}

//VALIDAR LA LONGITUD DEL TOTAL DESCUENTO
function validar_longitud($total_descuento, &$validar){
    $Longitud1=strlen($total_descuento);
    $conta=0;

    if($Longitud1<=4){
        return $validar;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El descuento no puede pasar de 4 cifras contando decimales</div>";
        return $validar;
    }

}

//-----------------------FIN FUNCIONES-------------------------------------

//Funcion para actualizar 
if (!empty($_POST["btnactualizarfacturadescuento"])) {

    $validar=true;
    $id_factura_descuento=$_POST["id_factura_descuento"];
    $total_descuento=$_POST["total_descuento"];
    campo_vacio($id_factura_descuento, $total_descuento, $validar);
       
         if ($validar==true){
            actualizar_factura_descuento($id_factura_descuento,$total_descuento, $validar);
            if ($validar==true){
                validar_longitud($total_descuento, $validar);
                if ($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Descuento', 'Creo descuento $descripcion','$sesion_usuario')");               
                    header("location:administracion_factura_descuento.php");
                }    
            }
        }
      
}

if (!empty($_POST["btn_nuevo_factura_descuento"])) {

    $validar=true;
    $total_descuento=$_POST["total_descuento"];

    validar_longitud($total_descuento, $validar);
    if ($validar==true){
        nuevo_factura_descuento($total_descuento, $validar);
        if ($validar==true) {

            //Guardar la bitacora 
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d h:i:s');
            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Descuento', 'Creo descuento $descripcion','$sesion_usuario')");               
            header("location:administracion_factura_descuento.php");
        }  
    }    
}
?>