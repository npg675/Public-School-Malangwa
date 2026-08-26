"use strict";
(function(){
  var header = document.getElementById('siteHeader');
  function onScroll(){
    if(!header) return;
    if(window.scrollY > 8) header.classList.add('scrolled'); else header.classList.remove('scrolled');
  }
  window.addEventListener('scroll', onScroll, {passive:true}); onScroll();

  var navToggle = document.getElementById('navToggle');
  var navClose = document.getElementById('navClose');
  var mobileNav = document.getElementById('mobileNav');
  function openNav(){ if(!mobileNav) return; mobileNav.classList.add('open'); if(navToggle) navToggle.setAttribute('aria-expanded','true'); document.body.style.overflow='hidden'; }
  function closeNav(){ if(!mobileNav) return; mobileNav.classList.remove('open'); if(navToggle) navToggle.setAttribute('aria-expanded','false'); document.body.style.overflow=''; }
  if(navToggle) navToggle.addEventListener('click', openNav);
  if(navClose) navClose.addEventListener('click', closeNav);
  if(mobileNav) mobileNav.querySelectorAll('a, button').forEach(function(a){ if(a.id==='navClose') return; a.addEventListener('click', function(){ closeNav(); }); });
  window.addEventListener('keydown', function(e){ if(e.key==='Escape'){ closeNav(); closeDropdowns(null); } });

  var dropButtons = document.querySelectorAll('.nav-drop-btn');
  function closeDropdowns(except){
    dropButtons.forEach(function(btn){
      if(btn !== except){
        btn.setAttribute('aria-expanded','false');
        btn.parentElement.classList.remove('open');
      }
    });
  }
  dropButtons.forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      var willOpen = btn.getAttribute('aria-expanded') !== 'true';
      closeDropdowns(btn);
      btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      btn.parentElement.classList.toggle('open', willOpen);
    });
  });
  document.addEventListener('click', function(){ closeDropdowns(null); });

  // language toggle
  var langBtn = document.getElementById('langToggle');
  if(langBtn) langBtn.addEventListener('click', function(){
    var cur = document.documentElement.lang === 'ne' ? 'ne' : 'en';
    setLang(cur === 'en' ? 'np' : 'en');
  });
  window.setLang = function(lang){
    document.cookie = 'site_lang=' + lang + '; path=/; max-age=' + (60*60*24*365);
    try{ localStorage.setItem('site_lang', lang);}catch(e){}
    location.reload();
  };
  // persist from localStorage
  try{
    var stored = localStorage.getItem('site_lang');
    if(stored && !document.cookie.includes('site_lang')) document.cookie='site_lang='+stored+'; path=/; max-age=31536000';
  }catch(e){}

  // toast helper
  window.showToast = function(title, msg){
    var toast = document.getElementById('toast');
    if(!toast) return;
    var tt = document.getElementById('toastTitle');
    var tm = document.getElementById('toastMsg');
    if(tt) tt.textContent = title;
    if(tm) tm.textContent = msg;
    toast.classList.add('show');
    clearTimeout(window.__toastTimer);
    window.__toastTimer = setTimeout(function(){ toast.classList.remove('show'); }, 5000);
  };

  // simple form validation hook for demo (actual submit handled server-side)
  document.addEventListener('submit', function(e){
    var form = e.target;
    if(form.hasAttribute('data-no-validate')) return;
    // let server handle if action present; only client toast for demo without action
    if(!form.getAttribute('action') || form.getAttribute('action') === '#'){
      // allow native validation to run via JS
    }
  });

  // Intersection reveal
  var reveals = document.querySelectorAll('.reveal');
  if('IntersectionObserver' in window && reveals.length){
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(en){ if(en.isIntersecting){ en.target.classList.add('in'); io.unobserve(en.target);} });
    }, {threshold:0.12});
    reveals.forEach(function(el){ io.observe(el); });
  } else {
    reveals.forEach(function(el){ el.classList.add('in'); });
  }
})();
