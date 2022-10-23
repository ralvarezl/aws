<?php
//|||||||||||||||||||||||||||||||| Funciones de Recupercion por msj ||||||||||||||||||||||||||||||||||||

//--validacion que no existan campos vacios de respuesta
function campo_vacio_respuesta($respuestas,&$validar){
    if (!empty($_POST["respuesta"]) and $validar=true) {    //Campos en uso
        return $validar;
    }else {
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Favor Rellenar Campos</div>"; //Campos sin uso
        return $validar;
    }
}

function Comparar_respuesta($usuario_msj,$id_pregunta, $respuesta, &$validar){
    
    include "../../modelo/conexion.php";
    //Obtenemos el id del usuario
    $sql=mysqli_query($conexion, "select id_usuario from tbl_ms_usuario where usuario='$usuario_msj'");
    $row=mysqli_fetch_array($sql);
    $id_usuario=$row[0];

    $sql2=mysqli_query($conexion, "select respuesta from tbl_ms_preguntas_usuario where id_pregunta=$id_pregunta and id_usuario=$id_usuario and respuesta='$respuesta'");
    $row2=mysqli_fetch_array($sql2);
    
    if (is_null($row2)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>Respuesta Incorecta </div>";
        return $validar;
    }else{
        //Obtenemos la respuesta del usuario y su pregunta
        $sql1=mysqli_query($conexion, "select respuesta from tbl_ms_preguntas_usuario where id_pregunta=$id_pregunta and id_usuario=$id_usuario");
        $row1=mysqli_fetch_array($sql1);
        $respuesta_usuario=$row1[0];
        
        if($respuesta_usuario==$respuesta){
           //Confirmacion
            return $validar;
        }  
    }
    
}


//--ver si hay espacios
function Validar_Espacio_rmjs($respuesta,&$validar){
    //Validar que el Usuario tenga espacio

    if(strpos($respuesta, "  ")){
        echo"<div class='alert alert-danger text-center'>No se permiten mas de un espacios</div>";
        $validar=false;
        return $validar;
    }else{
        if (ctype_graph($respuesta)){        
            echo"<div class='alert alert-danger text-center'>No se permiten mas de un espacios</div>";            
            $validar=false;
            return $validar;   
        }
        elseif(!ctype_graph($respuesta)){        
            return $validar;
        }
    }
}


function Valida_resp($respuesta,&$validar){
    //Validar tenga numeros
    if (preg_match('/[0-9]/',$respuesta)){
        $validar=false;
        echo"<div class='alert alert-danger text-center'>La respuesta no debe tener caracteres numéricos</div>"; 
    } else {
        //Validar tenga caracter especial
        if (preg_match('/[^a-zA-Z\d]/',$respuesta)){
            $validar=false;
        echo"<div class='alert alert-danger text-center'>La respuesta no debe tener caracteres especiales</div>"; 
        }else {
            $Longitud1=strlen($respuesta);
            if($Longitud1<=20){
                return $validar;
            }else {
                $validar=false;
                echo"<div class='alert alert-danger text-center'>La respuesta es muy extensa</div>"; //Campos sin uso
                return $validar;
            }
        }
    }
}
///////////////////////////////////////////----EJECUCIÓN DE COMBOBOX----///////////////////////////////////////////


$consulta = "select * from tbl_ms_preguntas";
$ejecutar = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));


if (!empty($_POST["btnsiguiente"])){
        //session_destroy();
        $validar=true;
        $respuesta=$_POST["respuesta"];
        $query=$conexion -> query("select * from tbl_ms_preguntas_usuario where respuesta='$respuesta'");
        $id_pregunta=$_POST["id_pregunta"];
        
        campo_vacio_respuesta($respuesta,$validar);
        if($validar==true){
            Validar_Espacio_rmjs($respuesta,$validar);
            if($validar==true){
                Valida_resp($respuesta,$validar);
                if($validar==true){
                    Comparar_respuesta($usuario_msj,$id_pregunta, $respuesta,$validar);
                    if($validar==true){
                        //Validar con el parametro
                        if(isset($_SESSION["respuesta_resp"]) == true){
                            //Entonces que le sume uno
                            $_SESSION["respuesta_resp"]++;
                            $respuesta_resp= $_SESSION["respuesta_resp"];
                            //Sacar el valor del parametro de preguntas
                            $sql=mysqli_query($conexion, "select valor from tbl_ms_parametros where id_parametro='3'");
                            $row=mysqli_fetch_array($sql);
                            $valor=$row[0];
                            
                            //Si respuestas son iguales al valor del parametro
                            if($respuesta_resp==$valor){
                                                    
                            header("location:recuperacion_msj_contra.php");
                            }
                            }else{
                                // Si no existe que la cree
                                $_SESSION["respuesta_resp"] = 1;
                            } 
                            echo "<div class='alert alert-success text-center'>Respuesta Correcta</div>";
                        }else{
                            $_SESSION["respuestas_resp"]=0;
                        }
                    }
                }
        }
}
     

if (!empty($_POST["btn_salir_msj"])) {
    session_destroy();
}

?>