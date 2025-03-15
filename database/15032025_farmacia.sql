-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para farmacia
CREATE DATABASE IF NOT EXISTS `farmacia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `farmacia`;

-- Volcando estructura para tabla farmacia.detalle_venta
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `det_cantidad` int(11) NOT NULL,
  `det_vencimiento` date NOT NULL,
  `Id_det_lote` int(11) NOT NULL,
  `Id_det_prod` int(11) NOT NULL,
  `lote_Id_prov` int(11) NOT NULL,
  `Id_det_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `Id_det_lote` (`Id_det_lote`),
  KEY `Id_det_prod` (`Id_det_prod`),
  KEY `lote_Id_prov` (`lote_Id_prov`),
  KEY `Id_det_venta` (`Id_det_venta`),
  CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`Id_det_lote`) REFERENCES `lote` (`id_lote`),
  CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`Id_det_prod`) REFERENCES `productos` (`id_producto`),
  CONSTRAINT `detalle_venta_ibfk_4` FOREIGN KEY (`Id_det_venta`) REFERENCES `venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.detalle_venta: ~0 rows (aproximadamente)
DELETE FROM `detalle_venta`;

-- Volcando estructura para tabla farmacia.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `ruc` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla farmacia.empresa: ~1 rows (aproximadamente)
DELETE FROM `empresa`;
INSERT INTO `empresa` (`id`, `nombre`, `logo`, `ruc`, `telefono`, `direccion`, `email`) VALUES
	(3, 'SofaCount SA', 'empresa.jpg', '0707012605', '0992294342', 'Machala', 'softcount@info.com');

-- Volcando estructura para tabla farmacia.laboratorio
CREATE TABLE IF NOT EXISTS `laboratorio` (
  `id_laboratorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_laboratorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.laboratorio: ~0 rows (aproximadamente)
DELETE FROM `laboratorio`;

-- Volcando estructura para tabla farmacia.lote
CREATE TABLE IF NOT EXISTS `lote` (
  `id_lote` int(11) NOT NULL AUTO_INCREMENT,
  `stock` int(11) NOT NULL,
  `vencimiento` date NOT NULL,
  `lote_Id_prod` int(11) NOT NULL,
  `lote_Id_prov` int(11) NOT NULL,
  PRIMARY KEY (`id_lote`),
  KEY `lote_Id_prod` (`lote_Id_prod`),
  KEY `lote_Id_prov` (`lote_Id_prov`),
  CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`lote_Id_prod`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`lote_Id_prov`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.lote: ~0 rows (aproximadamente)
DELETE FROM `lote`;

-- Volcando estructura para tabla farmacia.presentacion
CREATE TABLE IF NOT EXISTS `presentacion` (
  `id_presentacion` int(11) NOT NULL AUTO_INCREMENT,
  `presentacion` varchar(60) NOT NULL,
  PRIMARY KEY (`id_presentacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.presentacion: ~0 rows (aproximadamente)
DELETE FROM `presentacion`;

-- Volcando estructura para tabla farmacia.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `concentracion` varchar(255) NOT NULL,
  `adicional` varchar(60) NOT NULL,
  `precio` float NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `prod_lab` int(11) NOT NULL,
  `prod_tip_prod` int(11) NOT NULL,
  `prod_present` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `IId_laboratorio` (`prod_lab`),
  KEY `Id_tipo_producto` (`prod_tip_prod`),
  KEY `Id_presentacion` (`prod_present`),
  CONSTRAINT `fk_Id_laboratorio` FOREIGN KEY (`prod_lab`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Id_presentacion` FOREIGN KEY (`prod_present`) REFERENCES `presentacion` (`id_presentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tipo_presentacion` FOREIGN KEY (`prod_tip_prod`) REFERENCES `tipo_producto` (`id_tipo_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.productos: ~0 rows (aproximadamente)
DELETE FROM `productos`;

-- Volcando estructura para tabla farmacia.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.proveedor: ~0 rows (aproximadamente)
DELETE FROM `proveedor`;

-- Volcando estructura para tabla farmacia.tipo_producto
CREATE TABLE IF NOT EXISTS `tipo_producto` (
  `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(60) NOT NULL,
  PRIMARY KEY (`id_tipo_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.tipo_producto: ~0 rows (aproximadamente)
DELETE FROM `tipo_producto`;

-- Volcando estructura para tabla farmacia.tipo_us
CREATE TABLE IF NOT EXISTS `tipo_us` (
  `Id_tipo_us` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_tipo_us`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.tipo_us: ~4 rows (aproximadamente)
DELETE FROM `tipo_us`;
INSERT INTO `tipo_us` (`Id_tipo_us`, `nombre_tipo`) VALUES
	(1, 'admin'),
	(2, 'tecnico'),
	(3, 'root'),
	(4, 'vendedor');

-- Volcando estructura para tabla farmacia.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `edad` date NOT NULL,
  `clave` varchar(255) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `residencia` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `sexo` varchar(30) DEFAULT NULL,
  `adicional` varchar(200) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `us_tipo` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `us_tipo` (`us_tipo`),
  CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`us_tipo`) REFERENCES `tipo_us` (`Id_tipo_us`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.usuario: ~1 rows (aproximadamente)
DELETE FROM `usuario`;
INSERT INTO `usuario` (`id_usuario`, `cedula`, `nombre`, `apellido`, `edad`, `clave`, `telefono`, `residencia`, `correo`, `sexo`, `adicional`, `avatar`, `us_tipo`) VALUES
	(1, '1234567890', 'test', 'test', '1996-10-20', '123456', '0992294342', 'Av Rocafuerte', 'test@gmail.com', 'macho', 'test', 'user2-160x160.jpg', 3);

-- Volcando estructura para tabla farmacia.venta
CREATE TABLE IF NOT EXISTS `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `vendedor` int(11) NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `vendedor` (`vendedor`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.venta: ~0 rows (aproximadamente)
DELETE FROM `venta`;

-- Volcando estructura para tabla farmacia.venta_mensual
CREATE TABLE IF NOT EXISTS `venta_mensual` (
  `mensual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.venta_mensual: ~0 rows (aproximadamente)
DELETE FROM `venta_mensual`;

-- Volcando estructura para tabla farmacia.venta_producto
CREATE TABLE IF NOT EXISTS `venta_producto` (
  `id_venta_producto` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  `subtotal` float NOT NULL,
  `producto_Id_producto` int(11) NOT NULL,
  `venta_Id_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_venta_producto`),
  KEY `producto_Id_producto` (`producto_Id_producto`),
  KEY `venta_Id_venta` (`venta_Id_venta`),
  CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`producto_Id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`venta_Id_venta`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla farmacia.venta_producto: ~0 rows (aproximadamente)
DELETE FROM `venta_producto`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
