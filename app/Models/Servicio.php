<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Servicio extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'servicios';
    protected $fillable = ['codigo', 'nombre', 'descripcion'];
}
