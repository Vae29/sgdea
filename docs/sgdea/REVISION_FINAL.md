# SGDEA · Revisión final del frontend

**Alcance:** revisión del frontend entregado, siguiendo las aclaraciones de la empresa. Sin backend, sin base de datos y sin rutas definitivas.
**Fuente oficial de requerimientos:** `274-2026E.pdf` (10 historias de usuario). CCD, TRD, FUID, rótulos y modelo de datos se usan para representar la información de la empresa.
**Regla aplicada:** no se inventan datos, códigos, relaciones ni reglas; cuando los documentos difieren, se conserva cada fuente y se documenta la diferencia.

## Listado de cambios de esta revisión

Solo frontend: no se creó ni modificó backend, base de datos, rutas, controladores ni modelos.

### 1. CCD (HU-GDO-01)
- **Se conservan las 43 series (110 subseries) que el CCD lista sin oficina productora.** Aparecen en el árbol bajo su unidad, con la indicación «Oficina productora no especificada en el CCD», en las tablas y en el panel de detalle. No se inventó ninguna oficina.
- Los datos del CCD se regeneraron para incluir esas series y la retención que el CCD sí trae (5 subseries).
- Las unidades sin oficinas conservan el mensaje «No tiene oficinas productoras asociadas».
- Se mantiene la regla de modelo: las series **nuevas** requieren oficina; al editar una serie sin oficina el campo no es obligatorio y se muestra una nota.
- Nuevo: **Eliminar** con bloqueo por registros asociados (HU-GDO-01).
- Nuevo: soporte del tipo documental como Físico / Electrónico (incluye audiovisual y fotográfico) / Híbrido (HU-GDO-02).
- Se documentó en pantalla la diferencia entre la jerarquía de la HU-GDO-01 y la del CCD.

### 2. TRD (HU-GDO-02)
- Módulo **general**: 254 registros de todas las unidades y oficinas, incluidas las series sin oficina. TRD_30 se trata como ejemplo del formato.
- Columnas del formato TRD: código, serie, subserie, tipo de soporte, años de gestión y central, disposición, procedimiento.
- Encabezado del formato TRD y fuente de los valores («CCD oficial»).
- Disposición con CT, E, S, **M** (HU) y **D** (TRD), cada una con su fuente; gestión ≥ 1 y central ≥ 0 como en la HU.
- Nueva pestaña con la tabla de diferencias HU / formato TRD.
- Se retiró el aviso que presentaba la TRD como exclusiva de Planta de Beneficio Animal.

### 3. FUID (HU-GDO-09)
- **Filtro por fase** (Gestión, Central, Histórico y «No especificada en el FUID»).
- Inventario **general**: el filtro de dependencia lista todas las unidades y oficinas del CCD y es jerárquico; el encabezado del formato cambia con la dependencia; las cajas se agrupan por dependencia; mensaje cuando una dependencia no tiene registros.
- Datos de ejemplo: los 106 registros del FUID entregado más 9 carpetas de Contabilidad del rótulo de caja (marcadas como demostración).
- El detalle del registro muestra la fase y el origen.

### 4. Radicación (HU-GDO-03)
- Se **retiró lo que la historia no pide**: marca «PQRSDF», pestaña PQRSDF y filtro. Se añadió una nota: las PQRSDF se radican por el mismo flujo y sus detalles están pendientes de definición.
- El correo del solicitante queda siempre disponible.
- La dependencia se presenta como remitente o receptora según el tipo y se asocia al usuario que radica.

### 5. Otras historias
- **HU-GDO-05:** descarga consolidada del expediente y visor de documentos en el detalle de carpeta.
- **HU-GDO-06:** el modal de cierre menciona el estado de expediente cerrado, el inicio del conteo de retención, el sello SHA-256 y la bitácora.
- **HU-GDO-07:** tabla de nivel de acceso por serie y subserie (336 filas) y matriz de permisos por rol (23 permisos × 5 roles, sin asignar).
- **HU-GDO-08:** filtro por radicado o expediente, «Tipo de evento» como etiqueta del filtro, y agente de usuario en el detalle.
- **HU-GDO-10:** disposición aplicada «Eliminado (registro histórico)» y botón de FUID de transferencia.
- Los selectores de documentos, carpetas y TRD ofrecen «Oficina productora no especificada en el CCD» para poder trabajar con esas series.

