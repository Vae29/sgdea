# SGDEA · Contrato entre el frontend y el backend

**Sistema:** Sistema de Gestión Documental Electrónica de Archivo (SGDEA) — Empresas Varias de Caicedonia E.V.C. – E.S.P.
**Alcance de este documento:** describe lo que entrega el frontend (Laravel Blade) y lo que el backend deberá implementar después.
**Regla de esta etapa:** no se creó ninguna ruta, controlador, modelo, migración, política, middleware ni consulta. Todo lo que aquí se llama «ruta sugerida» está **por crear**.

---

## 1. Cómo leer este contrato

### 1.1 Datos de demostración y datos reales

Cada vista declara al inicio las variables que espera recibir del controlador. Si la variable no llega, usa datos de demostración:

```blade
@php
    $radicaciones = $radicaciones ?? require resource_path('sgdea/demo/radicaciones.php');
    $esDemo = $esDemo ?? true;
@endphp
```

- Cuando el controlador pase la variable, los datos de demostración se ignoran solos.
- Pase `$esDemo = false` para ocultar los avisos «Datos de demostración» de cada pantalla.
- Los datos de demostración viven aparte, en `resources/sgdea/demo/`. Una vez integrado el backend esa carpeta se puede eliminar.
- Los **presentadores** (`resources/sgdea/presenters/*.php`) son funciones PHP puras que reorganizan arreglos para la vista (árbol del CCD, índice de carpetas, totales del FUID). No consultan nada. El backend puede reutilizarlos o entregar los datos ya organizados.

### 1.2 Convenciones de nombres

| Elemento | Convención |
|---|---|
| Vistas | `resources/views/sgdea/{módulo}/{pantalla}.blade.php` (ej. `sgdea.radicaciones.create`) |
| Componentes | `<x-sgdea.nombre>` en `resources/views/components/sgdea/` |
| Nombres de ruta sugeridos | `sgdea.{módulo}.{acción}` (ej. `sgdea.carpetas.show`) |
| Campos de formularios | Los nombres de columna del modelo de datos (`oficina_productora_id`, `nivel_acceso`, …) |
| Campos `filtro_*` | Solo sirven para encadenar selectores (unidad → oficina → serie). **No se guardan.** |

### 1.3 Enlaces entre pantallas

Los botones y el menú resuelven la ruta con `Route::has()`. Si la ruta con ese nombre existe, el enlace funciona; si no, se muestra como «pendiente» sin producir error. Basta con **registrar las rutas con los nombres sugeridos** para que la navegación se active sola.

### 1.4 Selectores dependientes

Los selectores encadenados (unidad → oficina → serie → subserie → tipo documental) leen sus opciones de bloques JSON incrustados en la página:

```html
<script type="application/json" id="opt-oficinas">{"<unidad>":[{"value":"<id>","label":"12 · Secretaria"}]}</script>
```

| Id del bloque | Clave del objeto | Contenido de cada opción |
|---|---|---|
| `opt-unidades` | id del fondo | unidades administrativas del fondo |
| `opt-oficinas` | id de la unidad administrativa | oficinas productoras reales de esa unidad |
| `opt-oficinas-ext` | id de la unidad administrativa | oficinas reales **más** la opción «Oficina productora no especificada en el CCD» (valor `sin:{unidad}`, que **no es un id**) cuando la unidad tiene series sin oficina; se usa en TRD, documentos y carpetas |
| `opt-series` | id de la oficina productora (o `sin:{unidad}` para las series sin oficina especificada) | series de esa oficina |
| `opt-subseries` | id de la serie | subseries de esa serie |
| `opt-tipos` | id de la serie | tipos documentales de la serie (con su subserie en la etiqueta) |
| `opt-fuid-subseries` | código de la serie | subseries (solo en el inventario FUID) |

Hoy los `value` son llaves de demostración como `u:10` u `o:10:12`; el backend debe poner los **identificadores reales** (`unidad_administrativa_id`, `oficina_productora_id`, …). Alternativa: reemplazar los bloques por consultas AJAX (`sgdea.ccd.opciones`, ver §4.3) conservando el mismo formato de respuesta.

**Regla jerárquica aplicada en el frontend:** las series **nuevas** se vinculan a una oficina productora (modelo de datos actual), y esa validación debe repetirse en el backend. Las 43 series que el CCD oficial lista sin oficina se **conservan y se muestran** como «Oficina productora no especificada en el CCD»; no se les inventó oficina. Cómo guardarlas es la decisión D1 (sección 5).

### 1.5 Mensajes y errores

- Formularios: el componente `x-sgdea.field` muestra `old($name)` y `$errors->first($name)` automáticamente.
- Mensajes de sesión que reconoce el layout: `session('success')`, `session('warning')`, `session('error')`, y `$errors->any()`.
- Tras el guardado real, el controlador debe redirigir con uno de esos mensajes.

### 1.6 Qué retirar al integrar

