-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: scmi
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acceso`
--

DROP TABLE IF EXISTS `acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acceso` (
  `IdAcs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdRol` bigint(20) unsigned NOT NULL,
  `IdPem` bigint(20) unsigned NOT NULL,
  `IdMen` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdAcs`),
  KEY `acceso_idrol_foreign` (`IdRol`),
  KEY `acceso_idpem_foreign` (`IdPem`),
  KEY `acceso_idmen_foreign` (`IdMen`),
  CONSTRAINT `acceso_idmen_foreign` FOREIGN KEY (`IdMen`) REFERENCES `menu` (`IdMen`) ON DELETE CASCADE,
  CONSTRAINT `acceso_idpem_foreign` FOREIGN KEY (`IdPem`) REFERENCES `permiso` (`IdPem`) ON DELETE CASCADE,
  CONSTRAINT `acceso_idrol_foreign` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acceso`
--

LOCK TABLES `acceso` WRITE;
/*!40000 ALTER TABLE `acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area` (
  `IdAre` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreAre` varchar(255) NOT NULL,
  `EstadoAre` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdAre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'CUC',1,NULL,NULL);
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clasemantenimiento`
--

DROP TABLE IF EXISTS `clasemantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clasemantenimiento` (
  `IdClm` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreClm` varchar(255) NOT NULL,
  `EstadoClm` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdClm`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clasemantenimiento`
--