### 6. Archivos
- **Nuevo:** `docs/sgdea/REVISION_FINAL.md`.
- **Reescritos:** los presentadores `ccd.php` y `trd.php`; **ajustado:** `fuid.php`. **Datos regenerados:** `demo/ccd.php` y `demo/fuid.php`.
- **Modificados:** vistas `ccd` (index, tree-node, tabla-nivel, modales), `trd/index`, `fuid` (index, show), `radicaciones` (index, create, show), `documentos/create`, `carpetas` (create, show), `cierre/partials/modal-cierre`, `usuarios/index`, `auditorias/index`, `transferencias/index`; JavaScript `sgdea.js`, `ccd.js`, `trd.js`, `fuid.js`, `radicaciones.js`, `usuarios.js`, `auditorias.js`, `transferencias.js`; `sgdea.css`; datos demo de radicaciones, auditorías y transferencias.
- Sin cambios en el diseño visual, los componentes, el layout, el login, la recuperación y el dashboard.

### 7. Verificación
- 46 vistas Blade compiladas con el compilador de Laravel 11 y 28 renderizados (21 pantallas y sus variantes) sin errores.
- Pruebas de comportamiento sobre el HTML renderizado: las anteriores (actualizadas) y 44 comprobaciones nuevas de esta revisión.
- No se probó la apariencia en un navegador real.

---

## Cuadro de cumplimiento de las 10 historias de usuario (274-2026E.pdf)

**Cómo leerlo:** «Completo» significa que la interfaz representa lo solicitado en la historia; la lógica real (guardado, cálculos, archivos, permisos) sigue siendo trabajo del backend. «Parcial» indica que una parte depende de una definición de la empresa. «Pendiente de información» indica datos que no fueron suministrados.

| HU | Historia | Pantallas | Estado | Pendiente (referencia) |
|---|---|---|---|---|
| **HU-GDO-01** | Administración del CCD | `ccd.index` | **Completo** | Diferencia con la jerarquía genérica y tratamiento de las 43 series sin oficina (C1, C2, D1) |
| **HU-GDO-02** | Parametrización de la TRD | `trd.index`, `ccd.index` (soporte de tipos) | **Completo** (interfaz) · **Pendiente de información** (valores) | Años y disposición de 249 de 254 registros (B1); convención M/D y asociación a serie o subserie (C4, C5) |
| **HU-GDO-03** | Radicación de comunicaciones | `radicaciones.index/create/show` | **Completo** | Tipos, plazos y estados de PQRSDF no definidos (B13, D7); segunda dependencia en comunicaciones internas |
| **HU-GDO-04** | Registro de documentos digitales | `documentos.index/create/show` | **Completo** | Peso máximo del archivo (B4); tipos documentales faltantes (B10) |
| **HU-GDO-05** | Conformación de expedientes | `carpetas.index/create/show` | **Completo** | — (visor, descarga e índice son diseño; funcionan con el backend) |
| **HU-GDO-06** | Cierre de expedientes | `cierre.index/show` | **Completo** | Fecha estimada de transferencia «No calculable» hasta tener retención (B1) |
| **HU-GDO-07** | Usuarios y niveles de confidencialidad | `usuarios.index` | **Parcial** | Matriz de permisos por rol sin asignar (B6, D9); dónde se guarda el nivel por serie/subserie (C12, D6); texto de reserva legal (B7) |
| **HU-GDO-08** | Auditoría | `auditorias.index` | **Completo** | `user_agent` sin columna en el modelo (C11); catálogo de acciones (B11) |
| **HU-GDO-09** | Inventario FUID | `fuid.index/show` | **Completo** (incluye filtro por fase) | Fase de los registros entregados (B8, C10); columnas sin soporte en el modelo (D11) |
| **HU-GDO-10** | Transferencias, alertas y disposición final | `transferencias.index` | **Parcial** | Semáforos manuales mientras falte la retención (B1); estados oficiales y formato del acta (B5, C13, D8) |

