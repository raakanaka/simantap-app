-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: simantap_dynamic
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','$2y$12$E2rengWTMAxKO38Hv6nkH.hFzIO6wQzmbcH2JyCh2uV08mULA60em','Administrator','admin@test.com','super_admin','081234567890','Jl. Admin No. 123','active','2025-09-10 10:14:35','2025-09-10 10:14:35');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_requirements`
--

DROP TABLE IF EXISTS `exam_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_type_id` bigint unsigned NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `file_types` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_size` int NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_requirements_exam_type_id_foreign` (`exam_type_id`),
  CONSTRAINT `exam_requirements_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_requirements`
--

LOCK TABLES `exam_requirements` WRITE;
/*!40000 ALTER TABLE `exam_requirements` DISABLE KEYS */;
INSERT INTO `exam_requirements` VALUES (1,4,'Rekap Nilai + Asli KHS Semester I s/d VII','Dokumen Rekap Nilai + Asli KHS Semester I s/d VII',1,'PDF',10240,1,'2025-09-10 10:22:01','2025-09-10 10:22:01'),(2,4,'Rekap SKK (Kartu E) + Sertifikat','Dokumen Rekap SKK (Kartu E) + Sertifikat',1,'PDF',10240,2,'2025-09-10 10:22:01','2025-09-10 10:22:01'),(3,4,'Nilai/Sertifikat Kelulusan KKN','Dokumen Nilai/Sertifikat Kelulusan KKN',1,'PDF',10240,3,'2025-09-10 10:22:01','2025-09-10 10:22:01'),(4,4,'Asli Blangko Pembayaran SPP Semester 1 s/d VIII','Dokumen Asli Blangko Pembayaran SPP Semester 1 s/d VIII',1,'PDF',10240,4,'2025-09-10 10:22:01','2025-09-10 10:22:01'),(5,4,'Sertifikat/Nilai Kelulusan Praktikum Semester I s/d VII','Dokumen Sertifikat/Nilai Kelulusan Praktikum Semester I s/d VII',1,'PDF',10240,5,'2025-09-10 10:22:01','2025-09-10 10:22:01'),(6,5,'Formulir Pendaftaran','Dokumen Formulir Pendaftaran',1,'PDF',10240,1,'2025-09-10 10:22:08','2025-09-10 10:22:08'),(7,5,'Draf Jurnal','Dokumen Draf Jurnal',1,'PDF',10240,2,'2025-09-10 10:22:08','2025-09-10 10:22:08'),(8,5,'Slip UKT Asli Semester 1–9','Dokumen Slip UKT Asli Semester 1–9',1,'PDF',10240,3,'2025-09-10 10:22:08','2025-09-10 10:22:08'),(9,5,'Daftar Hadir Mengikuti Ujian Semhas Jurnal','Dokumen Daftar Hadir Mengikuti Ujian Semhas Jurnal',1,'PDF',10240,4,'2025-09-10 10:22:08','2025-09-10 10:22:08'),(10,6,'Formulir Pendaftaran','Dokumen Formulir Pendaftaran',1,'PDF',10240,1,'2025-09-10 10:22:15','2025-09-10 10:22:15'),(11,6,'Proposal Skripsi','Dokumen Proposal Skripsi',1,'PDF',10240,2,'2025-09-10 10:22:15','2025-09-10 10:22:15'),(12,6,'Slip UKT Asli Semester 1–9','Dokumen Slip UKT Asli Semester 1–9',1,'PDF',10240,3,'2025-09-10 10:22:15','2025-09-10 10:22:15'),(13,6,'Daftar Hadir Mengikuti Sidang','Dokumen Daftar Hadir Mengikuti Sidang',1,'PDF',10240,4,'2025-09-10 10:22:15','2025-09-10 10:22:15'),(14,7,'Asli KTM','Dokumen Asli KTM',1,'PDF',10240,1,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(15,7,'Ijazah SLTA (tidak harus dileges)','Dokumen Ijazah SLTA (tidak harus dileges)',1,'PDF',10240,2,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(16,7,'KTP','Dokumen KTP',1,'PDF',10240,3,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(17,7,'Pas Photo 3x4 Hitam Putih','Dokumen Pas Photo 3x4 Hitam Putih',1,'JPG',10240,4,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(18,7,'Abstraksi Jurnal','Dokumen Abstraksi Jurnal',1,'PDF',10240,5,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(19,7,'Asli Pembayaran UKT Semester 1 s/d Terakhir','Dokumen Asli Pembayaran UKT Semester 1 s/d Terakhir',1,'PDF',10240,6,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(20,7,'Surat Keterangan Bebas Plagiasi','Dokumen Surat Keterangan Bebas Plagiasi',1,'PDF',10240,7,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(21,7,'Surat Keterangan Lulus Ujian Kompri','Dokumen Surat Keterangan Lulus Ujian Kompri',1,'PDF',10240,8,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(22,7,'Kartu Bimbingan Asli','Dokumen Kartu Bimbingan Asli',1,'PDF',10240,9,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(23,7,'Sertifikat TOEFL/TOAFL dari PUSBINSA UINSU','Dokumen Sertifikat TOEFL/TOAFL dari PUSBINSA UINSU',1,'PDF',10240,10,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(24,7,'Surat Permohonan Ujian ke Dekan','Dokumen Surat Permohonan Ujian ke Dekan',1,'PDF',10240,11,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(25,7,'Surat Pernyataan Keaslian Karya Ilmiah bermaterai Rp. 10.000','Dokumen Surat Pernyataan Keaslian Karya Ilmiah bermaterai Rp. 10.000',1,'PDF',10240,12,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(26,7,'Lembar Perbaikan Seminar Hasil','Dokumen Lembar Perbaikan Seminar Hasil',1,'PDF',10240,13,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(27,7,'Transkrip Nilai','Dokumen Transkrip Nilai',1,'PDF',10240,14,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(28,7,'Artikel Jurnal dilengkapi: Surat persetujuan Pembimbing + LOA','Dokumen Artikel Jurnal dilengkapi: Surat persetujuan Pembimbing + LOA',1,'PDF',10240,15,'2025-09-10 10:22:23','2025-09-10 10:22:23'),(29,8,'Asli KTM','Dokumen Asli KTM',1,'PDF',10240,1,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(30,8,'Ijazah SLTA (tidak harus dileges)','Dokumen Ijazah SLTA (tidak harus dileges)',1,'PDF',10240,2,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(31,8,'KTP','Dokumen KTP',1,'PDF',10240,3,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(32,8,'Pas Photo 3x4 Hitam Putih','Dokumen Pas Photo 3x4 Hitam Putih',1,'JPG',10240,4,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(33,8,'Abstraksi Skripsi','Dokumen Abstraksi Skripsi',1,'PDF',10240,5,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(34,8,'Asli Pembayaran UKT Semester 1 s/d Terakhir','Dokumen Asli Pembayaran UKT Semester 1 s/d Terakhir',1,'PDF',10240,6,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(35,8,'Surat Keterangan Bebas Plagiasi','Dokumen Surat Keterangan Bebas Plagiasi',1,'PDF',10240,7,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(36,8,'Surat Keterangan Lulus Ujian Kompri','Dokumen Surat Keterangan Lulus Ujian Kompri',1,'PDF',10240,8,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(37,8,'Kartu Bimbingan Asli','Dokumen Kartu Bimbingan Asli',1,'PDF',10240,9,'2025-09-10 10:22:32','2025-09-10 10:22:32'),(38,8,'Sertifikat TOEFL/TOAFL dari PUSBINSA UINSU','Dokumen Sertifikat TOEFL/TOAFL dari PUSBINSA UINSU',1,'PDF',10240,10,'2025-09-10 10:22:33','2025-09-10 10:22:33'),(39,8,'Surat Permohonan Ujian ke Dekan','Dokumen Surat Permohonan Ujian ke Dekan',1,'PDF',10240,11,'2025-09-10 10:22:33','2025-09-10 10:22:33'),(40,8,'Lembar Perbaikan Seminar Proposal','Dokumen Lembar Perbaikan Seminar Proposal',1,'PDF',10240,12,'2025-09-10 10:22:33','2025-09-10 10:22:33'),(41,8,'Transkrip Nilai','Dokumen Transkrip Nilai',1,'PDF',10240,13,'2025-09-10 10:22:33','2025-09-10 10:22:33'),(42,8,'Skripsi yang dilengkapi dengan: Surat Pengesahan PS I & PS II, Surat Riset Fakultas & Balasan, Surat Pernyataan Keaslian Skripsi bermaterai Rp. 10.000, Surat Istimewa (Panggilan Sidang) PS I & PS II','Dokumen Skripsi yang dilengkapi dengan: Surat Pengesahan PS I & PS II, Surat Riset Fakultas & Balasan, Surat Pernyataan Keaslian Skripsi bermaterai Rp. 10.000, Surat Istimewa (Panggilan Sidang) PS I & PS II',1,'PDF',10240,14,'2025-09-10 10:22:33','2025-09-10 10:22:33');
/*!40000 ALTER TABLE `exam_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_types`
--

DROP TABLE IF EXISTS `exam_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_types_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_types`
--

LOCK TABLES `exam_types` WRITE;
/*!40000 ALTER TABLE `exam_types` DISABLE KEYS */;
INSERT INTO `exam_types` VALUES (4,'Ujian Komprehensif','KOMPRE','Ujian Komprehensif untuk mahasiswa','active','2025-09-10 10:19:18','2025-09-10 10:19:18'),(5,'Seminar Hasil Jurnal','SEMINAR_JURNAL','Seminar Proposal Draf Artikel Jurnal Ilmiah','active','2025-09-10 10:19:18','2025-09-10 10:21:41'),(6,'Seminar Proposal Skripsi','SEMINAR_SKRIPSI','Seminar Proposal Skripsi','active','2025-09-10 10:19:18','2025-09-10 10:19:18'),(7,'Sidang Kolokium Jurnal','KOLOKIUM_JURNAL','Sidang Kolokium Jurnal','active','2025-09-10 10:19:18','2025-09-10 10:19:18'),(8,'Sidang Munaqasyah Skripsi','MUNAQASYAH_SKRIPSI','Sidang Munaqasyah Skripsi','active','2025-09-10 10:19:18','2025-09-10 10:19:18');
/*!40000 ALTER TABLE `exam_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulir_pendaftarans`
--

DROP TABLE IF EXISTS `formulir_pendaftarans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulir_pendaftarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `study_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thesis_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_status` json NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulir_pendaftarans`
--

LOCK TABLES `formulir_pendaftarans` WRITE;
/*!40000 ALTER TABLE `formulir_pendaftarans` DISABLE KEYS */;
/*!40000 ALTER TABLE `formulir_pendaftarans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expertise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `study_program_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecturers_nip_unique` (`nip`),
  UNIQUE KEY `lecturers_email_unique` (`email`),
  KEY `lecturers_study_program_id_foreign` (`study_program_id`),
  CONSTRAINT `lecturers_study_program_id_foreign` FOREIGN KEY (`study_program_id`) REFERENCES `study_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

LOCK TABLES `lecturers` WRITE;
/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_08_071026_create_students_table',1),(5,'2025_09_08_071029_create_admins_table',1),(6,'2025_09_08_071029_create_exam_types_table',1),(7,'2025_09_08_071029_create_lecturers_table',1),(8,'2025_09_08_071030_create_exam_requirements_table',1),(9,'2025_09_08_071031_create_submissions_table',1),(10,'2025_09_08_071032_create_submission_documents_table',1),(11,'2025_09_08_093854_create_study_programs_table',1),(12,'2025_09_08_094712_add_study_program_id_to_lecturers_table',1),(13,'2025_09_08_174858_add_ktm_file_to_students_table',1),(14,'2025_09_09_034726_add_title_description_to_submissions_table',1),(15,'2025_09_09_035627_make_requirement_id_nullable_in_submission_documents',1),(16,'2025_09_09_104234_create_formulir_pendaftarans_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `study_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `ktm_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_nim_unique` (`nim`),
  UNIQUE KEY `students_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'1234567890','$2y$12$KcnUSS633o8f9UZxAeB0QuRtwikM.AUFpwQsBtw6BVVma9bwBrXRu','Mahasiswa Test','mahasiswa@test.com','Teknik Informatika','Fakultas Teknik',6,'081234567890','Jl. Test No. 123',NULL,'active',1,NULL,NULL,NULL,'2025-09-10 10:14:29','2025-09-10 10:14:29');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `study_programs`
--

DROP TABLE IF EXISTS `study_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `study_programs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `study_programs_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `study_programs`
--

LOCK TABLES `study_programs` WRITE;
/*!40000 ALTER TABLE `study_programs` DISABLE KEYS */;
INSERT INTO `study_programs` VALUES (1,'PAI','Manajemen Dakwah','Fakultas Dakwah',NULL,1,'2025-09-10 10:15:10','2025-09-10 10:15:10');
/*!40000 ALTER TABLE `study_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_documents`
--

DROP TABLE IF EXISTS `submission_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint unsigned NOT NULL,
  `requirement_id` bigint unsigned DEFAULT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stored_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submission_documents_submission_id_foreign` (`submission_id`),
  KEY `submission_documents_requirement_id_foreign` (`requirement_id`),
  CONSTRAINT `submission_documents_requirement_id_foreign` FOREIGN KEY (`requirement_id`) REFERENCES `exam_requirements` (`id`),
  CONSTRAINT `submission_documents_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_documents`
--

LOCK TABLES `submission_documents` WRITE;
/*!40000 ALTER TABLE `submission_documents` DISABLE KEYS */;
INSERT INTO `submission_documents` VALUES (1,1,6,'Formulir_Seminar_Proposal_Skripsi_2021014_2025-09-10 (2).pdf','1757525043_Formulir_Seminar_Proposal_Skripsi_2021014_2025-09-10 (2).pdf','submissions/1/1757525043_Formulir_Seminar_Proposal_Skripsi_2021014_2025-09-10 (2).pdf',2830,'application/octet-stream','2025-09-10 10:24:03','2025-09-10 10:24:03'),(2,1,7,'Formulir_Kolokium_2021014_2025-09-10 (4).pdf','1757525043_Formulir_Kolokium_2021014_2025-09-10 (4).pdf','submissions/1/1757525043_Formulir_Kolokium_2021014_2025-09-10 (4).pdf',5478,'application/octet-stream','2025-09-10 10:24:03','2025-09-10 10:24:03'),(3,1,8,'Formulir_Kolokium_2021014_2025-09-10 (2).pdf','1757525043_Formulir_Kolokium_2021014_2025-09-10 (2).pdf','submissions/1/1757525043_Formulir_Kolokium_2021014_2025-09-10 (2).pdf',5478,'application/octet-stream','2025-09-10 10:24:03','2025-09-10 10:24:03'),(4,1,9,'ITINERARY 10D TULIP IN TURKIYE APRIL 2026 POLOS (1).pdf','1757525043_ITINERARY 10D TULIP IN TURKIYE APRIL 2026 POLOS (1).pdf','submissions/1/1757525043_ITINERARY 10D TULIP IN TURKIYE APRIL 2026 POLOS (1).pdf',190630,'application/octet-stream','2025-09-10 10:24:03','2025-09-10 10:24:03');
/*!40000 ALTER TABLE `submission_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_study_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_type_id` bigint unsigned NOT NULL,
  `exam_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu_verifikasi','berkas_diterima','berkas_ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `submitted_at` timestamp NOT NULL,
  `revision_reason` text COLLATE utf8mb4_unicode_ci,
  `verified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submissions_submission_number_unique` (`submission_number`),
  KEY `submissions_exam_type_id_foreign` (`exam_type_id`),
  CONSTRAINT `submissions_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submissions`
--

LOCK TABLES `submissions` WRITE;
/*!40000 ALTER TABLE `submissions` DISABLE KEYS */;
INSERT INTO `submissions` VALUES (1,'SUB-2025-0001','1234567890','Mahasiswa Test','Teknik Informatika',5,'Seminar Hasil Jurnal','sssssssssssssssssssssssssssssssssssssssss','ssssssss','berkas_diterima','2025-09-10 10:24:03',NULL,'Administrator','2025-09-10 10:29:07','2025-09-10 10:24:03','2025-09-10 10:29:07');
/*!40000 ALTER TABLE `submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-09-11  0:35:03
