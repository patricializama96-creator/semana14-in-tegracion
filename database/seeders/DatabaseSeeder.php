<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Semana 6 · Eloquent ORM
     * Punto de entrada de todos los seeders del proyecto.
     * Semana 12: se crean primero los usuarios (dueños de los comercios).
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ana López',
            'email' => 'ana@taskboard.test',
            'password' => 'password123', // el cast 'hashed' la cifra
        ]);

        User::create([
            'name' => 'Carlos Pérez',
            'email' => 'carlos@taskboard.test',
            'password' => 'password123',
        ]);

        $this->call([
            ComercioSeeder::class,
        ]);
    }
}
