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
</script>
</body>
</html>
