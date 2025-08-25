<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Zona extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'descripcion',
    ];

    public function zonaAcampar(): HasOne
        {
            return $this->hasOne(ZonaAcampar::class);
        }
    public function zonaHotel(): HasOne
    {
        return $this->zonaHotel(ZonaHotel::class);
    }
    
    public function zonaGeneral():HasOne 
    {
        return $this->zonaGeneral(ZonaGeneral::class);
    }

    
}
