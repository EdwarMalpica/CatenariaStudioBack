<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPublicacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('tipo_publicaciones')->updateOrInsert(
            [
                'nombre' => 'articulo',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        DB::table('tipo_publicaciones')->updateOrInsert(
            [
                'nombre' => 'proyecto',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

    }
}
