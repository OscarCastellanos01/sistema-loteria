<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSorteoRequest;
use App\Models\Sorteo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SorteoController extends Controller
{
    public function index()
    {
        return view('sorteos.index');
    }
}
