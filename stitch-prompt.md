# Stitch Design Prompts — Shree Public Secondary School Website

Complete set of prompts for designing the full website in **Google Stitch**.
Design one screen at a time, pasting one prompt below per screen.

---

## How to use

1. Start every new Stitch project by running **Prompt 0 (Global Theme)** once to lock the design system.
2. Then generate screens in order. Each prompt is self-contained and repeats key context so results stay consistent.
3. After generating, keep the same theme when iterating ("make the hero taller", "use 3 stat cards instead of 4", etc.).

---

## PROMPT 0 — Global Design System (run this first)

```
Design system for a Nepali government community school website called
"Shree Public Secondary School" (श्री पब्लिक माध्यमिक विद्यालय),
located in Malangwa-2, Sarlahi, Madhesh Province, Nepal. IEMIS 190640003.

Style: trustworthy civic-institutional, clean, modern, accessible,
government-school credibility with warmth. NOT corporate SaaS.

Colors:
- Primary deep navy: #092A4D (sidebar/header), #123B6D (headings, buttons)
- Darkest navy for masthead: #001E40
- Gold accent: #D29A32 and #FFCC00 (used sparingly for CTAs, active states)
- Alert red: #C1272D (urgent notices only)
- Backgrounds: white #FFFFFF and light gray-blue #F7F9FC
- Borders: #E2E8F0
- Text: #172033 headings, #667085 secondary

Typography:
- English: Inter (body), Hanken Grotesk (display/headings)
- Nepali: Noto Sans Devanagari (site is bilingual EN ⇄ नेपाली)

Components vocabulary: rounded corners (8–12px), soft shadows
(rgba(9,42,77,.06)), pill-shaped status tags, clear focus rings,
generous whitespace, mobile-first responsive layout.

Every public page shares: a slim top utility bar (dark navy) showing a
green-dot "Government / Community School" badge, location "Malangwa-2,
Sarlahi · Madhesh Province 45800", phone number and an EN | नेपाली language
toggle; below it a main header with circular school logo, bilingual school
name, subtitle line "Malangwa-2, Sarlahi • Community School • IEMIS 190640003",
horizontal nav (Home, About, Academics, Admissions, Notice Board, Results,
Resources ▾, Gallery, Contact) and a gold "Admission Inquiry" button;
and a dark navy footer with contact info, quick links, resources links,
map embed and copyright.
```

---
---

# PART A — PUBLIC PAGES

## A1. Home (`index.php`)

```
Homepage for Shree Public Secondary School, a government community school
in Malangwa-2, Sarlahi, Nepal (ECD to Grade 12, +2 Science & Management under NEB).
Use the shared utility bar + main header + footer from the design system.

Sections top to bottom:
1. Urgent/latest notice bar directly under the header: red-tinted strip with
   bell icon, label "Latest Notice", pinned notice title, date, and
   "View Notice →" link.
2. Hero: large photo of rural Nepali school students in blue uniforms,
   headline "Quality Public Education in Malangwa", subtext mentioning
   ECD through Grade 12 and +2 Science & Management (NEB), two buttons:
   primary "Apply for Admission" and outline "Explore Programs".
   Overlay stats row on hero bottom: Students, Teachers, Since year,
   Pass rate.
3. Quick access card row: 4 icon cards linking to Notices, Results,
   Downloads, Academic Calendar.
4. "Why choose us" section: 4 feature cards with icons — Free & quality
   education, Qualified teachers, Science & Management (+2), Community trust.
5. Latest Notices section: list of 6 notice rows with category tag
   (Exam, Admission, Holiday, Scholarship, Procurement), title, Nepali date,
   pin icon for pinned ones; "View all notices →" link.
6. News & Events side-by-side: 3 news cards with thumbnails and dates,
   plus upcoming events list with calendar-date badges.
7. Programs band: three program tiles — Basic Level (ECD–8), Secondary
   (9–10 SEE), +2 Science & Management (NEB).
8. Gallery preview: masonry grid of 8 campus photos, "View gallery →".
9. Head teacher welcome quote strip with avatar.
10. CTA banner: navy background, "Admissions open for the new session",
    gold button "Start Admission Inquiry", phone number beside it.
Mobile: hamburger menu drawer version included.
```

## A2. About (`about.php`)

