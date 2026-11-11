/* SGDEA · Módulo Transferencias y disposición — interacciones visuales (no se ejecuta ningún proceso). */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var tr = $('#trf-data'); if (!tr) return;
  var T = JSON.parse(tr.textContent), S = JSON.parse($('#sol-data').textContent);
  var EST = { pendiente: 'Pendiente', proximo: 'Próximo a vencer', vencido: 'Vencido', revision: 'En revisión', aprobado: 'Aprobado', rechazado: 'Rechazado', transferido: 'Transferido' };
  var TONO = { pendiente: 'neutral', revision: 'info', aprobado: 'success', rechazado: 'danger', transferido: 'dark' };
  var esc = function (t) { return String(t == null ? '' : t).replace(/[&<>"']/g, function (c) { return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]; }); };
  var fill = function (attr, o) { $$('[' + attr + ']').forEach(function (n) { var v = o[n.getAttribute(attr)]; n.textContent = (v == null || v === '') ? '—' : v; }); };

  document.addEventListener('click', function (e) {
    var f = e.target.closest('[data-sem-filter]');
    if (f) {
      $$('[data-sem-filter]').forEach(function (b) { b.className = 'btn btn-sm btn-outline'; }); f.className = 'btn btn-sm btn-secondary';
      var v = f.getAttribute('data-sem-filter');
      $$('#tbl-alertas tbody tr[data-sem]').forEach(function (r) { r.classList.toggle('is-filtered-out', !!v && r.dataset.sem !== v); }); return;
    }
    var t = e.target.closest('[data-trf-ver]'), a = e.target.closest('[data-acta-ver]');
    if (t || a) {
      var x = T[parseInt((t || a).getAttribute(t ? 'data-trf-ver' : 'data-acta-ver'), 10)];
      x.ruta = x.fase_origen + ' → ' + x.fase_destino; x.estado_label = EST[x.estado];
      var items = x.items.map(function (i) { return '<li>' + esc(i.carpeta) + (i.notas ? ' <span class="muted small">— ' + esc(i.notas) + '</span>' : '') + '</li>'; }).join('');
      if (t) { fill('data-t', x); $('#trf-items').innerHTML = items; window.SGDEA.openModal('modal-trf-detalle'); }
      else { fill('data-ac', x); $('#acta-items').innerHTML = items; window.SGDEA.openModal('modal-acta'); }
      return;
    }
    var s = e.target.closest('[data-sol-ver]');
    if (s) {
      var y = S[parseInt(s.getAttribute('data-sol-ver'), 10)]; y.estado_label = EST[y.estado]; fill('data-s', y);
      $('#sol-historico').hidden = y.disposicion_aplicada !== 'Eliminado';
      var ap = y.aprobaciones.map(function (p, i) {
        return '<li><span class="badge badge-' + (TONO[p.estado] || 'neutral') + '">' + esc(EST[p.estado] || p.estado) + '</span><div>' + (i + 1) + '.º visto bueno — ' + esc(p.aprobado_por || 'Pendiente de asignar') +
          (p.comentarios ? '<div class="small muted">' + esc(p.comentarios) + '</div>' : '') + (p.fecha_hora ? '<div class="small muted">' + esc(p.fecha_hora) + '</div>' : '') + '</div></li>';
      }).join('');
      $('#sol-aprobaciones').innerHTML = ap || '<li class="muted">Sin aprobaciones registradas.</li>';
      window.SGDEA.openModal('modal-sol-detalle');
    }
  });

  /* La eliminación exige acta del Comité de MIPG */
  document.addEventListener('change', function (e) {
    if (e.target.id !== 'disp-tipo') return;
    var el = e.target.value === 'Eliminación';
    $('#disp-acta').hidden = !el; $('#disp-num').required = el; $('#disp-ref').required = el;
    $$('#disp-acta .req').forEach(function (n) { n.remove(); });
  });
  var chip = $('[data-sem-filter=""]'); if (chip) chip.className = 'btn btn-sm btn-secondary';
})();
