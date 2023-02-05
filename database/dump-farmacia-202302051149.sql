-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: farmacia
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES (1,5,'2020-08-22',6,2,2,1),(3,20,'2022-11-25',14,8,0,13),(4,2,'2022-11-25',14,8,0,14),(5,10,'2022-11-25',14,8,2,15),(6,10,'2020-08-03',1,2,1,16),(7,0,'2020-08-03',9,2,1,16),(8,5,'2023-06-16',15,1,2,16),(9,10,'2022-11-25',14,8,2,17),(10,8,'2022-11-25',14,8,2,18),(11,1,'2020-08-03',1,2,1,18),(14,10,'2023-06-16',15,1,2,21),(15,12,'2022-11-25',14,8,2,21),(16,20,'2022-11-25',14,8,2,22),(17,20,'2023-06-16',15,1,2,23),(18,10,'2023-06-16',15,1,2,24),(19,5,'2022-11-25',14,8,2,24),(23,10,'2023-06-16',15,1,2,28),(24,5,'2021-12-28',16,11,2,29),(25,5,'2021-12-28',16,11,2,30),(26,1,'2021-12-28',16,11,2,31),(27,1,'2022-11-25',14,8,2,31),(28,1,'2021-12-28',16,11,2,32),(29,1,'2022-11-25',14,8,2,33),(30,1,'2023-06-16',15,1,2,33),(31,1,'2021-12-28',16,11,2,34),(32,5,'2021-12-28',16,11,2,35),(33,1,'2021-12-28',16,11,2,36);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `ruc` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (3,'SofaCount SA','empresa.jpg','0707012605','0992294342','Machala','softcount@info.com');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laboratorio`
--

DROP TABLE IF EXISTS `laboratorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laboratorio` (
  `id_laboratorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_laboratorio`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laboratorio`
--

