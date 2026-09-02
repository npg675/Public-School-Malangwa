<?php
$adminPage = 'staff'; $adminTitle = 'Staff Form';
require_once __DIR__ . '/includes/admin_header.php';
$pdo = db(); $flash = null; $editing = isset($_GET['id']) && is_numeric($_GET['id']); $row = null; $cats = [];
if ($pdo && db_has_table('staff_categories')) {
    try {
        // Keep existing installations in sync with the About page hierarchy.
        $pdo->exec("INSERT INTO staff_categories (slug,name_en,name_np,sort_order) VALUES ('committee','School Management Committee','विद्यालय व्यवस्थापन समिति',2) ON DUPLICATE KEY UPDATE name_en=VALUES(name_en), name_np=VALUES(name_np), sort_order=VALUES(sort_order)");
        $pdo->exec("UPDATE staff_categories SET sort_order = CASE slug WHEN 'leadership' THEN 1 WHEN 'committee' THEN 2 WHEN 'administration' THEN 3 WHEN 'teaching' THEN 4 WHEN 'non_teaching' THEN 5 ELSE sort_order END WHERE slug IN ('leadership','committee','administration','teaching','non_teaching')");
        $cats = $pdo->query("SELECT * FROM staff_categories ORDER BY sort_order, name_en")->fetchAll();
    } catch (Throwable $e) { error_log('Staff categories load failed: '.$e->getMessage()); }
}
if ($editing) { $stmt = $pdo->prepare('SELECT * FROM staff WHERE id = ?'); $stmt->execute([(int)$_GET['id']]); $row = $stmt->fetch(); if (!$row) { header('Location: '.base_url('admin/staff.php')); exit; } }
$form = $row ?: [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['name_en'=>trim($_POST['name_en']??''),'name_np'=>trim($_POST['name_np']??''),'designation_en'=>trim($_POST['designation_en']??''),'designation_np'=>trim($_POST['designation_np']??''),'department'=>trim($_POST['department']??''),'qualification'=>trim($_POST['qualification']??''),'phone'=>trim($_POST['phone']??''),'email'=>trim($_POST['email']??''),'show_phone'=>isset($_POST['show_phone'])?1:0,'show_email'=>isset($_POST['show_email'])?1:0,'photo'=>trim($_POST['photo']??''),'category_id'=>$_POST['category_id']?:null,'display_order'=>(int)($_POST['display_order']??0),'is_active'=>isset($_POST['is_active'])?1:0];
    $errors = [];
    if (empty($d['name_en']) || empty($d['designation_en'])) $errors[] = ta('Name and designation are required.','नाम र पद आवश्यक छन्।');
    if (empty($d['category_id'])) $errors[] = ta('Please choose a staff category.','कृपया कर्मचारीको श्रेणी छान्नुहोस्।');
    if ($d['email'] !== '' && !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = ta('Please enter a valid email address.','कृपया मान्य इमेल ठेगाना राख्नुहोस्।');
    if ($errors) { $form = array_merge($form, $d); $flash = ['err', implode(' ', $errors)]; }
    else {
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE staff SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $form = array_merge($form, $d); $flash=['ok',ta('Staff updated.','कर्मचारी अद्यावधिक भयो।')]; }
        else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO staff (`$c`) VALUES ($v)")->execute($d); $form = []; $flash=['ok',ta('Staff added.','कर्मचारी थपियो।')]; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/staff.php')) ?>"><?= ta('Staff','कर्मचारी') ?></a> <span aria-hidden="true">/</span> <span><?= $editing ? ta('Edit','सम्पादन') : ta('Add','थप्नुहोस्') ?></span></div>
<div class="top"><h1><?= $editing ? ta('Edit Staff','कर्मचारी सम्पादन गर्नुहोस्') : ta('Add Staff Member','कर्मचारी थप्नुहोस्') ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>" role="<?= $flash[0] === 'err' ? 'alert' : 'status' ?>" aria-live="polite"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box staff-form" id="staffForm">
<?= csrf_field() ?>
<div id="staffFormErrors" class="form-errors" role="alert" aria-live="assertive" hidden></div>
<fieldset class="form-section">
    <legend><?= ta('Basic information','आधारभूत जानकारी') ?></legend>
    <div class="form-grid">
        <div class="form-group"><label for="staffNameEn"><?= ta('Name (English)','नाम (अंग्रेजी)') ?> <span class="req" aria-hidden="true">*</span></label><input id="staffNameEn" type="text" name="name_en" required aria-required="true" autocomplete="name" value="<?= e($form['name_en']??'') ?>"></div>
        <div class="form-group"><label for="staffNameNp"><?= ta('Name (Nepali)','नाम (नेपाली)') ?></label><input id="staffNameNp" type="text" name="name_np" lang="ne" autocomplete="off" aria-describedby="nameNpHint" value="<?= e($form['name_np']??'') ?>"><small class="hint" id="nameNpHint"><?= ta('Add the official Nepali spelling when available.','उपलब्ध भएमा आधिकारिक नेपाली हिज्जे राख्नुहोस्।') ?></small></div>
        <div class="form-group"><label for="staffDesignationEn"><?= ta('Designation (English)','पद (अंग्रेजी)') ?> <span class="req" aria-hidden="true">*</span></label><input id="staffDesignationEn" type="text" name="designation_en" required aria-required="true" value="<?= e($form['designation_en']??'') ?>"></div>
        <div class="form-group"><label for="staffDesignationNp"><?= ta('Designation (Nepali)','पद (नेपाली)') ?></label><input id="staffDesignationNp" type="text" name="designation_np" lang="ne" autocomplete="off" value="<?= e($form['designation_np']??'') ?>"></div>
    </div>
</fieldset>
<fieldset class="form-section">
    <legend><?= ta('Role and contact','पद र सम्पर्क') ?></legend>
    <div class="form-grid">
        <div class="form-group"><label for="staffCategory"><?= ta('Category','श्रेणी') ?> <span class="req" aria-hidden="true">*</span></label><select id="staffCategory" name="category_id" required aria-required="true" aria-describedby="categoryHint"><option value=""><?= ta('Select a category','श्रेणी छान्नुहोस्') ?></option><?php foreach($cats as $c): ?><option value="<?= (int)$c['id'] ?>" <?=($form['category_id']??'')==$c['id']?'selected':''?>><?= e(ta((string)$c['name_en'], (string)$c['name_np'])) ?></option><?php endforeach;?></select><small class="hint" id="categoryHint"><?= ta('Choose Teaching Staff for teachers.','शिक्षकका लागि Teaching Staff छान्नुहोस्।') ?></small></div>
        <div class="form-group"><label for="staffDepartment"><?= ta('Department','विभाग') ?></label><input id="staffDepartment" type="text" name="department" autocomplete="organization" value="<?= e($form['department']??'') ?>"></div>
        <div class="form-group"><label for="staffQualification"><?= ta('Qualification','शैक्षिक योग्यता') ?></label><input id="staffQualification" type="text" name="qualification" value="<?= e($form['qualification']??'') ?>"></div>
        <div class="form-group"><label for="staffPhone"><?= ta('Phone','फोन') ?></label><input id="staffPhone" type="tel" name="phone" inputmode="tel" autocomplete="tel" value="<?= e($form['phone']??'') ?>"></div>
        <div class="form-group"><label for="staffEmail"><?= ta('Email','इमेल') ?></label><input id="staffEmail" type="email" name="email" inputmode="email" autocomplete="email" value="<?= e($form['email']??'') ?>"></div>
    </div>
</fieldset>
<fieldset class="form-section">
    <legend><?= ta('Profile photo','प्रोफाइल फोटो') ?></legend>
    <div class="form-group form-full">
        <div class="upload-zone" role="button" tabindex="0" aria-describedby="photoUploadLabel photoHelp" onclick="staffPhotoZoneClick(event,this)"><input type="file" accept="image/jpeg,image/png,image/webp" style="display:none" id="staffPhotoInput"><span id="photoUploadLabel"><?= ta('Click or drag to upload a JPG, PNG or WebP portrait','JPG, PNG वा WebP फोटो अपलोड गर्न क्लिक वा तान्नुहोस्') ?></span><img id="staffPhotoPreview" class="preview-img" src="<?= e_attr(!empty($form['photo']) ? staff_photo_url($form['photo']) : '') ?>" alt="<?= ta('Current profile photo','हालको प्रोफाइल फोटो') ?>" style="<?= !empty($form['photo']) ? '' : 'display:none' ?>">
        <div id="staffPhotoEditor" class="photo-editor" style="display:none">
            <div class="pe-frame"><canvas id="staffPhotoCanvas" width="600" height="600"></canvas></div>
            <div class="pe-controls">
                <button type="button" class="btn btn-sm" onclick="staffPhotoZoom(-0.15)" title="<?= ta('Zoom out','जुम घटाउनुहोस्') ?>" aria-label="<?= ta('Zoom out','जुम घटाउनुहोस्') ?>">−</button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoReset()"><?= ta('Reset','रिसेट') ?></button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoZoom(0.15)" title="<?= ta('Zoom in','जुम बढाउनुहोस्') ?>" aria-label="<?= ta('Zoom in','जुम बढाउनुहोस्') ?>">+</button>
                <button type="button" class="btn btn-primary btn-sm" data-photo-save="1" onclick="staffPhotoSave()"><?= ta('Save photo','फोटो सुरक्षित गर्नुहोस्') ?></button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoCancel()"><?= ta('Cancel','रद्द') ?></button>
            </div>
            <small style="display:block;margin-top:6px;color:#667085"><?= ta('Use + / − or scroll to zoom, drag to centre the face.','+ / − वा स्क्रोल गरेर जुम गर्नुहोस्, अनुहार केन्द्रित गर्न तस्बिर तान्नुहोस्।') ?></small>
        </div>
        </div>
        <small class="hint" id="photoHelp"><?= ta('Use a clear, front-facing school-approved photo. The profile appears publicly only when Active is checked.','विद्यालयले स्वीकृत गरेको स्पष्ट अगाडिबाट खिचिएको फोटो प्रयोग गर्नुहोस्। Active छान्दा मात्र प्रोफाइल वेबसाइटमा देखिन्छ।') ?></small>
        <details class="advanced-photo"><summary><?= ta('Use an existing photo path or URL','पहिलेको फोटो path वा URL प्रयोग गर्नुहोस्') ?></summary><label for="staffPhotoPath"><?= ta('Photo path or URL','फोटो path वा URL') ?></label><input type="text" name="photo" id="staffPhotoPath" value="<?= e($form['photo']??'') ?>" placeholder="uploads/staff/..." autocomplete="off"></details>
    </div>
</fieldset>
<fieldset class="form-section">
    <legend><?= ta('Website visibility','वेबसाइटमा देखिने') ?></legend>
    <div class="form-grid">
        <div class="form-group"><label for="staffDisplayOrder"><?= ta('Display order','देखाउने क्रम') ?></label><input id="staffDisplayOrder" type="number" name="display_order" min="0" step="1" aria-describedby="displayOrderHint" value="<?= e($form['display_order']??'0') ?>"><small class="hint" id="displayOrderHint"><?= ta('Lower numbers appear first.','कम अंक भएका कर्मचारी पहिले देखिन्छन्।') ?></small></div>
        <div class="visibility-options" aria-label="<?= ta('Website visibility options','वेबसाइट दृश्यता विकल्पहरू') ?>">
            <label class="checkbox-row" for="show_phone"><input type="checkbox" name="show_phone" id="show_phone" <?=($form['show_phone']??0)?'checked':''?>><span><?= ta('Show phone on website','वेबसाइटमा फोन देखाउनुहोस्') ?></span></label>
            <label class="checkbox-row" for="show_email"><input type="checkbox" name="show_email" id="show_email" <?=($form['show_email']??0)?'checked':''?>><span><?= ta('Show email on website','वेबसाइटमा इमेल देखाउनुहोस्') ?></span></label>
            <label class="checkbox-row" for="is_active"><input type="checkbox" name="is_active" id="is_active" <?=($form['is_active']??1)?'checked':''?>><span><?= ta('Active (visible on site)','Active (वेबसाइटमा देखिने)') ?></span></label>
        </div>
    </div>
</fieldset>
<div class="form-actions"><button type="submit" class="btn btn-primary"><?= $editing ? ta('Save changes','परिवर्तन सुरक्षित गर्नुहोस्') : ta('Add staff member','कर्मचारी थप्नुहोस्') ?></button><a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="btn"><?= ta('Cancel','रद्द') ?></a><span class="form-actions-note"><?= ta('Required fields are marked with *','* भएका फाँटहरू आवश्यक छन्') ?></span></div>
</form>
<script>
(function(){
  var input=document.getElementById('staffPhotoInput');
  var editor=document.getElementById('staffPhotoEditor');
  if(!input||!editor)return;
  var canvas=document.getElementById('staffPhotoCanvas');
  var ctx=canvas.getContext('2d');
  var frame=canvas.parentElement;
  var SIZE=600;
  var img=null, scale=1, panX=0, panY=0;
  var zone=input.closest('.upload-zone');
  var photoSaveButton=editor.querySelector('[data-photo-save]');

  function draw(){
    if(!img)return;
    var cover=Math.max(SIZE/img.naturalWidth, SIZE/img.naturalHeight);
    var drawW=img.naturalWidth*cover*scale;
    var drawH=img.naturalHeight*cover*scale;
    var maxX=(drawW-SIZE)/2, maxY=(drawH-SIZE)/2;
    if(maxX<=0)panX=0; else panX=Math.max(-maxX,Math.min(maxX,panX));
    if(maxY<=0)panY=0; else panY=Math.max(-maxY,Math.min(maxY,panY));
    ctx.fillStyle='#0B1B33'; ctx.fillRect(0,0,SIZE,SIZE);
    ctx.drawImage(img, SIZE/2+panX-drawW/2, SIZE/2+panY-drawH/2, drawW, drawH);
    editor.dataset.open='1';
  }

  function load(file){
    var url=URL.createObjectURL(file);
    var im=new Image();
    im.onload=function(){ URL.revokeObjectURL(url); img=im; scale=1; panX=0; panY=0; draw(); editor.style.display='block'; };
    im.onerror=function(){ URL.revokeObjectURL(url); alert('<?= ta("Could not open this image.","यो तस्बिर खोल्न सकिएन।") ?>'); };
    im.src=url;
  }

  input.addEventListener('change',function(){
    if(!input.files.length)return;
    load(input.files[0]);
    input.value='';
  });

  if(zone) zone.addEventListener('keydown',function(ev){
    if(ev.key==='Enter'||ev.key===' '){ev.preventDefault();staffPhotoZoneClick(ev,zone);}
  });

  window.staffPhotoZoneClick=function(ev,zone){
    if(ev)ev.stopImmediatePropagation();
    if(editor.dataset.open)return;
    zone.querySelector('input[type=file]').click();
  };

  window.staffPhotoZoom=function(delta){
    if(!img)return;
    var ns=Math.min(4,Math.max(1,scale+delta));
    var f=ns/scale; panX*=f; panY*=f; scale=ns;
    draw();
  };
  window.staffPhotoReset=function(){ if(!img)return; scale=1; panX=0; panY=0; draw(); };
  window.staffPhotoCancel=function(){
    editor.style.display='none'; delete editor.dataset.open;
    img=null; scale=1; panX=0; panY=0;
  };
  window.staffPhotoSave=function(){
    if(!img)return;
    if(photoSaveButton){photoSaveButton.disabled=true;photoSaveButton.setAttribute('aria-busy','true');}
    canvas.toBlob(function(blob){
      if(!blob){ alert('<?= ta("Could not save the image.","तस्बिर सुरक्षित गर्न सकिएन।") ?>'); if(photoSaveButton){photoSaveButton.disabled=false;photoSaveButton.removeAttribute('aria-busy');} return; }
      uploadFile(blob,function(e,r){
        if(e){ alert(e); if(photoSaveButton){photoSaveButton.disabled=false;photoSaveButton.removeAttribute('aria-busy');} return; }
        document.getElementById('staffPhotoPath').value=r.path;
        var pv=document.getElementById('staffPhotoPreview');
        pv.src='<?= e_attr(base_url('')) ?>'+r.path;
        pv.style.display='block';
        staffPhotoCancel();
        if(photoSaveButton){photoSaveButton.disabled=false;photoSaveButton.removeAttribute('aria-busy');}
      },'staff');
    },'image/jpeg',0.9);
  };

  frame.addEventListener('wheel',function(ev){ ev.preventDefault(); staffPhotoZoom(ev.deltaY<0?0.05:-0.05); },{passive:false});

  var dragging=false, sx=0, sy=0, spx=0, spy=0;
  frame.addEventListener('mousedown',function(ev){ if(!img)return; dragging=true; frame.classList.add('dragging'); sx=ev.clientX; sy=ev.clientY; spx=panX; spy=panY; });
  window.addEventListener('mousemove',function(ev){ if(!dragging)return; panX=spx+(ev.clientX-sx); panY=spy+(ev.clientY-sy); draw(); });
  window.addEventListener('mouseup',function(){ dragging=false; frame.classList.remove('dragging'); });

  var tx=null;
  frame.addEventListener('touchstart',function(ev){ if(!img||ev.touches.length!==1)return; tx=ev.touches[0]; dragging=true; frame.classList.add('dragging'); sx=tx.clientX; sy=tx.clientY; spx=panX; spy=panY; ev.preventDefault(); },{passive:false});
  frame.addEventListener('touchmove',function(ev){ if(!dragging||!tx)return; var t=ev.touches[0]; panX=spx+(t.clientX-sx); panY=spy+(t.clientY-sy); draw(); ev.preventDefault(); },{passive:false});
  frame.addEventListener('touchend',function(){ dragging=false; tx=null; frame.classList.remove('dragging'); });
})();

(function(){
  var form=document.getElementById('staffForm');
  var errorBox=document.getElementById('staffFormErrors');
  if(!form)return;
  var dirty=false,submitting=false;
  function clearValidState(field){if(field.checkValidity()){field.removeAttribute('aria-invalid');}}
  function showErrors(){
    var invalid=[].slice.call(form.querySelectorAll('input,select,textarea')).filter(function(field){return field.willValidate&&!field.checkValidity();});
    invalid.forEach(function(field){field.setAttribute('aria-invalid','true');});
    if(errorBox&&invalid.length){errorBox.hidden=false;errorBox.textContent='<?= e_attr(ta("Please complete the required fields before saving.","सुरक्षित गर्नुअघि आवश्यक फाँटहरू भर्नुहोस्।")) ?>';}
  }
  form.addEventListener('input',function(ev){dirty=true;clearValidState(ev.target);if(errorBox&&!form.querySelector(':invalid')){errorBox.hidden=true;errorBox.textContent='';}});
  form.addEventListener('change',function(){dirty=true;});
  form.addEventListener('invalid',showErrors,true);
  form.addEventListener('submit',function(){submitting=true;});
  window.addEventListener('beforeunload',function(ev){if(dirty&&!submitting){ev.preventDefault();ev.returnValue='';}});
})();
</script>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
