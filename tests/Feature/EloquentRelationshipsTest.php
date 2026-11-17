<?php

use App\Models\CajaAlmacenamiento;
use App\Models\CarpetaArchivo;
use App\Models\DocumentoDigital;
use App\Models\FondoDocumental;
use App\Models\OficinaProductora;
use App\Models\Radicacion;
use App\Models\RetencionDocumental;
use App\Models\Rol;
use App\Models\SerieDocumental;
use App\Models\SolicitudDisposicion;
use App\Models\SubserieDocumental;
use App\Models\TipoDocumental;
use App\Models\TipoSoporte;
use App\Models\TransferenciaDocumental;
use App\Models\UnidadAdministrativa;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('SGDEA relationships return their related records and preserve casts and scopes', function () {
    $fondo = FondoDocumental::create([
        'codigo' => 'F-TEST',
        'nombre' => 'Fondo de prueba',
        'activo' => true,
    ]);
    $unidad = $fondo->unidades()->create([
        'codigo' => 'U-TEST',
        'nombre' => 'Unidad de prueba',
        'activo' => true,
    ]);
    $oficina = $unidad->oficinas()->create([
        'codigo' => 'O-TEST',
        'nombre' => 'Oficina de prueba',
        'activo' => true,
    ]);
    $serie = $oficina->series()->create([
        'codigo' => 'S-TEST',
        'nombre' => 'Serie de prueba',
        'activo' => true,
    ]);
    $subserie = $serie->subseries()->create([
        'codigo' => 'SS-TEST',
        'nombre' => 'Subserie de prueba',
        'activo' => true,
    ]);
    $soporte = TipoSoporte::create(['nombre' => 'Digital']);
    $tipoDocumental = $serie->tiposDocumentales()->create([
        'subserie_id' => $subserie->getKey(),
        'tipo_soporte_id' => $soporte->getKey(),
        'nombre' => 'Tipo de prueba',
        'activo' => true,
    ]);
    $retencionSerie = RetencionDocumental::create([
        'serie_id' => $serie->getKey(),
        'anios_gestion' => 1,
        'anios_central' => 2,
        'activo' => true,
    ]);
    $retencionSubserie = RetencionDocumental::create([
        'serie_id' => $serie->getKey(),
        'subserie_id' => $subserie->getKey(),
        'anios_gestion' => 3,
        'anios_central' => 4,
        'activo' => true,
    ]);
    $caja = $oficina->cajas()->create([
        'numero_caja' => 'C-TEST',
        'anio' => 2026,
        'estado' => 'Activa',
    ]);
    $usuario = Usuario::create([
        'oficina_productora_id' => $oficina->getKey(),
        'nombre_completo' => 'Usuario de prueba',
        'correo' => 'usuario-prueba@example.test',
        'contrasena' => 'password',
        'activo' => true,
    ]);
    $rol = Rol::create(['nombre' => 'Rol de prueba']);
    $usuario->roles()->attach($rol->getKey(), [
        'fecha_creacion' => now(),
        'fecha_modificacion' => now(),
    ]);
    $carpeta = CarpetaArchivo::create([
        'caja_almacenamiento_id' => $caja->getKey(),
        'oficina_productora_id' => $oficina->getKey(),
        'serie_id' => $serie->getKey(),
        'subserie_id' => $subserie->getKey(),
        'numero_asignado' => 'CP-TEST',
        'nombre_carpeta' => 'Carpeta abierta',
        'anio' => 2026,
        'tipo_soporte_id' => $soporte->getKey(),
        'nivel_acceso' => 'publica',
        'fase_archivo' => 'Archivo de gestión',
        'estado' => 'Abierta',
        'usuario_creador' => $usuario->getKey(),
    ]);
    $carpetaCerrada = CarpetaArchivo::create([
        'oficina_productora_id' => $oficina->getKey(),
        'serie_id' => $serie->getKey(),
        'numero_asignado' => 'CP-CERRADA',
        'nombre_carpeta' => 'Carpeta cerrada',
        'anio' => 2026,
        'tipo_soporte_id' => $soporte->getKey(),
        'nivel_acceso' => 'publica',
        'fase_archivo' => 'Archivo de gestión',
        'estado' => 'Cerrada',
    ]);
    $radicacionPadre = Radicacion::create([
        'numero_radicado' => 'TEST-001-2026-E',
        'anio_radicado' => 2026,
        'numero_consecutivo' => 1,
        'tipo' => 'entrada',
        'asunto' => 'Radicación padre de prueba',
        'datos_remitente' => ['nombre' => 'Remitente'],
        'oficina_productora_id' => $oficina->getKey(),
        'usuario_id' => $usuario->getKey(),
        'fecha_hora_radicacion' => now(),
        'estado' => 'Radicado',
    ]);
    $radicacionHija = Radicacion::create([
        'numero_radicado' => 'TEST-002-2026-S',
        'anio_radicado' => 2026,
        'numero_consecutivo' => 2,
        'tipo' => 'salida',
        'radicado_padre_id' => $radicacionPadre->getKey(),
        'asunto' => 'Radicación hija de prueba',
        'datos_destinatario' => ['nombre' => 'Destinatario'],
        'oficina_productora_id' => $oficina->getKey(),
        'usuario_id' => $usuario->getKey(),
        'fecha_hora_radicacion' => now(),
        'estado' => 'Radicado',
    ]);
    $documento = DocumentoDigital::create([
        'radicacion_id' => $radicacionHija->getKey(),
        'tipo_documental_id' => $tipoDocumental->getKey(),
        'titulo' => 'Documento de prueba',
        'fecha_produccion' => '2026-11-17',
        'soporte_origen' => 'Digital',
        'nivel_acceso' => 'publica',
        'nombre_original_archivo' => 'prueba.pdf',
        'ruta_archivo' => 'pruebas/prueba.pdf',
        'tipo_mime' => 'application/pdf',
        'tamano_bytes' => 128,
        'hash_sha256' => str_repeat('a', 64),
        'metadatos_json' => ['pagina' => 1],
        'subido_por' => $usuario->getKey(),
        'hora_carga' => now(),
    ]);
    $carpeta->documentos()->attach($documento->getKey(), [
        'numero_secuencia' => 1,
        'folio_inicial' => 1,
        'folio_final' => 1,
        'fecha_hora_incorporacion' => now(),
        'incorporado_por' => $usuario->getKey(),
    ]);
    $transferencia = TransferenciaDocumental::create([
        'codigo_transferencia' => 'TR-TEST',
        'tipo_transferencia' => 'Primaria',
        'fase_origen' => 'Archivo de gestión',
        'fase_destino' => 'Archivo central',
        'estado' => 'En revisión',
        'creado_por' => $usuario->getKey(),
    ]);
    $item = $transferencia->items()->create(['carpeta_id' => $carpeta->getKey()]);
    $solicitud = SolicitudDisposicion::create([
        'carpeta_id' => $carpeta->getKey(),
        'tipo_disposicion' => 'Selección',
        'estado' => 'Pendiente',
        'solicitado_por' => $usuario->getKey(),
        'fecha_hora_solicitud' => now(),
    ]);
    $aprobacion = $solicitud->aprobaciones()->create([
        'aprobado_por' => $usuario->getKey(),
        'estado' => 'Aprobada',
    ]);
    $fondoInactivo = FondoDocumental::create([
        'codigo' => 'F-INACTIVO',
        'nombre' => 'Fondo inactivo',
        'activo' => false,
    ]);

    expect($fondo->unidades->modelKeys())->toBe([$unidad->getKey()])
        ->and($unidad->fondo->is($fondo))->toBeTrue()
        ->and($unidad->oficinas->modelKeys())->toBe([$oficina->getKey()])
        ->and($oficina->series->modelKeys())->toBe([$serie->getKey()])
        ->and($serie->subseries->modelKeys())->toBe([$subserie->getKey()])
        ->and($serie->tiposDocumentales->modelKeys())->toBe([$tipoDocumental->getKey()])
        ->and($subserie->tiposDocumentales->modelKeys())->toBe([$tipoDocumental->getKey()])
        ->and($serie->retenciones->modelKeys())->toBe([$retencionSerie->getKey(), $retencionSubserie->getKey()])
        ->and($subserie->retenciones->modelKeys())->toBe([$retencionSubserie->getKey()])
        ->and($carpeta->documentos->modelKeys())->toBe([$documento->getKey()])
        ->and($carpeta->caja->is($caja))->toBeTrue()
        ->and($radicacionHija->padre->is($radicacionPadre))->toBeTrue()
        ->and($radicacionPadre->hijos->modelKeys())->toBe([$radicacionHija->getKey()])
        ->and($radicacionHija->documentos->modelKeys())->toBe([$documento->getKey()])
        ->and($radicacionHija->oficina->is($oficina))->toBeTrue()
        ->and($radicacionHija->usuario->is($usuario))->toBeTrue()
        ->and($transferencia->items->modelKeys())->toBe([$item->getKey()])
        ->and($solicitud->aprobaciones->modelKeys())->toBe([$aprobacion->getKey()])
        ->and($usuario->roles->modelKeys())->toBe([$rol->getKey()])
        ->and($usuario->oficina->is($oficina))->toBeTrue()
        ->and($radicacionPadre->datos_remitente)->toBe(['nombre' => 'Remitente'])
        ->and($radicacionHija->datos_destinatario)->toBe(['nombre' => 'Destinatario'])
        ->and($documento->metadatos_json)->toBe(['pagina' => 1])
        ->and($documento->fecha_produccion->toDateString())->toBe('2026-11-17')
        ->and(FondoDocumental::activos()->whereKey($fondo->getKey())->exists())->toBeTrue()
        ->and(FondoDocumental::activos()->whereKey($fondoInactivo->getKey())->exists())->toBeFalse()
        ->and(UnidadAdministrativa::activos()->whereKey($unidad->getKey())->exists())->toBeTrue()
        ->and(OficinaProductora::activos()->whereKey($oficina->getKey())->exists())->toBeTrue()
        ->and(SerieDocumental::activos()->whereKey($serie->getKey())->exists())->toBeTrue()
        ->and(SubserieDocumental::activos()->whereKey($subserie->getKey())->exists())->toBeTrue()
        ->and(TipoDocumental::activos()->whereKey($tipoDocumental->getKey())->exists())->toBeTrue()
        ->and(RetencionDocumental::activos()->whereKey($retencionSerie->getKey())->exists())->toBeTrue()
        ->and(CajaAlmacenamiento::activos()->whereKey($caja->getKey())->exists())->toBeTrue()
        ->and(Usuario::activos()->whereKey($usuario->getKey())->exists())->toBeTrue()
        ->and(CarpetaArchivo::abiertas()->whereKey($carpeta->getKey())->exists())->toBeTrue()
        ->and(CarpetaArchivo::abiertas()->whereKey($carpetaCerrada->getKey())->exists())->toBeFalse()
        ->and(CarpetaArchivo::cerradas()->whereKey($carpetaCerrada->getKey())->exists())->toBeTrue()
        ->and(CarpetaArchivo::cerradas()->whereKey($carpeta->getKey())->exists())->toBeFalse();
});
