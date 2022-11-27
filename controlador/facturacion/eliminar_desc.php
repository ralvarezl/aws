<?php
    if(!empty($_GET["id_descuento"])) {
        $sesion_usuario=$_SESSION['usuario_login'];
        $id_descuento=$_GET["id_descuento"];
        
        //BORRAR EL TIPO DE PEDIDO
        $sql=$conexion->query("delete from tbl_detalle_desc_temp where id_descuento=$id_descuento ");
    }

?>