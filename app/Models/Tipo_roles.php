<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];
}
