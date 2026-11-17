# SGDEA · Frontend Blade — Cómo instalarlo y verlo

1. Descomprima el ZIP en la **raíz del proyecto Laravel**. Solo agrega archivos nuevos en `public/sgdea/`, `resources/views/sgdea/`, `resources/views/components/sgdea/`, `resources/sgdea/` y `docs/sgdea/`; no reemplaza archivos existentes.
2. No hay dependencias que instalar (no usa Vite, npm ni paquetes). Requiere Laravel 9 o superior.
3. Las rutas ya están integradas en `routes/sgdea.php`; no agregue rutas temporales.
4. Inicie sesión en `/login`. Al abrir `/`, el sistema lo llevará al panel y, desde allí, podrá entrar a cada módulo según sus permisos.
5. Para la integración con el backend lea `FRONTEND_BACKEND_CONTRACT.md`.
