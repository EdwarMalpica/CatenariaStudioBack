<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_publicacion_id',
        'titulo',
        'fecha_creacion',
        'descripcion',
        'user_id'
    ];
}
