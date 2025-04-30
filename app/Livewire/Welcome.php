<?php

namespace App\Livewire;

use App\Models\Sorteo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Welcome extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $searchNombre = '';
    public $fechaInicio = '';
    public $fechaFin = '';

    public function updated($property)
    {
        if (in_array($property, ['searchNombre', 'fechaInicio', 'fechaFin'])) {
            $this->resetPage();
        }
    }
    
    public function render()
    {
        $sorteos = Sorteo::withCount('compras')
        ->where('estadoSorteo', true)
        ->when($this->searchNombre, fn($query) =>
            $query->where('nombreSorteo', 'like', '%' . $this->searchNombre . '%')
        )
        ->when($this->fechaInicio && $this->fechaFin, fn($query) =>
            $query->whereBetween('fechaSorteo', [$this->fechaInicio, $this->fechaFin])
        )
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        return view('livewire.welcome', [
            'sorteos' => $sorteos
        ]);
    }
}
