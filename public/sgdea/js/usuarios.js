/* SGDEA · Módulo Usuarios — interacciones visuales (no se guarda ni autentica nada). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var el = $('#usr-data'); if (!el) return;
  var U = JSON.parse(el.textContent);

  function filtrar() {
    var e = $('#usr-f-estado').value, r = $('#usr-f-rol').value;
    $$('#tbl-usuarios tbody tr[data-activo]').forEach(function (tr) {
      var ok = (!e || tr.dataset.activo === e) && (!r || tr.dataset.roles.split('|').indexOf(r) !== -1);
      tr.classList.toggle('is-filtered-out', !ok);
    });
  }
  document.addEventListener('change', function (e) { if (e.target.id === 'usr-f-estado' || e.target.id === 'usr-f-rol') filtrar(); });

  document.addEventListener('change', function (e) {
    if (e.target.classList && e.target.classList.contains('tca-sel')) window.SGDEA.toast('warning', 'Demostración: el nivel de acceso no se guardó. Se heredará a los documentos cuando el backend esté conectado.');
    if (e.target.classList && e.target.classList.contains('perm-chk')) window.SGDEA.toast('warning', 'Demostración: la asignación de permisos no se guardó; la matriz por rol está pendiente de definir.');
  });

  document.addEventListener('click', function (e) {
    var v = e.target.closest('[data-usuario-ver]');
    if (v) {
      var u = U[parseInt(v.getAttribute('data-usuario-ver'), 10)];
      var set = function (k, t) { $('[data-u="' + k + '"]').textContent = t; };
      set('nombre_completo', u.nombre_completo); set('correo', u.correo); set('oficina', u.oficina || 'Sin oficina asignada');
      set('roles', u.roles.join(', ')); set('estado', u.activo ? 'Activa' : 'Inactiva'); set('fecha_creacion', u.fecha_creacion);
      window.SGDEA.openModal('modal-usuario-detalle'); return;
    }
    var n = e.target.closest('[data-usuario-nuevo], [data-usuario-editar]');
    if (n) {
      var f = $('#form-usuario'); f.reset(); $$('.has-error', f).forEach(function (x) { x.classList.remove('has-error'); }); $$('.field-error', f).forEach(function (x) { x.remove(); });
      var idx = n.getAttribute('data-usuario-editar');
      $('#modal-usuario-form .modal-title-text').textContent = idx === null ? 'Nuevo usuario' : 'Editar usuario';
      if (idx !== null) {
        var q = U[parseInt(idx, 10)];
        f.elements['nombre_completo'].value = q.nombre_completo; f.elements['correo'].value = q.correo; f.elements['activo'].checked = q.activo;
        $$('input[name="roles[]"]', f).forEach(function (c) { c.checked = q.roles.indexOf(c.value) !== -1; });
        var un = $('#usr-unidad'); un.value = q.unidad_key || ''; un.dispatchEvent(new Event('change', { bubbles: true }));
        var of = $('#usr-oficina'); if (q.oficina_key) { of.value = q.oficina_key; }
      }
      window.SGDEA.openModal('modal-usuario-form'); return;
    }
    var s = e.target.closest('[data-usuario-estado]');
    if (s) {
      var w = U[parseInt(s.getAttribute('data-usuario-estado'), 10)];
      $('#usr-estado-texto').textContent = (w.activo ? '¿Desactivar' : '¿Activar') + ' la cuenta de «' + w.nombre_completo + '»?';
      window.SGDEA.openModal('modal-usuario-estado');
    }
  });
})();
