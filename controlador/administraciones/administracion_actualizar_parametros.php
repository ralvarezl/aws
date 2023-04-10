<?php
//Funcion para validar campos vacios
function campo_vacio($parametro, $valor, &$validar){
    if (!empty($_POST["parametro"] and $_POST["valor"] and $validar=true)) { //Campos llenos
        return $validar;
    }else {
        $validar=false;
        echo"<div align='center' class='alert alert-danger' >Favor rellenar campos</div>"; //Campos vacios
        return $validar;
    }
}

//Funcion para validar que el parametro no exista
function parametro_existe($parametro,&$validar){
    include "../../../../modelo/conexion.php";
    //consultar por el parametro
    $sql=$conexion->query("select parametro from tbl_ms_parametros where parametro='$parametro'");
    if ($datos=$sql->fetch_object()) { //si existe
        echo"<div class='alert alert-danger text-center'>Parametro existente</div>"; 
        $validar=false;
        return $validar;
    }else {
        return $validar;
    }
}

//Funcion para insertar los registros 
function parametro_crear($parametro,$valor,$estado,&$validar){
    include "../../../../modelo/conexion.php";
    
    //Envio de los datos a ingresar por la query
    $sql=$conexion->query("insert into tbl_ms_parametros (parametro,valor,estado) values ('$parametro', '$valor','$estado')");
    if ($sql==1) {
    return $validar;
    }else {
    $validar=false;
    return $validar;
    }
}

//Funcion para validar si se actualizo

function parametro_actualizar($id_parametro,$parametro,$valor,$estado,&$validar){
    include "../../../../modelo/conexion.php";
            
        //CONSULTAR EL PARAMETRO
        $sql1=mysqli_query($conexion, "select parametro from tbl_ms_parametros where id_parametro=$id_parametro");
        $row=mysqli_fetch_array($sql1);
        $objeto_base=$row[0];
    
        if($parametro==$objeto_base){
            $sql=$conexion->query(" update tbl_ms_parametros SET parametro='$parametro', valor='$valor', estado='$estado' WHERE id_parametro = $id_parametro ");   
            
        }else{
            //consultar por el parametro
            $sql=$conexion->query("select parametro from tbl_ms_parametros where parametro='$parametro'");
            if ($datos=$sql->fetch_object()) { //si existe
                echo"<div class='alert alert-danger text-center'>Este parametro ya existe</div>";
                $validar=false;
                return $validar;
            }else {
                $sql=$conexion->query(" update tbl_ms_parametros SET parametro='$parametro', valor='$valor', estado='$estado' WHERE id_parametro = $id_parametro ");   
                return $validar;
            }
        }
    }

//Caracteres especiales 
function valida_paramentro($parametro,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$parametro)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres numéricos</div>"; 
        return $validar;
    } else {
        //Validar tenga caracter especial
        if (!preg_match("/^[a-zA-Z\s]*$/",$parametro)){
            $validar=false;
            echo"<div class='alert alert-danger text-center'>El nombre no debe tener caracteres especiales</div>"; 
            return $validar;
        }else {
            //Validar tenga no tenga mas de 2 espacios
            if(strpos($parametro," ")){
                echo"<div class='alert alert-danger text-center'>No se permite espacios</div>";
                $validar=false;
                return $validar;
            }else{
                return $validar;
            }
        }
    }
}

//*****************************BOTONES***************************************//
//Crear Nuevo parametro Al Presionar Boton
if (!empty($_POST["btnregistrar_parametro"])) {
    $validar=true;
    $parametro=$_POST["parametro"];
    $valor=$_POST["valor"];
    $estado=$_POST["estado"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($parametro,$valor,$validar);
    if ($validar==true) {
        valida_paramentro($parametro,$validar);
        if ($validar==true) {
            parametro_existe($parametro,$validar);
            if ($validar==true) {
                parametro_crear($parametro,$valor,$estado,$validar);
                if ($validar==true) {
                    //Guardar la bitacora 
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d h:i:s');
                    $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Nuevo Parametro', 'Creo el parametro $parametro','$sesion_usuario')");
                    //Mensaje de confirmacion
                    echo '<script language="javascript">alert("Parametro registrado exitosamente");;window.location.href="administracion_parametros.php"</script>';//Parametro ingresado
                }else{
                    echo '<div class="alert alert-danger text-center">Error al registrar parametro</div>';//Error al ingresar parametro
                    }
            }
        }
    }
}

if (!empty($_POST["btnactualizarparametro"])) {
    $validar=true;
    $parametro=$_POST["parametro"];
    $valor=$_POST["valor"];
    $estado=$_POST["estado"];
    $sesion_usuario=$_SESSION['usuario_login'];

    campo_vacio($parametro,$valor,$validar);
    if ($validar==true) {
        valida_paramentro($parametro,$validar);
        if ($validar==true) {
            parametro_actualizar($id_parametro,$parametro,$valor,$estado,$validar);
            if ($validar==true) {
                 //Guardar la bitacora 
                 date_default_timezone_set("America/Tegucigalpa");
                 $fecha = date('Y-m-d h:i:s');
                 $sql_bitacora=$conexion->query("INSERT INTO tbl_ms_bitacora (fecha_bitacora, accion, descripcion,creado_por) value ( '$fecha', 'Actualizo Parametro', 'Actualizo el parametro $parametro','$sesion_usuario')");
                //Mensaje de confirmacion
                echo '<script language="javascript">alert("Parametro actualizado exitosamente");;window.location.href="administracion_parametros.php"</script>';//Sucursal ingresada
            }else{
                echo '<div class="alert alert-danger text-center">Error al actualizar parametro</div>';//Error al ingresar parametro
            }
        }
    }
}
?>