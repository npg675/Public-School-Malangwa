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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['_csrf'] ?? '')) {
    $d = ['name_en'=>trim($_POST['name_en']??''),'name_np'=>trim($_POST['name_np']??''),'designation_en'=>trim($_POST['designation_en']??''),'designation_np'=>trim($_POST['designation_np']??''),'department'=>trim($_POST['department']??''),'qualification'=>trim($_POST['qualification']??''),'phone'=>trim($_POST['phone']??''),'email'=>trim($_POST['email']??''),'show_phone'=>isset($_POST['show_phone'])?1:0,'show_email'=>isset($_POST['show_email'])?1:0,'photo'=>trim($_POST['photo']??''),'category_id'=>$_POST['category_id']?:null,'display_order'=>(int)($_POST['display_order']??0),'is_active'=>isset($_POST['is_active'])?1:0];
    if (empty($d['name_en']) || empty($d['designation_en'])) { $flash = ['err','Name and Designation required.']; }
    else {
        if ($editing) { $s=[]; foreach($d as $k=>$v) $s[]="`$k`=:$k"; $d[':id']=(int)$_GET['id']; $pdo->prepare('UPDATE staff SET '.implode(', ',$s).' WHERE id=:id')->execute($d); $flash=['ok','Staff updated.']; }
        else { $c=implode('`, `',array_keys($d)); $v=':'.implode(', :',array_keys($d)); $pdo->prepare("INSERT INTO staff (`$c`) VALUES ($v)")->execute($d); $flash=['ok','Staff added.']; }
    }
}
?>
<div class="breadcrumbs"><a href="<?= e_attr(base_url('admin/staff.php')) ?>">Staff</a> <span>/</span> <span><?= $editing?'Edit':'Add' ?></span></div>
<div class="top"><h1><?= $editing?'Edit Staff':'Add Staff Member' ?></h1></div>
<?php if ($flash): ?><div class="flash flash-<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<form method="post" class="section-box"><?= csrf_field() ?>
<div class="form-grid">
    <div class="form-group"><label>Name (English) *</label><input type="text" name="name_en" required value="<?= e($row['name_en']??'') ?>"></div>
    <div class="form-group"><label>Name (Nepali)</label><input type="text" name="name_np" value="<?= e($row['name_np']??'') ?>"></div>
    <div class="form-group"><label>Designation (English) *</label><input type="text" name="designation_en" required value="<?= e($row['designation_en']??'') ?>"></div>
    <div class="form-group"><label>Designation (Nepali)</label><input type="text" name="designation_np" value="<?= e($row['designation_np']??'') ?>"></div>
    <div class="form-group"><label>Category</label><select name="category_id"><option value="">— Select —</option><?php foreach($cats as $c): ?><option value="<?=$c['id']?>" <?=($row['category_id']??'')==$c['id']?'selected':''?>><?=e($c['name_en'])?></option><?php endforeach;?></select></div>
    <div class="form-group"><label>Department</label><input type="text" name="department" value="<?= e($row['department']??'') ?>"></div>
    <div class="form-group"><label>Qualification</label><input type="text" name="qualification" value="<?= e($row['qualification']??'') ?>"></div>
    <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= e($row['phone']??'') ?>"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= e($row['email']??'') ?>"></div>
    <div class="form-group form-full"><label>Profile photo</label><input type="text" name="photo" value="<?= e($row['photo']??'') ?>" placeholder="uploads/staff/..." id="staffPhotoPath"><div class="upload-zone" style="margin-top:8px;padding:18px;position:relative" onclick="staffPhotoZoneClick(event,this)"><input type="file" accept="image/jpeg,image/png,image/webp" style="display:none" id="staffPhotoInput"><small>Click or drag to upload a JPG, PNG or WebP portrait</small><img id="staffPhotoPreview" class="preview-img" src="<?= e_attr(!empty($row['photo']) ? staff_photo_url($row['photo']) : '') ?>" alt="Current profile photo" style="<?= !empty($row['photo']) ? '' : 'display:none' ?>">
        <div id="staffPhotoEditor" class="photo-editor" style="display:none">
            <div class="pe-frame"><canvas id="staffPhotoCanvas" width="600" height="600"></canvas></div>
            <div class="pe-controls">
                <button type="button" class="btn btn-sm" onclick="staffPhotoZoom(-0.15)" title="Zoom out">−</button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoReset()"><?= ta('Reset','रीसेट') ?></button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoZoom(0.15)" title="Zoom in">+</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="staffPhotoSave()"><?= ta('Save','सुरक्षित गर्नुहोस्') ?></button>
                <button type="button" class="btn btn-sm" onclick="staffPhotoCancel()"><?= ta('Cancel','रद्द') ?></button>
            </div>
            <small style="display:block;margin-top:6px;color:#667085"><?= ta('Use + / − or scroll to zoom, drag to centre the face.','+ / − वा स्क्रोल गरेर जुम गर्नुहोस्, अनुहार केन्द्रित गर्न तस्बिर तान्नुहोस्।') ?></small>
        </div>
        </div><small style="display:block;margin-top:6px;color:#667085">Use a clear, front-facing school-approved photo. The profile appears publicly only when Active is checked.</small></div>
    <div class="form-group"><label>Display Order</label><input type="number" name="display_order" value="<?= e($row['display_order']??'0') ?>"></div>
    <div class="form-group form-full">
        <div class="checkbox-row"><input type="checkbox" name="show_phone" id="show_phone" <?=($row['show_phone']??0)?'checked':''?>><label for="show_phone" style="margin:0">Show phone on website</label></div>
        <div class="checkbox-row"><input type="checkbox" name="show_email" id="show_email" <?=($row['show_email']??0)?'checked':''?>><label for="show_email" style="margin:0">Show email on website</label></div>
        <div class="checkbox-row"><input type="checkbox" name="is_active" id="is_active" <?=($row['is_active']??1)?'checked':''?>><label for="is_active" style="margin:0">Active (visible on site)</label></div>
    </div>
</div>
<div style="display:flex;gap:8px;margin-top:16px"><button type="submit" class="btn btn-primary"><?= $editing?'Update':'Add' ?></button><a href="<?= e_attr(base_url('admin/staff.php')) ?>" class="btn">Cancel</a></div>
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
    canvas.toBlob(function(blob){
      if(!blob){ alert('<?= ta("Could not save the image.","तस्बिर सुरक्षित गर्न सकिएन।") ?>'); return; }
      uploadFile(blob,function(e,r){
        if(e){ alert(e); return; }
        document.getElementById('staffPhotoPath').value=r.path;
        var pv=document.getElementById('staffPhotoPreview');
        pv.src='<?= e_attr(base_url('')) ?>'+r.path;
        pv.style.display='block';
        staffPhotoCancel();
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
</script>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
