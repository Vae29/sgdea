# SGDEA · Frontend Blade — Cómo instalarlo y verlo

1. Descomprima el ZIP en la **raíz del proyecto Laravel**. Solo agrega archivos nuevos en `public/sgdea/`, `resources/views/sgdea/`, `resources/views/components/sgdea/`, `resources/sgdea/` y `docs/sgdea/`; no reemplaza archivos existentes.
2. No hay dependencias que instalar (no usa Vite, npm ni paquetes). Requiere Laravel 9 o superior.
3. Para ver las pantallas agregue, **de forma temporal**, las rutas de `PREVISUALIZACION_TEMPORAL.md` en `routes/web.php` (este paquete no crea ni modifica rutas).
4. Abra `/sgdea/login`, `/sgdea/dashboard` y, desde el menú lateral, cada módulo.
5. Para la integración con el backend lea `FRONTEND_BACKEND_CONTRACT.md`.
