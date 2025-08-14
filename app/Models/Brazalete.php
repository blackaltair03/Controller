<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brazalete extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code',
        'fecha_in',
        'fecha_out',
        'estatus_id',
        'contador_reingresos'
    ];

    protected $casts = [
        'fecha_in' => 'datetime',
        'fecha_out' => 'datetime',
    ];
    public function estatuses()
    {
        return $this->belongsTo(Estatus::class);
    }
}
