/* SGDEA · Módulo TRD — filtros y detalle (solo visual). */
(function () {
  'use strict';
  var rowsEl = document.getElementById('trd-rows'); if (!rowsEl) return;
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var ROWS = JSON.parse(rowsEl.textContent);
  var esc = function (t) { return String(t == null ? '' : t).replace(/[&<>"']/g, function (c) { return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]; }); };
  var DISP = { CT: 'Conservación total', E: 'Eliminación', S: 'Selección', M: 'Reprografía (HU-GDO-02)', D: 'Reproducción por medio (formato TRD)' };

  /* Filtros combinados */
  function apply() {
    var f = { u: $('#f-unidad').value, o: $('#f-oficina').value, s: $('#f-serie').value, d: $('#f-disp').value, p: $('#f-param').value };
    var shown = 0;
    $$('#tbl-trd tbody tr[data-i]').forEach(function (tr) {
      var ok = (!f.u || tr.dataset.unidad === f.u) && (!f.o || tr.dataset.oficina === f.o) && (!f.s || tr.dataset.serie === f.s) &&
        (!f.d || (' ' + tr.dataset.disp + ' ').indexOf(' ' + f.d + ' ') !== -1) && (!f.p || tr.dataset.param === f.p);
      tr.classList.toggle('is-filtered-out', !ok); if (ok) shown++;
    });
    $('#trd-count').textContent = shown + ' registro(s)';
    var u = $('#f-unidad'), o = $('#f-oficina'), t = 'Todas las dependencias';
    if (o.value && o.selectedIndex > 0) t = o.options[o.selectedIndex].textContent + (u.selectedIndex > 0 ? ' — ' + u.options[u.selectedIndex].textContent : '');
    else if (u.value) t = u.options[u.selectedIndex].textContent;
    $('#trd-dep').textContent = t;
  }
  document.addEventListener('change', function (e) { if (e.target.closest('#trd-filtros')) apply(); });
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-trd-limpiar]')) {
      $$('#trd-filtros select').forEach(function (s) { s.value = ''; s.dispatchEvent(new Event('change', { bubbles: true })); });
      return;
    }
    var d = e.target.closest('[data-trd-detalle]');
    if (d) {
      var r = ROWS[d.getAttribute('data-trd-detalle')], x = r.retencion;
      var h = '<dl class="dl">' +
        '<dt>Código (formato TRD)</dt><dd class="mono">' + esc(r.codigo) + '</dd>' +
        '<dt>Unidad administrativa</dt><dd>' + esc(r.unidad) + '</dd><dt>Oficina productora</dt><dd>' + esc(r.oficina) + '</dd>' +
        '<dt>Serie</dt><dd>' + esc(r.serie) + '</dd><dt>Subserie</dt><dd>' + (r.subserie ? esc(r.subserie) : '<span class="muted">No aplica (retención asociada a la serie)</span>') + '</dd>' +
        '<dt>Retención asociada a</dt><dd>' + esc(r.aplica) + '</dd>' +
        '<dt>Tipo de soporte</dt><dd>' + (r.soportes.length ? esc(r.soportes.join('; ')) : '<span class="muted">No especificado en el CCD</span>') + '</dd>' +
        '<dt>Archivo de gestión</dt><dd>' + (r.anios_gestion != null ? r.anios_gestion + ' años' : '<span class="muted">Sin parametrizar</span>') + '</dd>' +
        '<dt>Archivo central</dt><dd>' + (r.anios_central != null ? r.anios_central + ' años' : '<span class="muted">Sin parametrizar</span>') + '</dd>' +
        '<dt>Disposición final</dt><dd>' + (r.disposicion_final.length ? r.disposicion_final.map(function (k) { return esc(k + ' — ' + (DISP[k] || k)); }).join('; ') : '<span class="muted">Sin parametrizar</span>') + '</dd>' +
        '<dt>Procedimiento</dt><dd>' + (r.procedimiento ? esc(r.procedimiento) : '<span class="muted">Sin parametrizar</span>') + '</dd>' +
        '<dt>Fuente de los valores</dt><dd>' + (r.fuente ? esc(r.fuente) : '<span class="muted">Sin información suministrada</span>') + '</dd>' +
        '<dt>Tipos documentales</dt><dd>' + (r.tipos.length ? '<ul class="list-plain">' + r.tipos.map(function (t) { return '<li>' + esc(t) + '</li>'; }).join('') + '</ul>' : '<span class="muted">No registrados en el CCD</span>') + '</dd></dl>';
      $('#trd-detalle-cuerpo').innerHTML = h;
      $('#trd-detalle-editar').setAttribute('data-trd-editar', d.getAttribute('data-trd-detalle'));
      window.SGDEA.openModal('modal-trd-detalle'); return;
    }
    var ed = e.target.closest('[data-trd-editar]');
    if (ed) {
      var q = ROWS[ed.getAttribute('data-trd-editar')], f = $('#form-trd'); f.reset();
      window.SGDEA.closeModal($('#modal-trd-detalle'));
      [['unidad', q.unidad_key], ['oficina', q.oficina_key], ['serie', q.serie_key], ['subserie', q.subserie_key]].forEach(function (p) {
        var s = $('#trd-form-' + p[0]); if (s && p[1]) { s.value = p[1]; s.dispatchEvent(new Event('change', { bubbles: true })); }
      });
      f.elements['anios_gestion'].value = q.anios_gestion == null ? '' : q.anios_gestion; f.elements['anios_central'].value = q.anios_central == null ? '' : q.anios_central;
      f.elements['disposicion_final'].value = q.disposicion_final[0] || ''; f.elements['procedimiento'].value = q.procedimiento || '';
      window.SGDEA.openModal('modal-trd-form'); return;
    }
    if (e.target.closest('[data-trd-nuevo]')) { $('#form-trd').reset(); window.SGDEA.openModal('modal-trd-form'); }
  });
  apply();
})();
