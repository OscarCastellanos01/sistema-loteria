<?php

namespace App\Livewire\Compra;

use App\Models\Compra;
use App\Models\Sorteo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $sorteo;
    public $numeroCompra;
    public bool $sorteoActivo = true;
    public string $mensaje = '';

    protected $rules = [
        'numeroCompra' => 'required|integer|min:1|max:100',
    ];

    public function mount(Sorteo $sorteo)
    {
        $this->sorteo = $sorteo;
    }

    #[On('finalizarSorteo')]
    public function desactivarSorteo()
    {
        $this->sorteoActivo = false;
    }

    public function setNumero($numero)
    {
        $this->numeroCompra = $numero;
    }

    public function comprar()
    {
        if (!$this->sorteoActivo) {
            session()->flash('error', 'El sorteo ha finalizado. No puedes comprar más números.');
            return;
        }

        $this->validate();

        // Verificar si el número ya ha sido comprado
        $existe = Compra::where('sorteoId', $this->sorteo->id)
                        ->where('numeroCompra', $this->numeroCompra)
                        ->exists();

        if ($existe) {
            session()->flash('error', 'Este número ya ha sido comprado.');
            return;
        }

        // Crear la compra
        Compra::create([
            'sorteoId' => $this->sorteo->id,
            'userId' => Auth::id(),
            'numeroCompra' => $this->numeroCompra,
        ]);

        session()->flash('message', 'Número comprado exitosamente.');
        $this->reset('numeroCompra');
    }

    public function seleccionarGanador($sorteoId)
    {
        $sorteo = Sorteo::with('compras')->findOrFail($sorteoId);

        if ($sorteo->numeroGanador) {
            session()->flash('message', 'Este sorteo ya tiene un ganador.');
            return;
        }

        if ($sorteo->compras->isEmpty()) {
            session()->flash('message', 'No hay números comprados en este sorteo.');
            return;
        }

        $ganador = $sorteo->compras->random();

        $sorteo->update([
            'numeroGanador' => $ganador->numeroCompra,
            'estadoSorteo' => false
        ]);

        $this->dispatch('refresh');

        $this->mensaje = '🎉 Ganador seleccionado: número ' . $ganador->numeroCompra . ' - ' . $sorteo->compras->first()->user->name;
    }
    
    #[On('refresh')]
    public function refreshComponent()
    {
        $this->sorteo = $this->sorteo->fresh();
    }

    public function render()
    {
        $numerosComprados = Compra::where('sorteoId', $this->sorteo->id)
        ->pluck('numeroCompra')
        ->toArray();

        $this->sorteoActivo = now()->lessThan($this->sorteo->fechaSorteo);

        
        return view('livewire.compra.index', [
            'numerosComprados' => $numerosComprados,
        ]);
    }
}
