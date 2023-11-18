<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'login',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'registro',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'visita_proyecto',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'visita_articulo',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'cita_agendada',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'visita_pagina',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'bd',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_logs')->updateOrInsert(
            [
                'nombre' => 'otro',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
    }
}
