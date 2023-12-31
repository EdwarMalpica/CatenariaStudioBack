<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $fillable  = [
        'tipo_log_id',
        'descripcion',
        'ip'
    ];

    public function tipo_logs()
    {
        return $this->belongsTo(Tipo_Logs::class);
    }
}
