<?php
//Funcion para validar campos vacios
function campo_vacio($id_estado,$estado, &$validar){
    if (!empty($_POST["estado"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//ACTUALIZAR ESTADO
function actualizar_estado($id_estado,$estado, &$validar){
    include "../../../../modelo/conexion.php";
        
    $sql=$conexion->query(" update tbl_ms_estado SET estado='$estado' WHERE id_estado = $id_estado ");   
    if ($sql==1) {
        return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

//NUEVO ESTADO
function nuevo_estado($estado, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_estado (estado) values ('$estado') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($estado, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select estado from tbl_ms_estado where estado='$estado'");//consultar por el estado
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este estado ya existe</div>";
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function valida_estado($estado,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$estado)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($estado);
    if($Longitud1<=20){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Estado muy extenso</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($estado, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga numeros
    if (preg_match('/[0-9]/',$estado)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El estado no debe tener caracteres numéricos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }
    
    if(!strpos($estado, "=") && !strpos($estado, '""') or !strpos($estado, '"')){
        $cont=5;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">El estado no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==5){
        return $validar;    
    }
}

//-----------------------PRESIONAR BOTONES-------------------------------------

//Ingresar nuevo estado
if (!empty($_POST["btnregistrar_estado"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $estado=$_POST["estado"];
    if($estado==''){
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        $validar=false;
    }

    if ($validar==true) {
        validar_existe($estado, $validar);
        if($validar==true){
            valida_estado($estado,$validar);
            if($validar==true){
                nuevo_estado($estado,$validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Estado', 'Creo nuevo estado $estado','$sesion_usuario')");
                    //Mensaje de confirmacion
                    echo '<script language="javascript">alert("Estado ingresado exitosamente");;window.location.href="administracion_estado.php"</script>';//estado ingresado
                }
            }  
        }
    }
}

//ACTUALIZAR ESTADO
if (!empty($_POST["btnactualizar_estado"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_estado=$_POST["id_estado"];
    $estado=$_POST["estado"];
    campo_vacio($id_estado,$estado, $validar);
        if ($validar==true) {
            validar_existe($estado, $validar);
            if($validar==true){
                valida_estado($estado,$validar);
                if($validar==true){
                    actualizar_estado($id_estado,$estado, $validar);
                    if($validar==true){
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar Estado', 'Actualizo estado $estado','$sesion_usuario')");
                        //Mensaje de confirmacion
                        echo '<script language="javascript">alert("Estado actualizado exitosamente");;window.location.href="administracion_estado.php"</script>';//estado ingresado
                    }
                }
                
            } 
        }
}


?>