### Detalle por historia

**HU-GDO-01** — Árbol jerárquico y tablas por nivel (unidades, oficinas, series, subseries y tipos); formularios con selectores en cascada; activar o desactivar; **eliminar con bloqueo** («existen registros asociados activos»); las series sin oficina productora se conservan con la indicación «Oficina productora no especificada en el CCD».

**HU-GDO-02** — Código, serie y subserie, tipo de soporte, años en gestión y central, disposición final y procedimiento; formulario con gestión ≥ 1 y central ≥ 0 (obligatorios) y la disposición con CT, E, S, M y D; soporte de los tipos documentales (físico, electrónico o híbrido); tabla de convenciones HU / TRD. Módulo **general** para todas las unidades y oficinas.

**HU-GDO-03** — Tres tipos de comunicación, número de ejemplo, remitente y destinatario, dependencia (se asocia al usuario que radica), radicado padre/hijo, archivo adjunto, rótulo con QR y comprobante. Las PQRSDF se radican por este mismo flujo.

**HU-GDO-04** — Archivo con formato admitido, vinculación obligatoria a un tipo documental (sin huérfanos), seis metadatos mínimos, contexto de carga automático, estado de validación con 4 criterios, huella SHA-256 e integridad.

**HU-GDO-05** — Apertura con retención heredada, orden de incorporación con foliación consecutiva, índice provisional exportable (PDF/A y JSON), carpetas híbridas, rótulo, visor y descarga del expediente.

**HU-GDO-06** — Confirmación con casilla de aceptación y advertencia de irreversibilidad, insignia de expediente cerrado, fecha de cierre, índice definitivo con huella y estimación de transferencia.

**HU-GDO-07** — Usuarios con roles, estado y oficina; los cinco roles; niveles Pública, Clasificada y Reservada con conteos; **tabla de nivel de acceso por serie y subserie**; **matriz de permisos por rol**; mensaje de acceso denegado con fundamento normativo.

**HU-GDO-08** — Tabla de eventos con filtros (usuario, tipo de evento, tipo de recurso, fechas, **radicado o expediente**), resaltado de accesos denegados e intentos fallidos, detalle con información anterior/posterior y **agente de usuario**, exportación a CSV, sin edición ni borrado.

**HU-GDO-09** — Encabezado del formato FUID (cambia con la dependencia), totales dinámicos, filtros por **dependencia (todas las unidades y oficinas del CCD)**, año, serie, subserie, caja y **fase (Gestión, Central, Histórico)**, todas las columnas del formato, detalle, cajas, resúmenes, rótulos de caja y de carpeta y exportación visual.

**HU-GDO-10** — Panel de métricas y semáforo, alertas, transferencias con detalle, actas, **FUID de transferencia**, paquete, disposición con acta del Comité de MIPG, doble visto bueno y **baja con registro histórico**.

---

## Clasificación de hallazgos y decisiones

La fuente oficial de requerimientos es `274-2026E.pdf` (10 historias de usuario). Los demás documentos (CCD, TRD, FUID, rótulos físicos y modelo de datos) explican cómo se organiza la información. **No hace falta resolver todo antes de continuar:** el frontend ya representa lo solicitado y deja preparada la interfaz para la información pendiente.

### A. Funcionalidades claramente solicitadas en las historias de usuario (se conservan aunque falten datos de ejemplo)

Todas están representadas visualmente; la lógica real queda para el backend.

