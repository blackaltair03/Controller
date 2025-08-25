<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicacions';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];
}