1. `<x-sgdea.demo-banner />` en `sgdea/layouts/app.blade.php`.
2. El atributo `data-demo-form` y `action="#"` de cada formulario (poner la ruta real).
3. Los botones con `data-demo-toast` (acciones visuales) → reemplazarlos por su acción real.
4. La carpeta `resources/sgdea/demo/` y las variables `$esDemo`.
5. El texto «Pantalla de demostración visual» de `layouts/auth.blade.php`.

---

## 2. Inventario de archivos del frontend

**Públicos** (`public/sgdea/`): `css/sgdea.css`, `img/logo-evc.png`, y `js/`: `sgdea.js` (global), `ccd.js`, `trd.js`, `radicaciones.js`, `documentos.js`, `carpetas.js` (también cubre Cierre), `fuid.js`, `usuarios.js`, `auditorias.js`, `transferencias.js`.

**Blade** (`resources/views/`): 11 componentes en `components/sgdea/` (`icon`, `button`, `card`, `stat-card`, `badge`, `alert`, `modal`, `field`, `table`, `page-header`, `demo-banner`); layouts `sgdea/layouts/{app,auth}`; parciales `sgdea/partials/{sidebar,topbar,flash,json-options}`; y las vistas por módulo listadas en la sección 4.

**Datos y presentadores** (`resources/sgdea/`): `navigation.php`, `demo/*.php` (10 archivos), `presenters/{ccd,trd,carpetas,fuid}.php`.

**Dependencias:** ninguna (no usa Vite, npm ni paquetes). Requiere Laravel 9 o superior.

---

## 3. Elementos transversales

### 3.1 Layout principal (`sgdea.layouts.app`)

| Elemento | Detalle |
|---|---|
| Secciones que cada vista define | `title`, `subtitle` (opcional), `module` (clave del menú activo), `content` |
| Pilas | `styles`, `modals`, `scripts` |
| Variables opcionales | `$usuarioActual` (`nombre_completo`, `rol`, `oficina`), `$notificaciones` (lista de `tono`, `texto`, `tiempo`) |
| Menú | `resources/sgdea/navigation.php` (claves: `dashboard`, `ccd`, `trd`, `radicaciones`, `documentos`, `carpetas`, `cierre`, `fuid`, `transferencias`, `usuarios`, `auditorias`) |

**Backend:** entregar `$usuarioActual` y `$notificaciones` (puede ser con un View Composer sobre `sgdea.partials.topbar`). Filtrar el menú según los permisos del usuario.

### 3.2 Estados visuales (componente `badge`)

Claves aceptadas por `<x-sgdea.badge status="…">`: `pendiente`, `proximo`, `vencido`, `revision`, `aprobado`, `rechazado`, `transferido`, `vigente`, `activo`, `inactivo`, `abierta`, `cerrada`, `publica`, `clasificada`, `reservada`, `demo`. Para otros textos use `tone` y `label`.

---
## 4. Contrato por módulo

> **Permisos:** los nombres de permiso son una **propuesta** para facilitar el trabajo del backend. La asignación a los cinco roles (Administrador, Radicador, Funcionario, Consulta Pública, Control Interno) debe definirla la empresa; los documentos no traen una matriz de permisos.
> **Formato de fechas:** `AAAA-MM-DD` para fechas y `AAAA-MM-DD HH:MM[:SS]` para fecha y hora. Las vistas dan el formato de presentación.

### 4.1 Acceso (login y recuperación)

| | |
|---|---|
| **Vistas** | `sgdea.auth.login`, `sgdea.auth.forgot-password` (layout `sgdea.layouts.auth`) |
| **Datos a recibir** | Ninguno. Errores de validación vía `$errors` |
| **Formulario login** | `correo`, `contrasena` |
| **Formulario recuperación** | Paso 1: `correo`. Paso 2: `code`, `contrasena`, `contrasena_confirmation` (el cambio de paso hoy es solo visual; con backend serán dos respuestas distintas) |
| **Acciones del backend** | Autenticar; registrar intentos fallidos en `auditorias`; cerrar sesión; generar y enviar un código de recuperación con vencimiento; validar el código y cambiar la contraseña marcándolo como usado; sesión con expiración por inactividad |
| **Rutas sugeridas** | `GET sgdea.login`, `POST sgdea.login.store`, `POST sgdea.logout`, `GET sgdea.password.request`, `POST sgdea.password.email`, `POST sgdea.password.update` |
| **Tablas** | `usuarios`, `sesiones`, `sgdea_password_reset_tokens` (`code`, `expires_at`, `used`), `auditorias` |
| **Validaciones** | `correo` obligatorio y con formato de correo; `contrasena` obligatoria; `code` obligatorio y vigente; nueva contraseña confirmada. Mensaje genérico ante credenciales inválidas. Limitar intentos |
| **Permisos** | Público (sin autenticación). Cuenta debe estar `activo` |

### 4.2 Panel principal

