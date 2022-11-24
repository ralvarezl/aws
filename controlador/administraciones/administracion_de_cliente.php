<?php
//Funcion para validar campos vacios
function campo_vacio($nombres,$identidad,$genero,$telefono,&$validar){
    if (!empty($_POST["nombres"] and $_POST["identidad"] and $_POST["genero"] and $_POST["telefono"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//NUEVO CLIENTE
function nuevo_cliente($nombres,$identidad,$genero,$telefono,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" insert into tbl_cliente (nombres,identidad,genero,telefono) values ('$nombres',$identidad,'$genero',$telefono)"); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//MODIFICAR CLIENTE
function modificar_cliente($id_cliente,$nombres,$identidad,$genero,$telefono,&$validar){
    include "../../../../modelo/conexion.php";
    $sql=$conexion->query(" update tbl_cliente SET nombres='$nombres', identidad= $identidad, genero = '$genero', telefono= $telefono WHERE id_cliente = $id_cliente "); 
    if($sql==1){
        return $validar;
    }else{
        echo"<div align='center' class='alert alert-danger' >Error al actualizar</div>";
    }
}

//validar extension de identidad y telefono
function tamanio_identidad_telefono($identidad,$telefono, &$validar){

    $Longitud1=strlen($identidad);
    $Longitud2=strlen($telefono);
    $conta=0;

    if($Longitud1>=13 && $Longitud1<=13){
        $conta=1;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La identidad debe tener 13 caracteres numericos</div>";
        return $validar;
    }
    if($Longitud2>=8 && $Longitud2<=8){
        $conta=2;
    }else{
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El telefono debe tener 8 caracteres numericos</div>";
        return $validar;
    }

    if ($conta==2){
        return $validar;
    }
}

//Caracteres especiales 
function valida_nombre($nombres,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$nombres)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
    } else {
        //Validar tenga caracter especial
        if (preg_match("/(?=.[@$!¿%}*{#+-.:,;'?&])/",$nombres) && preg_match('/[!"#$"%&()_=?\+[]}{-@¡¿]/',$nombres)){
            $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres especiales</div>"; 
        }else {
            if(strpos($nombres,"  ")){
                echo"<div class='alert alert-danger text-center'>No se permiten más de un espacios</div>";
                $validar=false;
                return $validar;
            }else {
                if(!strpos($nombres,"=") && !strpos($nombres, '""') or !strpos($nombres, '"')){
                    return $validar;
                }else{
                    $validar=false;
                    echo '<div class="alert alert-danger text-center">El nombre no puede llevar caracteres especiales.</div>';
                    return $validar;
                }
            }
            
        }
    }
}

//Validar que la identidad no exista ya
function identidad($identidad,&$validar){
    include "../../../../modelo/conexion.php";

    //Preguntar si existe la identidad
    $sql=mysqli_query($conexion, "select identidad from tbl_cliente where identidad=$identidad");
    $row=mysqli_fetch_array($sql);
    
    //Si no hay respuesta no existe y sigue
    if (is_null($row)){
        return $validar;
    }else{

        $validar=false;
        echo"<div class='alert alert-danger text-center'>Identidad ya existente</div>";
        return $validar;  
    }
}

//Saber si se cambio la identidad del cliente
function identidad_actualizar($id_cliente,$identidad,&$validar){
    include "../../../../modelo/conexion.php";

    //Preguntar si existe la identidad
    $sql=mysqli_query($conexion, "select identidad from tbl_cliente where id_cliente=$id_cliente");
    $row=mysqli_fetch_array($sql);
    $identidad_cliente=$row[0];

    if($identidad_cliente==$identidad){
        return $validar;
    }else{
        //Preguntar si existe la identidad
        $sql=mysqli_query($conexion, "select identidad from tbl_cliente where identidad=$identidad");
        $row=mysqli_fetch_array($sql);
        
        //Si no hay respuesta no existe y sigue
        if (is_null($row)){
            return $validar;
        }else{

            $validar=false;
            echo"<div class='alert alert-danger text-center'>Identidad ya existente</div>";
            return $validar;  
        } 
    }

}


//-----------------------FIN FUNCIONES-------------------------------------

//Ingresar nuevo cliente
if (!empty($_POST["btnregistrarcliente"])) {
    $sesion_usuario=$_SESSION['usuario_login'];
    $validar=true;
    $nombres=$_POST["nombres"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];

    campo_vacio($nombres,$identidad,$genero,$telefono,$validar);
    if($validar==true){
        valida_nombre($nombres,$validar);
        if($validar==true){
            tamanio_identidad_telefono($identidad,$telefono, $validar);
            if ($validar==true) {
                identidad($identidad,$validar);
                if ($validar==true) {
                    nuevo_cliente($nombres,$identidad,$genero,$telefono,$validar);
                    if ($validar==true) {
                        //Guardar la bitacora 
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha = date('Y-m-d h:i:s');
                        $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Creo nuevo cliente', 'Cliente nuevo','$sesion_usuario')");
                        //Mensaje de confirmacion
                        echo '<script language="javascript">alert("Cliente actualizado exitosamente");;window.location.href="administracion_cliente.php"</script>';
                    }
                }
            }
        }
    }           
}

//Modificar cliente
if (!empty($_POST["btnactualizarcliente"])) {

    //include "../../modelo/conexion.php";
    $validar=true;
    $sesion_usuario=$_SESSION['usuario_login'];
    $id_cliente=$_POST["id_cliente"];
    $nombres=$_POST["nombres"];
    $identidad=$_POST["identidad"];
    $genero=$_POST["genero"];
    $telefono=$_POST["telefono"];

    campo_vacio($nombres,$identidad,$genero,$telefono,$validar);
    if($validar==true){
        tamanio_identidad_telefono($identidad,$telefono, $validar);
        if ($validar==true) {
            identidad_actualizar($id_cliente,$identidad,$validar);
            if ($validar==true) {
                modificar_cliente($id_cliente,$nombres,$identidad,$genero,$telefono,$validar);
                if ($validar==true) {
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo cliente', 'Cliente actualizado','$sesion_usuario')");
                    //Mensaje de confirmacion
                    echo '<script language="javascript">alert("Cliente actualizado exitosamente");;window.location.href="administracion_cliente.php"</script>';
                }
            }
        }
    }
}

?>