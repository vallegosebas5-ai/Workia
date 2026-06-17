<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\User;
use Illuminate\Database\Seeder;

class OfertasJorgeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'jorgue12@gmail.com')->first();

        if (! $user) {
            $this->command->error('No se encontró el usuario jorgue12@gmail.com. Verifica que esté registrado.');
            return;
        }

        $empresa = Empresa::where('user_id', $user->id)->first();

        if (! $empresa) {
            $this->command->error('El usuario Jorge no tiene una empresa registrada. Debe completar su perfil de empresa primero.');
            return;
        }

        $cat = Categoria::pluck('id', 'nombre');

        $ofertas = [
            [
                'empresa_id'    => $empresa->id,
                'categoria_id'  => $cat['Administración'],
                'titulo'        => 'Asistente Administrativo',
                'descripcion'   => "Buscamos Asistente Administrativo para apoyar las operaciones diarias de nuestra empresa.\n\nResponsabilidades:\n- Gestión de agenda y correspondencia\n- Atención telefónica y presencial a clientes\n- Archivo y organización de documentos\n- Apoyo en facturación y control de pagos\n- Coordinación con otras áreas de la empresa",
                'requisitos'    => "- Técnico o Licenciado en Administración de Empresas o carrera afín\n- Manejo de paquete Office (Word, Excel, Outlook)\n- Buena presentación y habilidades de comunicación\n- Experiencia mínima de 1 año en puestos similares\n- Conocimiento básico de contabilidad deseable",
                'ubicacion'     => $empresa->ciudad . ', Bolivia',
                'salario_min'   => 2500,
                'salario_max'   => 3500,
                'tipo_contrato' => 'tiempo_completo',
                'modalidad'     => 'presencial',
                'fecha_limite'  => now()->addDays(25)->toDateString(),
                'estado'        => 'activa',
                'vacantes'      => 1,
                'requiere_cv'   => true,
            ],
            [
                'empresa_id'    => $empresa->id,
                'categoria_id'  => $cat['Comercio y Ventas'],
                'titulo'        => 'Vendedor/a Externo',
                'descripcion'   => "Necesitamos Vendedor/a Externo dinámico para ampliar nuestra cartera de clientes.\n\nResponsabilidades:\n- Prospección y captación de nuevos clientes\n- Seguimiento y fidelización de cartera existente\n- Presentación y demostración de productos/servicios\n- Cumplimiento de metas mensuales de ventas\n- Elaboración de reportes de visitas y resultados",
                'requisitos'    => "- Experiencia mínima de 1 año en ventas externas\n- Habilidades de negociación y orientación a resultados\n- Licencia de conducir categoría B (indispensable)\n- Disponibilidad para movilizarse en la ciudad\n- Actitud proactiva y trabajo bajo presión",
                'ubicacion'     => $empresa->ciudad . ', Bolivia',
                'salario_min'   => 2000,
                'salario_max'   => 4000,
                'tipo_contrato' => 'tiempo_completo',
                'modalidad'     => 'presencial',
                'fecha_limite'  => now()->addDays(20)->toDateString(),
                'estado'        => 'activa',
                'vacantes'      => 2,
                'requiere_cv'   => true,
            ],
            [
                'empresa_id'    => $empresa->id,
                'categoria_id'  => $cat['Administración'],
                'titulo'        => 'Contador/a General',
                'descripcion'   => "Incorporamos Contador/a General para la gestión contable y tributaria de la empresa.\n\nResponsabilidades:\n- Registro y control de operaciones contables\n- Elaboración y presentación de declaraciones tributarias al SIN\n- Preparación de estados financieros mensuales\n- Control de cuentas por cobrar y por pagar\n- Coordinación con la auditoría externa",
                'requisitos'    => "- Licenciatura en Contaduría Pública o Auditoría Financiera\n- Matrícula profesional vigente\n- Dominio de software contable (SAGE, Softland o similar)\n- Conocimiento actualizado de normativa tributaria boliviana\n- 2+ años de experiencia en posiciones similares",
                'ubicacion'     => $empresa->ciudad . ', Bolivia',
                'salario_min'   => 4000,
                'salario_max'   => 6000,
                'tipo_contrato' => 'tiempo_completo',
                'modalidad'     => 'presencial',
                'fecha_limite'  => now()->addDays(30)->toDateString(),
                'estado'        => 'activa',
                'vacantes'      => 1,
                'requiere_cv'   => true,
            ],
            [
                'empresa_id'    => $empresa->id,
                'categoria_id'  => $cat['Comercio y Ventas'],
                'titulo'        => 'Cajero/a',
                'descripcion'   => "Buscamos Cajero/a responsable para el manejo de caja y atención al cliente.\n\nResponsabilidades:\n- Recepción y procesamiento de pagos en efectivo y tarjeta\n- Cuadre y cierre de caja diario\n- Atención y orientación al cliente en punto de venta\n- Emisión de facturas y notas de venta\n- Reporte de diferencias e incidencias al supervisor",
                'requisitos'    => "- Bachiller o estudiante universitario\n- Experiencia mínima de 6 meses en manejo de caja\n- Habilidad numérica y atención al detalle\n- Honestidad y responsabilidad comprobables\n- Disponibilidad para turnos rotativos",
                'ubicacion'     => $empresa->ciudad . ', Bolivia',
                'salario_min'   => 2000,
                'salario_max'   => 2800,
                'tipo_contrato' => 'tiempo_completo',
                'modalidad'     => 'presencial',
                'fecha_limite'  => now()->addDays(15)->toDateString(),
                'estado'        => 'activa',
                'vacantes'      => 2,
                'requiere_cv'   => false,
            ],
            [
                'empresa_id'    => $empresa->id,
                'categoria_id'  => $cat['Logística'],
                'titulo'        => 'Encargado de Almacén',
                'descripcion'   => "Requerimos Encargado de Almacén para control de inventarios y gestión de stock.\n\nResponsabilidades:\n- Recepción, verificación y registro de mercadería\n- Control de inventarios y kardex\n- Despacho de pedidos internos y externos\n- Coordinación con proveedores y área de compras\n- Mantenimiento del orden y limpieza del almacén",
                'requisitos'    => "- Técnico en Logística, Administración o experiencia equivalente\n- Conocimiento de sistemas de inventario\n- Manejo básico de Excel\n- Experiencia mínima de 1 año en almacenes o depósitos\n- Capacidad para trabajo físico y manejo de cargas",
                'ubicacion'     => $empresa->ciudad . ', Bolivia',
                'salario_min'   => 2500,
                'salario_max'   => 3500,
                'tipo_contrato' => 'tiempo_completo',
                'modalidad'     => 'presencial',
                'fecha_limite'  => now()->addDays(20)->toDateString(),
                'estado'        => 'activa',
                'vacantes'      => 1,
                'requiere_cv'   => true,
            ],
        ];

        foreach ($ofertas as $oferta) {
            Oferta::create($oferta);
        }

        $this->command->info("✓ {$empresa->razon_social}: " . count($ofertas) . ' ofertas creadas correctamente.');
    }
}