| | |
|---|---|
| **Vista** | `sgdea.dashboard.index` |
| **Variables** | `$indicadores` (lista de `etiqueta`, `valor`, `icono`, `tono`, `nota`: documentos, carpetas, cajas, radicaciones del año, transferencias pendientes, alertas); `$radicacionesPorTipo` (`tipo`, `total`); `$semaforo` (`clase` ∈ `sem-verde`/`sem-amarillo`/`sem-rojo`, `etiqueta`, `total`); `$alertas` (`estado`, `texto`, `detalle`); `$actividad` (`usuario`, `accion`, `tono`, `recurso`, `id`, `fecha`); `$esDemo` |
| **Formularios** | Ninguno |
| **Acciones del backend** | Calcular los totales y la actividad reciente (últimos eventos de `auditorias`) |
| **Rutas sugeridas** | `GET sgdea.dashboard` |
| **Tablas** | `documentos_digitales`, `carpetas_archivo`, `cajas_almacenamiento`, `radicaciones`, `transferencias_documentales`, `auditorias` |
| **Validaciones** | No aplica |
| **Permisos** | `dashboard.ver` (cualquier usuario autenticado; filtrar la actividad según el rol) |

### 4.3 Módulo 1 · Cuadro de Clasificación Documental (CCD) — HU-GDO-01

| | |
|---|---|
| **Vista** | `sgdea.ccd.index` (+ parciales `tree-node`, `tabla-nivel`, `modales`) |
| **Variables** | `$fondo` (`codigo`, `nombre`, `activo`); `$unidades`: lista de unidades (`codigo`, `nombre`, `activo`) con `oficinas` → `series` → `subseries` y `tipos` (`nombre`, `soporte`), **y `series_sin_oficina`**: lista de series (misma estructura) que el CCD oficial registra bajo la unidad con la oficina productora vacía. Cada serie y subserie puede traer `retencion` (`anios_gestion`, `anios_central`, `disposicion_final`, `procedimiento`). Estructura de referencia: `resources/sgdea/demo/ccd.php`. `$esDemo` |
| **Formularios (modales)** | **Fondo:** `codigo`, `nombre`, `activo`. **Unidad:** `fondo_id`, `codigo`, `nombre`, `activo`. **Oficina:** `unidad_administrativa_id`, `codigo`, `nombre`, `activo`. **Serie:** `oficina_productora_id`, `codigo`, `nombre`, `activo` (al editar una serie sin oficina, la oficina no es obligatoria y se muestra una nota). **Subserie:** `serie_id`, `codigo`, `nombre`, `activo`. **Tipo documental:** `serie_id`, `subserie_id` (opcional), `nombre`, `tipo_soporte_id` (Físico / Electrónico, incluye audiovisual y fotográfico / Híbrido), `especificacion_formato`, `activo`. Los campos `filtro_*_id` son auxiliares |
| **Acciones del backend** | Crear y editar cada nivel; activar/desactivar sin perder el histórico; **eliminar con restricción**: si el registro tiene hijos o expedientes asociados activos, responder con un error y el mensaje «existen registros asociados activos» (la interfaz ya lo muestra); entregar las opciones de los selectores dependientes |
| **Rutas sugeridas** | `GET sgdea.ccd.index`; por nivel `POST`, `PUT/PATCH` y `DELETE`: `sgdea.ccd.fondos.*`, `…unidades.*`, `…oficinas.*`, `…series.*`, `…subseries.*`, `…tipos.*`; `PATCH sgdea.ccd.{nivel}.estado`; `GET sgdea.ccd.opciones` (JSON opcional) |
| **Tablas** | `fondos_documentales`, `unidades_administrativas`, `oficinas_productoras`, `series_documentales`, `subseries_documentales`, `tipos_documentales`, `tipos_soportes` |
| **Validaciones** | `codigo` y `nombre` obligatorios; `codigo` único dentro de su nivel (HU-GDO-01); la serie nueva exige una oficina productora existente; la oficina exige una unidad; la subserie, una serie; el tipo documental, una serie y, si trae subserie, esta debe pertenecerle; `tipo_soporte_id` existente; **no eliminar** registros con dependencias activas (se puede desactivar) |
| **Permisos** | `ccd.ver`, `ccd.administrar` |

> **Diferencia con la HU-GDO-01 (documentada, sin decidir):** la historia describe *Fondo, Sección, Subsección, Serie, Subserie, Tipo documental*; el CCD de la empresa usa *Fondo, Unidad administrativa, Oficina productora, Serie, Subserie, Tipo documental*. La interfaz representa el CCD real. Persistir las series sin oficina requiere la decisión D1.

### 4.4 Módulo 2 · Tablas de Retención Documental (TRD) — HU-GDO-02

Módulo **general**: lista todas las unidades administrativas y oficinas productoras del CCD, incluidas las series sin oficina especificada. El ejemplo TRD_30 (Planta de Beneficio Animal) define el formato, no el alcance.

