/* SGDEA · Módulo Documentos digitales — interacciones visuales (no se guarda nada). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---- Consulta: filtros combinados ---- */
  var tabla = $('#tbl-doc');
  function aplicar() {
    var a = $('#df-acceso').value, v = $('#df-valid').value, d = $('#df-desde').value, h = $('#df-hasta').value;
    $$('tbody tr[data-acceso]', tabla).forEach(function (tr) {
      var ok = (!a || tr.dataset.acceso === a) && (!v || tr.dataset.valid === v) && (!d || tr.dataset.fecha >= d) && (!h || tr.dataset.fecha <= h);
      tr.classList.toggle('is-filtered-out', !ok);
    });
  }
  if (tabla) document.addEventListener('change', function (e) { if (e.target.closest('#doc-filtros')) aplicar(); });

  /* ---- Detalle: copiar huella ---- */
  document.addEventListener('click', function (e) {
    var c = e.target.closest('[data-copy-hash]'); if (!c) return;
    var txt = $(c.getAttribute('data-copy-hash')).textContent.trim();
    if (navigator.clipboard) navigator.clipboard.writeText(txt).then(function () { window.SGDEA.toast('success', 'Huella copiada.'); }, function () { window.SGDEA.toast('warning', 'No se pudo copiar.'); });
    else window.SGDEA.toast('warning', 'Su navegador no permite copiar automáticamente.');
  });

  /* ---- Registro: información del archivo y vista previa de la huella ---- */
  var inp = $('#doc-archivo'); if (!inp) return;
  var OK = /\.(pdf|tif|tiff|jpe?g|png)$/i;
  function hex(buf) { return Array.prototype.map.call(new Uint8Array(buf), function (b) { return ('0' + b.toString(16)).slice(-2); }).join(''); }
  inp.addEventListener('change', function () {
    var f = inp.files[0], info = $('#doc-info'); if (!f) { info.hidden = true; return; }
    info.hidden = false;
    var ok = OK.test(f.name);
    $('#doc-formato-ok').hidden = !ok; $('#doc-formato-error').hidden = ok;
    $('#doc-mime').textContent = f.type || 'No identificado';
    $('#doc-tam').textContent = f.size > 1048576 ? (f.size / 1048576).toFixed(2) + ' MB' : Math.max(1, Math.round(f.size / 1024)) + ' KB';
    var hh = $('#doc-hash');
    if (!ok) { hh.textContent = 'No calculada (formato no admitido)'; return; }
    if (!(window.crypto && window.crypto.subtle) || f.size > 100 * 1048576) { hh.textContent = 'No calculada en el navegador'; return; }
    hh.textContent = 'Calculando…';
    f.arrayBuffer().then(function (b) { return window.crypto.subtle.digest('SHA-256', b); }).then(function (d) { hh.textContent = hex(d); }, function () { hh.textContent = 'No se pudo calcular'; });
  });
})();
