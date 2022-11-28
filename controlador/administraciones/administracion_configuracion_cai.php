<?php
//Funcion para validar campos vacios
function campo_vacio_actualizar($numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, &$validar){
    if (!empty($_POST["numero_cai"] and $_POST["secuencia_inicial"] and $_POST["secuencia_actual"] and $_POST["secuencia_final"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

function campo_vacio_nuevo($numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, &$validar){
    if (!empty($_POST["numero_cai"] and $_POST["secuencia_inicial"] and $_POST["secuencia_actual"] and $_POST["secuencia_final"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}




function actualizar_configuracion_cai($id_configuracion_cai, $numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, &$validar){
    include "../../../../modelo/conexion.php";
    
    //CONSULTAR EL numero cai
    $sql1=mysqli_query($conexion, "select numero_cai from tbl_configuracion_cai where id_configuracion_cai=$id_configuracion_cai");
    $row=mysqli_fetch_array($sql1);
    $cai_base=$row[0];

    if($numero_cai==$cai_base){
        $sql=$conexion->query(" update tbl_configuracion_cai SET secuencia_inicial='$secuencia_inicial', secuencia_actual ='$secuencia_actual', secuencia_final='$secuencia_final' WHERE id_configuracion_cai=$id_configuracion_cai");
    }else{
        //consultar por el numero cai
        $sql=$conexion->query("select numero_cai from tbl_configuracion_cai where numero_cai='$numero_cai'");
        if ($datos=$sql->fetch_object()) { //si existe
            echo"<div class='alert alert-danger text-center'>Este numero cai ya existe</div>";
            $validar=false;
            return $validar;
        }else{
            $sql=$conexion->query(" update tbl_configuracion_cai SET numero_cai='$numero_cai', secuencia_inicial='$secuencia_inicial',secuencia_actual='$secuencia_actual', secuencia_final='$secuencia_final' WHERE id_configuracion_cai=$id_configuracion_cai");
            return $validar;
        }
    }
}

//NUEVO CONFIGURACION CAI
function nuevo_configuracion_cai($id_configuracion_cai, $numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, $estado, &$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_configuracion_cai (numero_cai, secuencia_inicial, secuencia_actual, secuencia_final, estado) values ('$numero_cai','$secuencia_inicial','$secuencia_actual','$secuencia_final', 'ACTIVO'); "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al registrar</div>";
    }
}



//Caracteres especiales 
function validar_numero_cai($numero_cai,&$validar){
    $cont=0;
    //Validar tenga caracter especial
    if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$numero_cai)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No debe tener caracteres especiales</div>";
        return $validar;
    }else{
        $cont=1;
    }
    $Longitud1=strlen($numero_cai);
    if($Longitud1<=4){
        $cont=2;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Numero cai muy extenso</div>"; //Campos sin uso
        return $validar;
    }
    if (strpos($numero_cai, "  ")){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>No puede tener espacios o caracteres especiales</div>";
        return $validar;
    }else{
        $cont=3; 
    }

    //Validar tenga mayusculas
    if (preg_match('/[A-Z]/',$numero_cai)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El numero cai no debe tener caracteres alfabeticos</div>"; 
        return $validar;
    }else{
        $cont=4;
    }

    //Validar tenga minusculas
    if (preg_match('/[a-z]/',$numero_cai)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La descripción no debe tener caracteres alfabeticos</div>"; 
        return $validar;
    }else{
        $cont=5;
    }
    
    if(!strpos($numero_cai, "=") && !strpos($numero_cai, '""') or !strpos($numero_cai, '"')){
        $cont=6;
    }else{
        $validar=false;
        echo '<div class="alert alert-danger text-center">La descripción no puede llevar caracteres especiales.</div>';
        return $validar;
    }

    if($cont==6){
        return $validar;    
    }
}

//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo configuracion cai
if (!empty($_POST["btn_nuevo_configuracion_cai"])) {
    
    
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];

    
    $numero_cai=$_POST["numero_cai"];
    $secuencia_inicial=$_POST["secuencia_inicial"];
    $secuencia_actual=$_POST["secuencia_actual"];
    $secuencia_final=$_POST["secuencia_final"];

    campo_vacio_nuevo($numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, $validar);
    if($validar==true){
        validar_existe($numero_cai, $validar);
        if($validar==true){
            validar_numero_cai($numero_cai, $validar);
            if($validar==true){
                nuevo_configuracion_cai($id_configuracion_cai, $numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, $estado, $validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Configuracion Cai', 'Creo numero cai $numero_cai','$sesion_usuario')");
                    header("location:administracion_configuracion_cai.php");
                }
            }  
        }
    }
}

//ACTUALIZAR EL TIPO DE PEDIDO
if (!empty($_POST["btn_actualizar_configuracion_cai"])) {
    
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];

    $id_configuracion_cai=$_POST["id_configuracion_cai"];
    $numero_cai=$_POST["numero_cai"];
    $secuencia_inicial=$_POST["secuencia_inicial"];
    $secuencia_actual=$_POST["secuencia_actual"];
    $secuencia_final=$_POST["secuencia_final"];


    campo_vacio_actualizar($numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, $validar);
    if($validar==true){
        
            validar_numero_cai($numero_cai,$validar);
            if($validar==true){
                actualizar_configuracion_cai($id_configuracion_cai, $numero_cai, $secuencia_inicial, $secuencia_actual, $secuencia_final, $validar);
                if($validar==true){
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Configuracion Cai', 'Creo numero cai $numero_cai','$sesion_usuario')");
                    header("location:administracion_configuracion_cai.php");
                }
            }  
        
    }    
}
?>