| | |
|---|---|
| **Vista** | `sgdea.trd.index` |
| **Variables** | Las mismas `$fondo` y `$unidades` del CCD, con `retencion` en cada serie o subserie. El presentador `trd.php` arma las filas con `codigo` (notación TRD: `30.08`, `30.08-02`), `serie`, `subserie`, `soportes`, `anios_gestion`, `anios_central`, `disposicion_final`, `procedimiento`, `parametrizada` y `fuente`. `$esDemo` |
| **Formulario** | `serie_id`, `subserie_id` (opcional), `anios_gestion` (≥ 1, obligatorio), `anios_central` (≥ 0, obligatorio), `disposicion_final` (obligatorio: `CT`, `E`, `S`, `M` según la HU o `D` según el formato TRD), `procedimiento`, `activo` |
| **Acciones del backend** | Consultar y filtrar; crear/editar la retención de una serie o subserie; cargar los datos base desde las TRD (seeders, según la HU) |
| **Rutas sugeridas** | `GET sgdea.trd.index`, `POST sgdea.trd.store`, `PUT sgdea.trd.update`, `GET sgdea.trd.show` (JSON opcional) |
| **Tablas** | `retencion_documental`, `series_documentales`, `subseries_documentales`, `oficinas_productoras` |
| **Validaciones** | `serie_id` obligatorio; `subserie_id` (si viene) perteneciente a la serie; `anios_gestion` y `anios_central` enteros, no nulos, con gestión ≥ 1 y central ≥ 0 (HU-GDO-02); `disposicion_final` dentro del catálogo que defina la empresa (decisión D3); evitar dos retenciones activas para la misma serie/subserie |
| **Permisos** | `trd.ver`, `trd.administrar` |

**Datos:** solo 5 de los 254 registros del CCD traen años y disposición (los muestra con la fuente «CCD oficial»); el resto aparece «Sin parametrizar» y la interfaz queda lista para registrarlos. La pantalla incluye una pestaña con las diferencias HU / formato TRD (disposición M/D, asociación a serie o subserie, años, soporte y notación de códigos); no elige una convención sobre la otra.

### 4.5 Módulo 3 · Radicación

| | |
|---|---|
| **Vistas** | `sgdea.radicaciones.index`, `.create`, `.show` (+ parcial `comprobante`) |
| **Variables** | **index:** `$radicaciones`. **create:** `$unidades`, `$radicadosPadre` (id → «número — asunto»). **show:** `$radicacion`, `$documentos`, `$hijos`. Cada radicación: `id`, `numero_radicado`, `anio_radicado`, `numero_consecutivo`, `tipo` (`entrada`/`salida`/`interna`), `asunto`, `datos_remitente` y `datos_destinatario` (`nombre`, `identificacion`, `contacto`), `correo_solicitante`, `oficina`, `unidad`, `usuario`, `fecha_hora`, `fecha_documento`, `folios`, `anexos`, `estado`, `padre` (número del radicado padre), `documentos` |
| **Formulario** | `tipo`, `datos_remitente[nombre\|identificacion\|contacto]`, `datos_destinatario[…]`, `filtro_unidad_id`, `oficina_productora_id`, `asunto`, `fecha_documento`, `radicado_padre_id`, `cantidad_folios`, `cantidad_anexos`, `correo_solicitante`, `archivo` |
| **Acciones del backend** | Asignar `numero_radicado`, `anio_radicado`, `numero_consecutivo` (con bloqueo de concurrencia sobre `consecutivos_radicacion`), `fecha_hora_radicacion` y `usuario_id`; guardar el archivo adjunto como documento digital; vincular radicado padre/hijo; generar el rótulo/comprobante imprimible |
| **Rutas sugeridas** | `GET sgdea.radicaciones.index`, `GET …create`, `POST sgdea.radicaciones.store`, `GET sgdea.radicaciones.show`, `GET sgdea.radicaciones.comprobante` (PDF) |
| **Tablas** | `radicaciones`, `consecutivos_radicacion`, `documentos_digitales`, `oficinas_productoras`, `usuarios` |
| **Validaciones** | `tipo` ∈ {entrada, salida, interna}; `asunto` obligatorio; remitente y destinatario con nombre; `oficina_productora_id` existente (la oficina, no la unidad); `fecha_documento` válida y no futura; folios y anexos enteros ≥ 0; `correo_solicitante` con formato válido cuando se pida; `radicado_padre_id` existente; archivo en formato admitido. **El número, la fecha y hora no se aceptan desde el formulario y no se pueden editar después** |
| **Permisos** | `radicacion.ver`, `radicacion.crear` (propuesto para Radicador), sin edición ni borrado |

**PQRSDF (HU-GDO-03):** se radican por este mismo flujo, normalmente como comunicaciones de entrada, con el correo del solicitante (`applicant_email`). La historia no define tipos, plazos ni estados propios; no se agregó ninguna marca ni pantalla adicional (pendiente de definición, D7). La dependencia es la oficina del usuario que radica (asociación automática de usuario y dependencia remitente o receptora).

