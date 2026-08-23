<?php $page='faq'; $title='FAQ — Frequently Asked Questions | Shree Public Secondary School'; $description='Frequently asked questions about Shree Public Secondary School, Malangwa-2 — location, levels, +2 programs, notices, downloads, admission, results and directions.'; require_once __DIR__.'/includes/header.php'; ?>
<section class="hero" style="padding:40px 0 32px"><div class="hero-grid" aria-hidden="true"></div><div class="wrap" style="position:relative"><span class="hero-badge"><span class="dot"></span> FAQ</span><h1 style="color:#fff;margin:14px 0 10px">Frequently Asked Questions</h1><p class="lead" style="color:#C7D7F0;max-width:680px">Safe, verifiable answers — drawn only from information confirmed for Shree Public Secondary School. Policies are not invented; official notices and the school office take precedence.</p></div></section>
<nav class="wrap" style="padding:14px 20px"><div class="breadcrumbs"><a href="<?= e_attr(base_url()) ?>">Home</a><span class="sep">/</span><span>FAQ</span></div></nav>
<section class="section" style="padding-top:28px;background:#fff;border-top:1px solid var(--border)">
  <div class="wrap" style="max-width:760px;display:grid;gap:14px">
    <div style="background:var(--surface-low);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--primary);width:20px;height:20px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <p style="font-size:.88rem;color:var(--muted);line-height:1.7"><strong style="color:var(--text)">Note:</strong> Answers below use only verified school identity (name, location, IEMIS, levels, +2 streams). For dates, fees, procedures and personal matters, the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a> and <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">school office</a> are authoritative. No policy is invented to fill space.</p>
    </div>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px" open>
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">Where is the school located?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7"><strong style="color:var(--text)">Shree Public Secondary School</strong> (श्री पब्लिक माध्यमिक विद्यालय) is in <strong>Malangwa Municipality-2, Sarlahi, Madhesh Province 45800, Nepal</strong>. Plus Code <strong>VH24+22W</strong> (26.8501032 N, 85.555064 E). See <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">Contact → Map &amp; directions</a> for the embedded map and directions link.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">What levels does the school teach?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">The school covers <strong style="color:var(--text)">ECD through Grade 12</strong> on a single campus — ECD / Nursery, Basic Level (Grades 1–8), Secondary Level (Grades 9–10, SEE) and Higher Secondary (Grades 11–12, NEB). See <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--primary);font-weight:700">Academics</a> for a detailed explanation of each level.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">Which +2 programs are available?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">Currently <strong style="color:var(--text)">+2 Science</strong> and <strong style="color:var(--text)">+2 Management</strong> under the National Examinations Board (NEB). Program descriptions, learning focus and general further-study examples are on <a href="<?= e_attr(base_url('science.php')) ?>" style="color:var(--primary);font-weight:700">+2 Science</a> and <a href="<?= e_attr(base_url('management.php')) ?>" style="color:var(--primary);font-weight:700">+2 Management</a>. Exact subject combinations for the current year are confirmed by the school office.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">Where are official notices published?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">All official notices — admissions, examinations, scholarships, holidays, vacancies, procurement and general — are published on the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--primary);font-weight:700">Notice Board</a>. Pinned / urgent notices appear first. Expired notices are hidden automatically. For admission specifically, use <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">Notice Board → Admission</a>.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">Where can I download forms and school documents?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">In the <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads / Resources centre</a> — categories include Academic Calendar, Exam Routine, Admission Documents, Results, Forms, Policies, Citizen Charter and Publications. When a document exists it shows file type, size and publish date. Empty categories show an intentional empty state.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">How can I get directions to the school?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">Use the embedded map and <strong>Get Directions — VH24+22W</strong> button on the <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">Contact page</a>, or search Plus Code <strong>VH24+22W</strong> / coordinates <strong>26.8501032, 85.555064</strong> in Google Maps.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">How do I confirm admission requirements?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">Check the <a href="<?= e_attr(base_url('notices.php?category=admission')) ?>" style="color:var(--primary);font-weight:700">latest admission notice</a> for the grade and year you are applying for, and <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--primary);font-weight:700">contact or visit the school</a> to confirm eligibility, seats, fees, required documents and deadline. The general guidance on the <a href="<?= e_attr(base_url('admissions.php')) ?>" style="color:var(--primary);font-weight:700">Admissions page</a> is not a substitute for the official notice.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">Are examination results available online?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">Published online results — when made available — appear in <a href="<?= e_attr(base_url('results.php')) ?>" style="color:var(--primary);font-weight:700">Results</a> (search by symbol / roll number) and as downloadable PDFs in <a href="<?= e_attr(base_url('downloads.php')) ?>" style="color:var(--primary);font-weight:700">Downloads</a>. Online display is for information only; the official marksheet / grade sheet is the authoritative record and is verified through the school office. Board results for Grade 12 are also verifiable via <a href="https://neb.gov.np" target="_blank" rel="noopener" style="color:var(--primary);font-weight:700">neb.gov.np</a>.</p>
    </details>

    <details style="background:var(--bg);border:1px solid var(--border);border-radius:12px;padding:18px">
      <summary style="font-weight:700;cursor:pointer;font-size:1rem">What does IEMIS 190640003 mean?</summary>
      <p style="color:var(--muted);font-size:.92rem;margin-top:10px;line-height:1.7">It is the <strong>Integrated Educational Management Information System</strong> code identifying Shree Public Secondary School as a public institution within Nepal's education data system (CEHRD). Enrollment figures by grade are reported through IEMIS — this website displays the total as <strong>1,000+ Students</strong> to avoid fixing a single year's total.</p>
    </details>

    <div style="background:var(--primary-dark);color:#C7D7F0;border-radius:12px;padding:18px;display:flex;gap:12px;align-items:flex-start">
      <svg class="ic" style="color:var(--gold);width:22px;height:22px;margin-top:2px;flex:none"><use href="#i-info"/></svg>
      <div style="font-size:.88rem;line-height:1.6"><strong style="color:#fff">Still have a question?</strong> Visit <a href="<?= e_attr(base_url('contact.php')) ?>" style="color:var(--gold);text-decoration:underline">Contact</a> or the <a href="<?= e_attr(base_url('notices.php')) ?>" style="color:var(--gold);text-decoration:underline">Notice Board</a>. For general school structure, start with <a href="<?= e_attr(base_url('academics.php')) ?>" style="color:var(--gold);text-decoration:underline">Academics</a> and <a href="<?= e_attr(base_url('admissions.php')) ?>" style="color:var(--gold);text-decoration:underline">Admissions</a>. No additional policy is assumed on this site — when in doubt, ask the school office.</div>
    </div>

    <div style="display:flex;flex-wrap:wrap;gap:10px">
      <a href="<?= e_attr(base_url('contact.php')) ?>" class="btn btn-primary">Contact School →</a>
      <a href="<?= e_attr(base_url('admissions.php')) ?>" class="btn btn-soft">Admissions</a>
      <a href="<?= e_attr(base_url('notices.php')) ?>" class="btn btn-ghost">Notice Board</a>
    </div>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>
