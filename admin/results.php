<?php
$adminPage = 'results'; $adminTitle = 'Exam Results';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null;

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (csrf_verify($_GET['csrf'] ?? '')) {
        $pdo->prepare('DELETE FROM student_results WHERE exam_id=?')->execute([(int)$_GET['delete']]);
        $pdo->prepare('DELETE FROM exams WHERE id=?')->execute([(int)$_GET['delete']]);
        $flash = ['ok', 'Exam and results deleted.'];
    }
}

$exams = [];
if ($pdo && db_has_table('exams')) {
    try { $exams = $pdo->query("SELECT e.*, t.name_en as type_name, (SELECT COUNT(*) FROM student_results WHERE exam_id=e.id) as result_count FROM exams e JOIN exam_types t ON t.id=e.exam_type_id ORDER BY e.academic_year DESC, e.created_at DESC")->fetchAll(); } catch (Throwable $e) { error_log('Exams list failed: '.$e->getMessage()); }
}
$examTypes = [];
if ($pdo && db_has_table('exam_types')) { try { $examTypes = $pdo->query("SELECT * FROM exam_types")->fetchAll(); } catch (Throwable $e) { error_log('Exam types load failed: '.$e->getMessage()); } }

// Create exam
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '') && isset($_POST['create_exam'])) {
    $pdo->prepare('INSERT INTO exams (exam_type_id, academic_year, class_name, title_en, is_published) VALUES (?,?,?,?,?)')
        ->execute([(int)$_POST['exam_type_id'], $_POST['academic_year']??'', $_POST['class_name']??'', $_POST['exam_title']??'', 1]);
    $flash = ['ok', 'Exam created.'];
}

// Import results
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '') && isset($_POST['import_results'])) {
    $exam_id = (int)$_POST['exam_id'];
    $csv = trim($_POST['csv_data'] ?? '');
    if ($exam_id && $csv) {
        $lines = explode("\n", $csv);
        $count = 0;
        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line || $count === 0 && (str_contains($line, 'symbol') || str_contains($line, 'Symbol'))) { $count++; continue; }
            $parts = str_getcsv($line);
            if (count($parts) >= 2) {
                $sym = trim($parts[0]);
                $name = trim($parts[1]);
                $grade = $parts[2] ?? null;
                $gpa = $parts[3] ?? null;
                $status = $parts[4] ?? 'graded';
                try {
                    $pdo->prepare('INSERT INTO student_results (exam_id, symbol_no, student_name, grade, gpa, result_status) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE student_name=VALUES(student_name), grade=VALUES(grade), gpa=VALUES(gpa), result_status=VALUES(result_status)')
                        ->execute([$exam_id, $sym, $name, $grade, $gpa ?: null, $status]);
                    $count++;
                } catch (Throwable $e) { error_log('Result import failed: '.$e->getMessage()); }
            }
        }
        $flash = ['ok', "$count result(s) imported."];
    }
}
?>
<div class="top"><div><h1>Exam Results</h1><p>Manage exams and import student results (SEE, NEB, Internal)</p></div></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<div class="grid2">
    <div class="section-box">
        <h3>Create New Exam</h3>
        <form method="post"><?= csrf_field() ?><input type="hidden" name="create_exam" value="1">
        <div class="form-grid">
            <div class="form-group"><label>Type</label><select name="exam_type_id" required><option value="">— Select —</option><?php foreach($examTypes as $t): ?><option value="<?=$t['id']?>"><?=e($t['name_en'])?></option><?php endforeach;?></select></div>
            <div class="form-group"><label>Academic Year</label><input type="text" name="academic_year" value="<?= date('Y') ?>" placeholder="2082"></div>
            <div class="form-group"><label>Class</label><input type="text" name="class_name" placeholder="Grade 10"></div>
            <div class="form-group"><label>Title</label><input type="text" name="exam_title" placeholder="SEE 2082"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:8px">Create Exam</button>
        </form>
    </div>
    <div class="section-box">
        <h3>Import Results (CSV)</h3>
        <form method="post"><?= csrf_field() ?><input type="hidden" name="import_results" value="1">
        <div class="form-group"><label>Exam</label><select name="exam_id" required><option value="">— Select —</option><?php foreach($exams as $ex): ?><option value="<?=$ex['id']?>"><?=e($ex['title_en'])?> (<?=$ex['academic_year']?>)</option><?php endforeach;?></select></div>
        <div class="form-group"><label>CSV Data</label><textarea name="csv_data" rows="6" placeholder="symbol_no,student_name,grade,gpa,status&#10;1001,Ram Shrestna,A+,3.90,graded&#10;1002,Sita Kumar,A,3.70,graded"></textarea></div>
        <button type="submit" class="btn btn-primary" style="margin-top:8px">Import</button>
        </form>
    </div>
</div>

<div class="section-box" style="margin-top:16px">
    <h3>All Exams</h3>
    <table><thead><tr><th>Exam</th><th>Year</th><th>Class</th><th>Results</th><th>Status</th><th>Actions</th></tr></thead><tbody>
    <?php if (empty($exams)): ?><tr><td colspan="6" class="empty">No exams yet.</td></tr>
    <?php else: foreach ($exams as $ex): ?><tr>
        <td><strong><?= e($ex['title_en']) ?></strong><br><small style="color:#667085"><?= e($ex['type_name']) ?></small></td>
        <td><small><?= e($ex['academic_year']) ?></small></td>
        <td><small><?= e($ex['class_name']) ?></small></td>
        <td><span class="tag tag-blue"><?= $ex['result_count'] ?> results</span></td>
        <td><span class="tag <?= $ex['is_published']?'tag-green':'tag-gold' ?>"><?= $ex['is_published']?'Published':'Draft' ?></span></td>
        <td><a href="<?= e_attr(base_url('admin/results.php?delete='.$ex['id'].'&csrf='.csrf_token())) ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</a></td>
    </tr><?php endforeach; endif; ?>
    </tbody></table>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
