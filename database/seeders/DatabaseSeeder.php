<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@workia.bo'],
            [
                'name' => 'Administrador Workia',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
                'activo' => true,
            ]
        );

        // Categorías
        $categorias = [
            ['nombre' => 'Tecnología', 'icono' => 'laptop-code'],
            ['nombre' => 'Administración', 'icono' => 'briefcase'],
            ['nombre' => 'Salud', 'icono' => 'heartbeat'],
            ['nombre' => 'Educación', 'icono' => 'graduation-cap'],
            ['nombre' => 'Minería', 'icono' => 'hard-hat'],
            ['nombre' => 'Construcción', 'icono' => 'building'],
            ['nombre' => 'Comercio y Ventas', 'icono' => 'store'],
            ['nombre' => 'Finanzas', 'icono' => 'chart-line'],
            ['nombre' => 'Marketing', 'icono' => 'bullhorn'],
            ['nombre' => 'Logística', 'icono' => 'truck'],
            ['nombre' => 'Juridico y Legal', 'icono' => 'gavel'],
            ['nombre' => 'Arte y Diseño', 'icono' => 'palette'],
        ];

        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(['nombre' => $cat['nombre']], $cat);
        }

        $this->call(OfertasSeeder::class);
    }
}