```
About page for Shree Public Secondary School, Malangwa-2, Sarlahi.
Shared header/footer. Breadcrumb "Home > About".

Sections:
1. Page hero band (navy gradient) with title "About Our School" and short
   intro paragraph.
2. Two-column intro: left — history and mission text describing a public
   community school serving ECD through Grade 12 in Madhesh Province;
   right — photo of the school building.
3. Facts strip: established year, students enrolled, teaching staff,
   IEMIS code 190640003 as 4 stat blocks.
4. Mission, Vision, Values as three cards with icons.
5. "Our Programs at a glance" mini timeline: ECD → Basic (1–8) →
   Secondary (9–10) → +2 Science & Management.
6. School management committee mention with link to Management page.
7. Photo strip of facilities: classrooms, science lab, library, playground.
```

## A3. Academics (`academics.php`)

```
Academics overview page for Shree Public Secondary School.
Breadcrumb "Home > Academics". Shared header/footer.

Sections:
1. Hero band: "Academics — ECD to Grade 12", subtitle "+2 Science &
   Management affiliated to NEB (National Examination Board)".
2. Level tabs or segmented control: Early Childhood (ECD), Basic Level
   (Grades 1–8), Secondary (Grades 9–10, SEE), Ten Plus Two (+2).
3. Under each level: subjects taught listed as chips, class sizes,
   medium of instruction note (Nepali/English).
4. Two prominent program cards for +2 Science and +2 Management with
   photos, "Learn more →" links to their detail pages.
5. Assessment & exams explainer card: terminal exams, SEE prep, NEB
   board exams.
6. Academic calendar teaser with download button (PDF).
7. Daily routine table: assembly, periods, break, dismissal times.
```

## A4. +2 Science program (`science.php`)

```
Program detail page: "+2 Science (NEB)" at Shree Public Secondary School.
Breadcrumb "Home > Academics > +2 Science".

Sections:
1. Compact hero with program badge, title, NEB affiliation note,
   "Admission Inquiry" gold button.
2. Program overview paragraphs: physics, chemistry, biology/math focus,
   lab-based learning, who should consider it.
3. Subject grid: Compulsory English, Physics, Chemistry, Biology/Math,
   Nepali — each as a card with short description.
4. Learning outcomes checklist with check icons.
5. Future pathways section: MBBS, BE, BSc, agriculture, nursing — shown
   as pathway arrows/chips.
6. Lab facilities photo pair.
7. Sidebar card: eligibility, shift (morning/day), seats, fee note
   "affordable public rates", apply CTA.
```

## A5. +2 Management program (`management.php`)

```
Program detail page: "+2 Management (NEB)" at Shree Public Secondary
School. Same layout pattern as the Science page.

Sections:
1. Hero with program badge and title.
2. Overview: accounting, economics, business studies, hotel management
   option, computer basics.
3. Subject grid cards: English, Accountancy, Economics, Business Studies,
   Hotel Management, Computer.
4. Skills gained checklist: bookkeeping, communication, entrepreneurship.
5. Career pathways chips: BBA, BBS, CA, banking, retail, hospitality.
6. Sidebar eligibility/seats/apply card.
```

## A6. Academic Calendar (`academic-calendar.php`)

```
Academic Calendar page (Bikram Sambat 2082) for Shree Public Secondary
School. Breadcrumb "Home > Resources > Academic Calendar".

Sections:
1. Hero band with title "Academic Calendar 2082" and a gold
   "Download PDF" button with download icon.
2. Three term cards: First Term, Second Term, Third Term — each with
   start/end dates in BS, exam weeks highlighted.
3. Month-by-month table: month, key activities (exams, holidays,
   parents day, sports week), status tags (Upcoming/Done).
4. Holidays & observances list with calendar icons.
5. Note box: dates may change; follow the Notice Board for updates.
```

## A7. Admissions (`admissions.php`)

```
Admissions page for Shree Public Secondary School, Malangwa-2.
Breadcrumb "Home > Admissions". This is the conversion page.

Sections:
1. Hero: "Admissions Open — ECD to Grade 12 & +2", supporting line,
   scroll cue to inquiry form.
2. Step process: 4 numbered steps — Visit school office, Fill application,
   Submit documents, Enrollment confirmed — as horizontal stepper.
3. Documents required checklist card: birth certificate, transfer
   certificate, marksheet, photos, citizenship (for +2).
4. Level-wise admission info accordion: ECD, Basic, Secondary, +2
   Science/Management (eligibility: SEE GPA requirement).
5. Fee transparency note: free basic education per government policy;
   minimal charges listed honestly.
6. Large inquiry form card: Full name, Phone, Email (optional),
   Grade applying for (select), Message, submit button "Submit Inquiry".
   Beside it: office hours card and phone/WhatsApp contact card.
7. FAQ teasers linking to FAQ page.
```

