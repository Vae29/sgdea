/* SGDEA · Módulo Auditorías — filtros y detalle (solo lectura, visual). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var el = $('#aud-data'); if (!el) return;
  var A = JSON.parse(el.textContent);

  function filtrar() {
    var u = $('#af-usuario').value, a = $('#af-accion').value, t = $('#af-tabla').value, d = $('#af-desde').value, h = $('#af-hasta').value, q = ($('#af-ref').value || '').trim().toLowerCase();
    $$('#tbl-aud tbody tr[data-usuario]').forEach(function (tr) {
      var ok = (!u || tr.dataset.usuario === u) && (!a || tr.dataset.accion === a) && (!t || tr.dataset.tabla === t) && (!d || tr.dataset.fecha >= d) && (!h || tr.dataset.fecha <= h) && (!q || (tr.dataset.ref || '').toLowerCase().indexOf(q) !== -1);
      tr.classList.toggle('is-filtered-out', !ok);
    });
  }
  document.addEventListener('change', function (e) { if (e.target.closest('#aud-filtros')) filtrar(); });
  document.addEventListener('input', function (e) { if (e.target.id === 'af-ref') filtrar(); });
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-aud-limpiar]')) { $$('#aud-filtros select, #aud-filtros input').forEach(function (s) { s.value = ''; }); filtrar(); return; }
    var v = e.target.closest('[data-aud-ver]'); if (!v) return;
    var a = A[parseInt(v.getAttribute('data-aud-ver'), 10)];
    $$('[data-a]').forEach(function (n) { var x = a[n.getAttribute('data-a')]; n.textContent = (x == null || x === '') ? (n.getAttribute('data-a') === 'usuario' ? 'Sin sesión' : '—') : x; });
    var j = function (o) { return o == null ? 'Sin datos' : JSON.stringify(o, null, 2); };
    $('#aud-antes').textContent = j(a.antes); $('#aud-despues').textContent = j(a.despues);
    var box = $('#aud-alerta'); box.innerHTML = '';
    if (a.accion === 'acceso_denegado' || a.accion === 'intento_fallido') {
      box.innerHTML = '<div class="alert alert-' + (a.accion === 'acceso_denegado' ? 'error' : 'warning') + '" role="alert"><div class="alert-body"><strong>Evento crítico</strong>' + (a.accion === 'acceso_denegado' ? 'Se denegó el acceso a un documento restringido.' : 'Falló un intento de autenticación.') + '</div></div>';
    }
    window.SGDEA.openModal('modal-aud-detalle');
  });
})();
