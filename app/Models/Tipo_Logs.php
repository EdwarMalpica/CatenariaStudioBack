<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Logs extends Model
{
    use HasFactory;
    protected $filliable = [
        'nombre'
    ];
    public function logs()
    {
        return $this->hasMany(Logs::class);
    }

}