- **HU-01:** administración visual de la jerarquía documental, selectores en cascada, activar/inactivar sin perder histórico y bloqueo de eliminación cuando hay registros asociados.
- **HU-02:** años en archivo de gestión y central, disposición final, procedimiento/justificación y soporte de los tipos documentales (físico, electrónico o híbrido).
- **HU-03:** radicación de entrada, salida e interna con consecutivo anual, rótulo digital con QR, vínculo padre/hijo y correo del solicitante.
- **HU-04:** carga de documentos con metadatos mínimos, nivel de acceso, huella SHA-256, formatos PDF/A, TIFF, JPG y PNG, y vínculo obligatorio (sin documentos huérfanos).
- **HU-05:** apertura de carpetas con retención heredada, orden de incorporación, foliación, índice exportable, visor y descarga consolidada del expediente.
- **HU-06:** cierre irreversible con advertencia, insignia «Expediente de Archivo (Cerrado)», índice definitivo sellado y huella.
- **HU-07:** usuarios, los cinco roles, permisos por rol, niveles Pública, Clasificada y Reservada (configurables por serie/subserie) y mensaje de acceso denegado con fundamento normativo.
- **HU-08:** bitácora de solo lectura con filtros (usuario, tipo de evento, fechas, radicado o expediente), detalle con información anterior y posterior, eventos críticos y exportación a CSV.
- **HU-09:** inventario FUID por dependencia, año, serie, subserie y **fase (Gestión, Central, Histórico)**, con exportación a Excel, CSV y PDF.
- **HU-10:** alertas con semáforo, transferencias con acta, FUID de transferencia y paquete, y disposición final con acta del Comité de MIPG, doble visto bueno y registro histórico de la baja.

### B. Información que la empresa no ha suministrado (no se inventa; la interfaz muestra «Sin parametrizar» o «Información pendiente»)

| # | Información | Cómo queda en la interfaz |
|---|---|---|
| B1 | Años de retención y disposición final: solo 5 de los 254 registros de serie/subserie del CCD los traen | «Sin parametrizar»; los 5 existentes se muestran con su fuente (CCD oficial) |
| B2 | Resolución de aprobación de la TRD | «Información pendiente» en el encabezado de la TRD |
| B3 | Código del fondo documental | Se deja vacío («Sin código en el CCD oficial») |
| B4 | Peso máximo del archivo (HU-GDO-04 exige validarlo, pero no da el valor) | Texto «lo definirá el backend» |
| B5 | Formato oficial del acta de transferencia | Vista informativa provisional |
| B6 | Matriz de permisos por rol | Casillas sin asignar |
| B7 | Texto de la reserva legal por nivel de acceso | Mensaje genérico con la Ley 1712 de 2014 (arts. 18 y 19) y la Ley 1581 de 2012 citadas por la HU |
| B8 | Fase del archivo de los 106 registros del FUID entregado | «No especificada en el FUID» (filtro disponible) |
| B9 | Datos del FUID de otras dependencias (folios, fechas) | Solo 9 carpetas de Contabilidad tomadas del rótulo de caja, marcadas como demostración |
| B10 | Tipos documentales: el CCD solo registra 70 en total | Se muestran los existentes; el formulario permite registrar los faltantes |
| B11 | Catálogo definitivo de acciones de auditoría | Vocabulario de demostración basado en la HU-08 |
| B12 | Ubicación topográfica (número de caja en archivo central, estante, entrepaño) | Líneas en blanco en el rótulo de caja |
| B13 | Tipos, plazos y estados propios de PQRSDF: la HU-03 no los define | Se radican por el flujo general; correo del solicitante; nota «pendiente de definición» |

### C. Contradicciones entre los documentos (se conserva cada fuente; no se corrigió nada)

