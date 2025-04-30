<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $fillable = [
        'nombreSorteo',
        'fechaSorteo',
        'numeroGanador',
        'estadoSorteo'
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'sorteoId');
    }
}
