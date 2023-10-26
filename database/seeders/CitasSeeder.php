<?php

namespace Database\Seeders;

use App\Models\Citas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear citas de ejemplo
        Citas::create([
            'fecha_cita' => now(),
            'mensaje' => 'Mensaje de ejemplo para la cita 1',
            'user_id' => 66, // Cambia el user_id según tu configuración
            'estado_cita_id' => 1, // Cambia el estado_cita_id según tu configuración
        ]);

        // Agrega más citas según sea necesario
    }
}
