<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'dia',
        'active'
    ];
    public function franjas(){
        return $this->hasMany(FranjaHoraria::class, 'horario_id');
    }
}
