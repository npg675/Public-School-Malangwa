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
('principal_message_np','हाम्रो लक्ष्य सबै पृष्ठभूमिका विद्यार्थीहरूलाई जिम्मेवार नागरिक र भविष्यका नेता बन्न सशक्त बनाउँदै समावेशी, गुणस्तरीय शिक्षा प्रदान गर्नु हो।')
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
INSERT IGNORE INTO pages (slug, title_en, title_np, content_en, content_np, meta_description, status) VALUES
('about','About Our School','हाम्रो विद्यालयबारे','<h2>Welcome to Shree Public Secondary School</h2><p>Shree Public Secondary School is a government community school located in Malangwa-2, Sarlahi, Madhesh Province, Nepal. The school provides quality education from Early Childhood Development (ECD) through Grade 12, including +2 programs in Science and Management affiliated with the National Examination Board (NEB).</p><h3>Our Mission</h3><p>To provide accessible, equitable and quality education to every child of our community regardless of background.</p><h3>Our Vision</h3><p>To be a model community school in Madhesh Province known for academic excellence, discipline and social responsibility.</p>','<h2>श्री पब्लिक माध्यमिक विद्यालयमा स्वागत छ</h2><p>श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेश, सर्लाही जिल्लाको मलंगवा–२ मा अवस्थित एक सरकारी सामुदायिक विद्यालय हो।</p>','Shree Public Secondary School — public community school in Malangwa-2, Sarlahi. ECD to Grade 12, +2 Science & Management (NEB). IEMIS 190640003.','published'),
('admissions','Admissions','भर्ना','<h2>Admission Open — ECD to Grade 12 &amp; +2</h2><p>Parents and guardians may visit the school office during office hours (Sunday–Friday, 10:00 AM – 4:00 PM) to collect and submit the application form.</p><h3>Documents Required</h3><ul><li>Birth certificate (copy)</li><li>Transfer certificate (if transferring)</li><li>Previous marksheet/grade sheet</li><li>Passport-size photographs (2 copies)</li><li>Citizenship copy (for +2 applicants)</li></ul>','<h2>भर्ना खुला छ</h2><p>अभिभावकहरूले कार्यालय समयमा विद्यालय कार्यालयमा सम्पर्क गर्नुहोला।</p>','Admission information for Shree Public Secondary School Malangwa-2 — ECD to Grade 12, +2 Science & Management (NEB).','published'),
('citizen-charter','Citizen Charter','नागरिक वडापत्र','<h2>Citizen Charter (नागरिक वडापत्र)</h2><p>This charter outlines the services provided by the school, required documents and service delivery time commitments.</p><ul><li>Admission enrollment — same day during office hours</li><li>Transfer certificate — within 2 working days</li><li>Character certificate — within 2 working days</li><li>Marksheet verification — within 3 working days</li></ul>','<h2>नागरिक वडापत्र</h2><p>यो वडापत्रमा विद्यालयले प्रदान गर्ने सेवाहरू र सेवा प्रदान गर्ने समय उल्लेख छ।</p>','Citizen Charter of Shree Public Secondary School, Malangwa-2 — services, documents, time and fees.','published'),
('faq','Frequently Asked Questions','जिज्ञासा','<h2>Frequently Asked Questions</h2><h3>Where is the school located?</h3><p>VH24+22W, Malangwa-2, Sarlahi, Madhesh Province, Nepal (postal code 45800).</p><h3>Which programs does the school offer?</h3><p>ECD through Grade 12, plus +2 Science and +2 Management streams affiliated with NEB.</p><h3>What are the office hours?</h3><p>Sunday to Friday, 10:00 AM to 4:00 PM. Closed on Saturday.</p>','<h2>जिज्ञासाहरू</h2><h3>विद्यालय कहाँ अवस्थित छ?</h3><p>मलंगवा–२, सर्लाही, मधेश प्रदेश।</p>','Frequently asked questions about Shree Public Secondary School, Malangwa-2.','published'),
('publications','Publications','प्रकाशनहरू','<h2>Publications &amp; Reports</h2><p>Official publications of the school are made available for public transparency: annual reports, school improvement plans and financial summaries. Printed copies are available at the school office.</p>','<h2>प्रकाशनहरू</h2><p>विद्यालयका आधिकारिक प्रकाशनहरू सार्वजनिक पारदर्शिताका लागि उपलब्ध गराइएको छ।</p>','Publications from Shree Public Secondary School — annual reports, prospectus, transparency documents.','published');
