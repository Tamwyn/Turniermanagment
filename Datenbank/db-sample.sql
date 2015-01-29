-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: turniermanagment
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `altersklassen`
--

DROP TABLE IF EXISTS `altersklassen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `altersklassen` (
  `TurnierID` int(11) NOT NULL,
  `JahrgID` int(11) NOT NULL,
  PRIMARY KEY (`TurnierID`,`JahrgID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `altersklassen`
--

LOCK TABLES `altersklassen` WRITE;
/*!40000 ALTER TABLE `altersklassen` DISABLE KEYS */;
INSERT INTO `altersklassen` VALUES (1,3),(1,4),(2,2),(2,3),(2,4),(3,0),(3,1),(3,2),(3,3),(3,4),(3,5),(4,2),(4,3),(4,4),(5,1),(5,2),(6,1),(6,2),(6,3),(6,4),(7,2),(7,3),(7,4);
/*!40000 ALTER TABLE `altersklassen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fechter`
--

DROP TABLE IF EXISTS `fechter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fechter` (
  `ID` int(11) NOT NULL,
  `Nachname` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Vorname` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Jahrgang` int(11) NOT NULL,
  `Email` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `idFechter_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Daten ueber die einzelnen Fechter';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fechter`
--

LOCK TABLES `fechter` WRITE;
/*!40000 ALTER TABLE `fechter` DISABLE KEYS */;
INSERT INTO `fechter` VALUES (0,'','',0,''),(1,'Säbelfechter','Ein',1951,'alt@saebel.de'),(2,'Florettfechter','Ein',1951,'jung@florett.de'),(3,'Beidesfechter','Ein',1997,'beides@fechten.de'),(4,'Schüler','Ein',2002,'ein@schueler.de'),(5,'Bjugend','Ein',2000,'ein@bjugend.de'),(6,'Ajugend','Ein',1998,'ein@ajugend.de'),(7,'Fechter','Starker',1997,'fechten@starker.de'),(8,'Fechterin','Starke',2002,'fechten@starke.de');
/*!40000 ALTER TABLE `fechter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fechterwaffe`
--

DROP TABLE IF EXISTS `fechterwaffe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fechterwaffe` (
  `FechterID` int(11) NOT NULL,
  `WaffeID` int(11) NOT NULL,
  PRIMARY KEY (`FechterID`,`WaffeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Zwischentabelle um einem Fechter mehrere Waffen zuweisen zu können';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fechterwaffe`
--

LOCK TABLES `fechterwaffe` WRITE;
/*!40000 ALTER TABLE `fechterwaffe` DISABLE KEYS */;
INSERT INTO `fechterwaffe` VALUES (0,0),(1,0),(2,1),(3,0),(3,1),(4,0),(5,0),(5,1),(6,0),(6,1),(7,1),(8,1);
/*!40000 ALTER TABLE `fechterwaffe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jahrgaenge`
--

DROP TABLE IF EXISTS `jahrgaenge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jahrgaenge` (
  `ID` int(11) NOT NULL,
  `JahrgName` varchar(45) NOT NULL,
  `Beginn` year(4) NOT NULL,
  `Ende` year(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jahrgaenge`
--

LOCK TABLES `jahrgaenge` WRITE;
/*!40000 ALTER TABLE `jahrgaenge` DISABLE KEYS */;
INSERT INTO `jahrgaenge` VALUES (0,'Schueler',2003,2005),(1,'B-Jugend',2002,2003),(2,'A-Jugend',1998,2000),(3,'Junioren',1995,2000),(4,'Aktive',1945,1998),(5,'Senioren',1945,1974);
/*!40000 ALTER TABLE `jahrgaenge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turnier`
--

DROP TABLE IF EXISTS `turnier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turnier` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Ausschreibung` varchar(45) NOT NULL,
  `Pflichtturnier` int(1) NOT NULL,
  `Datum` date NOT NULL,
  `Ort` varchar(45) NOT NULL,
  `casted` int(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turnier`
--

LOCK TABLES `turnier` WRITE;
/*!40000 ALTER TABLE `turnier` DISABLE KEYS */;
INSERT INTO `turnier` VALUES (0,'','',0,'1970-01-01','',0),(1,'Hamburger Meisterschaften','hamburger-fechtverband.de/meisterschaften.pdf',1,'2015-02-01','Hamburg',0),(2,'Hannoveraner Floretturnier','fechten-hannover.de/ausschreibung.pdf',1,'2015-02-07','Hannover',0),(3,'Münchener Multiturnier','turniere.fechten.org/7834.pdf',0,'2015-02-19','München',0),(4,'Internationales Säbelturnier','turniere.fechten.org/7625.pdf',0,'2015-02-28','Mühlheim',0),(5,'Landesmeisterschaften SH','fbsh.de/lmsh.pdf',1,'2015-02-21','Kiel',0),(6,'Internationales Florettturnier','turniere.fechten.org/7626.pdf',0,'2015-02-22','Eislingen',0);
/*!40000 ALTER TABLE `turnier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waffen`
--

DROP TABLE IF EXISTS `waffen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waffen` (
  `ID` int(11) NOT NULL,
  `WaffeName` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waffen`
--

LOCK TABLES `waffen` WRITE;
/*!40000 ALTER TABLE `waffen` DISABLE KEYS */;
INSERT INTO `waffen` VALUES (0,'Saebel'),(1,'Florett'),(2,'Degen');
/*!40000 ALTER TABLE `waffen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waffetur`
--

DROP TABLE IF EXISTS `waffetur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waffetur` (
  `TurnierID` int(11) NOT NULL,
  `WaffeID` int(11) NOT NULL,
  `Kalender` int(1) DEFAULT '0',
  PRIMARY KEY (`TurnierID`,`WaffeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waffetur`
--

LOCK TABLES `waffetur` WRITE;
/*!40000 ALTER TABLE `waffetur` DISABLE KEYS */;
INSERT INTO `waffetur` VALUES (0,0,1),(1,0,0),(2,1,0),(3,0,0),(3,1,0),(4,0,0),(5,0,0),(5,1,0),(6,1,0),(7,1,0);
/*!40000 ALTER TABLE `waffetur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-29 15:48:59
