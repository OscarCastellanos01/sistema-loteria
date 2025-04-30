<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $fillable = [
        'nombreSorteo',
        'fechaSorteo',
        'estadoSorteo'
    ];
}
