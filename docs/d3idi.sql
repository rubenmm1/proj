-- --------------------------------------------------------
-- Host:                         192.168.0.100
-- Versión del servidor:         10.11.2-MariaDB - Source distribution
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para d3idi
CREATE DATABASE IF NOT EXISTS `d3idi` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci */;
USE `d3idi`;

-- Volcando estructura para tabla d3idi.albaranes
CREATE TABLE IF NOT EXISTS `albaranes` (
  `cod_albaran` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL DEFAULT 0,
  `importe_neto` decimal(20,2) NOT NULL DEFAULT 0.00,
  `importe_descuento` decimal(20,2) NOT NULL DEFAULT 0.00,
  `iva` int(11) NOT NULL DEFAULT 0,
  `re` float NOT NULL DEFAULT 0,
  `tarifa` int(11) NOT NULL DEFAULT 0,
  `tiempos_pago_valor` float NOT NULL DEFAULT 0,
  `tiempos_pago_texto` varchar(255) NOT NULL DEFAULT '0',
  `factura` varchar(50) NOT NULL DEFAULT '',
  `observaciones` text NOT NULL,
  `cod_serie` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_albaran`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.albaranes: ~0 rows (aproximadamente)
DELETE FROM `albaranes`;
INSERT INTO `albaranes` (`cod_albaran`, `fecha`, `id_cliente`, `importe_neto`, `importe_descuento`, `iva`, `re`, `tarifa`, `tiempos_pago_valor`, `tiempos_pago_texto`, `factura`, `observaciones`, `cod_serie`) VALUES
	('AOB22-0001', '2022-03-21', 1, 500.00, 470.00, 21, 5.4, 1, -5, 'Pago anticipado del total', 'FOB22-0003', 'Duplicado del presupuesto: POB22-0002\n', 1),
	('ASA22-0003', '2022-03-16', 1, 1365.99, 1284.03, 21, 0, 1, -5, 'Pago anticipado del total', 'FSA22-0003', '', 2),
	('ASU22-0001', '2022-03-16', 1, 1238.60, 1164.28, 21, 0, 1, -5, 'Pago anticipado del total', 'FSU22-0001', '', 3),
	('ASU23-0001', '2023-01-16', 9, 2036.60, 2179.16, 21, 5.2, 3, 10, 'Pago al año', '', 'Vamos que nos vamos\n', 3);

-- Volcando estructura para tabla d3idi.albaranes_lineas
CREATE TABLE IF NOT EXISTS `albaranes_lineas` (
  `cod_albaranes_lineas` int(11) NOT NULL AUTO_INCREMENT,
  `id_albaran` varchar(50) NOT NULL DEFAULT '',
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT '',
  `precio_unitario` decimal(20,2) DEFAULT NULL,
  `desc_linea` int(11) DEFAULT 0,
  `subtotal` decimal(20,2) DEFAULT NULL COMMENT '= precio_unitario * cantidad - desc_linea',
  PRIMARY KEY (`cod_albaranes_lineas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.albaranes_lineas: ~0 rows (aproximadamente)
DELETE FROM `albaranes_lineas`;
INSERT INTO `albaranes_lineas` (`cod_albaranes_lineas`, `id_albaran`, `id_articulo`, `cantidad`, `descripcion`, `precio_unitario`, `desc_linea`, `subtotal`) VALUES
	(100, 'ASA22-0003', 2, 1, '', 1356.00, 0, 1356.00),
	(101, 'ASA22-0003', 5, 1, '', 9.99, 0, 9.99),
	(105, 'ASU22-0001', 1, 1, '', 719.00, 0, 719.00),
	(106, 'ASU22-0001', 2, 1, '', 500.00, 0, 500.00),
	(107, 'ASU22-0001', 15, 1, 'Hora de trabajo útil de un operario con categoría de Oficial', 20.00, 2, 19.60),
	(109, 'AOB22-0001', 2, 1, '', 500.00, 0, 500.00),
	(110, 'ASU23-0001', 1, 1, '', 919.00, 0, 919.00),
	(111, 'ASU23-0001', 2, 1, '', 1000.00, 0, 1000.00),
	(112, 'ASU23-0001', 15, 1, 'Hora de trabajo útil de un operario con categoría de Oficial', 120.00, 2, 117.60);

-- Volcando estructura para tabla d3idi.articulos
CREATE TABLE IF NOT EXISTS `articulos` (
  `cod_articulo` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL COMMENT '1- Maquina, 2- Incidencia, 3- Material',
  `activo` int(11) DEFAULT NULL,
  `precio` decimal(20,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_articulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.articulos: ~0 rows (aproximadamente)
DELETE FROM `articulos`;
INSERT INTO `articulos` (`cod_articulo`, `nombre`, `descripcion`, `tipo`, `activo`, `precio`, `foto`, `categoria`) VALUES
	(1, 'HISENSE de 6.192 frig. AUD71UX4RFCL4 Clase A++', 'Su aire acondicionado centralizado por conductos Inverter marca HISENSE modelo AUD71UX4RFCL4 con nuevo refrigerante R32 con bomba de calor y una potencia frigorífica de 6.192 frigorías con clasificación energética A++ y un nivel sonoro de sólo 34 db. ', 1, 1, 919.00, NULL, 2),
	(2, 'LG de 5.848 frig. CONFORT CM24F/UUB1 Clase A 2 con R32', 'Su aire acondicionado Centralizado por Conductos Inverter con bomba de calor de la marca LG modelo CONFORT CM24F.N10/UUB1.U20 con refrigerante R32 y una potencia frigorífica de 5.848 frigorías con clasificación energética A  además de un nivel sonoro de sólo 32 db. en modo de funcionamiento bajo en unidad interior.', 1, 1, 1356.00, NULL, 2),
	(5, 'Restauración del filtro', 'esta es algo nuevo', 2, 1, 9.99, NULL, 1),
	(13, 'Nuevo con imagen', 'Maquina nuevaaaa', 1, 1, 195.25, NULL, NULL),
	(15, 'varios', '', 2, 1, 0.00, NULL, NULL),
	(16, 'Split WIND TC4 de 2700 frigorías', 'Aire acondicionado Split WIND TC4 de 2700 frigorías', 1, 1, 299.00, NULL, NULL),
	(17, 'Mitsubishi 71zs04 2600 3x1720 fg', 'Aire acondicionado 4x1 mitsubishi 71zs04 2600 3x1720 fg', 1, 1, 599.00, NULL, NULL),
	(18, 'asdfasdf', 'vrvr', 1, 0, 12.00, NULL, NULL),
	(19, 'DFgdjisdpojkdsfdfd ', 'Maquina nextpyme', 1, 1, 800.00, NULL, NULL),
	(20, 'refirgerante R32', 'Gas refrigerante de tipo fluido bla blsa blas', 3, 1, 20.00, NULL, NULL);

-- Volcando estructura para tabla d3idi.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `cod_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) DEFAULT NULL,
  `activo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.categorias: ~0 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`cod_categoria`, `nombre_categoria`, `activo`) VALUES
	(1, 'Oxidacion', '1'),
	(2, 'Instalacion pared', '1'),
	(3, 'Recubrimiento', '1'),
	(4, 'Maquinaria', '1');

-- Volcando estructura para tabla d3idi.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `cod_cliente` int(11) NOT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cif` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `cp` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  `iva` int(11) DEFAULT NULL,
  `re` float DEFAULT NULL,
  `id_tarifa` int(11) DEFAULT NULL,
  `plano` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.clientes: ~0 rows (aproximadamente)
DELETE FROM `clientes`;
INSERT INTO `clientes` (`cod_cliente`, `razon_social`, `nombre`, `cif`, `direccion`, `cp`, `telefono`, `email`, `poblacion`, `provincia`, `usuario`, `login`, `pass`, `activo`, `iva`, `re`, `id_tarifa`, `plano`) VALUES
	(1, 'Nextpyme S.A', 'Carlos Martín', '48819640R', 'Calle Cromo 53 Segundo A', '41007', '954638841', 'nextpyme@nextpyme.com', 'Sevilla', '954638841', 'nextpyme', 'nextpyme', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 21, 5.4, 1, NULL),
	(3, 'Hiprosol S.L.', 'Hiprosol', 'B36698895', 'cromo 51', '', '958784896', 'hiprosol@nextpyme.com', 'Sevilla', '958784896', NULL, 'hiprosol', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 1, 21, 0, 1, NULL),
	(4, 'Ferson Electrónica', 'Ferson', 'B28879687', 'Calle Pamplona', '', '954698878', 'nxp@nxp.com', 'Camas', 'Sevilla', NULL, 'ferson', '2ff8d791c5c6ab933e1d40226d7e8b6dcfee265b', 1, 10, 0, 1, NULL),
	(6, 'Nextpyme SL', 'Carlos', '27317326L', 'C/Hasta arriba vamos 23', '41900', '954565656', 'nextpyme@nextpyme.com', 'Sevilla', '954565656', NULL, 'nextpyme', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 10, 5.2, 1, NULL),
	(7, 'GT Castillo', 'Antonio Castillo', 'B48965369', 'calle cromo', '41500', '958747417', 'castillo@castillo.com', 'Sevilla', 'Sevilla', NULL, 'castillo', 'ecc6359964a7b74e3c09e122905a7c13b80d72ae', 1, 21, 0, 1, NULL),
	(9, 'ARPO SA', 'Fernando Mancha', 'B568348538', 'C/kansas city 21', '41900', '945345445', 'fmancha@arpo--sa.com', 'SEvilla', '945345445', NULL, 'arpo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 10, 5.2, 1, ''),
	(11, 'Hiprosol S.L.', 'online', '4989845R', 'cromo', '41900', 'vfev3433', 'admin', 'Sevilla', 'Sevilla', NULL, 'javi0228', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 10, 5.2, 1, NULL),
	(17, 'Ferson Electrónica', '', 'B36698895', '', '41900', '954967938', 'javi@gmial.com', '', '', NULL, 'javi0228', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 21, 0, 2, 'plano_17.png');

-- Volcando estructura para tabla d3idi.contadores
CREATE TABLE IF NOT EXISTS `contadores` (
  `descripcion` varchar(50) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.contadores: ~0 rows (aproximadamente)
DELETE FROM `contadores`;
INSERT INTO `contadores` (`descripcion`, `contador`) VALUES
	('clientes', 25),
	('articulos', 20),
	('usuarios', 2),
	('maquinas', 35),
	('presupuestos', 9),
	('albaranes', 12),
	('facturas', 14),
	('pagos', 37),
	('restificativas', 3),
	('revisiones', 117),
	('incidencias', 26),
	('series', 5);

-- Volcando estructura para tabla d3idi.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `cod_factura` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL DEFAULT 0,
  `importe_neto` decimal(20,2) NOT NULL DEFAULT 0.00,
  `importe_descuento` decimal(20,2) NOT NULL DEFAULT 0.00,
  `iva` int(11) NOT NULL DEFAULT 0,
  `re` float NOT NULL DEFAULT 0,
  `tarifa` int(11) NOT NULL DEFAULT 0,
  `tiempos_pago_valor` float NOT NULL DEFAULT 0,
  `tiempos_pago_texto` varchar(50) NOT NULL DEFAULT '0',
  `pagado` int(11) NOT NULL DEFAULT 0,
  `observaciones` text NOT NULL,
  `id_serie` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.facturas: ~0 rows (aproximadamente)
DELETE FROM `facturas`;
INSERT INTO `facturas` (`cod_factura`, `fecha`, `id_cliente`, `importe_neto`, `importe_descuento`, `iva`, `re`, `tarifa`, `tiempos_pago_valor`, `tiempos_pago_texto`, `pagado`, `observaciones`, `id_serie`) VALUES
	('FOB22-0003', '2022-03-21', 1, 500.00, 470.00, 21, 5.4, 1, -5, 'Pago anticipado del total', 0, '\nDuplicado del presupuesto: POB22-0002\n', 0),
	('FR23-0003', '2023-01-30', 1, -1365.99, -1284.03, 21, 0, 1, -5, 'Pago anticipado del total', 0, 'Abono factura FSA22-0003: \n', 0),
	('FSA22-0003', '2022-03-16', 1, 1365.99, 1284.03, 21, 5.4, 1, -5, 'Pago anticipado del total', 0, '\n', 2),
	('FSU22-0001', '2022-03-16', 1, 1238.60, 1164.28, 21, 5.4, 1, -5, 'Pago anticipado del total', 1, '\n', 3);

-- Volcando estructura para tabla d3idi.facturas_lineas
CREATE TABLE IF NOT EXISTS `facturas_lineas` (
  `cod_facturas_lineas` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` varchar(50) NOT NULL DEFAULT '',
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_unitario` decimal(20,2) DEFAULT NULL,
  `desc_linea` int(11) DEFAULT 0,
  `subtotal` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`cod_facturas_lineas`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.facturas_lineas: ~0 rows (aproximadamente)
DELETE FROM `facturas_lineas`;
INSERT INTO `facturas_lineas` (`cod_facturas_lineas`, `id_factura`, `id_articulo`, `cantidad`, `descripcion`, `precio_unitario`, `desc_linea`, `subtotal`) VALUES
	(61, 'FSA22-0003', 2, 1, '', 1356.00, 0, 1356.00),
	(62, 'FSA22-0003', 5, 1, '', 9.99, 0, 9.99),
	(63, 'FSU22-0001', 1, 1, '', 719.00, 0, 719.00),
	(64, 'FSU22-0001', 2, 1, '', 500.00, 0, 500.00),
	(65, 'FSU22-0001', 15, 1, 'Hora de trabajo útil de un operario con categoría de Oficial', 20.00, 2, 19.60),
	(68, 'FOB22-0003', 2, 1, '', 500.00, 0, 500.00),
	(69, 'FR23-0003', 2, -1, '', 1356.00, 0, -1356.00),
	(70, 'FR23-0003', 5, -1, '', 9.99, 0, -9.99);

-- Volcando estructura para tabla d3idi.incidencias
CREATE TABLE IF NOT EXISTS `incidencias` (
  `cod_incidencia` int(11) NOT NULL,
  `id_revision` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`cod_incidencia`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla d3idi.incidencias: ~14 rows (aproximadamente)
DELETE FROM `incidencias`;
INSERT INTO `incidencias` (`cod_incidencia`, `id_revision`, `id_cliente`, `fecha`, `descripcion`) VALUES
	(7, 23, 1, '2022-06-20', 'Incidencia n1'),
	(8, 26, 1, '2023-01-12', 'Incidencia en el salon'),
	(9, 27, 1, '2023-01-13', ''),
	(10, 60, 9, '2023-03-24', ''),
	(11, 65, 1, '2024-04-10', 'rewteagd'),
	(12, 51, 1, '2024-04-12', 'test'),
	(13, 67, 1, '2024-04-12', ''),
	(14, 70, 1, '2024-04-12', 'Test incidencia'),
	(15, 53, 1, '2024-04-12', 'test'),
	(16, 69, 1, '2024-04-12', ''),
	(17, 71, 1, '2024-04-12', 'asdf'),
	(18, 77, 17, '2024-04-12', ''),
	(19, 76, 17, '2024-04-12', 'Descripción de prueba para ver si se sube el presupuesto'),
	(20, 75, 17, '2024-04-12', 'dafasdfasfa'),
	(21, 110, 1, '2024-04-15', 'axsdfasdf'),
	(22, 98, 1, '2024-04-15', 'asdf'),
	(23, 104, 1, '2024-04-15', ''),
	(24, 100, 1, '2024-04-15', 'asdfasdf'),
	(25, 113, 1, '2024-04-16', 'descripcion incidencia'),
	(26, 116, 1, '2024-04-18', 'Filtro en mal estado, oxido\nManguito picado');

-- Volcando estructura para tabla d3idi.incidencias_fotos
CREATE TABLE IF NOT EXISTS `incidencias_fotos` (
  `cod_incidencias_fotos` int(11) NOT NULL AUTO_INCREMENT,
  `id_incidencia` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) NOT NULL DEFAULT '0',
  `descripcion_foto` text DEFAULT NULL,
  PRIMARY KEY (`cod_incidencias_fotos`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla d3idi.incidencias_fotos: ~16 rows (aproximadamente)
DELETE FROM `incidencias_fotos`;
INSERT INTO `incidencias_fotos` (`cod_incidencias_fotos`, `id_incidencia`, `foto`, `descripcion_foto`) VALUES
	(89, 8, 'fondo2.jpg', ''),
	(163, 10, 'image001.png', ''),
	(164, 11, 'cabecera.jpg', ''),
	(165, 12, '1 (5).jpg', ''),
	(166, 12, '1 (4).jpg', ''),
	(169, 14, '1 (4).jpg', ''),
	(170, 14, '1 (6).jpg', ''),
	(172, 15, '1 (4).jpg', ''),
	(173, 17, '1 (3).jpg', ''),
	(174, 19, 'isotipo.png', ''),
	(175, 20, 'isotipo-blanco.png', ''),
	(176, 21, '1 (1).jpg', ''),
	(178, 22, '1 (3).jpg', ''),
	(180, 24, '1 (1).jpg', ''),
	(203, 25, '1 (4).jpg', ''),
	(204, 25, '1 (6).jpg', ''),
	(211, 26, '1 (4).jpg', '');

-- Volcando estructura para tabla d3idi.incidencias_lineas
CREATE TABLE IF NOT EXISTS `incidencias_lineas` (
  `cod_incidencias_lineas` int(11) NOT NULL AUTO_INCREMENT,
  `id_incidencia` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`cod_incidencias_lineas`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.incidencias_lineas: ~17 rows (aproximadamente)
DELETE FROM `incidencias_lineas`;
INSERT INTO `incidencias_lineas` (`cod_incidencias_lineas`, `id_incidencia`, `id_articulo`, `cantidad`, `descripcion`) VALUES
	(4, 8, 5, 1, ''),
	(5, 8, 15, 1, ''),
	(51, 7, 5, 1, 'cewcew'),
	(52, 7, 5, 2, 'de'),
	(53, 11, 5, 3, ''),
	(56, 14, 5, 1, ''),
	(57, 14, 15, 1, ''),
	(60, 15, 15, 1, ''),
	(61, 15, 5, 1, ''),
	(62, 19, 5, 3, 'wdcw'),
	(63, 20, 15, 4, 'fasfafasd'),
	(64, 21, 5, 1, ''),
	(66, 24, 5, 1, ''),
	(67, 24, 5, 15, ''),
	(68, 24, 5, 10, 'necesita reparación'),
	(96, 25, 5, 2, 'filtro picado'),
	(97, 25, 15, 5, 'reparacion manguito\n'),
	(112, 26, 5, 10, 'Filtros en mal estado de oxido'),
	(113, 26, 15, 5, 'Manguitos picados');

-- Volcando estructura para tabla d3idi.maquinas
CREATE TABLE IF NOT EXISTS `maquinas` (
  `cod_maquina` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `nombre_maquina` varchar(255) DEFAULT NULL,
  `descripcion_maquina` varchar(255) DEFAULT NULL,
  `nserie` varchar(255) DEFAULT NULL,
  `activa` int(11) DEFAULT 1,
  `posicion_plano_x` int(4) unsigned DEFAULT NULL COMMENT 'Coordenada X de posicion en el plano',
  `posicion_plano_y` int(4) unsigned DEFAULT NULL COMMENT 'Coordenada Y de posicion en el plano',
  PRIMARY KEY (`cod_maquina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.maquinas: ~12 rows (aproximadamente)
DELETE FROM `maquinas`;
INSERT INTO `maquinas` (`cod_maquina`, `id_cliente`, `id_articulo`, `nombre_maquina`, `descripcion_maquina`, `nserie`, `activa`, `posicion_plano_x`, `posicion_plano_y`) VALUES
	(1, 1, 1, 'Aire central', 'Este aire esta colocado en la habitación principal', '9855845368', 1, NULL, NULL),
	(2, 1, 2, 'Segundo aire', 'Solo se usa cuando se estropea el primero', '555878488', 1, NULL, NULL),
	(3, 1, 13, 'Nuva maquina', 'Esta máquina está en el salon', '985586365468', 0, NULL, NULL),
	(4, 1, 1, 'Segunda maquina', 'segunda máquina hisense', '25154558548', 1, NULL, NULL),
	(5, 1, 1, 'LG planta 25', 'Estará en la planta 25', '268413874.84', 1, NULL, NULL),
	(12, 1, 13, 'Prueba', 'dfasdfasd543645634564536', '2342342', 0, NULL, NULL),
	(15, 6, 17, 'Pasillo 2', '123', '23432334', 1, NULL, NULL),
	(22, 10, 1, 'luis', '123', 'aac', 0, NULL, NULL),
	(23, 10, 16, 'nueva', 'nueva maquina', '12', 0, NULL, NULL),
	(32, 0, 19, ' luis', 'ejemplo ruben', 'aac', 0, NULL, NULL),
	(33, 17, 1, 'Hola', '2134', 'hola123', 1, 168, 57),
	(34, 17, 13, 'Hola', 'asdf', 'hola123', 1, 102, 41),
	(35, 17, 17, 'asdf', 'asdf', 'asdf', 1, 50, 40);

-- Volcando estructura para tabla d3idi.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `cod_pago` int(11) NOT NULL,
  `id_factura` varchar(50) NOT NULL DEFAULT '0',
  `id_tipo_pago` int(11) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `pago` decimal(20,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`cod_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.pagos: ~0 rows (aproximadamente)
DELETE FROM `pagos`;
INSERT INTO `pagos` (`cod_pago`, `id_factura`, `id_tipo_pago`, `fecha`, `pago`) VALUES
	(34, 'FA22-0014', 3, '2022-03-07', 9474.36),
	(36, 'FSU22-0001', 1, '2023-01-16', 1471.65);

-- Volcando estructura para tabla d3idi.presupuestos
CREATE TABLE IF NOT EXISTS `presupuestos` (
  `cod_presupuesto` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL DEFAULT 0,
  `importe_neto` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'importe neto con solo los descuentos lineas',
  `importe_descuento` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'importe con el descuento tarifa',
  `iva` int(11) NOT NULL DEFAULT 0 COMMENT 'Se guardará el valor en % del IVA aplicado ',
  `re` float NOT NULL DEFAULT 0,
  `tarifa` int(11) NOT NULL DEFAULT 0 COMMENT 'Se guardará el valor en % del tipo de tarifa a la que corresponda',
  `albaran` varchar(50) NOT NULL DEFAULT '',
  `observaciones` text NOT NULL,
  `aceptado` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no aceptado; 1= aceptado',
  `cod_serie` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_presupuesto`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.presupuestos: ~9 rows (aproximadamente)
DELETE FROM `presupuestos`;
INSERT INTO `presupuestos` (`cod_presupuesto`, `fecha`, `id_cliente`, `importe_neto`, `importe_descuento`, `iva`, `re`, `tarifa`, `albaran`, `observaciones`, `aceptado`, `cod_serie`) VALUES
	('PMA23-0001', '2023-01-16', 4, 1365.99, 1325.01, 10, 0, 3, '', '', 0, 5),
	('PMA23-0003', '2023-01-17', 1, 3631.00, 3522.07, 21, 5.4, 3, '', 'nuevo presupuesto', 0, 5),
	('PMA23-0004', '2023-01-17', 1, 2712.00, 2630.64, 21, 5.4, 3, '', 'Duplicado del presupuesto: PMA23-0003\nnuevo presupuesto', 0, 5),
	('POB22-0002', '2022-03-21', 7, 500.00, 485.00, 21, 5.4, 3, '', '', 0, 1),
	('POB22-0003', '2022-03-21', 1, 500.00, 495.00, 21, 5.4, 1, 'AOB22-0001', 'Duplicado del presupuesto: POB22-0002\n', 1, 1),
	('POB23-0001', '2023-01-16', 7, 1713.25, 1661.85, 21, 0, 3, '', '', 0, 1),
	('PSA22-0003', '2022-03-16', 1, 1365.99, 1352.33, 21, 5.4, 1, 'ASA22-0003', '', 1, 2),
	('PSA24-0008', '2024-04-15', 1, 0.00, 0.00, 0, 0, 0, '', 'asdf', 0, 2),
	('PSA24-0009', '2024-04-15', 1, 0.00, 0.00, 0, 0, 0, '', 'asdf', 0, 2),
	('PSA24-0010', '2024-04-15', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0012', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0014', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0015', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0017', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0020', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0021', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0022', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0023', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0024', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0025', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0026', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0027', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0028', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0029', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0030', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0031', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0032', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0033', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', '', 0, 2),
	('PSA24-0034', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0035', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0036', '2024-04-16', 1, 0.00, 0.00, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0039', '2024-04-16', 1, 9.99, 9.99, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0040', '2024-04-16', 1, 109.89, 109.89, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0041', '2024-04-18', 1, 19.98, 19.98, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0042', '2024-04-18', 1, 19.98, 19.98, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0043', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0044', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0045', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0046', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0047', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0048', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0049', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0050', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0051', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'none', 0, 2),
	('PSA24-0052', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'vAMOOOOS', 0, 2),
	('PSA24-0053', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'asdf', 0, 2),
	('PSA24-0054', '2024-04-18', 1, 109.89, 109.89, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSA24-0055', '2024-04-18', 1, 109.89, 109.89, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSA24-0056', '2024-04-18', 1, 109.89, 109.89, 0, 0, 0, '', 'nuevoooo', 0, 2),
	('PSA24-0057', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'vamoos', 0, 2),
	('PSA24-0058', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSA24-0059', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSA24-0060', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSA24-0061', '2024-04-18', 1, 99.90, 99.90, 0, 0, 0, '', 'Sin observaciones', 0, 2),
	('PSU22-0001', '2022-03-16', 1, 2036.60, 2016.23, 21, 0, 1, 'ASU22-0001', '', 1, 3),
	('PSU23-0001', '2023-01-16', 9, 2036.60, 1975.50, 21, 5.2, 3, 'ASU23-0001', 'Vamos que nos vamos\n', 1, 3);

-- Volcando estructura para tabla d3idi.presupuestos_lineas
CREATE TABLE IF NOT EXISTS `presupuestos_lineas` (
  `cod_presupuestos_lineas` int(11) NOT NULL AUTO_INCREMENT,
  `id_presupuesto` varchar(50) NOT NULL DEFAULT '',
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT '',
  `precio_unitario` decimal(20,2) DEFAULT NULL,
  `desc_linea` int(11) DEFAULT 0,
  `subtotal` decimal(20,2) DEFAULT NULL COMMENT '= precio_unitario * cantidad - desc_linea',
  PRIMARY KEY (`cod_presupuestos_lineas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.presupuestos_lineas: ~29 rows (aproximadamente)
DELETE FROM `presupuestos_lineas`;
INSERT INTO `presupuestos_lineas` (`cod_presupuestos_lineas`, `id_presupuesto`, `id_articulo`, `cantidad`, `descripcion`, `precio_unitario`, `desc_linea`, `subtotal`) VALUES
	(139, 'PSA22-0003', 2, 1, '', 1356.00, 0, 1356.00),
	(140, 'PSA22-0003', 5, 1, '', 9.99, 0, 9.99),
	(144, 'PSU22-0001', 1, 1, '', 919.00, 0, 919.00),
	(145, 'PSU22-0001', 2, 1, '', 1000.00, 0, 1000.00),
	(146, 'PSU22-0001', 15, 1, 'Hora de trabajo útil de un operario con categoría de Oficial', 120.00, 2, 117.60),
	(154, 'POB22-0003', 2, 1, '', 500.00, 0, 500.00),
	(155, 'PMA23-0001', 0, 1, '', 1356.00, 0, 1356.00),
	(156, 'PMA23-0001', 1, 1, '', 9.99, 0, 9.99),
	(157, 'POB23-0001', 0, 1, '', 919.00, 0, 919.00),
	(158, 'POB23-0001', 1, 1, '', 599.00, 0, 599.00),
	(159, 'POB23-0001', 2, 1, '', 195.25, 0, 195.25),
	(160, 'POB22-0002', 2, 1, '', 500.00, 0, 500.00),
	(167, 'PSU23-0001', 1, 1, '', 919.00, 0, 919.00),
	(168, 'PSU23-0001', 2, 1, '', 1000.00, 0, 1000.00),
	(169, 'PSU23-0001', 15, 1, 'Hora de trabajo útil de un operario con categoría de Oficial', 120.00, 2, 117.60),
	(182, 'PMA23-0003', 0, 1, '', 919.00, 0, 919.00),
	(183, 'PMA23-0003', 1, 2, '', 1356.00, 0, 2712.00),
	(184, 'PMA23-0004', 1, 2, '', 1356.00, 0, 2712.00),
	(185, 'PMA23-0005', 1, 2, '', 1356.00, 0, 2712.00),
	(186, 'PMA23-0006', 0, 3, '', 9.99, 0, 29.97),
	(187, 'PMA23-0007', 0, 3, '', 9.99, 0, 29.97),
	(188, 'POB23-0004', 0, 1, '', 20.00, 0, 20.00),
	(189, 'POB23-0004', 1, 1, '', 9.99, 0, 9.99),
	(190, 'POB23-0004', 2, 1, '', 919.00, 0, 919.00),
	(191, 'POB23-0005', 0, 1, '', 20.00, 0, 20.00),
	(192, 'POB23-0005', 1, 1, '', 9.99, 0, 9.99),
	(193, 'POB23-0005', 2, 1, '', 919.00, 0, 919.00),
	(194, 'PMA24-0001', 0, 0, '', 0.00, 0, 0.00),
	(195, 'PMA24-0001', 1, 1, '', 9.99, 0, 9.99),
	(196, 'PMA24-0002', 0, 1, '', 1356.00, 0, 1356.00),
	(197, 'PMA24-0003', 0, 1, '', 9.99, 0, 9.99),
	(198, 'PSA24-0001', 0, 1, '', 195.25, 0, 195.25),
	(199, 'PMA24-0004', 0, 1, '', 9.99, 0, 9.99),
	(200, 'PMA24-0005', 0, 1, '', 9.99, 0, 9.99),
	(201, 'PMA24-0006', 0, 1, '', 9.99, 0, 9.99),
	(202, 'PSA24-0002', 0, 1, '', 1356.00, 0, 1356.00),
	(203, 'PMA24-0007', 0, 1, '', 9.99, 0, 9.99),
	(204, 'PMA24-0008', 0, 1, '', 9.99, 0, 9.99),
	(205, 'PMA24-0009', 0, 1, '', 9.99, 0, 9.99),
	(206, 'PSA24-0003', 0, 1, '', 299.00, 0, 299.00),
	(207, 'PMA24-0010', 0, 1, '', 9.99, 0, 9.99),
	(208, 'PMA24-0011', 0, 1, '', 9.99, 0, 9.99),
	(209, 'PMA24-0011', 1, 1, '', 195.25, 0, 195.25),
	(210, 'PSA24-0004', 0, 1, '', 9.99, 0, 9.99),
	(211, 'PSA24-0004', 1, 1, '', 1356.00, 0, 1356.00),
	(212, 'PSA24-0039', 0, 1, 'esta es algo nuevo', 9.99, 0, 9.99),
	(213, 'PSA24-0039', 1, 1, '', 0.00, 0, 0.00),
	(214, 'PSA24-0040', 0, 1, 'esta es algo nuevo', 9.99, 0, 9.99),
	(215, 'PSA24-0040', 1, 1, '', 0.00, 0, 0.00),
	(216, 'PSA24-0040', 2, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(217, 'PSA24-0041', 0, 2, 'esta es algo nuevo', 9.99, 0, 19.98),
	(218, 'PSA24-0041', 1, 5, '', 0.00, 0, 0.00),
	(219, 'PSA24-0042', 0, 2, 'esta es algo nuevo', 9.99, 0, 19.98),
	(220, 'PSA24-0042', 1, 5, '', 0.00, 0, 0.00),
	(221, 'PSA24-0043', 0, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(222, 'PSA24-0043', 1, 5, '', 0.00, 0, 0.00),
	(223, 'PSA24-0044', 0, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(224, 'PSA24-0044', 1, 5, '', 0.00, 0, 0.00),
	(225, 'PSA24-0045', 0, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(226, 'PSA24-0045', 1, 5, '', 0.00, 0, 0.00),
	(227, 'PSA24-0046', 0, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(228, 'PSA24-0046', 1, 5, '', 0.00, 0, 0.00),
	(229, 'PSA24-0047', 0, 10, 'esta es algo nuevo', 9.99, 0, 99.90),
	(230, 'PSA24-0047', 1, 5, '', 0.00, 0, 0.00),
	(231, 'PSA24-0048', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(232, 'PSA24-0048', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(233, 'PSA24-0049', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(234, 'PSA24-0049', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(235, 'PSA24-0050', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(236, 'PSA24-0050', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(237, 'PSA24-0051', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(238, 'PSA24-0051', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(239, 'PSA24-0052', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(240, 'PSA24-0052', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(241, 'PSA24-0053', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(242, 'PSA24-0053', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(243, 'PSA24-0054', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(244, 'PSA24-0054', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(245, 'PSA24-0054', 2, 1, 'Nuevo filtro', 9.99, 0, 9.99),
	(246, 'PSA24-0054', 3, 2, 'varios', 0.00, 0, 0.00),
	(247, 'PSA24-0055', 0, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(248, 'PSA24-0055', 1, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(249, 'PSA24-0055', 2, 1, 'Nuevo filtro', 9.99, 0, 9.99),
	(250, 'PSA24-0055', 3, 2, 'varios', 0.00, 0, 0.00),
	(251, 'PSA24-0056', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(252, 'PSA24-0056', 15, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(253, 'PSA24-0056', 5, 1, 'Nuevo filtro', 9.99, 0, 9.99),
	(254, 'PSA24-0056', 15, 2, 'varios', 0.00, 0, 0.00),
	(255, 'PSA24-0057', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(256, 'PSA24-0057', 15, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(257, 'PSA24-0058', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(258, 'PSA24-0058', 15, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(259, 'PSA24-0059', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(260, 'PSA24-0059', 15, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(261, 'PSA24-0060', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(262, 'PSA24-0060', 15, 5, 'Manguitos picados', 0.00, 0, 0.00),
	(263, 'PSA24-0061', 5, 10, 'Filtros en mal estado de oxido', 9.99, 0, 99.90),
	(264, 'PSA24-0061', 15, 5, 'Manguitos picados', 0.00, 0, 0.00);

-- Volcando estructura para tabla d3idi.restificativas
CREATE TABLE IF NOT EXISTS `restificativas` (
  `cod_restificativa` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL DEFAULT 0,
  `importe_neto` decimal(20,2) NOT NULL DEFAULT 0.00,
  `importe_descuento` decimal(20,2) NOT NULL DEFAULT 0.00,
  `iva` int(11) NOT NULL DEFAULT 0,
  `tarifa` int(11) NOT NULL DEFAULT 0,
  `tiempos_pago_valor` float NOT NULL DEFAULT 0,
  `tiempos_pago_texto` varchar(50) NOT NULL DEFAULT '0',
  `pagado` int(11) NOT NULL DEFAULT 0,
  `observaciones` text NOT NULL,
  `id_factura` text NOT NULL,
  PRIMARY KEY (`cod_restificativa`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla d3idi.restificativas: ~0 rows (aproximadamente)
DELETE FROM `restificativas`;

-- Volcando estructura para tabla d3idi.restificativas_lineas
CREATE TABLE IF NOT EXISTS `restificativas_lineas` (
  `cod_restificativas_lineas` int(11) NOT NULL AUTO_INCREMENT,
  `id_restificativa` varchar(50) NOT NULL DEFAULT '',
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_unitario` decimal(20,2) DEFAULT NULL,
  `desc_linea` int(11) DEFAULT 0,
  `subtotal` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`cod_restificativas_lineas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla d3idi.restificativas_lineas: ~0 rows (aproximadamente)
DELETE FROM `restificativas_lineas`;

-- Volcando estructura para tabla d3idi.revisiones
CREATE TABLE IF NOT EXISTS `revisiones` (
  `cod_revision` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `firma` varchar(50) DEFAULT NULL,
  `fecha_firma` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_revision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.revisiones: ~11 rows (aproximadamente)
DELETE FROM `revisiones`;
INSERT INTO `revisiones` (`cod_revision`, `id_maquina`, `id_usuario`, `fecha`, `descripcion`, `firma`, `fecha_firma`) VALUES
	(98, 5, 2, '2024-04-15', 'asdf', 'asdf.png', '2024-04-15 11:38:36'),
	(100, 5, 2, '2024-04-15', 'nueva', 'nueva.png', '2024-04-15 10:56:51'),
	(102, 5, 2, '2024-04-15', 'description', 'description.png', '2024-04-16 11:24:02'),
	(104, 5, 2, '2024-04-15', 'asdf', 'asdf.png', '2024-04-15 10:58:56'),
	(106, 5, 2, '2024-04-15', 'asdf', 'asdf.png', '2024-04-15 10:59:52'),
	(108, 5, 2, '2024-04-15', 'asdf', '108.png', '2024-04-18 13:53:34'),
	(109, 5, 2, '2024-04-15', 'asdf', '109.png', '2024-04-18 13:59:08'),
	(110, 5, 2, '2024-04-15', '110', '110.png', '2024-04-15 11:05:59'),
	(111, 5, 2, '2024-04-15', 'nueva revision123', 'nueva_revision123.png', '2024-04-15 12:52:49'),
	(112, 5, 2, '2024-04-16', 'EDITED DESCRIPTION', '112.png', '2024-04-18 12:28:12'),
	(113, 5, 2, '2024-04-16', 'descripcion test', 'descripcion_test.png', '2024-04-16 12:36:48'),
	(116, 5, 2, '2024-04-18', 'Revisión general máquina aire acondicionado oficina central', '116.png', '2024-04-18 12:27:54'),
	(117, 5, 2, '2024-04-19', '19/04', '117.png', '2024-04-19 09:29:18');

-- Volcando estructura para tabla d3idi.revisiones_fotos
CREATE TABLE IF NOT EXISTS `revisiones_fotos` (
  `cod_revisiones_fotos` int(11) NOT NULL AUTO_INCREMENT,
  `id_revision` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) NOT NULL DEFAULT '0',
  `descripcion_foto` text NOT NULL,
  PRIMARY KEY (`cod_revisiones_fotos`)
) ENGINE=InnoDB AUTO_INCREMENT=357 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.revisiones_fotos: ~65 rows (aproximadamente)
DELETE FROM `revisiones_fotos`;
INSERT INTO `revisiones_fotos` (`cod_revisiones_fotos`, `id_revision`, `foto`, `descripcion_foto`) VALUES
	(80, 22, 'mmoreno.jpg', 'lateral'),
	(81, 22, '20194_1146151_62910_image.jpg', 'dfgthghfd'),
	(82, 22, 'isotipo-blanco.png', 'qwereqwrqew'),
	(86, 25, 'perfil.jpg', 'frontal'),
	(88, 23, 'isotipo.png', 'asdfasdfasd'),
	(89, 33, 'Captura de pantalla 2023-01-09 112328.png', 'xce'),
	(90, 42, 'captura_error.png', 'vr'),
	(101, 62, '3.jpg', 'm......'),
	(133, 60, 'logo_login.png', 'descripcion'),
	(134, 61, '3.jpg', 'descripción de foto'),
	(135, 53, 'captura_error.png', 'qwr'),
	(136, 24, '20194_1146151_62910_image.jpg', 'asdfasdfasdf'),
	(138, 63, 'maquina_icono.png', 'Filtro quemado'),
	(141, 26, 'cabecera.jpg', 'prueba'),
	(143, 65, 'default.jpg', 'test'),
	(148, 67, '1 (1).jpg', 'parte lateral noseque'),
	(149, 67, '1 (5).jpg', 'asdf'),
	(150, 67, '1 (3).jpg', 'asdf'),
	(152, 70, '1 (3).jpg', 'test photo'),
	(153, 51, 'captura_error.png', 'wc'),
	(154, 51, '1 (4).jpg', 'asdf'),
	(156, 71, '1 (4).jpg', 'testphpoto'),
	(163, 69, '1 (4).jpg', 'description'),
	(165, 73, '1 (4).jpg', 'asdf'),
	(166, 75, 'isotipo.png', 'pprruueebbaa'),
	(167, 76, 'isotipo.png', 'pprruueebbaa'),
	(168, 77, 'isotipo.png', 'pprruueebbaa'),
	(200, 78, '1 (3).jpg', 'image 1'),
	(201, 79, '1 (4).jpg', 'asdf'),
	(204, 80, '1 (3).jpg', 'image1'),
	(205, 80, '1 (5).jpg', 'image2'),
	(206, 81, '1 (1).jpg', 'image1'),
	(207, 81, '1 (2).jpg', 'image2'),
	(208, 82, '1 (3).jpg', '123'),
	(211, 83, '1 (2).jpg', '123'),
	(212, 84, '1 (3).jpg', '1234'),
	(214, 85, '1 (1).jpg', 'asdf'),
	(215, 86, '1 (2).jpg', 'asdf'),
	(216, 87, '1 (4).jpg', 'adsf'),
	(217, 88, '1 (4).jpg', 'asdf'),
	(218, 89, '1 (3).jpg', 'asdf'),
	(221, 90, '1 (4).jpg', 'asdf'),
	(225, 91, '1 (3).jpg', 'asdf'),
	(226, 91, '1 (5).jpg', 'asdf'),
	(228, 93, '1 (3).jpg', 'asdf'),
	(229, 96, '1 (4).jpg', 'asdf'),
	(232, 100, '1 (2).jpg', '12'),
	(234, 104, '1 (2).jpg', 'asdf'),
	(235, 106, '1 (4).jpg', 'asdf'),
	(244, 110, '1 (3).jpg', 'imagen1'),
	(245, 110, '1 (1).jpg', 'imagen2'),
	(246, 110, '1 (5).jpg', 'imagen3'),
	(247, 98, '1 (3).jpg', 'adfas'),
	(254, 111, '1 (3).jpg', 'asdf'),
	(327, 102, '1 (4).jpg', 'asdf'),
	(334, 113, '1 (4).jpg', 'descripcion photo test 1'),
	(335, 113, '1 (2).jpg', 'descripcion photo  test 2'),
	(336, 113, '1 (5).jpg', 'descripcion photo  test 3'),
	(339, 114, '1 (6).jpg', 'aparato '),
	(340, 115, '1 (2).jpg', 'maquina'),
	(343, 116, '1 (2).jpg', 'maquina'),
	(344, 112, '1 (2).jpg', 'EDITED PHOTO DESCRIPTION'),
	(345, 112, '1 (5).jpg', 'EDITED PHOTO2 DESCRIPTION'),
	(348, 108, '1 (4).jpg', 'asdf'),
	(350, 109, '1 (2).jpg', 'asdf'),
	(356, 117, '1 (3).jpg', 'asdf');

-- Volcando estructura para tabla d3idi.series
CREATE TABLE IF NOT EXISTS `series` (
  `cod_serie` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(3) NOT NULL DEFAULT '0',
  `descripcion` varchar(255) NOT NULL DEFAULT '0',
  `cuenta_bancaria` varchar(255) NOT NULL DEFAULT '0',
  `p` int(11) NOT NULL DEFAULT 0,
  `a` int(11) NOT NULL DEFAULT 0,
  `f` int(11) NOT NULL DEFAULT 0,
  `ab` int(11) NOT NULL DEFAULT 0,
  `activo` int(11) NOT NULL DEFAULT 1,
  `anio` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cod_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.series: ~5 rows (aproximadamente)
DELETE FROM `series`;
INSERT INTO `series` (`cod_serie`, `codigo`, `descripcion`, `cuenta_bancaria`, `p`, `a`, `f`, `ab`, `activo`, `anio`) VALUES
	(1, 'OB', 'Obras', 'ES232356654895687745', 0, 0, 0, 0, 1, 2024),
	(2, 'SA', 'Asistencia técnica', 'ES232356654895687745', 61, 0, 0, 0, 1, 2024),
	(3, 'SU', 'Suministros', 'ES232356654895687745', 0, 0, 0, 0, 1, 2024),
	(4, 'PU', 'Purificadores', 'ES232356654895687745', 0, 0, 0, 0, 1, 2024),
	(5, 'MA', 'Mantenimiento', 'ES232356654895687745', 11, 0, 0, 0, 1, 2024);

-- Volcando estructura para tabla d3idi.tarifas
CREATE TABLE IF NOT EXISTS `tarifas` (
  `cod_tarifa` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`cod_tarifa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.tarifas: ~0 rows (aproximadamente)
DELETE FROM `tarifas`;
INSERT INTO `tarifas` (`cod_tarifa`, `descripcion`, `valor`) VALUES
	(1, 'Industrial', 3),
	(2, 'Particular', 1);

-- Volcando estructura para tabla d3idi.tiempos_pago
CREATE TABLE IF NOT EXISTS `tiempos_pago` (
  `cod_tiempos_pago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL DEFAULT '0',
  `valor` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`cod_tiempos_pago`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.tiempos_pago: ~0 rows (aproximadamente)
DELETE FROM `tiempos_pago`;
INSERT INTO `tiempos_pago` (`cod_tiempos_pago`, `descripcion`, `valor`) VALUES
	(1, 'Pago anticipado del total', -5),
	(2, 'Pago a los 3 meses', 5),
	(3, 'Pago al año', 10);

-- Volcando estructura para tabla d3idi.tipo_articulos
CREATE TABLE IF NOT EXISTS `tipo_articulos` (
  `cod_tipo_articulo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL DEFAULT '0',
  `color` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cod_tipo_articulo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.tipo_articulos: ~0 rows (aproximadamente)
DELETE FROM `tipo_articulos`;
INSERT INTO `tipo_articulos` (`cod_tipo_articulo`, `descripcion`, `color`) VALUES
	(1, 'Máquina', 'bg-info'),
	(2, 'Incidencia', 'bg-success'),
	(3, 'Material', 'bg-dark');

-- Volcando estructura para tabla d3idi.tipo_pago
CREATE TABLE IF NOT EXISTS `tipo_pago` (
  `cod_tipo_pago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.tipo_pago: ~0 rows (aproximadamente)
DELETE FROM `tipo_pago`;
INSERT INTO `tipo_pago` (`cod_tipo_pago`, `descripcion`) VALUES
	(1, 'Transferencia'),
	(2, 'Contado'),
	(3, 'Bizum');

-- Volcando estructura para tabla d3idi.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT 1 COMMENT '0 - Administrador; 1 - Operario',
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Volcando datos para la tabla d3idi.usuarios: ~2 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`cod_usuario`, `usuario`, `login`, `pass`, `nombre`, `apellido`, `tipo`, `activo`) VALUES
	(1, 'admin', 'admin', 'bdb98912e254d538e8b7cefce8123bd4c71e32b0', 'admin', 'admin', 0, 1),
	(2, 'operario', 'operario', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Pepe', 'Dominguez', 1, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
