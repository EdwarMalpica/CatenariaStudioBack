<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('horarios')->updateOrInsert(
            [
                'dia' => 'Lunes',
                'active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        DB::table('horarios')->updateOrInsert(
            [
                'dia' => 'Martes',
                'active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        DB::table('horarios')->updateOrInsert(
            [
                'dia' => 'Miercoles',
                'active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('horarios')->updateOrInsert(

            [
                'dia' => 'Jueves',
                'active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        DB::table('horarios')->updateOrInsert(
            [
                'dia' => 'Viernes',
                'active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        DB::table('horarios')->updateOrInsert([
            'dia' => 'Sabado',
            'active' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('horarios')->updateOrInsert([

            'dia' => 'Domingo',
            'active' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
