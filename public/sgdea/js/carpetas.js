/* SGDEA · Módulos Carpetas y Cierre — interacciones visuales (no se guarda nada). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  function fmt(d) { return (d && /^\d{4}-\d{2}-\d{2}$/.test(d)) ? d.split('-').reverse().join('/') : d; }

  /* Listado de carpetas: filtros combinados */
  var tc = $('#tbl-carp');
  function filtrarCarpetas() {
    var f = { e: $('#cf-estado').value, s: $('#cf-soporte').value, o: $('#cf-oficina').value, a: $('#cf-anio').value };
    $$('tbody tr[data-estado]', tc).forEach(function (tr) {
      var ok = (!f.e || tr.dataset.estado === f.e) && (!f.s || tr.dataset.soporte === f.s) && (!f.o || tr.dataset.oficina === f.o) && (!f.a || tr.dataset.anio === f.a);
      tr.classList.toggle('is-filtered-out', !ok);
    });
  }
  if (tc) document.addEventListener('change', function (e) { if (e.target.closest('#carp-filtros')) filtrarCarpetas(); });

  /* Cierre: pestañas por estado (por defecto, abiertas) */
  var tz = $('#tbl-cierre');
  function filtrarCierre(v) { $$('tbody tr[data-estado]', tz).forEach(function (tr) { tr.classList.toggle('is-filtered-out', !!v && tr.dataset.estado !== v); }); }
  if (tz) filtrarCierre('Abierta');

  document.addEventListener('click', function (e) {
    var f = e.target.closest('[data-cierre-filter]');
    if (f) { $$('[data-cierre-filter]').forEach(function (b) { b.classList.remove('is-active'); }); f.classList.add('is-active'); filtrarCierre(f.getAttribute('data-cierre-filter')); return; }
    var r = e.target.closest('[data-carpeta-rotulo]');
    if (r) {
      var d = JSON.parse($('#carpeta-data').textContent)[parseInt(r.getAttribute('data-carpeta-rotulo'), 10)];
      $$('[data-rot]').forEach(function (el) { var v = d[el.getAttribute('data-rot')]; el.textContent = v == null ? '—' : fmt(v); });
      window.SGDEA.openModal('modal-carpeta-rotulo'); return;
    }
    var c = e.target.closest('[data-cierre-abrir]');
    if (c) {
      $('#cierre-nombre').textContent = c.getAttribute('data-cierre-abrir');
      $('#cierre-ack').checked = false; $('#cierre-ok').disabled = true;
      window.SGDEA.openModal('modal-cierre');
    }
  });

  /* Confirmación de cierre: requiere marcar la casilla */
  document.addEventListener('change', function (e) {
    if (e.target.id === 'cierre-ack') $('#cierre-ok').disabled = !e.target.checked;
    if (e.target.id === 'inc-doc') {
      var o = e.target.options[e.target.selectedIndex], next = parseInt($('#form-incorporar').dataset.nextFolio, 10), n = parseInt(o.getAttribute('data-folios') || '0', 10);
      $('#inc-folios').textContent = (e.target.value && n > 0) ? next + ' – ' + (next + n - 1) : '—';
    }
  });
})();