LOCK TABLES `clasemantenimiento` WRITE;
/*!40000 ALTER TABLE `clasemantenimiento` DISABLE KEYS */;
INSERT INTO `clasemantenimiento` VALUES (1,'SOFTWARE',1,NULL,NULL),(2,'HARDWARE',1,NULL,NULL);
/*!40000 ALTER TABLE `clasemantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallelaboratorio`
--

DROP TABLE IF EXISTS `detallelaboratorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detallelaboratorio` (
  `IdDtl` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdLab` bigint(20) unsigned NOT NULL,
  `RealizadoDtl` varchar(255) NOT NULL,
  `IdTpm` bigint(20) unsigned NOT NULL,
  `FechaDtl` date NOT NULL,
  `EstadoDtl` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdDtl`),
  KEY `detallelaboratorio_idlab_foreign` (`IdLab`),
  KEY `detallelaboratorio_idtpm_foreign` (`IdTpm`),
  CONSTRAINT `detallelaboratorio_idlab_foreign` FOREIGN KEY (`IdLab`) REFERENCES `laboratorio` (`IdLab`) ON DELETE CASCADE,
  CONSTRAINT `detallelaboratorio_idtpm_foreign` FOREIGN KEY (`IdTpm`) REFERENCES `tipomantenimiento` (`IdTpm`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallelaboratorio`
--

LOCK TABLES `detallelaboratorio` WRITE;
/*!40000 ALTER TABLE `detallelaboratorio` DISABLE KEYS */;
INSERT INTO `detallelaboratorio` VALUES (1,1,'Albert Navarro',1,'2025-11-03',1,'2025-11-03 07:23:00','2025-11-03 07:23:00'),(2,1,'Albert Navarro Mallma',4,'2025-11-03',1,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(3,1,'Albert Navarro Mallma',4,'2025-11-05',1,'2025-11-05 20:59:05','2025-11-05 20:59:05');
/*!40000 ALTER TABLE `detallelaboratorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallemantenimiento`
--

DROP TABLE IF EXISTS `detallemantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detallemantenimiento` (
  `IdDtm` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdMan` bigint(20) unsigned NOT NULL,
  `IdEqo` bigint(20) unsigned NOT NULL,
  `FechaDtm` date NOT NULL,
  `EstadoDtm` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdDtm`),
  KEY `detallemantenimiento_idman_foreign` (`IdMan`),
  KEY `detallemantenimiento_ideqo_foreign` (`IdEqo`),
  CONSTRAINT `detallemantenimiento_ideqo_foreign` FOREIGN KEY (`IdEqo`) REFERENCES `equipo` (`IdEqo`) ON DELETE CASCADE,
  CONSTRAINT `detallemantenimiento_idman_foreign` FOREIGN KEY (`IdMan`) REFERENCES `mantenimiento` (`IdMan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallemantenimiento`
--

LOCK TABLES `detallemantenimiento` WRITE;
/*!40000 ALTER TABLE `detallemantenimiento` DISABLE KEYS */;
INSERT INTO `detallemantenimiento` VALUES (1,9,1,'2025-11-03',1,'2025-11-03 07:23:00','2025-11-03 07:23:00'),(14,34,1,'2025-11-03',1,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(15,35,1,'2025-11-03',1,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(16,36,1,'2025-11-03',1,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(17,37,1,'2025-11-03',0,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(18,38,1,'2025-11-03',1,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(19,39,1,'2025-11-03',0,'2025-11-03 20:47:06','2025-11-03 20:47:06'),(20,34,1,'2025-11-05',0,'2025-11-05 20:59:05','2025-11-05 20:59:05'),(21,35,1,'2025-11-05',0,'2025-11-05 20:59:05','2025-11-05 20:59:05'),(22,36,1,'2025-11-05',0,'2025-11-05 20:59:05','2025-11-05 20:59:05'),(23,37,1,'2025-11-05',0,'2025-11-05 20:59:05','2025-11-05 20:59:05'),(24,38,1,'2025-11-05',1,'2025-11-05 20:59:05','2025-11-05 20:59:05'),(25,39,1,'2025-11-05',1,'2025-11-05 20:59:05','2025-11-05 20:59:05');
/*!40000 ALTER TABLE `detallemantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalleusuario`
--

DROP TABLE IF EXISTS `detalleusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalleusuario` (
  `IdDtu` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdUsa` bigint(20) unsigned NOT NULL,
  `IdLab` bigint(20) unsigned NOT NULL,
  `EstadoDtu` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdDtu`),
  KEY `detalleusuario_idusa_foreign` (`IdUsa`),
  KEY `detalleusuario_idlab_foreign` (`IdLab`),
  CONSTRAINT `detalleusuario_idlab_foreign` FOREIGN KEY (`IdLab`) REFERENCES `laboratorio` (`IdLab`) ON DELETE CASCADE,
  CONSTRAINT `detalleusuario_idusa_foreign` FOREIGN KEY (`IdUsa`) REFERENCES `usuario` (`IdUsa`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleusuario`
--

LOCK TABLES `detalleusuario` WRITE;
/*!40000 ALTER TABLE `detalleusuario` DISABLE KEYS */;
INSERT INTO `detalleusuario` VALUES (1,1,1,1,'2025-11-20 22:24:50','2025-11-20 22:24:50'),(2,1,2,1,'2025-11-20 22:24:50','2025-11-20 22:24:50');
/*!40000 ALTER TABLE `detalleusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipo` (
  `IdEqo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdLab` bigint(20) unsigned NOT NULL,
  `NombreEqo` varchar(255) NOT NULL,
  `CodigoEqo` varchar(255) NOT NULL,
  `EstadoEqo` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdEqo`),
  KEY `equipo_idlab_foreign` (`IdLab`),
  CONSTRAINT `equipo_idlab_foreign` FOREIGN KEY (`IdLab`) REFERENCES `laboratorio` (`IdLab`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (1,1,'PC-01','09099',1,'2025-10-31 22:06:23','2025-10-31 22:06:23'),(2,1,'PC-02','09100',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(3,1,'PC-03','09101',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(4,1,'PC-04','09102',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(5,1,'PC-05','09103',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(6,1,'PC-06','09104',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(7,1,'PC-07','09105',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(8,1,'PC-08','09106',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(9,1,'PC-09','09107',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(10,1,'PC-10','09108',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(11,1,'PC-11','09109',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(12,1,'PC-12','09110',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(13,1,'PC-13','09111',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(14,1,'PC-14','09112',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(15,1,'PC-15','09113',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(16,1,'PC-16','09114',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(17,1,'PC-17','09115',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(18,1,'PC-18','09116',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(19,1,'PC-19','09117',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(20,1,'PC-20','09118',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(21,1,'PC-21','09119',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(22,1,'PC-22','09120',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(23,1,'PC-23','09121',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(24,1,'PC-24','09122',1,'2025-11-05 16:18:45','2025-11-05 16:18:45'),(25,1,'PC-25','09123',1,'2025-11-05 16:18:45','2025-11-05 16:18:45');
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laboratorio`
--

DROP TABLE IF EXISTS `laboratorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laboratorio` (
  `IdLab` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdAre` bigint(20) unsigned NOT NULL,
  `NombreLab` varchar(255) NOT NULL,
  `EstadoLab` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdLab`),
  KEY `laboratorio_idare_foreign` (`IdAre`),
  CONSTRAINT `laboratorio_idare_foreign` FOREIGN KEY (`IdAre`) REFERENCES `area` (`IdAre`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laboratorio`
--

LOCK TABLES `laboratorio` WRITE;
/*!40000 ALTER TABLE `laboratorio` DISABLE KEYS */;
INSERT INTO `laboratorio` VALUES (1,1,'LAB-01',1,'2025-10-31 21:21:44','2025-10-31 21:21:44'),(2,1,'LAB-02',1,'2025-10-31 21:21:54','2025-10-31 21:21:54');
/*!40000 ALTER TABLE `laboratorio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimiento`
--

DROP TABLE IF EXISTS `mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mantenimiento` (
  `IdMan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdTpm` bigint(20) unsigned NOT NULL,
  `IdClm` bigint(20) unsigned NOT NULL,
  `NombreMan` varchar(255) NOT NULL,
  `EstadoMan` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdMan`),
  KEY `mantenimiento_idtpm_foreign` (`IdTpm`),
  KEY `mantenimiento_idclm_foreign` (`IdClm`),
  CONSTRAINT `mantenimiento_idclm_foreign` FOREIGN KEY (`IdClm`) REFERENCES `clasemantenimiento` (`IdClm`) ON DELETE CASCADE,
  CONSTRAINT `mantenimiento_idtpm_foreign` FOREIGN KEY (`IdTpm`) REFERENCES `tipomantenimiento` (`IdTpm`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimiento`
--

LOCK TABLES `mantenimiento` WRITE;
/*!40000 ALTER TABLE `mantenimiento` DISABLE KEYS */;
INSERT INTO `mantenimiento` VALUES (1,1,2,'Sopletear la PC',1,'2025-11-03 02:02:47','2025-11-04 21:54:15'),(2,1,2,'Sopletear la fuente de poder',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(3,1,2,'Limpiar el gabinete de la PC',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(4,1,2,'Sopletear el teclado y mouse',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(5,1,2,'Verificar teclado y mouse',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(6,1,2,'Limpiar el teclado y mouse',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(7,1,2,'Limpiar la pantalla del monitor',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(8,1,2,'Limpiar el monitor',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(9,1,1,'CheckDisk',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(10,1,1,'Crear punto de restauración inicial',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(11,1,1,'Descargar actualizaciones de Windows',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(12,1,1,'Actualizar el antivirus',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(13,1,1,'Analizar el sistema contra virus y malware',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(14,2,2,'Cambio de memoria RAM',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(15,2,2,'Cambio de disco duro o SSD',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(16,2,2,'Cambio de fuente de poder',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(17,2,2,'Cambio de tarjeta madre',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(18,2,2,'Cambio de procesador',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(19,2,2,'Cambio de tarjeta de video',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(20,2,2,'Cambio de ventilador del CPU',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(21,2,2,'Cambio de pasta térmica',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(22,2,2,'Cambio de lector óptico',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(23,2,2,'Cambio de tarjeta de red',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(24,2,2,'Cambio de tarjeta de sonido',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(25,2,2,'Sustitución de cables internos dañados',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(26,2,1,'Reinstalación del sistema operativo',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(27,2,1,'Reparación de inicio de Windows',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(28,2,1,'Restauración del sistema desde copia de seguridad',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(29,2,1,'Desinfección avanzada de virus y malware',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(30,2,1,'Reparación de controladores dañados',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(31,2,1,'Reinstalación de drivers',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(32,2,1,'Eliminación de software malicioso persistente',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(33,2,1,'Recuperación tras fallo de actualización',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(34,4,2,'Estado de Conectividad',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(35,4,2,'Tipo de Conexión',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(36,4,2,'Estado de Actualizaciones',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(37,4,2,'Incidencia de Seguridad Detectadas',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(38,4,2,'Antivirus Activo',1,'2025-11-03 02:02:47','2025-11-03 02:02:47'),(39,4,2,'Acción Correctiva',1,'2025-11-03 02:02:47','2025-11-03 02:02:47');
/*!40000 ALTER TABLE `mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `IdMen` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreMen` varchar(255) NOT NULL,
  `EstadoMen` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdMen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_07_11_162936_rol',1),(2,'2025_07_11_163045_tipoperiferico',1),(3,'2025_07_12_162907_persona',1),(4,'2025_07_12_162932_usuario',1),(5,'2025_07_12_162944_menu',1),(6,'2025_07_12_162949_permiso',1),(7,'2025_07_12_162956_acceso',1),(8,'2025_07_12_163013_area',1),(9,'2025_07_12_163019_laboratorio',1),(10,'2025_07_12_163030_equipo',1),(11,'2025_07_12_163038_periferico',1),(12,'2025_07_12_163105_tipomantenimiento',1),(13,'2025_07_12_163119_clasemantenimiento',1),(14,'2025_07_12_163126_mantenimiento',1),(15,'2025_07_12_163326_detalleusuario',1),(16,'2025_07_12_163342_detallelaboratorio',1),(17,'2025_07_12_163358_detallemantenimiento',1),(18,'2025_07_13_132424_create_sessions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periferico`
--

DROP TABLE IF EXISTS `periferico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periferico` (
  `IdPef` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdTpf` bigint(20) unsigned NOT NULL,
  `IdEqo` bigint(20) unsigned DEFAULT NULL,
  `CiuPef` varchar(255) NOT NULL,
  `CodigoInventarioPef` varchar(255) NOT NULL,
  `MarcaPef` varchar(255) NOT NULL,
  `ColorPef` varchar(255) NOT NULL,
  `EstadoPef` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPef`),
  KEY `periferico_idtpf_foreign` (`IdTpf`),
  KEY `periferico_ideqo_foreign` (`IdEqo`),
  CONSTRAINT `periferico_ideqo_foreign` FOREIGN KEY (`IdEqo`) REFERENCES `equipo` (`IdEqo`) ON DELETE SET NULL,
  CONSTRAINT `periferico_idtpf_foreign` FOREIGN KEY (`IdTpf`) REFERENCES `tipoperiferico` (`IdTpf`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periferico`
--

LOCK TABLES `periferico` WRITE;
/*!40000 ALTER TABLE `periferico` DISABLE KEYS */;
INSERT INTO `periferico` VALUES (1,2,1,'09313','740881870390','Lenovo','Negro',1,NULL,'2025-11-20 22:41:47'),(2,2,1,'08921','740899500048','Advance','Negro',1,NULL,'2025-10-31 22:06:23'),(3,3,1,'08936','740899500441','Lenovo','Negro',1,NULL,'2025-10-31 22:06:23'),(4,4,1,'08941','740899500428','Advance','Negro',1,NULL,'2025-10-31 22:06:23');
/*!40000 ALTER TABLE `periferico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permiso` (
  `IdPem` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombrePem` varchar(255) NOT NULL,
  `EstadoPem` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `IdPer` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombrePer` varchar(255) NOT NULL,
  `ApellidoPaternoPer` varchar(255) NOT NULL,
  `ApellidoMaternoPer` varchar(255) NOT NULL,
  `FechaNacimientoPer` date NOT NULL,
  `DniPer` varchar(255) NOT NULL,
  `TelefonoPer` varchar(255) NOT NULL,
  `CorreoPer` varchar(255) NOT NULL,
  `EstadoPer` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPer`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Albert','Navarro','Mallma','2004-01-15','76781233','983231243','dannavarro355@gmail.com',1,'2025-10-31 21:20:17','2025-10-31 21:20:17');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `IdRol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreRol` varchar(255) NOT NULL,
  `EstadoRol` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'ADMINISTRADOR',1,NULL,NULL),(2,'TECNICO',1,NULL,NULL),(3,'PRACTICANTE',1,NULL,NULL);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Dv9aDU2Cpvjhqsc5qLuAe8U3ftGkT4fMX6zfyJYn',NULL,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTRwQVAzNFN5b0FUQVhmdklCU09ielMyMjJXMzlobkdGQVkzY2k3NSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL1JlcG9ydGVzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9SZXBvcnRlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1763838286),('n3E1eLpXPsvYPya9DU4MARKqAZS7q0mrjgvKeJq0',1,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVXBpV3RzQjZWVm9qMHFsczEyQ1g1cnVqdFh0aHh0Z0R3Y0JDTjdMVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvQ29udHJvbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1763838306),('S5KPh0PK9YIPisxqRgAtgJJDACVW4KuWNaezu4W5',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaDRhNWhoT1V5ZDFRY2dwVXEwNUlzdVFjM1ZTZ3JqbnRjbG9HY0xpeSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvTWFudGVuaW1pZW50b3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1763821566);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipomantenimiento`
--

DROP TABLE IF EXISTS `tipomantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipomantenimiento` (
  `IdTpm` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreTpm` varchar(255) NOT NULL,
  `EstadoTpm` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdTpm`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomantenimiento`
--

LOCK TABLES `tipomantenimiento` WRITE;
/*!40000 ALTER TABLE `tipomantenimiento` DISABLE KEYS */;
INSERT INTO `tipomantenimiento` VALUES (1,'PREVENTIVO',1,NULL,NULL),(2,'CORRECTIVO',1,NULL,NULL),(3,'PREDICTIVO',1,NULL,NULL),(4,'CONECTIVIDAD E INCIDENCIAS',1,NULL,NULL);
/*!40000 ALTER TABLE `tipomantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoperiferico`
--

DROP TABLE IF EXISTS `tipoperiferico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipoperiferico` (
  `IdTpf` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NombreTpf` varchar(255) NOT NULL,
  `EstadoTpf` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdTpf`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoperiferico`
--

LOCK TABLES `tipoperiferico` WRITE;
/*!40000 ALTER TABLE `tipoperiferico` DISABLE KEYS */;
INSERT INTO `tipoperiferico` VALUES (1,'MONITOR',1,NULL,NULL),(2,'CPU',1,NULL,NULL),(3,'TECLADO',1,NULL,NULL),(4,'RATON',1,NULL,NULL);
/*!40000 ALTER TABLE `tipoperiferico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `IdUsa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IdRol` bigint(20) unsigned NOT NULL,
  `IdPer` bigint(20) unsigned NOT NULL,
  `UsernameUsa` varchar(255) NOT NULL,
  `PasswordUsa` varchar(255) NOT NULL,
  `EstadoUsa` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdUsa`),
  KEY `usuario_idrol_foreign` (`IdRol`),
  KEY `usuario_idper_foreign` (`IdPer`),
  CONSTRAINT `usuario_idper_foreign` FOREIGN KEY (`IdPer`) REFERENCES `persona` (`IdPer`) ON DELETE CASCADE,
  CONSTRAINT `usuario_idrol_foreign` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,1,'dannn','$2y$12$JTVyom3ftux6bOHILBrTGOEVMG/aq0XjFpVYnK/Kp/Cly5NDG/O9m',1,'2025-10-31 21:20:17','2025-11-20 22:24:50');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-22 14:16:21
