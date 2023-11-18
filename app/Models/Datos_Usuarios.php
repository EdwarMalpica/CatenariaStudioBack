<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Datos_Usuarios extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'datos_usuarios';
    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'numero_telefonico',
        'user_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
