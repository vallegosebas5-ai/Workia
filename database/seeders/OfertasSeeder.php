<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OfertasSeeder extends Seeder
{
    public function run(): void
    {
        $empresasData = [
            [
                'user' => [
                    'name'     => 'TechBolivia S.R.L.',
                    'email'    => 'rrhh@techbolivia.bo',
                    'password' => Hash::make('empresa1234'),
                    'role'     => 'empresa',
                    'activo'   => true,
                ],
                'empresa' => [
                    'razon_social' => 'TechBolivia S.R.L.',
                    'nit'          => '1234567890',
                    'rubro'        => 'Tecnología y Software',
                    'descripcion'  => 'Empresa boliviana de desarrollo de software y soluciones tecnológicas con más de 10 años en el mercado.',
                    'sitio_web'    => 'https://techbolivia.bo',
                    'ciudad'       => 'La Paz',
                    'telefono'     => '+591 2 2441234',
                    'verificada'   => true,
                ],
            ],
            [
                'user' => [
                    'name'     => 'Minera Andes Bolivia',
                    'email'    => 'rrhh@mineraandes.bo',
                    'password' => Hash::make('empresa1234'),
                    'role'     => 'empresa',
                    'activo'   => true,
                ],
                'empresa' => [
                    'razon_social' => 'Minera Andes Bolivia S.A.',
                    'nit'          => '9876543210',
                    'rubro'        => 'Minería y Recursos Naturales',
                    'descripcion'  => 'Empresa dedicada a la exploración y explotación de minerales en el altiplano boliviano.',
                    'sitio_web'    => 'https://mineraandes.bo',
                    'ciudad'       => 'Oruro',
                    'telefono'     => '+591 2 5221234',
                    'verificada'   => true,
                ],
            ],
            [
                'user' => [
                    'name'     => 'Clínica Santa Cruz Salud',
                    'email'    => 'rrhh@sczsalud.bo',
                    'password' => Hash::make('empresa1234'),
                    'role'     => 'empresa',
                    'activo'   => true,
                ],
                'empresa' => [
                    'razon_social' => 'Clínica Santa Cruz Salud S.R.L.',
                    'nit'          => '4561237890',
                    'rubro'        => 'Salud y Medicina',
                    'descripcion'  => 'Centro médico privado con especialidades en medicina general, pediatría, cardiología y traumatología.',
                    'sitio_web'    => 'https://sczsalud.bo',
                    'ciudad'       => 'Santa Cruz',
                    'telefono'     => '+591 3 3441234',
                    'verificada'   => true,
                ],
            ],
            [
                'user' => [
                    'name'     => 'Constructora Pachamama',
                    'email'    => 'rrhh@pachamama.bo',
                    'password' => Hash::make('empresa1234'),
                    'role'     => 'empresa',
                    'activo'   => true,
                ],
                'empresa' => [
                    'razon_social' => 'Constructora Pachamama S.A.',
                    'nit'          => '7890123456',
                    'rubro'        => 'Construcción e Ingeniería Civil',
                    'descripcion'  => 'Empresa constructora con proyectos residenciales, comerciales e infraestructura vial en Bolivia.',
                    'sitio_web'    => 'https://pachamama.bo',
                    'ciudad'       => 'Cochabamba',
                    'telefono'     => '+591 4 4561234',
                    'verificada'   => true,
                ],
            ],
            [
                'user' => [
                    'name'     => 'BancoSol Bolivia',
                    'email'    => 'rrhh@bancosol.bo',
                    'password' => Hash::make('empresa1234'),
                    'role'     => 'empresa',
                    'activo'   => true,
                ],
                'empresa' => [
                    'razon_social' => 'BancoSol S.A.',
                    'nit'          => '3216549870',
                    'rubro'        => 'Servicios Financieros y Banca',
                    'descripcion'  => 'Banco boliviano líder en microfinanzas y servicios financieros para personas y empresas.',
                    'sitio_web'    => 'https://bancosol.bo',
                    'ciudad'       => 'La Paz',
                    'telefono'     => '+591 2 3141234',
                    'verificada'   => true,
                ],
            ],
        ];

        $empresas = [];
        foreach ($empresasData as $data) {
            $user = User::firstOrCreate(['email' => $data['user']['email']], $data['user']);
            $empresa = Empresa::firstOrCreate(['user_id' => $user->id], array_merge($data['empresa'], ['user_id' => $user->id]));
            $empresas[$data['empresa']['razon_social']] = $empresa;
        }

        $cat = Categoria::pluck('id', 'nombre');

        $ofertas = [
            // TechBolivia
            [
                'empresa_id'     => $empresas['TechBolivia S.R.L.']->id,
                'categoria_id'   => $cat['Tecnología'],
                'titulo'         => 'Desarrollador Full Stack Laravel + Vue.js',
                'descripcion'    => "Buscamos un desarrollador Full Stack con experiencia en Laravel y Vue.js para unirse a nuestro equipo de producto.\n\nResponsabilidades:\n- Desarrollar y mantener aplicaciones web usando Laravel y Vue.js\n- Colaborar con el equipo de diseño para implementar interfaces de usuario\n- Participar en revisiones de código y contribuir a la arquitectura del sistema\n- Escribir pruebas unitarias y de integración",
                'requisitos'     => "- 2+ años de experiencia con Laravel (v9 o superior)\n- Conocimiento sólido de Vue.js 3 y Composition API\n- Manejo de bases de datos MySQL y Redis\n- Experiencia con Git y metodologías ágiles\n- Deseable: conocimiento de Docker y CI/CD",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 5000,
                'salario_max'    => 8000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'hibrido',
                'fecha_limite'   => now()->addDays(30)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 2,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['TechBolivia S.R.L.']->id,
                'categoria_id'   => $cat['Tecnología'],
                'titulo'         => 'Analista de Soporte TI',
                'descripcion'    => "Buscamos un Analista de Soporte TI para brindar asistencia técnica a nuestros clientes internos y externos.\n\nResponsabilidades:\n- Soporte técnico de nivel 1 y 2\n- Instalación y configuración de equipos y software\n- Documentación de incidencias y resoluciones\n- Monitoreo de infraestructura de red",
                'requisitos'     => "- Técnico en Sistemas o carrera afín\n- Conocimientos en Windows Server y redes TCP/IP\n- Experiencia mínima de 1 año en soporte técnico\n- Disponibilidad para turnos rotativos",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 2800,
                'salario_max'    => 3500,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(20)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 1,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['TechBolivia S.R.L.']->id,
                'categoria_id'   => $cat['Marketing'],
                'titulo'         => 'Diseñador UX/UI',
                'descripcion'    => "Necesitamos un Diseñador UX/UI creativo para mejorar la experiencia de nuestros productos digitales.\n\nResponsabilidades:\n- Diseñar wireframes, prototipos y flujos de usuario\n- Realizar investigación de usuarios y pruebas de usabilidad\n- Colaborar con el equipo de desarrollo para implementar diseños\n- Mantener el sistema de diseño de la empresa",
                'requisitos'     => "- Portafolio demostrable de proyectos UX/UI\n- Dominio de Figma y Adobe XD\n- Conocimientos básicos de HTML/CSS\n- Experiencia con Design Systems\n- Habilidades de comunicación y trabajo en equipo",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 4000,
                'salario_max'    => 6000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'remoto',
                'fecha_limite'   => now()->addDays(25)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 1,
                'requiere_cv'    => true,
            ],

            // Minera Andes
            [
                'empresa_id'     => $empresas['Minera Andes Bolivia S.A.']->id,
                'categoria_id'   => $cat['Minería'],
                'titulo'         => 'Ingeniero de Minas Senior',
                'descripcion'    => "Incorporamos un Ingeniero de Minas Senior para supervisar operaciones de extracción en nuestra planta de Oruro.\n\nResponsabilidades:\n- Planificación y supervisión de operaciones mineras\n- Control de costos y optimización de procesos\n- Gestión del equipo operativo (30+ personas)\n- Cumplimiento de normativas de seguridad y medioambiente",
                'requisitos'     => "- Licenciatura en Ingeniería de Minas\n- 5+ años de experiencia en operaciones mineras\n- Conocimiento en software de planificación minera (Surpac, Vulcan)\n- Experiencia en gestión de seguridad ocupacional\n- Disponibilidad para trabajo en campo",
                'ubicacion'      => 'Oruro, Bolivia',
                'salario_min'    => 12000,
                'salario_max'    => 18000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(45)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 1,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['Minera Andes Bolivia S.A.']->id,
                'categoria_id'   => $cat['Minería'],
                'titulo'         => 'Técnico en Explosivos',
                'descripcion'    => "Requerimos Técnico en Explosivos certificado para operaciones de voladura controlada en yacimiento minero.\n\nResponsabilidades:\n- Preparación y ejecución de voladuras\n- Control y almacenamiento de materiales explosivos\n- Registros de consumo y reportes de operación\n- Coordinación con el área de seguridad",
                'requisitos'     => "- Certificación SENASAG/DGAAE en manejo de explosivos vigente\n- 3+ años de experiencia en operaciones de voladura\n- Curso de primeros auxilios\n- Licencia de conducir categoría B",
                'ubicacion'      => 'Oruro, Bolivia',
                'salario_min'    => 6000,
                'salario_max'    => 9000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(30)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 3,
                'requiere_cv'    => true,
            ],

            // Clínica Santa Cruz Salud
            [
                'empresa_id'     => $empresas['Clínica Santa Cruz Salud S.R.L.']->id,
                'categoria_id'   => $cat['Salud'],
                'titulo'         => 'Médico General',
                'descripcion'    => "Clínica Santa Cruz Salud incorpora Médico General para consulta externa y atención de urgencias.\n\nResponsabilidades:\n- Atención de consulta externa y urgencias\n- Elaboración de historias clínicas\n- Coordinación con especialistas\n- Participación en guardias nocturnas rotativas",
                'requisitos'     => "- Título de Médico Cirujano con registro en el Colegio Médico\n- Matrícula profesional vigente\n- Experiencia mínima de 1 año en práctica clínica\n- ATLS/ACLS deseable\n- Disponibilidad para guardias",
                'ubicacion'      => 'Santa Cruz, Bolivia',
                'salario_min'    => 8000,
                'salario_max'    => 12000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(20)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 2,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['Clínica Santa Cruz Salud S.R.L.']->id,
                'categoria_id'   => $cat['Salud'],
                'titulo'         => 'Enfermero/a Titulado/a',
                'descripcion'    => "Incorporamos Enfermeros/as Titulados/as para el área de hospitalización y cuidados intensivos.\n\nResponsabilidades:\n- Cuidado integral del paciente hospitalizado\n- Administración de medicamentos y tratamientos\n- Registro en expedientes clínicos\n- Coordinación con el equipo médico",
                'requisitos'     => "- Licenciatura en Enfermería con registro profesional\n- Experiencia mínima de 6 meses en hospitalización\n- Conocimientos en manejo de equipos médicos básicos\n- Disponibilidad para turnos rotativos (mañana, tarde, noche)",
                'ubicacion'      => 'Santa Cruz, Bolivia',
                'salario_min'    => 4500,
                'salario_max'    => 6000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(15)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 4,
                'requiere_cv'    => true,
            ],

            // Constructora Pachamama
            [
                'empresa_id'     => $empresas['Constructora Pachamama S.A.']->id,
                'categoria_id'   => $cat['Construcción'],
                'titulo'         => 'Ingeniero Civil Residente de Obra',
                'descripcion'    => "Buscamos Ingeniero Civil para ejercer como Residente de Obra en proyecto de edificio multifamiliar en Cochabamba.\n\nResponsabilidades:\n- Dirección técnica y supervisión diaria de obra\n- Control de cronograma, costos y calidad\n- Coordinación con proveedores y subcontratistas\n- Elaboración de informes semanales y valorizaciones",
                'requisitos'     => "- Ingeniería Civil titulada con registro en el Colegio de Ingenieros\n- 3+ años de experiencia como residente de obras verticales\n- Manejo de S10, MS Project y AutoCAD\n- Disponibilidad para trabajo en obra a tiempo completo",
                'ubicacion'      => 'Cochabamba, Bolivia',
                'salario_min'    => 7000,
                'salario_max'    => 10000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(35)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 1,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['Constructora Pachamama S.A.']->id,
                'categoria_id'   => $cat['Construcción'],
                'titulo'         => 'Maestro Mayor de Obra',
                'descripcion'    => "Requerimos Maestro Mayor de Obra con experiencia en construcción civil para proyecto en Cochabamba.\n\nResponsabilidades:\n- Supervisión directa de cuadrillas de trabajo\n- Control de materiales y rendimiento en obra\n- Coordinación con el Residente de Obra\n- Cumplimiento de normas de seguridad en obra",
                'requisitos'     => "- Curso técnico en construcción civil o experiencia equivalente\n- 5+ años como maestro mayor\n- Conocimiento en lectura de planos\n- Referencias comprobables de obras anteriores",
                'ubicacion'      => 'Cochabamba, Bolivia',
                'salario_min'    => 4000,
                'salario_max'    => 5500,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(20)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 2,
                'requiere_cv'    => false,
            ],

            // BancoSol
            [
                'empresa_id'     => $empresas['BancoSol S.A.']->id,
                'categoria_id'   => $cat['Finanzas'],
                'titulo'         => 'Asesor de Créditos',
                'descripcion'    => "BancoSol busca Asesores de Créditos para atención a clientes y gestión de cartera en La Paz.\n\nResponsabilidades:\n- Evaluación y aprobación de solicitudes de crédito\n- Gestión y seguimiento de cartera asignada\n- Recuperación de créditos en mora\n- Captación de nuevos clientes",
                'requisitos'     => "- Licenciatura en Economía, Finanzas, Administración o afín\n- 1+ año de experiencia en entidades financieras\n- Conocimiento del sistema financiero boliviano\n- Habilidades de negociación y orientación al cliente\n- Licencia de conducir categoría B (deseable)",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 3500,
                'salario_max'    => 5000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(25)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 5,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['BancoSol S.A.']->id,
                'categoria_id'   => $cat['Tecnología'],
                'titulo'         => 'Analista de Sistemas Financieros',
                'descripcion'    => "Incorporamos un Analista de Sistemas Financieros para el área de Tecnología Bancaria.\n\nResponsabilidades:\n- Soporte y mantenimiento de sistemas bancarios core\n- Análisis de requerimientos y documentación funcional\n- Coordinación con proveedores de software financiero\n- Elaboración de reportes regulatorios para la ASFI",
                'requisitos'     => "- Ingeniería en Sistemas, Informática o afín\n- 2+ años de experiencia en sistemas financieros\n- Conocimiento de SQL Server y bases de datos relacionales\n- Experiencia con sistemas core bancarios (Cobis, T24 o similar)\n- Conocimiento de regulaciones ASFI deseable",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 6000,
                'salario_max'    => 9000,
                'tipo_contrato'  => 'tiempo_completo',
                'modalidad'      => 'hibrido',
                'fecha_limite'   => now()->addDays(40)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 1,
                'requiere_cv'    => true,
            ],
            [
                'empresa_id'     => $empresas['BancoSol S.A.']->id,
                'categoria_id'   => $cat['Administración'],
                'titulo'         => 'Pasante Administración Bancaria',
                'descripcion'    => "Ofrecemos pasantía remunerada en el área de Operaciones y Atención al Cliente de BancoSol.\n\nResponsabilidades:\n- Apoyo en atención al cliente en ventanilla\n- Procesamiento de transacciones básicas\n- Archivo y gestión documental\n- Apoyo en actividades administrativas del área",
                'requisitos'     => "- Estudiante de últimos semestres en Administración, Economía o Finanzas\n- Disponibilidad de tiempo completo por 6 meses\n- Buen manejo de Office (Excel intermedio)\n- Actitud de servicio y trabajo en equipo",
                'ubicacion'      => 'La Paz, Bolivia',
                'salario_min'    => 1500,
                'salario_max'    => 2000,
                'tipo_contrato'  => 'practicante',
                'modalidad'      => 'presencial',
                'fecha_limite'   => now()->addDays(15)->toDateString(),
                'estado'         => 'activa',
                'vacantes'       => 3,
                'requiere_cv'    => true,
            ],
        ];

        if (Oferta::count() === 0) {
            foreach ($ofertas as $oferta) {
                Oferta::create($oferta);
            }
            $this->command->info('✓ ' . count($ofertas) . ' ofertas de trabajo creadas correctamente.');
        } else {
            $this->command->info('✓ Ofertas ya existentes, seeder omitido.');
        }
    }
}