## A8. Notice Board (`notices.php`)

```
Notice Board listing page — official notices of Shree Public Secondary
School. Breadcrumb "Home > Notice Board". High-information density page.

Sections:
1. Hero band: "Notice Board" with subtitle "Official notices, exam
   routines, admission updates, scholarships, holidays".
2. Filter toolbar: search input, category dropdown (All, Exam, Admission,
   Scholarship, Holiday, Event, Procurement), year dropdown, Apply button.
3. Notice list rows (table-like cards): each row has category color tag,
   bold title (bilingual where relevant), published date, pinned 📌 marker
   for important ones, "View →" link. Show 15 rows with pagination
   numbered 1 2 3 … at bottom.
4. Sidebar: "Quick categories" links, "Downloads" shortcuts, contact box.
5. Empty state example: friendly "No notices found" illustration state.
```

## A9. Notice Detail (`notice.php`)

```
Single notice detail page template. Breadcrumb "Home > Notice Board >
[Notice title]".

Layout:
1. Article header: category tag, H1 notice title, meta row with
   publish date, reference number, views count.
2. Body: clean readable typography column (max-width 720px) with
   headings, paragraphs, bullet lists; optional embedded PDF viewer card
   with "Download PDF" button; signature block "— Principal, Shree Public
   Secondary School".
3. Sticky right sidebar on desktop: notice metadata card (date,
   category, ref no), related downloads card, share buttons
   (Facebook, WhatsApp, copy link).
4. Bottom: "Other recent notices" 3-card row.
5. Print-friendly article styling.
```

## A10. News (`news.php`)

```
News page — school news & updates (distinct from official notices).
Breadcrumb "Home > More > News".

Sections:
1. Hero band: "News & Updates".
2. Featured news card: large image left, headline, excerpt, date, author
   role on right.
3. Grid of 9 news cards (3×3): thumbnail, category chip (Academic,
   Sports, Cultural, Community), title, 2-line excerpt, date.
4. Load more button.
5. Card hover: subtle lift + shadow.
```

## A11. Events (`events.php`)

```
Events page — upcoming school events. Breadcrumb "Home > More > Events".

Sections:
1. Hero: "School Events".
2. Upcoming events list: each event row has a square date badge
   (day big, month small), title, venue with pin icon, time with clock
   icon, short description, category tag.
3. Past events collapsed section with muted styling.
4. Sidebar: mini month calendar widget, "Subscribe via Notice Board" card.
```

## A12. Results (`results.php`)

```
Examination results page. Breadcrumb "Home > Academics > Results".

Sections:
1. Hero: "Published Examination Results" with verification guidance
   subtitle.
2. Result finder card (prominent): selects for Exam type (Terminal,
   SEE Practice, Grade 11, Grade 12 NEB), Year, Class/Section, symbol
   number input, blue "View Result" button.
3. Published result sheets table: exam name, class, published date,
   PDF download button per row.
4. How to verify grades info-steps card explaining NEB online verification
   with external link.
5. Trust note: results are also posted physically on school notice board.
```

## A13. Gallery (`gallery.php`)

```
Photo gallery page. Breadcrumb "Home > Gallery".

Sections:
1. Hero: "Life at Our School" with camera icon.
2. Album filter chips: All, Campus, Classrooms, Science Lab, Sports,
   Cultural Programs, Community, Assembly.
3. Masonry-style album grid: album cover images of varied heights,
   overlay gradient bottom with album title and photo count badge.
4. Lightbox modal example open over the grid: large photo, caption,
   prev/next arrows, close X, thumbnail strip below.
5. "Photos are authentic from school programs" trust microcopy.
```

## A14. Downloads (`downloads.php`)

