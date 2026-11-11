/* SGDEA · Módulo CCD — interacciones visuales (árbol, panel de detalle, formularios).
   Todo es demostrativo: no guarda ni consulta nada. */
(function () {
  'use strict';
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var norm = function (t) { return (t || '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase(); };
  var esc = function (t) { return String(t == null ? '' : t).replace(/[&<>"']/g, function (c) { return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]; }); };

  var nodesEl = $('#ccd-nodes'); if (!nodesEl) return;
  var NODES = JSON.parse(nodesEl.textContent);
  var LV = { fondo: 'Fondo documental', unidad: 'Unidad administrativa', oficina: 'Oficina productora', serie: 'Serie documental', subserie: 'Subserie documental', tipo: 'Tipo documental' };
  var HIJO = { fondo: ['unidad'], unidad: ['oficina'], oficina: ['serie'], serie: ['subserie', 'tipo'], subserie: ['tipo'], tipo: [] };
  var CADENA = ['fondo', 'unidad', 'oficina', 'serie', 'subserie'];
  var DISP = { CT: 'Conservación total', E: 'Eliminación', S: 'Selección', D: 'Reproducción por medio', M: 'Microfilmación' };
  var selected = null;

  /* ---- Árbol ---- */
  function setExpanded(li, open) {
    var t = $(':scope > .tree-row > .tree-toggle', li), ul = $(':scope > ul', li);
    if (!t || !ul) return; t.setAttribute('aria-expanded', open ? 'true' : 'false'); ul.hidden = !open;
  }
  document.addEventListener('click', function (e) {
    var tg = e.target.closest('.tree-toggle');
    if (tg) { var li = tg.closest('li'); setExpanded(li, tg.getAttribute('aria-expanded') !== 'true'); return; }
    var b = e.target.closest('[data-node-key]');
    if (b) { select(b.getAttribute('data-node-key'), b); return; }
    if (e.target.closest('[data-tree-expand]')) { $$('#ccd-tree li').forEach(function (li) { setExpanded(li, true); }); return; }
    if (e.target.closest('[data-tree-collapse]')) { $$('#ccd-tree li').forEach(function (li) { setExpanded(li, false); }); var r = $('#ccd-tree > li'); if (r) setExpanded(r, true); return; }
    var ed = e.target.closest('[data-ccd-edit]');
    if (ed) { var n = NODES[ed.getAttribute('data-ccd-edit')]; if (n) openForm(n.nivel, 'edit', n); return; }
    var nw = e.target.closest('[data-ccd-new]');
    if (nw) { openForm(nw.getAttribute('data-ccd-new'), 'add', { ids: {} }); return; }
    var ad = e.target.closest('[data-ccd-add]');
    if (ad) { var p = NODES[ad.getAttribute('data-parent-key')]; if (p) openForm(ad.getAttribute('data-ccd-add'), 'add', p); return; }
    var el2 = e.target.closest('[data-ccd-eliminar]');
    if (el2) { askEliminar(NODES[el2.getAttribute('data-ccd-eliminar')]); return; }
    var st = e.target.closest('[data-ccd-estado]');
    if (st) { askEstado(NODES[st.getAttribute('data-ccd-estado')]); return; }
  });

  /* Búsqueda en el árbol: muestra coincidencias y sus ancestros */
  var q = $('#ccd-tree-search');
  if (q) q.addEventListener('input', function () {
    var term = norm(q.value);
    function visit(li) {
      var rowEl = $(':scope > .tree-row', li); if (!rowEl) { li.hidden = !!term; return false; }
      var own = norm(rowEl.textContent).indexOf(term) !== -1;
      var any = false;
      $$(':scope > ul > li', li).forEach(function (c) { if (visit(c)) any = true; });
      var show = !term || own || any; li.hidden = !show;
      if (term && any) setExpanded(li, true);
      return own || any;
    }
    $$('#ccd-tree > li').forEach(visit);
  });

  /* ---- Panel de detalle ---- */
  function row(k, v) { return '<dt>' + k + '</dt><dd>' + v + '</dd>'; }
  function select(key, btn) {
    var n = NODES[key]; if (!n) return;
    $$('.tree-btn.is-selected').forEach(function (x) { x.classList.remove('is-selected'); });
    if (btn) btn.classList.add('is-selected'); selected = key;
    var h = '<div class="crumbs">' + n.ruta.map(esc).join(' › ') + '</div>';
    h += '<div class="flex between" style="align-items:flex-start"><div><div class="tree-lvl">' + LV[n.nivel] + '</div><h3 style="font-size:1.1rem;color:var(--primary-dark)">' + esc(n.nombre) + '</h3></div>';
    h += '<span class="badge ' + (n.activo ? 'badge-success' : 'badge-neutral') + '">' + (n.activo ? 'Activo' : 'Inactivo') + '</span></div><dl class="dl mt-2">';
    h += row('Código', n.codigo ? '<span class="mono">' + esc(n.codigo) + '</span>' : '<span class="muted">Sin código en el CCD oficial</span>');
    if (n.hijos_label) h += row('Contiene', n.hijos + ' ' + n.hijos_label);
    if (n.soporte !== undefined) h += row('Soporte', n.soporte ? esc(n.soporte) : '<span class="muted">No especificado en el CCD</span>');
    if (n.retencion) {
      var r = n.retencion, hay = r.anios_gestion != null || r.anios_central != null || r.disposicion_final;
      h += row('Retención (TRD)', hay ? 'Gestión: ' + (r.anios_gestion ?? '—') + ' · Central: ' + (r.anios_central ?? '—') + ' · ' + esc((r.disposicion_final || []).join(', ')) : '<span class="muted">Sin parametrizar</span>');
    }
    h += '</dl>';
    if (n.tipos && n.tipos.length) {
      h += '<h4 class="mt-2 small">Tipos documentales</h4><ul class="list-plain">' + n.tipos.map(function (t) { return '<li>' + esc(t.nombre) + '</li>'; }).join('') + '</ul>';
    }
    if (n.sin_oficinas) h += '<div class="alert alert-info mt-2" role="status"><div class="alert-body"><strong>No tiene oficinas productoras asociadas</strong>Para registrar series en esta unidad, primero debe crearse una oficina productora.</div></div>';
    if (n.series_sin_oficina) h += '<div class="alert alert-warning mt-2" role="status"><div class="alert-body">El CCD oficial lista ' + n.series_sin_oficina + ' serie(s) bajo esta unidad con <strong>oficina productora no especificada</strong>. Se muestran en el árbol dentro de la unidad, sin inventarles oficina.</div></div>';
    if (n.oficina_no_especificada && (n.nivel === 'serie' || n.nivel === 'subserie' || n.nivel === 'tipo')) h += '<div class="alert alert-warning mt-2" role="status"><div class="alert-body"><strong>Oficina productora no especificada en el CCD</strong>El CCD oficial registra esta serie directamente bajo la unidad. Queda pendiente confirmar a qué oficina corresponde.</div></div>';
    h += '<div class="flex flex-wrap mt-2">';
    h += '<button type="button" class="btn btn-outline btn-sm" data-ccd-edit="' + esc(key) + '">Editar</button>';
    HIJO[n.nivel].forEach(function (c) { h += '<button type="button" class="btn btn-secondary btn-sm" data-ccd-add="' + c + '" data-parent-key="' + esc(key) + '">Agregar ' + LV[c].toLowerCase() + '</button>'; });
    h += '<button type="button" class="btn btn-ghost btn-sm" data-ccd-estado="' + esc(key) + '">' + (n.activo ? 'Desactivar' : 'Activar') + '</button>';
    h += '<button type="button" class="btn btn-ghost btn-sm" data-ccd-eliminar="' + esc(key) + '">Eliminar</button></div>';
    $('#ccd-detalle').innerHTML = h;
  }

  /* ---- Formularios (prefill visual) ---- */
  function setVal(el, v) { if (!el) return; el.value = v; el.dispatchEvent(new Event('change', { bubbles: true })); }
  function openForm(nivel, modo, node) {
    var m = $('#modal-ccd-' + nivel); if (!m) return;
    var f = $('form', m); f.reset(); $$('.has-error', f).forEach(function (x) { x.classList.remove('has-error'); });
    $$('.field-error', f).forEach(function (x) { x.remove(); });
    $('.modal-title-text', m).textContent = (modo === 'edit' ? 'Editar ' : 'Nuevo/a ') + LV[nivel].toLowerCase();
    var ids = Object.assign({}, node.ids || {}); if (modo === 'edit') delete ids[nivel];
    var sinOf = !!(modo === 'edit' && node.oficina_no_especificada && nivel === 'serie');
    f.dataset.relaxGuard = sinOf ? '1' : '0';
    var nota = $('#serie-nota-sin-oficina', m); if (nota) nota.hidden = !sinOf;
    var selOf = $('#serie-oficina', m); if (selOf) selOf.required = !sinOf;
    $$('[type=submit]', m).forEach(function (b) { b.disabled = false; });
    CADENA.forEach(function (c) { if (ids[c]) setVal($('#' + nivel + '-' + c), ids[c]); });
    if (modo === 'edit') {
      var cod = $('[name=codigo]', f), nom = $('[name=nombre]', f), act = $('[name=activo]', f);
      if (cod) cod.value = node.codigo || ''; if (nom) nom.value = node.nombre || ''; if (act) act.checked = !!node.activo;
      var so = $('[name=tipo_soporte_id]', f); if (so && node.soporte_tipo) so.value = node.soporte_tipo;
      var ef = $('[name=especificacion_formato]', f); if (ef && node.formato) ef.value = node.formato;
    }
    window.SGDEA.openModal('modal-ccd-' + nivel);
  }
  function askEstado(n) {
    if (!n) return;
    $('#ccd-estado-texto').textContent = (n.activo ? '¿Desactivar ' : '¿Activar ') + LV[n.nivel].toLowerCase() + ' «' + n.nombre + '»?';
    var ok = $('#ccd-estado-ok'); ok.setAttribute('data-demo-toast', 'Demostración: el estado no se modificó. La integración con el backend está pendiente.'); ok.setAttribute('data-toast-type', 'warning');
    window.SGDEA.openModal('modal-ccd-estado');
  }

  function askEliminar(n) {
    if (!n) return;
    var hijos = (n.hijos || 0) + (n.series_sin_oficina || 0) + ((n.nivel === 'serie' || n.nivel === 'subserie') ? (n.tipos || []).length : 0);
    var ok = $('#ccd-eliminar-ok'), cuerpo = $('#ccd-eliminar-cuerpo');
    var tit = '<p>' + esc(LV[n.nivel]) + ' «<strong>' + esc(n.nombre) + '</strong>».</p>';
    if (hijos > 0) {
      cuerpo.innerHTML = tit + '<div class="alert alert-error" role="alert"><div class="alert-body"><strong>No se puede eliminar</strong>Existen registros asociados activos (' + hijos + '). Primero debe resolverlos; puede desactivar el registro sin perder el histórico.</div></div>';
      ok.disabled = true;
    } else {
      cuerpo.innerHTML = tit + '<div class="alert alert-warning" role="status"><div class="alert-body">No se encontraron registros asociados en esta demostración. Los expedientes vinculados los verificará el backend (integridad referencial).</div></div>';
      ok.disabled = false;
    }
    window.SGDEA.openModal('modal-ccd-eliminar');
  }

  /* ---- Filtro de estado en tablas ---- */
  document.addEventListener('change', function (e) {
    var f = e.target.closest('[data-table-status]'); if (!f) return;
    $$('tbody tr[data-activo]', $(f.getAttribute('data-table-status'))).forEach(function (tr) {
      tr.classList.toggle('is-filtered-out', !!f.value && tr.getAttribute('data-activo') !== f.value);
    });
  });

  /* Selección inicial: la raíz */
  var first = $('#ccd-tree .tree-btn'); if (first) select(first.getAttribute('data-node-key'), first);
})();
