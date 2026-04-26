-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: LIBERA
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `denda_perhari` int(11) NOT NULL DEFAULT 5000,
  `cover` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (8,'Angin Berhembus','Cahaya Dewi',7,5000,'1776657694_d79248c7d5e3ae0a9535.webp'),(9,'kala Itu Langit Bisu','Kim Chun Hei',8,5000,'1776657703_579aee34159c732ece32.webp'),(10,'Surat untuk Senja','Soo Jin Ae',7,5000,'1776657709_b17d0074dd0e6391a2f6.webp'),(11,'perahu Tanpa Narkoba','Juliana Silva',9,5000,'1776657718_8beac84aceec17a6a59c.webp'),(12,'Haunted House','Ken Adams',9,5000,'1776661468_db64e2f82d10323e0a57.jpg'),(13,'Suara Misterius Dirumah Tua','Adeline Palmerston',9,5000,'1776708333_6485fc6c44742afcf68c.webp'),(14,'Apa Adanya','Chandra Barkah',10,5000,'1776712145_c2b24fb282432f9f3ed6.jpg'),(15,'Jejak Kepribadian','Cahaya Dewi',10,5000,'1776712223_ccd090372ff0c59920a7.webp'),(16,'Free Fire ','Rianngraha',10,5000,'1776712467_6a35d0643b655ed13dd3.png'),(17,'MEOW','Sam Austen',10,5000,'1776712629_26b99d237234313a8a75.jpg'),(18,'Interaksi Antar Galaksi Yang Tak Dikenal','Samira Hadid',10,5000,'1776876059_2bc6945c7ce999348922.webp'),(20,'Menanti Restu Langit','Makhasin',10,5000,'1776876375_8f0eabd58aa7eb73a382.jpg');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  `denda` int(11) NOT NULL DEFAULT 0,
  `status` enum('dipinjam','diajukan','kembali') NOT NULL DEFAULT 'dipinjam',
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (10,2,8,'2026-04-20','2026-04-23','2026-04-20',0,'kembali'),(11,2,10,'2026-04-20','2026-04-23','2026-04-20',0,'kembali'),(12,4,12,'2026-04-20','2026-04-21','2026-04-20',0,'kembali'),(14,4,13,'2026-04-20','2026-04-21','2026-04-20',0,'kembali'),(15,5,11,'2026-04-20','2026-04-21','2026-04-25',20000,'kembali'),(16,2,9,'2026-04-21','2026-04-22','2026-04-21',0,'kembali'),(17,4,14,'2026-04-21','2026-04-20','2026-04-21',5000,'kembali'),(26,NULL,9,'2026-04-22','2026-04-25',NULL,0,'dipinjam'),(27,NULL,10,'2026-04-22','2026-04-25',NULL,0,'dipinjam'),(28,5,10,'2026-04-22','2026-04-20','2026-04-22',10000,'kembali'),(29,NULL,9,'2026-04-23','2026-04-26',NULL,0,'dipinjam'),(30,5,8,'2026-04-23','2026-04-25','2026-04-23',0,'kembali'),(31,2,9,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(32,2,9,'2026-04-25','2026-04-23','2026-04-25',0,'kembali'),(33,2,8,'2026-04-25','2026-04-23','2026-04-25',0,'kembali'),(35,5,9,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(36,5,10,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(37,5,8,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(38,5,10,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(39,5,11,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(40,5,12,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(41,5,13,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(42,5,8,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(43,2,8,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(44,2,10,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali'),(45,2,9,'2026-04-25','2026-04-23','2026-04-25',10000,'kembali');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rendi Nurcahyadin','aa','rendi','$2y$10$7tVGmrEAMXyuDX.yNyEEAOYTaGtHFT30ceURbxjba0ETgp/ehcXEK','admin','1776306804_36a78e4166b70ff4fdf6.jpg','aktif','2026-04-11 04:09:20'),(2,'Didit Fathul','ii','didit','$2y$10$yHad6TPWSz2OuXkqYtFZeOBgsmQywENU6WcSRR1uv5PlLewueQm.u','anggota','1775922954_f6ca7603ea282f741383.jpg','aktif','2026-04-11 04:10:29'),(3,'fahmi','uu@gmail.com','fahmi','$2y$10$z8fcPM3rSBxnEpuJtMF6TOTVonvWN.BGCO73yZYL5oc98.tslb3M.','petugas','1775922933_9cacc397066153d26efe.jpg','aktif','2026-04-11 04:32:37'),(4,'reza','reza@gmail.com','reza','$2y$10$gXyZalWYdfNoB2/6LxnUcueaadM5o7OC3.8Al/H/L.d5h..FpUPAe','anggota','1776219831_e48386b7b20a96a2197b.jpg','aktif','2026-04-11 17:38:44'),(5,'rian','rian@gmail.com','rian','$2y$10$/v4HP34lJ9nE/4kRYl9uweX2.YhrOJUP74bjCJbnzk0dmX/4bok6a','anggota','1776710545_d69c67cfbfaebd96e66f.jpg','aktif','2026-04-20 18:42:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-26 14:39:43
