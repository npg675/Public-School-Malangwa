-- Shree Public Secondary School — Normalized Schema
-- Malangwa-2, Sarlahi | IEMIS 190640003 | MySQL 8 / MariaDB compatible
-- Charset: utf8mb4_unicode_ci — supports Nepali Devanagari
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- Users & RBAC
CREATE TABLE IF NOT EXISTS roles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (slug,name) VALUES ('super_admin','Super Admin'),('school_admin','School Admin'),('editor','Editor'),('exam_officer','Exam Officer')
ON DUPLICATE KEY UPDATE name=VALUES(name);

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role_id INT UNSIGNED NOT NULL,
  is_active TINYINT(1) DEFAULT 1,
  last_login_at DATETIME NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site settings (key/value)
CREATE TABLE IF NOT EXISTS site_settings (
  `key` VARCHAR(100) PRIMARY KEY,
  `value` TEXT,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO site_settings (`key`,`value`) VALUES
('site_name_en','Shree Public Secondary School'),
('site_name_np','श्री पब्लिक माध्यमिक विद्यालय'),
('address_en','Malangwa-2, Sarlahi, Madhesh Province, Nepal'),
('address_np','मलंगवा-२, सर्लाही, मधेश प्रदेश, नेपाल'),
('phone',''),
('email',''),
('office_hours',''),
('students_display','1,000+'),
('iemis_code','190640003'),
('coords_lat','26.8501032'),
('coords_lng','85.555064'),
('plus_code','VH24+22W'),
('show_principal','0'),
('principal_name',''),
('principal_message_en',''),
('principal_message_np','')
ON DUPLICATE KEY UPDATE `value`=VALUES(`value`);

-- Pages
CREATE TABLE IF NOT EXISTS pages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(190) NOT NULL UNIQUE,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  content_en MEDIUMTEXT NULL,
  content_np MEDIUMTEXT NULL,
  meta_description VARCHAR(255) NULL,
  status ENUM('draft','published') DEFAULT 'published',
  updated_by INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notice categories
CREATE TABLE IF NOT EXISTS notice_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO notice_categories (slug,name_en,name_np,sort_order) VALUES
('general','General Notice','सामान्य सूचना',1),
('examination','Examination','परीक्षा',2),
('admission','Admission','भर्ना',3),
('holiday','Holiday','बिदा',4),
('vacancy','Vacancy','रिक्त',5),
('scholarship','Scholarship','छात्रवृत्ति',6),
('procurement','Procurement/Tender','खरिद/बोलपत्र',7),
('events','Events','कार्यक्रम',8),
('results','Results','नतिजा',9),
('urgent','Urgent','जरुरी',10)
ON DUPLICATE KEY UPDATE name_en=VALUES(name_en);

-- Notices
CREATE TABLE IF NOT EXISTS notices (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  reference_number VARCHAR(100) NULL,
  category_id INT UNSIGNED NULL,
  description_en MEDIUMTEXT NULL,
  description_np MEDIUMTEXT NULL,
  attachment VARCHAR(255) NULL,
  attachment_type ENUM('pdf','docx','xlsx','jpg','png') NULL,
  thumbnail VARCHAR(255) NULL,
  published_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  expires_at DATETIME NULL,
  is_pinned TINYINT(1) DEFAULT 0,
  is_urgent TINYINT(1) DEFAULT 0,
  status ENUM('draft','published','archived') DEFAULT 'published',
  created_by INT UNSIGNED NULL,
  updated_by INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES notice_categories(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_notices_status_published (status, published_at),
  INDEX idx_notices_category (category_id),
  FULLTEXT idx_notices_search (title_en, title_np, description_en)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- News
CREATE TABLE IF NOT EXISTS news_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO news_categories (slug,name_en) VALUES ('general','General'),('academic','Academic'),('community','Community'),('sports','Sports'),('cultural','Cultural') ON DUPLICATE KEY UPDATE name_en=VALUES(name_en);

CREATE TABLE IF NOT EXISTS news (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  category_id INT UNSIGNED NULL,
  excerpt_en VARCHAR(400) NULL,
  excerpt_np VARCHAR(400) NULL,
  content_en MEDIUMTEXT NULL,
  content_np MEDIUMTEXT NULL,
  cover_image VARCHAR(255) NULL,
  published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('draft','published','archived') DEFAULT 'published',
  created_by INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES news_categories(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_news_status (status, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Events
CREATE TABLE IF NOT EXISTS events (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  description_en TEXT NULL,
  description_np TEXT NULL,
  location_en VARCHAR(255) NULL,
  location_np VARCHAR(255) NULL,
  event_date DATE NOT NULL,
  event_time VARCHAR(100) NULL,
  cover_image VARCHAR(255) NULL,
  status ENUM('draft','published','archived') DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_events_date (event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Academic programs
CREATE TABLE IF NOT EXISTS academic_programs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  title_en VARCHAR(150) NOT NULL,
  title_np VARCHAR(150) NULL,
  level ENUM('ecd','basic_1_5','basic_6_8','secondary_9_10','higher_secondary') NOT NULL,
  stream VARCHAR(50) NULL,
  description_en TEXT NULL,
  description_np TEXT NULL,
  sort_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO academic_programs (slug,title_en,level,stream,sort_order) VALUES
('ecd','ECD / Nursery','ecd',NULL,1),
('grades-1-5','Grades 1–5','basic_1_5',NULL,2),
('grades-6-8','Grades 6–8','basic_6_8',NULL,3),
('grades-9-10','Grades 9–10 (SEE)','secondary_9_10',NULL,4),
('plus2-science','+2 Science','higher_secondary','Science',5),
('plus2-management','+2 Management','higher_secondary','Management',6)
ON DUPLICATE KEY UPDATE title_en=VALUES(title_en);

-- Staff
CREATE TABLE IF NOT EXISTS staff_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(50) NOT NULL UNIQUE,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO staff_categories (slug,name_en,sort_order) VALUES ('leadership','Leadership',1),('administration','Administration',2),('teaching','Teaching Staff',3),('non_teaching','Non-Teaching Staff',4) ON DUPLICATE KEY UPDATE name_en=VALUES(name_en);

CREATE TABLE IF NOT EXISTS staff (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  photo VARCHAR(255) NULL,
  name_en VARCHAR(150) NOT NULL,
  name_np VARCHAR(150) NULL,
  designation_en VARCHAR(150) NOT NULL,
  designation_np VARCHAR(150) NULL,
  department VARCHAR(100) NULL,
  qualification VARCHAR(255) NULL,
  phone VARCHAR(50) NULL,
  email VARCHAR(150) NULL,
  show_phone TINYINT(1) DEFAULT 0,
  show_email TINYINT(1) DEFAULT 0,
  category_id INT UNSIGNED NULL,
  display_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES staff_categories(id) ON DELETE SET NULL,
  INDEX idx_staff_category (category_id, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Downloads
CREATE TABLE IF NOT EXISTS download_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) NOT NULL UNIQUE,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO download_categories (slug,name_en,sort_order) VALUES
('forms','Forms',1),('routine','Routine',2),('results','Results',3),('academic-calendar','Academic Calendar',4),('curriculum','Curriculum',5),('reports','Reports',6),('citizen-charter','Citizen Charter',7),('policies','Policies',8),('procurement','Procurement',9),('publications','Publications',10),('scholarships','Scholarships',11),('other','Other',12)
ON DUPLICATE KEY UPDATE name_en=VALUES(name_en);

CREATE TABLE IF NOT EXISTS downloads (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  category_id INT UNSIGNED NULL,
  file_path VARCHAR(255) NOT NULL,
  file_size INT UNSIGNED NULL,
  file_type VARCHAR(20) NULL,
  published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('draft','published','archived') DEFAULT 'published',
  download_count INT UNSIGNED DEFAULT 0,
  created_by INT UNSIGNED NULL,
  FOREIGN KEY (category_id) REFERENCES download_categories(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_downloads_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Publications (alias to downloads with publication flag optionally)
CREATE TABLE IF NOT EXISTS publications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  description_en TEXT NULL,
  description_np TEXT NULL,
  cover_image VARCHAR(255) NULL,
  file_path VARCHAR(255) NULL,
  published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('draft','published') DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Gallery
CREATE TABLE IF NOT EXISTS gallery_albums (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(150) NOT NULL UNIQUE,
  title_en VARCHAR(150) NOT NULL,
  title_np VARCHAR(150) NULL,
  description_en VARCHAR(500) NULL,
  cover_image VARCHAR(255) NULL,
  sort_order INT DEFAULT 0,
  status ENUM('draft','published') DEFAULT 'published',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gallery_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  album_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  caption_en VARCHAR(255) NULL,
  caption_np VARCHAR(255) NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (album_id) REFERENCES gallery_albums(id) ON DELETE CASCADE,
  INDEX idx_gallery_album (album_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Academic calendars
CREATE TABLE IF NOT EXISTS academic_calendars (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_np VARCHAR(255) NULL,
  academic_year VARCHAR(20) NOT NULL,
  file_path VARCHAR(255) NULL,
  published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('draft','published') DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exams & Results
CREATE TABLE IF NOT EXISTS exam_types (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO exam_types (name_en) VALUES ('SEE'),('Grade 12 (NEB)'),('Internal') ON DUPLICATE KEY UPDATE name_en=VALUES(name_en);

CREATE TABLE IF NOT EXISTS exams (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  exam_type_id INT UNSIGNED NOT NULL,
  academic_year VARCHAR(20) NOT NULL,
  class_name VARCHAR(50) NOT NULL,
  title_en VARCHAR(200) NOT NULL,
  is_published TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_type_id) REFERENCES exam_types(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS student_results (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  exam_id INT UNSIGNED NOT NULL,
  symbol_no VARCHAR(50) NOT NULL,
  student_name VARCHAR(150) NOT NULL,
  grade VARCHAR(20) NULL,
  gpa DECIMAL(3,2) NULL,
  result_status ENUM('graded','non-graded','withheld') DEFAULT 'graded',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
  UNIQUE KEY uniq_exam_symbol (exam_id, symbol_no),
  INDEX idx_results_symbol (symbol_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  email VARCHAR(150) NULL,
  subject VARCHAR(200) NULL,
  message TEXT NOT NULL,
  lang VARCHAR(5) DEFAULT 'en',
  is_read TINYINT(1) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_contact_read (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Menus (optional)
CREATE TABLE IF NOT EXISTS menus (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  location ENUM('header','footer','quick') NOT NULL,
  label_en VARCHAR(100) NOT NULL,
  label_np VARCHAR(100) NULL,
  url VARCHAR(255) NOT NULL,
  sort_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Activity logs
CREATE TABLE IF NOT EXISTS activity_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  action VARCHAR(100) NOT NULL,
  entity_type VARCHAR(100) NULL,
  entity_id VARCHAR(100) NULL,
  detail TEXT NULL,
  ip_address VARCHAR(45) NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_logs_user (user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;

-- Default admin (password: Admin@123 — change immediately)
-- password_hash('Admin@123', PASSWORD_DEFAULT)
INSERT INTO users (name,email,password_hash,role_id) VALUES
('Super Admin','admin@shreepublic.edu.np','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1)
ON DUPLICATE KEY UPDATE email=VALUES(email);
