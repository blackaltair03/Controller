<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estatus extends Model
{
    use HasFactory;

    public $timestamps = false; # Se deshabilita la gestion automatica de timestamps

    protected $table = 'estatus'; # especiifcacion de la tabla estatus

    protected $fillable = ['codigo', 'nombre', 'descripcion'];

}
