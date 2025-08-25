<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZonaGeneral extends Model
{
    use HasFactory;

    protected $table = 'zona_general';
    protected $fillable = [
        'zona_id',
        'area',
        'capacidad',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
