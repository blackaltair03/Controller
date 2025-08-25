<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ZonaHotel extends Model
{
    use HasFactory;

    protected $table = 'zona_hotels';
    protected $fillable = [
        'zona_id',
        'habitacion',
        'piso',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
