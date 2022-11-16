<?php
session_start();
if(empty($_SESSION['usuario_login'])){
    header("location:../../../../login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Descuento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/02575225aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../public/style_inicio.css">
    <link rel="shortcut icon" href="../../public/img/Logo.png">

</head>


<body>
    <!--INICIO DEL NAVBAR-->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
            <img src="../../public/img/aws_navbar.png"/>
                Andrés Coffee
            </a>
            <a class="navbar-brand" href="#" >
                <i class="fa-solid fa-gears"></i> FACTURACION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h1 class="fas fa-user-circle"></h1>
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                <!--MOSTRAR EL USUARIO LOGUEADO-->
                <?=
                "BIENVENIDO ".$_SESSION['usuario_login'];
                ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/inicio.php"><i class="fa-solid fa-house"></i> INICIO </a>
                </li>
                <!--ADMINISTRADOR CIENTE-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_cliente.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE CLIENTE</a>
                </li>
                <!--ADMINISTRADOR PRODUCTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_producto.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PRODUCTOS</a>
                </li>
                <!--ADMINISTRADOR PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_promocion.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DESCUENTO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE DESCUENTO</a>
                </li>
                <!--ADMINISTRADOR TIPO PEDIDO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_tipo_pedido.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE TIPO PEDIDO</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_sucursal.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE SUCURSAL</a>
                </li>
                <!--ADMINISTRADOR DE SUCURSAL PROMOCION-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_sucursal_promocion.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE SUCURSAL Y PROMOCION</a>
                </li>
                <!--ADMINISTRADOR DE CONFIGURACION CAI-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_configuracion_cai.php"><i class="fa-solid fa-list-check"></i> ADMINISTRADOR DE CONFIGURACION CAI</a>
                </li>
                <!--ADMINISTRADOR DE USUARIO-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_usuario.php"><i class="fa-solid fa-users-gear"></i> ADMINISTRADOR DE USUARIOS</a>
                </li>
                <!--ADMINISTRADOR DE PARAMETROS-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/admin_parametros.php"><i class="fa-solid fa-gears"></i> ADMINISTRADOR DE PARAMETROS</a>
                </li>
                <!--ADMINISTRADOR DE BITACORA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/bitacora_pantalla/bitacora.php"><i class="fa-solid fa-list-check"></i> BITACORA</a>
                </li>
                <!--SALIR DEL SITEMA-->
                <li class="btn btn-dark p-2">
                    <a class="nav-link" href="../../../../controlador/cerrar_sesion.php"><i class="fa-solid fa-person-walking-arrow-right"></i> SALIR DEL SISTEMA</a>
                </li>

                <li class="btn btn-dark p-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </nav>
        <!--FIN DEL NAVBAR-->
        
        <!--Funcion de eliminar-->
        <script>
            function eliminar(){
                var respuesta=confirm("¿Deseas eliminar la configuracion cai?")
            return respuesta;
            }
        </script>

        <div class="col-9 p-3 m-auto">
        <br><br><br><br>

        <div class="container">
	    <div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Factura</h4>
		</div>
		<div class="panel-body">
		<!--<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>-->
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">

				<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				<div class="col-md-3">
					    <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required>
					    <input id="id_cliente" type='hidden'>	
				</div>

				<label for="tel1" class="col-md-1 control-label">Teléfono</label>
				<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly>
				</div>

				<label for="mail" class="col-md-1 control-label">Identidad</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="mail" placeholder="Identidad" readonly>
				</div>
                </div>

					<div class="form-group row">
						<label for="empresa" class="col-md-1 control-label">Vendedor: </label>
						<div class="col-md-3">
                        <input type="text" readonly="readonly" class="form-control" 
                               name="vendedor" value="<?=$_SESSION['usuario_login'];?>">
						</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
                        <button type="button" class="btn btn-default" onclick="location.href='nuevo_prodcuto.php'">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" onclick="location.href='nuevo_cliente.php'">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>

	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.email_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	
	</script>

  </body>




<?