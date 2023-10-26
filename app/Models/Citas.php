<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citas extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'fecha_cita',
        'mensaje',
        'user_id',
        'estado_cita_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function estado(){
        return $this->belongsTo(EstadoCita::class, 'estado_cita_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
