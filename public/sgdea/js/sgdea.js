/* SGDEA · EVC E.S.P. — Interacciones visuales (Etapa 1).
   Nada de este archivo guarda información ni se comunica con el backend. */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var norm = function (t) { return (t || '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase(); };
  var DEMO_MSG = 'Demostración del frontend: la información no se guardó. La integración con el backend está pendiente.';

  /* ---- Mensajes temporales ---- */
  function toast(type, msg, ms) {
    var stack = $('#toast-stack'); if (!stack) return;
    var t = document.createElement('div');
    t.className = 'toast ' + (type || 'info'); t.setAttribute('role', 'status');
    t.textContent = msg; stack.appendChild(t);
    setTimeout(function () { t.remove(); }, ms || 5000);
  }

  /* ---- Modales ---- */
  function openModal(id) {
    var m = document.getElementById(id); if (!m) return;
    m.classList.add('is-open'); m.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden';
    var f = $('input,select,textarea,button.btn', m); if (f) f.focus();
  }
  function closeModal(m) {
    if (!m) return; m.classList.remove('is-open'); m.setAttribute('aria-hidden', 'true');
    if (!$('.modal.is-open')) document.body.style.overflow = '';
  }
  window.SGDEA = { toast: toast, openModal: openModal, closeModal: closeModal, DEMO_MSG: DEMO_MSG };

  /* ---- Validación visual de formularios ---- */
  function setError(field, msg) {
    var box = field.closest('.field'); if (!box) return;
    box.classList.add('has-error');
    var e = $('.field-error', box);
    if (!e) { e = document.createElement('div'); e.className = 'field-error'; e.setAttribute('role', 'alert'); box.appendChild(e); }
    e.textContent = msg;
  }
  function clearError(field) {
    var box = field.closest('.field'); if (!box) return;
    box.classList.remove('has-error'); var e = $('.field-error', box); if (e && !e.hasAttribute('data-server')) e.remove();
  }
  function validate(form) {
    var ok = true;
    $$('input,select,textarea', form).forEach(function (el) {
      if (el.disabled || el.type === 'hidden') return;
      clearError(el);
      if (el.required && !el.value.trim()) { setError(el, 'Este campo es obligatorio.'); ok = false; }
      else if (el.value && el.type === 'email' && !el.checkValidity()) { setError(el, 'Ingrese un correo electrónico válido.'); ok = false; }
      else if (el.dataset.match) {
        var o = $(el.dataset.match, form); if (o && o.value !== el.value) { setError(el, 'Las contraseñas no coinciden.'); ok = false; }
      }
    });
    return ok;
  }

  document.addEventListener('submit', function (e) {
    var f = e.target.closest('form[data-demo-form]'); if (!f) return;
    e.preventDefault();
    if (!validate(f)) { toast('error', 'Revise los campos marcados en rojo.'); return; }
    var after = f.getAttribute('data-demo-after');
    toast('warning', f.getAttribute('data-demo-message') || DEMO_MSG, 7000);
    if (after) { var ev = new CustomEvent('demo:submitted', { bubbles: true, detail: after }); f.dispatchEvent(ev); }
  });
  document.addEventListener('input', function (e) { if (e.target.closest && e.target.closest('.field.has-error')) clearError(e.target); });

  /* ---- Clics delegados ---- */
  document.addEventListener('click', function (e) {
    var t = e.target;
    var el;

    if ((el = t.closest('[data-sidebar-toggle]'))) {
      if (window.innerWidth < 992) document.body.classList.toggle('sidebar-open');
      else document.body.classList.toggle('sidebar-collapsed');
      return;
    }
    if (t.closest('[data-sidebar-close]')) { document.body.classList.remove('sidebar-open'); return; }

    if ((el = t.closest('[data-modal-open]'))) { e.preventDefault(); openModal(el.getAttribute('data-modal-open')); return; }
    if ((el = t.closest('[data-modal-close]'))) { closeModal(el.closest('.modal')); return; }

    if ((el = t.closest('[data-demo-toast]'))) {
      e.preventDefault();
      toast(el.getAttribute('data-toast-type') || 'info', el.getAttribute('data-demo-toast'));
      closeModal(el.closest('.modal')); return;
    }
    if ((el = t.closest('[data-pending-route]'))) {
      e.preventDefault();
      toast('info', 'Esta pantalla se entrega en una etapa posterior. Ruta pendiente: ' + el.getAttribute('data-pending-route'));
      return;
    }
    if ((el = t.closest('[data-toggle-target]'))) {
      var tg = $(el.getAttribute('data-toggle-target')); if (tg) tg.hidden = !tg.hidden; return;
    }
    if ((el = t.closest('[data-tab-target]'))) {
      var wrap = el.closest('[data-tabs]'); if (!wrap) return;
      $$('.tab-btn', wrap).forEach(function (b) { b.classList.remove('is-active'); });
      $$('.tab-panel', wrap).forEach(function (p) { p.classList.remove('is-active'); });
      el.classList.add('is-active'); var p = $(el.getAttribute('data-tab-target')); if (p) p.classList.add('is-active'); return;
    }
    if ((el = t.closest('[data-toggle-password]'))) {
      var inp = $(el.getAttribute('data-toggle-password')); if (!inp) return;
      var show = inp.type === 'password'; inp.type = show ? 'text' : 'password';
      el.classList.toggle('is-visible', show); el.setAttribute('aria-label', show ? 'Ocultar contraseña' : 'Mostrar contraseña'); return;
    }
    if ((el = t.closest('[data-dismiss]'))) { var a = el.closest('.alert'); if (a) a.remove(); return; }

    var dd = t.closest('[data-dropdown]');
    $$('[data-dropdown].is-open').forEach(function (d) { if (d !== dd) d.classList.remove('is-open'); });
    if (dd && t.closest('[data-dropdown-trigger]')) dd.classList.toggle('is-open');

    if (t.classList && t.classList.contains('modal-backdrop')) closeModal(t.closest('.modal'));
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { $$('.modal.is-open').forEach(closeModal); $$('[data-dropdown].is-open').forEach(function (d) { d.classList.remove('is-open'); }); }
  });

  /* ---- Búsqueda visual en tablas (sin acentos) ---- */
  document.addEventListener('input', function (e) {
    var inp = e.target.closest('[data-table-search]'); if (!inp) return;
    var table = $(inp.getAttribute('data-table-search')); if (!table) return;
    var q = norm(inp.value), shown = 0;
    $$('tbody tr:not(.table-empty)', table).forEach(function (tr) {
      var m = norm(tr.textContent).indexOf(q) !== -1; tr.hidden = !m; if (m) shown++;
    });
    var empty = $('.table-empty', table); if (empty) empty.hidden = shown !== 0;
  });

  /* ---- Selectores dependientes (datos de demostración en JSON) ---- */
  function fillDependent(child) {
    var parent = document.getElementById(child.getAttribute('data-parent'));
    var src = document.getElementById(child.getAttribute('data-options-from'));
    if (!parent || !src) return;
    var data = {}; try { data = JSON.parse(src.textContent); } catch (err) {}
    var opts = data[parent.value] || [];
    var ph = (parent.value && !opts.length && child.getAttribute('data-empty-text')) ? child.getAttribute('data-empty-text') : (child.getAttribute('data-placeholder') || 'Seleccione…');
    child.innerHTML = '<option value="">' + ph + '</option>' + opts.map(function (o) {
      return '<option value="' + o.value + '">' + o.label + '</option>';
    }).join('');
    child.disabled = !parent.value;
    child.dispatchEvent(new Event('change', { bubbles: true }));
  }
  $$('select[data-parent]').forEach(function (child) {
    var parent = document.getElementById(child.getAttribute('data-parent'));
    if (parent) parent.addEventListener('change', function () { fillDependent(child); });
    fillDependent(child);
  });

  /* ---- Previsualización visual de archivos ---- */
  document.addEventListener('change', function (e) {
    var inp = e.target.closest('input[type=file][data-file-preview]'); if (!inp) return;
    var list = $(inp.getAttribute('data-file-preview')); if (!list) return;
    list.innerHTML = '';
    Array.prototype.forEach.call(inp.files, function (f) {
      var li = document.createElement('li');
      var kb = f.size > 1048576 ? (f.size / 1048576).toFixed(2) + ' MB' : Math.max(1, Math.round(f.size / 1024)) + ' KB';
      if (f.type.indexOf('image/') === 0) { var im = document.createElement('img'); im.src = URL.createObjectURL(f); im.alt = ''; li.appendChild(im); }
      var s = document.createElement('span'); s.textContent = f.name + ' · ' + (f.type || 'tipo desconocido') + ' · ' + kb; li.appendChild(s);
      list.appendChild(li);
    });
  });

  /* ---- Guardia de jerarquía (genérica): sin padre válido no se puede guardar ---- */
  document.addEventListener('change', function (e) {
    var s = e.target; if (!s.matches || !s.matches('select[data-guard]')) return;
    var form = s.closest('form'), any = false;
    if (form.dataset.relaxGuard === '1') { $$('[data-guard-alert]', form).forEach(function (x) { x.hidden = true; }); $$('[type=submit]', form.closest('.modal') || form).forEach(function (b) { b.disabled = false; }); return; }
    $$('select[data-guard]', form).forEach(function (g) {
      var p = document.getElementById(g.getAttribute('data-parent'));
      var blocked = !!(p && p.value) && g.options.length <= 1;
      var al = $('[data-guard-alert="' + g.id + '"]', form); if (al) al.hidden = !blocked;
      if (blocked) any = true;
    });
    $$('[type=submit]', form.closest('.modal') || form).forEach(function (b) { b.disabled = any; });
  });

  /* ---- Pasos de recuperación de contraseña (solo visual) ---- */
  document.addEventListener('demo:submitted', function (e) {
    if (e.detail !== 'next-step') return;
    var cur = e.target.closest('[data-step]'); if (!cur) return;
    var next = document.getElementById(e.target.getAttribute('data-next-step')); if (!next) return;
    cur.hidden = true; next.hidden = false;
  });
})();
