-- MySQL dump 10.16  Distrib 10.2.36-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: coorxyz_training
-- ------------------------------------------------------
-- Server version	10.2.36-MariaDB

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
-- Table structure for table `geom_user_tests`
--

DROP TABLE IF EXISTS `geom_user_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `geom_user_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(40) NOT NULL,
  `test_id` int(11) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `geom_user_tests`
--

LOCK TABLES `geom_user_tests` WRITE;
/*!40000 ALTER TABLE `geom_user_tests` DISABLE KEYS */;
INSERT INTO `geom_user_tests` VALUES (1,'6cc46a91-4e15-11eb-b5c9-a0369fc4af22',1,'{\"test_id\":\"1\",\"tasks\":[{\"task_id\":\"1\",\"options\":[{\"option_index\":\"0\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"2\",\"options\":[{\"option_index\":\"2\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"3\",\"options\":[{\"option_index\":\"2\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"4\",\"options\":[{\"option_index\":\"1\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"5\",\"options\":[{\"option_index\":\"1\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"6\",\"options\":[{\"option_index\":\"1\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"7\",\"options\":[{\"option_index\":\"1\",\"is_right\":false}],\"score\":1,\"errno\":0},{\"task_id\":\"8\",\"options\":[{\"option_index\":\"0\",\"is_right\":false}],\"score\":1,\"errno\":0},{\"task_id\":\"9\",\"options\":[{\"option_index\":\"1\",\"is_right\":true}],\"score\":1,\"errno\":0},{\"task_id\":\"10\",\"options\":[{\"option_index\":\"2\",\"is_right\":true}],\"score\":1,\"errno\":0}],\"score\":100}','2021-01-18 04:10:07'),(2,'6cc46a91-4e15-11eb-b5c9-a0369fc4af22',9,'{\"test_id\":\"9\",\"tasks\":[{\"task_id\":\"81\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"82\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"83\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"84\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"85\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"86\",\"options\":[{\"option_index\":\"0\",\"is_right\":true},{\"option_index\":\"1\",\"is_right\":false},{\"option_index\":\"2\",\"is_right\":true}],\"score\":0,\"errno\":2},{\"task_id\":\"87\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"88\",\"options\":[],\"score\":0,\"errno\":3}],\"score\":6}','2021-01-18 04:14:57'),(3,'6cc46a91-4e15-11eb-b5c9-a0369fc4af22',8,'{\"test_id\":\"8\",\"tasks\":[{\"task_id\":\"71\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"72\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"73\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"74\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"75\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"76\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"77\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"78\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"79\",\"options\":[],\"score\":0,\"errno\":3},{\"task_id\":\"80\",\"options\":[],\"score\":0,\"errno\":3}],\"score\":0}','2021-01-22 04:19:02');
/*!40000 ALTER TABLE `geom_user_tests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-22  6:51:51