### 4.6 Módulo 4 · Documentos digitales

| | |
|---|---|
| **Vistas** | `sgdea.documentos.index`, `.create`, `.show` |
| **Variables** | **index:** `$documentos`. **create:** `$unidades`, `$radicaciones`. **show:** `$documento`. Cada documento: `id`, `titulo`, `tipo_documental`, `serie`, `subserie`, `oficina`, `radicado`, `fecha_produccion`, `folios`, `paginas`, `soporte_origen`, `nivel_acceso` (`publica`/`clasificada`/`reservada`), `nombre_original_archivo`, `tipo_mime`, `tamano_bytes`, `hash_sha256`, `subido_por`, `ip`, `hora_carga`, `estado_validacion` (`validado`/`observaciones`), `validacion` (lista de `etiqueta`, `ok`), `carpeta` |
| **Formulario** | `archivo`, `filtro_unidad_id`, `filtro_oficina_id` (opciones `opt-oficinas-ext`), `filtro_serie_id`, `tipo_documental_id`, `radicacion_id`, `titulo`, `fecha_produccion`, `soporte_origen`, `cantidad_folios`, `cantidad_paginas`, `nivel_acceso` |
| **Acciones del backend** | Guardar el archivo en disco **privado**; calcular el SHA-256, tipo MIME y tamaño; registrar usuario, IP y hora de carga (`metadatos_json`); evaluar los 4 criterios de validación; descarga protegida por controlador (no por URL pública); verificar integridad recalculando el hash |
| **Rutas sugeridas** | `GET sgdea.documentos.index`, `GET …create`, `POST sgdea.documentos.store`, `GET sgdea.documentos.show`, `GET sgdea.documentos.download`, `POST sgdea.documentos.verificar` |
| **Tablas** | `documentos_digitales`, `tipos_documentales`, `radicaciones`, `documentos_carpeta` |
| **Validaciones** | Formato de archivo: PDF/A, TIFF, JPG o PNG (verificar tipo real, no solo extensión; el peso máximo está por definir); `tipo_documental_id` obligatorio (**sin documentos huérfanos**); título, fecha de producción, soporte de origen, folios, páginas y nivel de acceso obligatorios; `nivel_acceso` ∈ {publica, clasificada, reservada}; `radicacion_id` existente si viene |
| **Permisos** | `documento.ver` (sujeto al nivel de acceso), `documento.crear`, `documento.descargar`. **Acceso denegado (403) sin mostrar enlaces al archivo** cuando el nivel es Clasificada o Reservada y el usuario no tiene el rol o la autorización de la dependencia |

### 4.7 Módulo 5 · Carpetas y expedientes

| | |
|---|---|
| **Vistas** | `sgdea.carpetas.index`, `.create`, `.show` (+ parciales `rotulo`, `indice`) |
| **Variables** | **index:** `$carpetas`. **create:** `$unidades`, `$cajas`. **show:** `$carpeta`, `$documentosDisponibles`. Cada carpeta: `id`, `numero_asignado`, `nombre_carpeta`, `anio`, `unidad`, `oficina_codigo`, `oficina_nombre`, `serie_codigo`, `serie_nombre`, `subserie_codigo`, `subserie_nombre`, `caja`, `soporte`, `nivel_acceso`, `fase_archivo`, `estado`, `fecha_apertura`, `fecha_inicial`, `fecha_final`, `fecha_cierre`, `cantidad_folios`, `indice_sellado`, `usuario_creador`, `documentos` (`documento_id`, `secuencia`, `fecha_incorporacion`, `folio_inicial`, `folio_final`). El presentador `carpetas.php` agrega `indice`, `rotulo`, `total_documentos` e `hibrida` |
| **Formulario de apertura** | `filtro_unidad_id`, `oficina_productora_id` (opciones `opt-oficinas-ext`; si se elige «no especificada» el modelo exige decidir D1), `serie_id`, `subserie_id`, `numero_asignado`, `anio`, `nombre_carpeta`, `fecha_apertura`, `fecha_inicial`, `tipo_soporte_id` (Físico / Electrónico / Híbrido), `nivel_acceso`, `fase_archivo`, `caja_almacenamiento_id`. **Incorporar:** `documento_id` |
| **Acciones del backend** | Crear la carpeta con `estado = Abierta`; heredar la retención de la TRD; incorporar un documento asignando `numero_secuencia` y la foliación consecutiva (`folio_inicial`/`folio_final`) y actualizando `cantidad_folios`; impedir cambios si está cerrada; generar el rótulo imprimible; exportar el índice (PDF/A y JSON); descargar el expediente consolidado con su índice técnico estructurado; visor web de documentos |
| **Rutas sugeridas** | `GET sgdea.carpetas.index`, `GET …create`, `POST sgdea.carpetas.store`, `GET sgdea.carpetas.show`, `POST sgdea.carpetas.documentos.store`, `GET sgdea.carpetas.rotulo`, `GET sgdea.carpetas.indice`, `GET sgdea.carpetas.descarga` |
| **Tablas** | `carpetas_archivo`, `documentos_carpeta`, `documentos_digitales`, `cajas_almacenamiento`, `tipos_soportes`, `series_documentales`, `subseries_documentales` |
| **Validaciones** | Clasificación obligatoria y consistente (serie de la oficina, subserie de la serie); `numero_asignado` obligatorio y único dentro de su contexto; `fecha_apertura` válida; `fecha_final` ≥ `fecha_inicial`; el documento incorporado debe ser de la misma serie y no estar ya en otra carpeta; folios consecutivos sin solapamientos; **rechazar cualquier escritura si `estado = Cerrada`** |
| **Permisos** | `carpeta.ver`, `carpeta.crear`, `carpeta.incorporar` (propuesto para Funcionario de la dependencia) |

