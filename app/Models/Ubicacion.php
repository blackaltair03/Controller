<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }
}
