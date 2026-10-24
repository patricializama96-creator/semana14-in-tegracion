<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ComercioSeeder extends Seeder
{
    /**
     * Datos de ejemplo (Semana 6-12), ahora con dueño:
     * - Ana: Café Amanecer (con transacciones) y Pupusería Doña Marta.
     * - Carlos: Ferretería El Tornillo (sin transacciones, para probar @empty).
     */
    public function run(): void
    {
        $ana = User::where('email', 'ana@taskboard.test')->firstOrFail();
        $carlos = User::where('email', 'carlos@taskboard.test')->firstOrFail();

        $cafeAmanecer = $ana->comercios()->create([
            'nombre_comercio' => 'Café Amanecer',
            'rubro' => 'Restaurante',
            'telefono' => '2222-1234',
        ]);

        $cafeAmanecer->transacciones()->createMany([
            [
                'monto' => 45.00,
                'cliente_nombre' => 'María López',
                'estado' => 'Completada',
            ],
            [
                'monto' => 12.50,
                'cliente_nombre' => 'Juan Pérez',
                'estado' => 'Iniciada',
            ],
        ]);

        $carlos->comercios()->create([
            'nombre_comercio' => 'Ferretería El Tornillo',
            'rubro' => 'Ferretería',
            'telefono' => '2222-5678',
        ]);

        $pupuseria = $ana->comercios()->create([
            'nombre_comercio' => 'Pupusería Doña Marta',
            'rubro' => 'Restaurante',
            'telefono' => '2222-9012',
        ]);

        $pupuseria->transacciones()->create([
            'monto' => 8.00,
            'cliente_nombre' => 'Carlos Ramírez',
            'estado' => 'Fallida',
        ]);
    }
}
