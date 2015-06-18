CREATE DATABASE  IF NOT EXISTS `bhoi` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci */;
USE `bhoi`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: bhoi
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `komentari`
--

DROP TABLE IF EXISTS `komentari`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vijest` int(11) NOT NULL,
  `imeAutora` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `emailAutora` varchar(50) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `vrijemeObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fkv_idx` (`vijest`),
  CONSTRAINT `fkv` FOREIGN KEY (`vijest`) REFERENCES `vijesti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komentari`
--

LOCK TABLES `komentari` WRITE;
/*!40000 ALTER TABLE `komentari` DISABLE KEYS */;
/*!40000 ALTER TABLE `komentari` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `korisnici` (
  `korisnickoIme` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `sifra` varchar(32) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`korisnickoIme`),
  UNIQUE KEY `korisnickoIme_UNIQUE` (`korisnickoIme`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnici`
--

LOCK TABLES `korisnici` WRITE;
/*!40000 ALTER TABLE `korisnici` DISABLE KEYS */;
INSERT INTO `korisnici` VALUES ('amehanovic','5f4dcc3b5aa765d61d8327deb882cf99','amehanovic1@etf.unsa.ba');
/*!40000 ALTER TABLE `korisnici` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vijesti`
--

DROP TABLE IF EXISTS `vijesti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `autor` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `slika` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `uvodniTekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `citavTekst` text COLLATE utf8_slovenian_ci,
  `vrijemeObjave` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idvijesti_UNIQUE` (`id`),
  KEY `fka_idx` (`autor`),
  CONSTRAINT `fka` FOREIGN KEY (`autor`) REFERENCES `korisnici` (`korisnickoIme`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vijesti`
--

LOCK TABLES `vijesti` WRITE;
/*!40000 ALTER TABLE `vijesti` DISABLE KEYS */;
INSERT INTO `vijesti` VALUES (17,'NOVOST BROJ 1','amehanovic','../images/1.jpg','Uvodni tekst: Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1','Čitav tekst: Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1 Novost broj 1','2015-06-18 01:05:19'),(18,'NOVOST BROJ 2','amehanovic','../images/2.jpg','Uvodni tekst: Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2','Čitav tekst: Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2 Novost broj 2','2015-06-18 01:06:38'),(21,'NOVOST BROJ 5','amehanovic','','Uvodni tekst: Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5 Novost broj 5','','2015-06-18 01:10:17'),(22,'NOVOST BROJ 6','amehanovic','../images/6.jpg','Uvodni tekst: Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6','Čitav tekst: Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6 Novost broj 6','2015-06-18 01:09:27'),(23,'NOVOST BROJ 3','amehanovic','../images/3.jpg','Uvodni tekst: Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3','Čitav tekst: Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3 Novost broj 3','2015-06-18 01:07:49'),(24,'NOVOST BROJ 4','amehanovic','../images/4.jpg','Uvodni tekst: Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4 Novost broj 4','','2015-06-18 01:10:53');
/*!40000 ALTER TABLE `vijesti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-18  3:38:18
