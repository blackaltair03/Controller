<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Zona extends Model
{
    use HasFactory;

    protected $table = 'zonas';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
    ];

    protected $casts = [
        'tipo' => 'string',
    ];

}

