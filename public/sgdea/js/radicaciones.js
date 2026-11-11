/* SGDEA · Módulo Radicación — interacciones visuales (sin guardar nada). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---- Listado: pestañas y filtros combinados ---- */
  var tabla = $('#tbl-rad');
  var tab = '';
  function aplicar() {
    if (!tabla) return;
    var anio = $('#rf-anio').value, ofi = $('#rf-oficina').value, d = $('#rf-desde').value, h = $('#rf-hasta').value;
    $$('tbody tr[data-tipo]', tabla).forEach(function (tr) {
      var ok = (!tab || tr.dataset.tipo === tab) &&
        (!anio || tr.dataset.anio === anio) && (!ofi || tr.dataset.oficina === ofi) &&
        (!d || tr.dataset.fecha >= d) && (!h || tr.dataset.fecha <= h);
      tr.classList.toggle('is-filtered-out', !ok);
    });
  }
  document.addEventListener('click', function (e) {
    var f = e.target.closest('[data-rad-filter]');
    if (f) { $$('[data-rad-filter]').forEach(function (b) { b.classList.remove('is-active'); }); f.classList.add('is-active'); tab = f.getAttribute('data-rad-filter'); aplicar(); return; }
    var c = e.target.closest('[data-rad-comprobante]');
    if (c) {
      var data = JSON.parse($('#rad-data').textContent)[parseInt(c.getAttribute('data-rad-comprobante'), 10)];
      $$('[data-rot]').forEach(function (el) { var v = data[el.getAttribute('data-rot')]; el.textContent = v == null ? '—' : v; });
      window.SGDEA.openModal('modal-rad-comprobante');
    }
  });
  document.addEventListener('change', function (e) { if (e.target.closest('#rad-filtros')) aplicar(); });

  /* ---- Formulario: número de ejemplo y correo del solicitante ---- */
  var form = $('#form-radicacion');
  if (form) {
    var letra = { entrada: 'E', salida: 'S', interna: 'I' };
    var prev = $('#rad-preview'), rol = $('#rad-dep-rol');
    var rolTxt = { entrada: 'receptora', salida: 'remitente', interna: 'remitente o receptora' };
    function actualizar() {
      var t = $('input[name=tipo]:checked', form).value;
      prev.textContent = 'DEMO-___-2026-' + letra[t];
      if (rol) rol.textContent = rolTxt[t];
    }
    form.addEventListener('change', function (e) { if (e.target.name === 'tipo') actualizar(); });
    actualizar();
  }
})();
