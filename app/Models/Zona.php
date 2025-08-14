<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Zona extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['codigo', 'nombre', 'tipo', 'descripcion'];

    public function zonaGeneral()
    {
        return $this->hasOne(ZonaGeneral::class); #relacion con datos iguales en zona
    }

    public function zonaHotel()
    {
        return $this->hasOne(ZonaHotel::class);
    }

    public function zonaAcampar()
    {
        return $this->hasOne(ZonaAcampar::class);
    }
}
