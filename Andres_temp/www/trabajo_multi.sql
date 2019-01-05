-- MySQL dump 10.13  Distrib 5.6.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: trabajo_multi
-- ------------------------------------------------------
-- Server version	5.6.35-1+deb.sury.org~xenial+0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'usuario.jpg',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (4,'Marcos','marcos@hotmail.com','$2y$10$BaRiGVRjuepRbso1205qauZ03TlC5xZp.Anv4DaOfNDB9FS7IKMp.','2018-03-25','                        Soy un tio muuuuuuuuuuuuuuuy tonto                    ','usuario.jpg'),(5,'Maria','maria@hotmail.com','$2y$10$TlIeCNENxCauiVlWnSWa6Oy6CDgXHQ8g8l5rwGDdWDnFiW9G1YUh2','2018-04-19','                                                                                                                                                                                                                                                Hola me gustan las Margaritas                                                                                                                                                                                                        ','usuario.jpg'),(6,'Guille','guille@hotmail.com','$2y$10$zSnN8baYVm6TbFSDRHVxbulkl.MQystB4EZHNvM/9OckbBnHXCV8i','2018-04-19','                                                                                            Hola que tal                                        ','6.jpg'),(7,'Alvaro','alvaro@hotmail.com','$2y$10$AlaQeJHnIlThYyXu/i6aH.KfH.1V2fXUBd0XwbQ3FDvQHWWLrcCFq','2018-04-19','                                                                                                                                                                                                                                                                    Hola soy gay y homosexual al mismo tiempo                                                                                                                                                                                   ','7.jpg');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Videos`
--

DROP TABLE IF EXISTS `Videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Videos` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(32) NOT NULL,
  `categoria` varchar(32) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `privado` varchar(1) DEFAULT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_video`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `Videos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Videos`
--

LOCK TABLES `Videos` WRITE;
/*!40000 ALTER TABLE `Videos` DISABLE KEYS */;
INSERT INTO `Videos` VALUES (10,4,'La Resistencia','Otras','Fragmento del programa de #0 (Movistar) presentado por David Broncano,','','2018-03-25'),(48,4,'Mi descripciÃ³n','Otras','','','2018-04-19'),(49,4,'Yo en practicas','Otras','Haciendo el tonto','','2018-04-19');
/*!40000 ALTER TABLE `Videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-20 13:53:17
