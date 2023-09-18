<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datos_Usuarios extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'numero_telefonico',
        'user_id'
    ];
}
