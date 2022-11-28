DROP TABLE IF EXISTS tbl_cliente;

CREATE TABLE `tbl_cliente` (
  `ID_CLIENTE` int NOT NULL AUTO_INCREMENT,
  `NOMBRES` varchar(60) DEFAULT NULL,
  `IDENTIDAD` bigint(13) unsigned zerofill DEFAULT NULL,
  `GENERO` varchar(20) DEFAULT NULL,
  `TELEFONO` bigint DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_cliente VALUES("1","CLIENTE FRECUENTE","0000000000000","SIN SEXO","0","ACTIVO",);



DROP TABLE IF EXISTS tbl_configuracion_cai;

CREATE TABLE `tbl_configuracion_cai` (
  `ID_CONFIGURACION_CAI` int NOT NULL AUTO_INCREMENT,
  `NUMERO_CAI` int(4) unsigned zerofill NOT NULL,
  `SECUENCIA_INICIAL` int DEFAULT NULL,
  `SECUENCIA_ACTUAL` int DEFAULT NULL,
  `SECUENCIA_FINAL` int DEFAULT NULL,
  `FECHA_VENCIMIENTO` date DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_CONFIGURACION_CAI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_descuento;

CREATE TABLE `tbl_descuento` (
  `ID_DESCUENTO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `PORCENTAJE_DESCUENTO` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_DESCUENTO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_descuento VALUES("1","SIN DESCUENTO","0.00","ACTIVO",),
("2","DESCUENTO DE LA TERCERA EDAD","10.00","ACTIVO",),
("3","DESCUENTO POR EL GASTO DE 300 LPS","7.00","ACTIVO",),
("4","DESCUENTO NAVIDEÑO","5.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_detalle_prom_temp;

CREATE TABLE `tbl_detalle_prom_temp` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PROMOCION` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_VENTA` decimal(8,2) NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;




DROP TABLE IF EXISTS tbl_detalle_temp;

CREATE TABLE `tbl_detalle_temp` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_VENTA` decimal(8,2) NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;




DROP TABLE IF EXISTS tbl_factura;

CREATE TABLE `tbl_factura` (
  `ID_FACTURA` int NOT NULL AUTO_INCREMENT,
  `FECHA` datetime DEFAULT NULL,
  `NUMERO_FACTURA` decimal(8,2) DEFAULT NULL,
  `SUBTOTAL` decimal(8,2) DEFAULT NULL,
  `ISV` decimal(8,2) DEFAULT NULL,
  `TOTAL_DESCUENTO` decimal(8,2) DEFAULT NULL,
  `TOTAL` decimal(8,2) DEFAULT NULL,
  `PAGO` decimal(8,2) DEFAULT NULL,
  `CAMBIO` decimal(8,2) DEFAULT NULL,
  `ID_TIPO_PEDIDO` int DEFAULT NULL,
  `ID_CLIENTE` int DEFAULT NULL,
  `ID_SUCURSAL` int DEFAULT NULL,
  `ID_USUARIO` int DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_FACTURA`),
  KEY `ID_TIPO_PEDIDO` (`ID_TIPO_PEDIDO`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  KEY `ID_SUCURSAL` (`ID_SUCURSAL`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `tbl_factura_ibfk_1` FOREIGN KEY (`ID_TIPO_PEDIDO`) REFERENCES `tbl_tipo_pedido` (`ID_TIPO_PEDIDO`),
  CONSTRAINT `tbl_factura_ibfk_2` FOREIGN KEY (`ID_CLIENTE`) REFERENCES `tbl_cliente` (`ID_CLIENTE`),
  CONSTRAINT `tbl_factura_ibfk_3` FOREIGN KEY (`ID_SUCURSAL`) REFERENCES `tbl_sucursal` (`ID_SUCURSAL`),
  CONSTRAINT `tbl_factura_ibfk_4` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_ms_usuario` (`ID_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_factura_descuento;

CREATE TABLE `tbl_factura_descuento` (
  `ID_FACTURA_DESCUENTO` int NOT NULL AUTO_INCREMENT,
  `TOTAL_DESCUENTO` decimal(8,2) NOT NULL,
  `ID_DESCUENTO` int DEFAULT NULL,
  `ID_FACTURA` int DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_FACTURA_DESCUENTO`),
  KEY `ID_DESCUENTO` (`ID_DESCUENTO`),
  KEY `ID_FACTURA` (`ID_FACTURA`),
  CONSTRAINT `tbl_factura_descuento_ibfk_1` FOREIGN KEY (`ID_DESCUENTO`) REFERENCES `tbl_descuento` (`ID_DESCUENTO`),
  CONSTRAINT `tbl_factura_descuento_ibfk_2` FOREIGN KEY (`ID_FACTURA`) REFERENCES `tbl_factura` (`ID_FACTURA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_factura_detalle;

CREATE TABLE `tbl_factura_detalle` (
  `ID_FACTURA_DETALLE` int NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int NOT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `ID_FACTURA` int DEFAULT NULL,
  `ID_PRODUCTO` int DEFAULT NULL,
  `ID_PROMOCION` int DEFAULT NULL,
  PRIMARY KEY (`ID_FACTURA_DETALLE`),
  KEY `ID_FACTURA` (`ID_FACTURA`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  KEY `ID_PROMOCION` (`ID_PROMOCION`),
  CONSTRAINT `tbl_factura_detalle_ibfk_1` FOREIGN KEY (`ID_FACTURA`) REFERENCES `tbl_factura` (`ID_FACTURA`),
  CONSTRAINT `tbl_factura_detalle_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `tbl_producto` (`ID_PRODUCTO`),
  CONSTRAINT `tbl_factura_detalle_ibfk_3` FOREIGN KEY (`ID_PROMOCION`) REFERENCES `tbl_promocion` (`ID_PROMOCION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_factura_promocion;

CREATE TABLE `tbl_factura_promocion` (
  `ID_FACTURA_PROMOCION` int NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int NOT NULL,
  `TOTAL_PROMOCION` decimal(8,2) NOT NULL,
  `ID_FACTURA` int NOT NULL,
  `ID_PROMOCION` int NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_FACTURA_PROMOCION`),
  KEY `ID_FACTURA` (`ID_FACTURA`),
  KEY `ID_PROMOCION` (`ID_PROMOCION`),
  CONSTRAINT `tbl_factura_promocion_ibfk_1` FOREIGN KEY (`ID_FACTURA`) REFERENCES `tbl_factura` (`ID_FACTURA`),
  CONSTRAINT `tbl_factura_promocion_ibfk_2` FOREIGN KEY (`ID_PROMOCION`) REFERENCES `tbl_promocion` (`ID_PROMOCION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_ms_bitacora;

CREATE TABLE `tbl_ms_bitacora` (
  `ID_BITACORA` int NOT NULL AUTO_INCREMENT,
  `FECHA_BITACORA` datetime DEFAULT NULL,
  `ACCION` varchar(100) DEFAULT NULL,
  `DESCRIPCION` varchar(200) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `ID_OBJETO` int DEFAULT NULL,
  PRIMARY KEY (`ID_BITACORA`),
  KEY `ID_OBJETO` (`ID_OBJETO`),
  CONSTRAINT `tbl_ms_bitacora_ibfk_1` FOREIGN KEY (`ID_OBJETO`) REFERENCES `tbl_ms_objetos` (`ID_OBJETO`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_bitacora VALUES("1","2022-11-27 05:12:06","Login","Ingreso al sistema","ADMIN","","","","",),
("2","2022-11-27 05:12:27","Login","Ingreso al sistema","ADMIN","","","","",),
("3","2022-11-27 05:12:48","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("4","2022-11-27 05:15:37","Crear usuario","Administrador creo un usuario nuevo","ADMIN","","","","",),
("5","2022-11-27 05:16:37","Salir","Salida del sistema","ADMIN","","","","",),
("6","2022-11-27 05:17:04","Contestar Preguntas","Usuario respondio preguntas de seguridad","DOCTOR","","","","",),
("7","2022-11-27 05:17:15","Cambiar contraseña","Cambia contraseña","DOCTOR","","","","",),
("8","2022-11-27 05:17:24","Login","Ingreso al sistema","DOCTOR","","","","",),
("9","2022-11-27 05:21:14","Editar datos de perfil","DOCTOR modifico sus datos de perfil","DOCTOR","","","","",),
("10","2022-11-27 05:21:27","Editar datos de perfil","DOCTOR modifico sus datos de perfil","DOCTOR","","","","",),
("11","2022-11-27 05:24:38","Administrador preguntas","Entro a Administración preguntas","DOCTOR","","","","",),
("12","2022-11-27 05:24:59","Nueva pregunta","Creo nueva pregunta","DOCTOR","","","","",),
("13","2022-11-27 05:32:20","Editar datos de perfil","ADMIN modifico sus datos de perfil","ADMIN","","","","",),
("14","2022-11-27 05:32:45","Salir","Salida del sistema","ADMIN","","","","",),
("15","2022-11-27 05:32:55","Login","Ingreso al sistema","DOCTOR","","","","",),
("16","2022-11-27 05:34:34","Administrador de usuario","Entro a Administración de usuarios","DOCTOR","","","","",),
("17","2022-11-27 05:34:57","Administrador de permisos","Entro a Administración de Permisos","DOCTOR","","","","",),
("18","2022-11-27 05:35:39","Salir","Salida del sistema","DOCTOR","","","","",),
("19","2022-11-27 07:33:15","Login","Ingreso al sistema","ADMIN","","","","",),
("20","2022-11-27 07:38:01","Inicio","Entro al Inicio","ADMIN","","","","",),
("21","2022-11-27 07:38:08","Administrador objeto","Entro a Administración objeto","ADMIN","","","","",),
("22","2022-11-27 07:39:16","Nuevo Objeto","Creo nuevo objeto ADMINISTRACION FACTURA","ADMIN","","","","",),
("23","2022-11-27 07:39:40","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("24","2022-11-27 07:41:58","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("25","2022-11-27 07:42:24","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("26","2022-11-27 07:42:55","Actualizo un permiso","Permiso actualizado","ADMIN","","","","",),
("27","2022-11-27 07:43:10","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("28","2022-11-27 07:49:31","Inicio","Entro al Inicio","ADMIN","","","","",),
("29","2022-11-27 07:50:56","Administrador objeto","Entro a Administración objeto","ADMIN","","","","",),
("30","2022-11-27 07:53:41","Nuevo Objeto","Creo nuevo objeto ADMINISTRACIÓN FACTURA DETALLE","ADMIN","","","","",),
("31","2022-11-27 07:54:06","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("32","2022-11-27 07:54:25","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("33","2022-11-27 07:54:34","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("34","2022-11-27 08:01:48","Nuevo Objeto","Creo nuevo objeto PERFIL USUARIO","ADMIN","","","","",),
("35","2022-11-27 08:02:15","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("36","2022-11-27 08:02:30","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("37","2022-11-27 08:02:46","Creo nuevo permiso","Permiso nuevo","ADMIN","","","","",),
("38","2022-11-27 08:04:41","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("39","2022-11-27 08:21:27","Salir","Salida del sistema","ADMIN","","","","",),
("40","2022-11-27 08:35:02","Login","Ingreso al sistema","DOCTOR","","","","",),
("41","2022-11-27 08:42:40","Bitacora","Entro a la Bitacora","DOCTOR","","","","",),
("42","2022-11-27 08:46:13","Bitacora","Entro a la Bitacora","DOCTOR","","","","",);



DROP TABLE IF EXISTS tbl_ms_estado;

CREATE TABLE `tbl_ms_estado` (
  `ID_ESTADO` int NOT NULL AUTO_INCREMENT,
  `ESTADO` varchar(20) NOT NULL,
  `ESTADO1` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_ESTADO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_estado VALUES("1","ACTIVO","ACTIVO",),
("2","NUEVO","ACTIVO",),
("3","DEFAULT","ACTIVO",),
("4","BLOQUEADO","ACTIVO",),
("5","INACTIVO","ACTIVO",);



DROP TABLE IF EXISTS tbl_ms_genero;

CREATE TABLE `tbl_ms_genero` (
  `ID_GENERO` int NOT NULL AUTO_INCREMENT,
  `GENERO` varchar(20) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_GENERO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_genero VALUES("1","MASCULINO","ACTIVO",),
("2","FEMENINO","ACTIVO",);



DROP TABLE IF EXISTS tbl_ms_historial_password;

CREATE TABLE `tbl_ms_historial_password` (
  `ID_HISTORIAL` int NOT NULL AUTO_INCREMENT,
  `PASSWORD` varchar(15) NOT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  `ID_USUARIO` int NOT NULL,
  PRIMARY KEY (`ID_HISTORIAL`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `tbl_ms_historial_password_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_ms_usuario` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_historial_password VALUES("1","Edu10_","DOCTOR","2022-11-27","","","2",);



DROP TABLE IF EXISTS tbl_ms_objetos;

CREATE TABLE `tbl_ms_objetos` (
  `ID_OBJETO` int NOT NULL AUTO_INCREMENT,
  `OBJETO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `TIPO_OBJETO` varchar(50) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_OBJETO`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_objetos VALUES("1","INICIO","PANTALLA INICIO","PANTALLA","","","","","",),
("2","FACTURA","PANTALLA DE FACTURA","PANTALLA","","","","","",),
("3","PARAMETROS","PANTALLA DE PARAMETROS","PANTALLA","","","","","",),
("4","BITACORA","PANTALLA BITACORA","PANTALLA","","","","","",),
("5","ADMINISTRACION USUARIO","PANTALLA USUARIOS","PANTALLA","","","","","",),
("6","ADMINISTRACION CLIENTES","PANTALLA CLIENTES","PANTALLA","","","","","",),
("7","ADMINISTRACION PRODUCTOS","PANTALLA PRODUCTOS","PANTALLA","","","","","",),
("8","ADMINISTRACION PROMOCION","PANTALLA PROMOCION","PANTALLA","","","","","",),
("9","ADMINISTRACION DESCUENTO","PANTALLA DESCUENTO","PANTALLA","","","","","",),
("10","ADMINISTRACION TIPO PEDIDO","PANTALLA TIPO PEDIDO","PANTALLA","","","","","",),
("11","ADMINISTRACION SUCURSAL","PANTALLA SUCURSAL","PANTALLA","","","","","",),
("12","ADMINISTRACION SUCURSAL PROMOCION","PANTALLA SUCURSAL PROMOCION","PANTALLA","","","","","",),
("13","ADMINISTRACION CONFIGURACION CAI","PANTALLA CONFIGURACION CAI","PANTALLA","","","","","",),
("14","ADMINISTRACION OBJETO","PANTALLA OBJETO","PANTALLA","","","","","",),
("15","ADMINISTRACION ROLES","PANTALLA ROLES","PANTALLA","","","","","",),
("16","ADMINISTRACION PERMISOS","PANTALLA PERMISOS","PANTALLA","","","","","",),
("17","ADMINISTRACION FACTURA DESCUENTO","PANTALLA FACTURA DESCUENTO","PANTALLA","","","","","",),
("18","ADMINISTRACIÓN FACTURA PROMOCION","PANTALLA FACTURA PROMOCION","PANTALLA","","","","","",),
("19","ADMINISTRACIÓN PREGUNTAS","PANTALLA PREGUNTAS","PANTALLA","","","","","",),
("20","ADMINISTRACIÓN ESTADO","PANTALLA ESTADO","PANTALLA","","","","","",),
("21","ADMINISTRACIÓN GENERO","PANTALLA GENERO","PANTALLA","","","","","",),
("22","ADMINISTRACION FACTURA","PANTALLA ADMINISTRACION FACTURA","PANTALLA","ACTIVO","","","","",),
("23","ADMINISTRACIÓN FACTURA DETALLE","PANTALLA FACTURA DETALLE","PANTALLA","ACTIVO","","","","",),
("24","PERFIL USUARIO","PANTALLA PERFIL USUARIO","PANTALLA","ACTIVO","","","","",);



DROP TABLE IF EXISTS tbl_ms_parametros;

CREATE TABLE `tbl_ms_parametros` (
  `ID_PARAMETRO` int NOT NULL AUTO_INCREMENT,
  `PARAMETRO` varchar(50) DEFAULT NULL,
  `VALOR` varchar(100) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_PARAMETRO`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_parametros VALUES("1","ADMIN_INTENTO","3","ACTIVO","","","","",),
("2","ADMIN_PREGUNTAS","3","ACTIVO","","","","",),
("3","MAX_PASSWORD","15","ACTIVO","","","","",),
("4","MIN_PASSWORD","5","ACTIVO","","","","",),
("5","ADMIN_DIAS_VIGENCIAS","360","ACTIVO","","","","",),
("6","ADMIN_CORREO","coffeeandre1201@gmail.com","ACTIVO","","","","",),
("7","ADMIN_CPUERTO","587","ACTIVO","","","","",),
("8","ADMIN_CUSER","coffeeandre1201@gmail.com","ACTIVO","","","","",),
("9","ADMIN_CPASS","bupgcormkrhugibc","ACTIVO","","","","",),
("10","ADMIN_VIGENCIA","5","ACTIVO","","","","",),
("11","NOMBRE_NEGOCIO","Andrés Coffee","ACTIVO","","","","",),
("12","LOGO_NEGOCIO","Logo.png","ACTIVO","","","","",),
("13","TELEFONO_NEGOCIO","98672309","ACTIVO","","","","",),
("14","CORRO_NEGOCIO","coffeeandre1201@gmail.com","ACTIVO","","","","",),
("15","IMPUESTO SOBRE LA VENTA","15","ACTIVO","","","","",);



DROP TABLE IF EXISTS tbl_ms_permisos;

CREATE TABLE `tbl_ms_permisos` (
  `ID_ROL` int NOT NULL,
  `ID_OBJETO` int NOT NULL,
  `PERMISO_VISUALIZAR` varchar(20) DEFAULT NULL,
  `PERMISO_INSERTAR` varchar(20) DEFAULT NULL,
  `PERMISO_ACTUALIZAR` varchar(20) DEFAULT NULL,
  `PERMISO_ELIMINAR` varchar(20) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`,`ID_OBJETO`),
  KEY `ID_OBJETO` (`ID_OBJETO`),
  CONSTRAINT `tbl_ms_permisos_ibfk_1` FOREIGN KEY (`ID_ROL`) REFERENCES `tbl_ms_roles` (`ID_ROL`),
  CONSTRAINT `tbl_ms_permisos_ibfk_2` FOREIGN KEY (`ID_OBJETO`) REFERENCES `tbl_ms_objetos` (`ID_OBJETO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_permisos VALUES("1","1","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("1","2","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","3","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("1","4","PERMITIR","PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("1","5","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","6","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","7","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","8","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","9","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","10","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","11","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","12","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","13","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","14","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("1","15","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("1","16","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("1","17","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","18","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","19","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","20","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("1","21","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","22","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","23","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("1","24","PERMITIR","NO PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("2","1","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","2","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("2","3","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","4","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","5","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","6","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("2","7","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("2","8","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","9","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","10","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","11","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","12","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","13","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","14","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","15","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","16","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","17","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","18","PERMITIR","PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","19","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","20","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","21","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("2","22","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("2","23","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("2","24","PERMITIR","NO PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("3","1","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","2","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","3","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","4","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","5","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","6","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","7","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","8","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","9","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","10","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","11","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","12","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","13","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","14","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","15","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","16","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","17","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","18","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","19","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","20","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","21","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","22","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","23","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("3","24","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("4","1","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","2","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","3","PERMITIR","PERMITIR","PERMITIR","NO PERMITIR","","","","",),
("4","4","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","5","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","6","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","7","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","8","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","9","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","10","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","11","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","12","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","13","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","14","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","15","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","16","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","17","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","18","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","19","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","20","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","21","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","22","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","23","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",),
("4","24","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",);



DROP TABLE IF EXISTS tbl_ms_preguntas;

CREATE TABLE `tbl_ms_preguntas` (
  `ID_PREGUNTA` int NOT NULL AUTO_INCREMENT,
  `PREGUNTA` varchar(100) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_PREGUNTA`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_preguntas VALUES("1","¿CUÁL ES EL NOMBRE DE TU MASCOTA?","ACTIVO","","","","",),
("2","¿CUÁL ES TU COLOR FAVORITO?","ACTIVO","","","","",),
("3","¿CUÁL ES EL PRIMER NOMBRE DE TU ABUELO?","ACTIVO","","","","",),
("4","¿CUÁL ES LA CIUDAD DÓNDE NACISTE?","ACTIVO","","","","",),
("5","¿CUÁL ES TU EQUIPO FAVORITO?","ACTIVO","","","","",);



DROP TABLE IF EXISTS tbl_ms_preguntas_usuario;

CREATE TABLE `tbl_ms_preguntas_usuario` (
  `ID_PREGUNTA` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `RESPUESTA` varchar(20) NOT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_PREGUNTA`,`ID_USUARIO`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `tbl_ms_preguntas_usuario_ibfk_1` FOREIGN KEY (`ID_PREGUNTA`) REFERENCES `tbl_ms_preguntas` (`ID_PREGUNTA`),
  CONSTRAINT `tbl_ms_preguntas_usuario_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_ms_usuario` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_preguntas_usuario VALUES("1","2","","DOCTOR","2022-11-27","","",),
("2","2","AZUL","DOCTOR","2022-11-27","","",),
("4","2","TEGUS","DOCTOR","2022-11-27","","",);



DROP TABLE IF EXISTS tbl_ms_roles;

CREATE TABLE `tbl_ms_roles` (
  `ID_ROL` int NOT NULL AUTO_INCREMENT,
  `ROL` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_roles VALUES("1","ADMIN","ROL ADMINISTRADOR","ACTIVO","","","","",),
("2","EMPLEADO","ROL EMPLEADO","ACTIVO","","","","",),
("3","SIN ASIGNAR","ROL SIN ASIGNAR","ACTIVO","","","","",),
("4","SUPERADMIN","ROL SUPER ADMIN","ACTIVO","","","","",);



DROP TABLE IF EXISTS tbl_ms_token;

CREATE TABLE `tbl_ms_token` (
  `ID_TOKEN` int NOT NULL AUTO_INCREMENT,
  `TOKEN` varchar(10) NOT NULL,
  `FECHA_VENCIMIENTO` datetime NOT NULL,
  `ID_USUARIO` int NOT NULL,
  PRIMARY KEY (`ID_TOKEN`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `tbl_ms_token_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_ms_usuario` (`ID_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_ms_usuario;

CREATE TABLE `tbl_ms_usuario` (
  `ID_USUARIO` int NOT NULL AUTO_INCREMENT,
  `NOMBRES` varchar(60) DEFAULT NULL,
  `IDENTIDAD` bigint(13) unsigned zerofill DEFAULT NULL,
  `GENERO` varchar(20) DEFAULT NULL,
  `TELEFONO` bigint DEFAULT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `CORREO` varchar(50) DEFAULT NULL,
  `USUARIO` varchar(20) DEFAULT NULL,
  `PASSWORD` varchar(15) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `PREGUNTAS_CONTESTADAS` int DEFAULT NULL,
  `PRIMER_INGRESO` date DEFAULT NULL,
  `CREADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_CREACION` date DEFAULT NULL,
  `FECHA_ULTIMA_CONEXION` date DEFAULT NULL,
  `FECHA_VENCIMIENTO` date DEFAULT NULL,
  `MODIFICADO_POR` varchar(50) DEFAULT NULL,
  `FECHA_MODIFICACION` date DEFAULT NULL,
  `ID_ROL` int NOT NULL,
  `ID_BITACORA` int DEFAULT NULL,
  `ID_SUCURSAL` int DEFAULT NULL,
  `ID_CONFIGURACION_CAI` int DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  UNIQUE KEY `USUARIO` (`USUARIO`),
  KEY `ID_ROL` (`ID_ROL`),
  KEY `ID_SUCURSAL` (`ID_SUCURSAL`),
  KEY `ID_CONFIGURACION_CAI` (`ID_CONFIGURACION_CAI`),
  CONSTRAINT `tbl_ms_usuario_ibfk_1` FOREIGN KEY (`ID_ROL`) REFERENCES `tbl_ms_roles` (`ID_ROL`),
  CONSTRAINT `tbl_ms_usuario_ibfk_2` FOREIGN KEY (`ID_SUCURSAL`) REFERENCES `tbl_sucursal` (`ID_SUCURSAL`),
  CONSTRAINT `tbl_ms_usuario_ibfk_3` FOREIGN KEY (`ID_CONFIGURACION_CAI`) REFERENCES `tbl_configuracion_cai` (`ID_CONFIGURACION_CAI`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_usuario VALUES("1","ADMINISTRADOR","","","","","","ADMIN","1234","ACTIVO","","2022-11-27","","","2022-11-27","","","","1","","","",),
("2","DENNIS RAMIREZ","0801200021912","MASCULINO","32421221","CENTROAMERICA","ia158ft1@gmail.com","DOCTOR","Edu10_","ACTIVO","3","2022-11-27","ADMIN","2022-11-27","2022-11-27","2023-11-22","DOCTOR","2022-11-27","1","","","",);



DROP TABLE IF EXISTS tbl_producto;

CREATE TABLE `tbl_producto` (
  `ID_PRODUCTO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) NOT NULL,
  `TIPO` varchar(40) NOT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUCTO`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_producto VALUES("1","EXPRESO AMERICANO","FRIO","56.00","",),
("2","MACCHIATO","FRIO","45.00","ACTIVO",),
("3","FRAPPÉ","FRIO","36.00","ACTIVO",),
("4","ICED TEAS","FRIO","60.00","ACTIVO",),
("5","CHOCOLATE","CALIENTE","35.00","ACTIVO",),
("6","MATE","FRIO","47.00","ACTIVO",),
("7","TÉS ORGANICOS","CALIENTE","70.00","ACTIVO",),
("8","CAFÉ LATTE","CALIENTE","32.00","ACTIVO",),
("9","PANCAKES","POSTRES","40.00","ACTIVO",),
("10","CREPES","POSTRES","65.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_promocion;

CREATE TABLE `tbl_promocion` (
  `ID_PROMOCION` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PROMOCION`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_promocion VALUES("1","FERIPAZ","145.00","ACTIVO",),
("2","MOTHER DAY","180.00","ACTIVO",),
("3","COFFEE NAVIDEÑOS","155.00","ACTIVO",),
("4","CHILDREN\'S DAY","119.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_sucursal;

CREATE TABLE `tbl_sucursal` (
  `ID_SUCURSAL` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_SUCURSAL`),
  UNIQUE KEY `NOMBRE` (`NOMBRE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_sucursal VALUES("1","SUCURSAL PRINCIPAL","LA PAZ, MEDIA CUADRA AL NORTE DE LA UNIVERSIDA POLITECNICA DE HONDURAS","ACTIVO",),
("2","SUCURSAL FRENTE DEL PARQUE PRINCIPAL","LA PAZ, FRENTE AL PARQUE CENTRAL, AL PAR DE AGUAS LA PAZ","ACTIVO",);



DROP TABLE IF EXISTS tbl_sucursal_promocion;

CREATE TABLE `tbl_sucursal_promocion` (
  `ID_SUCURSAL` int NOT NULL,
  `ID_PROMOCION` int NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_SUCURSAL`,`ID_PROMOCION`),
  KEY `ID_PROMOCION` (`ID_PROMOCION`),
  CONSTRAINT `tbl_sucursal_promocion_ibfk_1` FOREIGN KEY (`ID_SUCURSAL`) REFERENCES `tbl_sucursal` (`ID_SUCURSAL`),
  CONSTRAINT `tbl_sucursal_promocion_ibfk_2` FOREIGN KEY (`ID_PROMOCION`) REFERENCES `tbl_promocion` (`ID_PROMOCION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS tbl_tipo_pedido;

CREATE TABLE `tbl_tipo_pedido` (
  `ID_TIPO_PEDIDO` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(40) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPO_PEDIDO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_tipo_pedido VALUES("1","PARA CONSUMIR EN LOCAL","ACTIVO",),
("2","PARA LLEVAR","ACTIVO",);



