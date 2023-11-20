<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Logs extends Model
{
    protected $table = 'tipo_logs';
    use HasFactory;
    protected $filliable = [
        'nombre'
    ];
    public function logs()
    {
        return $this->hasMany(Logs::class, 'tipo_log_id');
    }

}
