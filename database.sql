-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: sps_malangwa
-- ------------------------------------------------------
-- Server version	8.0.46

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
-- Table structure for table `academic_calendars`
--

DROP TABLE IF EXISTS `academic_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_calendars` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_calendars`
--

LOCK TABLES `academic_calendars` WRITE;
/*!40000 ALTER TABLE `academic_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `academic_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `academic_programs`
--

DROP TABLE IF EXISTS `academic_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_programs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('ecd','basic_1_5','basic_6_8','secondary_9_10','higher_secondary') COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_np` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_programs`
--

LOCK TABLES `academic_programs` WRITE;
/*!40000 ALTER TABLE `academic_programs` DISABLE KEYS */;
INSERT INTO `academic_programs` VALUES (1,'ecd','ECD / Nursery',NULL,'ecd',NULL,'<p>Play-based start to formal schooling — early language, early numeracy, creative expression and social habits under the CDC national framework. Readiness for Grade 1 is emphasised over premature formal testing.</p>','<p>राष्ट्रिय पाठ्यक्रम (सीडीसी) अनुसार खेलमार्फत सिकाइ — प्रारम्भिक भाषा, अंक ज्ञान, सिर्जनात्मक अभिव्यक्ति र सामाजिक बानी। कक्षा १ को तयारीलाई प्राथमिकता।</p>',1,1),(2,'grades-1-5','Grades 1–5',NULL,'basic_1_5',NULL,'<p>Foundational literacy and numeracy — reading and writing in Nepali and English, arithmetic and introduction to the natural and social environment under the national curriculum.</p>','<p>आधारभूत साक्षरता र अंक ज्ञान — नेपाली र अंग्रेजीमा पढाइ र लेखाइ, अंकगणित तथा प्राकृतिक र सामाजिक वातावरणको परिचय।</p>',2,1),(3,'grades-6-8','Grades 6–8',NULL,'basic_6_8',NULL,'<p>Structured subject learning — English and Nepali literacy, mathematics, science, social studies and health &amp; physical education with study habits for secondary readiness.</p>','<p>संरचित विषयगत सिकाइ — अंग्रेजी र नेपाली साक्षरता, गणित, विज्ञान, सामाजिक अध्ययन र स्वास्थ्य तथा शारीरिक शिक्षा।</p>',3,1),(4,'grades-9-10','Grades 9–10 (SEE)',NULL,'secondary_9_10',NULL,'<p>Secondary Level culminating in the Secondary Education Examination (SEE) at the end of Grade 10. Emphasis on subject depth, examination readiness and preparation for higher secondary.</p>','<p>कक्षा १० को अन्त्यमा माध्यमिक शिक्षा परीक्षा (एसईई) मा समापन हुने माध्यमिक तह। विषयगत गहिराइ, परीक्षा तयारी र उच्च माध्यमिकको तयारीमा जोड।</p>',4,1),(5,'plus2-science','+2 Science',NULL,'higher_secondary','Science','<p>Two-year NEB Science stream — scientific reasoning, mathematics, analytical thinking and practical problem solving. Prepares for further study in science, technology, health sciences and engineering.</p>','<p>दुई वर्षे एनईबी विज्ञान स्ट्रिम — वैज्ञानिक तर्क, गणित, विश्लेषणात्मक सोच र व्यावहारिक समस्या समाधान। विज्ञान, प्रविधि, स्वास्थ्य विज्ञान र इन्जिनियरिङमा थप अध्ययनको तयारी।</p>',5,1),(6,'plus2-management','+2 Management',NULL,'higher_secondary','Management','<p>Two-year NEB Management stream — business understanding, accounting concepts, economics and organisational thinking, communication &amp; entrepreneurship.</p>','<p>दुई वर्षे एनईबी व्यवस्थापन स्ट्रिम — व्यापार बुझाइ, लेखा अवधारणा, अर्थशास्त्र र संगठनात्मक सोच, सञ्चार र उद्यमशीलता।</p>',6,1);
/*!40000 ALTER TABLE `academic_programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_logs_user` (`user_id`,`created_at`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'block.update','content_blocks','40','home:intro',NULL,'2026-08-26 07:18:02'),(2,1,'block.update','content_blocks','9','about:page_header',NULL,'2026-08-26 07:24:44'),(3,1,'block.update','content_blocks','9','about:page_header',NULL,'2026-08-26 07:26:09'),(4,1,'block.update','content_blocks','39','home:hero',NULL,'2026-08-26 10:45:37'),(5,1,'block.update','content_blocks','40','home:intro',NULL,'2026-08-26 10:46:15'),(6,1,'block.update','content_blocks','40','home:intro',NULL,'2026-08-31 15:51:58'),(7,1,'block.update','content_blocks','40','home:intro',NULL,'2026-08-31 16:17:31'),(8,1,'block.update','content_blocks','39','home:hero',NULL,'2026-08-31 19:02:46'),(9,1,'block.update','content_blocks','40','home:intro',NULL,'2026-09-01 13:48:40');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_contact_read` (`is_read`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Robertadutt','85178487226','aloha313@web.de','The perfect start a $25,000 promo code','Get buzzing with a $25,000 promo code https://link.1hut.ru/iPhlDA','en',0,'2026-09-01 21:21:57');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_blocks`
--

DROP TABLE IF EXISTS `content_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `content_blocks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `body_np` mediumtext COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `idx_blocks_page` (`page_slug`,`section_key`,`sort_order`),
  CONSTRAINT `content_blocks_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_blocks`
--

LOCK TABLES `content_blocks` WRITE;
/*!40000 ALTER TABLE `content_blocks` DISABLE KEYS */;
INSERT INTO `content_blocks` VALUES (1,'home','stat',1,'45+','४५+',NULL,NULL,'Qualified Teachers','योग्य शिक्षकहरू',NULL,'groups',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 10:42:21'),(2,'home','stat',2,'1,000+','१,०००+',NULL,NULL,'Students','विद्यार्थीहरू',NULL,'groups',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(3,'home','stat',3,'1947','१९४७',NULL,NULL,'Established','स्थापना',NULL,'history_edu',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(4,'home','stat',4,'98%','९८%',NULL,NULL,'Pass Rate','उत्तीर्ण दर',NULL,'verified',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(5,'home','commitment',2,'Two NEB Streams','दुई एनईबी स्ट्रिमहरू',NULL,NULL,'+2 Science & Management under NEB.','एनईबी अन्तर्गत +२ विज्ञान र व्यवस्थापन।',NULL,'workspace_premium',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(6,'home','commitment',3,'Community Focus','सामुदायिक केन्द्रित',NULL,NULL,'Serving families of Malangwa-2 and surrounding wards.','मलंगवा-२ र वरपरका वडाका परिवारहरूको सेवा।',NULL,'biotech',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(7,'home','commitment',4,'Government Oversight','सरकारी रेखदेख',NULL,NULL,'Public community school — IEMIS 190640003.','सामुदायिक विद्यालय — IEMIS १९०६४०००३।',NULL,'handshake',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(8,'home','cta_banner',0,'Admissions Now Open for 2082','२०८२ का लागि भर्ना खुला छ',NULL,NULL,'Secure a bright future. Join Shree Public Secondary School today.','उज्ज्वल भविष्य सुनिश्चित गर्नुहोस्। आजै श्री पब्लिक माध्यमिक विद्यालयमा सामेल हुनुहोस्।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(9,'about','page_header',0,'About Our School','हाम्रो विद्यालयको बारेमा','Malangwa-2, Sarlahi','मलंगवा-२, सर्लाही','Shree Public Secondary School is a government-recognized community school in Malangwa-2, Sarlahi. Registered under IEMIS Code 190640003, we provide holistic education from Early Childhood Development (ECD) through Grade 12.',NULL,NULL,NULL,NULL,1,1,'2026-08-26 07:04:21','2026-08-26 07:24:44'),(10,'about','intro',1,'A Pillar of Community Education','सामुदायिक शिक्षाको आधार',NULL,NULL,'Shree Public Secondary School stands at the heart of Malangwa as a cornerstone of government-led education in Madhesh Province. As a public community school, we are dedicated to providing accessible, high-quality education to over 1,000 students.','श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेशमा सरकारी शिक्षाको आधारशिलाको रूपमा मलंगवाको केन्द्रमा खडा छ। एक सार्वजनिक सामुदायिक विद्यालयको रूपमा, हामी १,००० भन्दा बढी विद्यार्थीहरूलाई पहुँचयोग्य, गुणस्तरीय शिक्षा प्रदान गर्न समर्पित छौं।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(11,'about','value',1,'Vision','परिकल्पना',NULL,NULL,'To be a leading center of educational excellence in Madhesh Province, empowering students with knowledge, skills, and values for a global future.','मधेश प्रदेशमा शैक्षिक उत्कृष्टताको अग्रणी केन्द्र बन्ने, विद्यार्थीहरूलाई वैश्विक भविष्यका लागि ज्ञान, सीप र मूल्यहरूद्वारा सशक्त बनाउने।',NULL,'visibility',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(12,'about','value',2,'Mission','लक्ष्य',NULL,NULL,'Providing accessible, high-quality public education from ECD to Grade 12, fostering an inclusive environment that nurtures intellectual growth and civic responsibility.','ईसीडीदेखि कक्षा १२ सम्म पहुँचयोग्य, उच्च गुणस्तरीय सार्वजनिक शिक्षा प्रदान गर्ने, बौद्धिक वृद्धि र नागरिक जिम्मेवारीलाई पोषण गर्ने समावेशी वातावरण निर्माण गर्ने।',NULL,'school',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(13,'about','value',3,'Values','मूल्यहरू',NULL,NULL,'Integrity, Inclusivity, Excellence, and Community Trust.','इमानदारी, समावेशिता, उत्कृष्टता र सामुदायिक विश्वास।',NULL,'workspace_premium',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(14,'about','timeline',1,'2003 BS','२००३ साल','1947 AD','सन् १९४७','Establishment of the school as a primary education center.','प्राथमिक शिक्षा केन्द्रको रूपमा विद्यालयको स्थापना।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(15,'about','timeline',4,'2080 BS','२०८० साल',NULL,NULL,'Modernization with ICT-integrated Smart Classrooms.','आईसीटी एकीकृत स्मार्ट कक्षाहरू सहित आधुनिकीकरण।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(16,'about','facility',1,'Science Laboratory','विज्ञान प्रयोगशाला',NULL,NULL,'Well-equipped for Physics, Chemistry, and Biology experiments.','भौतिक विज्ञान, रसायन विज्ञान र जीव विज्ञान प्रयोगका लागि सुसज्जित।','uploads/gallery/campus/staff-room-interior.jpg',NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(17,'about','facility',2,'ICT Lab','आईसीटी ल्याब',NULL,NULL,'Modern computer lab with internet access for smart learning.','स्मार्ट लर्निङका लागि इन्टरनेट सहितको आधुनिक कम्प्युटर ल्याब।','uploads/gallery/campus/staff-room-computer.jpg',NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(18,'about','facility',3,'Library','पुस्तकालय',NULL,NULL,'A collection of academic and reference books for all levels.','सबै तहका लागि शैक्षिक र सन्दर्भ पुस्तकहरूको संग्रह।','uploads/gallery/campus/headmaster-office.jpg',NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(19,'about','facility',4,'Sports Ground','खेल मैदान',NULL,NULL,'Space for athletics, football, and community events.','एथलेटिक्स, फुटबल र सामुदायिक कार्यक्रमहरूका लागि ठाउँ।','uploads/gallery/campus/courtyard-students-formation.jpg',NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(20,'about','cta_join',0,'Join Our Community','हाम्रो समुदायमा सामेल हुनुहोस्',NULL,NULL,'Explore our academic programs or start the admission process today to become part of Shree Public Secondary School.','हाम्रा शैक्षिक कार्यक्रमहरू अन्वेषण गर्नुहोस् वा आजै श्री पब्लिक माध्यमिक विद्यालयको हिस्सा बन्न भर्ना प्रक्रिया सुरु गर्नुहोस्।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(21,'faq','faq_item',4,'Where are official notices published?','आधिकारिक सूचनाहरू कहाँ प्रकाशित हुन्छन्?',NULL,NULL,'<p>All official notices are published on the <a href=\"/notices.php\">Notice Board</a>. Pinned / urgent notices appear first. For admission specifically, use <a href=\"/notices.php?category=admission\">Notice Board — Admission</a>.</p>','<p>सबै आधिकारिक सूचनाहरू <a href=\"/notices.php\">सूचना पाटी</a> मा प्रकाशित हुन्छन्। पिन गरिएका/जरुरी सूचनाहरू पहिले देखिन्छन्। भर्नाका लागि <a href=\"/notices.php?category=admission\">सूचना पाटी — भर्ना</a> हेर्नुहोस्।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(22,'faq','faq_item',5,'Where can I download forms and school documents?','फारम र विद्यालयका कागजातहरू कहाँ डाउनलोड गर्न सकिन्छ?',NULL,NULL,'<p>In the <a href=\"/downloads.php\">Downloads / Resources centre</a> — categories include Academic Calendar, Exam Routine, Admission Documents, Results, Forms, Policies, Citizen Charter and Publications.</p>','<p><a href=\"/downloads.php\">डाउनलोड / संसाधन केन्द्र</a> मा — शैक्षिक पात्रो, परीक्षा तालिका, भर्ना कागजात, नतिजा, फारम, नीति, नागरिक वडापत्र र प्रकाशनहरू समावेश छन्।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(23,'faq','faq_item',6,'How can I get directions to the school?','विद्यालयसम्म कसरी पुग्ने?',NULL,NULL,'<p>Use the embedded map and <strong>Get Directions — VH24+22W</strong> button on the <a href=\"/contact.php\">Contact page</a>, or search Plus Code <strong>VH24+22W</strong> / coordinates <strong>26.8501032, 85.555064</strong> in Google Maps.</p>','<p><a href=\"/contact.php\">सम्पर्क पृष्ठ</a> मा रहेको नक्सा र <strong>दिशा प्राप्त गर्नुहोस् — VH24+22W</strong> बटन प्रयोग गर्नुहोस्, वा Google Maps मा प्लस कोड <strong>VH24+22W</strong> / निर्देशांक <strong>२६.८५०१०३२, ८५.५५५०६४</strong> खोज्नुहोस्।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(24,'faq','faq_item',7,'How do I confirm admission requirements?','भर्ना आवश्यकताहरू कसरी पुष्टि गर्ने?',NULL,NULL,'<p>Check the <a href=\"/notices.php?category=admission\">latest admission notice</a> for the grade and year you are applying for, and <a href=\"/contact.php\">contact or visit the school</a> to confirm eligibility, seats, fees and deadline. The general guidance on the <a href=\"/admissions.php\">Admissions page</a> is not a substitute for the official notice.</p>','<p>तपाईंले आवेदन दिने कक्षा र वर्षका लागि <a href=\"/notices.php?category=admission\">नवीनतम भर्ना सूचना</a> जाँच गर्नुहोस् र योग्यता, सिट, शुल्क र अन्तिम मिति पुष्टि गर्न <a href=\"/contact.php\">विद्यालयमा सम्पर्क गर्नुहोस् वा भ्रमण गर्नुहोस्</a>। <a href=\"/admissions.php\">भर्ना पृष्ठ</a> मा रहेको सामान्य मार्गदर्शन आधिकारिक सूचनाको विकल्प होइन।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(25,'links','link',1,'Ministry of Education, Science & Technology','शिक्षा, विज्ञान तथा प्रविधि मन्त्रालय',NULL,NULL,'Policy, national education information','नीति, राष्ट्रिय शिक्षा जानकारी',NULL,'account_balance','https://moest.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(26,'links','link',2,'CEHRD — Center for Education and Human Resource Development','सीईएचआरडी — शिक्षा तथा मानव स्रोत विकास केन्द्र',NULL,NULL,'IEMIS, school education administration','IEMIS, विद्यालय शिक्षा प्रशासन',NULL,'school','https://cehrd.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(27,'links','link',5,'SEE','एसईई',NULL,NULL,'Secondary Education Examination','माध्यमिक शिक्षा परीक्षा',NULL,'verified','https://see.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(28,'links','link',6,'Malangwa Municipality','मलंगवा नगरपालिका',NULL,NULL,'Local government — ward, municipal notices','स्थानीय सरकार — वडा, नगरपालिका सूचनाहरू',NULL,'location_city','https://malangwamun.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(29,'links','link',7,'Madhesh Province','मधेश प्रदेश',NULL,NULL,'Provincial government','प्रदेश सरकार',NULL,'map','https://madhesh.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(30,'links','link',8,'National Education-related Portals','राष्ट्रिय शिक्षा सम्बन्धी पोर्टलहरू',NULL,NULL,'Additional references — verify before use','थप सन्दर्भहरू — प्रयोग गर्नु अघि प्रमाणित गर्नुहोस्',NULL,'language','https://www.nea.gov.np',1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(31,'science','highlight',1,'Scientific reasoning','वैज्ञानिक तर्क',NULL,NULL,'Observation, experimentation and interpreting evidence — building habits of inquiry and careful measurement.','अवलोकन, प्रयोग र प्रमाणको व्याख्या — जिज्ञासा र सावधानीपूर्वक मापनको बानी विकास।',NULL,'biotech',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(32,'science','highlight',2,'Mathematics','गणित',NULL,NULL,'Quantitative reasoning, algebraic and analytical thinking used across science and technology studies.','विज्ञान र प्रविधि अध्ययनमा प्रयोग हुने परिमाणात्मक तर्क, बीजगणितीय र विश्लेषणात्मक सोच।',NULL,'calculate',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(33,'science','highlight',3,'Analytical thinking','विश्लेषणात्मक सोच',NULL,NULL,'Breaking problems into parts, evaluating data and forming reasoned conclusions.','समस्यालाई भागमा विभाजन गर्ने, तथ्याङ्क मूल्याङ्कन गर्ने र तर्कसंगत निष्कर्ष निकाल्ने।',NULL,'psychology',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(34,'science','highlight',4,'Practical understanding & problem solving','व्यावहारिक बुझाइ र समस्या समाधान',NULL,NULL,'Applying concepts to real questions — where lab access and practical work are available, students learn through demonstration and supervised activity.','अवधारणाहरूलाई वास्तविक प्रश्नहरूमा लागू गर्ने — प्रयोगशाला र व्यावहारिक कार्य उपलब्ध हुँदा विद्यार्थीहरूले प्रदर्शन र पर्यवेक्षण गतिविधि मार्फत सिक्छन्।',NULL,'science',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(35,'management','highlight',1,'Business understanding','व्यापार बुझाइ',NULL,NULL,'How businesses are organised, how they operate and how decisions are made — introduced at higher-secondary level.','व्यवसायहरू कसरी संगठित हुन्छन्, कसरी सञ्चालन हुन्छन् र निर्णयहरू कसरी लिइन्छ — उच्च माध्यमिक तहमा परिचय गराइन्छ।',NULL,'business_center',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(36,'management','highlight',2,'Accounting concepts','लेखा अवधारणाहरू',NULL,NULL,'Recording, classifying and interpreting financial information — the language of business records.','वित्तीय जानकारीको रेकर्डिङ, वर्गीकरण र व्याख्या — व्यापार रेकर्डको भाषा।',NULL,'receipt_long',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(37,'management','highlight',3,'Economics','अर्थशास्त्र',NULL,NULL,'Scarcity, markets, production and trade — basic economic thinking applied to everyday and business contexts.','अभाव, बजार, उत्पादन र व्यापार — दैनिक र व्यापार सन्दर्भमा लागू गरिने आधारभूत आर्थिक सोच।',NULL,'trending_up',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(38,'management','highlight',4,'Organisational thinking, communication & entrepreneurship','संगठनात्मक सोच, सञ्चार र उद्यमशीलता',NULL,NULL,'Planning, organising, working with others, written and spoken communication, and an introduction to starting and running an enterprise.','योजना, संगठन, अरूसँग मिलेर काम गर्ने, लिखित र मौखिक सञ्चार, र उद्यम सुरु गर्ने र सञ्चालन गर्ने परिचय।',NULL,'groups',NULL,1,NULL,'2026-08-26 07:04:21','2026-08-26 07:04:21'),(39,'home','hero',0,'Shree Public Secondary School  Malangwa-2','श्री पब्लिक माध्यमिक विद्यालय — मलंगवा-२','Admissions Open 2082','भर्ना खुला २०८२','Providing public education from Early Childhood Development through Grade 12 in the heart of Malangwa.','मलंगवाको केन्द्रमा बालविकासदेखि कक्षा १२ सम्म सार्वजनिक शिक्षा।','uploads/hero/hero-main-gate-jubilee.jpg',NULL,NULL,1,1,'2026-08-26 07:11:53','2026-08-26 10:45:37'),(40,'home','intro',0,'About Our School','हाम्रो विद्यालयको बारेमा',NULL,NULL,'Shree Public Secondary School is a government-recognized community school in Malangwa-2, Sarlahi. Registered under IEMIS Code 190640003, we provide holistic education from Early Childhood Development (ECD) through Grade 12.','श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेशको सर्लाही जिल्ला, मलंगवा नगरपालिका-२ मा अवस्थित सरकारबाट मान्यता प्राप्त सामुदायिक शैक्षिक संस्था हो।',NULL,NULL,NULL,1,1,'2026-08-26 07:11:53','2026-09-01 13:48:40'),(41,'home','commitment',1,'National Curriculum','राष्ट्रिय पाठ्यक्रम',NULL,NULL,'Curriculum per Curriculum Development Centre (CDC).','पाठ्यक्रम विकास केन्द्र (सीडीसी) अनुसारको पाठ्यक्रम।',NULL,'volunteer_activism',NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(42,'science','intro',0,'What the Science stream is for','विज्ञान स्ट्रिम केका लागि हो',NULL,NULL,'<p>The +2 Science program at Shree Public is a two-year higher secondary course under NEB.</p>','<p>+२ विज्ञान कार्यक्रम श्री पब्लिकमा राष्ट्रिय परीक्षा बोर्ड (एनईबी) अन्तर्गतको दुई वर्षे कार्यक्रम हो।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(43,'management','intro',0,'What the Management stream is for','व्यवस्थापन स्ट्रिम केका लागि हो',NULL,NULL,'<p>The +2 Management program under NEB — the second stream at Shree Public.</p>','<p>+२ व्यवस्थापन कार्यक्रम एनईबी अन्तर्गत श्री पब्लिकको दोस्रो स्ट्रिम हो।</p>',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(44,'publications','intro',0,'Official publications for transparency','पारदर्शिताका लागि आधिकारिक प्रकाशनहरू',NULL,NULL,'School annual reports, financial summaries, SIP summaries, prospectus and institutional publications.','विद्यालय वार्षिक प्रतिवेदन, वित्तीय सारांश, SIP सारांश, prospectus र संस्थागत प्रकाशनहरू।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(45,'about','intro',2,NULL,NULL,NULL,NULL,'Our institution offers a comprehensive educational journey from ECD through Grade 12. We operate as a co-educational day school with +2 Science and Management streams. (IEMIS: 190640003)','हाम्रो संस्थाले ईसीडी देखि कक्षा १२ सम्म व्यापक शैक्षिक यात्रा प्रदान गर्दछ। हामी सह-शिक्षा दिवा विद्यालय हौं।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(46,'about','timeline',2,'2040 BS','२०४० साल',NULL,NULL,'Expansion to secondary level (Grade 10).','माध्यमिक तह (कक्षा १०) सम्म विस्तार।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(47,'about','timeline',3,'2065 BS','२०६५ साल',NULL,NULL,'Introduction of Higher Secondary (+2) programs.','उच्च माध्यमिक (+२) कार्यक्रमहरूको सुरुवात।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(49,'faq','faq_item',1,'Where is the school located?','विद्यालय कहाँ अवस्थित छ?',NULL,NULL,'Shree Public Secondary School is in Malangwa Municipality-2, Sarlahi, Madhesh Province 45800.','श्री पब्लिक माध्यमिक विद्यालय मलंगवा नगरपालिका-२, सर्लाही, मधेश प्रदेश मा अवस्थित छ।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(50,'faq','faq_item',2,'What levels does the school teach?','विद्यालयले कुन तहसम्म पढाउँछ?',NULL,NULL,'ECD through Grade 12 — ECD/Nursery, Basic (1–8), Secondary (9–10), Higher Secondary (11–12).','ईसीडीदेखि कक्षा १२ सम्म — ईसीडी/नर्सरी, आधारभूत (१–८), माध्यमिक (९–१०), उच्च माध्यमिक (११–१२)।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(51,'faq','faq_item',3,'Which +2 programs are available?','कुन +२ कार्यक्रमहरू उपलब्ध छन्?',NULL,NULL,'+2 Science and +2 Management under NEB.','हाल +२ विज्ञान र +२ व्यवस्थापन एनईबी अन्तर्गत सञ्चालित छन्।',NULL,NULL,NULL,1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(52,'links','link',3,'National Examinations Board (NEB)','राष्ट्रिय परीक्षा बोर्ड (एनईबी)',NULL,NULL,'Grade 11–12 registration, examinations, results','कक्षा ११–१२ दर्ता, परीक्षा, नतिजा',NULL,'assignment','https://neb.gov.np',1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53'),(53,'links','link',4,'Curriculum Development Centre (CDC)','पाठ्यक्रम विकास केन्द्र (सीडीसी)',NULL,NULL,'Curriculum, textbooks, learning materials','पाठ्यक्रम, पाठ्यपुस्तक, सिकाइ सामग्री',NULL,'menu_book','https://cdc.gov.np',1,NULL,'2026-08-26 07:11:53','2026-08-26 07:11:53');
/*!40000 ALTER TABLE `content_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `download_categories`
--

DROP TABLE IF EXISTS `download_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `download_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `download_categories`
--

LOCK TABLES `download_categories` WRITE;
/*!40000 ALTER TABLE `download_categories` DISABLE KEYS */;
INSERT INTO `download_categories` VALUES (1,'forms','Forms',NULL,1),(2,'routine','Routine',NULL,2),(3,'results','Results',NULL,3),(4,'academic-calendar','Academic Calendar',NULL,4),(5,'curriculum','Curriculum',NULL,5),(6,'reports','Reports',NULL,6),(7,'citizen-charter','Citizen Charter',NULL,7),(8,'policies','Policies',NULL,8),(9,'procurement','Procurement',NULL,9),(10,'publications','Publications',NULL,10),(11,'scholarships','Scholarships',NULL,11),(12,'other','Other',NULL,12);
/*!40000 ALTER TABLE `download_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `downloads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int unsigned DEFAULT NULL,
  `file_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `download_count` int unsigned DEFAULT '0',
  `created_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `idx_downloads_category` (`category_id`),
  CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `download_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads`
--

LOCK TABLES `downloads` WRITE;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
INSERT INTO `downloads` VALUES (1,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-20 13:00:00','published',0,NULL),(2,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-17 13:00:00','published',0,NULL),(3,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-10 13:00:00','published',0,NULL),(4,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-26 13:00:00','published',0,NULL),(5,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-16 13:00:00','published',0,NULL),(6,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-06 13:00:00','published',0,NULL),(7,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-20 13:37:25','published',0,NULL),(8,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-17 13:37:25','published',0,NULL),(9,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-10 13:37:25','published',0,NULL),(10,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-26 13:37:25','published',0,NULL),(11,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-16 13:37:25','published',0,NULL),(12,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-06 13:37:25','published',0,NULL),(13,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 07:02:26','published',0,NULL),(14,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 07:02:26','published',0,NULL),(15,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 07:02:26','published',0,NULL),(16,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 07:02:26','published',0,NULL),(17,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 07:02:26','published',0,NULL),(18,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 07:02:26','published',0,NULL),(19,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 07:04:21','published',0,NULL),(20,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 07:04:21','published',0,NULL),(21,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 07:04:21','published',0,NULL),(22,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 07:04:21','published',0,NULL),(23,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 07:04:21','published',0,NULL),(24,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 07:04:21','published',0,NULL),(25,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 10:40:43','published',0,NULL),(26,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 10:40:43','published',0,NULL),(27,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 10:40:43','published',0,NULL),(28,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 10:40:43','published',0,NULL),(29,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 10:40:43','published',0,NULL),(30,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 10:40:43','published',0,NULL),(31,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 10:41:07','published',0,NULL),(32,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 10:41:07','published',0,NULL),(33,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 10:41:07','published',0,NULL),(34,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 10:41:07','published',0,NULL),(35,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 10:41:07','published',0,NULL),(36,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 10:41:07','published',0,NULL),(37,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 15:37:50','published',0,NULL),(38,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 15:37:50','published',0,NULL),(39,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 15:37:50','published',0,NULL),(40,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 15:37:50','published',0,NULL),(41,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 15:37:50','published',0,NULL),(42,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 15:37:50','published',0,NULL),(43,'Student Admission Form 2082','भर्ना फारम २०८२',1,'uploads/downloads/admission-form-2082.pdf',1228800,'PDF','2026-08-21 15:38:13','published',0,NULL),(44,'Academic Calendar 2082','शैक्षिक पात्रो २०८२',4,'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF','2026-08-18 15:38:13','published',0,NULL),(45,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-11 15:38:13','published',0,NULL),(46,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-07-27 15:38:13','published',0,NULL),(47,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-17 15:38:13','published',0,NULL),(48,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-07 15:38:13','published',0,NULL),(51,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-16 16:03:40','published',0,NULL),(52,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-08-01 16:03:40','published',0,NULL),(53,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-22 16:03:40','published',0,NULL),(54,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-12 16:03:40','published',0,NULL),(57,'Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',11,'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF','2026-08-16 16:03:59','published',0,NULL),(58,'Code of Conduct for Students','विद्यार्थी आचारसंहिता',8,'uploads/downloads/code-of-conduct.pdf',819200,'PDF','2026-08-01 16:03:59','published',0,NULL),(59,'School Prospectus 2082','विद्यालय परिचय पुस्तिका',10,'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF','2026-07-22 16:03:59','published',0,NULL),(60,'Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',7,'uploads/downloads/citizen-charter.pdf',1887436,'PDF','2026-07-12 16:03:59','published',0,NULL);
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_np` text COLLATE utf8mb4_unicode_ci,
  `location_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_events_date` (`event_date`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'16 Days of Activism against Gender-Based Violence Campaign','लैंगिक हिंसाविरुद्ध १६ दिने अभियान','16-days-activism','Inaugurated with Malangwa Municipality, INSEC and local community groups. Awareness rallies and poster competitions by students.',NULL,'Shree Public Secondary School, Malangwa-2',NULL,'2026-09-04','11:00 AM',NULL,'published','2026-08-25 13:00:00'),(2,'Annual Sports Meet 2082','वार्षिक खेलकुद २०८२','annual-sports-meet-2082','Track and field events for all levels — ECD to Grade 12. Parents and community members are warmly invited.',NULL,'School Playground, Malangwa-2',NULL,'2026-09-19','9:00 AM',NULL,'published','2026-08-25 13:00:00'),(3,'School Level Science Exhibition','विद्यालय स्तरीय विज्ञान प्रदर्शनी','science-exhibition-2082','Students present working models from Physics, Chemistry and Biology. Best projects advance to the district level competition.',NULL,'Science Block, Malangwa-2',NULL,'2026-10-04','10:00 AM',NULL,'published','2026-08-25 13:00:00');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_types`
--

DROP TABLE IF EXISTS `exam_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_types`
--

LOCK TABLES `exam_types` WRITE;
/*!40000 ALTER TABLE `exam_types` DISABLE KEYS */;
INSERT INTO `exam_types` VALUES (1,'SEE',NULL),(2,'Grade 12 (NEB)',NULL),(3,'Internal',NULL),(4,'SEE',NULL),(5,'Grade 12 (NEB)',NULL),(6,'Internal',NULL),(7,'SEE',NULL),(8,'Grade 12 (NEB)',NULL),(9,'Internal',NULL),(10,'SEE',NULL),(11,'Grade 12 (NEB)',NULL),(12,'Internal',NULL),(13,'SEE',NULL),(14,'Grade 12 (NEB)',NULL),(15,'Internal',NULL),(16,'SEE',NULL),(17,'Grade 12 (NEB)',NULL),(18,'Internal',NULL),(19,'SEE',NULL),(20,'Grade 12 (NEB)',NULL),(21,'Internal',NULL),(22,'SEE',NULL),(23,'Grade 12 (NEB)',NULL),(24,'Internal',NULL),(25,'SEE',NULL),(26,'Grade 12 (NEB)',NULL),(27,'Internal',NULL),(28,'SEE',NULL),(29,'Grade 12 (NEB)',NULL),(30,'Internal',NULL),(31,'SEE',NULL),(32,'Grade 12 (NEB)',NULL),(33,'Internal',NULL),(34,'SEE',NULL),(35,'Grade 12 (NEB)',NULL),(36,'Internal',NULL),(37,'SEE',NULL),(38,'Grade 12 (NEB)',NULL),(39,'Internal',NULL);
/*!40000 ALTER TABLE `exam_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exams` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exam_type_id` int unsigned NOT NULL,
  `academic_year` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exam_type_id` (`exam_type_id`),
  CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,3,'2026','Grade 10','SEE 2082',1,'2026-08-31 18:17:08'),(2,3,'2026','Grade 10','SEE 2082',1,'2026-08-31 18:17:12'),(3,2,'2026','','',1,'2026-08-31 19:14:19');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_albums`
--

DROP TABLE IF EXISTS `gallery_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_albums` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_albums`
--

LOCK TABLES `gallery_albums` WRITE;
/*!40000 ALTER TABLE `gallery_albums` DISABLE KEYS */;
INSERT INTO `gallery_albums` VALUES (1,'campus-school','School & Campus','विद्यालय तथा परिसर','Classrooms, buildings, offices and everyday life inside the school campus.','uploads/gallery/campus/front-building-entrance.jpg',1,'published','2026-08-25 13:00:00'),(2,'assembly-events','Assembly & Events','प्रार्थना सभा तथा कार्यक्रम','Morning assemblies, announcements and school-wide gatherings.','uploads/gallery/assembly/teacher-addressing-assembly.jpg',2,'published','2026-08-25 13:00:00'),(3,'staff-leadership','Staff & Leadership','शिक्षक तथा नेतृत्व','Our teaching staff, leadership team and management committee.','uploads/gallery/staff/leadership-team-photo.jpg',3,'published','2026-08-25 13:00:00'),(4,'community-programs','Community Programs','सामुदायिक कार्यक्रम','Programs run with parents, local wards and Malangwa Municipality.','uploads/gallery/community/complaint-box-life-nepal.jpg',4,'published','2026-08-25 13:00:00');
/*!40000 ALTER TABLE `gallery_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gallery_album` (`album_id`,`sort_order`),
  CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
INSERT INTO `gallery_images` VALUES (1,1,'uploads/gallery/campus/front-building-entrance.jpg','School main building and entrance',NULL,1,'2026-08-25 13:00:00'),(2,1,'uploads/gallery/campus/school-sign-closeup.jpg','School name board at the gate',NULL,2,'2026-08-25 13:00:00'),(3,1,'uploads/gallery/campus/headmaster-office.jpg','Head teacher office',NULL,3,'2026-08-25 13:00:00'),(4,1,'uploads/gallery/campus/staff-room-interior.jpg','Staff room',NULL,4,'2026-08-25 13:00:00'),(5,1,'uploads/gallery/campus/staff-room-computer.jpg','ICT corner with computers',NULL,5,'2026-08-25 13:00:00'),(6,1,'uploads/gallery/campus/courtyard-students-formation.jpg','Students in courtyard formation',NULL,6,'2026-08-25 13:00:00'),(7,1,'uploads/hero/hero-main-gate-jubilee.jpg','Main gate',NULL,7,'2026-08-25 13:00:00'),(8,1,'uploads/hero/hero-courtyard-assembly.jpg','Courtyard assembly',NULL,8,'2026-08-25 13:00:00'),(9,1,'uploads/about/campus-assembly-building.jpg','Assembly in front of the building',NULL,9,'2026-08-25 13:00:00'),(10,1,'uploads/about/campus-building-aerial.jpg','School building view',NULL,10,'2026-08-25 13:00:00'),(11,2,'uploads/gallery/assembly/teacher-addressing-assembly.jpg','Teacher addressing the morning assembly',NULL,1,'2026-08-25 13:00:00'),(12,2,'uploads/gallery/assembly/staff-meeting-courtyard.jpg','Staff meeting in the courtyard',NULL,2,'2026-08-25 13:00:00'),(13,3,'uploads/gallery/staff/leadership-team-photo.jpg','School leadership team',NULL,1,'2026-08-25 13:00:00'),(14,4,'uploads/gallery/community/complaint-box-life-nepal.jpg','Community program at school',NULL,1,'2026-08-25 13:00:00');
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `location` enum('header','footer','quick') COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `excerpt_en` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_np` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `content_np` mediumtext COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  KEY `created_by` (`created_by`),
  KEY `idx_news_status` (`status`,`published_at`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Students Secure First Position in District Science Fair','जिल्ला विज्ञान महोत्सवमा प्रथम','news-district-science-win',2,'Our Grade 10 team presented an innovative water filtration model and won first place at the Sarlahi district science fair.',NULL,'Our Grade 10 students represented the school at the Sarlahi district level science fair and secured the first position with an innovative low-cost water filtration model. The team was felicitated at the school assembly. Congratulations to the students and supervising teachers!',NULL,'uploads/gallery/campus/staff-room-computer.jpg','2026-08-18 13:00:00','published',NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(2,'Community Tree Plantation Drive Completed','सामुदायिक वृक्षरोपण सम्पन्न','news-tree-plantation',3,'Eco-club members and local volunteers planted 200+ saplings around the school premises with Malangwa Municipality support.',NULL,'With support from Malangwa Municipality, our eco-club members, teachers and local volunteers completed a tree plantation drive around the school boundary, planting over 200 saplings of local species. The school thanks all community members who participated.',NULL,'uploads/gallery/community/complaint-box-life-nepal.jpg','2026-08-07 13:00:00','published',NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_categories`
--

DROP TABLE IF EXISTS `news_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_categories`
--

LOCK TABLES `news_categories` WRITE;
/*!40000 ALTER TABLE `news_categories` DISABLE KEYS */;
INSERT INTO `news_categories` VALUES (1,'general','General',NULL),(2,'academic','Academic',NULL),(3,'community','Community',NULL),(4,'sports','Sports',NULL),(5,'cultural','Cultural',NULL);
/*!40000 ALTER TABLE `news_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice_categories`
--

DROP TABLE IF EXISTS `notice_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice_categories`
--

LOCK TABLES `notice_categories` WRITE;
/*!40000 ALTER TABLE `notice_categories` DISABLE KEYS */;
INSERT INTO `notice_categories` VALUES (1,'general','General Notice','सामान्य सूचना',1),(2,'examination','Examination','परीक्षा',2),(3,'admission','Admission','भर्ना',3),(4,'holiday','Holiday','बिदा',4),(5,'vacancy','Vacancy','रिक्त',5),(6,'scholarship','Scholarship','छात्रवृत्ति',6),(7,'procurement','Procurement/Tender','खरिद/बोलपत्र',7),(8,'events','Events','कार्यक्रम',8),(9,'results','Results','नतिजा',9),(10,'urgent','Urgent','जरुरी',10);
/*!40000 ALTER TABLE `notice_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `description_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `description_np` mediumtext COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_type` enum('pdf','docx','xlsx','jpg','png') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime DEFAULT NULL,
  `is_pinned` tinyint(1) DEFAULT '0',
  `is_urgent` tinyint(1) DEFAULT '0',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `idx_notices_status_published` (`status`,`published_at`),
  KEY `idx_notices_category` (`category_id`),
  FULLTEXT KEY `idx_notices_search` (`title_en`,`title_np`,`description_en`),
  CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `notice_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `notices_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `notices_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notices`
--

LOCK TABLES `notices` WRITE;
/*!40000 ALTER TABLE `notices` DISABLE KEYS */;
INSERT INTO `notices` VALUES (1,'New Admission Open for Academic Session 2082 (ECD to Grade 9)','शैक्षिक सत्र २०८२ को लागि भर्ना खुला (बालविकास देखि कक्षा ९)','admission-open-2082','SPS/Notice/2082-01',3,'Admission forms are available at the school office during office hours (Sun–Fri, 10:00 AM – 4:00 PM). Limited seats per level. Bring birth certificate, transfer certificate and previous marksheet.',NULL,NULL,NULL,NULL,'2026-08-22 13:00:00',NULL,1,0,'published',NULL,NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(2,'SEE Examination Routine 2082 Published','एस.ई.ई. परीक्षा कार्यक्रम २०८२ प्रकाशित','see-routine-2082','SPS/Exam/2082-04',2,'The SEE examination routine for Grade 10 students has been published. Students may collect the routine PDF from the Downloads section or the school notice board.',NULL,NULL,NULL,NULL,'2026-08-13 13:00:00',NULL,0,0,'published',NULL,NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(3,'Vacancy Announcement: Secondary Level Science Teacher (Contract)','सूचना: माध्यमिक तह विज्ञान शिक्षक (करार)','vacancy-science-teacher-2082','SPS/Vacancy/2082-03',5,'Applications are invited from qualified candidates for Secondary Level Science Teacher (contract basis). Deadline: within 15 days of this notice. Apply at the school office.',NULL,NULL,NULL,NULL,'2026-08-05 13:00:00',NULL,0,1,'published',NULL,NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(4,'Grade 11 Scholarship Application Deadline Extended','कक्षा ११ छात्रवृत्ति आवेदन म्याद थप','scholarship-grade11-extended','SPS/Schol/2082-02',6,'The application deadline for Grade 11 scholarships (merit and quota-based) has been extended by one week. Eligible students should submit documents to the school office.',NULL,NULL,NULL,NULL,'2026-07-26 13:00:00',NULL,0,0,'published',NULL,NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(5,'School Closure Notice for Holi Festival','फागु पूर्णिमा (होली) को बिदा सम्बन्धी सूचना','holiday-holi-2082','SPS/Gen/2082-06',4,'The school will remain closed on the occasion of Fagu Purnima (Holi). Regular classes resume the following day.',NULL,NULL,NULL,NULL,'2026-07-11 13:00:00',NULL,0,0,'published',NULL,NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00');
/*!40000 ALTER TABLE `notices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `content_np` mediumtext COLLATE utf8mb4_unicode_ci,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `updated_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'about','About Our School','हाम्रो विद्यालयबारे','<h2>Welcome to Shree Public Secondary School</h2><p>Shree Public Secondary School is a government community school located in Malangwa-2, Sarlahi, Madhesh Province, Nepal. The school provides quality education from Early Childhood Development (ECD) through Grade 12, including +2 programs in Science and Management affiliated with the National Examination Board (NEB).</p><h3>Our Mission</h3><p>To provide accessible, equitable and quality education to every child of our community regardless of background.</p><h3>Our Vision</h3><p>To be a model community school in Madhesh Province known for academic excellence, discipline and social responsibility.</p>','<h2>श्री पब्लिक माध्यमिक विद्यालयमा स्वागत छ</h2><p>श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेश, सर्लाही जिल्लाको मलंगवा–२ मा अवस्थित एक सरकारी सामुदायिक विद्यालय हो।</p>','Shree Public Secondary School — public community school in Malangwa-2, Sarlahi. ECD to Grade 12, +2 Science & Management (NEB). IEMIS 190640003.','published',1,'2026-08-25 13:00:00','2026-08-26 07:02:26'),(2,'admissions','Admissions','भर्ना','<h2>Admission Open — ECD to Grade 12 &amp; +2</h2><p>Admission availability at Shree Public depends on the academic year, grade and number of seats as determined each year by the school administration. Parents and guardians may visit the school office during office hours (Sunday–Friday, 10:00 AM – 4:00 PM) to collect and submit the application form.</p><h3>Documents Required</h3><ul><li>Birth certificate (copy)</li><li>Transfer certificate (if transferring)</li><li>Previous marksheet/grade sheet</li><li>Passport-size photographs (2 copies)</li><li>Citizenship copy (for +2 applicants)</li></ul>','<h2>भर्ना खुला छ</h2><p>श्री पब्लिकमा भर्ना शैक्षिक वर्ष, कक्षा र सिट संख्यामा निर्भर गर्दछ। अभिभावकहरूले कार्यालय समय (आइतबार–शुक्रबार, बिहान १०:००–अपराह्न ४:००) मा विद्यालय कार्यालयमा सम्पर्क गर्नुहोला।</p><h3>आवश्यक कागजातहरू</h3><ul><li>जन्मदर्ता प्रमाणपत्र (प्रतिलिपि)</li><li>स्थानान्तरण प्रमाणपत्र (यदि स्थानान्तरण भएमा)</li><li>अघिल्लो लब्धाङ्क पत्र</li><li>पासपोर्ट साइज फोटो (२ प्रति)</li><li>नागरिकता प्रतिलिपि (+२ आवेदकका लागि)</li></ul>','Admission information for Shree Public Secondary School Malangwa-2 — ECD to Grade 12, +2 Science & Management (NEB).','published',NULL,'2026-08-25 13:00:00','2026-08-26 07:02:26'),(3,'citizen-charter','Citizen Charter','नागरिक वडापत्र','<h2>Citizen Charter (नागरिक वडापत्र)</h2><p>This charter outlines the services provided by the school, required documents and service delivery time commitments.</p><ul><li>Admission enrollment — same day during office hours</li><li>Transfer certificate — within 2 working days</li><li>Character certificate — within 2 working days</li><li>Marksheet verification — within 3 working days</li></ul>','<h2>नागरिक वडापत्र</h2><p>यो वडापत्रमा विद्यालयले प्रदान गर्ने सेवाहरू र सेवा प्रदान गर्ने समय उल्लेख छ।</p><ul><li>भर्ना दर्ता — कार्यालय समयमा सोही दिन</li><li>स्थानान्तरण प्रमाणपत्र — २ कार्य दिन भित्र</li><li>चारित्रिक प्रमाणपत्र — २ कार्य दिन भित्र</li><li>लब्धाङ्क प्रमाणीकरण — ३ कार्य दिन भित्र</li></ul>','Citizen Charter of Shree Public Secondary School, Malangwa-2 — services, documents, time and fees.','published',NULL,'2026-08-25 13:00:00','2026-08-26 07:02:26'),(4,'faq','Frequently Asked Questions','जिज्ञासा','<h2>Frequently Asked Questions</h2><h3>Where is the school located?</h3><p>VH24+22W, Malangwa-2, Sarlahi, Madhesh Province, Nepal (postal code 45800).</p><h3>Which programs does the school offer?</h3><p>ECD through Grade 12, plus +2 Science and +2 Management streams affiliated with NEB.</p><h3>What are the office hours?</h3><p>Sunday to Friday, 10:00 AM to 4:00 PM. Closed on Saturday.</p>','<h2>जिज्ञासाहरू</h2><h3>विद्यालय कहाँ अवस्थित छ?</h3><p>मलंगवा–२, सर्लाही, मधेश प्रदेश।</p>','Frequently asked questions about Shree Public Secondary School, Malangwa-2.','published',NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(5,'publications','Publications','प्रकाशनहरू','<h2>Publications &amp; Reports</h2><p>Official publications of the school are made available for public transparency: annual reports, school improvement plans and financial summaries. Printed copies are available at the school office.</p>','<h2>प्रकाशनहरू</h2><p>विद्यालयका आधिकारिक प्रकाशनहरू सार्वजनिक पारदर्शिताका लागि उपलब्ध गराइएको छ।</p>','Publications from Shree Public Secondary School — annual reports, prospectus, transparency documents.','published',NULL,'2026-08-25 13:00:00','2026-08-25 13:00:00'),(11,'scholarships','Scholarships','छात्रवृत्ति','<h2>Scholarships</h2><p>Scholarship quota, eligibility and reservation details are specified in each official notice. When the school or Government of Nepal issues a scholarship notice applicable to this school, it is published on the Notice Board (category: Scholarship) with full details and downloadable forms in Downloads.</p><h3>How to Apply</h3><p>See the attached notice for required documents, application form and deadline. Contact the school office for guidance before the deadline.</p>','<h2>छात्रवृत्ति</h2><p>छात्रवृत्ति कोटा, योग्यता र आरक्षण विवरण प्रत्येक आधिकारिक सूचनामा तोकिन्छ। जब विद्यालय वा नेपाल सरकारले छात्रवृत्ति सूचना जारी गर्दछ, यो सूचना पाटी (छात्रवृत्ति श्रेणी) मा पूर्ण विवरण सहित प्रकाशित हुन्छ।</p><h3>कसरी आवेदन दिने</h3><p>आवश्यक कागजात, आवेदन फारम र अन्तिम मितिका लागि सम्बन्धित सूचना हेर्नुहोस्। अन्तिम मिति अघि मार्गदर्शनका लागि विद्यालय कार्यालयमा सम्पर्क गर्नुहोस्।</p>','Scholarship information — quota, eligibility and application via official notices at Shree Public Secondary School.','published',NULL,'2026-08-26 07:02:26','2026-08-26 07:02:26'),(12,'academics','Academics','शैक्षिक कार्यक्रम','<h2>One continuum — from early childhood to higher secondary</h2><p>Shree Public Secondary School offers the full national school structure in a single institution. Students can enter at Early Childhood Development (ECD) and progress without changing school through <strong>Basic Level (Grades 1–8)</strong>, <strong>Secondary Level (Grades 9–10)</strong> and <strong>Higher Secondary (Grades 11–12)</strong>. The two higher secondary streams currently offered are <strong>+2 Science</strong> and <strong>+2 Management</strong> under the National Examinations Board (NEB). The school follows the national curriculum framework maintained by the Curriculum Development Centre (CDC) and the examination systems of SEE and NEB.</p>','<h2>एक निरन्तरता — प्रारम्भिक बाल्यकालदेखि उच्च माध्यमिकसम्म</h2><p>श्री पब्लिक माध्यमिक विद्यालयले एउटै संस्थामा पूर्ण राष्ट्रिय विद्यालय संरचना प्रदान गर्दछ। विद्यार्थीहरू प्रारम्भिक बालविकास (ईसीडी) मा प्रवेश गरी विद्यालय नबदली <strong>आधारभूत तह (कक्षा १–८)</strong>, <strong>माध्यमिक तह (कक्षा ९–१०)</strong> र <strong>उच्च माध्यमिक (कक्षा ११–१२)</strong> सम्म अगाडि बढ्न सक्छन्। हाल सञ्चालित दुई उच्च माध्यमिक स्ट्रिमहरू <strong>+२ विज्ञान</strong> र <strong>+२ व्यवस्थापन</strong> राष्ट्रिय परीक्षा बोर्ड (एनईबी) अन्तर्गत छन्।</p>','Academics at Shree Public Secondary School — ECD through Grade 12 and +2 Science & Management (NEB).','published',NULL,'2026-08-26 07:02:26','2026-08-26 07:02:26'),(13,'science','+2 Science','+२ विज्ञान','<h2>What the Science stream is for</h2><p>The <strong>+2 Science</strong> program at Shree Public Secondary School is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong>. It is one of two NEB streams currently offered at the school — the other being <strong>+2 Management</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to eligibility criteria and available seats as confirmed each year by the school office. The programme is intended to prepare students for further study after Grade 12 in areas such as <strong>science, technology, health sciences, engineering and natural sciences</strong>.</p><p>Study extends over two academic years with internal assessments and board examinations as required by NEB.</p>','<h2>विज्ञान स्ट्रिम केका लागि हो</h2><p><strong>+२ विज्ञान</strong> कार्यक्रम श्री पब्लिक माध्यमिक विद्यालयमा <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो। यो विद्यालयमा हाल सञ्चालित दुई एनईबी स्ट्रिमहरूमध्ये एक हो — अर्को <strong>+२ व्यवस्थापन</strong> हो।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p><p>अध्ययन दुई शैक्षिक वर्षसम्म चल्छ र एनईबीको आवश्यकता अनुसार आन्तरिक मूल्याङ्कन र बोर्ड परीक्षाहरू हुन्छन्।</p>','+2 Science stream at Shree Public Secondary School — NEB higher secondary overview.','published',NULL,'2026-08-26 07:02:26','2026-08-26 07:02:26'),(14,'management','+2 Management','+२ व्यवस्थापन','<h2>What the Management stream is for</h2><p>The <strong>+2 Management</strong> program is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong> — the second NEB stream currently operated at Shree Public alongside <strong>+2 Science</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to the eligibility criteria and seats confirmed each year by the school office. The programme is intended as preparation for further study after Grade 12 in areas such as <strong>business, commerce, management, finance and related fields</strong>.</p><p>Study runs over two academic years with internal assessments and board examinations as required by NEB.</p>','<h2>व्यवस्थापन स्ट्रिम केका लागि हो</h2><p><strong>+२ व्यवस्थापन</strong> कार्यक्रम <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो — श्री पब्लिकमा <strong>+२ विज्ञान</strong> सँगै सञ्चालित दोस्रो एनईबी स्ट्रिम।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p><p>अध्ययन दुई शैक्षिक वर्षसम्म चल्छ र एनईबीको आवश्यकता अनुसार आन्तरिक मूल्याङ्कन र बोर्ड परीक्षाहरू हुन्छन्।</p>','+2 Management stream at Shree Public Secondary School — NEB higher secondary overview.','published',NULL,'2026-08-26 07:02:26','2026-08-26 07:02:26');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `post_type` enum('news','event') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'news',
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `excerpt_en` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_np` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_en` mediumtext COLLATE utf8mb4_unicode_ci,
  `content_np` mediumtext COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  KEY `created_by` (`created_by`),
  KEY `idx_posts_type_status` (`post_type`,`status`,`published_at`),
  KEY `idx_posts_event_date` (`event_date`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,'news','Community Tree Plantation Drive Completed','सामुदायिक वृक्षरोपण सम्पन्न','news-tree-plantation',3,'Eco-club members and local volunteers planted 200+ saplings around the school premises with Malangwa Municipality support.',NULL,'With support from Malangwa Municipality, our eco-club members, teachers and local volunteers completed a tree plantation drive around the school boundary, planting over 200 saplings of local species. The school thanks all community members who participated.',NULL,'uploads/gallery/community/complaint-box-life-nepal.jpg',NULL,NULL,NULL,NULL,'2026-08-07 13:00:00','published',NULL,'2026-08-31 16:55:03','2026-08-31 16:55:03'),(4,'event','Annual Sports Meet 2082','लैंगिक हिंसाविरुद्ध १६ दिने अभियान','16-days-activism',NULL,NULL,NULL,'Inaugurated with Malangwa Municipality, INSEC and local community groups. Awareness rallies and poster competitions by students.',NULL,NULL,'Shree Public Secondary School, Malangwa-2',NULL,'2026-09-04','11:00 AM','2026-08-31 16:55:07','published',NULL,'2026-08-31 16:55:07','2026-08-31 16:56:56'),(5,'event','Annual Sports Meet 2082','वार्षिक खेलकुद २०८२','annual-sports-meet-2082',NULL,NULL,NULL,'Track and field events for all levels — ECD to Grade 12. Parents and community members are warmly invited.',NULL,NULL,'School Playground, Malangwa-2',NULL,'2026-09-19','9:00 AM','2026-08-31 16:55:07','published',NULL,'2026-08-31 16:55:07','2026-08-31 16:55:07'),(6,'event','School Level Science Exhibition','विद्यालय स्तरीय विज्ञान प्रदर्शनी','science-exhibition-2082',NULL,NULL,NULL,'Students present working models from Physics, Chemistry and Biology. Best projects advance to the district level competition.',NULL,NULL,'Science Block, Malangwa-2',NULL,'2026-10-04','10:00 AM','2026-08-31 16:55:07','published',NULL,'2026-08-31 16:55:07','2026-08-31 16:55:07');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_np` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_np` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publications`
--

LOCK TABLES `publications` WRITE;
/*!40000 ALTER TABLE `publications` DISABLE KEYS */;
/*!40000 ALTER TABLE `publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','Super Admin'),(2,'school_admin','School Admin'),(3,'editor','Editor'),(4,'exam_officer','Exam Officer');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES ('address_en','Malangwa-2, Sarlahi, Madhesh Province, Nepal','2026-08-24 22:03:53'),('address_np','मलंगवा-२, सर्लाही, मधेश प्रदेश, नेपाल','2026-08-24 22:03:53'),('coords_lat','26.8501032','2026-08-24 22:03:53'),('coords_lng','85.555064','2026-08-24 22:03:53'),('email','','2026-08-24 22:03:53'),('iemis_code','190640003','2026-08-24 22:03:53'),('logo_path','assets/img/logo.png','2026-08-26 10:40:43'),('office_hours','10:00AM To 5:00 PM','2026-08-31 19:05:53'),('phone','9844032297','2026-08-31 19:05:53'),('plus_code','VH24+22W','2026-08-24 22:03:53'),('principal_message_en','Our mission is to provide an inclusive, high-quality education that empowers students from all backgrounds to become responsible citizens and future leaders. We invite you to be a part of our growing community.','2026-08-25 13:00:00'),('principal_message_np','हाम्रो लक्ष्य सबै पृष्ठभूमिका विद्यार्थीहरूलाई जिम्मेवार नागरिक र भविष्यका नेता बन्न सशक्त बनाउँदै समावेशी, गुणस्तरीय शिक्षा प्रदान गर्नु हो।','2026-08-25 13:00:00'),('principal_name','Suvash Kumar Yadav','2026-08-31 19:05:53'),('principal_photo','uploads/gallery/staff/leadership-team-photo.jpg','2026-08-26 07:02:25'),('show_principal','1','2026-08-25 13:00:00'),('site_name_en','Shree Public Secondary School','2026-08-24 22:03:53'),('site_name_np','श्री पब्लिक माध्यमिक विद्यालय','2026-08-24 22:03:53'),('students_display','1,000+','2026-08-24 22:03:53');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_en` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation_np` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_phone` tinyint(1) DEFAULT '0',
  `show_email` tinyint(1) DEFAULT '0',
  `category_id` int unsigned DEFAULT NULL,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_staff_category` (`category_id`,`display_order`),
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `staff_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (2,'uploads/65deaa6056a01609.jpg','Suvash Kumar Yadav','सुभाष कुमार यादव','Head Teacher','प्रधानाध्यापक','Leadership','','','',0,0,2,1,1,'2026-08-25 13:00:00'),(32,'uploads/staff/m1.jpg','Subash Kumar Yadav','सुवास कुमार यादव','Head Teacher','प्रधानाध्यापक','Teaching',NULL,NULL,NULL,0,0,3,1,1,'2026-08-31 17:08:43'),(33,'uploads/staff/m2.jpg','Rabindra Kumar Pandey','रविन्द्र कुमार पाण्डे','Assistant Head Teacher','स० प्र० अ०','Teaching','','','',0,0,3,2,1,'2026-08-31 17:08:43'),(34,'uploads/staff/m3.jpg','Suresh Kumar Ray','सुरेश कुमार राय','Teacher','सहायक शिक्षक','Teaching','','','',0,0,3,3,1,'2026-08-31 17:08:43'),(35,'uploads/staff/m4.jpg','Umesh Kumar Ray','उमेश कुमार राय','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,4,1,'2026-08-31 17:08:43'),(36,'uploads/staff/m5.jpg','Shailendra Kumar Tiwari','शैलेन्द्र कुमार तिवारी','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,5,1,'2026-08-31 17:08:43'),(37,'uploads/staff/m6.jpg','Ram Kishor Das','राम किशोर दास','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,6,1,'2026-08-31 17:08:43'),(38,'uploads/staff/f1.jpg','Usha Yadav','उषा यादव','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,7,1,'2026-08-31 17:08:43'),(39,'uploads/staff/f2.jpg','Mamata Yadav','ममता यादव','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,8,1,'2026-08-31 17:08:43'),(40,'uploads/staff/f3.jpg','Manju Jha','मन्जु झा','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,9,1,'2026-08-31 17:08:43'),(41,'uploads/staff/m7.jpg','Bimal Kumar Jha','विमल कुमार झा','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,10,1,'2026-08-31 17:08:43'),(42,'uploads/staff/m8.jpg','Ram Khakal Ray','राम खड्काल राय','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,11,1,'2026-08-31 17:08:43'),(43,'uploads/staff/f4.jpg','Madhuri Sharma','माधुरी शर्मा','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,12,1,'2026-08-31 17:08:43'),(44,'uploads/staff/m9.jpg','Amarendra Sharma','अमरेन्द्र शर्मा','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,13,1,'2026-08-31 17:08:43'),(45,'uploads/staff/f5.jpg','Nirmala Yadav','निर्मला यादव','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,14,1,'2026-08-31 17:08:43'),(46,'uploads/staff/f6.jpg','Indira Jha','इन्दिरा झा','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,15,1,'2026-08-31 17:08:43'),(47,'uploads/staff/m10.jpg','Manoj Ray','मनोज राय','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,16,1,'2026-08-31 17:08:43'),(48,'uploads/staff/m11.jpg','Dara Paswan','दारा पासवान','Teacher','सहायक शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,17,1,'2026-08-31 17:08:43'),(49,'uploads/staff/f7.jpg','Pushpa (Unknown)','पुष्पा (अस्पष्ट)','ECD Teacher','बाल विकास शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,18,1,'2026-08-31 17:08:43'),(50,'uploads/staff/f8.jpg','Anita Yadav','अनिता यादव','ECD Teacher','बाल विकास शिक्षक','Teaching',NULL,NULL,NULL,0,0,3,19,1,'2026-08-31 17:08:43'),(51,'uploads/staff/m12.jpg','Dipendra Yadav','दिपेन्द्र यादव','School Helper','विद्यालय सहयोगी','Teaching',NULL,NULL,NULL,0,0,3,20,1,'2026-08-31 17:08:43'),(52,'uploads/staff/m13.jpg','Anand Pandit','आनन्द पण्डित','School Helper','विद्यालय सहयोगी','Teaching',NULL,NULL,NULL,0,0,3,21,1,'2026-08-31 17:08:43'),(53,'uploads/staff/m14.jpg','Om Shankar Adhikari','ओम शंकर अधिकारी','Teacher (Computer)','प्राविधिक शिक्षक','Technical (Computer)',NULL,NULL,NULL,0,0,3,22,1,'2026-08-31 17:08:43'),(54,'uploads/staff/m15.jpg','Dipak Yadav','दिपक यादव','Teacher (Computer)','प्राविधिक शिक्षक','Technical (Computer)',NULL,NULL,NULL,0,0,3,23,1,'2026-08-31 17:08:43'),(55,'uploads/staff/m16.jpg','Ramnarayan Pandit','रामनारायण पण्डित','Teacher (Computer)','प्राविधिक शिक्षक','Technical (Computer)',NULL,NULL,NULL,0,0,3,24,1,'2026-08-31 17:08:43'),(56,'uploads/staff/m17.jpg','Anil Kumar Pandit','अनिल कुमार पण्डित','Teacher (Computer)','प्राविधिक शिक्षक','Technical (Computer)',NULL,NULL,NULL,0,0,3,25,1,'2026-08-31 17:08:43');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_categories`
--

DROP TABLE IF EXISTS `staff_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_np` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_categories`
--

LOCK TABLES `staff_categories` WRITE;
/*!40000 ALTER TABLE `staff_categories` DISABLE KEYS */;
INSERT INTO `staff_categories` VALUES (1,'leadership','Leadership','नेतृत्व',1),(2,'administration','Administration','प्रशासन',3),(3,'teaching','Teaching Staff','शिक्षक कर्मचारी',4),(4,'non_teaching','Non-Teaching Staff','गैर-शिक्षण कर्मचारी',5),(5,'committee','School Management Committee','विद्यालय व्यवस्थापन समिति',2);
/*!40000 ALTER TABLE `staff_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_results`
--

DROP TABLE IF EXISTS `student_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_results` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int unsigned NOT NULL,
  `symbol_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `result_status` enum('graded','non-graded','withheld') COLLATE utf8mb4_unicode_ci DEFAULT 'graded',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_exam_symbol` (`exam_id`,`symbol_no`),
  KEY `idx_results_symbol` (`symbol_no`),
  CONSTRAINT `student_results_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_results`
--

LOCK TABLES `student_results` WRITE;
/*!40000 ALTER TABLE `student_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@shreepublic.edu.np','$2y$10$1RDYtl2csyQAp4Tb6QhmJu1kEvO/qqppY2G/hVCQHbK0lWgovPfbK',1,1,'2026-09-08 13:33:56','2026-08-24 22:03:54','2026-09-08 13:33:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sps_malangwa'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-10 14:01:59
