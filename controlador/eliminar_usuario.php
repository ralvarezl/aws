<?php
    if(!empty($_GET["id_usuario"])) {
        $id_usuario=$_GET["id_usuario"];
        $sql=$conexion->query(" update tbl_ms_usuario set estado='INACTIVO' where id_usuario=$id_usuario  ");
        if ($sql==1) {
            echo '<div class="alert alert-danger text-center">Usuario Eliminado Correctamente</div>';//Se elimino correctamente el usuario
        } else {
            echo '<div class="alert alert-danger text-center">Error al eliminar el usuario</div>';
        }
        
    }

?>