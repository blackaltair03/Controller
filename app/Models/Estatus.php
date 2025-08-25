<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estatus extends Model
{
    use HasFactory;

    protected $table = 'estatuses';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
    ];

    public function brazaletes()
    {
        return $this->hasMany(Brazalete::class);
    }

}
