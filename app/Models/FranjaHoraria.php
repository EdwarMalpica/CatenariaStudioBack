<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranjaHoraria extends Model
{
    use HasFactory;
    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'horario_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function dia(){
        return $this->belongsTo(Horario::class,'horario_id', 'id');
    }
}
