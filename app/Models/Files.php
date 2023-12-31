<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nombre',
        'path',
        'formato',
        'publicacion_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function publicacion(){
        return $this->belongsTo(Publicaciones::class, 'publicacion_id');
    }
}
