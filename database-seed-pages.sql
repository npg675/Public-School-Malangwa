-- ============================================================
-- Seed data for admin > Pages module
-- Shree Public Secondary School — Malangwa-2, Sarlahi
-- Import via phpMyAdmin (run AFTER database.sql)
-- Safe to re-run: INSERT IGNORE on unique slug
-- ============================================================

INSERT IGNORE INTO pages (slug, title_en, title_np, content_en, content_np, meta_description, status) VALUES
('about',
 'About Our School',
 'हाम्रो विद्यालयबारे',
 '<h2>Welcome to Shree Public Secondary School</h2><p>Shree Public Secondary School is a government community school located in Malangwa-2, Sarlahi, Madhesh Province, Nepal. Established to serve the local community, the school provides quality education from Early Childhood Development (ECD) through Grade 12, including +2 programs in Science and Management affiliated with the National Examination Board (NEB).</p><h3>Our Mission</h3><p>To provide accessible, equitable and quality education to every child of our community regardless of background.</p><h3>Our Vision</h3><p>To be a model community school in Madhesh Province known for academic excellence, discipline and social responsibility.</p><h3>School Information</h3><ul><li>IEMIS: 190640003</li><li>Location: Malangwa-2, Sarlahi (VH24+22W)</li><li>Levels: ECD to Grade 12</li><li>Streams: +2 Science & +2 Management (NEB)</li></ul>',
 '<h2>श्री पब्लिक माध्यमिक विद्यालयमा स्वागत छ</h2><p>श्री पब्लिक माध्यमिक विद्यालय मधेश प्रदेश, सर्लाही जिल्लाको मलंगवा–२ मा अवस्थित एक सरकारी सामुदायिक विद्यालय हो। यस विद्यालयले बालविकास (ECD) देखि कक्षा १२ सम्म तथा +२ विज्ञान र व्यवस्थापन (राष्ट्रिय परीक्षा बोर्ड) सम्मको गुणस्तरीय शिक्षा प्रदान गर्दछ।</p><h3>हाम्रो लक्ष्य</h3><p>समुदायका हरेक बालबालिकालाई पहुँचयोग्य, समान र गुणस्तरीय शिक्षा प्रदान गर्नु।</p>',
 'Shree Public Secondary School is a public community school in Malangwa-2, Sarlahi, serving ECD through Grade 12 with +2 Science & Management (NEB). IEMIS 190640003.',
 'published'),

('admissions',
 'Admissions',
 'भर्ना',
 '<h2>Admission Open — ECD to Grade 12 & +2</h2><p>Admissions are open for the new academic session. Parents and guardians may visit the school office during office hours (Sunday–Friday, 10:00 AM – 4:00 PM) to collect and submit the application form.</p><h3>Admission Process</h3><ol><li>Visit the school office and fill the application form</li><li>Submit required documents</li><li>Entrance/interaction (for applicable levels)</li><li>Enrollment confirmation and class assignment</li></ol><h3>Documents Required</h3><ul><li>Birth certificate (copy)</li><li>Transfer certificate (if transferring)</li><li>Previous marksheet/grade sheet</li><li>Passport-size photographs (2 copies)</li><li>Citizenship copy (for +2 applicants)</li></ul><h3>+2 Eligibility</h3><p>Students must have completed SEE (Grade 10) with the minimum GPA required by NEB for Science or Management streams.</p><p>For inquiries, call the school office or use the admission inquiry form on the Admissions page.</p>',
 '<h2>भर्ना खुला छ — बालविकास देखि कक्षा १२ र +२ सम्म</h2><p>नयाँ शैक्षिक सत्रको लागि भर्ना खुला छ। अभिभावकहरूले कार्यालय समयमा (आइतबार–शुक्रबार, बिहान १०:०० – साँझ ४:००) विद्यालय कार्यालयमा सम्पर्क गर्नुहोला।</p><h3>आवश्यक कागजातहरू</h3><ul><li>जन्मदर्ता प्रमाणपत्र (प्रतिलिपि)</li><li>सराइ प्रमाणपत्र</li><li>अघिल्लो उत्तीर्णपत्र</li><li>पासपोर्ट साइज फोटो (२ कपी)</li><li>+२ भर्नाको लागि नागरिकताको प्रतिलिपि</li></ul>',
 'Admission information for Shree Public Secondary School Malangwa-2 — ECD to Grade 12, +2 Science & Management (NEB). Process, documents and eligibility.',
 'published'),

