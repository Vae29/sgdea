/* SGDEA · Módulo Inventario FUID — filtros, columnas, totales y rótulo de caja (solo visual). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var tabla = $('#tbl-fuid'); if (!tabla) return;
  tabla.classList.add('fuid', 'hide-otro', 'hide-elec');
  var fmtN = function (n) { return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); };
  var fmtF = function (d) { return d && /^\d{4}-\d{2}-\d{2}$/.test(d) ? d.split('-').reverse().join('-') : (d || '—'); };

  /* Filtros combinados y totales de lo visible */
  function aplicar() {
    var f = { dep: $('#ff-dep').value, anio: $('#ff-anio').value, serie: $('#ff-serie').value, sub: $('#ff-subserie').value, caja: $('#ff-caja').value, fase: $('#ff-fase').value };
    $$('tbody tr[data-anio]', tabla).forEach(function (tr) {
      var ok = (!f.dep || tr.dataset.dep === f.dep || tr.dataset.unidad === f.dep) && (!f.anio || tr.dataset.anio === f.anio) && (!f.serie || tr.dataset.serie === f.serie) &&
        (!f.sub || tr.dataset.subserie === f.sub) && (!f.caja || tr.dataset.caja === f.caja) && (!f.fase || tr.dataset.fase === f.fase);
      tr.classList.toggle('is-filtered-out', !ok);
    });
    var H = JSON.parse($('#fuid-deps').textContent)[f.dep];
    $('#fuid-h-unidad').textContent = f.dep ? (H ? H.unidad_administrativa : f.dep) : 'Todas las dependencias';
    $('#fuid-h-oficina').textContent = f.dep ? (H ? H.oficina_productora : '—') : '—';
    $('#fuid-h-unidad').title = H && H.fuente ? 'Fuente: ' + H.fuente : '';
    totales();
  }
  function totales() {
    var vis = $$('tbody tr[data-anio]', tabla).filter(function (tr) { return !tr.hidden && !tr.classList.contains('is-filtered-out'); });
    var folios = 0, cajas = {};
    vis.forEach(function (tr) { folios += parseInt(tr.dataset.folios, 10) || 0; cajas[tr.dataset.caja] = 1; });
    var set = function (k, v) { var el = $('[data-total="' + k + '"] .stat-value'); if (el) el.textContent = v; };
    set('carpetas', fmtN(vis.length)); set('cajas', fmtN(Object.keys(cajas).length)); set('folios', fmtN(folios));
    $('#fuid-visibles').textContent = vis.length + ' registro(s) visible(s)';
    $('#export-count').textContent = vis.length;
    var em = $('.table-empty', tabla); if (em) em.hidden = vis.length !== 0;
  }
  document.addEventListener('change', function (e) { if (e.target.closest('#fuid-filtros')) aplicar(); });
  document.addEventListener('input', function (e) { if (e.target.closest('[data-table-search="#tbl-fuid"]')) setTimeout(totales, 0); });

  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-fuid-limpiar]')) { $$('#fuid-filtros select').forEach(function (s) { s.value = ''; s.dispatchEvent(new Event('change', { bubbles: true })); }); return; }
    var v = e.target.closest('[data-fuid-ver-caja]');
    if (v) { var s = $('#ff-caja'); s.value = v.getAttribute('data-fuid-ver-caja'); aplicar(); $('#tab-fuid-inv').click(); return; }
    var r = e.target.closest('[data-caja-rotulo]');
    if (r) {
      var c = JSON.parse($('#caja-data').textContent)[parseInt(r.getAttribute('data-caja-rotulo'), 10)];
      $$('[data-rc]').forEach(function (el) { var k = el.getAttribute('data-rc'), x = c[k]; el.textContent = (k.indexOf('fecha') === 0) ? fmtF(x) : (x == null ? '—' : x); });
      var tb = $('#rc-filas'); tb.innerHTML = '';
      c.contenido.forEach(function (f) {
        var tr = document.createElement('tr');
        [f.serie, f.subserie, f.carpeta + ':', f.nombre].forEach(function (t) { var td = document.createElement('td'); td.textContent = t; tr.appendChild(td); });
        tb.appendChild(tr);
      });
      window.SGDEA.openModal('modal-caja-rotulo');
    }
  });

  /* Mostrar u ocultar bloques de columnas del formato */
  document.addEventListener('change', function (e) {
    var c = e.target.closest('[data-fuid-col]'); if (!c) return;
    tabla.classList.toggle('hide-' + c.getAttribute('data-fuid-col'), !c.checked);
  });
  totales();
})();
