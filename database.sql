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
('show_principal','1'),
('principal_name','Devbarat Prasad Patel'),
('principal_message_en','Our mission is to provide an inclusive, high-quality education that empowers students from all backgrounds to become responsible citizens and future leaders. We invite you to be a part of our growing community.'),
('principal_message_np','हाम्रो लक्ष्य सबै पृष्ठभूमिका विद्यार्थीहरूलाई जिम्मेवार नागरिक र भविष्यका नेता बन्न सशक्त बनाउँदै समावेशी, गुणस्तरीय शिक्षा प्रदान गर्नु हो।'),
('principal_photo','uploads/gallery/staff/leadership-team-photo.jpg'),
('logo_path','assets/img/logo.png')
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

INSERT INTO academic_programs (slug,title_en,title_np,level,stream,sort_order,description_en,description_np) VALUES
('ecd','ECD / Nursery','ईसीडी / नर्सरी','ecd',NULL,1,'<p>Play-based start to formal schooling — early language, early numeracy, creative expression and social habits under the CDC national framework. Readiness for Grade 1 is emphasised over premature formal testing.</p>','<p>राष्ट्रिय पाठ्यक्रम (सीडीसी) अनुसार खेलमार्फत सिकाइ — प्रारम्भिक भाषा, अंक ज्ञान, सिर्जनात्मक अभिव्यक्ति र सामाजिक बानी। कक्षा १ को तयारीलाई प्राथमिकता।</p>'),
('grades-1-5','Grades 1–5','कक्षा १–५','basic_1_5',NULL,2,'<p>Foundational literacy and numeracy — reading and writing in Nepali and English, arithmetic and introduction to the natural and social environment under the national curriculum.</p>','<p>आधारभूत साक्षरता र अंक ज्ञान — नेपाली र अंग्रेजीमा पढाइ र लेखाइ, अंकगणित तथा प्राकृतिक र सामाजिक वातावरणको परिचय।</p>'),
('grades-6-8','Grades 6–8','कक्षा ६–८','basic_6_8',NULL,3,'<p>Structured subject learning — English and Nepali literacy, mathematics, science, social studies and health &amp; physical education with study habits for secondary readiness.</p>','<p>संरचित विषयगत सिकाइ — अंग्रेजी र नेपाली साक्षरता, गणित, विज्ञान, सामाजिक अध्ययन र स्वास्थ्य तथा शारीरिक शिक्षा।</p>'),
('grades-9-10','Grades 9–10 (SEE)','कक्षा ९–१० (एसईई)','secondary_9_10',NULL,4,'<p>Secondary Level culminating in the Secondary Education Examination (SEE) at the end of Grade 10. Emphasis on subject depth, examination readiness and preparation for higher secondary.</p>','<p>कक्षा १० को अन्त्यमा माध्यमिक शिक्षा परीक्षा (एसईई) मा समापन हुने माध्यमिक तह। विषयगत गहिराइ, परीक्षा तयारी र उच्च माध्यमिकको तयारीमा जोड।</p>'),
('plus2-science','+2 Science','+२ विज्ञान','higher_secondary','Science',5,'<p>Two-year NEB Science stream — scientific reasoning, mathematics, analytical thinking and practical problem solving. Prepares for further study in science, technology, health sciences and engineering.</p>','<p>दुई वर्षे एनईबी विज्ञान स्ट्रिम — वैज्ञानिक तर्क, गणित, विश्लेषणात्मक सोच र व्यावहारिक समस्या समाधान। विज्ञान, प्रविधि, स्वास्थ्य विज्ञान र इन्जिनियरिङमा थप अध्ययनको तयारी।</p>'),
('plus2-management','+2 Management','+२ व्यवस्थापन','higher_secondary','Management',6,'<p>Two-year NEB Management stream — business understanding, accounting concepts, economics and organisational thinking, communication &amp; entrepreneurship.</p>','<p>दुई वर्षे एनईबी व्यवस्थापन स्ट्रिम — व्यापार बुझाइ, लेखा अवधारणा, अर्थशास्त्र र संगठनात्मक सोच, सञ्चार र उद्यमशीलता।</p>')
ON DUPLICATE KEY UPDATE title_en=VALUES(title_en), description_en=VALUES(description_en), description_np=VALUES(description_np);

-- Staff
CREATE TABLE IF NOT EXISTS staff_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(50) NOT NULL UNIQUE,
  name_en VARCHAR(100) NOT NULL,
  name_np VARCHAR(100) NULL,
  sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO staff_categories (slug,name_en,name_np,sort_order) VALUES
('leadership','Leadership','नेतृत्व',1),
('committee','School Management Committee','विद्यालय व्यवस्थापन समिति',2),
('administration','Administration','प्रशासन',3),
('teaching','Teaching Staff','शिक्षक कर्मचारी',4),
('non_teaching','Non-Teaching Staff','गैर-शिक्षण कर्मचारी',5)
ON DUPLICATE KEY UPDATE name_en=VALUES(name_en), name_np=VALUES(name_np), sort_order=VALUES(sort_order);

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
  UNIQUE KEY uniq_album_image (album_id, image_path),
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

