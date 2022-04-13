-- MySQL dump 10.13  Distrib 8.0.25, for macos11.3 (x86_64)
--
-- Host: localhost    Database: church_db
-- ------------------------------------------------------
-- Server version	8.0.25

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
-- Table structure for table `live_comments`
--

DROP TABLE IF EXISTS `live_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `live_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `names` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `comments` text,
  `time_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `country` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `video` int DEFAULT NULL,
  `deleted` smallint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_comments`
--

LOCK TABLES `live_comments` WRITE;
/*!40000 ALTER TABLE `live_comments` DISABLE KEYS */;
INSERT INTO `live_comments` VALUES (1,'NAKABIITO ENID','ashrikan@gmail.com','AM here watching with my friends','2021-10-12 10:43:46','Uganda',6,0),(2,'NAKABIITO ENID','ashrikan@gmail.com','Second comment here with me','2021-10-12 10:46:33','Uganda',6,0),(3,'Ashiraff Tumusiime','ashan@boostedtechs.com','AM here enjoying the good things','2021-10-12 11:22:16','Uganda',6,1),(4,'Ashiraff Tumusiime','ashan@boostedtechs.com','Here is the message of Good','2021-10-12 11:30:48','Uganda',6,0),(5,'Revival God\'s Knowledge Church','balyewunyajpk@gmail.com','Another dummy data','2021-10-14 15:58:40','Uganda',5,1);
/*!40000 ALTER TABLE `live_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_users`
--

DROP TABLE IF EXISTS `online_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `online_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `time_added` int DEFAULT NULL,
  `sessionxx` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_users`
--

LOCK TABLES `online_users` WRITE;
/*!40000 ALTER TABLE `online_users` DISABLE KEYS */;
INSERT INTO `online_users` VALUES (11,1634319057,'7ej1kubqasj1o2bpvovpuuc6ng');
/*!40000 ALTER TABLE `online_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `names` char(100) DEFAULT NULL,
  `email` char(100) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'TNI ADMIN','admin@tnichurch.online','ce186fbfe0e9afdd7d9664951b2e4996fd6c5ee5d4e645f2e7341f3467b070a5');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `video_title` char(100) DEFAULT NULL,
  `video_description` text,
  `video_url` char(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_live` smallint DEFAULT '0',
  `date_added` date DEFAULT NULL,
  `status` smallint DEFAULT '1',
  `user` int DEFAULT NULL,
  `deleted` smallint DEFAULT '0',
  `image` char(250) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'Summon','Summon description','https://www.youtube.com/watch?v=dnfBnXS6ZbY',0,'2021-10-14',0,NULL,0,'//localhost/dashboard/assets/placeholder.png'),(2,'Coming Home','Coming home is good to go.','https://www.youtube.com/watch?v=mFcQad6RFGo',0,'2021-10-14',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(3,'Video 3','Video three description','https://www.youtube.com/watch?v=mFcQad6RFGo',0,'2021-10-14',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(4,'Video 3','New messages from here','https://www.youtube.com/watch?v=mFcQad6RFGo',0,'2021-10-14',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(5,'Video extra','Extra video added','https://www.youtube.com/watch?v=mFcQad6RFGo',1,'2021-10-14',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(6,'New video for testing here','Adding new video','https://www.youtube.com/watch?v=mFcQad6RFGo',0,'2021-10-14',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(7,'New video','Ashanana','https://www.youtube.com/watch?v=aXDQaH5pVN0',0,'2021-10-15',2,1,0,'//localhost/dashboard/assets/placeholder.png'),(9,'video 8 reloaded','New video to show off','https://www.youtube.com/watch?v=mFcQad6RFGo',0,'2021-10-15',2,1,0,'//localhost/dashboard/assets/placeholder.png');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-13  9:39:44
