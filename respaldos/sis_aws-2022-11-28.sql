DROP TABLE IF EXISTS tbl_cliente;

CREATE TABLE `tbl_cliente` (
  `ID_CLIENTE` int NOT NULL AUTO_INCREMENT,
  `NOMBRES` varchar(60) DEFAULT NULL,
  `IDENTIDAD` bigint(13) unsigned zerofill DEFAULT NULL,
  `GENERO` varchar(20) DEFAULT NULL,
  `TELEFONO` bigint DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_CLIENTE`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_cliente VALUES("1","CLIENTE FRECUENTE","0000000000000","SIN SEXO","0","ACTIVO",),
("2","RAUL ALVAREZ","0801199812829","MASCULINO","97862881","ACTIVO",),
("3","LUIS AYALA","0801199812587","MASCULINO","97862554","ACTIVO",),
("4","DENNIS RAMOS","0801200012569","MASCULINO","97862551","ACTIVO",),
("5","JULIO BERCIAN","0801198426584","MASCULINO","97862551","ACTIVO",),
("6","KAREN LAGOS","0801199805806","FEMENINO","97862551","ACTIVO",),
("7","JOSE RAUL","0801197425987","MASCULINO","97862893","ACTIVO",);



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_descuento VALUES("1","SIN DESCUENTO","0.00","ACTIVO",),
("2","DESCUENTO DE LA TERCERA EDAD","10.00","ACTIVO",),
("3","DESCUENTO POR EL GASTO DE 300 LPS","7.00","ACTIVO",),
("4","DESCUENTO NAVIDEÑO","5.00","ACTIVO",),
("5","DESCUENTO ESTUDIANTE","2.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_detalle_prom_temp;

CREATE TABLE `tbl_detalle_prom_temp` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PROMOCION` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_VENTA` decimal(8,2) NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;




DROP TABLE IF EXISTS tbl_detalle_temp;

CREATE TABLE `tbl_detalle_temp` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_VENTA` decimal(8,2) NOT NULL,
  `TOTAL` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;




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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_factura VALUES("1","2022-11-27 10:16:49","","466.00","69.90","46.60","489.30","500.00","10.70","2","1","1","1","ACTIVO",),
("2","2022-11-27 10:19:21","","900.00","135.00","0.00","1035.00","1100.00","65.00","1","1","2","1","ACTIVO",),
("3","2022-11-27 11:24:09","","72.00","10.80","7.20","75.60","100.00","24.40","1","1","2","1","INACTIVO",),
("4","2022-11-28 12:31:02","","72.00","10.80","0.00","82.80","95.00","12.20","1","1","2","1","ACTIVO",),
("5","2022-11-28 12:41:24","","610.00","91.50","61.00","640.50","650.00","9.50","1","1","1","2","ACTIVO",),
("6","2022-11-28 07:08:14","","70.00","10.50","0.00","80.50","90.00","9.50","1","1","2","1","ACTIVO",),
("7","2022-11-28 08:01:19","","105.00","15.75","0.00","120.75","200.00","79.25","1","1","2","1","ACTIVO",),
("8","2022-11-28 01:05:14","","510.00","76.50","51.00","535.50","600.00","64.50","1","1","2","2","ACTIVO",),
("9","2022-11-28 02:12:08","","360.00","54.00","0.00","414.00","550.00","136.00","1","1","2","1","ACTIVO",),
("10","2022-11-28 02:33:41","","442.00","66.30","0.00","508.30","600.00","91.70","1","1","2","1","ACTIVO",),
("11","2022-11-28 02:36:03","","432.00","64.80","0.00","496.80","500.00","3.20","1","5","2","1","ACTIVO",),
("12","2022-11-28 04:16:16","","120.00","18.00","2.40","135.60","200.00","64.40","1","2","2","1","ACTIVO",),
("13","2022-11-28 04:59:17","","36.00","5.40","0.00","41.40","50.00","8.60","1","1","2","1","ACTIVO",),
("14","2022-11-28 05:04:10","","70.00","10.50","0.00","80.50","90.00","9.50","1","6","2","1","ACTIVO",),
("15","2022-11-28 05:47:33","","70.00","10.50","1.40","79.10","80.00","0.90","1","1","1","2","ACTIVO",),
("16","2022-11-28 05:47:59","","45.00","6.75","0.00","51.75","60.00","8.25","1","1","1","2","INACTIVO",),
("17","2022-11-28 06:47:41","","450.00","67.50","9.00","508.50","600.00","91.50","1","1","1","2","ACTIVO",);



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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_factura_descuento VALUES("1","46.60","2","1","ACTIVO",),
("2","7.20","2","3","ACTIVO",),
("3","7.20","1","3","ACTIVO",),
("4","61.00","2","5","ACTIVO",),
("5","51.00","2","8","ACTIVO",),
("6","2.40","5","12","ACTIVO",),
("7","9.00","5","17","ACTIVO",);



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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_factura_detalle VALUES("1","1","36.00","36.00","ACTIVO","1","3","",),
("2","2","35.00","70.00","ACTIVO","1","5","",),
("3","2","180.00","360.00","ACTIVO","1","","2",),
("4","5","180.00","900.00","ACTIVO","2","","2",),
("5","2","36.00","72.00","ACTIVO","3","3","",),
("6","2","36.00","72.00","ACTIVO","3","3","",),
("7","2","35.00","70.00","ACTIVO","5","5","",),
("8","3","180.00","540.00","ACTIVO","5","","2",),
("9","2","35.00","70.00","ACTIVO","6","5","",),
("10","3","35.00","105.00","ACTIVO","7","5","",),
("11","3","50.00","150.00","ACTIVO","8","11","",),
("12","2","180.00","360.00","ACTIVO","8","","2",),
("13","2","180.00","360.00","ACTIVO","9","","2",),
("14","1","50.00","50.00","ACTIVO","10","11","",),
("15","1","32.00","32.00","ACTIVO","10","8","",),
("16","2","180.00","360.00","ACTIVO","10","","2",),
("17","2","36.00","72.00","ACTIVO","11","3","",),
("18","2","180.00","360.00","ACTIVO","11","","2",),
("19","2","30.00","60.00","ACTIVO","12","12","",),
("20","1","60.00","60.00","ACTIVO","12","","5",),
("21","1","36.00","36.00","ACTIVO","13","3","",),
("22","2","35.00","70.00","ACTIVO","6","5","",),
("23","2","35.00","70.00","ACTIVO","6","5","",),
("24","1","45.00","45.00","ACTIVO","16","2","",),
("25","4","50.00","200.00","ACTIVO","17","11","",),
("26","10","20.00","200.00","ACTIVO","17","13","",),
("27","1","30.00","30.00","ACTIVO","17","12","",),
("28","2","10.00","20.00","ACTIVO","17","","6",);



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_factura_promocion VALUES("1","2","360.00","1","2","ACTIVO",),
("2","5","900.00","2","2","ACTIVO",),
("3","3","540.00","5","2","ACTIVO",),
("4","2","360.00","8","2","ACTIVO",),
("5","2","360.00","9","2","ACTIVO",),
("6","2","360.00","10","2","ACTIVO",),
("7","2","360.00","11","2","ACTIVO",),
("8","1","60.00","12","5","ACTIVO",),
("9","2","20.00","17","6","ACTIVO",);



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
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_bitacora VALUES("1","2022-11-27 10:14:35","Login","Ingreso al sistema","ADMIN","","","","",),
("2","2022-11-27 10:14:53","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("3","2022-11-27 10:15:04","Login","Ingreso al sistema","ADMIN","","","","",),
("4","2022-11-27 10:15:10","Administrador de producto","Entro a Administración de Producto","ADMIN","","","","",),
("5","2022-11-27 10:15:11","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("6","2022-11-27 10:15:12","Administrador de descuento","Entro a Administración de descuento","ADMIN","","","","",),
("7","2022-11-27 10:23:36","Administrador de parametros","Entro a Administración de Parametros","ADMIN","","","","",),
("8","2022-11-27 10:23:38","Inicio","Entro al Inicio","ADMIN","","","","",),
("9","2022-11-27 10:23:39","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("10","2022-11-27 11:26:25","Inicio","Entro al Inicio","ADMIN","","","","",),
("11","2022-11-27 11:26:30","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("12","2022-11-27 11:34:56","Reporte Bitacora","Genero reporte especifico de bitacora","ADMIN","","","","",),
("13","2022-11-27 11:37:15","Login","Ingreso al sistema","ADMIN","","","","",),
("14","2022-11-27 11:37:17","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("15","2022-11-27 11:40:07","Backup del sistema","Genero backup del sistema","","","","","",),
("16","2022-11-27 11:40:12","Login","Ingreso al sistema","ADMIN","","","","",),
("17","2022-11-27 11:40:13","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("18","2022-11-27 11:42:02","Backup del sistema","Genero backup del sistema","ADMIN","","","","",),
("19","2022-11-27 11:42:06","Login","Ingreso al sistema","ADMIN","","","","",),
("20","2022-11-27 11:42:07","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("21","2022-11-27 11:59:04","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("22","2022-11-27 11:59:52","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("23","2022-11-28 12:00:52","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("24","2022-11-28 12:01:05","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("25","2022-11-28 12:01:10","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("26","2022-11-28 12:01:14","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("27","2022-11-28 12:01:26","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("28","2022-11-28 12:14:51","Reporte Factura","Genero reporte especifico de factura","ADMIN","","","","",),
("29","2022-11-28 12:22:03","Reporte Factura","Genero reporte especifico de factura","ADMIN","","","","",),
("30","2022-11-28 12:25:01","Inicio","Entro al Inicio","ADMIN","","","","",),
("31","2022-11-28 12:34:11","Login","Ingreso al sistema","ADMIN","","","","",),
("32","2022-11-28 12:34:22","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("33","2022-11-28 12:35:38","Crear usuario","Administrador creo un usuario nuevo","ADMIN","","","","",),
("34","2022-11-28 12:36:01","Salir","Salida del sistema","ADMIN","","","","",),
("35","2022-11-28 12:36:21","Contestar Preguntas","Usuario respondio preguntas de seguridad","RAUL","","","","",),
("36","2022-11-28 12:36:35","Cambiar contraseña","Cambia contraseña","RAUL","","","","",),
("37","2022-11-28 12:36:42","Login","Ingreso al sistema","RAUL","","","","",),
("38","2022-11-28 12:36:47","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("39","2022-11-28 12:37:00","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("40","2022-11-28 12:37:02","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("41","2022-11-28 12:37:10","Inicio","Entro al Inicio","RAUL","","","","",),
("42","2022-11-28 12:37:19","Administrador estado","Entro a Administración Estado","RAUL","","","","",),
("43","2022-11-28 12:37:25","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("44","2022-11-28 12:37:31","Administrador objeto","Entro a Administración objeto","RAUL","","","","",),
("45","2022-11-28 12:37:37","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("46","2022-11-28 12:37:42","Administrador objeto","Entro a Administración objeto","RAUL","","","","",),
("47","2022-11-28 12:37:52","Administrador genero","Entro a Administración genero","RAUL","","","","",),
("48","2022-11-28 12:38:26","Salir","Salida del sistema","RAUL","","","","",),
("49","2022-11-28 12:39:13","Login","Ingreso al sistema","RAUL","","","","",),
("50","2022-11-28 12:39:24","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("51","2022-11-28 12:41:04","Inicio","Entro al Inicio","RAUL","","","","",),
("52","2022-11-28 12:41:44","Administrador sucursal","Entro a Administración sucursal","RAUL","","","","",),
("53","2022-11-28 12:42:13","Administrador factura descuento","Entro a Administración factura descuento","RAUL","","","","",),
("54","2022-11-28 12:42:22","Administrador factura promocion","Entro a Administración factura promocion","RAUL","","","","",),
("55","2022-11-28 12:42:34","Administrador sucursal promocion","Entro a Administración sucursal promocion","RAUL","","","","",),
("56","2022-11-28 12:47:19","Login","Ingreso al sistema","ADMIN","","","","",),
("57","2022-11-28 12:47:21","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("58","2022-11-28 12:47:26","Actualizar","Administrador modifico datos de usuario RAUL","ADMIN","","","","",),
("59","2022-11-28 12:47:32","Salir","Salida del sistema","ADMIN","","","","",),
("60","2022-11-28 12:47:39","Login","Ingreso al sistema","RAUL","","","","",),
("61","2022-11-28 12:47:41","Administrador de parametros","Entro a Administración de Parametros","RAUL","","","","",),
("62","2022-11-28 12:48:10","Administrador de permisos","Entro a Administración de Permisos","RAUL","","","","",),
("63","2022-11-28 12:49:13","Actualizo un permiso","Permiso actualizado","RAUL","","","","",),
("64","2022-11-28 12:50:07","Inicio","Entro al Inicio","RAUL","","","","",),
("65","2022-11-28 12:50:09","Administrador de parametros","Entro a Administración de Parametros","RAUL","","","","",),
("66","2022-11-28 12:50:46","Inicio","Entro al Inicio","RAUL","","","","",),
("67","2022-11-28 12:52:44","Login","Ingreso al sistema","ADMIN","","","","",),
("68","2022-11-28 07:07:36","Login","Ingreso al sistema","ADMIN","","","","",),
("69","2022-11-28 07:07:39","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("70","2022-11-28 08:00:44","Login","Ingreso al sistema","ADMIN","","","","",),
("71","2022-11-28 08:00:48","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("72","2022-11-28 08:00:52","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("73","2022-11-28 08:03:43","Inicio","Entro al Inicio","ADMIN","","","","",),
("74","2022-11-28 08:03:59","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("75","2022-11-28 08:05:06","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("76","2022-11-28 08:06:43","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("77","2022-11-28 08:10:28","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("78","2022-11-28 08:11:21","Administrador de producto","Entro a Administración de Producto","ADMIN","","","","",),
("79","2022-11-28 08:11:26","Inicio","Entro al Inicio","ADMIN","","","","",),
("80","2022-11-28 08:11:29","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("81","2022-11-28 12:34:14","Login","Ingreso al sistema","ADMIN","","","","",),
("82","2022-11-28 12:34:23","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("83","2022-11-28 12:35:00","Inicio","Entro al Inicio","ADMIN","","","","",),
("84","2022-11-28 12:35:08","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("85","2022-11-28 12:35:16","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("86","2022-11-28 12:35:26","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("87","2022-11-28 12:35:38","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("88","2022-11-28 12:35:45","Administrador sucursal","Entro a Administración sucursal","ADMIN","","","","",),
("89","2022-11-28 12:35:55","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("90","2022-11-28 12:39:04","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("91","2022-11-28 12:39:16","Administrador de tipos de pedido","Entro a Administración de tipo pedido","ADMIN","","","","",),
("92","2022-11-28 12:39:25","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("93","2022-11-28 12:39:33","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("94","2022-11-28 12:40:05","Inicio","Entro al Inicio","ADMIN","","","","",),
("95","2022-11-28 12:47:54","Inicio","Entro al Inicio","ADMIN","","","","",),
("96","2022-11-28 12:48:04","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("97","2022-11-28 12:48:21","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("98","2022-11-28 12:48:37","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("99","2022-11-28 12:48:45","Salir","Salida del sistema","ADMIN","","","","",),
("100","2022-11-28 12:49:35","Login","Ingreso al sistema","RAUL","","","","",),
("101","2022-11-28 12:50:56","Editar datos de perfil","RAUL modifico sus datos de perfil","RAUL","","","","",),
("102","2022-11-28 12:51:45","Editar datos de perfil","RAUL modifico sus datos de perfil","RAUL","","","","",),
("103","2022-11-28 12:52:38","Inicio","Entro al Inicio","RAUL","","","","",),
("104","2022-11-28 12:52:47","Administrador de cliente","Entro a Administración de Cliente","RAUL","","","","",),
("105","2022-11-28 12:52:55","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("106","2022-11-28 12:53:09","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("107","2022-11-28 12:53:17","Administrador de descuento","Entro a Administración de descuento","RAUL","","","","",),
("108","2022-11-28 12:53:33","Administrador de tipos de pedido","Entro a Administración de tipo pedido","RAUL","","","","",),
("109","2022-11-28 12:54:16","Administrador sucursal","Entro a Administración sucursal","RAUL","","","","",),
("110","2022-11-28 12:54:23","Administrador factura","Entro a Administración factura","RAUL","","","","",),
("111","2022-11-28 12:54:48","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("112","2022-11-28 12:55:16","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("113","2022-11-28 12:55:19","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("114","2022-11-28 12:56:28","Administrador factura descuento","Entro a Administración factura descuento","RAUL","","","","",),
("115","2022-11-28 12:56:38","Administrador factura promocion","Entro a Administración factura promocion","RAUL","","","","",),
("116","2022-11-28 12:57:07","Administrador de configuracion cai","Entro a Administración de configuracion cai","RAUL","","","","",),
("117","2022-11-28 12:57:15","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("118","2022-11-28 12:58:08","Administrador estado","Entro a Administración Estado","RAUL","","","","",),
("119","2022-11-28 12:58:25","Administrador genero","Entro a Administración genero","RAUL","","","","",),
("120","2022-11-28 12:58:51","Administrador de parametros","Entro a Administración de Parametros","RAUL","","","","",),
("121","2022-11-28 12:59:12","Administrador objeto","Entro a Administración objeto","RAUL","","","","",),
("122","2022-11-28 12:59:33","Administrador de permisos","Entro a Administración de Permisos","RAUL","","","","",),
("123","2022-11-28 12:59:52","Administrador preguntas","Entro a Administración preguntas","RAUL","","","","",),
("124","2022-11-28 01:00:08","Administrador rol","Entro a Administración rol","RAUL","","","","",),
("125","2022-11-28 01:00:38","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("126","2022-11-28 01:01:09","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("127","2022-11-28 01:01:16","Administrador factura descuento","Entro a Administración factura descuento","RAUL","","","","",),
("128","2022-11-28 01:01:28","Administrador factura promocion","Entro a Administración factura promocion","RAUL","","","","",),
("129","2022-11-28 01:01:57","Inicio","Entro al Inicio","RAUL","","","","",),
("130","2022-11-28 01:02:12","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("131","2022-11-28 01:02:14","Inicio","Entro al Inicio","RAUL","","","","",),
("132","2022-11-28 01:02:18","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("133","2022-11-28 01:02:31","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("134","2022-11-28 01:03:07","Creo nuevo producto","Producto nuevo","RAUL","","","","",),
("135","2022-11-28 01:03:36","Inicio","Entro al Inicio","RAUL","","","","",),
("136","2022-11-28 01:03:37","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("137","2022-11-28 01:06:01","Inicio","Entro al Inicio","RAUL","","","","",),
("138","2022-11-28 01:06:02","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("139","2022-11-28 01:06:05","Administrador factura","Entro a Administración factura","RAUL","","","","",),
("140","2022-11-28 01:06:35","Inicio","Entro al Inicio","RAUL","","","","",),
("141","2022-11-28 01:06:36","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("142","2022-11-28 01:06:47","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("143","2022-11-28 01:06:59","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("144","2022-11-28 01:07:34","Inicio","Entro al Inicio","RAUL","","","","",),
("145","2022-11-28 01:08:01","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("146","2022-11-28 01:08:32","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("147","2022-11-28 01:09:11","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("148","2022-11-28 01:20:35","Inicio","Entro al Inicio","RAUL","","","","",),
("149","2022-11-28 01:21:14","Administrador factura","Entro a Administración factura","RAUL","","","","",),
("150","2022-11-28 01:26:29","Inicio","Entro al Inicio","RAUL","","","","",),
("151","2022-11-28 01:27:08","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("152","2022-11-28 01:27:19","Actualizar","Administrador modifico datos de usuario RAUL","RAUL","","","","",),
("153","2022-11-28 01:27:22","Inicio","Entro al Inicio","RAUL","","","","",),
("154","2022-11-28 01:27:23","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("155","2022-11-28 01:27:30","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("156","2022-11-28 01:27:42","Administrador de permisos","Entro a Administración de Permisos","RAUL","","","","",),
("157","2022-11-28 01:27:50","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("158","2022-11-28 01:27:59","Salir","Salida del sistema","RAUL","","","","",),
("159","2022-11-28 01:28:05","Login","Ingreso al sistema","ADMIN","","","","",),
("160","2022-11-28 01:28:15","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("161","2022-11-28 01:28:30","Inicio","Entro al Inicio","ADMIN","","","","",),
("162","2022-11-28 01:29:39","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("163","2022-11-28 01:30:31","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("164","2022-11-28 01:31:09","Inicio","Entro al Inicio","ADMIN","","","","",),
("165","2022-11-28 01:31:29","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("166","2022-11-28 01:34:03","Administrador de configuracion cai","Entro a Administración de configuracion cai","ADMIN","","","","",),
("167","2022-11-28 01:39:50","Inicio","Entro al Inicio","ADMIN","","","","",),
("168","2022-11-28 01:50:32","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("169","2022-11-28 01:50:45","Administrador sucursal","Entro a Administración sucursal","ADMIN","","","","",),
("170","2022-11-28 01:50:57","Reporte Sucursal","Genero reporte de sucursal","ADMIN","","","","",),
("171","2022-11-28 02:01:16","Inicio","Entro al Inicio","ADMIN","","","","",),
("172","2022-11-28 02:02:04","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("173","2022-11-28 02:03:46","Creo nuevo cliente","Cliente nuevo","ADMIN","","","","",),
("174","2022-11-28 02:03:55","Reporte Cliente","Genero reporte de cliente","ADMIN","","","","",),
("175","2022-11-28 02:07:52","Creo nuevo cliente","Cliente nuevo","ADMIN","","","","",),
("176","2022-11-28 02:08:46","Creo nuevo cliente","Cliente nuevo","ADMIN","","","","",),
("177","2022-11-28 02:08:56","Inicio","Entro al Inicio","ADMIN","","","","",),
("178","2022-11-28 02:08:57","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("179","2022-11-28 02:09:16","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("180","2022-11-28 02:11:12","Borrar factura","Se inactivo la factura ","ADMIN","","","","",),
("181","2022-11-28 02:11:17","Reporte Factura","Genero reporte de factura","ADMIN","","","","",),
("182","2022-11-28 02:11:20","Borrar factura","Se inactivo la factura ","ADMIN","","","","",),
("183","2022-11-28 02:15:44","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("184","2022-11-28 02:15:46","Borrar factura","Se inactivo la factura ","ADMIN","","","","",),
("185","2022-11-28 02:15:49","Inicio","Entro al Inicio","ADMIN","","","","",),
("186","2022-11-28 02:16:02","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("187","2022-11-28 02:16:33","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("188","2022-11-28 02:26:48","Administrador de parametros","Entro a Administración de Parametros","ADMIN","","","","",),
("189","2022-11-28 02:26:59","Administrador rol","Entro a Administración rol","ADMIN","","","","",),
("190","2022-11-28 02:27:13","Administrador objeto","Entro a Administración objeto","ADMIN","","","","",),
("191","2022-11-28 02:29:04","Administrador estado","Entro a Administración Estado","ADMIN","","","","",),
("192","2022-11-28 02:31:39","Administrador de configuracion cai","Entro a Administración de configuracion cai","ADMIN","","","","",),
("193","2022-11-28 02:32:36","Creo nuevo cliente","Cliente nuevo","ADMIN","","","","",),
("194","2022-11-28 02:33:20","Administrador de cliente","Entro a Administración de Cliente","ADMIN","","","","",),
("195","2022-11-28 03:03:03","Administrador de configuracion cai","Entro a Administración de configuracion cai","ADMIN","","","","",),
("196","2022-11-28 03:15:36","Administrador factura descuento","Entro a Administración factura descuento","ADMIN","","","","",),
("197","2022-11-28 03:15:49","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("198","2022-11-28 03:15:59","Administrador factura promocion","Entro a Administración factura promocion","ADMIN","","","","",),
("199","2022-11-28 03:17:02","Administrador de configuracion cai","Entro a Administración de configuracion cai","ADMIN","","","","",),
("200","2022-11-28 03:18:02","Inicio","Entro al Inicio","ADMIN","","","","",),
("201","2022-11-28 03:18:04","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("202","2022-11-28 03:18:32","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("203","2022-11-28 03:20:16","Administrador factura descuento","Entro a Administración factura descuento","ADMIN","","","","",),
("204","2022-11-28 03:21:54","Administrador factura promocion","Entro a Administración factura promocion","ADMIN","","","","",),
("205","2022-11-28 03:23:30","Administrador de configuracion cai","Entro a Administración de configuracion cai","ADMIN","","","","",),
("206","2022-11-28 04:03:18","Administrador factura descuento","Entro a Administración factura descuento","ADMIN","","","","",),
("207","2022-11-28 04:09:58","Inicio","Entro al Inicio","ADMIN","","","","",),
("208","2022-11-28 04:11:48","Salir","Salida del sistema","ADMIN","","","","",),
("209","2022-11-28 04:11:54","Login","Ingreso al sistema","RAUL","","","","",),
("210","2022-11-28 04:11:59","Administrador de usuario","Entro a Administración de usuarios","RAUL","","","","",),
("211","2022-11-28 04:12:07","Inicio","Entro al Inicio","RAUL","","","","",),
("212","2022-11-28 04:12:23","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("213","2022-11-28 04:12:59","Creo nuevo producto","Producto nuevo","RAUL","","","","",),
("214","2022-11-28 04:13:08","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("215","2022-11-28 04:13:17","Salir","Salida del sistema","RAUL","","","","",),
("216","2022-11-28 04:13:20","Login","Ingreso al sistema","ADMIN","","","","",),
("217","2022-11-28 04:13:26","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("218","2022-11-28 04:13:55","Creo nueva promocion","Promocion nueva","ADMIN","","","","",),
("219","2022-11-28 04:14:02","Administrador de descuento","Entro a Administración de descuento","ADMIN","","","","",),
("220","2022-11-28 04:14:44","Nuevo Descuento","Creo descuento DESCUENTO ESTUDIANTE","ADMIN","","","","",),
("221","2022-11-28 04:15:06","Inicio","Entro al Inicio","ADMIN","","","","",),
("222","2022-11-28 04:15:23","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("223","2022-11-28 04:21:36","Inicio","Entro al Inicio","ADMIN","","","","",),
("224","2022-11-28 04:23:23","Perfil Usuario","Entro a perfil usuario","ADMIN","","","","",),
("225","2022-11-28 04:23:29","Inicio","Entro al Inicio","ADMIN","","","","",),
("226","2022-11-28 04:23:33","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("227","2022-11-28 04:23:38","Inicio","Entro al Inicio","ADMIN","","","","",),
("228","2022-11-28 04:23:47","Perfil Usuario","Entro a perfil usuario","ADMIN","","","","",),
("229","2022-11-28 04:23:52","Salir","Salida del sistema","ADMIN","","","","",),
("230","2022-11-28 04:23:56","Login","Ingreso al sistema","RAUL","","","","",),
("231","2022-11-28 04:23:58","Perfil Usuario","Entro a perfil usuario","RAUL","","","","",),
("232","2022-11-28 04:33:12","Inicio","Entro al Inicio","RAUL","","","","",),
("233","2022-11-28 04:33:18","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("234","2022-11-28 04:33:35","Administrador factura","Entro a Administración factura","RAUL","","","","",),
("235","2022-11-28 04:34:10","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("236","2022-11-28 04:34:25","Administrador de tipos de pedido","Entro a Administración de tipo pedido","RAUL","","","","",),
("237","2022-11-28 04:34:31","Salir","Salida del sistema","RAUL","","","","",),
("238","2022-11-28 04:34:34","Login","Ingreso al sistema","ADMIN","","","","",),
("239","2022-11-28 04:34:38","Administrador de tipos de pedido","Entro a Administración de tipo pedido","ADMIN","","","","",),
("240","2022-11-28 04:34:47","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("241","2022-11-28 04:36:23","Administrador factura descuento","Entro a Administración factura descuento","ADMIN","","","","",),
("242","2022-11-28 04:36:27","Administrador factura promocion","Entro a Administración factura promocion","ADMIN","","","","",),
("243","2022-11-28 04:36:34","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("244","2022-11-28 04:36:39","Reporte Factura Promocion","Genero reporte de factura promocion","ADMIN","","","","",),
("245","2022-11-28 04:38:48","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("246","2022-11-28 04:38:56","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("247","2022-11-28 04:40:09","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("248","2022-11-28 04:41:28","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("249","2022-11-28 04:42:24","Administrador estado","Entro a Administración Estado","ADMIN","","","","",),
("250","2022-11-28 04:43:00","Administrador de parametros","Entro a Administración de Parametros","ADMIN","","","","",),
("251","2022-11-28 04:43:27","Administrador genero","Entro a Administración genero","ADMIN","","","","",),
("252","2022-11-28 04:43:56","Administrador objeto","Entro a Administración objeto","ADMIN","","","","",),
("253","2022-11-28 04:44:30","Administrador de permisos","Entro a Administración de Permisos","ADMIN","","","","",),
("254","2022-11-28 04:44:55","Administrador preguntas","Entro a Administración preguntas","ADMIN","","","","",),
("255","2022-11-28 04:45:16","Administrador rol","Entro a Administración rol","ADMIN","","","","",),
("256","2022-11-28 04:46:27","Administrador de promocion","Entro a Administración de Promocion","ADMIN","","","","",),
("257","2022-11-28 04:46:48","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("258","2022-11-28 04:46:55","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("259","2022-11-28 04:47:17","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("260","2022-11-28 04:48:43","Inicio","Entro al Inicio","ADMIN","","","","",),
("261","2022-11-28 04:48:47","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("262","2022-11-28 04:49:07","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("263","2022-11-28 04:49:12","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("264","2022-11-28 04:56:00","Inicio","Entro al Inicio","ADMIN","","","","",),
("265","2022-11-28 04:56:02","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("266","2022-11-28 05:03:20","Creo nuevo cliente desde la factura","Cliente nuevo en la factura","ADMIN","","","","",),
("267","2022-11-28 05:04:10","Finalizacion de factura","Genero factura","","","","","",),
("268","2022-11-28 05:04:17","Inicio","Entro al Inicio","ADMIN","","","","",),
("269","2022-11-28 05:04:23","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("270","2022-11-28 05:05:46","Inicio","Entro al Inicio","ADMIN","","","","",),
("271","2022-11-28 05:05:47","Facturacion","Entro a generar una factura","ADMIN","","","","",),
("272","2022-11-28 05:08:48","Creo nuevo cliente desde la factura","Cliente nuevo en la factura","ADMIN","","","","",),
("273","2022-11-28 05:09:13","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("274","2022-11-28 05:12:28","Administrador factura","Entro a Administración factura","ADMIN","","","","",),
("275","2022-11-28 05:29:20","Administrador de factura detalle","Entro a Administración de factura detalle","ADMIN","","","","",),
("276","2022-11-28 05:34:55","Inicio","Entro al Inicio","ADMIN","","","","",),
("277","2022-11-28 05:34:56","Facturacion","Entro a generar una factura","ADMIN","","","","",),
("278","2022-11-28 05:35:17","Inicio","Entro al Inicio","ADMIN","","","","",),
("279","2022-11-28 05:35:28","Administrador de tipos de pedido","Entro a Administración de tipo pedido","ADMIN","","","","",),
("280","2022-11-28 05:35:49","Nuevo Tipo de Pedido","Creo tipo de pedido AUTOSERVICIO","ADMIN","","","","",),
("281","2022-11-28 05:35:56","Administrador sucursal","Entro a Administración sucursal","ADMIN","","","","",),
("282","2022-11-28 05:36:09","Nueva Sucursal","Creo la sucursal SUCURSAL DE EJEMPLO","ADMIN","","","","",),
("283","2022-11-28 05:36:19","Borrar sucursal","Se inactivo la sucursal SUCURSAL DE EJEMPLO","ADMIN","","","","",),
("284","2022-11-28 05:36:26","Administrador de tipos de pedido","Entro a Administración de tipo pedido","ADMIN","","","","",),
("285","2022-11-28 05:36:34","Inicio","Entro al Inicio","ADMIN","","","","",),
("286","2022-11-28 05:36:41","Administrador sucursal","Entro a Administración sucursal","ADMIN","","","","",),
("287","2022-11-28 05:38:17","Borrar sucursal","Se inactivo la sucursal SUCURSAL DE EJEMPLO","ADMIN","","","","",),
("288","2022-11-28 05:39:25","Borrar tipo pedido","Se inactivo el tipo pedido AUTOSERVICIO","ADMIN","","","","",),
("289","2022-11-28 05:39:37","Inicio","Entro al Inicio","ADMIN","","","","",),
("290","2022-11-28 05:40:20","Perfil Usuario","Entro a perfil usuario","ADMIN","","","","",),
("291","2022-11-28 05:40:24","Salir","Salida del sistema","ADMIN","","","","",),
("292","2022-11-28 05:40:27","Login","Ingreso al sistema","RAUL","","","","",),
("293","2022-11-28 05:40:32","Perfil Usuario","Entro a perfil usuario","RAUL","","","","",),
("294","2022-11-28 05:44:48","Editar datos de perfil","RAUL modifico sus datos de perfil","RAUL","","","","",),
("295","2022-11-28 05:45:23","Inicio","Entro al Inicio","RAUL","","","","",),
("296","2022-11-28 05:45:24","Facturacion","Entro a generar una factura","RAUL","","","","",),
("297","2022-11-28 05:45:42","Inicio","Entro al Inicio","RAUL","","","","",),
("298","2022-11-28 05:45:45","Perfil Usuario","Entro a perfil usuario","RAUL","","","","",),
("299","2022-11-28 05:46:01","Editar datos de perfil","RAUL modifico sus datos de perfil","RAUL","","","","",),
("300","2022-11-28 05:46:17","Editar datos de perfil","RAUL modifico sus datos de perfil","RAUL","","","","",),
("301","2022-11-28 05:46:45","Inicio","Entro al Inicio","RAUL","","","","",),
("302","2022-11-28 05:46:47","Facturacion","Entro a generar una factura","RAUL","","","","",),
("303","2022-11-28 05:47:17","Administrador de descuento","Entro a Administración de descuento","RAUL","","","","",),
("304","2022-11-28 05:47:34","Finalizacion de factura","Genero factura","","","","","",),
("305","2022-11-28 05:48:00","Finalizacion de factura","Genero factura","","","","","",),
("306","2022-11-28 05:48:13","Inicio","Entro al Inicio","RAUL","","","","",),
("307","2022-11-28 05:48:35","Administrador de tipos de pedido","Entro a Administración de tipo pedido","RAUL","","","","",),
("308","2022-11-28 05:48:41","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("309","2022-11-28 05:48:46","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("310","2022-11-28 05:48:55","Inicio","Entro al Inicio","RAUL","","","","",),
("311","2022-11-28 05:49:00","Salir","Salida del sistema","RAUL","","","","",),
("312","2022-11-28 05:49:03","Login","Ingreso al sistema","ADMIN","","","","",),
("313","2022-11-28 05:49:14","Administrador de usuario","Entro a Administración de usuarios","ADMIN","","","","",),
("314","2022-11-28 05:50:24","Crear usuario","Administrador creo un usuario nuevo","ADMIN","","","","",),
("315","2022-11-28 05:50:48","Actualizar","Administrador modifico datos de usuario RAUL","ADMIN","","","","",),
("316","2022-11-28 05:52:28","Inicio","Entro al Inicio","ADMIN","","","","",),
("317","2022-11-28 05:52:40","Bitacora","Entro a la Bitacora","ADMIN","","","","",),
("318","2022-11-28 05:53:19","Backup del sistema","Genero backup del sistema","ADMIN","","","","",),
("319","2022-11-28 05:58:21","Login","Ingreso al sistema","RAUL","","","","",),
("320","2022-11-28 05:58:28","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("321","2022-11-28 05:58:35","Reporte Factura Promocion","Genero reporte de factura promocion","RAUL","","","","",),
("322","2022-11-28 05:59:12","Reporte Factura Promocion","Genero reporte de factura promocion","RAUL","","","","",),
("323","2022-11-28 05:59:19","Reporte Factura Promocion","Genero reporte especifico de factura promocion","RAUL","","","","",),
("324","2022-11-28 05:59:29","Inicio","Entro al Inicio","RAUL","","","","",),
("325","2022-11-28 05:59:37","Salir","Salida del sistema","RAUL","","","","",),
("326","2022-11-28 05:59:55","Login","Ingreso al sistema","RAUL","","","","",),
("327","2022-11-28 05:59:59","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("328","2022-11-28 06:00:19","Salir","Salida del sistema","RAUL","","","","",),
("329","2022-11-28 06:06:14","Login","Ingreso al sistema","RAUL","","","","",),
("330","2022-11-28 06:06:23","Bitacora","Entro a la Bitacora","RAUL","","","","",),
("331","2022-11-28 06:07:03","Reporte Bitacora","Genero reporte bitacora","RAUL","","","","",),
("332","2022-11-28 06:07:37","Reporte Bitacora","Genero reporte especifico de bitacora","RAUL","","","","",),
("333","2022-11-28 06:07:46","Inicio","Entro al Inicio","RAUL","","","","",),
("334","2022-11-28 06:09:38","Salir","Salida del sistema","RAUL","","","","",),
("335","2022-11-28 06:23:39","Login","Ingreso al sistema","RAUL","","","","",),
("336","2022-11-28 06:23:45","Administrador genero","Entro a Administración genero","RAUL","","","","",),
("337","2022-11-28 06:23:54","Nuevo Genero","Creo nuevo genero OTRO","RAUL","","","","",),
("338","2022-11-28 06:24:03","Actualizar Genero","Actualizo genero OTROS","RAUL","","","","",),
("339","2022-11-28 06:24:10","Reporte Genero","Genero reporte de genero","RAUL","","","","",),
("340","2022-11-28 06:24:31","Reporte Genero","Genero reporte especifico de genero","RAUL","","","","",),
("341","2022-11-28 06:24:45","Borrar genero","Se inactivo el genero OTROS","RAUL","","","","",),
("342","2022-11-28 06:25:02","Actualizar Genero","Actualizo genero OTROS","RAUL","","","","",),
("343","2022-11-28 06:25:16","Administrador de factura detalle","Entro a Administración de factura detalle","RAUL","","","","",),
("344","2022-11-28 06:25:22","Administrador factura","Entro a Administración factura","RAUL","","","","",),
("345","2022-11-28 06:25:57","Borrar factura","Se inactivo la factura ","RAUL","","","","",),
("346","2022-11-28 06:26:12","Finalizacion de factura","Genero factura","","","","","",),
("347","2022-11-28 06:26:17","Borrar factura","Se inactivo la factura ","RAUL","","","","",),
("348","2022-11-28 06:26:56","Reporte Factura","Genero reporte especifico de factura","RAUL","","","","",),
("349","2022-11-28 06:27:04","Reporte Factura","Genero reporte de factura","RAUL","","","","",),
("350","2022-11-28 06:27:20","Administrador rol","Entro a Administración rol","RAUL","","","","",),
("351","2022-11-28 06:27:33","Nuevo Rol","Creo nuevo rol PRUEBA","RAUL","","","","",),
("352","2022-11-28 06:29:43","Administrador de producto","Entro a Administración de Producto","RAUL","","","","",),
("353","2022-11-28 06:31:28","Creo nuevo producto","Producto nuevo","RAUL","","","","",),
("354","2022-11-28 06:32:02","Actualizo producto","Producto actualizado","RAUL","","","","",),
("355","2022-11-28 06:32:17","Borrar producto","Se inactivo el producto PRUEBA","RAUL","","","","",),
("356","2022-11-28 06:32:42","Borrar producto","Se inactivo el producto FRAPPÉ","RAUL","","","","",),
("357","2022-11-28 06:34:42","Reporte Producto","Genero reporte de producto","RAUL","","","","",),
("358","2022-11-28 06:35:08","Administrador de promocion","Entro a Administración de Promocion","RAUL","","","","",),
("359","2022-11-28 06:38:41","Creo nueva promocion","Promocion nueva","RAUL","","","","",),
("360","2022-11-28 06:38:55","Facturacion","Entro a generar una factura","RAUL","","","","",),
("361","2022-11-28 06:39:02","Inicio","Entro al Inicio","RAUL","","","","",),
("362","2022-11-28 06:39:16","Facturacion","Entro a generar una factura","RAUL","","","","",),
("363","2022-11-28 06:47:41","Finalizacion de factura","Genero factura","","","","","",),
("364","2022-11-28 06:54:36","Inicio","Entro al Inicio","RAUL","","","","",),
("365","2022-11-28 06:54:55","Administrador objeto","Entro a Administración objeto","RAUL","","","","",),
("366","2022-11-28 06:56:26","Nuevo Objeto","Creo nuevo objeto PRUEBA","RAUL","","","","",),
("367","2022-11-28 06:56:40","Reporte Objeto","Genero reporte de objeto","RAUL","","","","",),
("368","2022-11-28 06:57:11","Administrador de permisos","Entro a Administración de Permisos","RAUL","","","","",),
("369","2022-11-28 06:58:40","Creo nuevo permiso","Permiso nuevo","RAUL","","","","",),
("370","2022-11-28 06:59:07","Bitacora","Entro a la Bitacora","RAUL","","","","",);



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_genero VALUES("1","MASCULINO","ACTIVO",),
("2","FEMENINO","ACTIVO",),
("3","OTROS","ACTIVO",);



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

INSERT INTO tbl_ms_historial_password VALUES("1","Raul1-","RAUL","2022-11-28","","","2",);



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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_objetos VALUES("1","INICIO","PANTALLA INICIO","PANTALLA","ACTIVO","","","","",),
("2","FACTURA","PANTALLA DE FACTURA","PANTALLA","ACTIVO","","","","",),
("3","PARAMETROS","PANTALLA DE PARAMETROS","PANTALLA","ACTIVO","","","","",),
("4","BITACORA","PANTALLA BITACORA","PANTALLA","ACTIVO","","","","",),
("5","ADMINISTRACION USUARIO","PANTALLA USUARIOS","PANTALLA","ACTIVO","","","","",),
("6","ADMINISTRACION CLIENTES","PANTALLA CLIENTES","PANTALLA","ACTIVO","","","","",),
("7","ADMINISTRACION PRODUCTOS","PANTALLA PRODUCTOS","PANTALLA","ACTIVO","","","","",),
("8","ADMINISTRACION PROMOCION","PANTALLA PROMOCION","PANTALLA","ACTIVO","","","","",),
("9","ADMINISTRACION DESCUENTO","PANTALLA DESCUENTO","PANTALLA","ACTIVO","","","","",),
("10","ADMINISTRACION TIPO PEDIDO","PANTALLA TIPO PEDIDO","PANTALLA","ACTIVO","","","","",),
("11","ADMINISTRACION SUCURSAL","PANTALLA SUCURSAL","PANTALLA","ACTIVO","","","","",),
("12","ADMINISTRACION SUCURSAL PROMOCION","PANTALLA SUCURSAL PROMOCION","PANTALLA","ACTIVO","","","","",),
("13","ADMINISTRACION CONFIGURACION CAI","PANTALLA CONFIGURACION CAI","PANTALLA","ACTIVO","","","","",),
("14","ADMINISTRACION OBJETO","PANTALLA OBJETO","PANTALLA","ACTIVO","","","","",),
("15","ADMINISTRACION ROLES","PANTALLA ROLES","PANTALLA","ACTIVO","","","","",),
("16","ADMINISTRACION PERMISOS","PANTALLA PERMISOS","PANTALLA","ACTIVO","","","","",),
("17","ADMINISTRACION FACTURA DESCUENTO","PANTALLA FACTURA DESCUENTO","PANTALLA","ACTIVO","","","","",),
("18","ADMINISTRACIÓN FACTURA PROMOCION","PANTALLA FACTURA PROMOCION","PANTALLA","ACTIVO","","","","",),
("19","ADMINISTRACIÓN PREGUNTAS","PANTALLA PREGUNTAS","PANTALLA","ACTIVO","","","","",),
("20","ADMINISTRACIÓN ESTADO","PANTALLA ESTADO","PANTALLA","ACTIVO","","","","",),
("21","ADMINISTRACIÓN GENERO","PANTALLA GENERO","PANTALLA","ACTIVO","","","","",),
("22","ADMINISTRACIÓN FACTURA","PANTALLA ADMINISTRACION FACTURA","PANTALLA","ACTIVO","","","","",),
("23","ADMINISTRACIÓN FACTURA DETALLE","PANTALLA FACTURA DETALLE","PANTALLA","ACTIVO","","","","",),
("24","PERFIL USUARIO","PANTALLA PERFIL USUARIO","PANTALLA","ACTIVO","","","","",),
("25","PRUEBA","PRUEBA","PRUEBA","ACTIVO","","","","",);



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
("1","3","PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
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
("4","24","NO PERMITIR","NO PERMITIR","NO PERMITIR","NO PERMITIR","","","","",),
("5","1","PERMITIR","PERMITIR","PERMITIR","PERMITIR","","","","",);



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_preguntas_usuario VALUES("1","2","BLAKY","RAUL","2022-11-28","","",),
("2","2","EJM","RAUL","2022-11-28","","",),
("3","2","EJM","RAUL","2022-11-28","","",);



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_roles VALUES("1","ADMIN","ROL ADMINISTRADOR","ACTIVO","","","","",),
("2","EMPLEADO","ROL EMPLEADO","ACTIVO","","","","",),
("3","SIN ASIGNAR","ROL SIN ASIGNAR","ACTIVO","","","","",),
("4","SUPERADMIN","ROL SUPER ADMIN","ACTIVO","","","","",),
("5","PRUEBA","PRUEBA","ACTIVO","","","","",);



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_ms_usuario VALUES("1","","","","","","","ADMIN","AndresCoffee+1","ACTIVO","","2022-11-27","","","2022-11-28","","","","4","","","",),
("2","RAUL ANTONIO ALVAREZ LAGOS","0801199812829","MASCULINO","97862881","RES. LA CANADA","raul98antonio@gmail.com","RAUL","123","ACTIVO","3","2022-11-28","ADMIN","2022-11-28","2022-11-28","2023-11-23","ADMIN","2022-11-28","1","","","",),
("3","EDUARDO FONSECA","0801199812825","MASCULINO","97581474","RES. EL CENTRO","eduardo.fonseca@unah.hn","EDU","Edu1+","NUEVO","","","ADMIN","2022-11-28","","2023-11-23","","","2","","","",);



DROP TABLE IF EXISTS tbl_producto;

CREATE TABLE `tbl_producto` (
  `ID_PRODUCTO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(60) NOT NULL,
  `TIPO` varchar(40) NOT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUCTO`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_producto VALUES("1","EXPRESO AMERICANO","FRIO","56.00","INACTIVO",),
("2","MACCHIATO","FRIO","45.00","ACTIVO",),
("3","FRAPPÉ","FRIO","36.00","INACTIVO",),
("4","ICED TEAS","FRIO","60.00","ACTIVO",),
("5","CHOCOLATE","CALIENTE","35.00","ACTIVO",),
("6","MATE","FRIO","47.00","ACTIVO",),
("7","TÉS ORGANICOS","CALIENTE","70.00","ACTIVO",),
("8","CAFÉ LATTE","CALIENTE","32.00","ACTIVO",),
("9","PANCAKES","POSTRES","40.00","ACTIVO",),
("10","CREPES","POSTRES","65.00","ACTIVO",),
("11","CAFE AMERICANO","CALIENTE","50.00","ACTIVO",),
("12","CAFE CON LECHE","HELADO","30.00","ACTIVO",),
("13","PRUEBA","HELADO","20.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_promocion;

CREATE TABLE `tbl_promocion` (
  `ID_PROMOCION` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `PRECIO` decimal(8,2) NOT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PROMOCION`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_promocion VALUES("1","FERIPAZ","145.00","ACTIVO",),
("2","MOTHER DAY","180.00","ACTIVO",),
("3","COFFEE NAVIDEÑOS","155.00","ACTIVO",),
("4","CHILDREN\'S DAY","119.00","ACTIVO",),
("5","COFFEE DOBLE","60.00","ACTIVO",),
("6","PRUEBA","10.00","ACTIVO",);



DROP TABLE IF EXISTS tbl_sucursal;

CREATE TABLE `tbl_sucursal` (
  `ID_SUCURSAL` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_SUCURSAL`),
  UNIQUE KEY `NOMBRE` (`NOMBRE`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_sucursal VALUES("1","SUCURSAL PRINCIPAL","LA PAZ, MEDIA CUADRA AL NORTE DE LA UNIVERSIDA POLITECNICA DE HONDURAS","ACTIVO",),
("2","SUCURSAL FRENTE DEL PARQUE PRINCIPAL","LA PAZ, FRENTE AL PARQUE CENTRAL, AL PAR DE AGUAS LA PAZ","ACTIVO",),
("3","SUCURSAL DE EJEMPLO","EJEMPLO","INACTIVO",);



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO tbl_tipo_pedido VALUES("1","PARA CONSUMIR EN LOCAL","ACTIVO",),
("2","PARA LLEVAR","ACTIVO",),
("3","AUTOSERVICIO","INACTIVO",);