### 4.8 Módulo 6 · Cierre de carpetas

| | |
|---|---|
| **Vistas** | `sgdea.cierre.index`, `sgdea.cierre.show` (+ parcial `modal-cierre`) |
| **Variables** | `$carpetas` / `$carpeta` con la misma estructura del módulo 5; además `transferencia_estimada` (hoy `null`) e `indice_hash` |
| **Formulario** | Confirmación (casilla de aceptación) sin campos de datos |
| **Acciones del backend** | Cerrar en una sola transacción: `estado = Cerrada`, `fecha_cierre`, `indice_sellado`; calcular la fecha límite de transferencia según la TRD (si la TRD no tiene retención, dejarla vacía); generar el índice electrónico definitivo y su huella; registrar la auditoría; **operación irreversible** |
| **Rutas sugeridas** | `GET sgdea.cierre.index`, `GET sgdea.cierre.show`, `POST sgdea.cierre.store` |
| **Tablas** | `carpetas_archivo`, `documentos_carpeta`, `retencion_documental`, `auditorias` |
| **Validaciones** | La carpeta debe estar abierta y tener la clasificación completa; confirmar aceptación; no permitir reabrir ni editar |
| **Permisos** | `carpeta.cerrar` (propuesto para Funcionario responsable y Administrador) |

### 4.9 Módulo 9 · Inventario FUID — HU-GDO-09

Módulo **general**: el inventario se puede generar para cualquier unidad administrativa, oficina productora o para el Archivo Central. Los 106 registros del FUID entregado (dependencia 30) y 9 carpetas de Contabilidad (rótulo de caja) son solo datos de ejemplo.

| | |
|---|---|
| **Vistas** | `sgdea.fuid.index`, `sgdea.fuid.show` (+ parcial `rotulo-caja`; el rótulo de carpeta reutiliza `sgdea.carpetas.partials.rotulo`) |
| **Variables** | `$encabezado` (`codigo`, `fecha`, `version`, `acuerdo`, `entidad_remitente`, `objeto`, `numero_transferencia`); `$encabezados_dependencia` (código de dependencia → `unidad_administrativa`, `oficina_productora`, `fuente`; opcional: por defecto se arma con el CCD); `$unidades` (para el filtro de dependencia); `$registros` con los campos del formato FUID: `orden`, `codigo_dependencia`, `dependencia`, `serie_codigo`, `serie_nombre`, `subserie_codigo`, `subserie_nombre`, `nombre_unidad`, `fecha_inicial`, `fecha_final`, `anio`, `soporte_analogo`, `soporte_electronico`, `caja`, `carpeta`, `correlativo`, `folios` (texto, ej. `1-200` o `201-247 (47)`), `otro_tipo`, `otro_cantidad`, `elec_ubicacion`, `elec_cantidad`, `elec_tamano`, `notas`; más **`fase_archivo`** (`Gestión`, `Central`, `Histórico` o nulo), `origen` y `demo`. El presentador `fuid.php` calcula totales, cajas (por dependencia y caja), resúmenes y observaciones de calidad |
| **Formularios** | Ninguno (consulta). Filtros: dependencia (jerárquico: una unidad incluye sus oficinas), año, serie, subserie, caja y **fase** (Gestión, Central, Histórico, No especificada) |
| **Acciones del backend** | Generar el inventario desde `carpetas_archivo`, `cajas_almacenamiento` y `documentos_carpeta` por dependencia o por fase; aplicar los filtros del lado del servidor; calcular totales; **exportar a Excel/CSV y PDF** con el encabezado institucional; generar los rótulos de caja y de carpeta |
| **Rutas sugeridas** | `GET sgdea.fuid.index`, `GET sgdea.fuid.show`, `GET sgdea.fuid.exportar` (parámetro `formato` = xlsx, csv o pdf), `GET sgdea.fuid.caja.rotulo` |
| **Tablas** | `carpetas_archivo` (incluye `fase_archivo`), `cajas_almacenamiento`, `documentos_carpeta`, `oficinas_productoras`, `series_documentales`, `subseries_documentales`, `tipos_soportes` |
| **Validaciones** | Parámetros de filtro válidos (año numérico, ids existentes, `fase` ∈ {Gestión, Central, Histórico}); `formato` ∈ {xlsx, csv, pdf}. Verificar la consistencia de folios y fechas (el frontend resalta 4 casos en el FUID entregado) |
| **Permisos** | `fuid.ver`, `fuid.exportar` |

