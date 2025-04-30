<?php

namespace App\Livewire\Sorteo;

use App\Models\Sorteo;
use Livewire\Component;

class Index extends Component
{
    public $sorteoId;
    public $nombreSorteo;
    public $fechaSorteo;

    protected $rules = [
        'nombreSorteo' => 'required|string|max:255',
        'fechaSorteo' => 'required|date',
    ];
    
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
        $sorteos = Sorteo::all();
        
        return view('livewire.sorteo.index', [
            'sorteos' => $sorteos
        ]);
    }
}