('citizen-charter',
 'Citizen Charter',
 'नागरिक वडापत्र',
 '<h2>Citizen Charter (नागरिक वडापत्र)</h2><p>This charter outlines the services provided by Shree Public Secondary School, required documents, responsible officers and service delivery time commitments.</p><table border="1" cellpadding="6"><thead><tr><th>Service</th><th>Required Documents</th><th>Time</th><th>Fee</th></tr></thead><tbody><tr><td>Admission enrollment</td><td>Birth certificate, transfer certificate, marksheet, photos</td><td>Same day (office hours)</td><td>As per government policy</td></tr><tr><td>Transfer certificate</td><td>Written application from guardian, clearance of dues</td><td>Within 2 working days</td><td>Free</td></tr><tr><td>Character certificate</td><td>Written application</td><td>Within 2 working days</td><td>Free</td></tr><tr><td>Marksheet/verification</td><td>Application with exam details</td><td>Within 3 working days</td><td>Free</td></tr><tr><td>Scholarship application</td><td>As per notice requirements</td><td>As per notice deadline</td><td>Free</td></tr><tr><td>Grievance filing</td><td>Written or verbal complaint</td><td>Acknowledged same day</td><td>Free</td></tr></tbody></table><h3>Grievance Redress</h3><p>Complaints may be filed at the school office. Unresolved grievances may be escalated to the School Management Committee, then to Malangwa Municipality.</p>',
 '<h2>नागरिक वडापत्र</h2><p>यो वडापत्रमा विद्यालयले प्रदान गर्ने सेवाहरू, आवश्यक कागजातहरू, जिम्मेवार अधिकृत र सेवा प्रदान गर्ने समयबारे उल्लेख छ।</p>',
 'Citizen Charter of Shree Public Secondary School, Malangwa-2 — services, required documents, responsible officer, time and fees.',
 'published'),

('faq',
 'Frequently Asked Questions',
 'जिज्ञासा',
 '<h2>Frequently Asked Questions</h2><h3>Where is the school located?</h3><p>The school is located at VH24+22W, Malangwa-2, Sarlahi, Madhesh Province, Nepal (postal code 45800).</p><h3>Which programs does the school offer?</h3><p>ECD through Grade 12, plus +2 Science and +2 Management streams affiliated with NEB.</p><h3>Is education free?</h3><p>As a government community school, basic education (Grades 1–8) is free as per government policy. Minimal charges may apply as approved by the School Management Committee.</p><h3>How can I check exam results?</h3><p>Published results are available on the Results page and on the school notice board. NEB board results can also be verified online.</p><h3>What are the office hours?</h3><p>Sunday to Friday, 10:00 AM to 4:00 PM. Closed on Saturday.</p>',
 '<h2>जिज्ञासाहरू</h2><h3>विद्यालय कहाँ अवस्थित छ?</h3><p>विद्यालय मलंगवा–२, सर्लाही, मधेश प्रदेशमा अवस्थित छ।</p><h3>कुन कुन कार्यक्रम उपलब्ध छ?</h3><p>बालविकास देखि कक्षा १२ सम्म तथा +२ विज्ञान र व्यवस्थापन।</p>',
 'Frequently asked questions about Shree Public Secondary School, Malangwa-2 — location, programs, admission, results and office hours.',
 'published'),

('publications',
 'Publications',
 'प्रकाशनहरू',
 '<h2>Publications & Reports</h2><p>Official publications of Shree Public Secondary School are made available for public transparency. These include annual reports, school improvement plans and financial summaries.</p><ul><li>Annual Report 2081</li><li>School Improvement Plan (SSIP)</li><li>Financial Transparency Summary</li><li>School Prospectus</li></ul><p>Printed copies are available at the school office.</p>',
 '<h2>प्रकाशनहरू</h2><p>श्री पब्लिक माध्यमिक विद्यालयका आधिकारिक प्रकाशनहरू सार्वजनिक पारदर्शिताका लागि उपलब्ध गराइएको छ।</p>',
 'Publications from Shree Public Secondary School — annual reports, prospectus, school improvement plans and transparency documents.',
 'published');
-- INSERT IGNORE skips rows whose slug already exists, so re-running is safe.