```
Downloads centre page. Breadcrumb "Home > Resources > Downloads".

Sections:
1. Hero: "Download Centre" subtitle "Forms, calendars, routines,
   policies and publications".
2. Category filter pills: All, Forms, Exam Routines, Results, Calendar,
   Policies, Citizen Charter, Publications, Scholarships.
3. File list rows: file-type icon (PDF red / DOCX blue / XLSX green),
   title, category tag, file size, updated date, download button.
4. Sort dropdown (Newest, A–Z) above list.
5. Pagination. Empty state variant.
```

## A15. Publications (`publications.php`)

```
Publications page — official documents & reports.
Breadcrumb "Home > Resources > Publications".

Sections:
1. Hero: "Publications & Reports".
2. Publication cards grid (2 columns): each card = document cover
   thumbnail, title (Annual Report 2081, School Improvement Plan,
   Prospectus, Financial Transparency Report), description line,
   year tag, "Download PDF" outline button.
3. Transparency statement strip about public accountability of a
   community school.
```

## A16. Scholarships (`scholarships.php`)

```
Scholarships page — verified scholarship notices.
Breadcrumb "Home > Resources > Scholarships".

Sections:
1. Hero: "Scholarships" with award icon, subtitle about government and
   school scholarships.
2. Active scholarship notice cards: quota name (Dalit scholarship,
   girls' education, merit-based, disability), eligibility bullet list,
   required documents, deadline badge (red if close), source tag
   "Verified — School Notice" or "Government of Nepal".
3. How to apply numbered steps strip.
4. Empty-state variant: "No open scholarships right now — check the
   Notice Board."
```

## A17. Citizen Charter (`citizen-charter.php`)

```
Citizen Charter (नागरिक वडापत्र) page — services commitment of the school.
Breadcrumb "Home > Resources > Citizen Charter". Formal government tone.

Sections:
1. Hero with national-civic feel: title bilingual "Citizen Charter /
   नागरिक वडापत्र".
2. Services table: Service, Required Documents, Responsible Officer,
   Processing Time, Fee — 7 rows (admission certificate, transfer
   certificate, character certificate, marksheet verification, scholarship
   application, grievance filing, document attestation).
3. Service standards promise strip: time-bound delivery commitments.
4. Complaint/grievance redress card: contact person, phone, suggestion
   box note, escalation path to School Management Committee then
   Malangwa Municipality.
5. Downloadable charter PDF button.
```

## A18. FAQ (`faq.php`)

```
FAQ page. Breadcrumb "Home > Resources > FAQ".

Sections:
1. Hero: "Frequently Asked Questions".
2. Category anchors: Location, Admissions, Programs, Results, Downloads.
3. Accordion list of 12 questions with chevron icons — one expanded
   showing answer text: e.g. "Where is the school located?",
   "Which +2 streams do you offer?", "How do I get my SEE marksheet?",
   "Is education free?".
4. Still have questions? card with phone, email, contact-page button.
5. Search input above accordion filtering questions.
```

## A19. Useful Links (`links.php`)

```
Useful links page. Breadcrumb "Home > Resources > Useful Links".

Sections:
1. Hero: "Useful Links — Government & Education Portals".
2. Link card grid grouped by category headers:
   Federal: Ministry of Education (MOEST), CEHRD, NEB, CDC, SEE Board.
   Provincial: Madhesh Province Education Directorate.
   Local: Malangwa Municipality.
   Each card: portal favicon circle, name, short description,
   external-link arrow icon, opens in new tab badge.
```

## A20. Contact (`contact.php`)

```
Contact page. Breadcrumb "Home > Contact".

Sections:
1. Hero: "Visit, Call or Message Us".
2. Two-column: LEFT — contact form card (Name, Phone, Email, Subject
   select: Admission/General/Documents/Complaint, Message textarea,
   "Send Message" primary button); RIGHT — stacked info cards:
   address card (VH24+22W, Malangwa 45800, Sarlahi, Madhesh Province),
   phone card (tap-to-call), email card, office hours card
   (Sun–Fri 10:00–16:00, Sat closed).
3. Full-width embedded Google Map with pin on school location,
   "Get Directions" button opening Google Maps.
4. Accessibility note strip: wheelchair ramp at main gate.
```

## A21. Search Results (`search.php`)