> El modelo no tiene columnas para *Notas*, *Correlativo*, *Otro (tipo y cantidad)* ni *Ubicación electrónica* del formato FUID (decisión D11). El FUID de Excel entregado no trae la fase; el filtro la toma de `carpetas_archivo.fase_archivo`.

### 4.10 Módulo 7 · Usuarios y control de acceso

| | |
|---|---|
| **Vista** | `sgdea.usuarios.index` |
| **Variables** | `$usuarios` (`id`, `nombre_completo`, `correo`, `oficina`, `oficina_key`, `unidad_key`, `roles`, `activo`, `fecha_creacion`); `$roles` (`nombre`, `descripcion`); `$permisos` (matriz rol → permisos, hoy sin asignar); `$unidades` (series y subseries con su `nivel_acceso`); `$resumenNiveles` (`publica`/`clasificada`/`reservada` → `carpetas`, `documentos`) |
| **Formulario** | `nombre_completo`, `correo`, `filtro_unidad_id`, `oficina_productora_id` (opcional), `roles[]`, `activo` |
| **Acciones del backend** | Crear y editar usuarios; asignar roles (`rol_usuario`); **gestionar los permisos de cada rol**; **configurar el nivel de acceso por serie o subserie y heredarlo al documento**; activar/desactivar cuentas; gestionar la contraseña inicial; esquema RBAC con los 5 roles; aplicar los niveles de acceso al consultar y descargar |
| **Rutas sugeridas** | `GET sgdea.usuarios.index`, `POST sgdea.usuarios.store`, `PUT sgdea.usuarios.update`, `PATCH sgdea.usuarios.estado`, `PUT sgdea.roles.permisos`, `PATCH sgdea.usuarios.nivel-serie` (el almacenamiento del nivel por serie/subserie está pendiente, D6) |
| **Tablas** | `usuarios`, `roles`, `rol_usuario`, `oficinas_productoras`, `sesiones` |
| **Validaciones** | `nombre_completo` obligatorio; `correo` obligatorio, con formato válido y único; al menos un rol; `oficina_productora_id` existente si viene; no desactivar al último administrador |
| **Permisos** | `usuarios.administrar` (Administrador). El resto de roles no accede |

### 4.11 Módulo 8 · Auditorías

| | |
|---|---|
| **Vista** | `sgdea.auditorias.index` |
| **Variables** | `$auditorias` con `id`, `fecha_hora`, `usuario` (nulo si no hubo sesión), `referencia` (radicado o expediente relacionado), `user_agent`, `accion` (`creacion`, `consulta`, `modificacion`, `cierre`, `transferencia`, `intento_fallido`, `acceso_denegado`), `tabla_afectada`, `id_afectado`, `ip`, `antes`, `despues` (arreglos o nulos) |
| **Formularios** | Ninguno (filtros visuales: usuario, tipo de evento, tipo de recurso, radicado o expediente, fechas) |
| **Acciones del backend** | Registrar eventos de forma automática (observers o eventos); consultar con filtros; **exportar a CSV**; no ofrecer edición ni borrado |
| **Rutas sugeridas** | Solo `GET sgdea.auditorias.index`, `GET sgdea.auditorias.show` y `GET sgdea.auditorias.exportar` (equivalente a `Route::resource(...)->only(['index','show'])`) |
| **Tablas** | `auditorias`, `usuarios` |
| **Validaciones** | Fechas válidas y `desde` ≤ `hasta`; la tabla debe ser de solo inserción (sin `UPDATE` ni `DELETE`) |
| **Permisos** | `auditoria.ver` (propuesto para Control Interno y Administrador) |

### 4.12 Módulo 10 · Transferencias, alertas y disposición final

