<?php
/*
 | DATOS EXTRAÍDOS DEL CCD OFICIAL (CCD_12.docx). Se conservan TODAS las series del CCD:
 | - 'oficinas' → 'series': series registradas bajo una oficina productora.
 | - 'series_sin_oficina': series que el CCD lista bajo la unidad administrativa con el código de oficina productora VACÍO.
 |   No se les inventa oficina: la interfaz las muestra como "Oficina productora no especificada en el CCD".
 | - 'retencion' (años y disposición) solo trae valores en los 5 registros donde el CCD los diligencia; en el resto es null.
 | - El CCD no trae código para el fondo: se deja en null (no se inventa).
 | - Estados 'activo' = true es el valor por defecto del esquema; no proviene del CCD.
 | Será reemplazado por la información que entregue el controlador del módulo CCD.
*/
return [
    'fondo' => ['codigo' => null, 'nombre' => 'EMPRESAS VARIAS DE CAICEDONIA E.V.C – ESP', 'activo' => true],
    'unidades' => [
        [
            'codigo' => '10',
            'nombre' => 'Gerencia General',
            'activo' => true,
            'oficinas' => [
                [
                    'codigo' => '11',
                    'nombre' => 'Planeación',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '08',
                                    'nombre' => 'Actas de Comité Institucional de Gestión y Desempeño (MIPG).',
                                    'tipos' => [
                                        ['nombre' => 'Citación a reunión del comité.', 'soporte' => ''],
                                        ['nombre' => 'Acta de Comité Institucional de Gestión y Desempeño.', 'soporte' => ''],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'CIRCULARES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Circulares Informativas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Informes a entes de control',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '06',
                                    'nombre' => 'Informes de Desempeño del Sistema Integrado de Planeación y Gestión',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '12',
                                    'nombre' => 'Informes de Seguimiento al Modelo Integrado de Planeación y Gestión - MIPG',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '13',
                                    'nombre' => 'Informes de Seguimiento al Programa de Transparencia y ética Pública',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '32',
                            'nombre' => 'MANUALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Manuales de Contratación',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '06',
                                    'nombre' => 'Manuales de procesos y procedimientos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Manuales del Sistema de Gestión Ambiental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '08',
                                    'nombre' => 'Manuales del Sistema de Gestión de Calidad',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '11',
                                    'nombre' => 'Manuales del Sistema Integrado de Gestión',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '34',
                            'nombre' => 'PLANES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Plan de Acción Institucional',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '09',
                                    'nombre' => 'Plan de la Estrategia de Rendición de Cuentas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '24',
                                    'nombre' => 'Plan del Sistema de Gestión Ambiental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '27',
                                    'nombre' => 'Plan Estratégicos institucionales',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '34',
                                    'nombre' => 'Planes de gestión del riesgo',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Política de Participación ciudadana en la gestión',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Política de Servicio al Ciudadano',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '19',
                                    'nombre' => 'Política de Transparencia y lucha contra la corrupción.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '24',
                                    'nombre' => 'Políticas de Gestión y Administración de Riesgos Institucionales',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '43',
                            'nombre' => 'PROGRAMAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '13',
                                    'nombre' => 'Programa de Tranparencia y Ética Pública PTEP',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '47',
                            'nombre' => 'SISTEMA INTEGRADO DE GESTIÓN - SIG',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                ],
                [
                    'codigo' => '12',
                    'nombre' => 'Secretaria',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Actas de Apertura del Buzón de sugerencias',
                                    'tipos' => [
                                        ['nombre' => 'Acta', 'soporte' => 'Papel/Electrónico (PDF).'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'CIRCULARES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Circulares Informativas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '10',
                            'nombre' => 'COMPROBANTES DE ALMACÉN',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Comprobantes de Baja de Bienes de Almacén',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Comprobantes de Egreso de Bienes al
Almacén',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Comprobantes de Ingreso de Bienes al
Almacén',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Comprobantes de Reintegro de Bienes al Almacén',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Comprobantes de Traslado de Bienes',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '13',
                            'nombre' => 'CONSECUTIVOS DE COMUNICACIONES OFICIALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Consecutivo de comunicaciones oficiales internas',
                                    'tipos' => [
                                        ['nombre' => 'Registro Base de datos Excel.', 'soporte' => 'Electrónico (xlsx).'],
                                        ['nombre' => 'Copia del consecutivo de comunicaciones oficiales Enviadas.', 'soporte' => 'Electrónico (PDF).'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Consecutivos de comunicaciones oficiales enviadas',
                                    'tipos' => [
                                        ['nombre' => 'Registro Base de datos Excel.', 'soporte' => 'Electrónico (xlsx).'],
                                        ['nombre' => 'Copia del consecutivo de comunicaciones oficiales Enviadas', 'soporte' => 'Electrónico (PDF).'],
                                        ['nombre' => 'Acta cierre anual de consecutivo', 'soporte' => 'Electrónico (PDF).'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Consecutivos de comunicaciones oficiales recibidas',
                                    'tipos' => [
                                        ['nombre' => 'Acta Apertura anual de consecutivo', 'soporte' => 'Electrónico (xlsx).'],
                                        ['nombre' => 'Registro Base de datos Excel.', 'soporte' => 'Electrónico (PDF).'],
                                        ['nombre' => 'Copia comunicaciones oficiales Recibidas.', 'soporte' => 'Electrónico (PDF).'],
                                        ['nombre' => 'Acta cierre anual de consecutivo', 'soporte' => 'Electrónico (PDF).'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Consecutivos de Reportes de alumbrado Público',
                                    'tipos' => [
                                        ['nombre' => 'Registro Base de datos Excel.', 'soporte' => 'Electrónico (xlsx). / Papel/Electrónico (PDF)'],
                                        ['nombre' => 'Consecutivo Reporte.', 'soporte' => 'Electrónico (xlsx). / Papel/Electrónico (PDF)'],
                                        ['nombre' => 'Foto de la respuesta', 'soporte' => 'Electrónico (xlsx). / Papel/Electrónico (PDF)'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '17',
                            'nombre' => 'DERECHOS DE PETICIÓN',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [
                                ['nombre' => 'Derecho de Petición.', 'soporte' => 'Electrónico (PDF).'],
                                ['nombre' => 'Respuesta a Derecho de Petición', 'soporte' => 'Electrónico (PDF).'],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '10',
                                    'nombre' => 'Informes de PQRS',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '15',
                                    'nombre' => 'Informes Estadísticos de Comunicaciones Oficiales.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '16',
                                    'nombre' => 'Informes Estadísticos de Servicio al Ciudadano.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '26',
                            'nombre' => 'INSTRUMENTOS DE CONTROL',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Instrumentos de control Reportes de alumbrado Público.',
                                    'tipos' => [
                                        ['nombre' => 'Planilla de Entrega de Reportes de Alumbrado Público.', 'soporte' => 'Papel'],
                                    ],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '32',
                            'nombre' => 'MANUALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Manuales de Atención al Ciudadano',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '34',
                            'nombre' => 'PLANES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '30',
                                    'nombre' => 'Plan Institucional de Atención al
Ciudadano',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '14',
                                    'nombre' => 'Política de Racionalización de Trámites.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '20',
                                    'nombre' => 'Política frente a los grupos de interés.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                    ],
                ],
                [
                    'codigo' => '12.1',
                    'nombre' => 'Gestión Documental',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '10',
                                    'nombre' => 'Actas de eliminación documental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'CIRCULARES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Circulares Informativas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Informes a entes de control',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '14',
                                    'nombre' => 'Informes de visita a las dependencias',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '25',
                            'nombre' => 'INSTRUMENTOS ARCHIVÍSTICOS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Bancos terminológicos de series y subseries documentales',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Cuadros de clasificación documental - CCD',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Diagnóstico Integral de Archivos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Inventarios documentales de Archivo Central',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Modelo de Requisitos para la Gestión de Documentos Electrónicos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '06',
                                    'nombre' => 'Planes institucionales de archivos – PINAR',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '26',
                            'nombre' => 'INSTRUMENTOS DE CONTROL',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Instrumentos de control Consultas y Préstamos de Documentos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '28',
                            'nombre' => 'INVENTARIOS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Inventario Eliminación Documental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '34',
                            'nombre' => 'PLANES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Plan de Conservación Documental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '19',
                                    'nombre' => 'Plan de transferencias documentales PRIMARIAS',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '20',
                                    'nombre' => 'Plan de Transferencias Documentales Secundarias',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '08',
                                    'nombre' => 'Política de Gestión Documental',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '48',
                            'nombre' => 'TRANSFERENCIAS DOCUMENTALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Transferencia Documental Primaria (Dependencias para AC - 
EVC-ESP)',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                    ],
                ],
                [
                    'codigo' => '13',
                    'nombre' => 'Control Interno',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Actas de comité de coordinación del Sistema de Control Interno',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Informe anual de Evaluación de Control Interno Contable (ECIC)',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Informe de Auditoria y seguimiento',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Informes a entes de control',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Informes de Austeridad en el Gasto',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '09',
                                    'nombre' => 'Informes de Evaluación y Seguimiento a la Gestión',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '18',
                                    'nombre' => 'Informes Pormenorizado Del Estado Del Control Interno',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '34',
                            'nombre' => 'PLANES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '13',
                                    'nombre' => 'Plan de mejoramiento institucional',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '33',
                                    'nombre' => 'Planes de auditoría',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Política de Control Interno',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '10',
                                    'nombre' => 'Política de integridad pública',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '36',
                            'nombre' => 'PROCEDIMIENTOS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Procedimiento para el manejo y declaración de conflictos de interés',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Procedimiento para el procesamiento de las denuncias recibidas (internas y externas)',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                    ],
                ],
            ],
            'series_sin_oficina' => [
                [
                    'codigo' => '01',
                    'nombre' => 'ACCIONES CONSTITUCIONALES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Acciones De Tutela',
                            'tipos' => [
                                ['nombre' => 'Demanda', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'auto', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'contestación de la acción', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'comunicación oficial', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'notificación', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'sentencia', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => [
                                'anios_gestion' => 2,
                                'anios_central' => 8,
                                'disposicion_final' => ['S'],
                                'procedimiento' => null,
                            ],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '02',
                    'nombre' => 'ACTAS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '04',
                            'nombre' => 'Actas de Comité de Conciliación.',
                            'tipos' => [
                                ['nombre' => 'Citación comité.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Acta de la sesión.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Listado de asistencia.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => [
                                'anios_gestion' => 2,
                                'anios_central' => 8,
                                'disposicion_final' => ['S'],
                                'procedimiento' => null,
                            ],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Actas de Comité de Contratos.',
                            'tipos' => [
                                ['nombre' => 'Citación comité.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Acta de la sesión.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Listado de asistencia.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Informes de Evaluación.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => [
                                'anios_gestion' => 2,
                                'anios_central' => 18,
                                'disposicion_final' => ['CT'],
                                'procedimiento' => null,
                            ],
                        ],
                        [
                            'codigo' => '11',
                            'nombre' => 'Actas de la Junta Directiva',
                            'tipos' => [
                                ['nombre' => 'Citación comité.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Acta de la sesión.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Listado de asistencia.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Informes de Evaluación.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => [
                                'anios_gestion' => 2,
                                'anios_central' => 8,
                                'disposicion_final' => ['CT'],
                                'procedimiento' => null,
                            ],
                        ],
                        [
                            'codigo' => '12',
                            'nombre' => 'Actas del Comité Disciplinario.',
                            'tipos' => [
                                ['nombre' => 'Citación comité.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Acta de la sesión.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Listado de asistencia.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Informes de Evaluación.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '03',
                    'nombre' => 'ACTOS ADMINISTRATIVOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Acuerdos de la Junta Directiva',
                            'tipos' => [
                                ['nombre' => 'Acuerdo de la Junta Directiva.', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => [
                                'anios_gestion' => 2,
                                'anios_central' => 8,
                                'disposicion_final' => ['CT'],
                                'procedimiento' => null,
                            ],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Resoluciones',
                            'tipos' => [
                                ['nombre' => 'Resolución', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '07',
                    'nombre' => 'CERTIFICADOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Certificación para Contratistas del Sector Público',
                            'tipos' => [
                                ['nombre' => 'Solicitud', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Certificación', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Certificado deguello de ganado menor y/o mayor',
                            'tipos' => [
                                ['nombre' => 'Solicitud', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Certificación', 'soporte' => 'Papel/Electrónico (PDF)'],
                                ['nombre' => 'Anexos de soporte.', 'soporte' => 'Papel/Electrónico (PDF)'],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Certificados De Ingresos Y Retención En La Fuente',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Certificados de Viabilidad del Servicio de Alumbrado Público',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Certificados laboral servidores',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '08',
                    'nombre' => 'CIRCULARES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Circulares Dispositivas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Circulares Informativas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '11',
                    'nombre' => 'CONCEPTOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Conceptos Jurídicos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '14',
                    'nombre' => 'CONTRATOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Contratos de arrendamiento',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Contratos de arrendamiento local comercial',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Contratos de Comodato',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Contratos de Consultoría',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Contratos de prestación de servicios',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Contratos de seguros',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '07',
                            'nombre' => 'Contratos de suministros',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'Contratos Interadministrativos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '15',
                    'nombre' => 'CONVENIOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Convenios interadministrativos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Convenios interinstitucionales',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '24',
                    'nombre' => 'INFORMES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '03',
                            'nombre' => 'Informes a entes de control',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'Informes de Empalmes',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '11',
                            'nombre' => 'Informes de Rendición de cuentas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '26',
                    'nombre' => 'INSTRUMENTOS DE CONTROL',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '09',
                            'nombre' => 'Instrumentos de control solicitudes y requerimientos de servicios de tecnologías de la información y comunicaciones',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '27',
                    'nombre' => 'INSTRUMENTOS DE GESTIÓN DE INFORMACIÓN PÚBLICA',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Esquemas de Publicación de Información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Índices de Información Clasificada y Reservada',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Registros de Activos de Información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '28',
                    'nombre' => 'INVENTARIOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'Inventario de activos de seguridad y privacidad de la información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '07',
                            'nombre' => 'Inventarios de Equipos de Cómputo',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '31',
                    'nombre' => 'LICENCIAS DE SOFTWARE',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '32',
                    'nombre' => 'MANUALES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '05',
                            'nombre' => 'Manuales de Gobierno en línea',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '10',
                            'nombre' => 'Manuales del Sistema de Gestión de Seguridad y Privacidad de la Información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '13',
                            'nombre' => 'Manuales Técnicos de Sistemas de Informacion y Hardware',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '34',
                    'nombre' => 'PLANES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '08',
                            'nombre' => 'Plan de Contingencia y Continuidad de Negocio',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '12',
                            'nombre' => 'Plan de Mantenimiento Infraestructura Tecnológica',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '14',
                            'nombre' => 'Plan de preservación digital a largo plazo',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '17',
                            'nombre' => 'Plan de Seguridad y Privacidad de la Información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '21',
                            'nombre' => 'Plan de Transformación Digital',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '22',
                            'nombre' => 'Plan de Tratamiento de Riesgos de Seguridad y Privacidad de la Información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '25',
                            'nombre' => 'Plan Estratégico de Tecnologías de la información (PETI).',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '35',
                    'nombre' => 'POLÍTICAS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '03',
                            'nombre' => 'Política ambiental',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Política de Gestión de la Calidad',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '07',
                            'nombre' => 'Política de gestión del conocimiento y la innovación.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '09',
                            'nombre' => 'Política de Gobierno Digital',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '13',
                            'nombre' => 'Política de Protección de datos personales e información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '15',
                            'nombre' => 'política de Seguridad digital',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '16',
                            'nombre' => 'Política de Seguridad privacidad de la información',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '18',
                            'nombre' => 'Política de Tecnologías de la información y las comunicaciones',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '21',
                            'nombre' => 'Política internet y correo electrónico oficial',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '22',
                            'nombre' => 'Política para prevención del Daño Antijurídico',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '37',
                    'nombre' => 'PROCESOS CONTRACTUALES DECLARADOS DESIERTOS O NO
ADJUDICADOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '38',
                    'nombre' => 'PROCESOS DE COBRO COACTIVO',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '39',
                    'nombre' => 'PROCESOS DE COBRO PERSUASIVO',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '40',
                    'nombre' => 'PROCESOS DISCIPLINARIOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '41',
                    'nombre' => 'PROCESOS JUDICIALES',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '42',
                    'nombre' => 'PROCESOS SANCIONATORIOS ADMINISTRATIVOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '44',
                    'nombre' => 'PROYECTOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Proyectos De Inversión',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Proyectos de transformación digital',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
            ],
        ],
        [
            'codigo' => '20',
            'nombre' => 'Alumbrado Público',
            'activo' => true,
            'oficinas' => [],
            'series_sin_oficina' => [
                [
                    'codigo' => '34',
                    'nombre' => 'PLANES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '10',
                            'nombre' => 'Plan de Manejo de Residuos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '29',
                            'nombre' => 'Plan Institucional Alumbrado Público.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
            ],
        ],
        [
            'codigo' => '30',
            'nombre' => 'Planta de Beneficio Animal',
            'activo' => true,
            'oficinas' => [],
            'series_sin_oficina' => [
                [
                    'codigo' => '08',
                    'nombre' => 'CIRCULARES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'Circulares Informativas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '20',
                    'nombre' => 'HISTORIALES DE MAQUINARIA Y EQUIPOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '26',
                    'nombre' => 'INSTRUMENTOS DE CONTROL',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'Instrumentos de Control de Estadísticas de Sacrificio (Bovinos)',
                            'tipos' => [
                                ['nombre' => 'Guía de Movilización expedida por el ICA', 'soporte' => ''],
                                ['nombre' => 'Tiquete de Báscula', 'soporte' => ''],
                                ['nombre' => 'Planilla entrada Bovinos.', 'soporte' => ''],
                                ['nombre' => 'Guía de Transporte de carne en canal, deshuesada y subproductos', 'soporte' => ''],
                                ['nombre' => 'Registro diario de sacrificio de Bovinos', 'soporte' => ''],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Instrumentos de Control de Estadísticas de Sacrificio (Porcinos)',
                            'tipos' => [
                                ['nombre' => 'Guía de Movilización expedida por el ICA', 'soporte' => ''],
                                ['nombre' => 'Tiquete de Báscula.', 'soporte' => ''],
                                ['nombre' => 'Planilla entrada Porcinos.', 'soporte' => ''],
                                ['nombre' => 'Guía de Transporte de carne en canal, deshuesada y subproductos', 'soporte' => ''],
                                ['nombre' => 'Registro diario de sacrificio de Porcinos', 'soporte' => ''],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Instrumentos De Control Ingreso De Visitantes',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Instrumentos De Control Recorrido Diario De Vehículos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'Instrumentos De Control Retiro De Elementos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '10',
                            'nombre' => 'Planilla de control horario de trabajo',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '32',
                    'nombre' => 'MANUALES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'Manual De Inspección Veterinaria',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '34',
                    'nombre' => 'PLANES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '06',
                            'nombre' => 'Plan de Capacitación personal manipulador, BPM y estado de salud.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '10',
                            'nombre' => 'Plan de Manejo de Residuos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '11',
                            'nombre' => 'Plan de Mantenimiento Infraestructura Física',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '15',
                            'nombre' => 'Plan de prevención, preparación y respuestas ante emergencias',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '32',
                            'nombre' => 'Plan Institucional Planta de Beneficio Animal.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '36',
                    'nombre' => 'PROCEDIMIENTOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '03',
                            'nombre' => 'Procedimientos Análisis de peligros y puntos críticos de control (HACCP',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Procedimientos de Inspección Ante Mortem',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Procedimientos de Inspección Post Mortem',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Procedimientos Operativos Estandarizados de 
Saneamiento (POES)',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '43',
                    'nombre' => 'PROGRAMAS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Programa Control integrado de plagas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Programa de calidad del Agua',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Programa de Control y seguimiento de 
proveedores y Materias Primas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Programa de Higiene y Sanidad del Personal',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Programa de Limpieza y Desinfección',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Programa de Manejo y disposición final de residuos sólidos y líquidos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '07',
                            'nombre' => 'Programa de Mantenimiento preventivo y calibración de equipos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '08',
                            'nombre' => 'Programa de muestreo Microbiológico.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '09',
                            'nombre' => 'Programa de Operaciones Sanitarias',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '11',
                            'nombre' => 'Programa de salud ocupacional y seguridad industrial',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '12',
                            'nombre' => 'Programa de Tolerancia Cero',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '14',
                            'nombre' => 'Programa de Trazabilidad',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '15',
                            'nombre' => 'Programa de Vigilancia Epidemiológica PVE',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
            ],
        ],
        [
            'codigo' => '40',
            'nombre' => 'Administración De Bienes Fiscales',
            'activo' => true,
            'oficinas' => [],
            'series_sin_oficina' => [
                [
                    'codigo' => '20',
                    'nombre' => 'HISTORIALES DE MAQUINARIA Y EQUIPOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '26',
                    'nombre' => 'INSTRUMENTOS DE CONTROL',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '08',
                            'nombre' => 'Instrumentos De Control Retiro De Elementos.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '',
                    'nombre' => 'INSTRUMENTOS DE CONTROL',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '10',
                            'nombre' => 'Planilla de control horario de trabajo',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '34',
                    'nombre' => 'PLANES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '10',
                            'nombre' => 'Plan de Manejo de Residuos.',
                            'tipos' => [
                                ['nombre' => 'Plan del Sistema de Gestión Ambiental.', 'soporte' => ''],
                                ['nombre' => 'Bitácoras de Residuos Peligrosos.', 'soporte' => ''],
                                ['nombre' => 'Bitácoras de Residuos Reciclables.', 'soporte' => ''],
                                ['nombre' => 'Registo Control de Disposición Residuos Sólidos.', 'soporte' => ''],
                                ['nombre' => 'Registro Transporte Residuos Solidos.', 'soporte' => ''],
                                ['nombre' => 'Matriz de Identificación de aspectos y evaluación de impactos ambientales.', 'soporte' => ''],
                                ['nombre' => 'Informe de Gestión.', 'soporte' => ''],
                            ],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '11',
                            'nombre' => 'Plan de Mantenimiento Infraestructura Física.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '15',
                            'nombre' => 'Plan de prevención, preparación y respuestas ante emergencias.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '28',
                            'nombre' => 'Plan Institucional Administración de Bienes Fiscales.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '43',
                    'nombre' => 'PROGRAMAS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Programa Control integrado de plagas',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Programa de calidad del Agua',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Programa de Limpieza y Desinfección',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '18',
                            'nombre' => 'Programas de capacitación del personal de la Plaza de
Mercado.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
            ],
        ],
        [
            'codigo' => '50',
            'nombre' => 'Área Administrativa',
            'activo' => true,
            'oficinas' => [
                [
                    'codigo' => '51',
                    'nombre' => 'Contabilidad',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '13',
                                    'nombre' => 'Actas del Comité Financiero y de Sostenibilidad Económico',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'ANTEPROYECTOS DE PRESUPUESTO',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'BOLETINES DE DEUDORES MOROSOS DEL ESTADO',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '09',
                            'nombre' => 'COMPROBANTES CONTABLES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Comprobantes contables de Egreso',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '12',
                            'nombre' => 'CONCILIACIONES BANCARIAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => 'N/A',
                                    'nombre' => '',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '16',
                            'nombre' => 'DECLARACIONES TRIBUTARIAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Declaración bimestral de Impuestos sobre las Ventas – IVA',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Declaración de Renta y Complementarios o de Ingresos y Patrimonio para Personas Jurídicas y Asimiladas, Personas Naturales y Asimiladas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Declaración de Retención de Industria y Comercio - RETEICA',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Declaración Impuesto de Industria y Comercio - ICA',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Declaración mensual de retención en la fuente',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '18',
                            'nombre' => 'ESTADOS FINANCIEROS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Estados Financieros de Propósito General.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Informes a entes de control',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Informes de ejecución presupuestal',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '17',
                                    'nombre' => 'Informes Exógena',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '30',
                            'nombre' => 'LIBROS CONTABLES PRINCIPALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Libro Diario',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Libro Mayor',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Política contable',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                    ],
                ],
                [
                    'codigo' => '52',
                    'nombre' => 'Talento Humano',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '02',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Actas de Comisión de Personal',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'ACTAS DE COMITÉ BIENESTAR SOCIAL E INCENTIVOS',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '06',
                                    'nombre' => 'Actas de comité de convivencia laboral',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '',
                            'nombre' => 'ACTAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '09',
                                    'nombre' => 'Actas de comité paritario de salud y seguridad en el trabajo COPASST',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '52.08',
                            'nombre' => 'CIRCULARES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Circulares Informativas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '52.22',
                            'nombre' => 'HISTORIAS LABORALES',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '52.23',
                            'nombre' => 'HISTORIAS PRÁCTICAS LABORALES',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '52.24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Informes de Activos Fijos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '19',
                                    'nombre' => 'Informes Trimestrales del Comité de Convivencia Laboral',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '52.32',
                            'nombre' => 'MANUALES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Manual de Convivencia Laboral',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '12',
                                    'nombre' => 'Manuales Específicos de Funciones, Requisitos y Competencias Laborales',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '52.33',
                            'nombre' => 'NÓMINA',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '34',
                            'nombre' => 'PLANES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Plan Anual de Adquisiciones',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Plan Anual de Empleos Vacantes',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Plan anual de incentivos institucionales',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Plan de Bienestar e Incentivos',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '16',
                                    'nombre' => 'Plan de Previsión de Recursos Humanos.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '18',
                                    'nombre' => 'Plan de trabajo anual del Sistema de Gestión de Seguridad y Salud en el Trabajo – SG - SST',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '23',
                                    'nombre' => 'Plan de vacaciones',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '26',
                                    'nombre' => 'Plan Estratégico del Talento Humano',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '31',
                                    'nombre' => 'Plan institucional de capacitación - PIC',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '35',
                            'nombre' => 'POLÍTICAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '11',
                                    'nombre' => 'Política de Prevención de acoso laboral, sexual y contra la violencia de Género.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '12',
                                    'nombre' => 'Política de Prevención de Consumo de Tabaco, Alcohol y otras sustancias Psicoactivas',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '17',
                                    'nombre' => 'Política de seguridad Víal',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '23',
                                    'nombre' => 'Política y objetivos del sistema general de seguridad y salud en el trabajo SG-SST.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '36',
                            'nombre' => 'PROCEDIMIENTOS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Procesos y procedimientos establecidos en la entidad',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '43',
                            'nombre' => 'PROGRAMAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '10',
                                    'nombre' => 'Programa de reinducción',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '17',
                                    'nombre' => 'Programas de bienestar social',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '46',
                            'nombre' => 'REGLAMENTOS INTERNOS DE TRABAJO',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                ],
                [
                    'codigo' => '53',
                    'nombre' => 'Tesorería',
                    'activo' => true,
                    'series' => [
                        [
                            'codigo' => '06',
                            'nombre' => 'BOLETÍNES DIARIOS DE TESORERÍA',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '09',
                            'nombre' => 'COMPROBANTES CONTABLES',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '24',
                            'nombre' => 'INFORMES',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Informes a entes de control',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '26',
                            'nombre' => 'INSTRUMENTOS DE CONTROL',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Instrumentos de Control de recaudo del valor de los arrendamientos de la Paza de Mercado.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '29',
                            'nombre' => 'LIBROS CONTABLES AUXILIARES',
                            'activo' => true,
                            'subseries' => [],
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '43',
                            'nombre' => 'PROGRAMAS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '16',
                                    'nombre' => 'Programas Anuales Mensualizados de Caja PAC.',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                        [
                            'codigo' => '45',
                            'nombre' => 'REGISTROS',
                            'activo' => true,
                            'subseries' => [
                                [
                                    'codigo' => '01',
                                    'nombre' => 'Contribución estampilla Para la Justicia Familiar',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '02',
                                    'nombre' => 'Contribución estampilla Pro Bienestar del Adulto Mayor',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '03',
                                    'nombre' => 'Contribución estampilla Pro Cultura',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '04',
                                    'nombre' => 'Contribución Estampilla Pro Hospital',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '05',
                                    'nombre' => 'Contribución Estampilla Pro Universidad del Pacífico Omar Barona Murillo',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '06',
                                    'nombre' => 'Contribución Estampilla Pro Universidad del Valle',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '07',
                                    'nombre' => 'Contribución estampilla tasa ProDeporte',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                                [
                                    'codigo' => '08',
                                    'nombre' => 'Registros movimientos diarios de Caja Menor',
                                    'tipos' => [],
                                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                                ],
                            ],
                            'tipos' => [],
                        ],
                    ],
                ],
            ],
            'series_sin_oficina' => [
                [
                    'codigo' => '10',
                    'nombre' => 'COMPROBANTES DE ALMACÉN',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Comprobantes de Baja de Bienes de Almacén',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '02',
                            'nombre' => 'Comprobantes de Egreso de Bienes al
Almacén',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '03',
                            'nombre' => 'Comprobantes de Ingreso de Bienes al
Almacén',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Comprobantes de Reintegro de Bienes al
Almacén',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Comprobantes de Traslado de Bienes',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '19',
                    'nombre' => 'HISTORIALES DE BIENES INMUEBLES',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '20',
                    'nombre' => 'HISTORIALES DE MAQUINARIA Y EQUIPOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '21',
                    'nombre' => 'HISTORIALES DE VEHÍCULOS',
                    'activo' => true,
                    'subseries' => [],
                    'tipos' => [],
                    'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                ],
                [
                    'codigo' => '26',
                    'nombre' => 'INSTRUMENTOS DE CONTROL',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '08',
                            'nombre' => 'Instrumentos De Control Retiro De Elementos.',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '28',
                    'nombre' => 'INVENTARIOS',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '01',
                            'nombre' => 'Inventario Activos fijos, depreciación, amortización y ajustes',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '04',
                            'nombre' => 'Inventario general anual de bienes de almacén',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '05',
                            'nombre' => 'Inventarios de Bienes de Consumo y Devolutivos',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '06',
                            'nombre' => 'Inventarios de Bienes Individuales',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
                [
                    'codigo' => '34',
                    'nombre' => 'PLANES',
                    'activo' => true,
                    'subseries' => [
                        [
                            'codigo' => '11',
                            'nombre' => 'Plan de Mantenimiento Infraestructura Física',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                        [
                            'codigo' => '15',
                            'nombre' => 'Plan de prevención, preparación y respuestas ante emergencias',
                            'tipos' => [],
                            'retencion' => ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null],
                        ],
                    ],
                    'tipos' => [],
                ],
            ],
        ],
    ],
];
