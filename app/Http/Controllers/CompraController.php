<?php

namespace App\Http\Controllers;

use App\Models\Sorteo;

class CompraController extends Controller
{
    public function index(Sorteo $sorteo)
    {
        return view('Compra.index', [
            'sorteo' => $sorteo
        ]);
    }
}