| | |
|---|---|
| **Vista** | `sgdea.transferencias.index` (pestañas: panel y alertas, transferencias, actas, disposición final) |
| **Variables** | `$alertas` (`carpeta`, `oficina`, `ubicacion`, `fecha_cierre`, `semaforo` ∈ verde/amarillo/rojo, `estado`, `origen`); `$transferencias` (`id`, `codigo_transferencia`, `tipo_transferencia`, `fase_origen`, `fase_destino`, `fecha_transferencia`, `estado`, `numero_acta`, `creado_por`, `aprobado_por`, `items` con `carpeta` y `notas`); `$solicitudes` (`id`, `carpeta`, `tipo_disposicion`, `numero_acta`, `referencia_acta`, `estado`, `disposicion_aplicada` (p. ej. `Eliminado`), `solicitado_por`, `fecha_hora_solicitud`, `completado_en`, `aprobaciones` con `aprobado_por`, `estado`, `comentarios`, `fecha_hora`) |
| **Formularios** | **Transferencia:** `tipo_transferencia`, `fase_origen`, `fase_destino`, `carpetas[]`, `notas`. **Disposición:** `carpeta_id`, `tipo_disposicion` (CT, E, S, D), `numero_acta`, `referencia_acta`, `acta_archivo` |
| **Acciones del backend** | Evaluar a diario las fechas de retención con la TRD y la fecha de cierre (`php artisan sgdea:check-retention`) y producir el semáforo; crear transferencias con sus carpetas; flujo de estados y aprobación; generar el acta y el **FUID de transferencia**; descarga en bloque del paquete; solicitudes de disposición con el acta del Comité de MIPG y **doble visto bueno** para eliminar; conservar el registro histórico de la baja |
| **Rutas sugeridas** | `GET sgdea.transferencias.index`; `POST sgdea.transferencias.store`, `PATCH sgdea.transferencias.estado`, `GET sgdea.transferencias.acta`, `GET sgdea.transferencias.paquete`; `POST sgdea.disposicion.store`, `POST sgdea.disposicion.aprobaciones.store` |
| **Tablas** | `transferencias_documentales`, `items_transferencia_documental`, `solicitudes_disposicion`, `aprobaciones_disposicion`, `carpetas_archivo`, `retencion_documental` |
| **Validaciones** | Solo carpetas cerradas pueden transferirse; `tipo_transferencia`, `fase_origen`, `fase_destino` obligatorios; al menos una carpeta; para `E` (eliminación): `numero_acta` y `referencia_acta` obligatorios, dos aprobaciones distintas y solo si cumplió los tiempos; el solicitante no puede aprobar su propia solicitud |
| **Permisos** | `transferencia.ver`, `transferencia.crear`, `transferencia.aprobar`, `disposicion.solicitar`, `disposicion.aprobar` (propuesto para el Líder de Gestión Documental y el Comité Institucional) |

> Los semáforos y estados que hoy muestra la pantalla son **datos de demostración**. El backend decide los estados reales; la correspondencia propuesta con la historia HU-GDO-10 es: borrador → Pendiente, enviada → En revisión, recibida_archivo_central → Transferido, rechazada → Rechazado.

---
## 5. Clasificación de hallazgos y decisiones

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

---

## 6. Orden recomendado de integración

1. **Acceso y usuarios:** login, recuperación, roles y el layout con `$usuarioActual` (desbloquea todo lo demás).
2. **Auditoría transversal:** registrar eventos desde el inicio para que los demás módulos ya la usen.
3. **CCD** y luego **TRD** (base de la clasificación y la retención).
4. **Radicación** → **Documentos digitales** (almacenamiento privado y SHA-256).
5. **Carpetas** → **Cierre** (foliación, índice sellado).
6. **Inventario FUID** (depende de carpetas y cajas) y **Transferencias y disposición** (depende de cierre y TRD).
7. **Dashboard** al final, cuando existan los datos que resume.

---

## 7. Qué NO se implementó en el frontend (a propósito)

Autenticación y recuperación de contraseña reales; control de acceso o permisos; consultas a la base de datos; guardado de formularios; almacenamiento de archivos; cálculo de consecutivos, hashes definitivos, retención, fechas de transferencia, semáforos o foliación; exportaciones reales (Excel, CSV, PDF); generación de rótulos y actas imprimibles; envío de notificaciones. Todos los botones correspondientes muestran un aviso de demostración.

Lo único calculado en el navegador, solo para vista previa y sin guardar, es: la huella SHA-256 al seleccionar un archivo en «Registrar documento», los totales de pantalla del FUID según los filtros, y la vista previa de los folios al incorporar un documento.

---

## 8. Verificación realizada

- Las 46 vistas Blade se compilaron con el compilador real de Laravel 11 y el PHP resultante pasó la verificación de sintaxis.
- Las 21 pantallas (28 renderizados con sus variantes, por ejemplo carpeta abierta y cerrada) se renderizaron sin errores con el motor de vistas y los 11 componentes.
- Los archivos PHP de datos y presentadores y los 10 JavaScript pasaron la verificación de sintaxis.
- Se verificó que cada vista, componente, imagen, CSS y JavaScript referenciado existe.
- Se ejecutaron pruebas de comportamiento sobre el HTML renderizado (filtros, selectores dependientes, la regla de jerarquía unidad → oficina → serie, modales, validaciones visuales, cierre de carpeta, etc.).
- No se probó la apariencia visual en un navegador real ni en distintos tamaños de pantalla.

---

## 9. Cuadro de cumplimiento de las 10 historias de usuario (274-2026E.pdf)

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


El listado de cambios de la última revisión está en `docs/sgdea/REVISION_FINAL.md`.
