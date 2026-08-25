</main>
<script>
function confirmDelete(msg){return confirm(msg||'Are you sure you want to delete this?')}
function flashShow(el,type,msg){
  var d=document.createElement('div');
  d.className='flash flash-'+type;
  d.textContent=msg;
  el.parentNode.insertBefore(d,el);
  setTimeout(function(){d.remove()},4000);
}
document.querySelectorAll('.upload-zone').forEach(function(zone){
  var input=zone.querySelector('input[type=file]');
  if(!input)return;
  zone.addEventListener('click',function(){input.click()});
  zone.addEventListener('dragover',function(e){e.preventDefault();zone.classList.add('dragover')});
  zone.addEventListener('dragleave',function(){zone.classList.remove('dragover')});
  zone.addEventListener('drop',function(e){e.preventDefault();zone.classList.remove('dragover');input.files=e.dataTransfer.files;input.dispatchEvent(new Event('change'))});
});
function uploadFile(file,callback){
  var fd=new FormData();fd.append('file',file);
  fetch('<?= e_attr(base_url("admin/upload.php")) ?>',{method:'POST',body:fd})
    .then(function(r){return r.json()})
    .then(function(r){if(r.ok)callback(null,r);else callback(r.error||'Upload failed')})
    .catch(function(e){callback(e.message||'Network error')});
}

/* ---- Friendly slug generator ---- */
function slugify(text){
  return String(text).toLowerCase()
    .replace(/[नेपाली]/g,'')
    .replace(/[^a-z0-9\s-]/g,'')
    .trim().replace(/[\s_]+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
}

/* ---- Simple rich-text editor (no HTML knowledge needed) ---- */
function initRTE(rte){
  var area=rte.querySelector('.rte-area');
  var hidden=rte.querySelector('input[type=hidden]');
  if(!area||!hidden)return;
  area.innerHTML=hidden.value;
  var count=rte.querySelector('.rte-count');
  function sync(){hidden.value=area.innerHTML;
    if(count){var t=area.innerText.replace(/\s+/g,' ').trim();count.textContent=t?(t.split(' ').length+' words'):'Empty';}
  }
  area.addEventListener('input',sync);
  rte.querySelectorAll('[data-cmd]').forEach(function(btn){
    btn.addEventListener('mousedown',function(e){e.preventDefault();});
    btn.addEventListener('click',function(){
      var cmd=btn.getAttribute('data-cmd'),val=btn.getAttribute('data-val')||null;
      if(cmd==='createLink'){var u=prompt('Paste the link address (https://…)');if(!u)return;val=u;}
      document.execCommand(cmd,false,val);
      area.focus();sync();
    });
  });
  sync();
}
document.querySelectorAll('.rte').forEach(initRTE);

/* ---- Auto-slug: fills slug from title while typing (only if slug untouched/empty) ---- */
document.querySelectorAll('[data-slug-from]').forEach(function(slugInput){
  var titleInput=document.querySelector(slugInput.getAttribute('data-slug-from'));
  if(!titleInput)return;
  var touched=slugInput.value.length>0;
  slugInput.addEventListener('input',function(){touched=true});
  titleInput.addEventListener('input',function(){if(!touched)slugInput.value=slugify(titleInput.value)});
});
</script>
</body>
</html>
