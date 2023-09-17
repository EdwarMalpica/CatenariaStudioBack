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
        DB::table('tipo_publicacioness')->insert(
            [
                'nombre' => 'articulo'
            ],
            [
                'nombre' => 'proyecto'
            ]
         );
    }
}