LOCK TABLES `laboratorio` WRITE;
/*!40000 ALTER TABLE `laboratorio` DISABLE KEYS */;
INSERT INTO `laboratorio` VALUES (1,'pecho peludo 5','61bcef05407ae-deployLaravel.png'),(2,'sea ltmda','5f20847468c89-hello_word.png'),(3,'maria bd','61a50d7919cce-blade.png'),(4,'local host','5f3ff08cd78d7-reactjs.png'),(5,'pepeppeep','5f3ffb6081f82-item2.png'),(8,'la','5f21ae50f2e84-hello_word.png'),(13,'nestle ecuador ','618321cb85093-buscador_musicas.png'),(15,'no mas te jajaja :)','laboratorio.jpg'),(16,'master chef','laboratorio.jpg'),(17,'Bayer','619673359ec20-blade.png');
/*!40000 ALTER TABLE `laboratorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lote`
--

DROP TABLE IF EXISTS `lote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lote` (
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lote`
--

LOCK TABLES `lote` WRITE;
/*!40000 ALTER TABLE `lote` DISABLE KEYS */;
INSERT INTO `lote` VALUES (1,1,'2020-08-03',2,1),(6,17,'2020-08-22',2,1),(9,14,'2020-08-03',2,1),(10,22,'2020-08-29',2,1),(11,33,'2020-08-05',2,2),(14,21,'2022-11-25',8,2),(15,434,'2023-06-16',1,2),(16,20,'2021-12-28',11,2),(17,8,'2023-02-05',1,5),(18,1,'2023-02-05',1,5),(19,11,'2023-02-05',1,5),(20,11,'2023-02-05',1,5),(21,11,'2023-02-05',1,5),(22,11,'2023-02-05',1,5),(23,11,'2023-02-05',1,5),(24,11,'2023-02-05',1,5),(25,11,'2023-02-05',1,5),(26,11,'2023-02-05',1,5);
/*!40000 ALTER TABLE `lote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentacion`
--

DROP TABLE IF EXISTS `presentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presentacion` (
  `id_presentacion` int(11) NOT NULL AUTO_INCREMENT,
  `presentacion` varchar(60) NOT NULL,
  PRIMARY KEY (`id_presentacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentacion`
--

LOCK TABLES `presentacion` WRITE;
/*!40000 ALTER TABLE `presentacion` DISABLE KEYS */;
INSERT INTO `presentacion` VALUES (1,'Suero'),(2,'capsulas x2'),(3,'Liquido');
/*!40000 ALTER TABLE `presentacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'buscapina ','normal','anormal',1.78,'producto.png',3,3,2),(2,'omeprosol','primera vez','jajaj',1.5,'producto.png',15,2,2),(8,'Vitamina C','Lorem kjwhjkhkhkdjkh','wkjwfekj',90,'producto.png',17,3,1),(11,'Condones','condones ','c',5,'producto.png',4,3,1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'sabores SA','1235566','sabores@gmail.com','quito','proveedor.png'),(2,'mariana  de jesus','0992294342','a@gmail.com','machala','proveedor.png'),(3,'SSW','0992294342','ssw@info.com','Av Quito','proveedor.png'),(5,'DIEGO','0992294342','diego@gmail.com','mi casa ','proveedor.png');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_producto`
--

DROP TABLE IF EXISTS `tipo_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_producto` (
  `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(60) NOT NULL,
  PRIMARY KEY (`id_tipo_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_producto`
--

LOCK TABLES `tipo_producto` WRITE;
/*!40000 ALTER TABLE `tipo_producto` DISABLE KEYS */;
INSERT INTO `tipo_producto` VALUES (1,'capsula'),(2,'campos'),(3,'asdfg'),(4,'no mas jaja'),(10,'sech'),(11,'Farma');
/*!40000 ALTER TABLE `tipo_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_us`
--

DROP TABLE IF EXISTS `tipo_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_us` (
  `Id_tipo_us` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_tipo_us`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_us`
--

LOCK TABLES `tipo_us` WRITE;
/*!40000 ALTER TABLE `tipo_us` DISABLE KEYS */;
INSERT INTO `tipo_us` VALUES (1,'admin'),(2,'tecnico'),(3,'root');
/*!40000 ALTER TABLE `tipo_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'0707012605','diego','jimenez','1996-10-20','619andres','0992294342','andres96jimenez@gmail.com','Av Rocafuerte','masculino','Software Development','619675d7cab00-IMG_7151 vvvvvvvvvvvvvv.jpg',3),(2,'0707012600','mariel','lopez','1995-12-12','12345',NULL,NULL,NULL,NULL,NULL,'5f1f0711bf732-Captura de Pantalla 2020-07-13 a la(s) 11.09.41.png',1),(3,'0707012601','mariana','ponce','1996-10-20','12345','0992294342','machala','diego96jp@gmail.com','femenino','asdfghj','5f1f0095465e9-tienda2.png',2);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `vendedor` int(11) NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `vendedor` (`vendedor`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,'2020-08-28 00:00:00','manuel jimenez','0781234512',8.00,1),(2,'2021-11-03 19:28:43','Marco Robles','0707012600',11.00,1),(7,'2021-11-04 10:39:49','Diego','0707012600',890.00,1),(8,'2021-11-04 10:45:18','hjehfkjrhjk','',450.00,1),(9,'2021-11-04 11:17:36','lkshjldhjk','',18.00,1),(10,'2021-11-04 11:20:26','lalala','',888.00,1),(13,'2021-11-04 11:50:27','test','',1790.00,1),(14,'2021-11-04 11:52:41','diego jimenex','',180.00,1),(15,'2021-11-04 11:54:34','finalicima','27898789',888.00,1),(16,'2021-11-04 11:55:56','Mariana Ponce','',174.00,1),(17,'2021-11-04 11:57:21','Juan Jimenez','',910.00,1),(18,'2021-11-04 11:59:57','Nancy','',712.00,1),(21,'2021-11-04 12:09:40','jjjjj','0707012600',1088.00,1),(22,'2021-11-04 12:11:51','diego jimenex','0707012605',1790.00,1),(23,'2021-11-04 12:13:22','Juan Carlos Centeno','',24.00,1),(24,'2021-11-04 12:16:01','Lucia Ponce','',456.00,1),(28,'2021-11-04 12:23:35','lalalalalalalaaaaaaaaaaaakhgjh','',18.00,1),(29,'2021-11-04 12:27:04','prueba c','0707012666',10.00,1),(30,'2021-11-17 18:16:19','Ariana Mejia','0707012605',10.00,1),(31,'2021-11-29 12:13:34','Andrea Lozano','',92.00,1),(32,'2021-12-15 12:27:10','Manuel Pambe','',2.00,1),(33,'2021-12-15 12:28:54','Rosa Arizaga','',91.78,1),(34,'2021-12-15 12:34:41','diego jimenex','0707012605',2.00,1),(35,'2021-12-15 12:41:50','Maria Ponce','',10.00,1),(36,'2021-12-15 12:44:39','Jose Lucero','0707012666',5.00,1);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_mensual`
--

DROP TABLE IF EXISTS `venta_mensual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_mensual` (
  `mensual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_mensual`
--

LOCK TABLES `venta_mensual` WRITE;
/*!40000 ALTER TABLE `venta_mensual` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_mensual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_producto`
--

DROP TABLE IF EXISTS `venta_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_producto` (
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_producto`
--

LOCK TABLES `venta_producto` WRITE;
/*!40000 ALTER TABLE `venta_producto` DISABLE KEYS */;
INSERT INTO `venta_producto` VALUES (1,5,0,7.5,2,1),(2,10,1.78,17.8,1,9),(3,10,90,900,8,10),(4,20,90,1800,8,13),(5,2,90,180,8,14),(6,10,90,900,8,15),(7,10,1.5,15,2,16),(8,5,1.78,8.9,1,16),(9,10,90,900,8,17),(10,8,90,720,8,18),(11,10,1.78,17.8,1,21),(12,12,90,1080,8,21),(13,20,90,1800,8,22),(14,20,1.78,35.6,1,23),(15,10,1.78,17.8,1,24),(16,5,90,450,8,24),(17,10,1.78,17.8,1,28),(18,5,2,10,11,29),(19,5,2,10,11,30),(20,1,2,2,11,31),(21,1,90,90,8,31),(22,1,2,2,11,32),(23,1,90,90,8,33),(24,1,1.78,1.78,1,33),(25,1,2,2,11,34),(26,5,2,10,11,35),(27,1,5,5,11,36);
/*!40000 ALTER TABLE `venta_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'farmacia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-05 11:49:20
