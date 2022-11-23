<?php
//Funcion para validar campos vacios
function campo_vacio($id_genero,$genero, &$validar){
    if (!empty($_POST["genero"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}
//ACTUALIZAR GENERO
function actualizar_genero($id_genero,$genero, &$validar){
    include "../../../../modelo/conexion.php";
        
    $sql=$conexion->query(" update tbl_ms_genero SET genero='$genero' WHERE id_genero = $id_genero ");   
    if ($sql==1) {
        return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

//NUEVO GENERO
function nuevo_genero($genero, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_ms_genero (genero) values ('$genero') "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//VALIDAR QUE NO SEA UN ARCHIVO EXISTENTE
function validar_existe($genero, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query("select genero from tbl_ms_genero where genero='$genero'");//consultar por el genero
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Este genero ya existe</div>";
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Caracteres especiales 
function valida_genero($genero,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$genero)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($genero);
    if($Longitud1<=20){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Genero muy extenso</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($genero, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga numeros
    if (preg_match('/[0-9]/',$genero)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El genero no debe tener caracteres numéricos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }
    
    if(!strpos($genero, "=") && !strpos($genero, '""') or !strpos($genero, '"')){
        $cont=5;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">El genero no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==5){
        return $validar;    
    }
}

//-----------------------PRESIONAR BOTONES-------------------------------------

//Ingresar nuevo genero
if (!empty($_POST["btnregistrar_genero"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $genero=$_POST["genero"];
    if($genero==''){
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        $validar=false;
    }

    if ($validar==true) {
        validar_existe($genero, $validar);
        if($validar==true){
            valida_genero($genero,$validar);
            if($validar==true){
                nuevo_genero($genero,$validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Genero', 'Creo nuevo genero $genero','$sesion_usuario')");
                    //Mensaje de confirmacion
                    echo '<script language="javascript">alert("Genero ingresado exitosamente");;window.location.href="administracion_genero.php"</script>';//genero ingresado
                }
            }  
        }
    }
}

//ACTUALIZAR GENERO
if (!empty($_POST["btnactualizar_genero"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    //include "../../modelo/conexion.php";
    $validar=true;
    $id_genero=$_POST["id_genero"];
    $genero=$_POST["genero"];
    campo_vacio($id_genero,$genero, $validar);
        if ($validar==true) {
            validar_existe($genero, $validar);
            if($validar==true){
                valida_genero($genero,$validar);
                if($validar==true){
                    actualizar_genero($id_genero,$genero, $validar);
                    if($validar==true){
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizar Genero', 'Actualizo genero $genero','$sesion_usuario')");
                        //Mensaje de confirmacion
                        echo '<script language="javascript">alert("Genero actualizado exitosamente");;window.location.href="administracion_genero.php"</script>';//genero ingresado
                }
            }
                
        } 
    }
}


?>

