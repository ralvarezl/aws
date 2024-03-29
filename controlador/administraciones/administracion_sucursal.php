<?php
////////FUNCIONES NUEVO REGISTRO//////////

//Funcion para validar campos vacios
function campo_vacio($nombre_sucursal,$direccion_sucursal,&$validar){
    if (!empty($_POST["nombre_sucursal"] and $_POST["direccion_sucursal"]) and $validar=true) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Por favor llene todos los campos</div>"; //Campos vacios
        return $validar;
    }
}

function Valida_nombre($nombre_sucursal, &$validar){
    //Validar tenga no tenga mas de 2 espacios
    if(strpos($nombre_sucursal,"  ")){
        echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
        $validar=false;
        return $validar;
    }else{
        return $validar;
    }  

}

function Valida_direccion($direccion_sucursal, &$validar){
    //Validar tenga no tenga mas de 2 espacios
    if(strpos($direccion_sucursal,"  ")){
        echo"<div class='alert alert-danger text-center'>No se permite más de un espacio</div>";
        $validar=false;
        return $validar;
    }else{
        return $validar;
    }  
}

function limite_nombre_direccion($nombre_sucursal, $direccion_sucursal, &$validar){

    $Longitud1=strlen($nombre_sucursal);
    $Longitud2=strlen($direccion_sucursal);
    $conta=0;

    if($Longitud1<=50){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre es muy extenso</div>";
        return $validar;
    }

    if($Longitud2<=100){
        $conta=2;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La dirección es muy extensa</div>";
        return $validar;
    }

    if ($conta==2){
        return $validar;
    }
}

//Funcion para validar que la sucursal no exista
function sucursal_existe($nombre_sucursal,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select nombre from tbl_sucursal where nombre='$nombre_sucursal'");//consultar por la sucursal
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>La sucursal ya existe, ingrese una nueva</div>"; 
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para insertar los registros 
function usuario_crear($nombre_sucursal,$direccion_sucursal,&$validar){
    include "../../../../modelo/conexion.php";
    
    //Envio de los datos a ingresar por la query
    $sql=$conexion->query("insert into tbl_sucursal (nombre,direccion, estado) values ('$nombre_sucursal', '$direccion_sucursal','ACTIVO')");
    if ($sql==1) {
    return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

////////FUNCIONES ACTUALIZAR//////////
//Funcion para validar si se actualizo

function sucursal_actualizar($id_sucursal,$nombre_sucursal,$direccion_sucursal,$estado,&$validar){
include "../../../../modelo/conexion.php";
        
    //CONSULTAR EL OBJETO
    $sql1=mysqli_query($conexion, "select nombre from tbl_sucursal where id_sucursal=$id_sucursal");
    $row=mysqli_fetch_array($sql1);
    $objeto_base=$row[0];

    if($nombre_sucursal==$objeto_base){
        $sql=$conexion->query(" update tbl_sucursal SET nombre='$nombre_sucursal', direccion='$direccion_sucursal', estado='$estado' WHERE id_sucursal = $id_sucursal ");   
        
    }else{
        //consultar por el objeto
        $sql=$conexion->query("select nombre from tbl_sucursal where nombre='$nombre_sucursal'");
        if ($datos=$sql->fetch_object()) { //si existe
            echo"<div class='alert alert-danger text-center'>La sucursal ya existe, ingrese una nueva</div>";
            $validar=false;
            return $validar;
        }else {
            $sql=$conexion->query(" update tbl_sucursal SET nombre='$nombre_sucursal', direccion='$direccion_sucursal',estado='$estado' WHERE id_sucursal = $id_sucursal ");   
            return $validar;
        }
    }
}


//*****************************BOTONES***************************************//
//Crear Nueva Sucursal Al Presionar Boton
if (!empty($_POST["btnregistrar_sucursal"])) {
    $validar=true;
    $nombre_sucursal=$_POST["nombre_sucursal"];
    $direccion_sucursal=$_POST["direccion_sucursal"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($nombre_sucursal,$direccion_sucursal,$validar);
    if ($validar==true) {
        sucursal_existe($nombre_sucursal,$validar);
        if ($validar==true) {
            Valida_nombre($nombre_sucursal, $validar);
            if ($validar==true) {
                Valida_direccion($direccion_sucursal, $validar);
                if ($validar==true) {
                    limite_nombre_direccion($nombre_sucursal, $direccion_sucursal, $validar);
                    if ($validar==true) {
                        usuario_crear($nombre_sucursal,$direccion_sucursal,$validar);
                        if ($validar==true) {
                            //Guardar la bitacora 
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date('Y-m-d h:i:s');
                            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nueva Sucursal', 'Creo la sucursal $nombre_sucursal','$sesion_usuario')");
                            //Mensaje de confirmacion
                            echo '<script language="javascript">alert("Sucursal registrada exitosamente");;window.location.href="administracion_sucursal.php"</script>';//Sucursal ingresada
                        }else{
                            echo '<div class="alert alert-danger text-center">Error al registrar sucursal</div>';//Error al ingresar sucursal
                        }
                    }
                }    
            }    
        }
    }
}

//********************************************************************//
//Editar Sucursal Al Presionar Boton Editar

if (!empty($_POST["btnactualizar_sucursal"])) {
    $validar=true;
    $nombre_sucursal=$_POST["nombre_sucursal"];
    $direccion_sucursal=$_POST["direccion_sucursal"];
    $estado=$_POST["estado"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($nombre_sucursal,$direccion_sucursal,$validar);
    if ($validar==true) {
        Valida_nombre($nombre_sucursal, $validar);
            if ($validar==true) {
                Valida_direccion($direccion_sucursal, $validar);
                if ($validar==true) {
                    limite_nombre_direccion($nombre_sucursal, $direccion_sucursal, $validar);
                    if ($validar==true) {
                        sucursal_actualizar($id_sucursal,$nombre_sucursal,$direccion_sucursal,$estado,$validar);
                        if ($validar==true) {
                            //Guardar la bitacora 
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date('Y-m-d h:i:s');
                            $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo Sucursal', 'Actualizo la sucursal $nombre_sucursal','$sesion_usuario')");
                            //Mensaje de confirmacion
                            echo '<script language="javascript">alert("Sucursal actualizada exitosamente");;window.location.href="administracion_sucursal.php"</script>';//Sucursal ingresada
                        }else{
                            echo '<div class="alert alert-danger text-center">Error al actualizar sucursal</div>';//Error al ingresar sucursal
                        }
                    }

                }
            }                
        }
    }


?>