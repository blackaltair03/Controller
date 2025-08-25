<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brazalete extends Models
{
    use HasFactory;

    protected $fillable =[
        'qr_code',
        'fecha_in',
        'fecha_out',
        'estatus_id',
        'contador_reingresos',
    ];

    protected $casts = [
        'fecha_in' => 'datetime',
        'fecha_out' => 'datetime',
    ];

    public function estatus()
    {
        return $this->belongsTo(Estatus::class);
    }
}