```
Site search results page.

Layout:
1. Search hero band: large search input pre-filled with query term,
   "Search" button.
2. Results summary line: "12 results for 'admission'".
3. Grouped results: sections labeled Notices, Pages, Downloads, News —
   each result row: content-type tag, title with matched keywords
   bolded, snippet, URL breadcrumb in gray.
4. No-results state: illustration, "Try different keywords" suggestions,
   popular pages shortcuts.
```

## A22. Sitemap (`sitemap.php`)

```
HTML sitemap page.

Layout: hero band "Sitemap"; below, a multi-column tree of all site
sections grouped as Main Pages, About & Academics, Resources, Notices &
Media, Information — plain text links with folder icons. Clean,
low-chrome utilitarian design.
```

## A23. 404 & 500 error pages (`404.php`, `500.php`)

```
Two friendly error pages for the school website.

404: centered illustration of a lost school bag/backpack, big "404",
headline "This page went missing like a homework sheet 😅", body copy,
buttons "Go Home" (primary) and "Browse Notices" (outline), plus
search field.

500: centered wrench/gear illustration, "Something went wrong on our
side", reassurance copy "Our team has been notified", button "Back to
Home" and phone number to call the office.

Both reuse the standard header/footer.
```

---
---

# PART B — ADMIN PANEL PAGES

