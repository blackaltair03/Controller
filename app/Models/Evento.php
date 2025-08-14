<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'eventos';
    protected $fillable = ['codigo', 'duracion', 'descripcion'];
}
