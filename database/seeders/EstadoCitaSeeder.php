<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_citas')->updateOrInsert(
            [
                'id'=>1,
            ],
            [
                'nombre' => 'Sin Confirmar',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('estado_citas')->updateOrInsert(
            [
                'id'=>2,
            ],
            [
                'nombre' => 'Confirmada',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('estado_citas')->updateOrInsert(
            [
                'id'=>3,
            ],
            [
                'nombre' => 'Rechazada',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
    }
}
