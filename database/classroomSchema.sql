CREATE DATABASE  IF NOT EXISTS `classroom` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `classroom`;
-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: classroom
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.28-MariaDB

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
-- Table structure for table `addcourse`
--

DROP TABLE IF EXISTS `addcourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `semcourse_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `cname` varchar(45) NOT NULL,
  `cdetail` varchar(1024) NOT NULL,
  `tid` int(11) NOT NULL DEFAULT '0',
  `tfname` varchar(45) NOT NULL,
  `tlname` varchar(45) NOT NULL,
  `room` varchar(45) NOT NULL,
  `week` varchar(7) NOT NULL,
  `cstart` time NOT NULL,
  `cend` time NOT NULL,
  `rating` double NOT NULL,
  `nrating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addcourse`
--

LOCK TABLES `addcourse` WRITE;
/*!40000 ALTER TABLE `addcourse` DISABLE KEYS */;
INSERT INTO `addcourse` VALUES (1,1,1,1,'Arabic','Arabin fun to learn',1,'Tao','Yan','My house','13','18:00:00','20:00:00',4,1),(2,4,4,1,'Writing','Writing can sharp your skills',1,'Tao','Yan','My house','14','15:00:00','17:00:00',4.5,22),(3,5,5,1,'Statistics','Good for management of your finantial',1,'Tao','Yan','My house','5','08:00:00','09:00:00',2.2,13),(4,6,6,1,'Math','Calculating probability statistics',1,'Tao','Yan','My house','06','06:00:00','08:00:00',5,4),(5,4,10,2,'Writing','Writing can sharp your skills',1,'Tao','Yan','My house','24','12:00:00','14:00:00',4.5,22),(6,5,14,2,'Statistics','Good for management of your finantial',1,'Tao','Yan','My house','2','09:00:00','11:00:00',2.2,13),(7,8,8,1,'Element Software Engineering','Software engineering is the application of engineering to the development of software in a systematic method.',2,'SheikhIqbal','Ahamed','Cadahy 401','1','18:30:00','21:10:00',4.9,40),(8,2,2,1,'English','English great tools',3,'Zuheng','Kang','My house','24','02:00:00','04:00:00',2.4,15),(9,3,3,1,'Chinese','Hardest language',3,'Zuheng','Kang','My house','3','12:00:00','13:00:00',3.2,32),(10,7,7,1,'French','Most Romantic language',3,'Zuheng','Kang','My house','0','04:00:00','05:00:00',0,0),(11,3,9,2,'Chinese','Hardest language',3,'Zuheng','Kang','My house','13','04:00:00','06:00:00',3.2,32),(12,7,11,2,'French','Most Romantic language',3,'Zuheng','Kang','My house','5','13:00:00','15:00:00',0,0),(13,2,12,2,'English','English great tools',3,'Zuheng','Kang','My house','04','05:00:00','08:00:00',2.4,15),(14,9,13,2,'Music','Music is human spirit',3,'Zuheng','Kang','My house','14','06:00:00','10:00:00',5,10),(15,9,15,3,'Music','Music is human spirit',3,'Zuheng','Kang','My house','123','00:00:00','05:00:00',5,10);
/*!40000 ALTER TABLE `addcourse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(45) NOT NULL,
  `detail` varchar(1024) NOT NULL,
  `teacher_id` varchar(45) NOT NULL,
  `rating` double NOT NULL,
  `nrating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Arabic','Arabin fun to learn','1',4,1),(2,'English','English great tools','3',2.4,15),(3,'Chinese','Hardest language','3',3.2,32),(4,'Writing','Writing can sharp your skills','1',4.5,22),(5,'Statistics','Good for management of your finantial','1',2.2,13),(6,'Math','Calculating probability statistics','1',5,4),(7,'French','Most Romantic language','3',0,0),(8,'Element Software Engineering','Software engineering is the application of engineering to the development of software in a systematic method.','2',4.9,40),(9,'Music','Music is human spirit','3',5,10);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semcourse`
--

DROP TABLE IF EXISTS `semcourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `room` varchar(45) NOT NULL,
  `week` varchar(7) NOT NULL,
  `cstart` time NOT NULL,
  `cend` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semcourse`
--

LOCK TABLES `semcourse` WRITE;
/*!40000 ALTER TABLE `semcourse` DISABLE KEYS */;
INSERT INTO `semcourse` VALUES (1,1,1,'My house','13','18:00:00','20:00:00'),(2,2,1,'My house','24','02:00:00','04:00:00'),(3,3,1,'My house','3','12:00:00','13:00:00'),(4,4,1,'My house','14','15:00:00','17:00:00'),(5,5,1,'My house','5','08:00:00','09:00:00'),(6,6,1,'My house','06','06:00:00','08:00:00'),(7,7,1,'My house','0','04:00:00','05:00:00'),(8,8,1,'Cadahy 401','1','18:30:00','21:10:00'),(9,3,2,'My house','13','04:00:00','06:00:00'),(10,4,2,'My house','24','12:00:00','14:00:00'),(11,7,2,'My house','5','13:00:00','15:00:00'),(12,2,2,'My house','04','05:00:00','08:00:00'),(13,9,2,'My house','14','06:00:00','10:00:00'),(14,5,2,'My house','2','09:00:00','11:00:00'),(15,9,3,'My house','123','00:00:00','05:00:00');
/*!40000 ALTER TABLE `semcourse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` VALUES (1,2017,2,'2017-08-27','2017-12-16'),(2,2018,0,'2018-01-14','2018-05-16'),(3,2018,1,'2018-06-14','2018-08-08'),(4,2018,2,'2018-08-21','2018-12-14'),(5,2019,0,'2019-01-17','2019-05-11');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stucourse`
--

DROP TABLE IF EXISTS `stucourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stucourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `grade` varchar(2) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `read_time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stucourse`
--

LOCK TABLES `stucourse` WRITE;
/*!40000 ALTER TABLE `stucourse` DISABLE KEYS */;
INSERT INTO `stucourse` VALUES (2,2,1,1,'',5,'If you want to know the art of language, Arabic will be your choice.','1970-01-01'),(3,3,1,1,'',4,'Arabic is fun to learn, I love Arabic.','1970-01-01'),(7,1,8,1,'',NULL,NULL,'1970-01-01');
/*!40000 ALTER TABLE `stucourse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'robert','a@a.a','6a204bd89f3c8348afd5c77c717a097a','robertbogan','kang','55512315','My house',1),(2,'bogan','b@b.b','6a204bd89f3c8348afd5c77c717a097a','bogan','kang','2312312',NULL,1),(3,'kang','c@c.c','6a204bd89f3c8348afd5c77c717a097a','kang','ahh','12312312',NULL,1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `office` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (1,'austin','tao.yan@mu.edu','Library MSCS','6a204bd89f3c8348afd5c77c717a097a','Tao','Yan','42214123','Somewhere',1),(2,'iqbal','sheikh.ahamed@marquette.edu','Katharine Reed Cudahy Hall, Room 386','6a204bd89f3c8348afd5c77c717a097a','SheikhIqbal','Ahamed','',NULL,1),(3,'zuheng','zuheng.kang@marquette.edu','Library MSCS','6a204bd89f3c8348afd5c77c717a097a','Zuheng','Kang','4142043668','somewhere',1);
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-02  3:13:06