| # | Contradicción | Fuentes |
|---|---|---|
| C1 | La HU-01 describe *Fondo, Sección, Subsección, Serie, Subserie, Tipo documental*; el CCD usa *Fondo, Unidad administrativa, Oficina productora, Serie, Subserie, Tipo documental*. Se representa el CCD y se documenta la diferencia | HU-GDO-01 / CCD |
| C2 | El CCD lista 43 series (110 subseries) bajo una unidad con el código de oficina vacío, y el modelo exige `oficina_productora_id` en las series | CCD / modelo de datos |
| C3 | Planta de Beneficio Animal (30): *unidad administrativa* en el CCD; *oficina productora del Área Administrativa* en el encabezado del FUID; «dependencia» en los rótulos; *oficina productora* en la TRD_30 | CCD / FUID / rótulos / TRD |
| C4 | Disposición final: la HU usa **CT, E, S y M (Reprografía)**; la TRD y el CCD usan **CT, E, D y S**, donde D es reproducción por medio (M, D, R u O) | HU-GDO-02 / TRD / CCD |
| C5 | La HU liga la retención a cada *subserie*; la TRD y el CCD la admiten también en la *serie* | HU-GDO-02 / TRD / CCD |
| C6 | Notación de códigos: `30.08-02` (TRD), `30.26.05` (rótulo de carpeta) y `51.09-01` (rótulo de caja) | TRD / rótulos |
| C7 | El rótulo de carpeta de ejemplo 1 usa `30.26.05` para «Estadísticas de Sacrificio (Porcinos)» y el CCD asigna `30.26-03`; el ejemplo 2 usa `50-10-01` con un nombre distinto al del CCD | Rótulos / CCD |
| C8 | Correlativo de carpetas: `(1/2)` en el FUID y `(1-2)` en el rótulo de caja | FUID / rótulo |
| C9 | FUID entregado: 3 totales de folios que no coinciden con el rango, 1 fecha final anterior a la inicial, errores de digitación y la columna «NÚMERO ORDEN» con «REVISADO» en todas las filas | FUID |
| C10 | La HU-09 pide filtrar por fase; el formato FUID de Excel no tiene columna de fase | HU-GDO-09 / FUID |
| C11 | La HU-08 pide guardar `user_agent`; la tabla `auditorias` no tiene esa columna | HU-GDO-08 / modelo |
| C12 | La HU-07 pide el nivel de acceso por serie/subserie; el modelo lo guarda solo en carpetas y documentos | HU-GDO-07 / modelo |
| C13 | Estados de transferencia: la HU propone borrador, enviada, recibida_archivo_central y rechazada; la interfaz usa los estados solicitados por usted (Pendiente, En revisión, Aprobado, Rechazado, Transferido, y los semáforos) | HU-GDO-10 / solicitud |
| C14 | Modelo de datos: `consecutivos_radicacion.tipo_mime` parece ser `tipo`; `item_tranferencia_id` tiene un error de digitación; `unidad_administrativa_id` admite nulo; el código del FUID aparece como «-12.1» | Modelo / FUID |

### D. Decisiones de negocio que sí requieren confirmación de la empresa

Ninguna impide avanzar con el frontend. Se necesitan antes de cerrar el modelo de datos y la integración.

| # | Decisión | Por qué importa |
|---|---|---|
| D1 | ¿A qué oficina productora pertenecen las 43 series sin oficina, o se admitirán series directas de la unidad? (C2) | Determina si el modelo debe cambiar; hoy no se pueden guardar nuevas series sin oficina |
| D2 | Alumbrado Público (20), Planta de Beneficio Animal (30) y Administración de Bienes Fiscales (40): ¿son unidades sin oficinas, o su oficina productora es la misma unidad? (C3) | Radicaciones, carpetas y usuarios exigen oficina productora |
| D3 | Convención de disposición final: M (HU) o D (TRD) (C4) | Define el catálogo del campo `disposicion_final` |
| D4 | Retención a nivel de subserie o también de serie, y regla «gestión ≥ 1» (C5) | Define la tabla `retencion_documental` y las validaciones |
| D5 | Notación oficial de códigos de serie y subserie (C6, C7) | Rótulos, TRD y FUID deben usar una sola |
| D6 | Dónde se guarda el nivel de acceso por serie/subserie (C12) | Requiere columna o tabla nueva en una etapa posterior |
| D7 | Si se necesita identificar o tratar de forma especial las PQRSDF (B13) | Solo si la empresa lo requiere; la HU no lo pide |
| D8 | Estados oficiales de transferencia y formato del acta (B5, C13) | Define el flujo y el documento generado |
| D9 | Matriz de permisos por rol (B6) | Define el control de acceso |
| D10 | Peso máximo de archivo (B4) | Validación de la carga |
| D11 | Columnas del FUID sin soporte en el modelo: notas, correlativo, otro (tipo y cantidad), ubicación electrónica, fase y huella del índice | Necesario para exportar el FUID completo |
| D12 | Responsable de revisar y corregir los datos del FUID entregado (C9) | Calidad del inventario inicial |