> Shared admin chrome for ALL screens below: fixed left sidebar 260px,
> background #092A4D, white logo text "श्री पब्लिक" with subtitle
> "Website Management" + logged-in user name & role; grouped nav with
> section labels CONTENT / MEDIA / PEOPLE / SYSTEM (Dashboard; Notices;
> News; Events; Pages; Gallery; Downloads; Staff; Results; Messages;
> Settings; Users) — active item = lighter bg + 3px gold (#FFCC00) left
> border; bottom of sidebar "🌐 View Website" and "Sign out" buttons.
> Main area: light #F7F9FC background, page title row with action
> buttons on the right, white cards with 12px radius and soft shadow.

## B1. Login (`login.php`)

```
Login page for the school website admin panel. Split-screen design.

LEFT panel: navy #001E40→#123B6D gradient with school logo circle,
school name in English + Devanagari, tagline "Website Management Panel",
subtle pattern of books/graduation caps, small footer text with IEMIS
number.

RIGHT panel: white centered login card (max-width 400px): heading
"Sign In", email input, password input with show/hide eye toggle,
"Remember me" checkbox, full-width navy "Sign In" button, error alert
example (red tinted, "Invalid credentials"), "← Back to website" link
below. Mobile: single column, brand header on top.
```

## B2. Dashboard (`admin/index.php`)

```
Admin dashboard for the school CMS. Standard admin sidebar +
breadcrumb-less page header: "Dashboard" title, subtitle
"Shree Public Secondary School — Malangwa-2 • IEMIS 190640003",
right-side quick-action buttons: "+ New Notice" (primary),
"+ New News", "Upload Document", "Add Event", "Add Gallery".

Below:
1. Stat cards grid (8 clickable cards): Published Notices (with
   drafts sub-count), News, Upcoming Events, Downloads, Gallery Images,
   Staff Members, Messages (with red unread count), Users — each with
   big number and uppercase label.
2. Two-column row: LEFT "Recent Notices" list card (title, date, pin);
   RIGHT "Quick Actions" vertical list card with emoji-prefixed buttons:
   🔔 Create Notice, 📰 Write News, 📅 Add Event, 🖼️ New Gallery Album,
   ⚙️ Site Settings, 👤 Add Staff.
```

## B3. Notices list (`admin/notices.php`)

```
Admin notices management list. Header: "Notices" + green
"+ New Notice" button.

Content:
1. Filter bar: search input, category select, status select
   (Published/Draft/Pinned), filter button.
2. Data table: columns Title, Category tag, Status tag (Published =
   green pill, Draft = gray, Pinned = gold), Published date, Views,
   Actions (edit pencil icon-btn, view external-link icon-btn, delete
   trash icon-btn with red hover). 12 rows sample data in English +
   Nepali titles.
3. Pagination footer. Flash success message example at top
   ("Notice published successfully").
4. Delete confirmation modal example: "Delete this notice?" warning
   icon, Cancel/Delete-red buttons.
```

## B4. Notice form (`admin/notice-form.php`)

```
Admin notice create/edit form. Breadcrumbs: Dashboard > Notices >
New Notice.

Form in white card, two-column grid:
LEFT: Title (English)*, Slug auto-generated hint, Category select*,
Publish date picker, Is Pinned toggle, Is Urgent toggle (red hint),
Status radio (Draft/Published).
RIGHT: Title (नेपाली) input with Devanagari font, Summary (EN) textarea,
Summary (NP) textarea.
FULL WIDTH: Body content rich-text editor toolbar mockup
(B, I, U, lists, link, image, PDF embed) with sample text.
Sidebar-ish bottom row: "Save Draft" ghost button, "Publish" primary
button, "Cancel" back link. Validation error state example under one field.
```

## B5. News list + form (`admin/news.php`, `admin/news-form.php`)

```
Two screens for news management.

SCREEN 1 — News list: header "News" + "+ Write News" button; table with
thumbnail column (60px image), Title, Category chip, Status pill, Date,
Views, Actions; featured-news star column; pagination; search +
category filter bar.

SCREEN 2 — News editor form: breadcrumbs Dashboard > News > Edit;
fields: Headline*, Slug, Category select (Academic/Sports/Cultural/
Community/Achievement), Publish date; Featured image uploader — dashed
upload zone with camera icon, dragover highlight state, uploaded image
preview with replace/remove controls; Excerpt textarea; Body rich-text
editor; Save Draft / Publish buttons.
```

## B6. Events list + form (`admin/events.php`, `admin/event-form.php`)

```
Two screens for event management.

SCREEN 1 — Events list: table columns Event, Date badge, Venue,
Status (Upcoming green / Past gray / Ongoing blue), Actions; toggle
filter "Show past events"; "+ Add Event" button.

SCREEN 2 — Event form: Title*, Description rich editor, Event date +
time pickers side by side, Venue text input with map-pin icon,
Category select, Banner image upload zone, Featured toggle, Status
select; Save/Cancel row.
```

## B7. Pages manager (`admin/pages.php`, `admin/page-form.php`)

```
Two screens for static page management (About, Citizen Charter, etc.).

SCREEN 1 — Pages list: table: Page Title, URL slug in monospace,
Status pill, Last updated, Actions (edit/delete/view); "+ New Page"
button; search bar; reorder handle dots column for drag-sort.

SCREEN 2 — Page editor: Title*, Slug, Parent page select (for nesting),
Content full-width rich-text editor with sample formatted content,
Meta title + Meta description inputs for SEO with character counters,
Featured image upload, Status radios, Show in navigation toggle,
Save/Preview/Cancel buttons.
```

## B8. Gallery manager (`admin/gallery.php`, `album-form.php`, `album-images.php`)

```
Three screens for photo gallery management.

SCREEN 1 — Albums grid: album cards with cover photo, title, photo
count badge, created date, edit/delete icon buttons; "+ New Album"
card as first tile (dashed border with plus icon); search bar.

SCREEN 2 — Album form: Album title*, Description textarea, Event date,
Cover image upload zone with preview, Visibility toggle (Published/
Hidden), Save button.

SCREEN 3 — Album images manager: header shows album name + back link;
bulk upload dropzone ("Drop up to 20 photos"); grid of image
thumbnails with hover overlay actions (set as cover star icon, edit
caption pencil, delete trash); drag handles for reordering; caption
inline-edit popover example open on one image.
```

## B9. Downloads manager (`admin/downloads.php`, `admin/download-form.php`)

```
Two screens for downloadable documents.

SCREEN 1 — Downloads list: filter by category pills + search; table:
File (icon + name), Category tag, Size, Downloads count, Uploaded date,
Status pill, Actions; "+ Upload Document" primary button; storage-usage
progress bar card at top ("128 MB of 1 GB used").

SCREEN 2 — Download form: Document title*, Category select, Description,
File uploader — dashed zone with cloud-upload icon, accepted formats
hint (PDF, DOCX, XLSX, JPG, PNG, max 10MB), uploading progress state
example at 64%, uploaded file chip with remove ×; Version/Year select;
Published toggle; Save/Cancel.
```

## B10. Staff manager (`admin/staff.php`, `admin/staff-form.php`)

```
Two screens for staff directory.

SCREEN 1 — Staff list: card-grid OR table view toggle; each staff row:
circular avatar, Name*, Position (Principal, Vice Principal, Teacher —
Math, etc.), Department tag, Phone, Order number for display sorting,
Active/inactive toggle switch, edit/delete actions; "+ Add Staff"
button; search + department filter.

SCREEN 2 — Staff form: Full name*, Position*, Qualification, Department
select, Phone, Email, Photo upload (square crop preview circle),
Short bio textarea with counter, Display order spinner, Show on website
toggle, Save/Cancel.
```

## B11. Results manager (`admin/results.php`)

```
Admin screen for publishing exam results.

Sections:
1. Header "Results Manager" + "+ Publish New Result Set" button.
2. Published result sets table: Exam name (First Terminal 2082, SEE
   Model Set, Grade 11 NEB…), Class/Section, Students count, Published
   date, Status pill (Live green / Archived), Actions (view, export CSV,
   unpublish, delete).
3. Bulk upload panel: CSV/XLSX upload zone with template-download link,
   column-mapping preview table example (Symbol No, Name, GPA, Grade
   sheet columns), validation warnings row example ("3 rows missing
   symbol numbers") in amber.
4. Privacy note strip: student results require office verification;
   only summaries are public.
```

## B12. Messages inbox (`admin/messages.php`)

```
Contact messages inbox for the admin panel.

Layout: two-pane email-client style.
LEFT pane (280px): filter folders — All, Unread (badge 5), Starred,
Archive — plus sender list items with avatar initial circles, name,
subject snippet, time, unread dot, selected state highlighted.
RIGHT pane: opened message view: subject header, sender info row with
reply-all buttons, message body paragraph, metadata (submitted from
contact form page), quick action bar: Mark read/unread, Star, Reply
(opens mail client), Archive, Delete; below, reply composer textarea
with Send button.
Top bar: search messages input + unread-count filter chip.
Mobile: list collapses to full-width, tap opens detail slide-over.
```

## B13. Settings (`admin/settings.php`)

```
Site settings screen with vertical tab navigation.

Tabs on left (in-card): General, Contact, Social, SEO, Appearance,
Advanced. Show GENERAL tab active with fields:
General: School name (EN)*, School name (NP) with Devanagari font,
Tagline, Established year, IEMIS code (read-only), Logo uploader
(circle preview), Favicon uploader.
Contact: Address, Phone, Alternate phone, WhatsApp number, Email,
Office hours, Google Maps embed URL, Map latitude/longitude pair.
SEO: Meta defaults, OG image upload, Google Analytics ID, sitemap
regenerate button.
Each tab has sticky "Save Settings" primary button; success flash
message example at top.
```

## B14. Users manager (`admin/users.php`, `admin/user-form.php`)

```
Two screens for admin user accounts.

SCREEN 1 — Users list: table: Avatar+Username, Full name, Role pill
(Super Admin red-outline, Editor blue, Author green), Email, Last
login relative time, Active toggle, Actions; current-user row tagged
"You" chip and delete disabled; "+ Add User" button; role filter
dropdown.

SCREEN 2 — User form: Username*, Full name*, Email*, Role select with
permission explanation help-text per role, Password + Confirm password
with strength meter (weak/fair/strong colored bars), "Send reset link
by email" secondary button, Active toggle, Save/Cancel. Warning callout:
"Super Admin can manage all users and settings."
```

## B15. Logout transition (`logout.php`) — optional micro-screen

```
Simple sign-out interstitial: centered card on light background with
spinner then checkmark, text "You have been signed out securely.",
buttons "Sign in again" (primary) and "Go to homepage" (ghost).
Auto-redirect countdown "Redirecting in 5…" small text.
```

---
---

# PART C — Consistency reminders (append to any prompt if drift happens)

```
Keep consistent with previous screens:
- Palette: navy #092A4D/#123B6D/#001E40, gold #D29A32/#FFCC00 accents,
  red #C1272D alerts only, bg #F7F9FC, borders #E2E8F0.
- Fonts: Inter body, Hanken Grotesk headings, Noto Sans Devanagari for
  Nepali text.
- Radii 8–12px, soft shadows rgba(9,42,77,.06), pill status tags.
- Public header: utility bar + logo/masthead + nav + gold CTA.
- Admin sidebar: navy with gold active border, grouped sections.
- Bilingual labels (English primary, Devanagari secondary) wherever
  titles appear.
- Mobile variants: public = hamburger drawer; admin = collapsible
  sidebar with floating ☰ toggle button bottom-right.
```
