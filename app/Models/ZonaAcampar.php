<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuninate\Database\Eloquent\Relations\BelongsTo;
class ZonaAcampar extends Model
{
    use HasFactory;
    protected $table = 'zona_acampars';
    protected $fillable = [
        'zona_id',
        'lote',
        'area_comun'
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
