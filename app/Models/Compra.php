<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compra extends Model
{
    protected $fillable = [
        'sorteoId', 
        'userId', 
        'numeroCompra'
    ];

    public function sorteo(): BelongsTo
    {
        return $this->belongsTo(Sorteo::class, 'sorteoId');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
