<?php

namespace App\Livewire\Sorteo;

use App\Models\Sorteo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $sorteoId;
    public $nombreSorteo;
    public $fechaSorteo;

    public $searchNombre = '';
    public $fechaInicio = '';
    public $fechaFin = '';

    protected $rules = [
        'nombreSorteo' => 'required|string|max:255',
        'fechaSorteo' => 'required|date',
    ];
    
    public function updated($property)
    {
        if (in_array($property, ['searchNombre', 'fechaInicio', 'fechaFin'])) {
            $this->resetPage();
        }
    }
    
    public function edit($id)
    {
        $sorteo = Sorteo::findOrFail($id);
        $this->sorteoId = $sorteo->id;
        $this->nombreSorteo = $sorteo->nombreSorteo;
        $this->fechaSorteo = \Carbon\Carbon::parse($sorteo->fechaSorteo)->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->validate();

        Sorteo::updateOrCreate(
            ['id' => $this->sorteoId],
            [
                'nombreSorteo' => $this->nombreSorteo,
                'fechaSorteo' => $this->fechaSorteo,
            ]
        );

        session()->flash('message', 'Sorteo guardado exitosamente.');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->sorteoId = null;
        $this->nombreSorteo = '';
        $this->fechaSorteo = '';
    }

    public function render()
    {
        $sorteos = Sorteo::withCount('compras')
        ->when($this->searchNombre, fn($query) =>
            $query->where('nombreSorteo', 'like', '%' . $this->searchNombre . '%')
        )
        ->when($this->fechaInicio && $this->fechaFin, fn($query) =>
            $query->whereBetween('fechaSorteo', [$this->fechaInicio, $this->fechaFin])
        )
        ->orderBy('created_at', 'desc')
        ->paginate(12);
        
        return view('livewire.sorteo.index', [
            'sorteos' => $sorteos
        ]);
    }
}