-- Content blocks (CMS page sections)
CREATE TABLE IF NOT EXISTS content_blocks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page_slug VARCHAR(100) NOT NULL,
  section_key VARCHAR(100) NOT NULL,
  sort_order INT DEFAULT 0,
  title_en VARCHAR(255) NULL,
  title_np VARCHAR(255) NULL,
  subtitle_en VARCHAR(255) NULL,
  subtitle_np VARCHAR(255) NULL,
  body_en MEDIUMTEXT NULL,
  body_np MEDIUMTEXT NULL,
  image_url VARCHAR(255) NULL,
  icon VARCHAR(50) NULL,
  link_url VARCHAR(255) NULL,
  is_active TINYINT(1) DEFAULT 1,
  updated_by INT UNSIGNED NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_blocks_page (page_slug, section_key, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;

-- ============================================================
-- CONTENT SEEDS (match the Stitch-designed frontend)
-- Safe to re-run: INSERT IGNORE on unique slugs / NOT EXISTS guards
-- ============================================================

-- Default admin (password: Admin@123 — change immediately)
-- password_hash('Admin@123', PASSWORD_DEFAULT)
INSERT INTO users (name,email,password_hash,role_id) VALUES
('Super Admin','admin@shreepublic.edu.np','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1)
ON DUPLICATE KEY UPDATE email=VALUES(email);

-- ---- Notices (homepage Notice Board) ----
INSERT IGNORE INTO notices (title_en, title_np, slug, reference_number, category_id, description_en, published_at, is_pinned, is_urgent, status) VALUES
('New Admission Open for Academic Session 2082 (ECD to Grade 9)','शैक्षिक सत्र २०८२ को लागि भर्ना खुला (बालविकास देखि कक्षा ९)','admission-open-2082','SPS/Notice/2082-01',(SELECT id FROM notice_categories WHERE slug='admission'),'Admission forms are available at the school office during office hours (Sun–Fri, 10:00 AM – 4:00 PM). Limited seats per level. Bring birth certificate, transfer certificate and previous marksheet.', NOW() - INTERVAL 3 DAY, 1, 0, 'published'),
('SEE Examination Routine 2082 Published','एस.ई.ई. परीक्षा कार्यक्रम २०८२ प्रकाशित','see-routine-2082','SPS/Exam/2082-04',(SELECT id FROM notice_categories WHERE slug='examination'),'The SEE examination routine for Grade 10 students has been published. Students may collect the routine PDF from the Downloads section or the school notice board.', NOW() - INTERVAL 12 DAY, 0, 0, 'published'),
('Vacancy Announcement: Secondary Level Science Teacher (Contract)','सूचना: माध्यमिक तह विज्ञान शिक्षक (करार)','vacancy-science-teacher-2082','SPS/Vacancy/2082-03',(SELECT id FROM notice_categories WHERE slug='vacancy'),'Applications are invited from qualified candidates for Secondary Level Science Teacher (contract basis). Deadline: within 15 days of this notice. Apply at the school office.', NOW() - INTERVAL 20 DAY, 0, 1, 'published'),
('Grade 11 Scholarship Application Deadline Extended','कक्षा ११ छात्रवृत्ति आवेदन म्याद थप','scholarship-grade11-extended','SPS/Schol/2082-02',(SELECT id FROM notice_categories WHERE slug='scholarship'),'The application deadline for Grade 11 scholarships (merit and quota-based) has been extended by one week. Eligible students should submit documents to the school office.', NOW() - INTERVAL 30 DAY, 0, 0, 'published'),
('School Closure Notice for Holi Festival','फागु पूर्णिमा (होली) को बिदा सम्बन्धी सूचना','holiday-holi-2082','SPS/Gen/2082-06',(SELECT id FROM notice_categories WHERE slug='holiday'),'The school will remain closed on the occasion of Fagu Purnima (Holi). Regular classes resume the following day.', NOW() - INTERVAL 45 DAY, 0, 0, 'published');

-- ---- Upcoming Events (homepage Events column) ----
INSERT IGNORE INTO events (title_en, title_np, slug, description_en, location_en, event_date, event_time, status) VALUES
('16 Days of Activism against Gender-Based Violence Campaign','लैंगिक हिंसाविरुद्ध १६ दिने अभियान','16-days-activism','Inaugurated with Malangwa Municipality, INSEC and local community groups. Awareness rallies and poster competitions by students.','Shree Public Secondary School, Malangwa-2', CURDATE() + INTERVAL 10 DAY, '11:00 AM', 'published'),
('Annual Sports Meet 2082','वार्षिक खेलकुद २०८२','annual-sports-meet-2082','Track and field events for all levels — ECD to Grade 12. Parents and community members are warmly invited.','School Playground, Malangwa-2', CURDATE() + INTERVAL 25 DAY, '9:00 AM', 'published'),
('School Level Science Exhibition','विद्यालय स्तरीय विज्ञान प्रदर्शनी','science-exhibition-2082','Students present working models from Physics, Chemistry and Biology. Best projects advance to the district level competition.','Science Block, Malangwa-2', CURDATE() + INTERVAL 40 DAY, '10:00 AM', 'published');

-- ---- News ----
INSERT IGNORE INTO news (title_en, title_np, slug, category_id, excerpt_en, content_en, cover_image, published_at, status) VALUES
('Students Secure First Position in District Science Fair','जिल्ला विज्ञान महोत्सवमा प्रथम','news-district-science-win',(SELECT id FROM news_categories WHERE slug='academic'),'Our Grade 10 team presented an innovative water filtration model and won first place at the Sarlahi district science fair.','Our Grade 10 students represented the school at the Sarlahi district level science fair and secured the first position with an innovative low-cost water filtration model. The team was felicitated at the school assembly. Congratulations to the students and supervising teachers!','uploads/gallery/campus/staff-room-computer.jpg', NOW() - INTERVAL 7 DAY, 'published'),
('Community Tree Plantation Drive Completed','सामुदायिक वृक्षरोपण सम्पन्न','news-tree-plantation',(SELECT id FROM news_categories WHERE slug='community'),'Eco-club members and local volunteers planted 200+ saplings around the school premises with Malangwa Municipality support.','With support from Malangwa Municipality, our eco-club members, teachers and local volunteers completed a tree plantation drive around the school boundary, planting over 200 saplings of local species. The school thanks all community members who participated.','uploads/gallery/community/complaint-box-life-nepal.jpg', NOW() - INTERVAL 18 DAY, 'published');

-- ---- Downloads (homepage Resources & Downloads) ----
-- NOTE: upload the actual PDF files to uploads/downloads/ via Admin > Downloads, or update file_path.
INSERT IGNORE INTO downloads (title_en, title_np, category_id, file_path, file_size, file_type, published_at, status) VALUES
('Student Admission Form 2082','भर्ना फारम २०८२',(SELECT id FROM download_categories WHERE slug='forms'),'uploads/downloads/admission-form-2082.pdf',1228800,'PDF', NOW() - INTERVAL 5 DAY, 'published'),
('Academic Calendar 2082','शैक्षिक पात्रो २०८२',(SELECT id FROM download_categories WHERE slug='academic-calendar'),'uploads/downloads/academic-calendar-2082.pdf',460800,'PDF', NOW() - INTERVAL 8 DAY, 'published'),
('Scholarship Guidelines 2082','छात्रवृत्ति निर्देशिका २०८२',(SELECT id FROM download_categories WHERE slug='scholarships'),'uploads/downloads/scholarship-guidelines-2082.pdf',2202009,'PDF', NOW() - INTERVAL 15 DAY, 'published'),
('Code of Conduct for Students','विद्यार्थी आचारसंहिता',(SELECT id FROM download_categories WHERE slug='policies'),'uploads/downloads/code-of-conduct.pdf',819200,'PDF', NOW() - INTERVAL 30 DAY, 'published'),
('School Prospectus 2082','विद्यालय परिचय पुस्तिका',(SELECT id FROM download_categories WHERE slug='publications'),'uploads/downloads/school-prospectus-2082.pdf',5662310,'PDF', NOW() - INTERVAL 40 DAY, 'published'),
('Citizen Charter (नागरिक वडापत्र)','नागरिक वडापत्र',(SELECT id FROM download_categories WHERE slug='citizen-charter'),'uploads/downloads/citizen-charter.pdf',1887436,'PDF', NOW() - INTERVAL 50 DAY, 'published');

-- ---- Gallery Albums (uses real uploaded photos in /uploads/gallery) ----
INSERT IGNORE INTO gallery_albums (slug, title_en, title_np, description_en, cover_image, sort_order, status) VALUES
('campus-school','School & Campus','विद्यालय तथा परिसर','Classrooms, buildings, offices and everyday life inside the school campus.','uploads/gallery/campus/front-building-entrance.jpg',1,'published'),
('assembly-events','Assembly & Events','प्रार्थना सभा तथा कार्यक्रम','Morning assemblies, announcements and school-wide gatherings.','uploads/gallery/assembly/teacher-addressing-assembly.jpg',2,'published'),
('staff-leadership','Staff & Leadership','शिक्षक तथा नेतृत्व','Our teaching staff, leadership team and management committee.','uploads/gallery/staff/leadership-team-photo.jpg',3,'published'),
('community-programs','Community Programs','सामुदायिक कार्यक्रम','Programs run with parents, local wards and Malangwa Municipality.','uploads/gallery/community/complaint-box-life-nepal.jpg',4,'published');

INSERT INTO gallery_images (album_id, image_path, caption_en, sort_order)
SELECT a.id, t.image_path, t.caption_en, t.sort_order
FROM gallery_albums a
JOIN (
  SELECT 'campus-school' AS album_slug, 'uploads/gallery/campus/front-building-entrance.jpg' AS image_path, 'School main building and entrance' AS caption_en, 1 AS sort_order
  UNION ALL SELECT 'campus-school','uploads/gallery/campus/school-sign-closeup.jpg','School name board at the gate',2
  UNION ALL SELECT 'campus-school','uploads/gallery/campus/headmaster-office.jpg','Head teacher office',3
  UNION ALL SELECT 'campus-school','uploads/gallery/campus/staff-room-interior.jpg','Staff room',4
  UNION ALL SELECT 'campus-school','uploads/gallery/campus/staff-room-computer.jpg','ICT corner with computers',5
  UNION ALL SELECT 'campus-school','uploads/gallery/campus/courtyard-students-formation.jpg','Students in courtyard formation',6
  UNION ALL SELECT 'campus-school','uploads/hero/hero-main-gate-jubilee.jpg','Main gate',7
  UNION ALL SELECT 'campus-school','uploads/hero/hero-courtyard-assembly.jpg','Courtyard assembly',8
  UNION ALL SELECT 'campus-school','uploads/about/campus-assembly-building.jpg','Assembly in front of the building',9
  UNION ALL SELECT 'campus-school','uploads/about/campus-building-aerial.jpg','School building view',10
  UNION ALL SELECT 'assembly-events','uploads/gallery/assembly/teacher-addressing-assembly.jpg','Teacher addressing the morning assembly',1
  UNION ALL SELECT 'assembly-events','uploads/gallery/assembly/staff-meeting-courtyard.jpg','Staff meeting in the courtyard',2
  UNION ALL SELECT 'staff-leadership','uploads/gallery/staff/leadership-team-photo.jpg','School leadership team',1
  UNION ALL SELECT 'community-programs','uploads/gallery/community/complaint-box-life-nepal.jpg','Community program at school',1
) t ON a.slug = t.album_slug
WHERE NOT EXISTS (SELECT 1 FROM gallery_images gi WHERE gi.album_id = a.id AND gi.image_path = t.image_path);

-- ---- Staff (leadership shown on About page) ----
INSERT IGNORE INTO staff (photo, name_en, name_np, designation_en, designation_np, department, category_id, display_order, is_active) VALUES
('uploads/gallery/staff/leadership-team-photo.jpg','Devbarat Prasad Patel','देववरत प्रसाद पटेल','Chairman / Head Teacher','अध्यक्ष / प्रधानाध्यापक','Leadership',(SELECT id FROM staff_categories WHERE slug='leadership'),1,1),
(NULL,'—','—','Principal','प्रधानाध्यापक','Leadership',(SELECT id FROM staff_categories WHERE slug='leadership'),2,1),
(NULL,'—','—','Vice-Principal','उपप्रधानाध्यापक','Leadership',(SELECT id FROM staff_categories WHERE slug='leadership'),3,1);

-- ---- Static Pages (Admin > Pages module) ----
INSERT INTO pages (slug, title_en, title_np, content_en, content_np, meta_description, status) VALUES
('about','About Our School','हाम्रो विद्यालयबारे','<h2>Welcome to Shree Public Secondary School</h2><p>Shree Public Secondary School is a government community school located in Malangwa-2, Sarlahi, Madhesh Province, Nepal. The school provides quality education from Early Childhood Development (ECD) through Grade 12, including +2 programs in Science and Management affiliated with the National Examination Board (NEB).</p><h3>Our Mission</h3><p>To provide accessible, equitable and quality education to every child of our community regardless of background.</p><h3>Our Vision</h3><p>To be a model community school in Madhesh Province known for academic excellence, discipline and social responsibility.</p>','<h2>श्री पब्लिक माध्यमिक विद्यालयमा स्वागत छ</h2><p>श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेश, सर्लाही जिल्लाको मलंगवा–२ मा अवस्थित एक सरकारी सामुदायिक विद्यालय हो।</p>','Shree Public Secondary School — public community school in Malangwa-2, Sarlahi. ECD to Grade 12, +2 Science & Management (NEB). IEMIS 190640003.','published'),
('admissions','Admissions','भर्ना','<h2>Admission Open — ECD to Grade 12 &amp; +2</h2><p>Admission availability at Shree Public depends on the academic year, grade and number of seats as determined each year by the school administration. Parents and guardians may visit the school office during office hours (Sunday–Friday, 10:00 AM – 4:00 PM) to collect and submit the application form.</p><h3>Documents Required</h3><ul><li>Birth certificate (copy)</li><li>Transfer certificate (if transferring)</li><li>Previous marksheet/grade sheet</li><li>Passport-size photographs (2 copies)</li><li>Citizenship copy (for +2 applicants)</li></ul>','<h2>भर्ना खुला छ</h2><p>श्री पब्लिकमा भर्ना शैक्षिक वर्ष, कक्षा र सिट संख्यामा निर्भर गर्दछ। अभिभावकहरूले कार्यालय समय (आइतबार–शुक्रबार, बिहान १०:००–अपराह्न ४:००) मा विद्यालय कार्यालयमा सम्पर्क गर्नुहोला।</p><h3>आवश्यक कागजातहरू</h3><ul><li>जन्मदर्ता प्रमाणपत्र (प्रतिलिपि)</li><li>स्थानान्तरण प्रमाणपत्र (यदि स्थानान्तरण भएमा)</li><li>अघिल्लो लब्धाङ्क पत्र</li><li>पासपोर्ट साइज फोटो (२ प्रति)</li><li>नागरिकता प्रतिलिपि (+२ आवेदकका लागि)</li></ul>','Admission information for Shree Public Secondary School Malangwa-2 — ECD to Grade 12, +2 Science & Management (NEB).','published'),
('citizen-charter','Citizen Charter','नागरिक वडापत्र','<h2>Citizen Charter (नागरिक वडापत्र)</h2><p>This charter outlines the services provided by the school, required documents and service delivery time commitments.</p><ul><li>Admission enrollment — same day during office hours</li><li>Transfer certificate — within 2 working days</li><li>Character certificate — within 2 working days</li><li>Marksheet verification — within 3 working days</li></ul>','<h2>नागरिक वडापत्र</h2><p>यो वडापत्रमा विद्यालयले प्रदान गर्ने सेवाहरू र सेवा प्रदान गर्ने समय उल्लेख छ।</p><ul><li>भर्ना दर्ता — कार्यालय समयमा सोही दिन</li><li>स्थानान्तरण प्रमाणपत्र — २ कार्य दिन भित्र</li><li>चारित्रिक प्रमाणपत्र — २ कार्य दिन भित्र</li><li>लब्धाङ्क प्रमाणीकरण — ३ कार्य दिन भित्र</li></ul>','Citizen Charter of Shree Public Secondary School, Malangwa-2 — services, documents, time and fees.','published'),
('scholarships','Scholarships','छात्रवृत्ति','<h2>Scholarships</h2><p>Scholarship quota, eligibility and reservation details are specified in each official notice. When the school or Government of Nepal issues a scholarship notice applicable to this school, it is published on the Notice Board (category: Scholarship) with full details and downloadable forms in Downloads.</p><h3>How to Apply</h3><p>See the attached notice for required documents, application form and deadline. Contact the school office for guidance before the deadline.</p>','<h2>छात्रवृत्ति</h2><p>छात्रवृत्ति कोटा, योग्यता र आरक्षण विवरण प्रत्येक आधिकारिक सूचनामा तोकिन्छ। जब विद्यालय वा नेपाल सरकारले छात्रवृत्ति सूचना जारी गर्दछ, यो सूचना पाटी (छात्रवृत्ति श्रेणी) मा पूर्ण विवरण सहित प्रकाशित हुन्छ।</p><h3>कसरी आवेदन दिने</h3><p>आवश्यक कागजात, आवेदन फारम र अन्तिम मितिका लागि सम्बन्धित सूचना हेर्नुहोस्। अन्तिम मिति अघि मार्गदर्शनका लागि विद्यालय कार्यालयमा सम्पर्क गर्नुहोस्।</p>','Scholarship information — quota, eligibility and application via official notices at Shree Public Secondary School.','published'),
('academics','Academics','शैक्षिक कार्यक्रम','<h2>One continuum — from early childhood to higher secondary</h2><p>Shree Public Secondary School offers the full national school structure in a single institution. Students can enter at Early Childhood Development (ECD) and progress without changing school through <strong>Basic Level (Grades 1–8)</strong>, <strong>Secondary Level (Grades 9–10)</strong> and <strong>Higher Secondary (Grades 11–12)</strong>. The two higher secondary streams currently offered are <strong>+2 Science</strong> and <strong>+2 Management</strong> under the National Examinations Board (NEB). The school follows the national curriculum framework maintained by the Curriculum Development Centre (CDC) and the examination systems of SEE and NEB.</p>','<h2>एक निरन्तरता — प्रारम्भिक बाल्यकालदेखि उच्च माध्यमिकसम्म</h2><p>श्री पब्लिक माध्यमिक विद्यालयले एउटै संस्थामा पूर्ण राष्ट्रिय विद्यालय संरचना प्रदान गर्दछ। विद्यार्थीहरू प्रारम्भिक बालविकास (ईसीडी) मा प्रवेश गरी विद्यालय नबदली <strong>आधारभूत तह (कक्षा १–८)</strong>, <strong>माध्यमिक तह (कक्षा ९–१०)</strong> र <strong>उच्च माध्यमिक (कक्षा ११–१२)</strong> सम्म अगाडि बढ्न सक्छन्। हाल सञ्चालित दुई उच्च माध्यमिक स्ट्रिमहरू <strong>+२ विज्ञान</strong> र <strong>+२ व्यवस्थापन</strong> राष्ट्रिय परीक्षा बोर्ड (एनईबी) अन्तर्गत छन्।</p>','Academics at Shree Public Secondary School — ECD through Grade 12 and +2 Science & Management (NEB).','published'),
('science','+2 Science','+२ विज्ञान','<h2>What the Science stream is for</h2><p>The <strong>+2 Science</strong> program at Shree Public Secondary School is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong>. It is one of two NEB streams currently offered at the school — the other being <strong>+2 Management</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to eligibility criteria and available seats as confirmed each year by the school office. The programme is intended to prepare students for further study after Grade 12 in areas such as <strong>science, technology, health sciences, engineering and natural sciences</strong>.</p><p>Study extends over two academic years with internal assessments and board examinations as required by NEB.</p>','<h2>विज्ञान स्ट्रिम केका लागि हो</h2><p><strong>+२ विज्ञान</strong> कार्यक्रम श्री पब्लिक माध्यमिक विद्यालयमा <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो। यो विद्यालयमा हाल सञ्चालित दुई एनईबी स्ट्रिमहरूमध्ये एक हो — अर्को <strong>+२ व्यवस्थापन</strong> हो।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p><p>अध्ययन दुई शैक्षिक वर्षसम्म चल्छ र एनईबीको आवश्यकता अनुसार आन्तरिक मूल्याङ्कन र बोर्ड परीक्षाहरू हुन्छन्।</p>','+2 Science stream at Shree Public Secondary School — NEB higher secondary overview.','published'),
('management','+2 Management','+२ व्यवस्थापन','<h2>What the Management stream is for</h2><p>The <strong>+2 Management</strong> program is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong> — the second NEB stream currently operated at Shree Public alongside <strong>+2 Science</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to the eligibility criteria and seats confirmed each year by the school office. The programme is intended as preparation for further study after Grade 12 in areas such as <strong>business, commerce, management, finance and related fields</strong>.</p><p>Study runs over two academic years with internal assessments and board examinations as required by NEB.</p>','<h2>व्यवस्थापन स्ट्रिम केका लागि हो</h2><p><strong>+२ व्यवस्थापन</strong> कार्यक्रम <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो — श्री पब्लिकमा <strong>+२ विज्ञान</strong> सँगै सञ्चालित दोस्रो एनईबी स्ट्रिम।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p><p>अध्ययन दुई शैक्षिक वर्षसम्म चल्छ र एनईबीको आवश्यकता अनुसार आन्तरिक मूल्याङ्कन र बोर्ड परीक्षाहरू हुन्छन्।</p>','+2 Management stream at Shree Public Secondary School — NEB higher secondary overview.','published')
ON DUPLICATE KEY UPDATE title_np=VALUES(title_np), content_en=VALUES(content_en), content_np=VALUES(content_np);
INSERT IGNORE INTO pages (slug, title_en, title_np, content_en, content_np, meta_description, status) VALUES
('faq','Frequently Asked Questions','जिज्ञासा','<h2>Frequently Asked Questions</h2><h3>Where is the school located?</h3><p>VH24+22W, Malangwa-2, Sarlahi, Madhesh Province, Nepal (postal code 45800).</p><h3>Which programs does the school offer?</h3><p>ECD through Grade 12, plus +2 Science and +2 Management streams affiliated with NEB.</p><h3>What are the office hours?</h3><p>Sunday to Friday, 10:00 AM to 4:00 PM. Closed on Saturday.</p>','<h2>जिज्ञासाहरू</h2><h3>विद्यालय कहाँ अवस्थित छ?</h3><p>मलंगवा–२, सर्लाही, मधेश प्रदेश।</p>','Frequently asked questions about Shree Public Secondary School, Malangwa-2.','published'),
('publications','Publications','प्रकाशनहरू','<h2>Publications &amp; Reports</h2><p>Official publications of the school are made available for public transparency: annual reports, school improvement plans and financial summaries. Printed copies are available at the school office.</p>','<h2>प्रकाशनहरू</h2><p>विद्यालयका आधिकारिक प्रकाशनहरू सार्वजनिक पारदर्शिताका लागि उपलब्ध गराइएको छ।</p>','Publications from Shree Public Secondary School — annual reports, prospectus, transparency documents.','published');

-- ---- Content Blocks seeds ----
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'hero', 0, 'Shree Public Secondary School — Malangwa-2', 'श्री पब्लिक माध्यमिक विद्यालय — मलंगवा-२', 'Admissions Open 2082', 'भर्ना खुला २०८२', 'Providing public education from Early Childhood Development through Grade 12 in the heart of Malangwa. ECD–12 • +2 Science & Management (NEB).', 'मलंगवाको केन्द्रमा बालविकासदेखि कक्षा १२ सम्म सार्वजनिक शिक्षा। ईसीडी–१२ • +२ विज्ञान तथा व्यवस्थापन (एनईबी)।', 'uploads/hero/hero-main-gate-jubilee.jpg', NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='hero' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'stat', 1, '45+', '४५+', NULL, NULL, 'Qualified Teachers', 'योग्य शिक्षकहरू', NULL, 'groups', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='stat' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'stat', 2, '1,000+', '१,०००+', NULL, NULL, 'Students', 'विद्यार्थीहरू', NULL, 'groups', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='stat' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'stat', 3, '1947', '१९४७', NULL, NULL, 'Established', 'स्थापना', NULL, 'history_edu', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='stat' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'stat', 4, '98%', '९८%', NULL, NULL, 'Pass Rate', 'उत्तीर्ण दर', NULL, 'verified', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='stat' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'intro', 0, 'About Our School', 'हाम्रो विद्यालयको बारेमा', NULL, NULL, 'Shree Public Secondary School is a government-recognised community educational institution situated in the heart of Malangwa Municipality-2, Sarlahi District, Madhesh Province. Registered under IEMIS Code 190640003, our school plays a central role in providing accessible education to the local community. We offer formal education from Early Childhood Development (ECD) up to Grade 12, following the National Examination Board (NEB) curriculum.', 'श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेशको सर्लाही जिल्ला, मलंगवा नगरपालिका-२ को केन्द्रमा अवस्थित सरकारबाट मान्यता प्राप्त सामुदायिक शैक्षिक संस्था हो। IEMIS कोड १९०६४०००३ मा दर्ता भएको हाम्रो विद्यालयले स्थानीय समुदायलाई पहुँचयोग्य शिक्षा प्रदान गर्न केन्द्रीय भूमिका खेल्दछ। हामी प्रारम्भिक बालविकास (ईसीडी) देखि कक्षा १२ सम्म राष्ट्रिय परीक्षा बोर्ड (एनईबी) को पाठ्यक्रम अनुसार औपचारिक शिक्षा प्रदान गर्छौं।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='intro' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'commitment', 1, 'National Curriculum', 'राष्ट्रिय पाठ्यक्रम', NULL, NULL, 'Curriculum per Curriculum Development Centre (CDC).', 'पाठ्यक्रम विकास केन्द्र (सीडीसी) अनुसारको पाठ्यक्रम।', NULL, 'volunteer_activism', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='commitment' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'commitment', 2, 'Two NEB Streams', 'दुई एनईबी स्ट्रिमहरू', NULL, NULL, '+2 Science & Management under NEB.', 'एनईबी अन्तर्गत +२ विज्ञान र व्यवस्थापन।', NULL, 'workspace_premium', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='commitment' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'commitment', 3, 'Community Focus', 'सामुदायिक केन्द्रित', NULL, NULL, 'Serving families of Malangwa-2 and surrounding wards.', 'मलंगवा-२ र वरपरका वडाका परिवारहरूको सेवा।', NULL, 'biotech', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='commitment' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'commitment', 4, 'Government Oversight', 'सरकारी रेखदेख', NULL, NULL, 'Public community school — IEMIS 190640003.', 'सामुदायिक विद्यालय — IEMIS १९०६४०००३।', NULL, 'handshake', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='commitment' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'home', 'cta_banner', 0, 'Admissions Now Open for 2082', '२०८२ का लागि भर्ना खुला छ', NULL, NULL, 'Secure a bright future. Join Shree Public Secondary School today.', 'उज्ज्वल भविष्य सुनिश्चित गर्नुहोस्। आजै श्री पब्लिक माध्यमिक विद्यालयमा सामेल हुनुहोस्।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='home' AND section_key='cta_banner' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'page_header', 0, 'About Our School', 'हाम्रो विद्यालयको बारेमा', 'Malangwa-2, Sarlahi', 'मलंगवा-२, सर्लाही', NULL, NULL, NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='page_header' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'intro', 1, 'A Pillar of Community Education', 'सामुदायिक शिक्षाको आधार', NULL, NULL, 'Shree Public Secondary School stands at the heart of Malangwa as a cornerstone of government-led education in Madhesh Province. As a public community school, we are dedicated to providing accessible, high-quality education to over 1,000 students.', 'श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेशमा सरकारी शिक्षाको आधारशिलाको रूपमा मलंगवाको केन्द्रमा खडा छ। एक सार्वजनिक सामुदायिक विद्यालयको रूपमा, हामी १,००० भन्दा बढी विद्यार्थीहरूलाई पहुँचयोग्य, गुणस्तरीय शिक्षा प्रदान गर्न समर्पित छौं।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='intro' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'intro', 2, NULL, NULL, NULL, NULL, 'Our institution offers a comprehensive educational journey from Early Childhood Development (ECD) through Grade 12. We proudly operate as a co-educational day school, fostering an inclusive environment. In our higher secondary levels (+2), we provide specialized streams in Science and Management, equipping our students with the skills necessary for modern professional landscapes. (IEMIS: 190640003)', 'हाम्रो संस्थाले प्रारम्भिक बालविकास (ईसीडी) देखि कक्षा १२ सम्म व्यापक शैक्षिक यात्रा प्रदान गर्दछ। हामी सह-शिक्षा दिवा विद्यालयको रूपमा समावेशी वातावरण प्रवर्द्धन गर्छौं। उच्च माध्यमिक तह (+२) मा हामी विज्ञान र व्यवस्थापनका विशेषीकृत स्ट्रिमहरू प्रदान गर्छौं। (IEMIS: १९०६४०००३)', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='intro' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'value', 1, 'Vision', 'परिकल्पना', NULL, NULL, 'To be a leading center of educational excellence in Madhesh Province, empowering students with knowledge, skills, and values for a global future.', 'मधेश प्रदेशमा शैक्षिक उत्कृष्टताको अग्रणी केन्द्र बन्ने, विद्यार्थीहरूलाई वैश्विक भविष्यका लागि ज्ञान, सीप र मूल्यहरूद्वारा सशक्त बनाउने।', NULL, 'visibility', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='value' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'value', 2, 'Mission', 'लक्ष्य', NULL, NULL, 'Providing accessible, high-quality public education from ECD to Grade 12, fostering an inclusive environment that nurtures intellectual growth and civic responsibility.', 'ईसीडीदेखि कक्षा १२ सम्म पहुँचयोग्य, उच्च गुणस्तरीय सार्वजनिक शिक्षा प्रदान गर्ने, बौद्धिक वृद्धि र नागरिक जिम्मेवारीलाई पोषण गर्ने समावेशी वातावरण निर्माण गर्ने।', NULL, 'school', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='value' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'value', 3, 'Values', 'मूल्यहरू', NULL, NULL, 'Integrity, Inclusivity, Excellence, and Community Trust.', 'इमानदारी, समावेशिता, उत्कृष्टता र सामुदायिक विश्वास।', NULL, 'workspace_premium', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='value' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'timeline', 1, '2003 BS', '२००३ साल', '1947 AD', 'सन् १९४७', 'Establishment of the school as a primary education center.', 'प्राथमिक शिक्षा केन्द्रको रूपमा विद्यालयको स्थापना।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='timeline' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'timeline', 2, '2040 BS', '२०४० साल', NULL, NULL, 'Expansion to secondary level (Grade 10).', 'माध्यमिक तह (कक्षा १०) सम्म विस्तार।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='timeline' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'timeline', 3, '2065 BS', '२०६५ साल', NULL, NULL, 'Introduction of Higher Secondary (+2) programs.', 'उच्च माध्यमिक (+२) कार्यक्रमहरूको सुरुवात।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='timeline' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'timeline', 4, '2080 BS', '२०८० साल', NULL, NULL, 'Modernization with ICT-integrated Smart Classrooms.', 'आईसीटी एकीकृत स्मार्ट कक्षाहरू सहित आधुनिकीकरण।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='timeline' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'facility', 1, 'Science Laboratory', 'विज्ञान प्रयोगशाला', NULL, NULL, 'Well-equipped for Physics, Chemistry, and Biology experiments.', 'भौतिक विज्ञान, रसायन विज्ञान र जीव विज्ञान प्रयोगका लागि सुसज्जित।', 'uploads/gallery/campus/staff-room-interior.jpg', NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='facility' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'facility', 2, 'ICT Lab', 'आईसीटी ल्याब', NULL, NULL, 'Modern computer lab with internet access for smart learning.', 'स्मार्ट लर्निङका लागि इन्टरनेट सहितको आधुनिक कम्प्युटर ल्याब।', 'uploads/gallery/campus/staff-room-computer.jpg', NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='facility' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'facility', 3, 'Library', 'पुस्तकालय', NULL, NULL, 'A collection of academic and reference books for all levels.', 'सबै तहका लागि शैक्षिक र सन्दर्भ पुस्तकहरूको संग्रह।', 'uploads/gallery/campus/headmaster-office.jpg', NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='facility' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'facility', 4, 'Sports Ground', 'खेल मैदान', NULL, NULL, 'Space for athletics, football, and community events.', 'एथलेटिक्स, फुटबल र सामुदायिक कार्यक्रमहरूका लागि ठाउँ।', 'uploads/gallery/campus/courtyard-students-formation.jpg', NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='facility' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'about', 'cta_join', 0, 'Join Our Community', 'हाम्रो समुदायमा सामेल हुनुहोस्', NULL, NULL, 'Explore our academic programs or start the admission process today to become part of Shree Public Secondary School.', 'हाम्रा शैक्षिक कार्यक्रमहरू अन्वेषण गर्नुहोस् वा आजै श्री पब्लिक माध्यमिक विद्यालयको हिस्सा बन्न भर्ना प्रक्रिया सुरु गर्नुहोस्।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='about' AND section_key='cta_join' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 1, 'Where is the school located?', 'विद्यालय कहाँ अवस्थित छ?', NULL, NULL, '<p><strong>Shree Public Secondary School</strong> (श्री पब्लिक माध्यमिक विद्यालय) is in <strong>Malangwa Municipality-2, Sarlahi, Madhesh Province 45800, Nepal</strong>. Plus Code <strong>VH24+22W</strong> (26.8501032 N, 85.555064 E). See <a href="/contact.php">Contact — Map &amp; directions</a> for the embedded map and directions link.</p>', '<p><strong>श्री पब्लिक माध्यमिक विद्यालय</strong> <strong>मलंगवा नगरपालिका-२, सर्लाही, मधेश प्रदेश ४५८००, नेपाल</strong> मा अवस्थित छ। प्लस कोड <strong>VH24+22W</strong> (२६.८५०१०३२ N, ८५.५५५०६४ E)। नक्सा र दिशा-निर्देशका लागि <a href="/contact.php">सम्पर्क — नक्सा र दिशा</a> हेर्नुहोस्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 2, 'What levels does the school teach?', 'विद्यालयले कुन तहसम्म पढाउँछ?', NULL, NULL, '<p>The school covers <strong>ECD through Grade 12</strong> on a single campus — ECD / Nursery, Basic Level (Grades 1–8), Secondary Level (Grades 9–10, SEE) and Higher Secondary (Grades 11–12, NEB). See <a href="/academics.php">Academics</a> for a detailed explanation of each level.</p>', '<p>विद्यालयले <strong>ईसीडीदेखि कक्षा १२ सम्म</strong> एउटै परिसरमा पढाउँछ — ईसीडी/नर्सरी, आधारभूत तह (कक्षा १–८), माध्यमिक तह (कक्षा ९–१०, एसईई) र उच्च माध्यमिक (कक्षा ११–१२, एनईबी)। प्रत्येक तहको विस्तृत विवरणका लागि <a href="/academics.php">शैक्षिक कार्यक्रम</a> हेर्नुहोस्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 3, 'Which +2 programs are available?', 'कुन +२ कार्यक्रमहरू उपलब्ध छन्?', NULL, NULL, '<p>Currently <strong>+2 Science</strong> and <strong>+2 Management</strong> under the National Examinations Board (NEB). Program descriptions are on <a href="/science.php">+2 Science</a> and <a href="/management.php">+2 Management</a>. Exact subject combinations for the current year are confirmed by the school office.</p>', '<p>हाल <strong>+२ विज्ञान</strong> र <strong>+२ व्यवस्थापन</strong> राष्ट्रिय परीक्षा बोर्ड (एनईबी) अन्तर्गत सञ्चालित छन्। कार्यक्रम विवरण <a href="/science.php">+२ विज्ञान</a> र <a href="/management.php">+२ व्यवस्थापन</a> मा हेर्न सकिन्छ। चालु वर्षको विषय संयोजन विद्यालय कार्यालयले पुष्टि गर्दछ।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 4, 'Where are official notices published?', 'आधिकारिक सूचनाहरू कहाँ प्रकाशित हुन्छन्?', NULL, NULL, '<p>All official notices are published on the <a href="/notices.php">Notice Board</a>. Pinned / urgent notices appear first. For admission specifically, use <a href="/notices.php?category=admission">Notice Board — Admission</a>.</p>', '<p>सबै आधिकारिक सूचनाहरू <a href="/notices.php">सूचना पाटी</a> मा प्रकाशित हुन्छन्। पिन गरिएका/जरुरी सूचनाहरू पहिले देखिन्छन्। भर्नाका लागि <a href="/notices.php?category=admission">सूचना पाटी — भर्ना</a> हेर्नुहोस्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 5, 'Where can I download forms and school documents?', 'फारम र विद्यालयका कागजातहरू कहाँ डाउनलोड गर्न सकिन्छ?', NULL, NULL, '<p>In the <a href="/downloads.php">Downloads / Resources centre</a> — categories include Academic Calendar, Exam Routine, Admission Documents, Results, Forms, Policies, Citizen Charter and Publications.</p>', '<p><a href="/downloads.php">डाउनलोड / संसाधन केन्द्र</a> मा — शैक्षिक पात्रो, परीक्षा तालिका, भर्ना कागजात, नतिजा, फारम, नीति, नागरिक वडापत्र र प्रकाशनहरू समावेश छन्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=5);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 6, 'How can I get directions to the school?', 'विद्यालयसम्म कसरी पुग्ने?', NULL, NULL, '<p>Use the embedded map and <strong>Get Directions — VH24+22W</strong> button on the <a href="/contact.php">Contact page</a>, or search Plus Code <strong>VH24+22W</strong> / coordinates <strong>26.8501032, 85.555064</strong> in Google Maps.</p>', '<p><a href="/contact.php">सम्पर्क पृष्ठ</a> मा रहेको नक्सा र <strong>दिशा प्राप्त गर्नुहोस् — VH24+22W</strong> बटन प्रयोग गर्नुहोस्, वा Google Maps मा प्लस कोड <strong>VH24+22W</strong> / निर्देशांक <strong>२६.८५०१०३२, ८५.५५५०६४</strong> खोज्नुहोस्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=6);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 7, 'How do I confirm admission requirements?', 'भर्ना आवश्यकताहरू कसरी पुष्टि गर्ने?', NULL, NULL, '<p>Check the <a href="/notices.php?category=admission">latest admission notice</a> for the grade and year you are applying for, and <a href="/contact.php">contact or visit the school</a> to confirm eligibility, seats, fees and deadline. The general guidance on the <a href="/admissions.php">Admissions page</a> is not a substitute for the official notice.</p>', '<p>तपाईंले आवेदन दिने कक्षा र वर्षका लागि <a href="/notices.php?category=admission">नवीनतम भर्ना सूचना</a> जाँच गर्नुहोस् र योग्यता, सिट, शुल्क र अन्तिम मिति पुष्टि गर्न <a href="/contact.php">विद्यालयमा सम्पर्क गर्नुहोस् वा भ्रमण गर्नुहोस्</a>। <a href="/admissions.php">भर्ना पृष्ठ</a> मा रहेको सामान्य मार्गदर्शन आधिकारिक सूचनाको विकल्प होइन।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=7);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 8, 'Are examination results available online?', 'परीक्षा नतिजा अनलाइन उपलब्ध छन्?', NULL, NULL, '<p>Published online results appear in <a href="/results.php">Results</a> (search by symbol / roll number) and as downloadable PDFs in <a href="/downloads.php">Downloads</a>. Board results for Grade 12 are also verifiable via <a href="https://neb.gov.np" target="_blank" rel="noopener">neb.gov.np</a>.</p>', '<p>प्रकाशित अनलाइन नतिजाहरू <a href="/results.php">नतिजा</a> (सिम्बोल नम्बरबाट खोज्नुहोस्) र <a href="/downloads.php">डाउनलोड</a> मा PDF को रूपमा उपलब्ध हुन्छन्। कक्षा १२ को बोर्ड नतिजा <a href="https://neb.gov.np" target="_blank" rel="noopener">neb.gov.np</a> मा पनि प्रमाणित गर्न सकिन्छ।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=8);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'faq', 'faq_item', 9, 'What does IEMIS 190640003 mean?', 'IEMIS १९०६४०००३ को अर्थ के हो?', NULL, NULL, '<p>It is the <strong>Integrated Educational Management Information System</strong> code identifying Shree Public Secondary School as a public institution within Nepal''s education data system (CEHRD).</p>', '<p>यो <strong>एकीकृत शैक्षिक व्यवस्थापन सूचना प्रणाली</strong> कोड हो जसले श्री पब्लिक माध्यमिक विद्यालयलाई नेपालको शिक्षा तथ्यांक प्रणाली (CEHRD) भित्र सार्वजनिक संस्थाको रूपमा पहिचान गर्दछ।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='faq' AND section_key='faq_item' AND sort_order=9);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 1, 'Ministry of Education, Science & Technology', 'शिक्षा, विज्ञान तथा प्रविधि मन्त्रालय', NULL, NULL, 'Policy, national education information', 'नीति, राष्ट्रिय शिक्षा जानकारी', NULL, 'account_balance', 'https://moest.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 2, 'CEHRD — Center for Education and Human Resource Development', 'सीईएचआरडी — शिक्षा तथा मानव स्रोत विकास केन्द्र', NULL, NULL, 'IEMIS, school education administration', 'IEMIS, विद्यालय शिक्षा प्रशासन', NULL, 'school', 'https://cehrd.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 3, 'National Examinations Board (NEB)', 'राष्ट्रिय परीक्षा बोर्ड (एनईबी)', NULL, NULL, 'Grade 11–12 registration, examinations, results', 'कक्षा ११–१२ दर्ता, परीक्षा, नतिजा', NULL, 'assignment', 'https://neb.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 4, 'Curriculum Development Centre (CDC)', 'पाठ्यक्रम विकास केन्द्र (सीडीसी)', NULL, NULL, 'Curriculum, textbooks, learning materials', 'पाठ्यक्रम, पाठ्यपुस्तक, सिकाइ सामग्री', NULL, 'menu_book', 'https://cdc.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 5, 'SEE', 'एसईई', NULL, NULL, 'Secondary Education Examination', 'माध्यमिक शिक्षा परीक्षा', NULL, 'verified', 'https://see.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=5);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 6, 'Malangwa Municipality', 'मलंगवा नगरपालिका', NULL, NULL, 'Local government — ward, municipal notices', 'स्थानीय सरकार — वडा, नगरपालिका सूचनाहरू', NULL, 'location_city', 'https://malangwamun.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=6);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 7, 'Madhesh Province', 'मधेश प्रदेश', NULL, NULL, 'Provincial government', 'प्रदेश सरकार', NULL, 'map', 'https://madhesh.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=7);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'links', 'link', 8, 'National Education-related Portals', 'राष्ट्रिय शिक्षा सम्बन्धी पोर्टलहरू', NULL, NULL, 'Additional references — verify before use', 'थप सन्दर्भहरू — प्रयोग गर्नु अघि प्रमाणित गर्नुहोस्', NULL, 'language', 'https://www.nea.gov.np') t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='links' AND section_key='link' AND sort_order=8);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'science', 'intro', 0, 'What the Science stream is for', 'विज्ञान स्ट्रिम केका लागि हो', NULL, NULL, '<p>The <strong>+2 Science</strong> program at Shree Public Secondary School is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong>. It is one of two NEB streams currently offered at the school — the other being <strong>+2 Management</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to eligibility criteria and available seats as confirmed each year by the school office.</p><p>Study extends over two academic years with internal assessments and board examinations as required by NEB.</p>', '<p><strong>+२ विज्ञान</strong> कार्यक्रम श्री पब्लिक माध्यमिक विद्यालयमा <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो। यो विद्यालयमा हाल सञ्चालित दुई एनईबी स्ट्रिमहरूमध्ये एक हो — अर्को <strong>+२ व्यवस्थापन</strong> हो।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p><p>अध्ययन दुई शैक्षिक वर्षसम्म चल्छ र एनईबीको आवश्यकता अनुसार आन्तरिक मूल्याङ्कन र बोर्ड परीक्षाहरू हुन्छन्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='science' AND section_key='intro' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'science', 'highlight', 1, 'Scientific reasoning', 'वैज्ञानिक तर्क', NULL, NULL, 'Observation, experimentation and interpreting evidence — building habits of inquiry and careful measurement.', 'अवलोकन, प्रयोग र प्रमाणको व्याख्या — जिज्ञासा र सावधानीपूर्वक मापनको बानी विकास।', NULL, 'biotech', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='science' AND section_key='highlight' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'science', 'highlight', 2, 'Mathematics', 'गणित', NULL, NULL, 'Quantitative reasoning, algebraic and analytical thinking used across science and technology studies.', 'विज्ञान र प्रविधि अध्ययनमा प्रयोग हुने परिमाणात्मक तर्क, बीजगणितीय र विश्लेषणात्मक सोच।', NULL, 'calculate', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='science' AND section_key='highlight' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'science', 'highlight', 3, 'Analytical thinking', 'विश्लेषणात्मक सोच', NULL, NULL, 'Breaking problems into parts, evaluating data and forming reasoned conclusions.', 'समस्यालाई भागमा विभाजन गर्ने, तथ्याङ्क मूल्याङ्कन गर्ने र तर्कसंगत निष्कर्ष निकाल्ने।', NULL, 'psychology', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='science' AND section_key='highlight' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'science', 'highlight', 4, 'Practical understanding & problem solving', 'व्यावहारिक बुझाइ र समस्या समाधान', NULL, NULL, 'Applying concepts to real questions — where lab access and practical work are available, students learn through demonstration and supervised activity.', 'अवधारणाहरूलाई वास्तविक प्रश्नहरूमा लागू गर्ने — प्रयोगशाला र व्यावहारिक कार्य उपलब्ध हुँदा विद्यार्थीहरूले प्रदर्शन र पर्यवेक्षण गतिविधि मार्फत सिक्छन्।', NULL, 'science', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='science' AND section_key='highlight' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'management', 'intro', 0, 'What the Management stream is for', 'व्यवस्थापन स्ट्रिम केका लागि हो', NULL, NULL, '<p>The <strong>+2 Management</strong> program is a two-year higher secondary course (Grades 11 and 12) under the <strong>National Examinations Board (NEB)</strong> — the second NEB stream currently operated at Shree Public alongside <strong>+2 Science</strong>.</p><p>Students who have completed Grade 10 (SEE) from Shree Public or any other recognised institution may apply to Grade 11 in this stream, subject to the eligibility criteria and seats confirmed each year by the school office.</p>', '<p><strong>+२ व्यवस्थापन</strong> कार्यक्रम <strong>राष्ट्रिय परीक्षा बोर्ड (एनईबी)</strong> अन्तर्गतको दुई वर्षे उच्च माध्यमिक पाठ्यक्रम (कक्षा ११ र १२) हो — श्री पब्लिकमा <strong>+२ विज्ञान</strong> सँगै सञ्चालित दोस्रो एनईबी स्ट्रिम।</p><p>श्री पब्लिक वा अन्य मान्यता प्राप्त संस्थाबाट कक्षा १० (एसईई) पूरा गरेका विद्यार्थीहरूले यस स्ट्रिममा कक्षा ११ मा आवेदन दिन सक्छन्।</p>', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='management' AND section_key='intro' AND sort_order=0);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'management', 'highlight', 1, 'Business understanding', 'व्यापार बुझाइ', NULL, NULL, 'How businesses are organised, how they operate and how decisions are made — introduced at higher-secondary level.', 'व्यवसायहरू कसरी संगठित हुन्छन्, कसरी सञ्चालन हुन्छन् र निर्णयहरू कसरी लिइन्छ — उच्च माध्यमिक तहमा परिचय गराइन्छ।', NULL, 'business_center', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='management' AND section_key='highlight' AND sort_order=1);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'management', 'highlight', 2, 'Accounting concepts', 'लेखा अवधारणाहरू', NULL, NULL, 'Recording, classifying and interpreting financial information — the language of business records.', 'वित्तीय जानकारीको रेकर्डिङ, वर्गीकरण र व्याख्या — व्यापार रेकर्डको भाषा।', NULL, 'receipt_long', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='management' AND section_key='highlight' AND sort_order=2);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'management', 'highlight', 3, 'Economics', 'अर्थशास्त्र', NULL, NULL, 'Scarcity, markets, production and trade — basic economic thinking applied to everyday and business contexts.', 'अभाव, बजार, उत्पादन र व्यापार — दैनिक र व्यापार सन्दर्भमा लागू गरिने आधारभूत आर्थिक सोच।', NULL, 'trending_up', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='management' AND section_key='highlight' AND sort_order=3);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'management', 'highlight', 4, 'Organisational thinking, communication & entrepreneurship', 'संगठनात्मक सोच, सञ्चार र उद्यमशीलता', NULL, NULL, 'Planning, organising, working with others, written and spoken communication, and an introduction to starting and running an enterprise.', 'योजना, संगठन, अरूसँग मिलेर काम गर्ने, लिखित र मौखिक सञ्चार, र उद्यम सुरु गर्ने र सञ्चालन गर्ने परिचय।', NULL, 'groups', NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='management' AND section_key='highlight' AND sort_order=4);
INSERT INTO content_blocks (page_slug,section_key,sort_order,title_en,title_np,subtitle_en,subtitle_np,body_en,body_np,image_url,icon,link_url)
SELECT * FROM (SELECT 'publications', 'intro', 0, 'Official publications for transparency', 'पारदर्शिताका लागि आधिकारिक प्रकाशनहरू', NULL, NULL, 'School annual reports, financial summaries (as approved for disclosure), School Improvement Plan (SIP) summaries, prospectus and similar institutional publications. Documents are shown with title, category, publish date and file type.', 'विद्यालय वार्षिक प्रतिवेदन, वित्तीय सारांश (प्रकाशनका लागि स्वीकृत), विद्यालय सुधार योजना (SIP) सारांश, prospectus र यस्तै संस्थागत प्रकाशनहरू। कागजातहरू शीर्षक, श्रेणी, प्रकाशन मिति र फाइल प्रकार सहित देखाइन्छ।', NULL, NULL, NULL) t
WHERE NOT EXISTS (SELECT 1 FROM content_blocks WHERE page_slug='publications' AND section_key='intro' AND sort_order=0);
