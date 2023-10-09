<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicaciones extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'tipo_publicacion_id',
        'titulo',
        'fecha_creacion',
        'descripcion',
        'user_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
